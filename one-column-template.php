<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>

      <div class="row">
          <?php get_template_part("partials/hero"); ?>
          <div class="container">
              <div id="main-content" class="col-12 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-12">
                      <h1 class="pt-3"><?php the_title(); ?></h1>
                    </div>
                </div>
          <?php
          // center
          if (have_rows('left_column_content')):
            echo '<div class="row">';
            while (have_rows('left_column_content')) : the_row();
              $type = get_sub_field('content_type');
              get_template_part('partials/'.$type);
            endwhile;
            echo '</div>';
          endif;
          ?>
          </div>
            <?php
            if(spouse_is_restricted_page()){
              ?>
                <div class="col-12 col-sm-12 col-lg-3 col-xl-3 events-column">
                    <h2><?php _e("Upcoming events") ?></h2>
                  <?php echo do_shortcode('[spouse-events]'); ?>
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
