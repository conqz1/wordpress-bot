<?php
/**
 * The main template file.
 * Fallback when no other template matches.
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
