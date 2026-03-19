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
<!-- Top Bar -->
<div style="background:var(--color-secondary);padding:10px 0;">
  <div class="container topbar-inner" style="display:flex;justify-content:space-between;align-items:center;color:#fff;font-size:14px;flex-wrap:nowrap;gap:16px;">
    <span style="white-space:nowrap;display:flex;align-items:center;gap:6px;"><span style="color:#F59E0B;">★★★★★</span> <strong>5.0</strong> Rated on Google</span>
    <span style="white-space:nowrap;">🔧 Serving Austin, Kyle &amp; Surrounding Areas</span>
    <div style="display:flex;align-items:center;gap:14px;white-space:nowrap;">
      <a href="tel:5125031080" style="color:#fff;font-weight:700;font-size:16px;display:flex;align-items:center;gap:6px;min-height:44px;">📞 (512) 503-1080</a>
      <a href="/contact-us" class="btn btn-primary" style="padding:8px 22px;font-size:14px;">Contact Us</a>
    </div>
  </div>
</div>
<!-- Navigation -->
<nav style="background:var(--color-primary);padding:0;position:sticky;top:0;z-index:1000;box-shadow:0 2px 16px rgba(0,0,0,0.1);">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;height:72px;">
    <a href="/" style="display:flex;align-items:center;min-height:44px;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Gardenhouse Plumbing" style="height:50px;width:auto;filter:brightness(0) invert(1);"/>
    </a>
    <div class="desktop-nav-links" style="display:flex;gap:24px;align-items:center;">
      <a href="/" class="nav-link">Home</a>
      <a href="/our-company" class="nav-link">Our Company</a>
      <a href="/cast-iron-repiping" class="nav-link">Cast Iron Repiping</a>
      <a href="/leak-detection" class="nav-link">Leak Detection</a>
      <a href="/hydrostatic-testing" class="nav-link">Hydrostatic Testing</a>
      <a href="/sewer-mapping" class="nav-link">Sewer Mapping</a>
      <a href="/water-heaters" class="nav-link">Water Heaters</a>
      <a href="/contact-us" class="btn btn-primary" style="padding:10px 24px;font-size:14px;white-space:nowrap;">Get a Quote</a>
    </div>
    <button class="hamburger-btn" aria-label="Open menu" onclick="document.getElementById('mobileMenu').classList.toggle('active');">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div id="mobileMenu" class="mobile-menu">
    <a href="/">Home</a>
    <a href="/our-company">Our Company</a>
    <a href="/cast-iron-repiping">Cast Iron Repiping</a>
    <a href="/leak-detection">Leak Detection</a>
    <a href="/hydrostatic-testing">Hydrostatic Testing</a>
    <a href="/sewer-mapping">Sewer Mapping</a>
    <a href="/water-heaters">Water Heaters</a>
    <a href="/resources">Resources</a>
    <a href="/contact-us">Contact Us</a>
    <a href="tel:5125031080" style="color:var(--color-accent);font-weight:700;">📞 (512) 503-1080</a>
  </div>
</nav>
