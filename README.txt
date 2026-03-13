WORDPRESS SITE BOT
==================
Two tools in one:

  THEME BUILDER (main.py) — Scrapes a URL, analyzes it with Claude Vision, and generates
  a beautiful installable WordPress theme (.zip) inspired by the site.

  PAGE BUILDER (page.py) — Scrapes any page URL, redesigns the content with Claude Vision,
  and creates it as a draft WordPress page on your site via the REST API.


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


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PAGE BUILDER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Scrapes any page URL, redesigns the content as a beautiful full-width
HTML page, uploads images to your WP media library, and creates the
page as a draft on your WordPress site.

The active theme provides the navigation and footer — the page builder
generates only the page body content (hero banner, feature grids, CTAs, etc.).

RUNNING
-------
1. Activate the virtual environment (every new terminal session):
   source venv/bin/activate

2. Run:
   python3 page.py --url https://example.com/about

3. A browser window opens showing a screenshot and a summary of the
   page Claude designed (sections, images, API cost).

4. Click "Create Page on WordPress (Draft)" to create, or "Skip" to cancel.

5. On approval, the bot will:
   - Upload all images to your WordPress media library
   - Create the page as a draft on your WP site
   - Print the draft page URL in the terminal

PUBLISHING THE PAGE
-------------------
1. WP Admin → Pages → find the draft
2. Click Edit → Publish

OPTIONS
-------
--url     (required) The URL of the page to copy


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
NOTES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
- Claude redesigns the site/page — it's inspired by the source, not a pixel-perfect copy.
- If an image fails to download, the bot falls back to the original URL.
- Re-run either command to generate a fresh result.
- The Page Builder requires your WordPress credentials in .env (WP_SITE_URL, WP_USERNAME,
  WP_APP_PASSWORD). The Theme Builder does not.
