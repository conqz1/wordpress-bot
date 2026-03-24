"""
Converts raw HTML (AI-generated page content) into WordPress Gutenberg block markup.

Each <section> element becomes its own <!-- wp:html --> block so the client
sees one labeled, editable block per section in the WP block editor — rather
than one giant opaque HTML blob.
"""
import re


def html_to_blocks(content_html: str) -> str:
    """
    Split HTML into Gutenberg wp:html blocks, one per <section>.
    A leading <style> block (if present) is placed in its own block first.
    Falls back to a single block if no <section> tags are found.
    """
    content_html = content_html.strip()

    # Extract a leading <style>...</style> block if present
    style_block = ""
    style_match = re.match(r"(<style[\s\S]*?</style>)\s*", content_html, re.IGNORECASE)
    if style_match:
        style_block = style_match.group(1)
        content_html = content_html[style_match.end():]

    # Extract individual <section>...</section> elements
    sections = re.findall(
        r"<section[\s\S]*?</section>",
        content_html,
        flags=re.IGNORECASE,
    )

    if not sections:
        # No sections — wrap everything in one block
        full = (style_block + "\n" + content_html).strip()
        return _wrap_block(full)

    parts = []

    if style_block:
        parts.append(_wrap_block(style_block))

    for section in sections:
        parts.append(_wrap_block(section))

    return "\n\n".join(parts)


def _wrap_block(html: str) -> str:
    html = html.strip()
    return f"<!-- wp:html -->\n{html}\n<!-- /wp:html -->"
