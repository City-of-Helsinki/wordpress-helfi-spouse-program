<?php
    if(get_sub_field('banner_title')){
        $id_name = wp_strip_all_tags( get_sub_field('banner_title') );
    }else{
        $id_name = wp_strip_all_tags( get_sub_field("banner_text_body") );
    }
    $id_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id_name);
    $id_name = substr($id_name, 0, 12);
    $img_id = 'img_' . $id_name;
    $banner_text_color = get_sub_field('banner_text_color') ?: '#fff';
    $banner_accent_color = get_sub_field('banner_accent_color') ?: '#fff';
    $banner_bg_color = get_sub_field('banner_background_color') ?: '#231f20';
    $banner_title = get_sub_field("banner_title");
    $banner_bg_image = get_sub_field("banner_background_image");
    $banner_img_only = get_sub_field("banner_image_only");
?>

<div class="banner-container" style="color: <?php echo $banner_text_color; ?>; background-color: <?php echo $banner_bg_color; ?>;">
    <div id="<?php echo $id_name; ?>" class="lift-100-wide lift-100-wide-drop lift-100-wide-- w-100 h-100 my-5" >
    <?php if( !$banner_img_only ):?>
             
        <div class="banner-shape" style="background-image: url(' <?php echo $banner_bg_image; ?>');"></div>
            <div class="row position-relative">
                <div class="col-lg-6 d-flex flex-column justify-content-center banner-content">
                    <h3 class="banner-title" style="color: <?php echo $banner_accent_color; ?>;"><?php echo $banner_title ; ?></h3>
                    <div class="banner-text"><?php the_sub_field("banner_text_body"); ?></div>
                    <div class="banner-extras">
                        <ul class="m-0 p-0">
                            <?php while( have_rows('banner_extra_fields') ): the_row();
                                $extra_prefix = get_sub_field("banner_extra_field_prefix");
                                $extra = get_sub_field("banner_extra_field");
                                printf('<li><span style="color: %s;">%s</span> - %s</li>', $banner_accent_color, $extra_prefix, $extra);
                            endwhile; ?>
                        </ul>               
                    </div>
                </div>          
            </div>
        </div>
    <?php else: ?>
        <div class="banner-full" style="background-image: url(' <?php echo $banner_bg_image; ?>');"></div>
    <?php endif; ?>
    </div>
</div>
