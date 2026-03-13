#!/usr/bin/env python3
"""
WordPress Site Bot — Page Builder.

Scrapes a URL, redesigns the page content with Claude Vision,
and creates it as a draft WordPress page via REST API.

Usage:
    python page.py --url https://example.com/about
"""
import argparse
import sys

_IMAGE_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif", ".svg", ".bmp", ".ico", ".avif")


def main():
    parser = argparse.ArgumentParser(
        description="Scrape a URL and create it as a draft WordPress page."
    )
    parser.add_argument("--url", required=True, help="URL of the page to analyze")
    args = parser.parse_args()

    url = args.url.strip()
    if not url.startswith("http"):
        print(f"ERROR: URL must start with http/https — got: {url}")
        sys.exit(1)

    print("\n=== WordPress Site Bot — Page Builder ===\n")

    # 1. Scrape
    from scraper.page import scrape
    page = scrape(url)

    # 2. Analyze with Claude Vision → page content design
    from ai.page_analyzer import analyze_page
    analysis = analyze_page(page.screenshot_b64, page.html, url)

    # 3. Show approval UI
    from ui.server import run_page_approval_ui
    decision = run_page_approval_ui(page, analysis)

    if decision != "approve":
        print("\n[main] Skipped. No page was created.")
        sys.exit(0)

    print("\n[main] Approved! Creating WordPress page...")

    # 4. Upload images to WP media library
    raw_images = analysis.get("images", [])
    images = [
        img for img in raw_images
        if any(img.get("original_url", "").lower().split("?")[0].endswith(ext) for ext in _IMAGE_EXTS)
    ]

    from wordpress.media import upload_images, replace_image_placeholders
    media_map = upload_images(images)

    # 5. Replace image placeholders with WP media URLs
    content_html = analysis.get("content_html", "")
    content_html = replace_image_placeholders(content_html, media_map)

    # 6. Create WordPress page as draft
    from wordpress.api import create_page
    page_title = analysis.get("page_title", page.title)
    wp_page = create_page(page_title, content_html, status="draft")

    wp_link = wp_page.get("link", "")
    wp_id = wp_page.get("id", "")

    print("\n" + "=" * 54)
    print(f"  Page:     {page_title}")
    print(f"  Status:   Draft (ID: {wp_id})")
    print(f"  Link:     {wp_link}")
    print()
    print("  To publish:")
    print("  1. WP Admin → Pages → find the draft")
    print("  2. Click Edit → Publish")
    print("=" * 54 + "\n")


if __name__ == "__main__":
    main()
