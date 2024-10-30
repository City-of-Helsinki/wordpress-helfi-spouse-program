<?php
  $current_url = home_url( $_SERVER['REQUEST_URI'] );
  $success_url = add_query_arg( array('newsletter' => 'success'), $current_url );
  $failure_url = add_query_arg( array('newsletter' => 'fail'), $current_url );

  $full_width = false;
  if(get_sub_field('newsletter_full_width')){
    $full_width = true;
  }

  $background_color = 'background-color: transparent;';
  $text_color = 'color: #212529;';
  $button_background_color = 'background-color: #bac1f2;';
  $button_text_color = 'color: #212529;';

  if(get_sub_field('newsletter_background_color')){
    $background_color = 'background-color: ' . get_sub_field('newsletter_background_color') . ';';
  }
  if(get_sub_field('newsletter_text_color')){
    $text_color = 'color: ' . get_sub_field('newsletter_text_color') . ';';
  }
  if(get_sub_field('newsletter_button_background_color')){
    $button_background_color = 'background-color: ' . get_sub_field('newsletter_button_background_color') . ';';
  }
  if(get_sub_field('newsletter_button_text_color')){
    $button_text_color = 'color: ' . get_sub_field('newsletter_button_text_color') . ';';
  }

  $newsletter_status = isset( $_GET["newsletter"] ) ? esc_attr( $_GET["newsletter"] ) : '';
  $hide_newsletter_form = false;
  $newsletter_message = '';
  if ( 'success' == $newsletter_status){
    $hide_newsletter_form = true;
    $newsletter_message = sprintf('<h3 class="py-5 d-flex justify-content-center">%s</h3>',  get_sub_field('subscribed_successfully_text') );
  } elseif ( 'fail' === $newsletter_status){
    $newsletter_message = sprintf('<h3 class="pb-3 d-flex justify-content-center">%s</h3>', get_sub_field('subscription_failed_text') );
  }

?>

<?php
if(!$full_width){
  echo '<div class="container mb-5">';
}
?>
<div class="newsletter container-fluid <?php echo ($full_width ? 'newsletter-full-width' : ''); ?>" id="newsletter" style="<?php echo $background_color; ?> <?php echo $text_color; ?>">
  <?php
  if(get_sub_field('anchor_tag')){
    echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
  }
  ?>
  <div class="row justify-content-center">
    <div class="col-12 col-lg-5 col-md-6 py-lg-5 py-md-4 py-3">
      <?php
      echo $newsletter_message;
      if (!$hide_newsletter_form): ?>
      <h3 class="font-weight-bold"><?php the_sub_field("newsletter_section_title"); ?></h3>
      <div class="liana-form" id="newsletter">
        <?php the_sub_field("newsletter_mailer_form"); ?>
        <p><?php the_sub_field("newsletter_body_text");?></p>
        <form method="post" action="<?php the_sub_field("liana_subscription_page"); ?>" class="lianamailer">
          <input type="hidden" name="success_url" value="<?php echo $success_url; ?>#newsletter">
          <input type="hidden" name="failure_url" value="<?php echo $failure_url; ?>#newsletter">
          <div class="mb-3 email">
            <label for="newsletterEmail" class="form-label">Email address*</label>
            <input id="newsletterEmail" name="email" type="email" aria-label="Leave an email address to subscribe to the newsletter" class="form-control border border-dark" required></input>
          </div>
          <div class="mb-3 radio-buttons row mx-0">
            <?php if (have_rows("mailing_list_ids")):
              while ( have_rows("mailing_list_ids") ) : the_row();
                $target_group = get_sub_field("target_group");
                $liana_id = get_sub_field("liana_id");
                $target = sprintf(
                  '<div class="form-check target-group-%s col-6">
                    <input required class="form-check-input" type="radio" name="join" id="liana-id-%1$s" value="%1$s">
                    <label class="form-check-label mt-0 ml-2" for="liana-id-%1$s">
                    %2$s
                  </label>
                </div>', $liana_id, $target_group);
                echo $target;
              endwhile;
              endif ?>
          </div>
          <div class="mb-3 privacy-policy form-check">
            <input required type="checkbox" class="form-check-input" id="privacyPolicyCheck">
            <label class="form-check-label mt-0 ml-2" for="privacyPolicyCheck"><?php echo get_sub_field('newsletter_consent_text'); ?></a></label>
          </div>
          <div class="mb-3 d-flex justify-content-center">
            <button type="submit" class="btn subscribe px-5"  style="<?php echo $button_background_color; ?> <?php echo $button_text_color; ?>">Subscribe</button>
          </div>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
if(!$full_width):
  echo '</div>';
endif;
?>