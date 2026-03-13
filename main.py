#!/usr/bin/env python3
"""
WordPress Site Bot — Entry point.

Usage:
    python main.py --url https://example.com
    python main.py --url https://example.com --status publish
"""
import argparse
import sys


def main():
    parser = argparse.ArgumentParser(
        description="Scrape a URL and recreate it as a Gutenberg page in WordPress."
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

    print("\n=== WordPress Site Bot ===\n")

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
    _IMAGE_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif", ".svg", ".bmp", ".ico", ".avif")
    images = [
        img for img in analysis.get("images", [])
        if any(img.get("original_url", "").lower().split("?")[0].endswith(ext) for ext in _IMAGE_EXTS)
    ]
    block_content = analysis.get("block_content", "")
    if images:
        print(f"[main] Uploading {len(images)} image(s) to WordPress media library...")
        mapping = upload_images(images)
        block_content = replace_image_placeholders(block_content, mapping)

    # 5. Create page via WP REST API
    from wordpress.api import create_page, get_edit_url
    page_title = analysis.get("page_title") or page.title
    wp_page = create_page(
        title=page_title,
        block_content=block_content,
        status=args.status,
    )

    edit_url = get_edit_url(wp_page["id"])
    live_url = wp_page.get("link", "")

    print("\n" + "=" * 50)
    print(f"  Page created: {page_title}")
    print(f"  Status:       {args.status}")
    print(f"  Live URL:     {live_url}")
    print(f"  Edit in WP:   {edit_url}")
    print("=" * 50 + "\n")


if __name__ == "__main__":
    main()
