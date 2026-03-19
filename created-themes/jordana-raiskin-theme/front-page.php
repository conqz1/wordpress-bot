<?php
/**
 * The front page template.
 * Homepage content — hero, services, CTA, etc.
 */
get_header();
?>
<!-- Hero Section -->
<section class="hero-section" style="position:relative;min-height:680px;display:flex;align-items:center;overflow:hidden;">
  <img src="__IMG_hero_bg__" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"/>
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(61,90,30,0.85) 0%,rgba(90,138,46,0.7) 50%,rgba(61,90,30,0.6) 100%);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;color:#fff;padding-top:60px;padding-bottom:80px;">
    <div style="max-width:640px;">
      <p class="section-label" style="color:rgba(255,255,255,0.85);letter-spacing:0.2em;">Austin, Texas Psychotherapist</p>
      <h1 style="font-size:54px;font-weight:300;line-height:1.15;margin-bottom:24px;font-family:Georgia,'Times New Roman',serif;color:#fff;">Life should be more than <span style="font-style:italic;color:var(--color-accent);">just coping</span></h1>
      <p style="font-size:20px;line-height:1.7;margin-bottom:40px;opacity:0.92;max-width:520px;font-family:Georgia,'Times New Roman',serif;">You want to feel comfortable in your own skin, confident in your decisions, and connected to the people around you.</p>
      <div style="display:flex;gap:16px;flex-wrap:wrap;">
        <a href="/contact/" class="btn btn-primary" style="font-size:18px;padding:16px 40px;">Schedule a Consultation</a>
        <a href="/about-therapy/" class="btn" style="font-size:18px;padding:16px 40px;background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.6);" onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.borderColor='#fff'" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.6)'">Learn About Therapy</a>
      </div>
    </div>
  </div>
</section>

<!-- About / Introduction Section -->
<section style="background:var(--color-bg-warm);padding:100px 0;">
  <div class="container">
    <div style="display:grid;grid-template-columns:380px 1fr;gap:60px;align-items:center;">
      <div style="position:relative;">
        <div style="border-radius:16px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.12);position:relative;z-index:2;">
          <img src="<?php echo get_template_directory_uri(); ?>/images/jordana-portrait.png" alt="Jordana Raiskin, LCSW - Austin Texas Psychotherapist" style="width:100%;height:auto;display:block;"/>
        </div>
        <div style="position:absolute;top:-16px;left:-16px;width:120px;height:120px;background:var(--color-bg-sage);border-radius:50%;z-index:1;"></div>
        <div style="position:absolute;bottom:-20px;right:-20px;width:80px;height:80px;background:var(--color-accent);opacity:0.2;border-radius:50%;z-index:1;"></div>
      </div>
      <div>
        <p class="section-label">Welcome</p>
        <h2 class="section-title" style="font-family:Georgia,'Times New Roman',serif;font-weight:400;font-size:38px;">Meet Jordana Raiskin, LCSW</h2>
        <p style="font-size:18px;line-height:1.8;margin-bottom:24px;color:var(--color-text-light);max-width:55ch;">You want to feel comfortable in your own skin. You want to feel confident of yourself and your decisions. You want to laugh spontaneously, and feel connected to the people around you. You want to be able to take more risks, and have it be less terrifying.</p>
        <p style="font-size:18px;line-height:1.8;margin-bottom:32px;color:var(--color-text-light);max-width:55ch;">My job is to meet you at the places where you feel stuck, frustrated, or dissatisfied, and <em><strong>together</strong></em> we can navigate through the obstacles that are getting in the way of a more vibrant, connected, <strong>purposeful</strong> life.</p>
        <a href="/about-me/" class="btn btn-secondary" style="padding:12px 32px;">More About Me</a>
      </div>
    </div>
  </div>
</section>

<!-- Quote Section -->
<section style="background:var(--color-secondary);padding:80px 0;">
  <div class="container" style="text-align:center;">
    <div style="max-width:700px;margin:0 auto;">
      <div style="font-size:60px;color:var(--color-accent);line-height:1;margin-bottom:16px;font-family:Georgia,serif;">&ldquo;</div>
      <blockquote style="font-family:Georgia,'Times New Roman',serif;font-size:28px;font-style:italic;line-height:1.5;color:#fff;margin-bottom:24px;border:none;padding:0;">A dream you dream alone is only a dream. A dream you dream together is reality.</blockquote>
      <p style="font-size:16px;color:var(--color-accent);font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;letter-spacing:0.08em;text-transform:uppercase;">John Lennon</p>
    </div>
  </div>
</section>

<!-- Approach / Services Section -->
<section id="approach" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label">My Approach</p>
      <h2 class="section-title" style="font-family:Georgia,'Times New Roman',serif;font-weight:400;">How I Can Help</h2>
      <p style="font-size:18px;color:var(--color-text-light);max-width:600px;margin:16px auto 0;">Together, we'll work through what's holding you back and build a path toward the life you truly want.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:var(--color-bg-warm);border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;border-top:4px solid var(--color-primary);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:var(--color-bg-sage);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">🌱</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Personal Growth</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Develop greater self-awareness and confidence. Learn to take risks and embrace change without overwhelming fear.</p>
      </div>
      <div style="background:var(--color-bg-warm);border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;border-top:4px solid var(--color-accent);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:var(--color-bg-sage);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">🤝</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Relationships</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Build deeper connections with the people around you. Feel more present, open, and engaged in your relationships.</p>
      </div>
      <div style="background:var(--color-bg-warm);border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;border-top:4px solid var(--color-primary);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:var(--color-bg-sage);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">✨</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Living Purposefully</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Navigate through the obstacles getting in the way of a vibrant, connected, purposeful life you deserve.</p>
      </div>
    </div>
  </div>
</section>

<!-- What to Expect Section -->
<section style="background:var(--color-bg-sage);padding:100px 0;">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <p class="section-label">What to Expect</p>
        <h2 class="section-title" style="font-family:Georgia,'Times New Roman',serif;font-weight:400;font-size:38px;">A Safe Space to Explore</h2>
        <p style="font-size:18px;line-height:1.8;margin-bottom:24px;color:var(--color-text-light);max-width:55ch;">Therapy is a collaborative process. I provide a warm, nonjudgmental environment where you can explore your thoughts and feelings at your own pace.</p>
        <p style="font-size:18px;line-height:1.8;margin-bottom:32px;color:var(--color-text-light);max-width:55ch;">Whether you're dealing with anxiety, depression, relationship issues, or simply feeling stuck, I'm here to help you find your way forward.</p>
        <div style="display:flex;flex-direction:column;gap:16px;">
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:32px;height:32px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;">✓</div>
            <span style="font-size:16px;color:var(--color-text);">Licensed Clinical Social Worker (LCSW)</span>
          </div>
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:32px;height:32px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;">✓</div>
            <span style="font-size:16px;color:var(--color-text);">Compassionate & Collaborative Approach</span>
          </div>
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:32px;height:32px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;">✓</div>
            <span style="font-size:16px;color:var(--color-text);">Serving the Austin, Texas Community</span>
          </div>
        </div>
      </div>
      <div style="position:relative;">
        <div style="border-radius:16px;overflow:hidden;box-shadow:0 12px 48px rgba(0,0,0,0.1);">
          <img src="__IMG_therapy_space__" alt="Comfortable therapy space in Austin, Texas" loading="lazy" style="width:100%;height:auto;display:block;"/>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonial-style Values Section -->
<section style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label">The Journey</p>
      <h2 class="section-title" style="font-family:Georgia,'Times New Roman',serif;font-weight:400;">From Coping to Thriving</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="text-align:center;padding:40px 28px;">
        <div style="width:80px;height:80px;background:var(--color-bg-sage);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;margin:0 auto 24px;">🪴</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Feel Comfortable</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Learn to feel at home in your own skin, embracing who you truly are with acceptance and compassion.</p>
      </div>
      <div style="text-align:center;padding:40px 28px;">
        <div style="width:80px;height:80px;background:var(--color-bg-sage);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;margin:0 auto 24px;">💪</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Feel Confident</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Develop trust in yourself and your decisions so you can move through life with clarity and courage.</p>
      </div>
      <div style="text-align:center;padding:40px 28px;">
        <div style="width:80px;height:80px;background:var(--color-bg-sage);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;margin:0 auto 24px;">💛</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Feel Connected</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:16px;">Laugh spontaneously and feel deeply connected to the people and world around you.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Band -->
<section style="background:var(--color-primary);padding:100px 0;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
  <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
  <div class="container" style="position:relative;z-index:2;">
    <h2 style="font-size:44px;font-weight:400;color:#fff;margin-bottom:20px;font-family:Georgia,'Times New Roman',serif;line-height:1.2;">Ready to Start Your Journey?</h2>
    <p style="font-size:20px;color:rgba(255,255,255,0.85);margin-bottom:40px;max-width:520px;margin-left:auto;margin-right:auto;font-family:Georgia,'Times New Roman',serif;line-height:1.7;">Life should be more than just coping. Let's work together to help you find your way to a more vibrant, connected, purposeful life.</p>
    <a href="/contact/" class="btn btn-white" style="font-size:18px;padding:18px 48px;box-shadow:0 4px 24px rgba(0,0,0,0.15);">Contact Me Today</a>
  </div>
</section>
<?php
get_footer();
