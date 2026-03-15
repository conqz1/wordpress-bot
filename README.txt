WORDPRESS SITE BOT
==================
Four tools:

  THEME BUILDER  (main.py)    — Scrapes a URL and generates a full installable WordPress
                                 theme (.zip) inspired by the site. Saved to created-themes/

  PAGE BUILDER   (page.py)    — Scrapes any page URL, redesigns the content with Claude
                                 Vision, and creates it as a draft WordPress page via REST API.

  THEME EDITOR   (edit.py)    — Chat with Claude to surgically edit a generated theme.
                                 Re-zips automatically after each change.

  PAGE EDITOR    (wp-edit.py) — Chat with Claude to edit any live WordPress page.
                                 Changes pushed live via REST API after each request.


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
THEME EDITOR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Chat with Claude in the terminal to make surgical edits to a generated theme.
Changes are applied directly to the theme folder and re-zipped automatically.

RUNNING
-------
1. Activate the virtual environment:
   source venv/bin/activate

2. Run (theme must have been built with main.py first):
   python3 edit.py --theme league-electric-theme

3. Type change requests in plain English:
   You: change the primary color to deep navy blue
   You: make the hero headline bigger
   You: add a thin red border under the nav bar
   You: exit

4. After each change:
   - The relevant theme file is edited surgically (only what you asked for)
   - The theme folder is re-zipped automatically
   - Re-upload the zip to WordPress to see the changes live

OPTIONS
-------
--theme   Theme folder name inside created-themes/, or a full path


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PAGE EDITOR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Chat with Claude to edit any live page on your WordPress site.
Claude sees a screenshot of the page + its HTML, makes surgical edits,
and pushes each change live via the REST API immediately.

Works on any WordPress page — not just ones created by this bot.

RUNNING
-------
1. Activate the virtual environment:
   source venv/bin/activate

2. Run:
   python3 wp-edit.py --url https://automai.ai/meet-the-team

3. Type change requests in plain English:
   You: change the heading "The People Behind League Electric" to "Our Expert Team"
   You: make the hero banner background darker — use #1a2040
   You: change the hero image to https://images.unsplash.com/photo-xyz.jpg
   You: exit

4. Each change is pushed live to WordPress immediately after Claude applies it.

IMAGE CHANGES
-------------
- Provide a direct image URL:  Claude replaces the src and uploads it to your WP media library
- Provide a local file path:   python will upload the file first, then use the hosted WP URL
  Example: "change the hero image to ~/Desktop/new-photo.jpg"

SPECIAL COMMANDS
----------------
refresh screenshot   — take a new screenshot so Claude can see recent changes

OPTIONS
-------
--url   (required) Full URL of the WordPress page to edit


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DESIGN QUALITY
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Both tools use design guidelines sourced from UI UX Pro Max (github.com/nextlevelbuilder/ui-ux-pro-max-skill)
incorporated directly into the AI prompts. Every generated theme and page automatically enforces:

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
- Claude redesigns the site/page — it's inspired by the source, not a pixel-perfect copy.
- If an image fails to download, the bot falls back to the original URL.
- Re-run either command to generate a fresh result.
- The Page Builder requires your WordPress credentials in .env (WP_SITE_URL, WP_USERNAME,
  WP_APP_PASSWORD). The Theme Builder does not.
