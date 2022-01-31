<?php
get_header();
?>
<div class="container-fluid">
    <div class="row">
      <?php get_template_part( 'partials/hero' ) ?>
    </div>
</div>
<main id="main-content" class="container">
            <div class="row">
                <div class="col-12 pt-4">
                  <h1 class="text-center"><?php the_title(); ?></h1>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
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
