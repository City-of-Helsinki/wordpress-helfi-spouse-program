<?php
if ( is_user_logged_in() && !current_user_can('administrator') && !current_user_can('editor')) {
    if(wp_redirect('main-page')) {
      exit;
    }
}
?>
<?php
get_header();
?>

<main id="main-content" role="main">
  <div class="col-12 col-sm-12 cta-column container-fluid">
      <div class="cta-background" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>); background-position: center center;">
          <?php $buttonEnabled = get_field('enable_cta-button') ?>
          <?php if($buttonEnabled): ?>
            <?php get_template_part('partials/cta'); ?>
          <?php endif; ?>
      </div>
  </div>
  <div class="container">
      <div class="row flex-column">
          <div class="col-12 col-sm-12 main-content">
              <div class="main-content-container">
                <?php
                if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                endif;
                ?>
                <?php get_template_part("partials/quotes")?>
                <?php get_template_part("partials/upcoming-events") ?>
                <?php get_template_part('partials/front-page-small-images') ?>
              </div>
          </div>
          
      </div>
  </div>
</main><!-- #site-content -->

<?php
get_footer();
