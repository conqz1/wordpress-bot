"""
Sends the page screenshot + (truncated) HTML to Claude Vision and asks it
to return a structured Gutenberg block markup payload.
"""
import json
import re

import anthropic

import config

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

# Maximum HTML characters to send (keep prompt within token budget)
_HTML_LIMIT = 20_000

SYSTEM_PROMPT = """You are an expert WordPress Gutenberg developer.
Analyze the webpage screenshot and HTML carefully, then produce valid WordPress Gutenberg block markup
that recreates the page as accurately and completely as possible.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "page_title": "<page title>",
  "block_content": "<full WordPress Gutenberg block markup as a single JSON-escaped string>",
  "images": [
    { "original_url": "<url>", "placeholder_id": "<unique short string>" }
  ]
}

━━━ BLOCK MARKUP FORMAT ━━━

Blocks use HTML comment delimiters. In the JSON string, escape all double quotes as \\" and use \\n for newlines.

━━━ FULL-WIDTH RULE (CRITICAL) ━━━

Every top-level block MUST span the full page width. Without this, the theme will crush content
into a narrow centered column. Add "align":"full" to every top-level wp:group and wp:cover.
Add "align":"wide" to every top-level wp:columns. These are mandatory on ALL top-level blocks.

━━━ CORE BLOCKS ━━━

HEADING (h1–h6):
<!-- wp:heading {"level":2,"style":{"color":{"text":"#hex"}}} -->
<h2 class="wp-block-heading" style="color:#hex">Heading text</h2>
<!-- /wp:heading -->

PARAGRAPH:
<!-- wp:paragraph {"style":{"color":{"text":"#hex"},"typography":{"fontSize":"18px"}}} -->
<p style="color:#hex;font-size:18px">Paragraph text here.</p>
<!-- /wp:paragraph -->

IMAGE:
<!-- wp:image {"id":0,"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="__IMG_placeholder__" alt="Description"/></figure>
<!-- /wp:image -->

COVER (hero / section with background image) — always alignfull at top level:
<!-- wp:cover {"url":"__IMG_hero__","id":0,"dimRatio":30,"minHeight":500,"minHeightUnit":"px","align":"full"} -->
<div class="wp-block-cover alignfull" style="min-height:500px">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="background-color:#000000;opacity:0.3"></span>
<img class="wp-block-cover__image-background" alt="" src="__IMG_hero__" data-object-fit="cover"/>
<div class="wp-block-cover__inner-container">
<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#ffffff"}}} -->
<h1 class="wp-block-heading has-text-align-center" style="color:#ffffff">Hero Title</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ffffff"}}} -->
<p class="has-text-align-center" style="color:#ffffff">Subtitle text here</p>
<!-- /wp:paragraph -->
</div>
</div>
<!-- /wp:cover -->

GROUP (section with background color) — always alignfull at top level:
<!-- wp:group {"align":"full","style":{"color":{"background":"#1a1a2e"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"40px","right":"40px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#1a1a2e;padding-top:60px;padding-bottom:60px;padding-left:40px;padding-right:40px">
<!-- inner blocks go here -->
</div>
<!-- /wp:group -->

COLUMNS (2, 3, or 4 column layout) — use alignwide at top level:
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- column content blocks -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- column content blocks -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

BUTTONS:
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#hex","text":"#fff"},"border":{"radius":"4px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="#" style="border-radius:4px;background-color:#hex;color:#fff">Button Text</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

SEPARATOR:
<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

SPACER:
<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

HTML (raw custom HTML — use for complex elements: forms, nav bars, rating widgets, icon grids):
<!-- wp:html -->
<div style="width:100%;box-sizing:border-box;">Your custom HTML here</div>
<!-- /wp:html -->

━━━ IMAGE PLACEHOLDERS ━━━
- Every image needs a short unique placeholder_id (e.g. "hero_bg", "logo", "img1")
- Use "__IMG_placeholder_id__" as the src/url wherever an image appears in blocks
- List EVERY image in the top-level "images" array with its original_url and placeholder_id
- The system will upload images to WordPress and replace placeholders with real URLs
- CRITICAL: original_url must be a direct image file URL (ending in .jpg, .png, .webp, .gif, .svg, etc.)
- NEVER put a webpage URL (e.g. https://example.com/) as an original_url — only real image file URLs

━━━ LAYOUT PATTERNS ━━━

TOP HEADER BAR (ratings + logo + phone):
→ wp:group align:"full" (background color matching the bar)
  → wp:columns align:"wide" (3 equal columns ~33/33/33)
    Left col: wp:html — star rating and review count, white-space:nowrap on key elements
    Center col: wp:image with logo
    Right col: wp:html — phone number and CTA button, white-space:nowrap on key elements

NAVIGATION BAR (horizontal menu):
→ wp:group align:"full" (background color matching the nav)
  → wp:html — <nav> with display:flex, flex-wrap:nowrap, all items inline, no text wrapping

HERO SECTION (large background image with text):
→ wp:cover align:"full" with background image, appropriate dimRatio
  → wp:heading (main headline, large, bold)
  → wp:paragraph (supporting text / bullet list)
  → wp:buttons (call to action)
  → wp:html (contact form if present, fully inline-styled)

SERVICES / FEATURES GRID (3–4 cards in a row):
→ wp:group align:"full" (section background)
  → wp:columns align:"wide" (3 or 4 equal columns)
    Each column: wp:html for fully styled card

CONTENT BAND (text + image side by side):
→ wp:group align:"full"
  → wp:columns align:"wide" (60/40 or 50/50)
    Left: wp:heading, wp:paragraph
    Right: wp:image

FOOTER:
→ wp:group align:"full" (dark background)
  → wp:columns align:"wide" for multi-column footer
  → wp:paragraph for copyright

━━━ ACCURACY RULES ━━━
1. DO NOT add a heading block for the page title — WordPress already displays it from the title field
2. Start block_content with the FIRST real content section (header bar, nav, or hero)
3. Add "align":"full" to EVERY top-level wp:group and wp:cover — this is non-negotiable
4. Add "align":"wide" to EVERY top-level wp:columns
5. COPY ALL TEXT exactly as shown in the screenshot — headings, body, phone numbers, CTAs
6. MATCH colors with exact hex values using inline styles on every block
7. USE wp:cover for ANY section that has a background photo/image
8. USE wp:group with background-color for solid-color section bands
9. USE wp:html for complex elements: navigation bars, forms, icon grids, star ratings
10. In wp:html blocks add white-space:nowrap to phone numbers, button text, and short labels
11. Recreate the ENTIRE page top to bottom — do NOT skip any section
12. The block_content JSON string must be properly escaped (quotes as \\", newlines as \\n)
"""


def analyze(screenshot_b64: str, html: str, url: str) -> dict:
    """
    Call Claude Vision with the screenshot and HTML.
    Returns parsed dict: { page_title, block_content, images }
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
                            "Generate the Gutenberg block markup now."
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

    result["_usage"] = {
        "input_tokens": input_tokens,
        "output_tokens": output_tokens,
        "cost_usd": cost_usd,
    }

    block_content = result.get("block_content", "")
    block_count = len(re.findall(r"<!-- wp:", block_content))
    print(f"[ai] Analysis complete. Blocks: {block_count} | Images: {len(result.get('images', []))}")
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
