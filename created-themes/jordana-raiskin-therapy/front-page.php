<?php
/**
 * The front page template.
 * Homepage content — hero, services, CTA, etc.
 */
get_header();
?>
<!-- Hero Section -->
<section style="background:var(--color-light);padding:100px 0 80px;overflow:hidden;">
  <div class="container">
    <div class="hero-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div class="hero-text">
        <p class="section-label" style="color:var(--color-primary);"><?php echo esc_html( get_theme_mod( 'hero_label', 'Austin, Texas Psychotherapist' ) ); ?></p>
        <h1 style="font-family:Georgia,serif;font-size:52px;font-weight:400;line-height:1.15;color:var(--color-secondary);margin-bottom:24px;"><?php echo esc_html( get_theme_mod( 'hero_headline', 'Life should be more than just coping' ) ); ?></h1>
        <p style="font-size:19px;line-height:1.8;color:var(--color-text-light);margin-bottom:36px;max-width:520px;"><?php echo esc_html( get_theme_mod( 'hero_subtext', 'You want to feel comfortable in your own skin. You want to feel confident of yourself and your decisions. You want to laugh spontaneously, and feel connected to the people around you.' ) ); ?></p>
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
          <a href="/contact/" class="btn btn-primary" style="font-size:17px;padding:16px 36px;"><?php echo esc_html( get_theme_mod( 'hero_cta', 'Begin Your Journey' ) ); ?></a>
          <a href="/about-therapy/" class="btn btn-secondary" style="font-size:17px;padding:16px 36px;"><?php echo esc_html( get_theme_mod( 'hero_cta_secondary', 'Learn About Therapy' ) ); ?></a>
        </div>
      </div>
      <div class="hero-image-wrap" style="position:relative;">
        <div style="position:absolute;top:-20px;right:-20px;width:100%;height:100%;background:var(--color-primary);border-radius:24px;opacity:0.1;"></div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/jordana-portrait.png" alt="Jordana Raiskin, LCSW" style="width:100%;border-radius:24px;position:relative;z-index:1;box-shadow:0 16px 48px rgba(45,59,45,0.15);aspect-ratio:3/4;object-fit:cover;"/>
      </div>
    </div>
  </div>
</section>

<!-- About / Approach Section -->
<section id="about" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="max-width:760px;margin:0 auto;text-align:center;">
      <p class="section-label" style="color:var(--color-accent);"><?php echo esc_html( get_theme_mod( 'about_label', 'My Approach' ) ); ?></p>
      <h2 class="section-title" style="margin-bottom:32px;"><?php echo esc_html( get_theme_mod( 'about_headline', 'Meeting you where you are' ) ); ?></h2>
      <p style="font-size:19px;line-height:1.9;color:var(--color-text-light);margin-bottom:24px;">{{about_text_1|You want to be able to take more risks, and have it be less terrifying. My job is to meet you at the places where you feel stuck, frustrated, or dissatisfied.}}</p>
      <p style="font-size:19px;line-height:1.9;color:var(--color-text-light);margin-bottom:0;">{{about_text_2|Together we can navigate through the obstacles that are getting in the way of a more vibrant, connected, purposeful life.}}</p>
    </div>
  </div>
</section>

<!-- Quote Section -->
<section style="background:var(--color-secondary);padding:80px 0;">
  <div class="container" style="text-align:center;">
    <div style="max-width:680px;margin:0 auto;">
      <div style="font-size:60px;color:var(--color-primary);line-height:1;margin-bottom:16px;font-family:Georgia,serif;">&ldquo;</div>
      <blockquote style="font-family:Georgia,serif;font-size:28px;font-style:italic;color:#fff;line-height:1.5;margin-bottom:20px;"><?php echo esc_html( get_theme_mod( 'quote_text', 'A dream you dream alone is only a dream. A dream you dream together is reality.' ) ); ?></blockquote>
      <cite style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:15px;font-style:normal;color:var(--color-primary);font-weight:600;letter-spacing:0.1em;text-transform:uppercase;"><?php echo esc_html( get_theme_mod( 'quote_author', 'John Lennon' ) ); ?></cite>
    </div>
  </div>
</section>

<!-- Specialties / What I Help With -->
<section id="specialties" style="background:var(--color-light);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label" style="color:var(--color-primary);"><?php echo esc_html( get_theme_mod( 'specialties_label', 'Areas of Focus' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'specialties_headline', 'What I can help with' ) ); ?></h2>
    </div>
    <div class="specialties-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:#fff;border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.25s,box-shadow 0.25s;border-top:4px solid var(--color-primary);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="font-size:36px;margin-bottom:16px;">🌱</div>
        <h3 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">{{specialty_1_title|Personal Growth}}</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">{{specialty_1_desc|Build confidence in yourself and your decisions. Take more risks and feel less terrified by the unknown.}}</p>
      </div>
      <div style="background:#fff;border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.25s,box-shadow 0.25s;border-top:4px solid var(--color-accent);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="font-size:36px;margin-bottom:16px;">🤝</div>
        <h3 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">{{specialty_2_title|Relationships & Connection}}</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">{{specialty_2_desc|Feel more connected to the people around you. Learn to laugh spontaneously and build deeper bonds.}}</p>
      </div>
      <div style="background:#fff;border-radius:16px;padding:40px 32px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.25s,box-shadow 0.25s;border-top:4px solid var(--color-primary);" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="font-size:36px;margin-bottom:16px;">🧭</div>
        <h3 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:20px;font-weight:700;margin-bottom:12px;color:var(--color-secondary);">{{specialty_3_title|Finding Purpose}}</h3>
        <p style="color:var(--color-text-light);line-height:1.7;font-size:15px;">{{specialty_3_desc|Navigate through the obstacles getting in the way of a more vibrant, connected, and purposeful life.}}</p>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Therapy Section -->
<section style="background:#fff;padding:100px 0;">
  <div class="container">
    <div class="approach-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;">
      <div>
        <img src="__IMG_therapy_room__" alt="Comfortable therapy space" loading="lazy" style="width:100%;border-radius:20px;box-shadow:0 12px 40px rgba(0,0,0,0.1);aspect-ratio:4/3;object-fit:cover;"/>
      </div>
      <div>
        <p class="section-label" style="color:var(--color-accent);"><?php echo esc_html( get_theme_mod( 'why_label', 'Why Therapy' ) ); ?></p>
        <h2 class="section-title" style="margin-bottom:28px;"><?php echo esc_html( get_theme_mod( 'why_headline', 'A safe space to explore and grow' ) ); ?></h2>
        <p style="font-size:17px;line-height:1.9;color:var(--color-text-light);margin-bottom:20px;">{{why_text_1|Therapy provides a unique and confidential space where you can explore your thoughts, feelings, and experiences without judgment.}}</p>
        <p style="font-size:17px;line-height:1.9;color:var(--color-text-light);margin-bottom:32px;">{{why_text_2|Together, we work to uncover patterns, build new skills, and create lasting change in the areas of your life that matter most.}}</p>
        <div style="display:flex;flex-direction:column;gap:16px;">
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <span style="color:var(--color-primary);font-weight:bold;">✓</span>
            </div>
            <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:16px;font-weight:500;">{{why_point_1|Licensed Clinical Social Worker (LCSW)}}</span>
          </div>
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <span style="color:var(--color-primary);font-weight:bold;">✓</span>
            </div>
            <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:16px;font-weight:500;">{{why_point_2|Warm, collaborative approach}}</span>
          </div>
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <span style="color:var(--color-primary);font-weight:bold;">✓</span>
            </div>
            <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:16px;font-weight:500;">{{why_point_3|Serving Austin, Texas}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Band -->
<section style="background:linear-gradient(135deg, var(--color-primary) 0%, #3D6B12 100%);padding:100px 0;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-50%;right:-10%;width:400px;height:400px;border-radius:50%;background:rgba(255,255,255,0.05);"></div>
  <div style="position:absolute;bottom:-30%;left:-5%;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
  <div class="container" style="position:relative;z-index:1;">
    <h2 style="font-family:Georgia,serif;font-size:44px;font-weight:400;color:#fff;margin-bottom:20px;line-height:1.2;"><?php echo esc_html( get_theme_mod( 'cta_headline', 'Ready to take the first step?' ) ); ?></h2>
    <p style="font-size:20px;color:rgba(255,255,255,0.85);margin-bottom:40px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7;"><?php echo esc_html( get_theme_mod( 'cta_subtext', 'Reaching out is the hardest part. I\'m here to make the rest of the journey easier.' ) ); ?></p>
    <a href="/contact/" class="btn btn-white" style="font-size:18px;padding:18px 48px;box-shadow:0 4px 24px rgba(0,0,0,0.15);"><?php echo esc_html( get_theme_mod( 'cta_button', 'Contact Me Today' ) ); ?></a>
  </div>
</section>
<?php
get_footer();
