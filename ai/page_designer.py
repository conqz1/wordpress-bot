"""
Designs an inner WordPress page (About, Contact, Services, etc.) using Claude Vision.
Unlike page_analyzer.py (which redesigns an existing page), this module designs a page
from scratch using the existing theme's brand context so it matches the homepage perfectly.

Output is raw HTML sections — no {{field}} Customizer markers.
Content goes into the WordPress database as Gutenberg wp:html blocks via the REST API.
"""
import json
import re

import anthropic

import config

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

_HTML_LIMIT = 20_000

# Common page types and the sections Claude should include
_PAGE_SECTION_HINTS = {
    "about":        ["hero-banner", "our-story", "team-grid", "stats-row", "cta-band"],
    "contact":      ["hero-banner", "contact-info-columns", "cta-band"],
    "services":     ["hero-banner", "services-grid", "process-steps", "why-choose-us", "cta-band"],
    "pricing":      ["hero-banner", "pricing-cards", "faq", "cta-band"],
    "testimonials": ["hero-banner", "reviews-grid", "stats-row", "cta-band"],
    "team":         ["hero-banner", "team-grid", "cta-band"],
    "faq":          ["hero-banner", "faq-accordion", "cta-band"],
    "resources":    ["hero-banner", "posts-grid", "cta-band"],
}

_SYSTEM_PROMPT = """You are a world-class web designer building an inner page for an existing WordPress theme.

The theme already provides the navigation header and footer — do NOT include them.
Your job is to design ONLY the page body content that appears between the header and footer.

The theme's brand colors, fonts, and CSS custom properties will be provided in the user message.
You MUST use var(--color-primary), var(--color-secondary), var(--color-accent) throughout —
never hardcode the hex values. This ensures the page matches the homepage exactly.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "page_title": "About Us",
  "sections": ["hero-banner", "our-story", "stats-row", "cta-band"],
  "content_html": "...",
  "images": [
    { "original_url": "<direct image URL>", "filename": "hero.jpg", "placeholder_id": "hero" }
  ]
}

━━━ content_html RULES ━━━

1. Start with a <style> block containing EXACTLY these base classes (copy verbatim, add more as needed):
   h1.entry-title, h1.page-title, .entry-header h1, .page-header h1,
   .wp-block-post-title, header.entry-header { display: none !important; }
   .wp-fw  { width: 100vw; margin-left: calc(50% - 50vw); }
   .wp-cont { max-width: 1100px; margin: 0 auto; padding: 0 40px; }
   .wp-btn  { display: inline-block; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 16px; cursor: pointer; text-decoration: none; transition: opacity 0.2s, transform 0.1s; }
   .wp-btn:hover { opacity: 0.88; transform: translateY(-1px); }
   .wp-title { font-size: 38px; font-weight: 700; line-height: 1.2; margin-bottom: 16px; }
   .wp-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; }
   * { box-sizing: border-box; }
   img { max-width: 100%; height: auto; }
   @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }
   a:focus-visible, button:focus-visible { outline: 3px solid var(--color-accent); outline-offset: 3px; }

2. EVERY <section> MUST have class "wp-fw" and a unique id matching its purpose:
   <section id="about-story" class="wp-fw" style="background:#fff; padding:100px 0;">
     <div class="wp-cont">...</div>
   </section>

3. Use var(--color-primary), var(--color-secondary), var(--color-accent) — never hardcode hex values
4. Use .wp-cont inside each section to constrain content to 1100px
5. DO NOT include <html>, <head>, <body>, <nav>, <footer> tags
6. DO NOT add a page title heading — WordPress shows it from the page title field
7. Reference images as __IMG_placeholder_id__ in src attributes
8. The JSON "content_html" value must be properly escaped: quotes → \\", newlines → \\n

━━━ DESIGN RULES ━━━
1. Match the homepage design language exactly — same card style, same section padding, same button style
2. Use var(--color-primary/secondary/accent) consistently — these come from the theme's style.css
3. Every card: box-shadow, border-radius, hover transition
4. Typography: h2 at 36–42px, h3 at 20–24px, body at 16–17px, line-height 1.6–1.7
5. Generous padding: 80–100px top/bottom on major sections
6. No 2-column image+text side-by-side layouts — use cards, full-width backgrounds, or stacked layouts
7. CTA band at the end of every page
8. All interactive elements: cursor: pointer; min-height: 44px

━━━ PAGE-TYPE SECTION PATTERNS ━━━

HERO BANNER (tasteful page header — not a full homepage hero):
<section id="page-hero" class="wp-fw" style="background:linear-gradient(135deg,var(--color-secondary) 0%,var(--color-primary) 100%);padding:80px 0;color:#fff;">
  <div class="wp-cont">
    <p class="wp-label" style="color:rgba(255,255,255,0.7);">About Us</p>
    <h2 class="wp-title" style="color:#fff;font-size:48px;">Our Story</h2>
    <p style="font-size:18px;line-height:1.7;max-width:600px;opacity:0.85;">A brief intro sentence.</p>
  </div>
</section>

STATS ROW:
<section id="stats" class="wp-fw" style="background:var(--color-primary);padding:60px 0;color:#fff;">
  <div class="wp-cont" style="display:grid;grid-template-columns:repeat(4,1fr);gap:32px;text-align:center;">
    <div>
      <div style="font-size:42px;font-weight:800;line-height:1;">25+</div>
      <div style="font-size:14px;opacity:0.75;margin-top:8px;">Years Experience</div>
    </div>
  </div>
</section>

CONTACT INFO COLUMNS:
<section id="contact-info" class="wp-fw" style="background:#fff;padding:100px 0;">
  <div class="wp-cont" style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;">
    <div>
      <h2 class="wp-title">Get in Touch</h2>
      <p style="color:#666;line-height:1.8;margin-bottom:32px;">We'd love to hear from you.</p>
      <div style="display:flex;flex-direction:column;gap:20px;">
        <div style="display:flex;align-items:center;gap:12px;">
          <span style="font-size:24px;">📞</span>
          <div><div style="font-size:13px;color:#999;margin-bottom:2px;">Phone</div><strong>(555) 000-0000</strong></div>
        </div>
      </div>
    </div>
    <div style="background:var(--color-light,#f8f9fa);border-radius:16px;padding:40px;">
      <h3 style="font-size:22px;font-weight:700;margin-bottom:24px;">Send a Message</h3>
      <p style="color:#666;line-height:1.7;">Use our contact form or reach out directly — we typically respond within one business day.</p>
      <a href="mailto:hello@example.com" class="wp-btn" style="background:var(--color-primary);color:#fff;margin-top:24px;display:inline-block;">Email Us</a>
    </div>
  </div>
</section>

CTA BAND:
<section id="cta" class="wp-fw" style="background:var(--color-accent,var(--color-primary));padding:80px 0;text-align:center;">
  <div class="wp-cont">
    <h2 style="font-size:40px;font-weight:800;color:#fff;margin-bottom:16px;">Ready to Get Started?</h2>
    <p style="font-size:18px;color:rgba(255,255,255,0.85);margin-bottom:32px;max-width:500px;margin-left:auto;margin-right:auto;">
      Contact us today.
    </p>
    <a href="/contact" class="wp-btn" style="background:#fff;color:var(--color-primary);font-size:17px;padding:16px 40px;">Get in Touch</a>
  </div>
</section>

━━━ IMAGE PLACEHOLDERS ━━━
- Only include images if a reference screenshot is provided
- If no screenshot: design the page using brand colors, icons, and text only — no images
- Give every image a short unique placeholder_id (e.g. "team1", "office")
- Use __IMG_placeholder_id__ as the src
- original_url must be a direct image file URL (.jpg/.png/.webp) — never a webpage URL
"""


def design_page(
    page_name: str,
    theme_meta: dict,
    theme_css: str,
    screenshot_b64: str = None,
    html: str = "",
    url: str = "",
    style: str = None,
) -> dict:
    """
    Ask Claude to design an inner page that matches the existing theme.

    Args:
        page_name:      e.g. "About", "Contact", "Services"
        theme_meta:     dict from theme-meta.json (colors, slug, name)
        theme_css:      content of the theme's style.css (provides CSS custom props context)
        screenshot_b64: optional base64 JPEG of a reference page to draw content from
        html:           optional HTML of a reference page
        url:            optional URL of the reference page
        style:          optional style directive
    """
    page_key = page_name.lower().replace(" ", "-")
    section_hints = _PAGE_SECTION_HINTS.get(page_key, ["hero-banner", "content", "cta-band"])

    # Extract just the :root block from theme CSS to give Claude the CSS variables
    root_css = ""
    root_match = re.search(r":root\s*\{[^}]+\}", theme_css, re.DOTALL)
    if root_match:
        root_css = root_match.group(0)

    # Build user message
    user_text = (
        f"Design the '{page_name}' page for this WordPress theme.\n\n"
        f"Theme: {theme_meta.get('theme_name', 'Custom Theme')}\n"
        f"Primary color:   {theme_meta.get('primary_color', '')}\n"
        f"Secondary color: {theme_meta.get('secondary_color', '')}\n"
        f"Accent color:    {theme_meta.get('accent_color', '')}\n\n"
        f"Theme CSS variables (use these — do not hardcode hex values):\n{root_css}\n\n"
        f"Expected sections for a '{page_name}' page: {', '.join(section_hints)}\n\n"
    )

    if url:
        user_text += f"Reference page URL: {url}\n"
        if html:
            truncated = _truncate_html(html)
            user_text += f"Reference HTML (truncated):\n{truncated}\n\n"
        user_text += (
            "Study the reference content carefully. Extract all real text, stats, team members, "
            "services, testimonials — use the actual content but elevate the design.\n"
        )
    else:
        user_text += (
            f"No reference URL provided. Design a complete, professional '{page_name}' page "
            f"with realistic placeholder content that matches the theme's industry and brand. "
            f"Do not include any images.\n"
        )

    if style:
        user_text += f"\nSTYLE DIRECTIVE: {style}"

    print(f"[ai] Designing '{page_name}' page...")

    content_blocks = [{"type": "text", "text": user_text}]

    if screenshot_b64:
        content_blocks.insert(0, {
            "type": "image",
            "source": {
                "type": "base64",
                "media_type": "image/jpeg",
                "data": screenshot_b64,
            },
        })

    raw_chunks = []
    with _client.messages.stream(
        model="claude-opus-4-6",
        max_tokens=32768,
        system=_SYSTEM_PROMPT,
        messages=[{"role": "user", "content": content_blocks}],
    ) as stream:
        for text in stream.text_stream:
            raw_chunks.append(text)
            print(".", end="", flush=True)
        final_message = stream.get_final_message()
    print()

    usage = final_message.usage
    input_tokens = usage.input_tokens
    output_tokens = usage.output_tokens
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
        print("[ai] WARNING: Response truncated — JSON repaired. Page may be incomplete.")
        return result
    except json.JSONDecodeError as e:
        raise ValueError(
            f"Claude returned invalid JSON: {e}\n\nRaw (first 500 chars):\n{text[:500]}"
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
