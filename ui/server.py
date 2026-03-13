"""
Local Flask approval UI.
Shows a screenshot of the scraped page and a summary of the Gutenberg
blocks that will be created. User can Approve or Skip.
"""
import re
import threading
import webbrowser
from flask import Flask, jsonify, render_template, request

import config

app = Flask(__name__)

# Shared state — set before starting the server
_state: dict = {
    "page": None,        # ScrapedPage
    "analysis": None,    # dict from ai.analyzer
    "decision": None,    # "approve" | "skip"
    "done": threading.Event(),
}


def run_approval_ui(scraped_page, analysis: dict) -> str:
    """
    Start the Flask server, open the browser, wait for user decision.
    Returns "approve" or "skip".
    """
    _state["page"] = scraped_page
    _state["analysis"] = analysis
    _state["decision"] = None
    _state["done"].clear()

    # Start server in a background thread
    server_thread = threading.Thread(
        target=lambda: app.run(
            port=config.UI_PORT,
            debug=False,
            use_reloader=False,
        ),
        daemon=True,
    )
    server_thread.start()

    # Wait for Flask to be ready before opening the browser
    import time
    url = f"http://localhost:{config.UI_PORT}"
    for _ in range(20):
        try:
            import urllib.request
            urllib.request.urlopen(url, timeout=1)
            break
        except Exception:
            time.sleep(0.25)

    print(f"[ui] Opening approval UI at {url}")
    webbrowser.open(url)

    _state["done"].wait()
    return _state["decision"]


@app.route("/")
def index():
    page = _state["page"]
    analysis = _state["analysis"]

    block_content = analysis.get("block_content", "")
    widget_summary = _build_block_summary(block_content)
    block_count = len(re.findall(r"<!-- wp:", block_content))
    images = analysis.get("images", [])

    usage = analysis.get("_usage", {})
    return render_template(
        "review.html",
        url=page.url,
        title=analysis.get("page_title", page.title),
        screenshot_data_uri=f"data:image/png;base64,{page.screenshot_b64}",
        widget_summary=widget_summary,
        image_count=len(images),
        section_count=block_count,
        input_tokens=f"{usage.get('input_tokens', 0):,}",
        output_tokens=f"{usage.get('output_tokens', 0):,}",
        cost_usd=f"${usage.get('cost_usd', 0):.4f}",
    )


@app.route("/decide", methods=["POST"])
def decide():
    decision = request.json.get("decision")
    if decision not in ("approve", "skip"):
        return jsonify({"error": "invalid decision"}), 400
    _state["decision"] = decision
    _state["done"].set()
    return jsonify({"ok": True})


@app.route("/screenshot")
def screenshot():
    """Serve the screenshot PNG directly."""
    from flask import send_file
    return send_file(_state["page"].screenshot_path, mimetype="image/png")


def _build_block_summary(block_content: str) -> list[dict]:
    """Parse Gutenberg block markup into a human-readable summary grouped by top-level blocks."""
    summary = []
    depth = 0
    section_num = 0

    for match in re.finditer(r"<!--\s*(/?)wp:([\w/-]+)", block_content):
        is_closing = bool(match.group(1))
        block_type = match.group(2)

        if is_closing:
            depth = max(0, depth - 1)
        else:
            if depth == 0:
                section_num += 1
                summary.append({"section": section_num, "widgets": [{"type": block_type, "label": ""}]})
            elif depth == 1 and summary:
                summary[-1]["widgets"].append({"type": block_type, "label": ""})
            depth += 1

    return summary
