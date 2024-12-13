<?php
    if(get_sub_field('it_title')){
        $id_name = wp_strip_all_tags( get_sub_field('it_title') );
    }else{
        $id_name = wp_strip_all_tags( get_sub_field("it_text_body") );
    }
    $id_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id_name);
    $id_name = substr($id_name, 0, 12);
    $img_id = 'img_' . $id_name;
    $highlightTextColor = "#212529";
    $highlightColor = get_sub_field('it_background_color');
    if(get_sub_field('it_text_color')){
        $highlightTextColor = get_sub_field('it_text_color');
    }

    $arrow_right = '<svg class="hds-arrow-right" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><rect width="24" height="24"></rect><polygon fill="currentColor" points="10.5 5.5 12 7 8 11 20.5 11 20.5 13 8 13 12 17 10.5 18.5 4 12" transform="matrix(-1 0 0 1 24.5 0)"></polygon></g></svg>';

    $card_title = get_sub_field("it_title");

    $side = 'right';
    if(get_sub_field('it_image_position')){
        $side = 'left';
    }

    $show_caption = get_sub_field('it_show_caption');
    $caption = attachment_url_to_postid( get_sub_field('it_background_image') );

?>

<style>
    <?php  echo '#' . $id_name; ?> a{
        color: <?php echo $highlightTextColor; ?>;
    }
    <?php  echo '#' . $id_name; ?> .lift-100-wide__links a.arrow{
        color: <?php echo $highlightTextColor; ?> !important;
    }

</style>

<?php
if(get_sub_field('it_style')){
?>

<div class="container">
    <?php
    if(get_sub_field('anchor_tag')){
        echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
    }
    ?>
    <div id="<?php echo $id_name; ?>" class="lift-100-wide lift-100-wide-drop lift-100-wide--<?php echo $side; ?> w-100 h-100 my-5 <?php echo(get_sub_field('it_rounded_corners') ? 'rounded-corners' : '');?>" style="background-color: <?php echo $highlightColor; ?>;">
        <div class="container">
            <div class="row position-relative">

                <?php if($side == 'right'): ?>
                    <div class="p-lg-4 p-3 col-lg-6 d-flex flex-column justify-content-center" style="color: <?php echo $highlightTextColor; ?>;" >
                        <h3 class="lift-100-wide__title"><?php echo $card_title ; ?></h3>
                        <p class="lift-100-wide__text"><?php the_sub_field("it_text_body"); ?></p>
                        <div class="lift-100-wide__links">
                            <ul class="m-0 p-0">
                            <?php while( have_rows('it_links') ): the_row();
                                $link = get_sub_field("it_link");
                                $text = get_sub_field("it_link_text");
                                $arialabel = '';
                                if(str_contains($text, 'more')):
                                    $arialabel = 'aria-label="More about '.  $card_title .'"';
                                elseif(str_contains($text, 'lisää')):
                                    $arialabel = 'aria-label="Lisää aiheesta '.  $card_title .'"';
                                endif;
                                printf('<li class="my-2"><a class="arrow" %s href="%s">%s</a></li>', $arialabel, $link, $text);
                            endwhile; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="p-lg-4 <?php if($side == 'right'){ echo 'pl-lg-5'; }else{ echo 'pr-lg-5'; } ?> p-sm-3 col-lg-6 d-flex flex-column justify-content-center" >
                    <?php if(get_sub_field("it_background_image")):?>
                        <figure class="clipped">
                            <svg class="clipped__media" viewBox="0 0 600 600">
                                <defs>
                                <clipPath id="<?php echo $img_id; ?>" clipPathUnits="userSpaceOnUse">
                                    <path d="m351.82,600.2H18.17C8.13,600.21,0,592.08,0,582.04V248.39C.01,27.54,267.03-83.06,423.19,73.1l103.91,103.91c156.17,156.16,45.57,423.18-175.28,423.19Z" />
                                </clipPath>
                                </defs>
                                <image
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMinYMin slice"
                                xlink:href="<?php the_sub_field("it_background_image");?>"
                                clip-path="url(#<?php echo $img_id; ?>)"
                                />
                            </svg>
                        </figure>
                    <?php else: ?>
                        <figure class="clipped">
                            <svg class="clipped__media" viewBox="0 0 600 600">
                                <defs><style>.<?php echo $img_id; ?>{fill:<?php echo get_sub_field('heart_shape_background_color'); ?>;}</style></defs>
                                <path class="<?php echo $img_id; ?>" d="m351.82,600.2H18.17C8.13,600.21,0,592.08,0,582.04V248.39C.01,27.54,267.03-83.06,423.19,73.1l103.91,103.91c156.17,156.16,45.57,423.18-175.28,423.19Z" />
                            </svg>
                        </figure>
                    <?php endif; ?>
                </div>

                <?php if($side == 'left'): ?>
                    <div class="p-lg-4 p-3 col-lg-6 d-flex flex-column justify-content-center" style="color: <?php echo $highlightTextColor; ?>;" >
                        <h3 class="lift-100-wide__title"><?php echo $card_title ; ?></h3>
                        <p class="lift-100-wide__text"><?php the_sub_field("it_text_body"); ?></p>
                        <div class="lift-100-wide__links">
                            <ul class="m-0 p-0">
                            <?php while( have_rows('it_links') ): the_row();
                                $link = get_sub_field("it_link");
                                $text = get_sub_field("it_link_text");
                                $arialabel = '';
                                if(str_contains($text, 'more')):
                                    $arialabel = 'aria-label="More about '.  $card_title .'"';
                                elseif(str_contains($text, 'lisää')):
                                    $arialabel = 'aria-label="Lisää aiheesta '.  $card_title .'"';
                                endif;
                                printf('<li class="my-2"><a class="arrow" %s href="%s">%s</a></li>', $arialabel, $link, $text);
                            endwhile; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php }else{ ?>

<div class="container">
    <?php
    if(get_sub_field('anchor_tag')){
        echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
    }
    ?>
    <div id="<?php echo $id_name; ?>" class="lift-100-wide lift-100-wide--<?php echo $side; ?> w-100 h-100 my-5">
        <div class="container">
            <div class="row position-relative">
                <div class="img-wrapper lift-100-wide__bg-img h-100 col-lg-8 p-0">
                    <img class="p-0 w-100 <?php echo(get_sub_field('it_rounded_corners') ? 'rounded-corners' : '');?>" alt="" src="<?php the_sub_field("it_background_image");?>">
                    <?php if ( true == $show_caption ): ?>
                    <figcaption class="d-flex">
                        <span class="ml-auto">
                            <?php echo (wp_get_attachment_caption( $caption ) ); ?></figcaption>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="lift-100-wide__card p-lg-4 p-sm-3 col-lg-6 d-flex flex-column justify-content-center <?php echo(get_sub_field('it_rounded_corners') ? 'rounded-corners' : '');?>" style="background-color: <?php echo $highlightColor; ?>" style="background-color: <?php echo $highlightColor; ?>; color: <?php echo $highlightTextColor; ?>;" >
                    <h3 class="lift-100-wide__title"><?php echo $card_title ; ?></h3>
                    <p class="lift-100-wide__text"><?php the_sub_field("it_text_body"); ?></p>
                    <div class="lift-100-wide__links">
                        <ul class="m-0 p-0">
                        <?php while( have_rows('it_links') ): the_row();
                            $link = get_sub_field("it_link");
                            $text = get_sub_field("it_link_text");
                            $arialabel = '';
                            if(str_contains($text, 'more')):
                                $arialabel = 'aria-label="More about '.  $card_title .'"';
                            elseif(str_contains($text, 'lisää')):
                                $arialabel = 'aria-label="Lisää aiheesta '.  $card_title .'"';
                            endif;
                            printf('<li class="my-2"><a class="arrow" %s href="%s">%s</a></li>', $arialabel, $link, $text);
                        endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>