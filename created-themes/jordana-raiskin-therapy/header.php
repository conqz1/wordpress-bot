<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<nav style="background:#fff;padding:0;position:sticky;top:0;z-index:999;box-shadow:0 1px 12px rgba(0,0,0,0.06);">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:80px;position:relative;">
    <a href="/" style="display:flex;flex-direction:column;line-height:1.2;">
      <span style="font-family:Georgia,serif;font-size:26px;color:var(--color-primary);font-weight:400;letter-spacing:0.02em;">jordana raiskin</span>
      <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:11px;text-transform:uppercase;letter-spacing:0.2em;color:var(--color-text-light);font-weight:600;">LCSW · Psychotherapy</span>
    </a>
    <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')" aria-label="Toggle navigation">
      <span></span><span></span><span></span>
    </button>
    <div class="nav-links" style="display:flex;gap:8px;align-items:center;">
      <a href="/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 16px;border-radius:8px;transition:background 0.2s,color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.background='var(--color-light)'" onmouseout="this.style.background='transparent'">Home</a>
      <a href="/about-me/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 16px;border-radius:8px;transition:background 0.2s,color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.background='var(--color-light)'" onmouseout="this.style.background='transparent'">About Me</a>
      <a href="/about-therapy/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 16px;border-radius:8px;transition:background 0.2s,color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.background='var(--color-light)'" onmouseout="this.style.background='transparent'">About Therapy</a>
      <a href="/contact/" class="btn btn-primary" style="margin-left:8px;">Contact Me</a>
    </div>
  </div>
</nav>
