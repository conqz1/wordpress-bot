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
_HTML_LIMIT = 20_000

SYSTEM_PROMPT = """You are an expert Elementor page builder developer.
Analyze the webpage screenshot and HTML carefully, then produce valid Elementor JSON
that recreates the page as accurately and completely as possible.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "page_title": "<page title>",
  "page_status": "draft",
  "elementor_data": [ ...array of section elements... ],
  "images": [
    { "original_url": "<url>", "placeholder_id": "<unique short string>" }
  ]
}

━━━ ELEMENTOR JSON STRUCTURE ━━━

Every element: { "id": "<8-char hex>", "elType": "...", "settings": {}, "elements": [] }
Hierarchy: section → column → widget  (NEVER nest sections inside sections)

━━━ WIDGET TYPES ━━━

heading:     { "title": "text", "header_size": "h1|h2|h3|h4|h5|h6",
               "align": "left|center|right", "title_color": "#hex",
               "typography_font_size": {"unit":"px","size":36},
               "typography_font_weight": "700" }
text-editor: { "editor": "<p>HTML content</p>" }
image:       { "image": {"url": "__IMG_pid__", "id": 0, "alt": "text", "source": "library"},
               "align": "left|center|right", "image_size": "full" }
button:      { "text": "label", "link": {"url": "#"},
               "align": "left|center|right",
               "background_color": "#hex", "button_text_color": "#hex",
               "border_radius": {"unit":"px","top":"4","right":"4","bottom":"4","left":"4","isLinked":true} }
spacer:      { "space": {"size": 40, "unit": "px"} }
divider:     { "color": {"color": "#hex"} }
html:        { "html": "<div style='...'>...</div>" }
icon-box:    { "title_text": "...", "description_text": "...", "icon": {"value":"fas fa-bolt","library":"fa-solid"} }

━━━ SECTION WITH BACKGROUND IMAGE — EXACT FORMAT ━━━

Use this EXACT structure for ANY section where a photo/image fills the background:

{
  "id": "xxxxxxxx",
  "elType": "section",
  "settings": {
    "background_background": "classic",
    "background_image": {
      "url": "__IMG_hero_bg__",
      "id": 0,
      "size": "",
      "alt": "",
      "source": "library"
    },
    "background_size": "cover",
    "background_position": "center center",
    "background_repeat": "no-repeat",
    "background_attachment": "scroll",
    "min_height": {"unit": "px", "size": 650},
    "padding": {"unit":"px","top":"80","right":"40","bottom":"80","left":"40","isLinked":false}
  },
  "elements": [ ...columns... ]
}

CRITICAL: The "background_background": "classic" key MUST be present. Without it, the image will not display.

━━━ SECTION WITH FLAT COLOR ━━━
{ "background_color": "#hex", "padding": {"unit":"px","top":"60","right":"0","bottom":"60","left":"0","isLinked":false} }

━━━ COLUMN SETTINGS ━━━
"_column_size": 100 | 66 | 60 | 50 | 40 | 33 | 25

━━━ IMAGE PLACEHOLDERS ━━━
- Every image needs a short unique placeholder_id (e.g. "hero_bg", "logo", "img1").
- Use "__IMG_placeholder_id__" as the url value in BOTH widget images AND section background_image.
- List EVERY image in the top-level "images" array with its original_url and placeholder_id.
- The system will upload images to WordPress and replace placeholders with real URLs + IDs.

━━━ LAYOUT PATTERNS TO RECOGNIZE ━━━

TOP HEADER BAR (ratings + logo + phone pattern):
  → 1 section, 3 columns (33/33/33):
    Col 1: html widget with star rating and review count
    Col 2: image widget with logo
    Col 3: html widget with phone number and CTA button

NAVIGATION BAR (horizontal menu bar with colored background):
  → 1 section with background_color matching the nav color
  → 1 full-width column
  → 1 html widget containing <nav> with inline-styled links

HERO SECTION (large photo background with text + form):
  → 1 section with background_background="classic" + background_image
  → 2 columns (60% left, 40% right):
    Left col: heading, text-editor (bullet points), button widgets
    Right col: html widget with styled form

SERVICES GRID (3 or 4 cards in a row):
  → 1 section, multiple equal columns, each with icon-box or html widget

━━━ ACCURACY RULES ━━━
1. HERO: Use background_background="classic" on the SECTION — never an image widget for backgrounds.
2. COPY ALL TEXT exactly as shown — headings, subheadings, phone numbers, bullets, CTAs.
3. COLORS: Match exact hex colors from screenshot for backgrounds, text, buttons, nav bars.
4. COLUMN WIDTHS: Match proportions — 60/40 split, 33/33/33, etc.
5. HEADER: Recreate the top bar (ratings, logo, phone) as 3 separate columns.
6. NAV BAR: Recreate as an html widget with the correct background color and all menu items.
7. FORMS: Use html widget with inline-styled inputs matching the original appearance.
8. RATINGS: Use html widget — include the number (e.g. 4.9), stars (★), and review count.
9. One section per distinct horizontal band.
10. Do NOT skip any visible section — recreate the ENTIRE page from top to bottom.
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
