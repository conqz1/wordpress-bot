import os
from dotenv import load_dotenv

load_dotenv()

ANTHROPIC_API_KEY = os.environ["ANTHROPIC_API_KEY"]

WP_SITE_URL = os.environ["WP_SITE_URL"].rstrip("/")
WP_USERNAME = os.environ["WP_USERNAME"]
WP_APP_PASSWORD = os.environ["WP_APP_PASSWORD"]

UI_PORT = int(os.getenv("UI_PORT", 5050))
SCREENSHOT_WIDTH = int(os.getenv("SCREENSHOT_WIDTH", 1440))
SCREENSHOT_HEIGHT = int(os.getenv("SCREENSHOT_HEIGHT", 900))
