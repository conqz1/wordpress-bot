<?php
/**
 * The page template.
 * Used for all standard WordPress pages.
 * Content manages its own layout (no width constraint here).
 */
get_header();
?>
<main id="main" style="min-height:60vh;">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
<?php
get_footer();
