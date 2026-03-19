<?php
/**
 * The front page template.
 * Homepage content — hero, services, CTA, etc.
 */
get_header();
?>
<!-- Hero Section -->
<section style="position:relative;min-height:660px;display:flex;align-items:center;overflow:hidden;">
  <img src="__IMG_hero_bg__" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"/>
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(13,27,42,0.85) 0%,rgba(13,27,42,0.5) 60%,rgba(13,27,42,0.3) 100%);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;color:#fff;padding-top:100px;padding-bottom:100px;">
    <p class="section-label" style="color:#F59E0B;font-size:14px;">YOUR FIRST CHOICE FOR PLUMBING SERVICES IN THE AUSTIN AREA</p>
    <h1 class="hero-heading" style="font-size:56px;font-weight:800;line-height:1.08;margin-bottom:20px;max-width:700px;">We're Ready to<br>Take On Your Job</h1>
    <p style="font-size:20px;line-height:1.7;margin-bottom:12px;max-width:560px;opacity:0.92;">From leaks and clogged disposals to complete water heater repair, replacement, and installation — fast, transparent service you can trust.</p>
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:36px;">
      <span style="color:#F59E0B;font-size:18px;">★★★★★</span>
      <span style="font-size:15px;opacity:0.85;">45+ Years Experience · Licensed &amp; OSHA-Certified</span>
    </div>
    <div class="hero-buttons" style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="tel:5125031080" class="btn btn-primary" style="font-size:18px;padding:18px 40px;">Call (512) 503-1080</a>
      <a href="/contact-us" class="btn btn-secondary" style="font-size:18px;padding:18px 40px;border-color:#fff;color:#fff;">Get a Quote</a>
    </div>
  </div>
</section>

<!-- Services Grid -->
<section id="services" style="background:var(--color-light);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label">What We Do</p>
      <h2 class="section-title">Our Plumbing Services</h2>
      <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Expert solutions for every plumbing need in Austin and surrounding areas.</p>
    </div>
    <div class="services-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
      <div style="background:#fff;border-radius:14px;padding:36px 24px;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;text-align:center;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:64px;height:64px;background:rgba(26,93,171,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:30px;">🔧</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Cast Iron Repiping</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;margin-bottom:20px;">Replace old pipes before they fail. Modern repiping solutions for lasting results.</p>
        <a href="/cast-iron-repiping" class="btn btn-secondary" style="padding:10px 24px;font-size:14px;">Learn More</a>
      </div>
      <div style="background:#fff;border-radius:14px;padding:36px 24px;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;text-align:center;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:64px;height:64px;background:rgba(26,93,171,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:30px;">🔍</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Leak Detection</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;margin-bottom:20px;">We'll find hidden leaks quickly using modern diagnostic technology.</p>
        <a href="/leak-detection" class="btn btn-secondary" style="padding:10px 24px;font-size:14px;">Learn More</a>
      </div>
      <div style="background:#fff;border-radius:14px;padding:36px 24px;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;text-align:center;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:64px;height:64px;background:rgba(26,93,171,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:30px;">💧</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Hydrostatic Testing</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;margin-bottom:20px;">Trust us to test your system for leaks with precision pressure testing.</p>
        <a href="/hydrostatic-testing" class="btn btn-secondary" style="padding:10px 24px;font-size:14px;">Learn More</a>
      </div>
      <div style="background:#fff;border-radius:14px;padding:36px 24px;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;text-align:center;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:64px;height:64px;background:rgba(26,93,171,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:30px;">🗺️</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Sewer Mapping</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;margin-bottom:20px;">Know where your sewer lines run with detailed mapping services.</p>
        <a href="/sewer-mapping" class="btn btn-secondary" style="padding:10px 24px;font-size:14px;">Learn More</a>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="about" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div class="two-col-layout" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <p class="section-label">About Gardenhouse Plumbing</p>
        <h2 class="section-title">Expert Plumbing Services &amp; Water Heater Solutions in the Austin Area</h2>
        <p style="color:var(--color-text-light);line-height:1.8;margin-bottom:20px;max-width:65ch;">From leaks and clogged disposals to complete water heater repair, replacement, and installation, Gardenhouse Plumbing delivers fast, transparent service you can trust.</p>
        <p style="color:var(--color-text-light);line-height:1.8;margin-bottom:20px;max-width:65ch;">Do you need a new water heater installed or a reliable plumber to repair your current one? At Gardenhouse Plumbing, we specialize in water heater repair, replacement, and installation to keep your home or business running smoothly. From minor fixes to major upgrades, our experienced team is here to handle it all.</p>
        <p style="color:var(--color-text-light);line-height:1.8;margin-bottom:20px;max-width:65ch;">Based in Austin and Kyle, our crew prides itself on complete transparency. For larger or more complex issues, we use modern diagnostic visuals to clearly show you the problem and explain the exact steps we'll take to fix it.</p>
        <div style="display:flex;gap:16px;margin-top:32px;flex-wrap:wrap;">
          <a href="tel:5125031080" class="btn btn-primary">Call (512) 503-1080</a>
          <a href="/contact-us" class="btn btn-secondary">Schedule Service</a>
        </div>
      </div>
      <div style="position:relative;">
        <img src="__IMG_about__" alt="Gardenhouse Plumbing team at work" loading="lazy" style="border-radius:16px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.12);"/>
        <div style="position:absolute;bottom:-20px;left:-20px;background:var(--color-primary);color:#fff;padding:24px 32px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.15);">
          <div style="font-size:36px;font-weight:800;line-height:1;">45+</div>
          <div style="font-size:14px;opacity:0.9;margin-top:4px;">Years Experience</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Full Services List -->
<section style="background:var(--color-secondary);padding:100px 0;color:#fff;">
  <div class="container">
    <div class="two-col-layout" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <img src="__IMG_faucet__" alt="Professional plumbing service" loading="lazy" style="border-radius:16px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.3);"/>
      </div>
      <div>
        <p class="section-label" style="color:#F59E0B;">Full-Service Plumbing</p>
        <h2 style="font-size:38px;font-weight:800;line-height:1.15;margin-bottom:20px;color:#fff;">Explore Our List of Services</h2>
        <p style="opacity:0.8;line-height:1.8;margin-bottom:28px;">Our knowledgeable crew can handle a range of jobs. For example, you can hire us for:</p>
        <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:14px;margin-bottom:32px;">
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Cast iron repiping services</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Service/House Calls</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Leak detection services</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Hydrostatic testing services</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Sewer mapping services</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Water heater installation services</li>
          <li style="display:flex;align-items:center;gap:12px;"><span style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">✓</span> Water heater relocation services</li>
        </ul>
        <a href="/contact-us" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">Reach Out Today</a>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section id="testimonials" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label">Customer Reviews</p>
      <h2 class="section-title">Read What Our Customers Have Been Saying</h2>
    </div>
    <div class="three-col-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:var(--color-light);border-radius:14px;padding:36px;border-top:4px solid var(--color-accent);box-shadow:0 2px 16px rgba(0,0,0,0.05);transition:transform 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="color:#F59E0B;font-size:22px;margin-bottom:16px;letter-spacing:2px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.8;margin-bottom:20px;color:var(--color-text);">"We've worked with Marcus on several projects involving water damage, and he's always been reliable, professional, and easy to work with. His quick response and quality plumbing work make a big difference for homeowners. Highly recommend!"</p>
        <strong style="color:var(--color-secondary);font-size:16px;">— Dominic G.</strong>
      </div>
      <div style="background:var(--color-light);border-radius:14px;padding:36px;border-top:4px solid var(--color-accent);box-shadow:0 2px 16px rgba(0,0,0,0.05);transition:transform 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="color:#F59E0B;font-size:22px;margin-bottom:16px;letter-spacing:2px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.8;margin-bottom:20px;color:var(--color-text);">"Gardenhouse Plumbing came through when we had a major leak emergency. They were fast, transparent about pricing, and did excellent work. We couldn't be happier with the service."</p>
        <strong style="color:var(--color-secondary);font-size:16px;">— Sarah M.</strong>
      </div>
      <div style="background:var(--color-light);border-radius:14px;padding:36px;border-top:4px solid var(--color-accent);box-shadow:0 2px 16px rgba(0,0,0,0.05);transition:transform 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="color:#F59E0B;font-size:22px;margin-bottom:16px;letter-spacing:2px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.8;margin-bottom:20px;color:var(--color-text);">"Outstanding workmanship on our water heater installation. They explained everything clearly, used modern tools for diagnostics, and left the area spotless. True professionals."</p>
        <strong style="color:var(--color-secondary);font-size:16px;">— James R.</strong>
      </div>
    </div>
    <div style="text-align:center;margin-top:40px;">
      <a href="https://www.google.com/search?q=gardenhouse+plumbing+austin+reviews" target="_blank" rel="noopener" class="btn btn-secondary" style="padding:12px 28px;font-size:15px;">Leave Us a Review on Google</a>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section style="background:var(--color-light);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label">Our Difference</p>
      <h2 class="section-title">Why Choose Gardenhouse Plumbing?</h2>
      <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">When you hire our reputable plumbing company, you can rest assured that you're putting your job in capable hands.</p>
    </div>
    <div class="why-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;">
      <div style="background:#fff;border-radius:14px;padding:44px 32px;text-align:center;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:72px;height:72px;background:rgba(26,93,171,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
          <span style="font-size:32px;">🏆</span>
        </div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">45+ Years of Experience</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">Decades of hands-on expertise solving every plumbing challenge in the Austin area.</p>
      </div>
      <div style="background:#fff;border-radius:14px;padding:44px 32px;text-align:center;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:72px;height:72px;background:rgba(26,93,171,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
          <span style="font-size:32px;">✅</span>
        </div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">OSHA-Certified</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">Safety first — our team meets all OSHA standards for workplace and customer protection.</p>
      </div>
      <div style="background:#fff;border-radius:14px;padding:44px 32px;text-align:center;box-shadow:0 2px 20px rgba(0,0,0,0.06);transition:transform 0.2s ease,box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.06)'">
        <div style="width:72px;height:72px;background:rgba(26,93,171,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
          <span style="font-size:32px;">📋</span>
        </div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">Informative Quotes</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">We provide detailed, transparent quotes for diagnostics so you understand every step.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section style="background:var(--color-primary);padding:100px 0;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,var(--color-primary) 0%,var(--color-accent) 100%);opacity:0.9;"></div>
  <div class="container" style="position:relative;z-index:2;">
    <h2 style="font-size:44px;font-weight:800;color:#fff;margin-bottom:16px;line-height:1.15;">Add a Top-Notch Water Heater to Your Home</h2>
    <p style="font-size:20px;color:rgba(255,255,255,0.9);margin-bottom:40px;max-width:560px;margin-left:auto;margin-right:auto;line-height:1.7;">Reach out to us for water heater installation services. Questions? Call us at (512) 503-1080 to find out more about our plumbing services.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:5125031080" class="btn btn-white" style="font-size:18px;padding:18px 44px;">Call (512) 503-1080</a>
      <a href="/contact-us" class="btn" style="font-size:18px;padding:18px 44px;background:transparent;color:#fff;border:2px solid #fff;">Get a Free Estimate</a>
    </div>
  </div>
</section>
<?php
get_footer();
