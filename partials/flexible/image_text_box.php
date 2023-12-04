<?php
    $id_name = wp_strip_all_tags( get_sub_field('it_title') );
    $id_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id_name);
    $id_name = substr($id_name, 0, 12);
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
    <div id="<?php echo $id_name; ?>" class="lift-100-wide lift-100-wide-drop lift-100-wide--<?php echo $side; ?> w-100 h-100 my-5" style="background-color: <?php echo $highlightColor; ?>;">
        <div class="container">
            <div class="row position-relative">
                <img style="border-radius: 50%; margin-top: 20px; margin-bottom: 20px;" class="lift-100-wide__bg-img h-100 col-lg-6 p-0" alt="" src="<?php the_sub_field("it_background_image");?>">
                <div class="lift-100-wide__card p-lg-4 p-sm-3 col-lg-6 d-flex flex-column justify-content-center" style="color: <?php echo $highlightTextColor; ?>;" >
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
                <img class="lift-100-wide__bg-img h-100 col-lg-8 p-0" alt="" src="<?php the_sub_field("it_background_image");?>">
                <div class="lift-100-wide__card p-lg-4 p-sm-3 col-lg-6 d-flex flex-column justify-content-center" style="background-color: <?php echo $highlightColor; ?>; color: <?php echo $highlightTextColor; ?>;" >
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