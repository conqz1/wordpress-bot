"""
Sends a page screenshot + HTML to Claude Vision and asks it to redesign
the page content as beautiful, modern HTML for a WordPress post_content field.
The active theme provides nav/footer — this generates ONLY the page body.
"""
import json
import re

import anthropic

import config

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

_HTML_LIMIT = 20_000

PAGE_SYSTEM_PROMPT = """You are a world-class web designer.
Study the provided webpage screenshot and HTML, then recreate and IMPROVE its content as
a beautiful, modern HTML page body. You are redesigning it — not copying it exactly.

The output will be injected into a WordPress page as post_content. The active theme already
provides the navigation header and footer — do NOT include them.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "page_title": "Services",
  "sections": ["hero-banner", "services-grid", "why-us", "cta"],
  "content_html": "...",
  "images": [
    { "original_url": "<direct image URL>", "filename": "hero.jpg", "placeholder_id": "hero" }
  ]
}

━━━ content_html RULES ━━━

1. Start with a <style> block defining shared classes:
   .wp-cont   { max-width: 1100px; margin: 0 auto; padding: 0 40px; }
   .wp-btn    { display: inline-block; padding: 14px 32px; border-radius: 6px; font-weight: 600;
                font-size: 16px; cursor: pointer; text-decoration: none;
                transition: opacity 0.2s, transform 0.1s; }
   .wp-btn:hover { opacity: 0.88; transform: translateY(-1px); }
   .wp-title  { font-size: 38px; font-weight: 700; line-height: 1.2; margin-bottom: 16px; }
   .wp-label  { font-size: 12px; font-weight: 600; text-transform: uppercase;
                letter-spacing: 0.1em; margin-bottom: 12px; }
   * { box-sizing: border-box; }
   img { max-width: 100%; height: auto; }

2. Use full-width <section> elements with colored backgrounds and 80–100px top/bottom padding
3. Use .wp-cont inside each section to constrain content width
4. DO NOT include <html>, <head>, <body>, <nav>, <footer>, or structural page wrapper tags
5. DO NOT add a heading for the page title — WordPress shows the title from the page title field
6. Reference images as __IMG_placeholder_id__ in src attributes
7. Inline styles for section-specific colors/layout; .wp-* classes for shared patterns
8. The JSON "content_html" value must be properly escaped: quotes → \\", newlines → \\n

━━━ DESIGN RULES ━━━
1. Extract ALL real content: headings, body text, feature lists, testimonials, pricing, contact info
2. Use exact brand colors extracted from the source site
3. Make it look stunning — better than the original
4. Every card: box-shadow, border-radius, and hover transition
5. Typography: h2 at 36–42px, h3 at 20–24px, body at 16–17px, line-height 1.6–1.7
6. Generous padding: 80–100px top/bottom on major sections

━━━ IMAGE PLACEHOLDERS ━━━
- Give every image a short unique placeholder_id (e.g. "hero", "service1", "team1")
- Use __IMG_placeholder_id__ as the src in <img> tags
- filename must be a safe filename with extension (e.g. "hero-banner.jpg", "logo.png")
- original_url must be a DIRECT image file URL ending in .jpg, .png, .webp, .gif, or .svg
- NEVER use a webpage URL (e.g. https://example.com/about) as original_url

━━━ SECTION PATTERNS ━━━

PAGE HERO BANNER (not a full homepage hero — a tasteful page header):
<section style="background:linear-gradient(135deg,#1a2a4a 0%,#2d4a7a 100%);padding:80px 0;color:#fff;">
  <div class="wp-cont">
    <p class="wp-label" style="color:#7cb9ff;opacity:1;">What We Offer</p>
    <h2 class="wp-title" style="font-size:48px;color:#fff;">Our Services</h2>
    <p style="font-size:18px;line-height:1.7;max-width:600px;opacity:0.85;">
      Professional, reliable service delivered by experts.
    </p>
  </div>
</section>

FEATURE / SERVICES GRID:
<section style="background:#f8f9fa;padding:100px 0;">
  <div class="wp-cont">
    <h2 class="wp-title" style="text-align:center;margin-bottom:60px;">What We Do</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:#fff;border-radius:12px;padding:36px 28px;
                  box-shadow:0 2px 20px rgba(0,0,0,0.07);
                  transition:transform 0.2s,box-shadow 0.2s;"
           onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.07)'">
        <div style="font-size:36px;margin-bottom:16px;">⚡</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">Service Name</h3>
        <p style="color:#666;line-height:1.7;font-size:15px;">Description text here.</p>
      </div>
    </div>
  </div>
</section>

CTA BAND:
<section style="background:#e84c3d;padding:80px 0;text-align:center;">
  <div class="wp-cont">
    <h2 style="font-size:40px;font-weight:800;color:#fff;margin-bottom:16px;">Ready to Get Started?</h2>
    <p style="font-size:18px;color:rgba(255,255,255,0.85);margin-bottom:32px;max-width:500px;margin-left:auto;margin-right:auto;">
      Contact us today for a free consultation.
    </p>
    <a href="#contact" class="wp-btn" style="background:#fff;color:#e84c3d;font-size:17px;padding:16px 40px;">
      Get in Touch
    </a>
  </div>
</section>
"""


def analyze_page(screenshot_b64: str, html: str, url: str) -> dict:
    """
    Call Claude Vision with the page screenshot and HTML.
    Returns parsed dict: { page_title, sections, content_html, images, _usage }
    """
    truncated_html = _truncate_html(html)

    print("[ai] Sending page to Claude for page design...")

    raw_chunks = []
    with _client.messages.stream(
        model="claude-opus-4-6",
        max_tokens=32768,
        system=PAGE_SYSTEM_PROMPT,
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
                            f"Source page URL: {url}\n\n"
                            f"HTML (truncated to {_HTML_LIMIT} chars):\n"
                            f"{truncated_html}\n\n"
                            "Study this page's content and brand, then redesign it as a beautiful, "
                            "modern WordPress page body. Preserve all real content but elevate the design. "
                            "Make it stunning — better than the original."
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
    print()

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

    sections = result.get("sections", [])
    images = result.get("images", [])
    print(f"[ai] Page design complete. Sections: {len(sections)} | Images: {len(images)}")
    return result


def _truncate_html(html: str) -> str:
    html = re.sub(r"<script[^>]*>.*?</script>", "", html, flags=re.DOTALL | re.IGNORECASE)
    html = re.sub(r"<style[^>]*>.*?</style>", "", html, flags=re.DOTALL | re.IGNORECASE)
    html = re.sub(r"<!--.*?-->", "", html, flags=re.DOTALL)
    html = re.sub(r"\s{2,}", " ", html)
    return html[:_HTML_LIMIT]


def _parse_json(text: str) -> dict:
    text = re.sub(r"^```[a-z]*\n?", "", text.strip(), flags=re.MULTILINE)
    text = re.sub(r"```$", "", text.strip(), flags=re.MULTILINE)
    text = text.strip()

    try:
        return json.loads(text)
    except json.JSONDecodeError:
        pass

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

    stripped = text.rstrip().rstrip(",")
    for opener in reversed(stack):
        stripped += "}" if opener == "{" else "]"
    return stripped
