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
<nav style="position:fixed;top:0;left:0;right:0;z-index:1000;background:#fff;box-shadow:0 1px 12px rgba(0,0,0,0.06);height:var(--nav-height);">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:100%;">
    <a href="/" style="display:flex;flex-direction:column;line-height:1.2;">
      <span style="font-family:Georgia,'Times New Roman',serif;font-size:26px;color:var(--color-secondary);font-weight:400;letter-spacing:0.02em;">jordana raiskin<span style="font-size:12px;color:var(--color-text-light);vertical-align:super;margin-left:2px;">LCSW</span></span>
      <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.18em;color:var(--color-primary);margin-top:2px;">psychotherapy</span>
    </a>
    <button class="mobile-menu-toggle" aria-label="Toggle navigation menu" onclick="document.querySelector('.nav-links').classList.toggle('active')">
      <span></span><span></span><span></span>
    </button>
    <div class="nav-links" style="display:flex;gap:36px;align-items:center;">
      <a href="/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 0;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-text)'">Home</a>
      <a href="/about-me/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 0;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-text)'">About Me</a>
      <a href="/about-therapy/" style="color:var(--color-text);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:500;font-size:15px;padding:10px 0;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-text)'">About Therapy</a>
      <a href="/contact/" class="btn btn-primary" style="padding:10px 28px;font-size:14px;">Contact Me</a>
    </div>
  </div>
</nav>
