<footer style="background:var(--color-secondary);padding:80px 0 40px;color:#fff;">
  <div class="container">
    <div class="footer-grid" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:50px;margin-bottom:60px;">
      <div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Gardenhouse Plumbing" loading="lazy" style="height:52px;margin-bottom:20px;filter:brightness(0) invert(1);"/>
        <p style="opacity:0.65;line-height:1.8;max-width:300px;font-size:15px;">Professional plumbing services in Austin, TX. Over 45 years of experience delivering fast, transparent, and reliable service.</p>
        <div style="display:flex;gap:12px;margin-top:24px;">
          <a href="https://www.facebook.com" target="_blank" rel="noopener" aria-label="Facebook" style="width:44px;height:44px;background:rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;transition:background 0.2s;" onmouseover="this.style.background='var(--color-accent)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">f</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Services</h4>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <a href="/cast-iron-repiping" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Cast Iron Repiping</a>
          <a href="/leak-detection" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Leak Detection</a>
          <a href="/hydrostatic-testing" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Hydrostatic Testing</a>
          <a href="/sewer-mapping" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Sewer Mapping</a>
          <a href="/water-heaters" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Water Heaters</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Company</h4>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <a href="/our-company" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Our Company</a>
          <a href="/resources" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Resources</a>
          <a href="/contact-us" style="color:#fff;font-size:15px;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">Contact Us</a>
        </div>
      </div>
      <div>
        <h4 style="font-weight:700;margin-bottom:20px;font-size:16px;">Contact</h4>
        <div style="font-size:15px;line-height:2.2;opacity:0.75;">
          <p>1000 Meredith Dr</p>
          <p>Austin, TX 78748</p>
          <p style="margin-top:8px;"><a href="tel:5125031080" style="color:#fff;font-weight:600;opacity:1;">(512) 503-1080</a></p>
        </div>
      </div>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:32px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <p style="opacity:0.5;font-size:14px;">© <?php echo date('Y'); ?> Gardenhouse Plumbing. All Rights Reserved.</p>
      <div style="display:flex;gap:24px;opacity:0.5;font-size:14px;">
        <a href="/" style="color:#fff;">Privacy Policy</a>
        <a href="/" style="color:#fff;">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
