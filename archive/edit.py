#!/usr/bin/env python3
"""
WordPress Theme Editor — chat with Claude to make surgical edits to a generated theme.

Usage:
    python3 edit.py --theme league-electric-theme
    python3 edit.py --theme created-themes/league-electric-theme
"""

import argparse
import json
import re
import sys
from pathlib import Path

import anthropic

import config
from theme.builder import rezip_theme

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

_THEME_FILES = [
    "style.css",
    "functions.php",
    "header.php",
    "footer.php",
    "front-page.php",
    "page.php",
    "index.php",
]

_SYSTEM_PROMPT = """You are a WordPress theme editor. You make precise, surgical edits to WordPress theme files.

Theme file roles:
- style.css       — Theme header comment + CSS custom properties (--color-primary etc.) + global CSS
- functions.php   — WordPress theme setup (add_theme_support, wp_enqueue_style)
- header.php      — Top bar + navigation — rendered on EVERY page via get_header()
- footer.php      — Site footer — rendered on EVERY page via get_footer()
- front-page.php  — Homepage content only (hero, services, CTA, etc.)
- page.php        — Inner pages template (every page except the front page)
- index.php       — Fallback template

When the user asks for a change, respond with ONLY a valid JSON object — no markdown fences, no explanation:
{
  "edits": [
    {
      "file": "style.css",
      "old": "exact existing substring to replace",
      "new": "replacement string"
    }
  ],
  "summary": "One-line description of what was changed"
}

RULES:
- "old" MUST be an exact verbatim substring of the current file — copy it character-for-character
- Make the minimum change needed — don't rewrite anything beyond what's requested
- To change a brand color: edit the CSS custom property in style.css (e.g. --color-primary: #8B2E1A)
- If a change touches multiple files, include multiple objects in the "edits" array
- Never include <html>, <head>, or <body> wrapper tags in edits to header.php/footer.php
- If no change is needed, return: {"edits": [], "summary": "No change needed — [reason]"}
- Return ONLY the JSON — nothing before or after it
"""


def _resolve_theme_dir(theme_arg: str) -> Path:
    """Find the theme folder from a name or path."""
    p = Path(theme_arg)
    if p.is_dir():
        return p.resolve()
    candidate = Path("created-themes") / theme_arg
    if candidate.is_dir():
        return candidate.resolve()
    raise FileNotFoundError(
        f"Theme folder '{theme_arg}' not found.\n"
        f"Checked: {p} and {candidate}\n"
        f"Available themes: {_list_themes()}"
    )


def _list_themes() -> str:
    themes_dir = Path("created-themes")
    if not themes_dir.exists():
        return "(created-themes/ folder not found)"
    folders = [f.name for f in themes_dir.iterdir() if f.is_dir()]
    return ", ".join(folders) if folders else "(none)"


def _load_files(theme_dir: Path) -> dict:
    """Load all editable theme files into {filename: content}."""
    files = {}
    for name in _THEME_FILES:
        path = theme_dir / name
        if path.exists():
            files[name] = path.read_text(encoding="utf-8")
    return files


def _save_file(theme_dir: Path, filename: str, content: str):
    (theme_dir / filename).write_text(content, encoding="utf-8")


def _apply_edits(theme_dir: Path, files: dict, edits: list) -> tuple[set, list]:
    """
    Apply edits in-place. Returns (changed_files, warnings).
    """
    changed = set()
    warnings = []
    for edit in edits:
        fname = edit.get("file", "")
        old = edit.get("old", "")
        new = edit.get("new", "")
        if fname not in files:
            warnings.append(f"'{fname}' not found in theme")
            continue
        if old not in files[fname]:
            warnings.append(f"String not found in {fname} — skipping that edit")
            continue
        files[fname] = files[fname].replace(old, new, 1)
        _save_file(theme_dir, fname, files[fname])
        changed.add(fname)
    return changed, warnings


def _build_context(files: dict) -> str:
    parts = ["Current theme file contents:\n"]
    for name, content in files.items():
        parts.append(f"=== {name} ===\n{content}\n")
    return "\n".join(parts)


def _call_claude(history: list, files: dict, user_message: str) -> dict:
    context = _build_context(files)
    messages = list(history) + [
        {
            "role": "user",
            "content": f"{context}\n\nEdit request: {user_message}",
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
        return {"edits": [], "summary": raw}


def main():
    parser = argparse.ArgumentParser(
        description="Chat with Claude to edit a WordPress theme"
    )
    parser.add_argument(
        "--theme",
        required=True,
        help="Theme folder name (inside created-themes/) or full path",
    )
    args = parser.parse_args()

    try:
        theme_dir = _resolve_theme_dir(args.theme)
    except FileNotFoundError as e:
        print(f"Error: {e}")
        sys.exit(1)

    files = _load_files(theme_dir)
    if not files:
        print(f"Error: No theme files found in '{theme_dir}'.")
        sys.exit(1)

    print(f"\n=== WordPress Theme Editor ===")
    print(f"Theme : {theme_dir.name}")
    print(f"Files : {', '.join(files.keys())}")
    print(f"\nDescribe your changes below. Type 'exit' to quit.\n")

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

        print("Claude: ", end="", flush=True)

        try:
            result = _call_claude(history, files, user_input)
        except ValueError as e:
            print(f"Error calling Claude: {e}")
            continue

        edits = result.get("edits", [])
        summary = result.get("summary", "")

        if not edits:
            print(summary or "No changes made.")
        else:
            changed, warnings = _apply_edits(theme_dir, files, edits)
            for w in warnings:
                print(f"  ⚠  {w}")
            if changed:
                zip_path = rezip_theme(str(theme_dir))
                zp = Path(zip_path)
                size_kb = zp.stat().st_size // 1024
                import datetime
                updated = datetime.datetime.now().strftime("%H:%M:%S")
                print(summary)
                print(f"  ✓  Edited   : {', '.join(sorted(changed))}")
                print(f"  ✓  Zip ready: {zp.name}  ({size_kb} KB, updated {updated})")
            else:
                print("No files were changed.")

        # Keep conversation history (without bulky file context)
        history.append({"role": "user", "content": user_input})
        history.append({"role": "assistant", "content": json.dumps(result)})

    zip_path = theme_dir.parent / f"{theme_dir.name}.zip"
    print(f"\nDone.")
    print(f"Theme folder : {theme_dir}")
    print(f"Final zip    : {zip_path}")


if __name__ == "__main__":
    main()
