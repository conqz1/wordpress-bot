"""
Fetches a webpage: full-page screenshot + raw HTML.
Uses Playwright (headless Chromium).
"""
import base64
import io
import re
from dataclasses import dataclass, field
from urllib.parse import urljoin, urlparse

from PIL import Image
from playwright.sync_api import sync_playwright

import config

_MAX_IMAGE_BYTES = 4 * 1024 * 1024  # 4 MB — safely under the 5 MB API limit


def compress_image(path: str) -> str:
    """Return a base64 string of any image file, resized/compressed to stay under the API limit.
    Public alias so main.py can use it for user-provided mockup photos."""
    return _compress_screenshot(path)


def _compress_screenshot(path: str) -> str:
    """Return a base64 string of the screenshot, resized/compressed to stay under the API limit."""
    img = Image.open(path).convert("RGB")

    # Cap both dimensions to API limits (8000px max per side)
    max_width, max_height = 1280, 7000
    ratio = min(max_width / img.width, max_height / img.height, 1.0)
    if ratio < 1.0:
        img = img.resize((int(img.width * ratio), int(img.height * ratio)), Image.LANCZOS)

    # Try progressively lower JPEG quality until under the limit
    for quality in (85, 70, 55, 40):
        buf = io.BytesIO()
        img.save(buf, format="JPEG", quality=quality, optimize=True)
        if buf.tell() <= _MAX_IMAGE_BYTES:
            return base64.b64encode(buf.getvalue()).decode("utf-8")

    # Last resort: halve the image dimensions
    img = img.resize((img.width // 2, img.height // 2), Image.LANCZOS)
    buf = io.BytesIO()
    img.save(buf, format="JPEG", quality=40, optimize=True)
    return base64.b64encode(buf.getvalue()).decode("utf-8")


@dataclass
class ScrapedPage:
    url: str
    title: str
    html: str
    screenshot_b64: str          # base64-encoded JPEG (compressed)
    screenshot_path: str         # saved to disk
    image_urls: list[str] = field(default_factory=list)


def scrape(url: str, output_dir: str = "tmp") -> ScrapedPage:
    """Take a full-page screenshot and fetch HTML for *url*."""
    import os
    os.makedirs(output_dir, exist_ok=True)
    screenshot_path = os.path.join(output_dir, "screenshot.png")

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(
            viewport={
                "width": config.SCREENSHOT_WIDTH,
                "height": config.SCREENSHOT_HEIGHT,
            },
            user_agent=(
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
                "AppleWebKit/537.36 (KHTML, like Gecko) "
                "Chrome/124.0.0.0 Safari/537.36"
            ),
        )
        page = context.new_page()

        print(f"[scraper] Loading {url} ...")
        try:
            page.goto(url, wait_until="load", timeout=30_000)
        except Exception:
            # Some sites never fully settle — grab what loaded so far
            pass

        # Scroll to trigger lazy-load content
        page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
        page.wait_for_timeout(1500)
        page.evaluate("window.scrollTo(0, 0)")
        page.wait_for_timeout(500)

        title = page.title()
        html = page.content()

        page.screenshot(path=screenshot_path, full_page=True)

        browser.close()

    screenshot_b64 = _compress_screenshot(screenshot_path)

    image_urls = _extract_image_urls(html, url)

    print(f"[scraper] Done. Title: '{title}' | Images found: {len(image_urls)}")
    return ScrapedPage(
        url=url,
        title=title,
        html=html,
        screenshot_b64=screenshot_b64,
        screenshot_path=screenshot_path,
        image_urls=image_urls,
    )


def _extract_image_urls(html: str, base_url: str) -> list[str]:
    """Pull all <img src> and CSS background-image URLs from the HTML."""
    urls = set()

    # <img src="...">
    for src in re.findall(r'<img[^>]+src=["\']([^"\']+)["\']', html, re.IGNORECASE):
        urls.add(_absolute(src, base_url))

    # background-image: url(...)
    for src in re.findall(r'url\(["\']?([^"\')\s]+)["\']?\)', html, re.IGNORECASE):
        if not src.startswith("data:"):
            urls.add(_absolute(src, base_url))

    # Filter: only http/https, skip tiny icons / SVG data URIs
    return [u for u in urls if u.startswith("http") and not u.endswith(".svg")]


def _absolute(url: str, base: str) -> str:
    if url.startswith("//"):
        scheme = urlparse(base).scheme
        return f"{scheme}:{url}"
    return urljoin(base, url)
