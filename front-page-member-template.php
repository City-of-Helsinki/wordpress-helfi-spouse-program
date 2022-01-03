<?php /*Template Name: Front-page-member-template */ ?>

<?php get_header(); ?>

      <div class="row">
          <?php get_template_part("partials/hero"); ?>
          <div class="container">
            <?php get_template_part("partials/user"); ?>
            <?php
            if(spouse_is_restricted_page()){
              ?>
                <div class="col-12 col-sm-12 events-column">
                  <h2>Upcoming events</h2>
                  <div class="row">
                      <?php echo do_shortcode('[spouse-events]'); ?>
                  </div>
                </div>
              <?php
            }
            ?>
      </div>
    </div>
  <?php
  // show social sharing only if the page is not behind login
  if( ! spouse_is_restricted_page()):
    ?>
      <div class="row">
          <div class="col-6 mx-auto text-center my-4">
            <span class="social-title"><?php dynamic_sidebar( 'social_title' ); ?></span>
            <?php echo do_shortcode('[SHARING_PLUS]'); ?>
          </div>
      </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
