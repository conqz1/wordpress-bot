"""
Downloads images from their original URLs and uploads them to the
WordPress media library via the REST API.
Returns a mapping of placeholder_id → {url, id} for use in block content replacement.
"""
import mimetypes
import os
import re
import tempfile
from urllib.parse import urlparse

import requests

import config

_AUTH = (config.WP_USERNAME, config.WP_APP_PASSWORD)
_MEDIA_ENDPOINT = f"{config.WP_SITE_URL}/wp-json/wp/v2/media"

_HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/124.0.0.0 Safari/537.36"
    )
}


def upload_images(images: list[dict]) -> dict[str, dict]:
    """
    images: [{"original_url": "...", "placeholder_id": "..."}]
    Returns: {"placeholder_id": {"url": "https://...", "id": 123}}
    """
    mapping = {}
    for img in images:
        placeholder_id = img["placeholder_id"]
        original_url = img["original_url"]
        try:
            wp_url, wp_id = _download_and_upload(original_url)
            mapping[placeholder_id] = {"url": wp_url, "id": wp_id}
            print(f"[media] Uploaded {placeholder_id}: {wp_url} (id={wp_id})")
        except Exception as e:
            print(f"[media] WARNING: Could not upload {original_url}: {e}")
            # Fall back to original URL with id=0
            mapping[placeholder_id] = {"url": original_url, "id": 0}
    return mapping


def replace_image_placeholders(block_content: str, mapping: dict[str, dict]) -> str:
    """
    Replace all __IMG_<placeholder_id>__ strings in the Gutenberg block markup
    with the real WordPress media URL.
    """
    for placeholder_id, media in mapping.items():
        block_content = block_content.replace(f"__IMG_{placeholder_id}__", media["url"])
    return block_content


def _download_and_upload(url: str) -> tuple[str, int]:
    """Download image from *url*, upload to WP media library, return (wp_url, attachment_id)."""
    resp = requests.get(url, headers=_HEADERS, timeout=20, stream=True)
    resp.raise_for_status()

    content_type = resp.headers.get("Content-Type", "image/jpeg").split(";")[0].strip()
    ext = mimetypes.guess_extension(content_type) or ".jpg"
    if ext == ".jpe":
        ext = ".jpg"

    filename = _url_to_filename(url, ext)

    with tempfile.NamedTemporaryFile(suffix=ext, delete=False) as tmp:
        for chunk in resp.iter_content(chunk_size=8192):
            tmp.write(chunk)
        tmp_path = tmp.name

    try:
        with open(tmp_path, "rb") as f:
            upload_resp = requests.post(
                _MEDIA_ENDPOINT,
                auth=_AUTH,
                headers={
                    "Content-Disposition": f'attachment; filename="{filename}"',
                    "User-Agent": _HEADERS["User-Agent"],
                },
                files={"file": (filename, f, content_type)},
                timeout=30,
            )
        upload_resp.raise_for_status()
        data = upload_resp.json()
        return data["source_url"], data["id"]
    finally:
        os.unlink(tmp_path)


def _url_to_filename(url: str, fallback_ext: str) -> str:
    path = urlparse(url).path
    name = os.path.basename(path) or "image"
    name = re.sub(r"[?&#].*$", "", name)
    if "." not in name:
        name += fallback_ext
    return name
