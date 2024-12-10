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
        'order' => 'ASC'
    );

    $posts = wp_get_recent_posts( $args, OBJECT );

    return $posts;
}

function spouse_print_newsletters($newsletters) {
    ?>
    <div class="d-flex newsletters-wrapper">
        <?php

        if ( is_array($newsletters) ) {
            foreach( $newsletters as $newsletter ) {
                $newsletter_title = $newsletter->post_title;
                $publish_date = $newsletter->post_date;
                $featured_image = get_the_post_thumbnail($newsletter->ID);
                $pdf = wp_get_attachment_url(get_post_meta($newsletter->ID, 'newsletter_pdf', true));
                ?>
                <div class="newsletter-column">

                    <?php echo $newsletter_title; ?>
                    <?php echo $publish_date; ?>
                    <!-- <?php echo $featured_image; ?> -->
                    <?php echo $pdf; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
}