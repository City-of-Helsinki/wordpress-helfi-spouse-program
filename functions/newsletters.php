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

    spouse_print_newsletters($newsletters);
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
    <div class="d-flex newsletters mt-3">
        <?php
        if ( is_array($newsletters) ) {
            foreach( $newsletters as $newsletter ) {
                $newsletter_title = $newsletter->post_title;
                $publish = strtotime( $newsletter->post_date );
                $publish_date = ( new \DateTime() )->setTimestamp( $publish )->format( 'j.m.Y' );
                $featured_image = get_the_post_thumbnail_url($newsletter->ID);
                $pdf = wp_get_attachment_url(get_post_meta($newsletter->ID, 'newsletter_pdf', true));
                $placeholder_image = get_field('placeholder_image', 'options_activity_setttings');
                ?>
                <div class="newsletters-column my-3">
                  <div class="newsletter clearfix">
                    <a href="<?php echo $pdf; ?>" target="_blank">
                      <div class="newsletter-content-wrap card border-0 flex-fill">
                        <div class="newsletter-content">
                          <?php if( !empty($featured_image) ): ?>
                            <div class="newsletter-featured-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
                          <?php else: ?>
                            <div class="newsletter-no-image" style="background-image: url(<?php echo $placeholder_image; ?>);"></div>
                          <?php endif; ?>
                          <div class="text-content card-body">
                            <h3 class="post-title"><?php echo $newsletter_title; ?></h3>
                            <p class="publish-date"><?php echo $publish_date; ?></p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
}