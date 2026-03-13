WORDPRESS SITE BOT
==================
Scrapes a URL, analyzes it with Claude Vision, and recreates it as a native
Gutenberg block page in WordPress. No Elementor required.


FIRST-TIME SETUP
----------------
1. Set up your Python environment (one time only):
   cd "/Users/asarosenberg_1/VSCode Projects/wordpress-site-bot"
   python3 -m venv venv
   source venv/bin/activate
   pip3 install -r requirements.txt
   python3 -m playwright install chromium

2. Your .env file is already configured with your credentials
   (site: https://automai.ai).

No WordPress plugins or mu-plugins needed.


RUNNING THE BOT
---------------
1. Activate the virtual environment (every new terminal session):
   source venv/bin/activate

2. Run:
   python3 main.py --url https://example.com

3. A browser window will open showing a screenshot of the page
   and a breakdown of the Gutenberg blocks Claude detected.

4. Click "Approve" to create the page in WordPress, or "Skip" to cancel.

5. On approval, the bot will:
   - Download and upload all images to your WordPress media library
   - Create the page in WordPress using native Gutenberg block markup
   - Print the page URL and WordPress editor link in the terminal


OPTIONS
-------
--url     (required) The URL to clone
--status  draft (default) or publish

Example:
   python3 main.py --url https://example.com --status publish


NOTES
-----
- Pages are created as drafts by default so you can review in WordPress before publishing.
- The WordPress editor link is printed in the terminal after creation.
- If an image fails to upload, the bot falls back to the original URL.
