<?php
  if( ! spouse_is_restricted_page() && empty(get_field('hide_social_media_buttons')) ):
    ?>
      <div class="row social-icon-bar">
          <div class="col-6 mx-auto text-center my-4">
            <span class="social-title"><?php dynamic_sidebar( 'social_title' ); ?></span>
            <?php echo do_shortcode('[SHARING_PLUS]'); ?>
          </div>
      </div>
  <?php endif; ?>