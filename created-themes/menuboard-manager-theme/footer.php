<footer style="background:var(--color-dark);padding:80px 0 40px;color:#fff;">
  <div class="container">
    <div class="footer-grid" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:60px;">
      <div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/logo-white.webp" alt="Menuboard Manager" style="height:44px;margin-bottom:20px;" loading="lazy"/>
        <p style="opacity:0.6;line-height:1.7;max-width:300px;font-size:15px;"><?php echo esc_html( get_theme_mod( 'footer_desc', 'Elevate your restaurant with stunning digital menu boards. Easy to update, fully customizable, and integrated with POS systems like Toast®.' ) ); ?></p>
        <div style="display:flex;gap:12px;margin-top:20px;">
          <a href="#" style="width:40px;height:40px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;transition:background 0.2s;" onmouseover="this.style.background='var(--color-secondary)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" aria-label="Facebook">f</a>
          <a href="#" style="width:40px;height:40px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;transition:background 0.2s;" onmouseover="this.style.background='var(--color-secondary)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" aria-label="Instagram">ig</a>
          <a href="#" style="width:40px;height:40px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;transition:background 0.2s;" onmouseover="this.style.background='var(--color-secondary)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'" aria-label="LinkedIn">in</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Product</h4>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <a href="#features" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Features</a>
          <a href="#pricing" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Pricing</a>
          <a href="#case-studies" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Case Studies</a>
          <a href="/shop" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Shop Hardware</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Resources</h4>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <a href="#how-it-works" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">How It Works</a>
          <a href="#" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Blog</a>
          <a href="#" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Support</a>
          <a href="#" style="color:rgba(255,255,255,0.65);font-size:15px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">FAQ</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Contact</h4>
        <div style="font-size:15px;line-height:2.2;">
          <p style="opacity:0.65;"><?php echo esc_html( get_theme_mod( 'footer_email', 'hello@menuboardmanager.com' ) ); ?></p>
          <p style="opacity:0.65;"><?php echo esc_html( get_theme_mod( 'footer_phone', '(800) 555-MENU' ) ); ?></p>
          <a href="#contact" class="btn btn-primary" style="margin-top:12px;padding:10px 24px;font-size:14px;"><?php echo esc_html( get_theme_mod( 'footer_cta', 'Get Started' ) ); ?></a>
        </div>
      </div>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:32px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
      <p style="opacity:0.45;font-size:14px;">© <?php echo date('Y'); ?> <?php echo esc_html( get_theme_mod( 'footer_company', 'Menuboard Manager' ) ); ?>. All rights reserved.</p>
      <div style="display:flex;gap:24px;">
        <a href="#" style="color:rgba(255,255,255,0.45);font-size:13px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">Privacy Policy</a>
        <a href="#" style="color:rgba(255,255,255,0.45);font-size:13px;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
