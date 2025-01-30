<?php
$newsletter_id = $args['id'];
$newsletter_title = get_the_title($newsletter_id);
$publish = strtotime( get_post_field('post_date', $newsletter_id) );
$publish_date = ( new \DateTime() )->setTimestamp( $publish )->format( 'j.m.Y' );
$featured_image = get_the_post_thumbnail_url($newsletter_id);
$pdf = wp_get_attachment_url(get_post_meta($newsletter_id, 'newsletter_pdf', true));
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
          </div>
        </div>
      </div>
    </a>
  </div>
</div>