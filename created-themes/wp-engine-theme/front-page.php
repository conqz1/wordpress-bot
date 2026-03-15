<?php
/**
 * The front page template.
 * Homepage content — hero, services, CTA, etc.
 */
get_header();
?>
<!-- HERO SECTION -->
<section style="position:relative;min-height:680px;display:flex;align-items:center;overflow:hidden;background:var(--color-secondary);">
  <img src="<?php echo get_template_directory_uri(); ?>/images/hero-bg.jpg" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;opacity:0.3;"/>
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,0.95) 0%,rgba(10,22,40,0.7) 50%,rgba(10,22,40,0.5) 100%);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;padding-top:100px;padding-bottom:100px;">
    <div style="max-width:700px;margin:0 auto;text-align:center;">
      <span class="section-label" style="color:var(--color-accent);">Managed Hosting &amp; Beyond</span>
      <h1 class="hero-title" style="font-size:56px;font-weight:800;line-height:1.08;margin-bottom:24px;color:#fff;letter-spacing:-0.03em;">Intelligent platforms<br>built for your<br>digital future</h1>
      <p style="font-size:19px;line-height:1.7;margin-bottom:40px;color:rgba(255,255,255,0.8);max-width:560px;margin-left:auto;margin-right:auto;">Powering 5 million websites, WP Engine combines enterprise-grade software, managed hosting, developer tools, and cutting-edge AI to keep your site performing at its best.</p>
      <div class="hero-buttons" style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center;">
        <a href="#get-started" class="btn btn-primary" style="font-size:17px;padding:16px 40px;">Get Started</a>
        <a href="#plans" class="btn btn-outline-white" style="font-size:17px;padding:16px 40px;">View Plans</a>
      </div>
    </div>
  </div>
  <div style="position:absolute;bottom:0;left:0;right:0;height:60px;background:linear-gradient(to bottom,transparent,var(--color-white));z-index:2;"></div>
</section>

<!-- SOLUTIONS SECTION -->
<section id="solutions" style="background:var(--color-white);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-label" style="color:var(--color-accent);">Power to Create Online</span>
      <h2 class="section-title">Solutions built for you</h2>
      <p class="section-desc" style="margin-left:auto;margin-right:auto;">From managed hosting to developer tools and enterprise solutions, our platform adapts to your specific goals.</p>
    </div>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:var(--color-white);border-radius:16px;padding:36px 28px;box-shadow:0 2px 24px rgba(0,0,0,0.06);transition:all 0.2s ease;border:1px solid var(--color-gray-200);overflow:hidden;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 24px rgba(0,0,0,0.06)'">
        <img src="<?php echo get_template_directory_uri(); ?>/images/solution1.jpg" alt="Managed Hosting" loading="lazy" style="width:100%;height:180px;object-fit:cover;border-radius:12px;margin-bottom:24px;"/>
        <span style="display:inline-block;background:var(--color-accent);color:var(--color-secondary);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;padding:4px 10px;border-radius:4px;margin-bottom:14px;">Popular</span>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Managed WordPress Hosting</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:15px;margin-bottom:18px;">Enterprise-grade hosting with automatic updates, daily backups, and blazing-fast CDN performance.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:15px;display:inline-flex;align-items:center;gap:6px;transition:gap 0.2s;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">Learn More →</a>
      </div>
      <div style="background:var(--color-white);border-radius:16px;padding:36px 28px;box-shadow:0 2px 24px rgba(0,0,0,0.06);transition:all 0.2s ease;border:1px solid var(--color-gray-200);overflow:hidden;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 24px rgba(0,0,0,0.06)'">
        <img src="<?php echo get_template_directory_uri(); ?>/images/solution2.jpg" alt="Developer Tools" loading="lazy" style="width:100%;height:180px;object-fit:cover;border-radius:12px;margin-bottom:24px;"/>
        <span style="display:inline-block;background:#E8ECF1;color:var(--color-secondary);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;padding:4px 10px;border-radius:4px;margin-bottom:14px;">New</span>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Advanced Custom Fields</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:15px;margin-bottom:18px;">Build beautiful, content-rich WordPress sites with the world's most powerful custom fields plugin.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:15px;display:inline-flex;align-items:center;gap:6px;transition:gap 0.2s;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">Learn More →</a>
      </div>
      <div style="background:var(--color-white);border-radius:16px;padding:36px 28px;box-shadow:0 2px 24px rgba(0,0,0,0.06);transition:all 0.2s ease;border:1px solid var(--color-gray-200);overflow:hidden;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 24px rgba(0,0,0,0.06)'">
        <img src="<?php echo get_template_directory_uri(); ?>/images/solution3.jpg" alt="Headless WordPress" loading="lazy" style="width:100%;height:180px;object-fit:cover;border-radius:12px;margin-bottom:24px;"/>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Headless WordPress</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:15px;margin-bottom:18px;">Build a native WordPress native experience using modern JavaScript frameworks and our pre-built toolset.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:15px;display:inline-flex;align-items:center;gap:6px;transition:gap 0.2s;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">Learn More →</a>
      </div>
    </div>
  </div>
</section>

<!-- TECHNOLOGY SECTION -->
<section id="technology" style="background:var(--color-gray-100);padding:100px 0;">
  <div class="container">
    <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;">
      <div>
        <span class="section-label" style="color:var(--color-accent);">The WP Engine Advantage</span>
        <h2 class="section-title" style="margin-bottom:24px;">Technology engineered for growth</h2>
        <p style="color:var(--color-gray-600);font-size:17px;line-height:1.8;margin-bottom:32px;">WP Engine removes the friction that slows down digital growth. We combine our world-class Managed Hosting Platform with specialized products and tools for Commerce and Media, so teams can focus on growth.</p>
        <div style="display:flex;flex-direction:column;gap:18px;">
          <div style="display:flex;align-items:flex-start;gap:14px;">
            <div style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7L5.5 10.5L12 3.5" stroke="#0A1628" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <strong style="font-size:16px;color:var(--color-secondary);">Performance at scale.</strong>
              <span style="color:var(--color-gray-600);font-size:15px;"> Deliver fast, reliable experiences whether you're processing peak holiday sales or breaking global news.</span>
            </div>
          </div>
          <div style="display:flex;align-items:flex-start;gap:14px;">
            <div style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7L5.5 10.5L12 3.5" stroke="#0A1628" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <strong style="font-size:16px;color:var(--color-secondary);">Security by design.</strong>
              <span style="color:var(--color-gray-600);font-size:15px;"> Protect your revenue and reputation with proactive platform-level defenses that secure every product in our suite.</span>
            </div>
          </div>
          <div style="display:flex;align-items:flex-start;gap:14px;">
            <div style="width:28px;height:28px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7L5.5 10.5L12 3.5" stroke="#0A1628" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <strong style="font-size:16px;color:var(--color-secondary);">Expertise and innovation.</strong>
              <span style="color:var(--color-gray-600);font-size:15px;"> Leverage specialized tools and expert support that empower you to create successful digital experiences.</span>
            </div>
          </div>
        </div>
      </div>
      <div style="position:relative;">
        <img src="<?php echo get_template_directory_uri(); ?>/images/technology.jpg" alt="WP Engine Technology" loading="lazy" style="width:100%;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.1);"/>
      </div>
    </div>
  </div>
</section>

<!-- TRUSTED LOGOS -->
<section style="background:var(--color-white);padding:80px 0;">
  <div class="container" style="text-align:center;">
    <p style="font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-gray-300);margin-bottom:40px;">Trusted by Industry Leaders</p>
    <div class="logo-grid" style="display:grid;grid-template-columns:repeat(6,1fr);gap:40px;align-items:center;justify-items:center;opacity:0.5;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-jll.png" alt="JLL" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-petco.png" alt="Petco" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-cmg.png" alt="CMG" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-warby.png" alt="Warby Parker" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-ticketmaster.png" alt="Ticketmaster" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-fedex.png" alt="FedEx" loading="lazy" style="height:32px;width:auto;filter:grayscale(100%);" />
    </div>
  </div>
</section>

<!-- STATS SECTION -->
<section style="background:var(--color-secondary);padding:100px 0;">
  <div class="container">
    <div class="stats-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:40px;text-align:center;">
      <div>
        <div style="font-size:64px;font-weight:800;color:var(--color-accent);margin-bottom:12px;letter-spacing:-0.03em;">57%</div>
        <p style="font-size:16px;color:rgba(255,255,255,0.7);line-height:1.6;">Support satisfaction</p>
      </div>
      <div>
        <div style="font-size:64px;font-weight:800;color:var(--color-accent);margin-bottom:12px;letter-spacing:-0.03em;">59%</div>
        <p style="font-size:16px;color:rgba(255,255,255,0.7);line-height:1.6;">First contact resolution</p>
      </div>
      <div>
        <div style="font-size:64px;font-weight:800;color:var(--color-accent);margin-bottom:12px;letter-spacing:-0.03em;">8X</div>
        <p style="font-size:16px;color:rgba(255,255,255,0.7);line-height:1.6;">Stevie Award winner for<br>Customer Service</p>
      </div>
    </div>
  </div>
</section>

<!-- ECOSYSTEM SECTION -->
<section id="ecosystem" style="background:var(--color-white);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:70px;">
      <span class="section-label" style="color:var(--color-accent);">Built for Your Success</span>
      <h2 class="section-title">An ecosystem that powers<br>your ambition</h2>
      <p class="section-desc" style="margin-left:auto;margin-right:auto;">Whether you are securing enterprise revenue, scaling a creative agency, or building complex applications, our ecosystem adapts to your specific goals.</p>
    </div>
    <div class="grid-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px 28px;transition:all 0.2s ease;border:1px solid transparent;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 30px rgba(14,202,212,0.12)'" onmouseout="this.style.borderColor='transparent';this.style.transform='';this.style.boxShadow=''">
        <div style="font-size:36px;margin-bottom:16px;">🏢</div>
        <h3 style="font-size:19px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Enterprise Teams</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:14px;margin-bottom:18px;">Cut build cost in ownership with an all-in-one platform. We handle the hosting, security, and tech so your engineering resources stay focused on innovation.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:6px;">Explore Enterprise →</a>
      </div>
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px 28px;transition:all 0.2s ease;border:1px solid transparent;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 30px rgba(14,202,212,0.12)'" onmouseout="this.style.borderColor='transparent';this.style.transform='';this.style.boxShadow=''">
        <div style="font-size:36px;margin-bottom:16px;">🎨</div>
        <h3 style="font-size:19px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Agencies</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:14px;margin-bottom:18px;">Deliver excellence to your clients without the overhead. Leverage our partner programs and 24/7 support to win more business and keep client sites fast and secure.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:6px;">Explore Agency →</a>
      </div>
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px 28px;transition:all 0.2s ease;border:1px solid transparent;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 30px rgba(14,202,212,0.12)'" onmouseout="this.style.borderColor='transparent';this.style.transform='';this.style.boxShadow=''">
        <div style="font-size:36px;margin-bottom:16px;">⚙️</div>
        <h3 style="font-size:19px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Developers</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:14px;margin-bottom:18px;">Use a workflow that respects your time. From local development to production, use our pre-code tools to iterate faster and manage sites with pure freedom.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:6px;">Explore Developer →</a>
      </div>
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px 28px;transition:all 0.2s ease;border:1px solid transparent;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 30px rgba(14,202,212,0.12)'" onmouseout="this.style.borderColor='transparent';this.style.transform='';this.style.boxShadow=''">
        <div style="font-size:36px;margin-bottom:16px;">📰</div>
        <h3 style="font-size:19px;font-weight:700;margin-bottom:10px;color:var(--color-secondary);">Media Publishers</h3>
        <p style="color:var(--color-gray-600);line-height:1.7;font-size:14px;margin-bottom:18px;">Deliver instant load times, audience engagement, and ad-tech driven publishing on a platform built for modern publishing needs.</p>
        <a href="#" style="color:var(--color-accent);font-weight:600;font-size:14px;display:inline-flex;align-items:center;gap:6px;">Explore Media →</a>
      </div>
    </div>
  </div>
</section>

<!-- CASE STUDY SECTION -->
<section style="background:var(--color-gray-100);padding:100px 0;">
  <div class="container">
    <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div style="position:relative;">
        <img src="<?php echo get_template_directory_uri(); ?>/images/casestudy.jpg" alt="Case Study" loading="lazy" style="width:100%;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.1);"/>
      </div>
      <div>
        <span class="section-label" style="color:var(--color-accent);">Case Study</span>
        <h2 class="section-title" style="margin-bottom:24px;">Keeping fans connected during game-day surges</h2>
        <p style="color:var(--color-gray-600);font-size:17px;line-height:1.8;margin-bottom:32px;">The Dallas Mavericks teamed up with WP Engine so that Air to deliver a fast, reliable, and engaging web experience, ensuring fans stay connected during high-traffic events.</p>
        <a href="#" class="btn btn-primary" style="padding:14px 32px;">Read the Case Study</a>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section style="background:var(--color-white);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-label" style="color:var(--color-accent);">Customer Stories</span>
      <h2 class="section-title">What our customers say</h2>
    </div>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px;border-top:4px solid var(--color-accent);transition:all 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="display:flex;gap:2px;color:var(--color-accent);font-size:18px;margin-bottom:16px;">★★★★★</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">Outstanding customer support which is always available to help</h3>
        <p style="font-style:italic;line-height:1.7;margin-bottom:20px;color:var(--color-gray-600);font-size:15px;">"I love WP Engine for their outstanding customer support which is always available to help when I have an issue or a workflow gap. They host my websites perfectly every day."</p>
        <strong style="color:var(--color-secondary);font-size:14px;">— Joey B.</strong>
      </div>
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px;border-top:4px solid var(--color-accent);transition:all 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="display:flex;gap:2px;color:var(--color-accent);font-size:18px;margin-bottom:16px;">★★★★★</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">We can focus on actually building great websites</h3>
        <p style="font-style:italic;line-height:1.7;margin-bottom:20px;color:var(--color-gray-600);font-size:15px;">"WP Engine's fast support, intuitive Envato Dashboard, and overall hosting services are wonderful, giving me peace of mind that my sites are well-supported."</p>
        <strong style="color:var(--color-secondary);font-size:14px;">— David L., UX/UI Designer</strong>
      </div>
      <div style="background:var(--color-gray-100);border-radius:16px;padding:36px;border-top:4px solid var(--color-accent);transition:all 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="display:flex;gap:2px;color:var(--color-accent);font-size:18px;margin-bottom:16px;">★★★★★</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">The best 24/7 tech support I have ever seen</h3>
        <p style="font-style:italic;line-height:1.7;margin-bottom:20px;color:var(--color-gray-600);font-size:15px;">"WP Engine provides the best hosting I have ever seen. Their engineering at least 8-10 focus of work for us."</p>
        <strong style="color:var(--color-secondary);font-size:14px;">— Small Business Owner</strong>
      </div>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section style="position:relative;padding:120px 0;overflow:hidden;">
  <img src="<?php echo get_template_directory_uri(); ?>/images/cta-bg.jpg" alt="" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"/>
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,0.92) 0%,rgba(10,22,40,0.8) 100%);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;text-align:center;">
    <span class="section-label" style="color:var(--color-accent);">Let's Get Started</span>
    <h2 style="font-size:48px;font-weight:800;color:#fff;margin-bottom:20px;letter-spacing:-0.02em;line-height:1.1;">Ready to migrate today?</h2>
    <p style="font-size:19px;color:rgba(255,255,255,0.8);margin-bottom:44px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7;">Join over 5 million websites and experience the performance, security, and support that WP Engine delivers.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="#get-started" class="btn btn-primary" style="font-size:18px;padding:18px 44px;">Get Started</a>
      <a href="#contact" class="btn btn-outline-white" style="font-size:18px;padding:18px 44px;">Get in Touch</a>
    </div>
  </div>
</section>
<?php
get_footer();
