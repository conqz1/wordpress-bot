"""
WordPress REST API client.
Creates pages using the native Gutenberg block editor (post_content).
No mu-plugins or special setup required.
"""
import requests

import config

_AUTH = (config.WP_USERNAME, config.WP_APP_PASSWORD)
_PAGES_ENDPOINT = f"{config.WP_SITE_URL}/wp-json/wp/v2/pages"
_HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/124.0.0.0 Safari/537.36"
    ),
    "Accept": "application/json",
}


def create_page(
    title: str,
    block_content: str,
    status: str = "draft",
) -> dict:
    """
    Create a new WordPress page with Gutenberg block content.
    Returns the full WP REST API page object (includes 'link' and 'id').
    """
    payload = {
        "title": title,
        "status": status,
        "content": block_content,
    }

    print(f"[wordpress] Creating page '{title}' as {status}...")
    resp = requests.post(_PAGES_ENDPOINT, auth=_AUTH, headers=_HEADERS, json=payload, timeout=30)

    if resp.status_code not in (200, 201):
        _raise_api_error(resp)

    page = resp.json()
    print(f"[wordpress] Page created: {page.get('link')} (ID: {page.get('id')})")
    return page


def get_edit_url(page_id: int) -> str:
    """Return the WordPress block editor URL for the given page."""
    return f"{config.WP_SITE_URL}/wp-admin/post.php?post={page_id}&action=edit"


def _raise_api_error(resp: requests.Response) -> None:
    try:
        body = resp.json()
        msg = body.get("message", resp.text)
    except Exception:
        msg = resp.text
    raise RuntimeError(
        f"WordPress API error {resp.status_code}: {msg}"
    )
