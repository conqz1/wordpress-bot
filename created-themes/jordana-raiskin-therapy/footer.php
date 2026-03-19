<footer style="background:var(--color-secondary);padding:80px 0 40px;color:#fff;">
  <div class="container">
    <div class="footer-grid" style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:60px;margin-bottom:60px;">
      <div>
        <div style="margin-bottom:20px;">
          <span style="font-family:Georgia,serif;font-size:24px;color:var(--color-primary);font-weight:400;">jordana raiskin</span>
          <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:12px;text-transform:uppercase;letter-spacing:0.15em;color:rgba(255,255,255,0.5);display:block;margin-top:4px;">LCSW · Psychotherapy</span>
        </div>
        <p style="opacity:0.6;line-height:1.8;max-width:320px;font-size:15px;"><?php echo esc_html( get_theme_mod( 'footer_description', 'Helping individuals in Austin, Texas navigate life\'s challenges and discover a more vibrant, connected, purposeful way of living.' ) ); ?></p>
      </div>
      <div>
        <h4 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:700;margin-bottom:20px;font-size:14px;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-primary);">Navigate</h4>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <a href="/" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">Home</a>
          <a href="/about-me/" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">About Me</a>
          <a href="/about-therapy/" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">About Therapy</a>
          <a href="/contact/" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;min-height:44px;display:flex;align-items:center;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">Contact</a>
        </div>
      </div>
      <div>
        <h4 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-weight:700;margin-bottom:20px;font-size:14px;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-primary);">Get in Touch</h4>
        <div style="opacity:0.7;font-size:15px;line-height:2.2;">
          <p><?php echo esc_html( get_theme_mod( 'footer_location', 'Austin, Texas' ) ); ?></p>
          <p><?php echo esc_html( get_theme_mod( 'footer_credentials', 'Licensed Clinical Social Worker' ) ); ?></p>
          <a href="/contact/" style="color:var(--color-accent);opacity:1;font-weight:600;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"><?php echo esc_html( get_theme_mod( 'footer_contact_link', 'Send a Message →' ) ); ?></a>
        </div>
      </div>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:32px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
      <p style="opacity:0.4;font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">© <?php echo date('Y'); ?> <?php echo esc_html( get_theme_mod( 'footer_copyright', 'Jordana Raiskin LCSW' ) ); ?>. All rights reserved.</p>
      <p style="opacity:0.4;font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;"><?php echo esc_html( get_theme_mod( 'footer_tagline', 'Life should be more than just coping.' ) ); ?></p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
