"""
Sends the page screenshot + (truncated) HTML to Claude Vision and asks it
to return a structured Elementor JSON payload.
"""
import json
import re
import uuid

import anthropic

import config

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

# Maximum HTML characters to send (keep prompt within token budget)
_HTML_LIMIT = 12_000

SYSTEM_PROMPT = """You are an expert Elementor page builder developer.
Analyze the webpage screenshot and HTML carefully, then produce valid Elementor JSON
that recreates the page as accurately as possible.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "page_title": "<page title>",
  "page_status": "draft",
  "elementor_data": [ ...Elementor section/column/widget array... ],
  "images": [
    { "original_url": "<url>", "placeholder_id": "<unique short string>" }
  ]
}

━━━ ELEMENTOR JSON STRUCTURE ━━━

Every element: { "id": "<8-char hex>", "elType": "...", "settings": {}, "elements": [] }

Hierarchy: section → column → widget  (never nest sections inside sections)

━━━ WIDGET TYPES ━━━

heading:     { "title": "text", "header_size": "h1|h2|h3|h4|h5|h6",
               "align": "left|center|right", "title_color": "#hex",
               "typography_font_size": {"unit":"px","size":36},
               "typography_font_weight": "700" }

text-editor: { "editor": "<p>content</p>" }

image:       { "image": {"url": "__IMG_placeholder_id__", "id": 0, "alt": "text"},
               "align": "left|center|right",
               "image_size": "full" }

button:      { "text": "label", "link": {"url": "#"},
               "align": "left|center|right",
               "background_color": "#hex", "button_text_color": "#hex",
               "border_radius": {"unit":"px","top":"4","right":"4","bottom":"4","left":"4","isLinked":true} }

spacer:      { "space": {"size": 40, "unit": "px"} }
divider:     { "color": {"color": "#hex"}, "gap": {"size":20,"unit":"px"} }
html:        { "html": "<div>...</div>" }
icon-box:    { "title_text": "...", "description_text": "...", "icon": {"value":"fas fa-bolt","library":"fa-solid"} }
video:       { "youtube_url": "..." }

━━━ SECTION SETTINGS ━━━

Flat solid background:
  "background_color": "#hex"

Hero/banner with a BACKGROUND IMAGE (use this for any section where an image fills the background):
  "background_background": "classic",
  "background_image": {"url": "__IMG_placeholder_id__", "id": 0, "alt": ""},
  "background_size": "cover",
  "background_position": "center center",
  "min_height": {"unit":"px","size":600},
  "padding": {"unit":"px","top":"80","right":"40","bottom":"80","left":"40","isLinked":false}

Padding (no background image):
  "padding": {"unit":"px","top":"60","right":"0","bottom":"60","left":"0","isLinked":false}

━━━ COLUMN SETTINGS ━━━
  "_column_size": 100 | 66 | 50 | 33 | 25

━━━ IMAGE PLACEHOLDERS ━━━
- Assign a short unique placeholder_id to every image (e.g. "hero_bg", "logo", "team_photo").
- Use "__IMG_placeholder_id__" as the URL everywhere in elementor_data (both widget images AND section background images).
- List every image used in the top-level "images" array with original_url + placeholder_id.
- The system will upload each image to WordPress and replace placeholders automatically.

━━━ ACCURACY RULES ━━━
1. HERO SECTIONS: If the original has a large image filling a section background, set background_background="classic" and background_image on the SECTION — do NOT use an image widget for it.
2. NAVIGATION BAR: Recreate as an html widget with inline styles matching the original colors/layout.
3. EVERY TEXT: Copy all visible text exactly — headings, body copy, phone numbers, taglines, CTAs.
4. COLORS: Extract exact hex colors from the screenshot for backgrounds, text, and buttons.
5. LAYOUT: Match the column structure — if the original has 2 columns side by side, use 2 columns (50/50 or as appropriate).
6. FORMS: Recreate contact/lead forms as an html widget with styled inputs matching the original.
7. RATINGS/REVIEWS BAR: Recreate as an html widget with stars, rating number, and review count.
8. One section per distinct horizontal band of the page.
9. Include ALL sections visible in the screenshot — do not skip any.
"""


def analyze(screenshot_b64: str, html: str, url: str) -> dict:
    """
    Call Claude Vision with the screenshot and HTML.
    Returns parsed dict: { page_title, page_status, elementor_data, images }
    """
    truncated_html = _truncate_html(html)

    print("[ai] Sending page to Claude for analysis...")

    raw_chunks = []
    with _client.messages.stream(
        model="claude-opus-4-6",
        max_tokens=32768,
        system=SYSTEM_PROMPT,
        messages=[
            {
                "role": "user",
                "content": [
                    {
                        "type": "image",
                        "source": {
                            "type": "base64",
                            "media_type": "image/png",
                            "data": screenshot_b64,
                        },
                    },
                    {
                        "type": "text",
                        "text": (
                            f"Page URL: {url}\n\n"
                            f"HTML (truncated to {_HTML_LIMIT} chars):\n"
                            f"{truncated_html}\n\n"
                            "Generate the Elementor JSON now."
                        ),
                    },
                ],
            }
        ],
    ) as stream:
        for text in stream.text_stream:
            raw_chunks.append(text)
            print(".", end="", flush=True)
        final_message = stream.get_final_message()
    print()  # newline after dots

    usage = final_message.usage
    input_tokens = usage.input_tokens
    output_tokens = usage.output_tokens
    # claude-opus-4-6 pricing: $15/M input, $75/M output
    cost_usd = (input_tokens / 1_000_000 * 15) + (output_tokens / 1_000_000 * 75)

    print(
        f"[ai] Tokens — input: {input_tokens:,} | output: {output_tokens:,} | "
        f"cost: ${cost_usd:.4f}"
    )

    raw = "".join(raw_chunks).strip()
    result = _parse_json(raw)

    result["elementor_data"] = _assign_ids(result.get("elementor_data", []))
    result["_usage"] = {
        "input_tokens": input_tokens,
        "output_tokens": output_tokens,
        "cost_usd": cost_usd,
    }

    print(f"[ai] Analysis complete. Sections: {len(result['elementor_data'])} | Images: {len(result.get('images', []))}")
    return result


def _truncate_html(html: str) -> str:
    """Strip scripts/styles and truncate."""
    html = re.sub(r"<script[^>]*>.*?</script>", "", html, flags=re.DOTALL | re.IGNORECASE)
    html = re.sub(r"<style[^>]*>.*?</style>", "", html, flags=re.DOTALL | re.IGNORECASE)
    html = re.sub(r"<!--.*?-->", "", html, flags=re.DOTALL)
    html = re.sub(r"\s{2,}", " ", html)
    return html[:_HTML_LIMIT]


def _parse_json(text: str) -> dict:
    """Extract JSON from the model response, even if wrapped in markdown or truncated."""
    # Strip markdown code fences if present
    text = re.sub(r"^```[a-z]*\n?", "", text.strip(), flags=re.MULTILINE)
    text = re.sub(r"```$", "", text.strip(), flags=re.MULTILINE)
    text = text.strip()

    # First try: parse as-is
    try:
        return json.loads(text)
    except json.JSONDecodeError:
        pass

    # Second try: response was truncated — attempt to close open structures
    repaired = _repair_truncated_json(text)
    try:
        result = json.loads(repaired)
        print("[ai] WARNING: Claude response was truncated — JSON was repaired. "
              "The page may be incomplete. Consider running again.")
        return result
    except json.JSONDecodeError as e:
        raise ValueError(
            f"Claude returned invalid JSON that could not be repaired: {e}\n\n"
            f"Raw response (first 500 chars):\n{text[:500]}"
        )


def _repair_truncated_json(text: str) -> str:
    """
    Close any open JSON arrays/objects so a truncated response can be parsed.
    Walks the string tracking open brackets/braces and appends closing tokens.
    """
    stack = []
    in_string = False
    escape_next = False

    for ch in text:
        if escape_next:
            escape_next = False
            continue
        if ch == "\\" and in_string:
            escape_next = True
            continue
        if ch == '"':
            in_string = not in_string
            continue
        if in_string:
            continue
        if ch in ("{", "["):
            stack.append(ch)
        elif ch in ("}", "]"):
            if stack:
                stack.pop()

    # Remove trailing comma before we close
    stripped = text.rstrip().rstrip(",")

    # Close all open structures in reverse order
    for opener in reversed(stack):
        stripped += "}" if opener == "{" else "]"

    return stripped


def _assign_ids(elements: list) -> list:
    """Recursively ensure every element has a valid 8-char hex id."""
    for el in elements:
        if not el.get("id") or len(el["id"]) < 4:
            el["id"] = uuid.uuid4().hex[:8]
        if el.get("elements"):
            el["elements"] = _assign_ids(el["elements"])
    return elements
