"""
Local Flask approval UI.
Shows a screenshot of the scraped page and a summary of the WordPress theme
that will be generated. User can Approve or Skip.
"""
import threading
import webbrowser
from flask import Flask, jsonify, render_template, request

import config

app = Flask(__name__)

# Shared state — set before starting the server
_state: dict = {
    "mode": "theme",     # "theme" | "page"
    "page": None,        # ScrapedPage
    "analysis": None,    # dict from ai.analyzer or ai.page_analyzer
    "decision": None,    # "approve" | "skip"
    "done": threading.Event(),
}


def run_approval_ui(scraped_page, analysis: dict) -> str:
    """
    Start the Flask server, open the browser, wait for user decision.
    Returns "approve" or "skip".
    """
    _state["mode"] = "theme"
    _state["page"] = scraped_page
    _state["analysis"] = analysis
    _state["decision"] = None
    _state["done"].clear()

    server_thread = threading.Thread(
        target=lambda: app.run(
            port=config.UI_PORT,
            debug=False,
            use_reloader=False,
        ),
        daemon=True,
    )
    server_thread.start()

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


def run_page_approval_ui(scraped_page, analysis: dict) -> str:
    """
    Start the Flask server in page mode, open the browser, wait for user decision.
    Returns "approve" or "skip".
    """
    _state["mode"] = "page"
    _state["page"] = scraped_page
    _state["analysis"] = analysis
    _state["decision"] = None
    _state["done"].clear()

    server_thread = threading.Thread(
        target=lambda: app.run(
            port=config.UI_PORT,
            debug=False,
            use_reloader=False,
        ),
        daemon=True,
    )
    server_thread.start()

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
    mode = _state["mode"]

    images = analysis.get("images", [])
    sections = analysis.get("sections", [])
    usage = analysis.get("_usage", {})
    common = dict(
        url=page.url,
        screenshot_data_uri=f"data:image/png;base64,{page.screenshot_b64}",
        sections=sections,
        image_count=len(images),
        section_count=len(sections),
        input_tokens=f"{usage.get('input_tokens', 0):,}",
        output_tokens=f"{usage.get('output_tokens', 0):,}",
        cost_usd=f"${usage.get('cost_usd', 0):.4f}",
    )

    if mode == "page":
        return render_template(
            "page_review.html",
            title=analysis.get("page_title", page.title),
            **common,
        )

    colors = [
        analysis.get("primary_color", ""),
        analysis.get("secondary_color", ""),
        analysis.get("accent_color", ""),
    ]
    colors = [c for c in colors if c]
    return render_template(
        "review.html",
        title=analysis.get("theme_name", page.title),
        description=analysis.get("description", ""),
        colors=colors,
        **common,
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
    from flask import send_file
    return send_file(_state["page"].screenshot_path, mimetype="image/png")
