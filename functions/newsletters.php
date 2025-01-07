<?php
/**
 * Description: Adds shortcode to display newsletter archive
 */

add_shortcode('spouse-archive', 'spouse_show_archive');

function spouse_show_archive($atts) {

    $newsletters = spouse_get_newsletters();

    if (!$newsletters) {
        return '';
    }

    ob_start();
    spouse_print_newsletters($newsletters);
    return ob_get_clean();
}

function spouse_get_newsletters() {
    $args = array (
        'post_type' => 'newsletter',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'order' => 'DESC'
    );

    $posts = wp_get_recent_posts( $args, OBJECT );

    return $posts;
}

function spouse_print_newsletters($newsletters) {
    ?>
        <?php
        if ( is_array($newsletters) ) {
            $placeholder_image = get_field('placeholder_image', 'options_activity_setttings');
            $latest_newsletter = $newsletters[0];
            $latest_pdf = wp_get_attachment_url(get_post_meta($latest_newsletter->ID, 'newsletter_pdf', true));
            $latest_featured_image = get_the_post_thumbnail_url($latest_newsletter->ID);
            $latest_publish_date = ( new \DateTime() )->setTimestamp( strtotime( $latest_newsletter->post_date ) )->format( 'j.m.Y' );
            $latest_newsletter_title = $latest_newsletter->post_title;
            ?>
            <div class="d-flex latest-newsletter pb-4">
                <a class="col-4 col-sm-12 col-lg-4" href="<?php echo $latest_pdf; ?>" target="_blank">
                    <div class="newsletter">
                      <div class="newsletter-content-wrap card border-0 flex-fill">
                          <div class="newsletter-content">
                            <?php if( !empty($latest_featured_image) ): ?>
                              <div class="newsletter-featured-image" style="background-image: url(<?php echo $latest_featured_image; ?>);"></div>
                            <?php else: ?>
                              <div class="newsletter-no-image" style="background-image: url(<?php echo $placeholder_image; ?>);"></div>
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
              $older_newsletters = array_slice($newsletters, 1);
              foreach( $older_newsletters as $newsletter ) {
                  get_template_part('partials/newsletter-card');
              }
              ?>
            </div>
            <div class="load-more row mt-3">
              <button id="load-more-newsletters" class="btn mx-auto" onclick="loadMoreNewsletters()">See previous letters</button>
            </div>
            <?php
        }
        ?>
    <?php
}