#!/usr/bin/env python3
"""
WordPress Site Bot — Entry point.

Usage:
    python main.py --url https://example.com
    python main.py --image ~/Desktop/client-mockup.jpg
    python main.py --url https://example.com --output ~/Desktop
"""
import argparse
import os
import sys


def main():
    parser = argparse.ArgumentParser(
        description="Generate an installable WordPress theme from a URL or a local image mockup."
    )
    source = parser.add_mutually_exclusive_group(required=True)
    source.add_argument("--url", default=None, help="URL of the site to analyze")
    source.add_argument(
        "--image",
        default=None,
        help="Path to a local image file (e.g. photo of a paper design mockup)",
    )
    parser.add_argument(
        "--output",
        default="created-themes",
        help="Directory to save the theme .zip file (default: created-themes/)",
    )
    parser.add_argument(
        "--style",
        default=None,
        help='Optional design style directive, e.g. "luxury, dark, editorial" or "playful, colorful, Gen-Z"',
    )
    args = parser.parse_args()

    output_dir = os.path.expanduser(args.output)
    os.makedirs(output_dir, exist_ok=True)

    print("\n=== WordPress Site Bot ===\n")

    if args.url:
        url = args.url.strip()
        if not url.startswith("http"):
            print(f"ERROR: URL must start with http/https — got: {url}")
            sys.exit(1)

        # 1a. Scrape URL
        from scraper.page import scrape
        page = scrape(url)
        screenshot_b64 = page.screenshot_b64
        html = page.html
        source_label = url

    else:
        # 1b. Load local image (paper mockup / hand-drawn design)
        image_path = os.path.expanduser(args.image)
        if not os.path.exists(image_path):
            print(f"ERROR: Image file not found: {image_path}")
            sys.exit(1)

        print(f"[main] Loading image: {image_path}")
        from scraper.page import compress_image
        screenshot_b64 = compress_image(image_path)
        html = ""
        source_label = f"[Local image: {os.path.basename(image_path)}]"

    # 2. Analyze with Claude Vision → theme design
    from ai.analyzer import analyze
    analysis = analyze(screenshot_b64, html, source_label, style=args.style)

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
