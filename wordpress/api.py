"""
WordPress REST API client.
Creates pages and sets Elementor data via the WP REST API.
Requires the mu-plugin (setup/elementor-rest-api.php) to be installed
so that _elementor_data is exposed via the REST API.
"""
import json

import requests

import config

_AUTH = (config.WP_USERNAME, config.WP_APP_PASSWORD)
_PAGES_ENDPOINT = f"{config.WP_SITE_URL}/wp-json/wp/v2/pages"


def create_elementor_page(
    title: str,
    elementor_data: list,
    status: str = "draft",
) -> dict:
    """
    Create a new WordPress page with Elementor content.
    Returns the full WP REST API page object (includes 'link' and 'id').
    """
    elementor_json = json.dumps(elementor_data)

    payload = {
        "title": title,
        "status": status,
        "meta": {
            "_elementor_data": elementor_json,
            "_elementor_edit_mode": "builder",
            "_elementor_template_type": "wp-page",
            "_elementor_version": "3.21.0",
        },
    }

    print(f"[wordpress] Creating page '{title}' as {status}...")
    resp = requests.post(_PAGES_ENDPOINT, auth=_AUTH, json=payload, timeout=30)

    if resp.status_code not in (200, 201):
        _raise_api_error(resp)

    page = resp.json()
    print(f"[wordpress] Page created: {page.get('link')} (ID: {page.get('id')})")
    return page


def get_edit_url(page_id: int) -> str:
    """Return the Elementor editor URL for the given page."""
    return f"{config.WP_SITE_URL}/wp-admin/post.php?post={page_id}&action=elementor"


def _raise_api_error(resp: requests.Response) -> None:
    try:
        body = resp.json()
        msg = body.get("message", resp.text)
    except Exception:
        msg = resp.text
    raise RuntimeError(
        f"WordPress API error {resp.status_code}: {msg}\n"
        "Tip: make sure the mu-plugin (setup/elementor-rest-api.php) is installed."
    )
