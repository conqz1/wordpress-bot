"""
WordPress REST API client.
Creates pages using the native Gutenberg block editor (post_content).
No mu-plugins or special setup required.
"""
import requests

import config

_AUTH = (config.WP_USERNAME, config.WP_APP_PASSWORD)
_PAGES_ENDPOINT = f"{config.WP_SITE_URL}/wp-json/wp/v2/pages"
_POSTS_ENDPOINT = f"{config.WP_SITE_URL}/wp-json/wp/v2/posts"
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


def create_post(
    title: str,
    content: str,
    status: str = "draft",
    excerpt: str = "",
    categories: list[int] = None,
    tags: list[int] = None,
    featured_media: int = 0,
) -> dict:
    """
    Create a new WordPress blog post.
    Returns the full WP REST API post object (includes 'link' and 'id').
    """
    payload: dict = {
        "title": title,
        "status": status,
        "content": content,
    }
    if excerpt:
        payload["excerpt"] = excerpt
    if categories:
        payload["categories"] = categories
    if tags:
        payload["tags"] = tags
    if featured_media:
        payload["featured_media"] = featured_media

    print(f"[wordpress] Creating post '{title}' as {status}...")
    resp = requests.post(_POSTS_ENDPOINT, auth=_AUTH, headers=_HEADERS, json=payload, timeout=30)

    if resp.status_code not in (200, 201):
        _raise_api_error(resp)

    post = resp.json()
    print(f"[wordpress] Post created: {post.get('link')} (ID: {post.get('id')})")
    return post


def upload_media(filename: str, data: bytes, mime_type: str = "image/jpeg") -> dict:
    """
    Upload a file to the WordPress Media Library.
    Returns the media object (includes 'source_url' and 'id').
    """
    headers = {
        **_HEADERS,
        "Content-Disposition": f'attachment; filename="{filename}"',
        "Content-Type": mime_type,
    }
    resp = requests.post(
        f"{config.WP_SITE_URL}/wp-json/wp/v2/media",
        auth=_AUTH,
        headers=headers,
        data=data,
        timeout=60,
    )
    if resp.status_code not in (200, 201):
        _raise_api_error(resp)
    media = resp.json()
    print(f"[wordpress] Uploaded media: {media.get('source_url')} (ID: {media.get('id')})")
    return media


def get_front_page_id() -> int:
    """Return the WordPress page ID set as the static front page (0 if not set)."""
    resp = requests.get(
        f"{config.WP_SITE_URL}/wp-json/wp/v2/settings",
        auth=_AUTH,
        headers=_HEADERS,
        timeout=15,
    )
    if resp.status_code not in (200, 201):
        _raise_api_error(resp)
    return resp.json().get("page_on_front", 0)


def get_page_by_id(page_id: int) -> dict:
    """Fetch a WordPress page by its ID. Returns full page object including raw content."""
    resp = requests.get(
        f"{_PAGES_ENDPOINT}/{page_id}",
        auth=_AUTH,
        headers=_HEADERS,
        params={"context": "edit"},
        timeout=15,
    )
    if resp.status_code not in (200, 201):
        _raise_api_error(resp)
    return resp.json()


def get_page_by_slug(slug: str) -> dict:
    """
    Fetch a WordPress page by its slug.
    Returns the full page object including raw content (requires auth).
    Raises RuntimeError if not found.
    """
    resp = requests.get(
        _PAGES_ENDPOINT,
        auth=_AUTH,
        headers=_HEADERS,
        params={"slug": slug, "context": "edit"},
        timeout=15,
    )
    if resp.status_code not in (200, 201):
        _raise_api_error(resp)
    pages = resp.json()
    if not pages:
        raise RuntimeError(f"No WordPress page found with slug '{slug}'.")
    return pages[0]


def update_page(page_id: int, content_html: str) -> dict:
    """
    Update a WordPress page's content.
    Returns the updated page object.
    """
    resp = requests.post(
        f"{_PAGES_ENDPOINT}/{page_id}",
        auth=_AUTH,
        headers=_HEADERS,
        json={"content": content_html},
        timeout=30,
    )
    if resp.status_code not in (200, 201):
        _raise_api_error(resp)
    return resp.json()


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
