"""
Downloads images from their original URLs and uploads them to the
WordPress media library via the REST API.
Returns a mapping of placeholder_id → {url, id} so Elementor can
render background images correctly (requires both fields).
"""
import json
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


def replace_image_placeholders(elementor_data: list, mapping: dict[str, dict]) -> list:
    """
    Walk the Elementor JSON and replace all __IMG_<placeholder_id>__ URL strings
    with the real WordPress media URL, then inject the attachment id into any
    image/background_image objects that contain that URL.
    """
    data_str = json.dumps(elementor_data)

    # Replace placeholder URL strings
    for placeholder_id, media in mapping.items():
        data_str = data_str.replace(f"__IMG_{placeholder_id}__", media["url"])

    data = json.loads(data_str)

    # Build a reverse lookup: url → id
    url_to_id = {m["url"]: m["id"] for m in mapping.values() if m["id"]}

    # Walk the tree and inject attachment ids
    _inject_ids(data, url_to_id)
    return data


def _inject_ids(elements: list, url_to_id: dict) -> None:
    """Recursively find image/background_image objects and set their id field."""
    for el in elements:
        settings = el.get("settings", {})

        # Widget image setting
        img = settings.get("image")
        if isinstance(img, dict) and img.get("url") in url_to_id:
            img["id"] = url_to_id[img["url"]]

        # Section background image
        bg = settings.get("background_image")
        if isinstance(bg, dict) and bg.get("url") in url_to_id:
            bg["id"] = url_to_id[bg["url"]]
            bg["source"] = "library"

        if el.get("elements"):
            _inject_ids(el["elements"], url_to_id)


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
                headers={"Content-Disposition": f'attachment; filename="{filename}"'},
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
