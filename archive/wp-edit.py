#!/usr/bin/env python3
"""
WordPress Page Editor — chat with Claude to edit any live page on your WordPress site.

Claude sees a screenshot of the page + its raw HTML, makes surgical edits,
and pushes changes live via the REST API after each accepted request.

Usage:
    python3 wp-edit.py --url https://automai.ai/meet-the-team
"""

import argparse
import json
import os
import re
import sys
from urllib.parse import urlparse

import anthropic

import config
from scraper.page import scrape
from wordpress.api import get_page_by_slug, get_page_by_id, get_front_page_id, update_page
from wordpress.media import upload_local_file, _download_and_upload

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

_IMAGE_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif", ".svg", ".bmp", ".avif")

_SYSTEM_PROMPT = """You are a WordPress page editor. You make precise, surgical edits to a live WordPress page's HTML content.

The page content is raw HTML stored in WordPress as post_content — it may include:
- Custom HTML with inline styles and <section class="wp-fw"> full-width sections (built by a bot)
- WordPress Gutenberg block markup (<!-- wp:paragraph --> etc.)
- Or a mix of both

You will receive:
1. A screenshot of how the page currently looks in a browser
2. The current raw HTML content of the page

When the user asks for a change, respond with ONLY a valid JSON object — no markdown, no explanation:
{
  "edits": [
    {
      "old": "exact existing substring to replace",
      "new": "replacement string"
    }
  ],
  "summary": "One-line description of what was changed"
}

RULES:
- "old" MUST be a verbatim substring of the current HTML — copy it character-for-character
- Keep edits minimal — change only what the user asked for
- For text changes: replace just the text node, not the whole element
- For color changes: replace the exact hex value or CSS property value
- For image changes: replace only the src="..." attribute value
- For style changes: replace just the relevant CSS property+value (e.g. font-size:58px → font-size:72px)
- If a change requires multiple replacements (e.g. a color used in 3 places), include all of them
- If no change is needed, return: {"edits": [], "summary": "No change needed — [reason]"}
- Never add <html>, <head>, or <body> wrapper tags
- Return ONLY the JSON — nothing before or after
"""


def _slug_from_url(url: str) -> str:
    """Extract the last path segment as the slug."""
    path = urlparse(url).path.rstrip("/")
    return path.split("/")[-1] or ""


def _is_local_path(s: str) -> bool:
    """Return True if string looks like a local filesystem path."""
    s = s.strip()
    return s.startswith("/") or s.startswith("~/") or s.startswith("./") or s.startswith("../")


def _is_image_url(s: str) -> bool:
    """Return True if string looks like a direct image URL."""
    lower = s.lower().split("?")[0]
    return lower.startswith("http") and any(lower.endswith(ext) for ext in _IMAGE_EXTS)


def _maybe_upload_image(value: str) -> str:
    """
    If value is a local file path or a remote image URL, upload it to WP media
    and return the hosted WP URL. Otherwise return value unchanged.
    """
    value = value.strip()
    if _is_local_path(value):
        print(f"[media] Uploading local file: {value} ...")
        wp_url, wp_id = upload_local_file(value)
        print(f"[media] Uploaded → {wp_url} (id={wp_id})")
        return wp_url
    if _is_image_url(value):
        print(f"[media] Uploading image to WP media: {value} ...")
        try:
            wp_url, wp_id = _download_and_upload(value)
            print(f"[media] Uploaded → {wp_url} (id={wp_id})")
            return wp_url
        except Exception as e:
            print(f"[media] Upload failed ({e}) — using URL directly")
            return value
    return value


def _process_edits(edits: list, html: str) -> tuple[str, list, list]:
    """
    Apply edits to html. Returns (updated_html, applied_summaries, warnings).
    Automatically uploads images if a new value looks like a file path or image URL.
    """
    warnings = []
    applied = []

    for edit in edits:
        old = edit.get("old", "")
        new = edit.get("new", "")

        if not old:
            warnings.append("Skipped an edit with empty 'old' string")
            continue
        if old not in html:
            warnings.append(f"String not found in page HTML — skipping: {old[:80]!r}")
            continue

        # If the new value in an src attribute is a local path or image URL, upload it
        src_match = re.match(r'^src=["\'](.+)["\']$', new)
        if src_match:
            raw_src = src_match.group(1)
            if _is_local_path(raw_src) or _is_image_url(raw_src):
                hosted = _maybe_upload_image(raw_src)
                quote = new[4]  # preserve quote style
                new = f"src={quote}{hosted}{quote}"

        html = html.replace(old, new, 1)
        applied.append(old[:60])

    return html, applied, warnings


def _build_context(html: str) -> str:
    return f"Current page HTML:\n\n{html}"


def _call_claude(
    history: list,
    screenshot_b64: str,
    html: str,
    user_message: str,
) -> dict:
    context = _build_context(html)

    messages = list(history) + [
        {
            "role": "user",
            "content": [
                {
                    "type": "image",
                    "source": {
                        "type": "base64",
                        "media_type": "image/png",
                        "data": screenshot_b64,
                    },
                },
                {
                    "type": "text",
                    "text": f"{context}\n\nEdit request: {user_message}",
                },
            ],
        }
    ]

    raw_chunks = []
    with _client.messages.stream(
        model="claude-opus-4-6",
        max_tokens=4096,
        system=_SYSTEM_PROMPT,
        messages=messages,
    ) as stream:
        for text in stream.text_stream:
            raw_chunks.append(text)
            print(".", end="", flush=True)
    print()

    raw = "".join(raw_chunks).strip()
    raw = re.sub(r"^```[a-z]*\n?", "", raw, flags=re.MULTILINE)
    raw = re.sub(r"```$", "", raw.strip(), flags=re.MULTILINE).strip()

    try:
        return json.loads(raw)
    except json.JSONDecodeError:
        # Claude returned prose — wrap it so the caller can display it gracefully
        return {"edits": [], "summary": raw}


def _take_screenshot(url: str) -> str:
    """Scrape the URL and return base64 screenshot."""
    page = scrape(url)
    return page.screenshot_b64


def main():
    parser = argparse.ArgumentParser(description="Edit a live WordPress page via chat")
    parser.add_argument("--url", required=True, help="Full URL of the WordPress page to edit")
    args = parser.parse_args()

    url = args.url.rstrip("/")
    slug = _slug_from_url(url)

    # ── 1. Find the page on WordPress ─────────────────────────────────────────
    print(f"\n=== WordPress Page Editor ===")
    print(f"Finding page: {url}")
    try:
        if not slug:
            # Homepage — look up the static front page
            front_id = get_front_page_id()
            if not front_id:
                print("Error: No static front page is set in WordPress.")
                print("Go to WP Admin → Settings → Reading and set 'A static page' as the homepage.")
                sys.exit(1)
            wp_page = get_page_by_id(front_id)
        else:
            wp_page = get_page_by_slug(slug)
    except RuntimeError as e:
        print(f"Error: {e}")
        sys.exit(1)

    page_id = wp_page["id"]
    page_title = wp_page.get("title", {}).get("rendered", slug)
    current_html = wp_page.get("content", {}).get("raw", "")

    print(f"Found  : '{page_title}' (ID: {page_id})")
    print(f"Content: {len(current_html):,} characters")

    # ── 2. Take a screenshot of the live page ─────────────────────────────────
    print(f"Taking screenshot of live page...")
    screenshot_b64 = _take_screenshot(url)

    print(f"\nReady. Describe your changes below. Type 'exit' to quit.\n")

    history = []

    while True:
        try:
            user_input = input("You: ").strip()
        except (EOFError, KeyboardInterrupt):
            print("\nExiting.")
            break

        if not user_input:
            continue
        if user_input.lower() in ("exit", "quit", "q"):
            break

        # Refresh screenshot on demand
        if user_input.lower() in ("refresh", "screenshot", "refresh screenshot"):
            print("Taking fresh screenshot...")
            screenshot_b64 = _take_screenshot(url)
            print("Screenshot updated.")
            continue

        print("Claude: ", end="", flush=True)

        try:
            result = _call_claude(history, screenshot_b64, current_html, user_input)
        except ValueError as e:
            print(f"Error: {e}")
            continue

        edits = result.get("edits", [])
        summary = result.get("summary", "")

        if not edits:
            print(summary or "No changes made.")
            history.append({"role": "user", "content": user_input})
            history.append({"role": "assistant", "content": json.dumps(result)})
            continue

        # Apply edits locally
        updated_html, applied, warnings = _process_edits(edits, current_html)

        for w in warnings:
            print(f"  ⚠  {w}")

        if not applied:
            print("No changes could be applied — strings not found in page HTML.")
            history.append({"role": "user", "content": user_input})
            history.append({"role": "assistant", "content": json.dumps(result)})
            continue

        # Push to WordPress
        try:
            update_page(page_id, updated_html)
            current_html = updated_html
            print(summary)
            print(f"  ✓  {len(applied)} edit(s) applied and pushed live")
            print(f"  →  {url}")
        except RuntimeError as e:
            print(f"  ✗  WordPress API error: {e}")

        # Keep history compact (no screenshot or HTML in history)
        history.append({"role": "user", "content": user_input})
        history.append({"role": "assistant", "content": json.dumps(result)})

    print(f"\nDone. View page: {url}")
    print(f"WP Admin: {config.WP_SITE_URL}/wp-admin/post.php?post={page_id}&action=edit")


if __name__ == "__main__":
    main()
