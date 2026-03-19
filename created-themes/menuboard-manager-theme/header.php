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
<div style="background:var(--color-dark);padding:10px 0;">
  <div class="container topbar-inner" style="display:flex;justify-content:space-between;align-items:center;color:#fff;font-size:14px;flex-wrap:wrap;gap:12px;">
    <span style="display:flex;align-items:center;gap:8px;white-space:nowrap;">⭐⭐⭐⭐⭐ <strong><?php echo esc_html( get_theme_mod( 'topbar_rating', '4.9 Stars' ) ); ?></strong> <?php echo esc_html( get_theme_mod( 'topbar_reviews', 'on Google Reviews' ) ); ?></span>
    <span style="white-space:nowrap;">🇺🇸 <?php echo esc_html( get_theme_mod( 'topbar_badge', 'Veteran-Owned Business' ) ); ?> &nbsp;|&nbsp; 🍞 <?php echo esc_html( get_theme_mod( 'topbar_integration', 'Official Toast® Integration Partner' ) ); ?></span>
    <div style="display:flex;align-items:center;gap:12px;white-space:nowrap;">
      <a href="tel:+1" class="btn btn-primary" style="padding:8px 20px;font-size:14px;"><?php echo esc_html( get_theme_mod( 'topbar_cta', 'Get Started Free' ) ); ?></a>
    </div>
  </div>
</div>
<nav style="background:#fff;padding:0;box-shadow:0 2px 20px rgba(0,0,0,0.08);position:sticky;top:0;z-index:1000;">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:76px;">
    <a href="/" style="display:flex;align-items:center;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.webp" alt="Menuboard Manager" style="height:44px;width:auto;"/>
    </a>
    <div class="desktop-nav" style="display:flex;gap:28px;align-items:center;">
      <a href="#features" style="color:var(--color-primary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;padding:10px 4px;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='var(--color-primary)'">Features</a>
      <a href="#pricing" style="color:var(--color-primary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;padding:10px 4px;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='var(--color-primary)'">Pricing</a>
      <a href="#case-studies" style="color:var(--color-primary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;padding:10px 4px;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='var(--color-primary)'">Case Studies</a>
      <a href="#how-it-works" style="color:var(--color-primary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;padding:10px 4px;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='var(--color-primary)'">How It Works</a>
      <a href="/shop" style="color:var(--color-primary);font-weight:500;font-size:15px;white-space:nowrap;transition:color 0.2s;padding:10px 4px;" onmouseover="this.style.color='var(--color-secondary)'" onmouseout="this.style.color='var(--color-primary)'">Shop</a>
      <a href="#contact" class="btn btn-primary" style="white-space:nowrap;padding:12px 28px;"><?php echo esc_html( get_theme_mod( 'nav_cta', 'Book a Demo' ) ); ?></a>
    </div>
    <button class="mobile-menu-toggle" style="display:none;background:none;border:none;cursor:pointer;padding:10px;min-height:44px;min-width:44px;" aria-label="Toggle menu">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
    </button>
  </div>
</nav>
