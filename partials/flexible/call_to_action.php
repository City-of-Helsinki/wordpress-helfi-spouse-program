<?php
$button_text = get_sub_field( 'spouse_cta_text' );
$button_url = get_sub_field( 'spouse_cta_url' );
$button_shape_field = get_sub_field( 'button_shape' );
$button_shape = $button_shape_field == true ? '1rem' : '';
$background_color = get_sub_field( 'spouse_cta_background_color' );
$text_color = get_sub_field( 'spouse_cta_text_color' );
?>

<div class="col-12 my-3">
    <a href="<?php echo $button_url; ?>" class="col-12 mr-auto py-3 flex-cta" style="background-color:<?php echo $background_color; ?>; border-radius:<?php echo $button_shape; ?>; color:<?php echo $text_color; ?>;">
        <?php echo $button_text; ?>
    </a>
</div>