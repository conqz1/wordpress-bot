<?php
/**
 * The front page template.
 * Homepage content — hero, services, CTA, etc.
 */
get_header();
?>
<!-- HERO SECTION -->
<section style="position:relative;min-height:680px;display:flex;align-items:center;overflow:hidden;background:var(--color-primary);">
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,var(--color-dark) 0%,var(--color-primary) 50%,rgba(26,188,156,0.15) 100%);z-index:1;"></div>
  <div style="position:absolute;right:-100px;bottom:-50px;width:600px;height:600px;border-radius:50%;background:rgba(232,81,26,0.08);z-index:1;"></div>
  <div class="container" style="position:relative;z-index:2;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;padding-top:100px;padding-bottom:100px;" >
    <div class="hero-content">
      <p class="section-label" style="color:var(--color-accent);font-size:14px;"><?php echo esc_html( get_theme_mod( 'hero_label', '#1 Digital Menu Board Software for Restaurants' ) ); ?></p>
      <h1 style="font-size:54px;font-weight:800;line-height:1.08;margin-bottom:20px;color:#fff;"><?php echo esc_html( get_theme_mod( 'hero_headline', 'Sell More Food, Faster' ) ); ?></h1>
      <p style="font-size:19px;line-height:1.7;margin-bottom:36px;color:rgba(255,255,255,0.85);max-width:500px;"><?php echo esc_html( get_theme_mod( 'hero_subtext', 'Elevate your restaurant with stunning digital menu boards. Easy to update, fully customizable, and integrated with your POS system.' ) ); ?></p>
      <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:32px;">
        <a href="#pricing" class="btn btn-primary" style="font-size:18px;padding:16px 36px;">{{hero_cta_1|See Pricing}}</a>
        <a href="#contact" class="btn btn-secondary" style="font-size:18px;padding:16px 36px;border-color:#fff;color:#fff;" onmouseover="this.style.background='#fff';this.style.color='var(--color-primary)'" onmouseout="this.style.background='transparent';this.style.color='#fff'">{{hero_cta_2|Book a Demo}}</a>
      </div>
      <div style="display:flex;gap:24px;align-items:center;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:8px;">
          <img src="<?php echo get_template_directory_uri(); ?>/images/google-play.webp" alt="Google Play" style="height:36px;" loading="lazy"/>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
          <img src="<?php echo get_template_directory_uri(); ?>/images/amazon-badge.webp" alt="Amazon Signage" style="height:36px;" loading="lazy"/>
        </div>
      </div>
    </div>
    <div style="text-align:center;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/hero-mockup.webp" alt="Digital menu board on screen" style="max-width:100%;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.4);"/>
    </div>
  </div>
</section>

<!-- TOP FEATURES -->
<section id="features" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label"><?php echo esc_html( get_theme_mod( 'features_label', 'Top Features' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'features_headline', 'Everything You Need to Sell More' ) ); ?></h2>
      <p class="section-subtitle" style="margin-left:auto;margin-right:auto;"><?php echo esc_html( get_theme_mod( 'features_subtext', 'Our digital menu board software is built specifically for restaurants. Here\'s what sets us apart.' ) ); ?></p>
    </div>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(232,81,26,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">🍔</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_1_title|Pick & Choose Menu Items}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_1_desc|Select exactly which items appear on your digital boards. Full control over what customers see.}}</p>
      </div>
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(26,188,156,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">📱</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_2_title|Simple Drag & Drop UI}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_2_desc|Intuitive drag-and-drop interface makes updating your menus fast and effortless. No design skills needed.}}</p>
      </div>
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(45,62,80,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">🔗</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_3_title|POS Integration}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_3_desc|Seamlessly syncs with Toast® POS and other systems. Update prices once — everywhere updates automatically.}}</p>
      </div>
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(232,81,26,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">⏰</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_4_title|Daypart Scheduling}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_4_desc|Automatically switch between breakfast, lunch, and dinner menus at scheduled times throughout the day.}}</p>
      </div>
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(26,188,156,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">🎨</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_5_title|Beautiful Templates}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_5_desc|Choose from professionally designed templates or customize your own to match your brand perfectly.}}</p>
      </div>
      <div style="background:var(--color-light);border-radius:16px;padding:36px 28px;box-shadow:0 2px 20px rgba(0,0,0,0.05);transition:transform 0.2s,box-shadow 0.2s;border:1px solid var(--color-border);" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 20px rgba(0,0,0,0.05)'">
        <div style="width:56px;height:56px;background:rgba(45,62,80,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">☁️</div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:10px;">{{feature_6_title|Cloud-Based Management}}</h3>
        <p style="color:var(--color-gray);line-height:1.7;font-size:15px;">{{feature_6_desc|Manage all your locations from anywhere. Update menus remotely from your phone, tablet, or computer.}}</p>
      </div>
    </div>
  </div>
</section>

<!-- AMAZON SIGNAGE -->
<section id="amazon" style="background:var(--color-primary);padding:100px 0;overflow:hidden;">
  <div class="container">
    <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <p class="section-label" style="color:var(--color-accent);"><?php echo esc_html( get_theme_mod( 'amazon_label', 'Hardware Made Simple' ) ); ?></p>
        <h2 class="section-title" style="color:#fff;"><?php echo esc_html( get_theme_mod( 'amazon_headline', 'Amazon Signage' ) ); ?></h2>
        <p style="font-size:18px;color:rgba(255,255,255,0.8);line-height:1.7;margin-bottom:28px;max-width:500px;"><?php echo esc_html( get_theme_mod( 'amazon_desc', 'Run your digital menu boards on affordable Amazon Fire TV Stick hardware. Plug in, connect to your account, and your menus are live in minutes.' ) ); ?></p>
        <ul style="list-style:none;padding:0;margin-bottom:32px;">
          <li style="color:rgba(255,255,255,0.9);font-size:16px;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);font-size:20px;">✓</span> {{amazon_point_1|No expensive hardware required}}</li>
          <li style="color:rgba(255,255,255,0.9);font-size:16px;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);font-size:20px;">✓</span> {{amazon_point_2|Works with any TV or display}}</li>
          <li style="color:rgba(255,255,255,0.9);font-size:16px;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);font-size:20px;">✓</span> {{amazon_point_3|Setup in under 5 minutes}}</li>
        </ul>
        <a href="#contact" class="btn btn-accent" style="font-size:17px;padding:16px 36px;"><?php echo esc_html( get_theme_mod( 'amazon_cta', 'Learn More' ) ); ?></a>
      </div>
      <div style="text-align:center;">
        <img src="<?php echo get_template_directory_uri(); ?>/images/amazon-signage.webp" alt="Amazon Signage integration" style="max-width:100%;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.3);" loading="lazy"/>
      </div>
    </div>
  </div>
</section>

<!-- COMMAND CENTER -->
<section id="how-it-works" style="background:var(--color-light);padding:100px 0;">
  <div class="container" style="text-align:center;">
    <p class="section-label"><?php echo esc_html( get_theme_mod( 'command_label', 'Powerful & Intuitive' ) ); ?></p>
    <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'command_headline', 'Your Menu Command Center' ) ); ?></h2>
    <p class="section-subtitle" style="margin:0 auto 48px;"><?php echo esc_html( get_theme_mod( 'command_subtext', 'See how easy it is to manage your digital menus from our cloud-based dashboard. Control every screen, every location.' ) ); ?></p>
    <div style="background:#fff;border-radius:20px;padding:12px;box-shadow:0 8px 40px rgba(0,0,0,0.1);display:inline-block;max-width:900px;width:100%;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/dashboard.webp" alt="Menu command center dashboard" style="width:100%;border-radius:12px;" loading="lazy"/>
    </div>
    <div style="margin-top:36px;">
      <a href="#contact" class="btn btn-primary" style="font-size:17px;padding:16px 40px;"><?php echo esc_html( get_theme_mod( 'command_cta', 'Start Managing Your Menus' ) ); ?></a>
    </div>
  </div>
</section>

<!-- PRICING -->
<section id="pricing" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label"><?php echo esc_html( get_theme_mod( 'pricing_label', 'Transparent Pricing' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'pricing_headline', 'Simple, Per-Screen Pricing' ) ); ?></h2>
      <p class="section-subtitle" style="margin:0 auto;"><?php echo esc_html( get_theme_mod( 'pricing_subtext', 'No hidden fees. No long-term contracts. Scale as you grow.' ) ); ?></p>
    </div>
    <div class="pricing-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;max-width:960px;margin:0 auto;">
      <div style="background:var(--color-light);border-radius:20px;padding:40px 32px;text-align:center;border:2px solid var(--color-border);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.transform='';this.style.boxShadow=''">
        <h3 style="font-size:18px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-gray);margin-bottom:16px;">{{plan_1_name|Starter}}</h3>
        <div style="font-size:52px;font-weight:800;color:var(--color-primary);margin-bottom:4px;">{{plan_1_price|$69}}</div>
        <p style="color:var(--color-gray);font-size:14px;margin-bottom:28px;">{{plan_1_period|per screen / month}}</p>
        <ul style="list-style:none;padding:0;text-align:left;margin-bottom:32px;">
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_1_f1|1-4 Screens}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_1_f2|Cloud Management}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_1_f3|All Templates}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_1_f4|Email Support}}</li>
        </ul>
        <a href="#contact" class="btn btn-secondary" style="width:100%;">{{plan_1_cta|Get Started}}</a>
      </div>
      <div style="background:var(--color-secondary);border-radius:20px;padding:40px 32px;text-align:center;border:2px solid var(--color-secondary);position:relative;transform:scale(1.05);box-shadow:0 16px 48px rgba(232,81,26,0.25);">
        <div style="position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--color-accent);color:#fff;padding:5px 20px;border-radius:20px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;">Most Popular</div>
        <h3 style="font-size:18px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.8);margin-bottom:16px;">{{plan_2_name|Growth}}</h3>
        <div style="font-size:52px;font-weight:800;color:#fff;margin-bottom:4px;">{{plan_2_price|$150}}</div>
        <p style="color:rgba(255,255,255,0.7);font-size:14px;margin-bottom:28px;">{{plan_2_period|per screen / month}}</p>
        <ul style="list-style:none;padding:0;text-align:left;margin-bottom:32px;">
          <li style="padding:8px 0;font-size:15px;color:#fff;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_2_f1|5-9 Screens}}</li>
          <li style="padding:8px 0;font-size:15px;color:#fff;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_2_f2|POS Integration}}</li>
          <li style="padding:8px 0;font-size:15px;color:#fff;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_2_f3|Daypart Scheduling}}</li>
          <li style="padding:8px 0;font-size:15px;color:#fff;display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_2_f4|Priority Support}}</li>
        </ul>
        <a href="#contact" class="btn" style="width:100%;background:#fff;color:var(--color-secondary);font-weight:700;">{{plan_2_cta|Get Started}}</a>
      </div>
      <div style="background:var(--color-light);border-radius:20px;padding:40px 32px;text-align:center;border:2px solid var(--color-border);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--color-accent)';this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.transform='';this.style.boxShadow=''">
        <h3 style="font-size:18px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-gray);margin-bottom:16px;">{{plan_3_name|Enterprise}}</h3>
        <div style="font-size:52px;font-weight:800;color:var(--color-primary);margin-bottom:4px;">{{plan_3_price|$299}}</div>
        <p style="color:var(--color-gray);font-size:14px;margin-bottom:28px;">{{plan_3_period|per screen / month}}</p>
        <ul style="list-style:none;padding:0;text-align:left;margin-bottom:32px;">
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_3_f1|10+ Screens}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_3_f2|Multi-Location Support}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_3_f3|Custom Design}}</li>
          <li style="padding:8px 0;font-size:15px;color:var(--color-primary);display:flex;align-items:center;gap:10px;"><span style="color:var(--color-accent);">✓</span> {{plan_3_f4|Dedicated Account Manager}}</li>
        </ul>
        <a href="#contact" class="btn btn-secondary" style="width:100%;">{{plan_3_cta|Contact Sales}}</a>
      </div>
    </div>
  </div>
</section>

<!-- COMPARISON CTA -->
<section style="background:var(--color-accent);padding:60px 0;text-align:center;">
  <div class="container">
    <h2 style="font-size:28px;font-weight:700;color:#fff;margin-bottom:12px;"><?php echo esc_html( get_theme_mod( 'comparison_headline', 'Compare the cost of digital menus to printing and manually updating static menus!' ) ); ?></h2>
    <p style="font-size:17px;color:rgba(255,255,255,0.85);margin-bottom:28px;"><?php echo esc_html( get_theme_mod( 'comparison_subtext', 'See how much time and money you can save with Menuboard Manager.' ) ); ?></p>
    <a href="#contact" class="btn" style="background:#fff;color:var(--color-accent);font-size:17px;padding:16px 40px;"><?php echo esc_html( get_theme_mod( 'comparison_cta', 'See the Comparison' ) ); ?></a>
  </div>
</section>

<!-- GOOGLE REVIEWS -->
<section style="background:var(--color-light);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label"><?php echo esc_html( get_theme_mod( 'reviews_label', 'What People Say' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'reviews_headline', 'Google Reviews' ) ); ?></h2>
    </div>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 20px rgba(0,0,0,0.06);border-left:4px solid var(--color-secondary);">
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;font-size:15px;">"{{review_1_text|Menuboard Manager has completely transformed our restaurant. The menus look professional and updating them is a breeze. Highly recommend!}}"</p>
        <strong style="color:var(--color-primary);">{{review_1_name|— Restaurant Owner}}</strong>
      </div>
      <div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 20px rgba(0,0,0,0.06);border-left:4px solid var(--color-accent);">
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;font-size:15px;">"{{review_2_text|The Toast integration is seamless. We change prices in Toast and the menu boards update automatically. This saves us hours every week.}}"</p>
        <strong style="color:var(--color-primary);">{{review_2_name|— Quick Service Manager}}</strong>
      </div>
      <div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 20px rgba(0,0,0,0.06);border-left:4px solid var(--color-secondary);">
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;font-size:15px;">"{{review_3_text|Setup was incredibly easy. Plugged in the Fire Stick, connected our account, and we were live in minutes. The support team is fantastic too.}}"</p>
        <strong style="color:var(--color-primary);">{{review_3_name|— Franchise Director}}</strong>
      </div>
    </div>
  </div>
</section>

<!-- POS INTEGRATION -->
<section style="background:#fff;padding:100px 0;">
  <div class="container">
    <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/pos-integration.webp" alt="POS integration" style="width:100%;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,0.1);" loading="lazy"/>
      </div>
      <div>
        <p class="section-label"><?php echo esc_html( get_theme_mod( 'pos_label', 'Seamless Integration' ) ); ?></p>
        <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'pos_headline', 'Order Confirmation with Your POS' ) ); ?></h2>
        <p style="font-size:17px;color:var(--color-gray);line-height:1.7;margin-bottom:28px;max-width:500px;"><?php echo esc_html( get_theme_mod( 'pos_desc', 'Connect your digital menu boards directly to your POS system. When you update items, prices, or availability in Toast® — your boards update in real-time.' ) ); ?></p>
        <ul style="list-style:none;padding:0;margin-bottom:32px;">
          <li style="font-size:16px;margin-bottom:14px;display:flex;align-items:center;gap:12px;color:var(--color-primary);"><span style="color:var(--color-accent);font-size:20px;font-weight:700;">✓</span> {{pos_point_1|Real-time menu sync}}</li>
          <li style="font-size:16px;margin-bottom:14px;display:flex;align-items:center;gap:12px;color:var(--color-primary);"><span style="color:var(--color-accent);font-size:20px;font-weight:700;">✓</span> {{pos_point_2|Automatic price updates}}</li>
          <li style="font-size:16px;margin-bottom:14px;display:flex;align-items:center;gap:12px;color:var(--color-primary);"><span style="color:var(--color-accent);font-size:20px;font-weight:700;">✓</span> {{pos_point_3|86 items instantly}}</li>
        </ul>
        <a href="#contact" class="btn btn-primary"><?php echo esc_html( get_theme_mod( 'pos_cta', 'See It In Action' ) ); ?></a>
      </div>
    </div>
  </div>
</section>

<!-- TECH STACK -->
<section style="background:var(--color-primary);padding:80px 0;">
  <div class="container" style="text-align:center;">
    <h2 class="section-title" style="color:#fff;margin-bottom:12px;"><?php echo esc_html( get_theme_mod( 'tech_headline', 'Where Menus Meet Your Tech Stack' ) ); ?></h2>
    <p style="font-size:17px;color:rgba(255,255,255,0.75);margin-bottom:48px;max-width:600px;margin-left:auto;margin-right:auto;"><?php echo esc_html( get_theme_mod( 'tech_subtext', 'Menuboard Manager integrates with the tools you already use to run your restaurant.' ) ); ?></p>
    <div class="grid-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
      <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:28px 20px;border:1px solid rgba(255,255,255,0.12);">
        <div style="font-size:36px;margin-bottom:12px;">🍞</div>
        <p style="color:#fff;font-weight:600;font-size:15px;">{{tech_1|Toast® POS}}</p>
      </div>
      <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:28px 20px;border:1px solid rgba(255,255,255,0.12);">
        <div style="font-size:36px;margin-bottom:12px;">📺</div>
        <p style="color:#fff;font-weight:600;font-size:15px;">{{tech_2|Amazon Fire TV}}</p>
      </div>
      <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:28px 20px;border:1px solid rgba(255,255,255,0.12);">
        <div style="font-size:36px;margin-bottom:12px;">📱</div>
        <p style="color:#fff;font-weight:600;font-size:15px;">{{tech_3|Android Devices}}</p>
      </div>
      <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:28px 20px;border:1px solid rgba(255,255,255,0.12);">
        <div style="font-size:36px;margin-bottom:12px;">🖥️</div>
        <p style="color:#fff;font-weight:600;font-size:15px;">{{tech_4|Samsung Displays}}</p>
      </div>
    </div>
  </div>
</section>

<!-- FINANCING -->
<section style="background:var(--color-light);padding:80px 0;">
  <div class="container" style="text-align:center;">
    <p class="section-label"><?php echo esc_html( get_theme_mod( 'financing_label', 'Flexible Options' ) ); ?></p>
    <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'financing_headline', 'Financing Available' ) ); ?></h2>
    <p class="section-subtitle" style="margin:0 auto 48px;"><?php echo esc_html( get_theme_mod( 'financing_subtext', 'Get started with affordable monthly payments. No large upfront costs.' ) ); ?></p>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;max-width:800px;margin:0 auto;">
      <div style="text-align:center;">
        <div style="width:64px;height:64px;background:rgba(232,81,26,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">💳</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:8px;">{{financing_1_title|Low Monthly Payments}}</h3>
        <p style="color:var(--color-gray);font-size:14px;line-height:1.6;">{{financing_1_desc|Spread the cost across affordable monthly installments.}}</p>
      </div>
      <div style="text-align:center;">
        <div style="width:64px;height:64px;background:rgba(26,188,156,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">📊</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:8px;">{{financing_2_title|Zero Interest Options}}</h3>
        <p style="color:var(--color-gray);font-size:14px;line-height:1.6;">{{financing_2_desc|Qualified businesses can enjoy zero-interest financing options.}}</p>
      </div>
      <div style="text-align:center;">
        <div style="width:64px;height:64px;background:rgba(45,62,80,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">🏦</div>
        <h3 style="font-size:17px;font-weight:700;margin-bottom:8px;">{{financing_3_title|Potential Tax Savings}}</h3>
        <p style="color:var(--color-gray);font-size:14px;line-height:1.6;">{{financing_3_desc|Equipment leasing may qualify for tax deductions. Consult your CPA.}}</p>
      </div>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<section id="case-studies" style="background:#fff;padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label"><?php echo esc_html( get_theme_mod( 'case_studies_label', 'Real Results' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'case_studies_headline', 'Case Studies' ) ); ?></h2>
      <p class="section-subtitle" style="margin:0 auto;"><?php echo esc_html( get_theme_mod( 'case_studies_subtext', 'For nearly a decade, we\'ve been transforming how restaurants display and sell their food.' ) ); ?></p>
    </div>
    <div style="display:flex;flex-direction:column;gap:40px;">
      <div class="case-study-card-inner" style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center;background:var(--color-light);border-radius:20px;padding:40px;box-shadow:0 2px 20px rgba(0,0,0,0.05);">
        <div>
          <img src="<?php echo get_template_directory_uri(); ?>/images/case-study-1.webp" alt="Case study restaurant" style="width:100%;border-radius:12px;" loading="lazy"/>
        </div>
        <div>
          <h3 style="font-size:24px;font-weight:700;margin-bottom:12px;color:var(--color-primary);">{{case_1_title|Pro's Pizza}}</h3>
          <p style="color:var(--color-gray);line-height:1.7;margin-bottom:20px;">{{case_1_desc|Pro's Pizza saw a significant increase in average ticket size after implementing our digital menu boards with dynamic upselling and promotional displays.}}</p>
          <div style="display:flex;gap:32px;flex-wrap:wrap;">
            <div>
              <div style="font-size:32px;font-weight:800;color:var(--color-secondary);">{{case_1_stat_1|+22%}}</div>
              <p style="font-size:13px;color:var(--color-gray);">{{case_1_stat_1_label|Average Ticket Size}}</p>
            </div>
            <div>
              <div style="font-size:32px;font-weight:800;color:var(--color-accent);">{{case_1_stat_2|3x}}</div>
              <p style="font-size:13px;color:var(--color-gray);">{{case_1_stat_2_label|Faster Menu Updates}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="case-study-card-inner" style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center;background:var(--color-light);border-radius:20px;padding:40px;box-shadow:0 2px 20px rgba(0,0,0,0.05);">
        <div>
          <img src="<?php echo get_template_directory_uri(); ?>/images/case-study-2.webp" alt="Case study restaurant" style="width:100%;border-radius:12px;" loading="lazy"/>
        </div>
        <div>
          <h3 style="font-size:24px;font-weight:700;margin-bottom:12px;color:var(--color-primary);">{{case_2_title|Great Harvest Bakery}}</h3>
          <p style="color:var(--color-gray);line-height:1.7;margin-bottom:20px;">{{case_2_desc|Great Harvest Bakery streamlined their daily specials and seasonal menu changes across multiple locations using our centralized management platform.}}</p>
          <div style="display:flex;gap:32px;flex-wrap:wrap;">
            <div>
              <div style="font-size:32px;font-weight:800;color:var(--color-secondary);">{{case_2_stat_1|85%}}</div>
              <p style="font-size:13px;color:var(--color-gray);">{{case_2_stat_1_label|Time Saved on Updates}}</p>
            </div>
            <div>
              <div style="font-size:32px;font-weight:800;color:var(--color-accent);">{{case_2_stat_2|12}}</div>
              <p style="font-size:13px;color:var(--color-gray);">{{case_2_stat_2_label|Locations Managed}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section style="background:var(--color-dark);padding:100px 0;color:#fff;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label" style="color:var(--color-accent);"><?php echo esc_html( get_theme_mod( 'why_label', 'The Menuboard Manager Difference' ) ); ?></p>
      <h2 class="section-title" style="color:#fff;"><?php echo esc_html( get_theme_mod( 'why_headline', 'Why Choose Us?' ) ); ?></h2>
    </div>
    <div class="grid-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:28px;">
      <div style="text-align:center;padding:28px 20px;background:rgba(255,255,255,0.05);border-radius:16px;border:1px solid rgba(255,255,255,0.08);transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-4px)'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform=''">
        <div style="font-size:44px;margin-bottom:16px;">🏆</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">{{why_1_title|Nearly a Decade of Experience}}</h3>
        <p style="opacity:0.7;line-height:1.7;font-size:14px;">{{why_1_desc|We've been building digital menu solutions since the beginning. We know what works.}}</p>
      </div>
      <div style="text-align:center;padding:28px 20px;background:rgba(255,255,255,0.05);border-radius:16px;border:1px solid rgba(255,255,255,0.08);transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-4px)'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform=''">
        <div style="font-size:44px;margin-bottom:16px;">🤝</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">{{why_2_title|Dedicated Support}}</h3>
        <p style="opacity:0.7;line-height:1.7;font-size:14px;">{{why_2_desc|Real people, real support. We're here to help you every step of the way.}}</p>
      </div>
      <div style="text-align:center;padding:28px 20px;background:rgba(255,255,255,0.05);border-radius:16px;border:1px solid rgba(255,255,255,0.08);transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-4px)'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform=''">
        <div style="font-size:44px;margin-bottom:16px;">🇺🇸</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">{{why_3_title|Veteran-Owned}}</h3>
        <p style="opacity:0.7;line-height:1.7;font-size:14px;">{{why_3_desc|Proudly veteran-owned and operated. Discipline and integrity in everything we do.}}</p>
      </div>
      <div style="text-align:center;padding:28px 20px;background:rgba(255,255,255,0.05);border-radius:16px;border:1px solid rgba(255,255,255,0.08);transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-4px)'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform=''">
        <div style="font-size:44px;margin-bottom:16px;">⚡</div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">{{why_4_title|Quick Setup}}</h3>
        <p style="opacity:0.7;line-height:1.7;font-size:14px;">{{why_4_desc|Get up and running in minutes, not weeks. Plug-and-play simplicity.}}</p>
      </div>
    </div>
  </div>
</section>

<!-- WHO WE ARE -->
<section style="background:#fff;padding:100px 0;">
  <div class="container">
    <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
      <div>
        <p class="section-label"><?php echo esc_html( get_theme_mod( 'whoweare_label', 'Our Story' ) ); ?></p>
        <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'whoweare_headline', 'Who We Are' ) ); ?></h2>
        <p style="font-size:17px;color:var(--color-gray);line-height:1.8;margin-bottom:20px;max-width:500px;">{{whoweare_desc_1|Menuboard Manager was built by restaurant people, for restaurant people. We understand the chaos of a busy kitchen and the importance of clear, attractive menu presentation.}}</p>
        <p style="font-size:17px;color:var(--color-gray);line-height:1.8;margin-bottom:28px;max-width:500px;">{{whoweare_desc_2|As a veteran-owned company, we bring discipline, reliability, and a relentless commitment to our customers' success. We're not just a software company — we're your digital menu partner.}}</p>
        <a href="#contact" class="btn btn-primary"><?php echo esc_html( get_theme_mod( 'whoweare_cta', 'Learn Our Story' ) ); ?></a>
      </div>
      <div style="text-align:center;">
        <img src="<?php echo get_template_directory_uri(); ?>/images/who-we-are.webp" alt="The Menuboard Manager team" style="width:100%;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,0.1);" loading="lazy"/>
      </div>
    </div>
  </div>
</section>

<!-- CLIENT TESTIMONIALS -->
<section style="background:var(--color-light);padding:100px 0;">
  <div class="container">
    <div style="text-align:center;margin-bottom:60px;">
      <p class="section-label"><?php echo esc_html( get_theme_mod( 'testimonials_label', 'Trusted by Restaurants' ) ); ?></p>
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'testimonials_headline', 'Client Testimonials' ) ); ?></h2>
    </div>
    <div class="grid-3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
      <div style="background:#fff;border-radius:16px;padding:36px;box-shadow:0 4px 24px rgba(0,0,0,0.06);text-align:center;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="width:72px;height:72px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;color:#fff;">🍕</div>
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;">"{{testimonial_1_text|The digital menus have been a game-changer for our pizza shop. Customers love the visual appeal and our sales have gone up.}}"</p>
        <strong style="color:var(--color-primary);font-size:15px;">{{testimonial_1_name|— Mike D., Pizza Shop Owner}}</strong>
      </div>
      <div style="background:#fff;border-radius:16px;padding:36px;box-shadow:0 4px 24px rgba(0,0,0,0.06);text-align:center;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="width:72px;height:72px;background:var(--color-secondary);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;color:#fff;">🍔</div>
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;">"{{testimonial_2_text|Managing menus across our 8 locations used to be a nightmare. Now it takes minutes instead of days. Incredible product.}}"</p>
        <strong style="color:var(--color-primary);font-size:15px;">{{testimonial_2_name|— Sarah L., Multi-Unit Operator}}</strong>
      </div>
      <div style="background:#fff;border-radius:16px;padding:36px;box-shadow:0 4px 24px rgba(0,0,0,0.06);text-align:center;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <div style="width:72px;height:72px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;color:#fff;">☕</div>
        <div style="color:#F5A623;font-size:18px;margin-bottom:12px;">★★★★★</div>
        <p style="font-style:italic;line-height:1.7;margin-bottom:16px;color:#444;">"{{testimonial_3_text|The setup was so easy. We were up and running in less than an hour. The support team walked us through everything.}}"</p>
        <strong style="color:var(--color-primary);font-size:15px;">{{testimonial_3_name|— James R., Café Owner}}</strong>
      </div>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section id="contact" style="background:linear-gradient(135deg,var(--color-secondary) 0%,#C43D0E 100%);padding:100px 0;text-align:center;">
  <div class="container">
    <h2 style="font-size:46px;font-weight:800;color:#fff;margin-bottom:16px;line-height:1.15;"><?php echo esc_html( get_theme_mod( 'cta_headline', 'Stunning Menus That Drive More Sales' ) ); ?></h2>
    <p style="font-size:20px;color:rgba(255,255,255,0.88);margin-bottom:40px;max-width:560px;margin-left:auto;margin-right:auto;line-height:1.7;"><?php echo esc_html( get_theme_mod( 'cta_subtext', 'Join hundreds of restaurants already using Menuboard Manager to boost revenue and simplify operations.' ) ); ?></p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="#" class="btn" style="background:#fff;color:var(--color-secondary);font-size:18px;padding:18px 44px;font-weight:700;">{{cta_button_1|Start Free Trial}}</a>
      <a href="#" class="btn" style="background:transparent;color:#fff;font-size:18px;padding:18px 44px;border:2px solid #fff;" onmouseover="this.style.background='#fff';this.style.color='var(--color-secondary)'" onmouseout="this.style.background='transparent';this.style.color='#fff'">{{cta_button_2|Schedule a Demo}}</a>
    </div>
  </div>
</section>
<?php
get_footer();
