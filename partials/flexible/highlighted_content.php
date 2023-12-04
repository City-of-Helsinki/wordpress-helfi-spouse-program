<?php if( get_sub_field('hl_content')) : ?>
    <?php
        $id_name = wp_strip_all_tags( get_sub_field('hl_content') );
        $id_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id_name);
        $id_name = substr($id_name, 0, 12);
        $highlightTextColor = "#212529";
        $highlightColor = get_sub_field('hl_background_color');
        if(get_sub_field('hl_text_color')){
            $highlightTextColor = get_sub_field('hl_text_color');
        }
    ?>
    <style>
        <?php  echo '#' . $id_name; ?> .highlighted-content a{
            color: <?php echo $highlightTextColor; ?>;
        }
    </style>

    <div id="<?php echo $id_name; ?>" class="container mb-5">
        <?php
        if(get_sub_field('anchor_tag')){
            echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
        }
        ?>
        <div class="highlighted-content" style="background-color: <?php echo $highlightColor; ?>; color: <?php echo $highlightTextColor; ?>;">
            <?php the_sub_field('hl_content'); ?>
        </div>
    </div>
<?php endif ?>