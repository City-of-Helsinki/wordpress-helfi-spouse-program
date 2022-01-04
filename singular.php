<?php
get_header();
?>
<main id="main-content" class="container-fluid" role="main">
    <div class="row">
      <?php get_template_part( 'partials/hero' ) ?>
        <div class="col-12 offset-0 col-lg-6 offset-lg-3">
            <h1><?php the_title(); ?></h1>
          <?php
          if (have_posts()) :
            while (have_posts()) :
              the_post();
              the_content();
            endwhile;
          endif;
        ?>

        </div>
    </div>
    <?php
    // show social sharing only if the page is not behind login
    if( ! spouse_is_restricted_page()):
    ?>
    <div class="row social-icon-bar">
        <div class="col-6 mx-auto text-center">
            <span class="social-title"><?php dynamic_sidebar( 'social_title' ); ?></span>
          <?php echo do_shortcode('[SHARING_PLUS]'); ?>
        </div>
    </div>
    <?php endif; ?>
</main><!-- #site-content -->
<?php
get_footer();
