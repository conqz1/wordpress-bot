#!/usr/bin/env python3
"""
WordPress Site Bot — Add a new inner page to an existing site.

Usage:
    python add_page.py --page "About"
    python add_page.py --page "Contact" --url https://example.com/contact
    python add_page.py --page "Services" --theme-slug my-theme --status publish
"""
import argparse
import json
import os
import sys


_THEMES_DIR = os.path.join(os.path.dirname(__file__), "created-themes")
_IMAGE_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif", ".svg")


def main():
    parser = argparse.ArgumentParser(
        description="Design and publish a new inner page to an existing WordPress site."
    )
    parser.add_argument("--page",         required=True,  help='Page name, e.g. "About" or "Contact"')
    parser.add_argument("--theme-slug",   default=None,   help="Theme slug to match (auto-detects most recent if omitted)")
    parser.add_argument("--url",          default=None,   help="Optional reference URL to draw content from")
    parser.add_argument("--status",       default="draft", choices=["draft", "publish"], help="WordPress page status (default: draft)")
    parser.add_argument("--style",        default=None,   help='Optional style directive, e.g. "warm, minimal"')
    args = parser.parse_args()

    print(f"\n=== WordPress Site Bot — Add Page: {args.page} ===\n")

    # 1. Load theme metadata
    theme_meta, theme_css = _load_theme_context(args.theme_slug)
    print(f"[main] Using theme: {theme_meta['theme_name']} ({theme_meta['theme_slug']})")

    # 2. Optionally scrape reference URL
    screenshot_b64 = None
    html = ""
    url = args.url or ""

    if args.url:
        print(f"[main] Scraping reference URL: {args.url}")
        from scraper.page import scrape
        page = scrape(args.url)
        screenshot_b64 = page.screenshot_b64
        html = page.html

    # 3. Design the page with Claude
    from ai.page_designer import design_page
    result = design_page(
        page_name=args.page,
        theme_meta=theme_meta,
        theme_css=theme_css,
        screenshot_b64=screenshot_b64,
        html=html,
        url=url,
        style=args.style,
    )

    content_html = result.get("content_html", "")
    page_title   = result.get("page_title", args.page)
    images       = result.get("images", [])

    if not content_html:
        print("ERROR: Claude returned no content_html. Try running again.")
        sys.exit(1)

    # 4. Download and upload images, replace placeholders
    if images:
        content_html = _handle_images(content_html, images)

    # 5. Convert HTML sections to Gutenberg blocks
    from wordpress.blocks import html_to_blocks
    block_content = html_to_blocks(content_html)

    # 6. Push to WordPress
    from wordpress.api import create_page, get_edit_url
    wp_page = create_page(
        title=page_title,
        block_content=block_content,
        status=args.status,
    )

    page_id  = wp_page.get("id")
    page_url = wp_page.get("link", "")
    edit_url = get_edit_url(page_id)

    usage = result.get("_usage", {})

    print("\n" + "=" * 54)
    print(f"  Page:     {page_title}")
    print(f"  Status:   {args.status}")
    print(f"  URL:      {page_url}")
    print(f"  Edit:     {edit_url}")
    if usage:
        print(f"  Cost:     ${usage.get('cost_usd', 0):.4f}")
    print()
    if args.status == "draft":
        print("  → Review the page in WP Admin, then publish when ready.")
    print("  → Add this page to your nav: WP Admin → Appearance → Menus")
    print("=" * 54 + "\n")


def _load_theme_context(theme_slug: str | None) -> tuple[dict, str]:
    """
    Load theme-meta.json and style.css for the given slug.
    If slug is None, auto-detects the most recently modified theme.
    """
    if not os.path.isdir(_THEMES_DIR):
        print(f"ERROR: created-themes/ directory not found at {_THEMES_DIR}")
        print("Run main.py first to generate a theme.")
        sys.exit(1)

    if theme_slug:
        theme_dir = os.path.join(_THEMES_DIR, theme_slug)
    else:
        # Auto-detect: find the most recently modified theme-meta.json
        candidates = []
        for name in os.listdir(_THEMES_DIR):
            meta_path = os.path.join(_THEMES_DIR, name, "theme-meta.json")
            if os.path.isfile(meta_path):
                candidates.append((os.path.getmtime(meta_path), name))
        if not candidates:
            print("ERROR: No themes found in created-themes/. Run main.py first.")
            sys.exit(1)
        candidates.sort(reverse=True)
        theme_slug = candidates[0][1]
        theme_dir  = os.path.join(_THEMES_DIR, theme_slug)
        print(f"[main] Auto-detected theme: {theme_slug}")

    meta_path = os.path.join(theme_dir, "theme-meta.json")
    css_path  = os.path.join(theme_dir, "style.css")

    if not os.path.isfile(meta_path):
        print(f"ERROR: theme-meta.json not found in {theme_dir}")
        print("Re-run main.py to regenerate the theme (adds metadata file).")
        sys.exit(1)

    with open(meta_path, encoding="utf-8") as f:
        theme_meta = json.load(f)

    theme_css = ""
    if os.path.isfile(css_path):
        with open(css_path, encoding="utf-8") as f:
            theme_css = f.read()

    return theme_meta, theme_css


def _handle_images(content_html: str, images: list) -> str:
    """
    Download each image and upload it to the WordPress Media Library.
    Replace __IMG_placeholder__ markers with the uploaded media URLs.
    Falls back to the original URL if upload fails.
    """
    import requests as _requests
    from wordpress.api import upload_media

    _HEADERS = {
        "User-Agent": (
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
            "AppleWebKit/537.36 (KHTML, like Gecko) "
            "Chrome/124.0.0.0 Safari/537.36"
        )
    }

    for img in images:
        placeholder_id = img.get("placeholder_id", "")
        filename       = img.get("filename", "")
        original_url   = img.get("original_url", "")

        if not all([placeholder_id, filename, original_url]):
            continue

        ext = os.path.splitext(filename)[1].lower()
        if ext not in _IMAGE_EXTS:
            continue

        mime_map = {
            ".jpg": "image/jpeg", ".jpeg": "image/jpeg",
            ".png": "image/png",  ".webp": "image/webp",
            ".gif": "image/gif",  ".svg":  "image/svg+xml",
        }
        mime_type = mime_map.get(ext, "image/jpeg")
        marker    = f"__IMG_{placeholder_id}__"

        try:
            resp = _requests.get(original_url, headers=_HEADERS, timeout=20, stream=True)
            resp.raise_for_status()
            data = b"".join(resp.iter_content(chunk_size=8192))
            media = upload_media(filename, data, mime_type)
            content_html = content_html.replace(marker, media["source_url"])
        except Exception as e:
            print(f"[main] WARNING: Could not upload {filename}: {e} — using original URL")
            content_html = content_html.replace(marker, original_url)

    return content_html


if __name__ == "__main__":
    main()
