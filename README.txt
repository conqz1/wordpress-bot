WORDPRESS SITE BOT
==================
Two tools:

  THEME BUILDER  (main.py)    — Generates a full installable WordPress theme (.zip) from
                                 a URL or a local image (paper mockup / hand-drawn design).
                                 Saved to created-themes/

  PAGE BUILDER   (add_page.py) — Adds a new inner page (About, Contact, Services, etc.)
                                 to an existing WordPress site — no theme re-upload needed.
                                 Claude designs the page to match the installed theme, then
                                 pushes it to WordPress via the REST API as Gutenberg blocks.

  (Page Editor and Theme Editor are archived in archive/ for future use.)


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

2. Run with a URL (existing website):
   python3 main.py --url https://example.com

   Or run with a local image (paper mockup / client design scan):
   python3 main.py --image ~/Desktop/client-mockup.jpg

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
--url     URL of the site to analyze (mutually exclusive with --image)
--image   Path to a local image file — use when the client has no existing website
          and provides paper mockups, sketches, or scanned designs instead
--output  Directory to save the .zip (default: created-themes/)
--style   Optional design style directive. Tells Claude the aesthetic to apply.
          If omitted, Claude decides the style based on the source (default behavior).

          Examples:
            python3 main.py --url https://example.com --style "luxury, dark, editorial"
            python3 main.py --url https://example.com --style "playful, colorful, Gen-Z"
            python3 main.py --image ~/Desktop/mockup.jpg --style "warm, approachable, therapist"
            python3 main.py --image ~/Desktop/mockup.jpg --style "bold, industrial, contractor"


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PAGE BUILDER
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Adds a new inner page to an existing WordPress site without touching the theme.
Claude designs the page body (header/footer come from the installed theme), then
pushes it to WordPress as Gutenberg wp:html blocks — one block per section so
the client can click into each section and edit text directly in the block editor.

RUNNING
-------
1. Make sure the theme is already installed on the WordPress site.

2. Activate the virtual environment:
   source venv/bin/activate

3. Add a page (auto-detects the most recently built theme):
   python3 add_page.py --page "About"
   python3 add_page.py --page "Contact"
   python3 add_page.py --page "Services"

   Reference an existing page to draw real content from:
   python3 add_page.py --page "About" --url https://example.com/about

   Target a specific theme (if you have multiple in created-themes/):
   python3 add_page.py --page "Services" --theme-slug my-theme-slug

   Publish immediately instead of saving as draft:
   python3 add_page.py --page "About" --status publish

4. The bot will:
   - Load brand colors and CSS variables from the installed theme
   - Optionally scrape and read the reference URL
   - Design the page with Claude (matching the existing theme's style)
   - Download and upload any images to the WordPress Media Library
   - Push the page to WordPress (default: draft so you can review first)
   - Print the WP Admin edit URL

5. Review the draft in WP Admin, then publish when ready.
   Add the page to your nav: WP Admin → Appearance → Menus.

OPTIONS
-------
--page          Page name, e.g. "About", "Contact", "Services"  (required)
--url           Optional reference URL to draw real content from
--theme-slug    Theme slug to match (auto-detects most recent if omitted)
--status        WordPress page status: draft (default) or publish
--style         Optional style directive, e.g. "warm, minimal"


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
