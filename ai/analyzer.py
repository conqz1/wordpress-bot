"""
Sends the page screenshot + (truncated) HTML to Claude Vision and asks it
to return a structured WordPress theme payload.
"""
import json
import re

import anthropic

import config

_client = anthropic.Anthropic(api_key=config.ANTHROPIC_API_KEY)

# Maximum HTML characters to send (keep prompt within token budget)
_HTML_LIMIT = 20_000

SYSTEM_PROMPT = """You are a world-class web designer and WordPress theme developer.
Study the provided website screenshot and HTML, then design a beautiful, modern, professional
WordPress theme inspired by it. You are NOT copying the site — you are redesigning it.

The output is an ACTUAL WordPress theme with proper template separation:
- header_html → goes into header.php (shown on EVERY page — nav bar, top bar)
- body_html   → goes into front-page.php (homepage only — hero, services, CTA, etc.)
- footer_html → goes into footer.php (shown on EVERY page — footer, copyright)

This means new WordPress pages will automatically get the nav and footer.

Return ONLY a valid JSON object — no markdown fences, no explanation, nothing else. Shape:
{
  "theme_name": "Business Name Theme",
  "theme_slug": "business-name-theme",
  "description": "A modern WordPress theme for Business Name — electricians, Waco TX",
  "primary_color": "#hex",
  "secondary_color": "#hex",
  "accent_color": "#hex",
  "sections": ["topbar", "nav", "hero", "services", "about", "testimonials", "cta", "footer"],
  "global_css": "/* CSS string — resets, fonts, utility classes, animations */",
  "header_html": "<!-- Top bar + navigation only. Shown on EVERY page. No <html>/<head>/<body> tags. -->",
  "body_html": "<!-- Homepage content only: hero, services, about, testimonials, CTA. NOT nav or footer. -->",
  "footer_html": "<!-- Site footer only. Shown on EVERY page. No </body></html> tags. -->",
  "images": [
    { "original_url": "<direct image URL>", "filename": "hero.jpg", "placeholder_id": "hero" }
  ]
}

━━━ DESIGN PHILOSOPHY ━━━

Think like a $10,000 agency hired to redesign this business's website:
- MODERN: Clean layout, ample whitespace, strong visual hierarchy
- BOLD: Full-width hero with large text, high-contrast CTAs, vivid brand color usage
- POLISHED: Card components with box-shadows, smooth hover effects, professional typography
- CONSISTENT: 2–3 brand colors used purposefully throughout every section
- COMPLETE: Every section of the original site must be present and improved

━━━ global_css RULES ━━━

Include in global_css:
- CSS custom properties for brand colors: --color-primary, --color-secondary, --color-accent
- Base body styles (font-family, line-height, color)
- Utility classes: .container (max-width:1100px; margin:0 auto; padding:0 40px), .btn, .section-title
- Hover/transition effects on links and buttons
- Any CSS animations (fade-in, etc.)

Example:
:root {
  --color-primary: #8B2E1A;
  --color-secondary: #1A1A1A;
  --color-accent: #E84C3D;
}
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1a1a1a; }
.container { max-width: 1100px; margin: 0 auto; padding: 0 40px; }
.btn { display: inline-block; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 16px; cursor: pointer; text-decoration: none; transition: opacity 0.2s, transform 0.1s; }
.btn:hover { opacity: 0.88; transform: translateY(-1px); }
.btn-primary { background: var(--color-accent); color: #fff; }
.btn-secondary { background: #fff; color: var(--color-primary); border: 2px solid var(--color-primary); }
.section-title { font-size: 38px; font-weight: 700; line-height: 1.2; margin-bottom: 16px; }
.section-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; opacity: 0.7; }
* { box-sizing: border-box; }
a { text-decoration: none; color: inherit; }

━━━ header_html / body_html / footer_html RULES ━━━

header_html — put ONLY the top bar and navigation here:
- This is rendered on EVERY WordPress page, not just the front page
- Include: top bar (ratings/phone), navigation bar with logo and menu links
- Use inline styles + CSS custom properties
- No <html>, <head>, <body> tags

body_html — put ONLY the homepage-specific content sections here:
- Hero, services grid, about section, testimonials, CTA band
- Do NOT include the nav or footer (those are in header_html / footer_html)
- Use the .container class for content width constraint
- Use CSS custom properties from global_css (var(--color-primary), etc.)
- Reference images as __IMG_placeholder_id__ in src attributes
- No <html>, <head>, <body> tags

footer_html — put ONLY the footer here:
- This is rendered on EVERY WordPress page
- Include: footer columns (logo, links, contact), copyright line
- No </body>, </html> tags

━━━ SECTION PATTERNS ━━━

━━━ header_html EXAMPLE (top bar + nav — shown on every page) ━━━

<div style="background:var(--color-secondary);padding:10px 0;">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;color:#fff;font-size:14px;flex-wrap:nowrap;gap:16px;">
    <span style="white-space:nowrap;">⭐⭐⭐⭐⭐ <strong>4.9</strong> (97 Reviews)</span>
    <span style="white-space:nowrap;">Serving Waco, TX Area</span>
    <div style="display:flex;align-items:center;gap:12px;white-space:nowrap;">
      <strong style="font-size:16px;">(254) 266-7299</strong>
      <a href="#contact" class="btn btn-primary" style="padding:8px 20px;font-size:14px;">Contact Us</a>
    </div>
  </div>
</div>
<nav style="background:var(--color-primary);padding:0;">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:72px;">
    <a href="/" style="display:flex;align-items:center;">
      <img src="__IMG_logo__" alt="Logo" style="height:48px;width:auto;"/>
    </a>
    <div style="display:flex;gap:32px;align-items:center;">
      <a href="#services" style="color:#fff;font-weight:500;font-size:15px;white-space:nowrap;transition:opacity 0.2s;" onmouseover="this.style.opacity=0.7" onmouseout="this.style.opacity=1">Services</a>
      <a href="#about" style="color:#fff;font-weight:500;font-size:15px;white-space:nowrap;" onmouseover="this.style.opacity=0.7" onmouseout="this.style.opacity=1">About</a>
      <a href="#contact" class="btn btn-primary" style="white-space:nowrap;">Get a Quote</a>
    </div>
  </div>
</nav>

━━━ body_html EXAMPLES (homepage content only — hero through CTA) ━━━

HERO SECTION (with background image):
<section style="position:relative;min-height:640px;display:flex;align-items:center;overflow:hidden;">
  <img src="__IMG_hero_bg__" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"/>
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.7) 0%,rgba(0,0,0,0.3) 100%);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;color:#fff;padding-top:80px;padding-bottom:80px;">
    <p class="section-label" style="color:var(--color-accent);">Licensed & Insured</p>
    <h1 style="font-size:58px;font-weight:800;line-height:1.1;margin-bottom:20px;max-width:700px;">Expert Electricians in Waco, TX</h1>
    <p style="font-size:20px;line-height:1.6;margin-bottom:36px;max-width:560px;opacity:0.9;">Fast, reliable electrical services for homes and businesses. Available 24/7.</p>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="tel:2542667299" class="btn btn-primary" style="font-size:18px;padding:16px 36px;">Call (254) 266-7299</a>
      <a href="#contact" class="btn btn-secondary" style="font-size:18px;padding:16px 36px;">Request Service</a>
    </div>
  </div>
</section>

SERVICES GRID:
<section id="services" style="background:#f8f9fa;padding:100px 0;">
  <div class="container">
    <p class="section-label" style="text-align:center;color:var(--color-primary);">What We Do</p>
    <h2 class="section-title" style="text-align:center;margin-bottom:60px;">Our Electrical Services</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <!-- Each card: -->
      <div style="background:#fff;border-radius:12px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.07);transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.07)'">
        <div style="font-size:40px;margin-bottom:16px;">⚡</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Residential Electrical</h3>
        <p style="color:#666;line-height:1.7;font-size:15px;">Panel upgrades, outlet installs, wiring repairs, and everything your home needs.</p>
      </div>
    </div>
  </div>
</section>

WHY CHOOSE US:
<section style="background:var(--color-secondary);padding:100px 0;color:#fff;">
  <div class="container">
    <p class="section-label" style="text-align:center;color:var(--color-accent);">Why League Electric</p>
    <h2 class="section-title" style="text-align:center;margin-bottom:60px;">Built on Trust & Quality</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:40px;">
      <div style="text-align:center;">
        <div style="font-size:48px;margin-bottom:16px;">🏆</div>
        <h3 style="font-size:22px;font-weight:700;margin-bottom:10px;">Licensed & Insured</h3>
        <p style="opacity:0.75;line-height:1.7;">All our electricians are fully licensed and carry comprehensive insurance.</p>
      </div>
    </div>
  </div>
</section>

TESTIMONIALS:
<section style="background:#fff;padding:100px 0;">
  <div class="container">
    <p class="section-label" style="text-align:center;color:var(--color-primary);">Reviews</p>
    <h2 class="section-title" style="text-align:center;margin-bottom:60px;">What Our Customers Say</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:#f8f9fa;border-radius:12px;padding:32px;border-left:4px solid var(--color-accent);">
        <div style="color:var(--color-accent);font-size:20px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;">"Quote text here..."</p>
        <strong style="color:var(--color-secondary);">— Customer Name</strong>
      </div>
    </div>
  </div>
</section>

CTA BAND:
<section style="background:var(--color-accent);padding:100px 0;text-align:center;">
  <div class="container">
    <h2 style="font-size:42px;font-weight:800;color:#fff;margin-bottom:16px;">Ready to Get Started?</h2>
    <p style="font-size:20px;color:rgba(255,255,255,0.85);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto;">Contact us today for a free estimate on any electrical job.</p>
    <a href="tel:2542667299" class="btn" style="background:#fff;color:var(--color-accent);font-size:18px;padding:18px 44px;">Call (254) 266-7299</a>
  </div>
</section>

━━━ footer_html EXAMPLE (footer only — shown on every page) ━━━

<footer style="background:#111;padding:80px 0 40px;color:#fff;">
  <div class="container">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:60px;margin-bottom:60px;">
      <div>
        <img src="__IMG_logo__" alt="Logo" style="height:48px;margin-bottom:20px;filter:brightness(0) invert(1);"/>
        <p style="opacity:0.6;line-height:1.7;max-width:300px;">Professional electrical services in Waco, TX. Licensed, insured, and trusted.</p>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Services</h4>
        <div style="display:flex;flex-direction:column;gap:10px;opacity:0.7;">
          <a href="#" style="color:#fff;font-size:15px;">Residential</a>
          <a href="#" style="color:#fff;font-size:15px;">Commercial</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Contact</h4>
        <div style="opacity:0.7;font-size:15px;line-height:2;">
          <p>Waco, TX</p>
          <p>(254) 266-7299</p>
        </div>
      </div>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:32px;text-align:center;opacity:0.5;font-size:14px;">
      © <?php echo date('Y'); ?> Business Name. All rights reserved.
    </div>
  </div>
</footer>

━━━ IMAGE PLACEHOLDERS ━━━
- Give every image a short unique placeholder_id (e.g. "hero", "logo", "service1")
- Use __IMG_placeholder_id__ as the src in <img> tags and CSS background-image values
- filename must be a safe filename with extension (e.g. "hero-bg.jpg", "logo.png")
- original_url must be a direct image file URL ending in .jpg, .png, .webp, .gif, or .svg
- NEVER use a webpage URL (e.g. https://example.com/) as original_url

━━━ EDITABLE CONTENT (WordPress Customizer) — NON-NEGOTIABLE ━━━
EVERY piece of visible text on the site MUST use this syntax — no exceptions:
  {{field_name|Default text here}}

This is a hard business requirement. The site owner must be able to edit ALL text
through WordPress without touching code. If any text is hardcoded, it is a defect.

Rules:
- field_name must be snake_case, unique, and descriptive (e.g. hero_headline, contact_phone)
- Default text is the actual content you extracted from the source site
- Only wrap visible text content — NOT HTML attributes, CSS values, or URLs
- MUST wrap ALL of: headlines, taglines, subheadings, paragraph descriptions,
  phone numbers, addresses, business hours, CTA button labels, testimonial quotes,
  service names, service descriptions, stats/numbers, reviewer names, review text,
  footer taglines, copyright text, nav CTA label, top bar text, badge labels
- Do NOT wrap: nav link labels (Home, About, etc.), section IDs, CSS class names, image alt text

Examples:
  <h1>{{hero_headline|Expert Electricians in Waco, TX}}</h1>
  <p>{{hero_subtext|Fast, reliable electrical services for homes and businesses.}}</p>
  <a href="tel:2542667299">{{contact_phone|(254) 266-7299}}</a>
  <h3>{{service_1_title|Residential Electrical}}</h3>
  <p>{{service_1_desc|Panel upgrades, outlet installs, wiring repairs, and everything your home needs.}}</p>
  <strong>{{reviewer_1_name|— Sarah M.}}</strong>
  <p>{{stat_1_label|Years Experience}}</p>
  <div>{{stat_1_value|45+}}</div>
  <p>{{footer_tagline|Professional electrical services in Waco, TX. Licensed, insured, and trusted.}}</p>

━━━ DESIGN RULES ━━━
1. Extract ALL real content: business name, phone, address, services, taglines, testimonials, hours
2. Use the brand colors from the source site — extract their exact hex values
3. Make it look stunning — better than the original
4. Use .container class for width-constrained content inside full-width sections
5. Every card gets box-shadow and border-radius; hover effects with CSS transitions
6. Full-width colored sections (no narrow content columns)
7. Generous padding: 80–100px top/bottom on major sections
8. Typography: h1 at 52–60px, h2 at 36–42px, body at 16–17px, line-height 1.6–1.7
9. Body text paragraphs: max-width 65ch for readable line length
10. Do NOT add a page title — WordPress shows it from the title field
11. header_html, body_html, and footer_html must each be properly JSON-escaped (quotes → \\", newlines → \\n)
12. The footer copyright year uses: <?php echo date('Y'); ?>
13. header_html = top bar + nav ONLY | body_html = hero through CTA ONLY | footer_html = footer ONLY

━━━ UX & ACCESSIBILITY STANDARDS (Non-Negotiable) ━━━
These 7 rules must be met in EVERY theme — treat them as hard requirements:

1. CONTRAST — All text must meet WCAG AA (4.5:1 ratio). Never put light gray text on white, or dark text on dark bg.
2. TRANSITIONS — All hover/interactive effects: transition duration 150–300ms. Never exceed 300ms for UI feedback.
3. REDUCED MOTION — Include in global_css:
   @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }
4. FOCUS STATES — All buttons and links must have visible :focus-visible outline:
   a:focus-visible, button:focus-visible, [role="button"]:focus-visible { outline: 3px solid var(--color-accent); outline-offset: 3px; }
5. CURSOR — Every button, link, and clickable element: cursor: pointer
6. TOUCH TARGETS — All interactive elements minimum 44×44px (use min-height/min-width or padding)
7. RESPONSIVE — Include these breakpoints in global_css for the nav (collapse to hamburger) and grids (stack to 1 col):
   @media (max-width: 768px) { .container { padding: 0 20px; } /* nav stacks, grids go to 1 col */ }
   @media (max-width: 480px) { /* fine-tune for small phones */ }

ADDITIONAL UX RULES:
- Add html { scroll-behavior: smooth; } to global_css
- All non-hero images: add loading="lazy" attribute
- Heading hierarchy: h1 in hero only, h2 for section headings, h3 for cards
- Sticky nav: add padding-top to the first content section equal to nav height to prevent overlap
- Trust signals in hero: ratings, certifications, years in business — visible above the fold
- CTA placement: hero section + after features/services + footer
- Empty/error states: if a grid has placeholder items, add real content or leave them out
"""


def analyze(screenshot_b64: str, html: str, url: str, style: str = None) -> dict:
    """
    Call Claude Vision with the screenshot and HTML (or image mockup).
    Returns parsed dict: { theme_name, theme_slug, global_css, body_html, images, ... }

    When url starts with '[Local image:' there is no source website — Claude will
    infer the business and design entirely from the image.
    """
    is_image_mode = url.startswith("[Local image:")

    if is_image_mode:
        user_text = (
            "The client has provided a photo of their paper design mockup (no existing website). "
            "Study the image carefully — extract the business name, colors, content, layout, "
            "and brand identity from what is shown. Design a complete, professional WordPress theme "
            "based on these designs. Infer any missing details (phone, address, services) from context "
            "and use realistic placeholder text in the {{field_name|default}} format so the client "
            "can fill them in via the WordPress Customizer.\n\n"
            "Remember: EVERY piece of visible text must use the {{field_name|default}} syntax."
        )
    else:
        truncated_html = _truncate_html(html)
        user_text = (
            f"Source site URL: {url}\n\n"
            f"HTML (truncated to {_HTML_LIMIT} chars):\n"
            f"{truncated_html}\n\n"
            "Study this site's content and brand, then design a beautiful, modern "
            "WordPress theme inspired by it. Make it stunning — better than the original. "
            "Extract all real content and elevate the design. "
            "Remember: EVERY piece of visible text must use the {{field_name|default}} syntax."
        )

    if style:
        user_text += (
            f"\n\nSTYLE DIRECTIVE: The client has requested this specific aesthetic: "
            f'"{style}". Apply this style throughout — colors, typography, layout, '
            f"and tone should all reflect it."
        )

    print("[ai] Sending to Claude for theme design...")

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
                            "media_type": "image/jpeg",
                            "data": screenshot_b64,
                        },
                    },
                    {
                        "type": "text",
                        "text": user_text,
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

    sections = result.get("sections", [])
    images = result.get("images", [])
    print(f"[ai] Theme design complete. Sections: {len(sections)} | Images: {len(images)}")
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
              "The theme may be incomplete. Consider running again.")
        return result
    except json.JSONDecodeError as e:
        raise ValueError(
            f"Claude returned invalid JSON that could not be repaired: {e}\n\n"
            f"Raw response (first 500 chars):\n{text[:500]}"
        )


def _repair_truncated_json(text: str) -> str:
    """Close any open JSON structures so a truncated response can be parsed."""
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
