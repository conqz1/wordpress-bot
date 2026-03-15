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
<div style="background:var(--color-secondary);padding:10px 0;">
  <div class="container topbar-inner" style="display:flex;justify-content:space-between;align-items:center;color:#fff;font-size:13px;flex-wrap:nowrap;gap:16px;">
    <span style="white-space:nowrap;opacity:0.8;">Powering 5+ million websites worldwide</span>
    <div style="display:flex;align-items:center;gap:20px;white-space:nowrap;">
      <a href="#plans" style="color:#fff;opacity:0.8;transition:opacity 0.2s;font-size:13px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Ready to find the plan that fits your needs?</a>
      <strong style="font-size:14px;color:var(--color-accent);">Call +1 (877) 972-8480</strong>
    </div>
  </div>
</div>
<nav style="background:var(--color-white);padding:0;position:sticky;top:0;z-index:1000;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:72px;">
    <a href="/" style="display:flex;align-items:center;gap:8px;min-height:44px;min-width:44px;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="WP Engine" style="height:36px;width:auto;"/>
    </a>
    <div class="nav-links" style="display:flex;gap:28px;align-items:center;">
      <a href="#platform" style="color:var(--color-secondary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-secondary)'">Platform</a>
      <a href="#solutions" style="color:var(--color-secondary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-secondary)'">Solutions</a>
      <a href="#resources" style="color:var(--color-secondary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-secondary)'">Resources</a>
      <a href="#pricing" style="color:var(--color-secondary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-secondary)'">Pricing</a>
      <a href="#login" style="color:var(--color-secondary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-secondary)'">Log In</a>
      <a href="#get-started" class="btn btn-primary" style="white-space:nowrap;padding:10px 24px;font-size:14px;display:inline-flex;align-items:center;justify-content:center;line-height:1.2;">Get Started</a>
    </div>
    <button class="mobile-menu-btn" style="display:none;background:none;border:none;cursor:pointer;padding:10px;min-height:44px;min-width:44px;align-items:center;justify-content:center;" aria-label="Menu">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
</nav>
