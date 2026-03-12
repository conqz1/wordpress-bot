ELEMENTOR BOT
=============
Scrapes a URL, analyzes it with Claude Vision, and recreates it as an Elementor page in WordPress.


FIRST-TIME SETUP
----------------
1. Install the WordPress mu-plugin:
   - Copy setup/elementor-rest-api.php to your WordPress folder:
     wp-content/mu-plugins/elementor-rest-api.php
   - Create the mu-plugins folder if it doesn't exist.
   - No activation needed — it loads automatically.

2. Set up your Python environment (one time only):
   cd "/Users/asarosenberg_1/VSCode Projects/elementor-bot"
   python3 -m venv venv
   source venv/bin/activate
   pip3 install -r requirements.txt
   python3 -m playwright install chromium

3. Your .env file is already configured with your credentials.


RUNNING THE BOT
---------------
1. Activate the virtual environment (every new terminal session):
   source venv/bin/activate

2. Run:
   python3 main.py --url https://example.com

3. A browser window will open showing a screenshot of the page
   and a breakdown of the Elementor layout Claude detected.

4. Click "Approve" to create the page in WordPress, or "Skip" to cancel.

5. On approval, the bot will:
   - Download and upload all images to your WordPress media library
   - Create the page in WordPress with Elementor data
   - Print the page URL and Elementor editor link in the terminal


OPTIONS
-------
--url     (required) The URL to clone
--status  draft (default) or publish

Example:
   python3 main.py --url https://example.com --status publish


NOTES
-----
- Pages are created as drafts by default so you can review in Elementor before publishing.
- The Elementor editor link is printed in the terminal after creation.
- If an image fails to upload, the bot falls back to the original URL.
