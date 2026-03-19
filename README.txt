WORDPRESS SITE BOT
==================
One tool:

  THEME BUILDER  (main.py) — Scrapes a URL and generates a full installable WordPress
                              theme (.zip) inspired by the site. Saved to created-themes/

  (Page Builder, Theme Editor, and Page Editor are archived in archive/ for future use.)


FIRST-TIME SETUP
----------------
1. Set up your Python environment (one time only):
   cd "/Users/asarosenberg_1/VSCode Projects/wordpress-site-bot"
   python3 -m venv venv
   source venv/bin/activate
   pip3 install -r requirements.txt
   python3 -m playwright install chromium

2. Your .env file is already configured with your Anthropic API key and WP credentials.


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
THEME BUILDER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Generates a complete, installable WordPress .zip theme with:
  - style.css      (theme header + global CSS with brand colors)
  - functions.php  (theme setup, style enqueue)
  - header.php     (top bar + navigation — shown on every page)
  - footer.php     (site footer — shown on every page)
  - front-page.php (homepage: hero, services, CTA, etc.)
  - page.php       (inner pages template — full-width, content-managed layout)
  - index.php      (fallback template)
  - images/        (all images downloaded from source)

RUNNING
-------
1. Activate the virtual environment (every new terminal session):
   source venv/bin/activate

2. Run:
   python3 main.py --url https://example.com

   Themes are saved to created-themes/ by default.
   Optional — save zip to a specific folder (e.g. Desktop):
   python3 main.py --url https://example.com --output ~/Desktop

3. A browser window opens showing a screenshot and a summary of the
   theme Claude designed (sections, brand colors, images, API cost).

4. Click "Approve & Build Theme .zip" to generate, or "Skip" to cancel.

5. On approval, the bot will:
   - Download all images from the source site
   - Generate all PHP/CSS theme files
   - Package everything into a .zip file
   - Print the zip location in the terminal

INSTALLING THE THEME
--------------------
1. WP Admin → Appearance → Themes → Add New
2. Click "Upload Theme"
3. Select the generated .zip file
4. Click "Install Now" → "Activate"

The site's front page will immediately reflect the generated theme.
New pages you create will automatically inherit the nav and footer.

OPTIONS
-------
--url     (required) The URL to analyze
--output  Directory to save the .zip (default: created-themes/)
--style   Optional design style directive. Tells Claude the aesthetic to apply.
          If omitted, Claude decides the style based on the source site (default behavior).

          Examples:
            python3 main.py --url https://example.com --style "luxury, dark, editorial"
            python3 main.py --url https://example.com --style "playful, colorful, Gen-Z"
            python3 main.py --url https://example.com --style "minimal, corporate, law firm"
            python3 main.py --url https://example.com --style "bold, industrial, contractor"
            python3 main.py --url https://example.com --style "warm, approachable, therapist"


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DESIGN QUALITY
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Every generated theme automatically enforces:

  - WCAG AA contrast (4.5:1 minimum ratio)
  - Transition timing: 150–300ms for all hover/interactive effects
  - prefers-reduced-motion: animations disabled for users who prefer it
  - Keyboard focus: visible :focus-visible outline on all interactive elements
  - Touch targets: minimum 44×44px on all buttons and links
  - Responsive: breakpoints at 480px and 768px (grid stacking, nav collapse)
  - Smooth scroll, lazy-loaded images, proper heading hierarchy (h1 → h2 → h3)


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
NOTES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
- Claude redesigns the site — it's inspired by the source, not a pixel-perfect copy.
- If an image fails to download, the bot falls back to the original URL.
- Re-run the command to generate a fresh result at any time.
