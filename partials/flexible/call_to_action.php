<?php
$button_text = get_sub_field( 'spouse_cta_text' );
$button_url = get_sub_field( 'spouse_cta_url' );
$button_shape_field = get_sub_field( 'button_shape' );
$background_color = get_sub_field( 'spouse_cta_background_color' );
$text_color = get_sub_field( 'spouse_cta_text_color' );
?>

<div class="row mt-2 mb-3">
    <div class="container">
        <div class="col-12 my-3">
            <a href="<?php echo $button_url; ?>" class="mr-auto py-3 px-3 flex-cta" style="background-color:<?php echo $background_color; ?>; color:<?php echo $text_color; ?>;">
                <?php echo $button_text; ?>
            </a>
        </div>
    </div>

</div>