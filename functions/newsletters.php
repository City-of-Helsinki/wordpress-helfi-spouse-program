<?php
/**
 * Description: Adds shortcode to display newsletter archive
 */

add_shortcode('spouse-archive', 'spouse_show_archive');

function spouse_show_archive($atts) {
  $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
  $newsletters = spouse_get_custom_posts( $paged, "newsletter" );

  if (!$newsletters->have_posts()) {
      return '';
  }

  ob_start();
  spouse_print_newsletters($newsletters);
  return ob_get_clean();
}

function spouse_get_custom_posts($paged = 1, $post_type="newsletter" ) {
  $args = array(
      'post_type'      => $post_type,
      'post_status'    => 'publish',
      'posts_per_page' => 4,
      'order'          => 'DESC',
      'paged'          => $paged,
  );

  $query = new WP_Query($args);

  return $query;
}

function spouse_print_newsletters($query) {
  if ($query->have_posts()) {
    $query->the_post(); 
      $latest_newsletter_id = get_the_ID();
      $latest_pdf = wp_get_attachment_url(get_post_meta($latest_newsletter_id, 'newsletter_pdf', true));
      $latest_featured_image = get_the_post_thumbnail_url($latest_newsletter_id);
      $latest_publish_date = (new \DateTime())->setTimestamp(strtotime(get_the_date()))->format('j.m.Y');
      $latest_newsletter_title = get_the_title();
      ?>
      <div class="newsletters-wrapper">
        <div class="d-flex latest-newsletter mb-5 pb-5">
          <a class="col-4 col-sm-12 col-lg-4" href="<?php echo $latest_pdf; ?>" target="_blank">
          <div class="newsletter">
            <div class="newsletter-content-wrap card border-0 flex-fill">
              <div class="newsletter-content">
                <?php if (!empty($latest_featured_image)) : ?>
                  <div class="newsletter-featured-image" style="background-image: url(<?php echo $latest_featured_image; ?>);"></div>
                <?php else : ?>
                  <div class="newsletter-no-image" style="background-image: url(<?php echo get_field('placeholder_image', 'options_activity_setttings'); ?>);"></div>
                <?php endif; ?>
                <div class="text-content card-body">
                  <h3 class="post-title"><?php echo $latest_newsletter_title; ?></h3>
                </div>
              </div>
            </div>
          </div>
          </a>
          <div class="latest-description col-8 col-lg-8 col-sm-12 my-lg-auto my-sm-3">
            <h2 class="my-1 mx-3">Read the latest Spouse Program newsletter</h2>
            <p class="mx-3"><?php echo $latest_newsletter_title; ?></p>
          </div>
          </div>
          <div id="previous-newsletters" class="d-flex newsletters mt-3">
          <?php
          while ($query->have_posts()) {
            $query->the_post();
            get_template_part('partials/newsletter-card');
          }
          wp_reset_postdata();
          ?>
          </div>
          <div id="load-more-container" class="d-flex newsletters mt-3">
            <!-- Load more newsletters -->
          </div>
          <div id="action-container">         
            <div class="load-more mt-4">
              <a id="load-more-newsletters" href="javascript:void(0);" data-paged="1">
                <span class="dashicons dashicons-arrow-down-alt"></span>Load More Newsletters
              </a>
          </div>           
        </div>
      </div>
  <?php
  }
}