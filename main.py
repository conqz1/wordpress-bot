#!/usr/bin/env python3
"""
WordPress Site Bot — Entry point.

Usage:
    python main.py --url https://example.com
    python main.py --url https://example.com --output ~/Desktop
"""
import argparse
import os
import sys


def main():
    parser = argparse.ArgumentParser(
        description="Scrape a URL and generate an installable WordPress theme inspired by it."
    )
    parser.add_argument("--url", required=True, help="URL of the site to analyze")
    parser.add_argument(
        "--output",
        default="created-themes",
        help="Directory to save the theme .zip file (default: created-themes/)",
    )
    args = parser.parse_args()

    url = args.url.strip()
    if not url.startswith("http"):
        print(f"ERROR: URL must start with http/https — got: {url}")
        sys.exit(1)

    output_dir = os.path.expanduser(args.output)
    os.makedirs(output_dir, exist_ok=True)

    print("\n=== WordPress Site Bot ===\n")

    # 1. Scrape
    from scraper.page import scrape
    page = scrape(url)

    # 2. Analyze with Claude Vision → theme design
    from ai.analyzer import analyze
    analysis = analyze(page.screenshot_b64, page.html, url)

    # 3. Show approval UI
    from ui.server import run_approval_ui
    decision = run_approval_ui(page, analysis)

    if decision != "approve":
        print("\n[main] Skipped. No theme was created.")
        sys.exit(0)

    print("\n[main] Approved! Building theme...")

    # 4. Build theme zip (downloads images, generates PHP files, packages zip)
    from theme.builder import build_theme_zip
    zip_path = build_theme_zip(analysis, output_dir=output_dir)

    theme_name = analysis.get("theme_name", "Custom Theme")
    theme_slug = analysis.get("theme_slug", "custom-theme")

    print("\n" + "=" * 54)
    print(f"  Theme:    {theme_name}")
    print(f"  Slug:     {theme_slug}")
    print(f"  Saved to: {zip_path}")
    print()
    print("  To install:")
    print("  1. WP Admin → Appearance → Themes → Add New")
    print("  2. Upload Theme → select the .zip file")
    print("  3. Install → Activate")
    print("=" * 54 + "\n")


if __name__ == "__main__":
    main()
