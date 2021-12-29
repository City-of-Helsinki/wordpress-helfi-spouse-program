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
  <div class="container">
      <div class="row flex-column">
          <div class="col-12 col-sm-12 cta-column">
              <div class="cta-background" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);">
                  <?php $buttonEnabled = get_field('enable_cta-button') ?>
                  <?php if($buttonEnabled): ?>
                    <?php get_template_part('partials/cta'); ?>
                  <?php endif; ?>
              </div>
          </div>
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
                  <div class="small-images clearfix">
                      <div class="d-flex flex-row flex-wrap align-items-center">
                        <?php
                        while ( have_rows('images') ) : the_row();
                          $img = get_sub_field('image');
                          ?>
                            <div class="p-2 w-25">
                                <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>"/>
                            </div>
                        <?php
                        endwhile;
                        ?>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-12 col-sm-12 events-column">
            <div class="container line position-relative">
              <h2>Upcoming events</h2>
                <div class="row">
                      <?php echo do_shortcode('[spouse-events]'); ?>
                </div>
            </div>
          </div>
      </div>
  </div>
</main><!-- #site-content -->

<?php
get_footer();
