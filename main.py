#!/usr/bin/env python3
"""
Elementor Bot — Entry point.

Usage:
    python main.py --url https://example.com
    python main.py --url https://example.com --status publish
"""
import argparse
import sys


def main():
    parser = argparse.ArgumentParser(
        description="Scrape a URL and recreate it as an Elementor page in WordPress."
    )
    parser.add_argument("--url", required=True, help="URL of the page to clone")
    parser.add_argument(
        "--status",
        choices=["draft", "publish"],
        default="draft",
        help="WordPress page status (default: draft)",
    )
    args = parser.parse_args()

    url = args.url.strip()
    if not url.startswith("http"):
        print(f"ERROR: URL must start with http/https — got: {url}")
        sys.exit(1)

    print("\n=== Elementor Bot ===\n")

    # 1. Scrape
    from scraper.page import scrape
    page = scrape(url)

    # 2. Analyze with Claude Vision
    from ai.analyzer import analyze
    analysis = analyze(page.screenshot_b64, page.html, url)

    # 3. Show approval UI
    from ui.server import run_approval_ui
    decision = run_approval_ui(page, analysis)

    if decision != "approve":
        print("\n[main] Page skipped. Nothing was created in WordPress.")
        sys.exit(0)

    print("\n[main] Approved! Processing images and creating page...")

    # 4. Download + upload images
    from wordpress.media import upload_images, replace_image_placeholders
    images = analysis.get("images", [])
    if images:
        print(f"[main] Uploading {len(images)} image(s) to WordPress media library...")
        mapping = upload_images(images)
        elementor_data = replace_image_placeholders(analysis["elementor_data"], mapping)
    else:
        elementor_data = analysis["elementor_data"]

    # 5. Create Elementor page via WP REST API
    from wordpress.api import create_elementor_page, get_edit_url
    page_title = analysis.get("page_title") or page.title
    wp_page = create_elementor_page(
        title=page_title,
        elementor_data=elementor_data,
        status=args.status,
    )

    edit_url = get_edit_url(wp_page["id"])
    live_url = wp_page.get("link", "")

    print("\n" + "=" * 50)
    print(f"  Page created: {page_title}")
    print(f"  Status:       {args.status}")
    print(f"  Live URL:     {live_url}")
    print(f"  Edit in Elementor: {edit_url}")
    print("=" * 50 + "\n")


if __name__ == "__main__":
    main()
