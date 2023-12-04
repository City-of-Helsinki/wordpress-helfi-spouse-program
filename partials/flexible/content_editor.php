<?php if( get_sub_field('ce_content')) : ?>
    <div class="container mb-5">
        <?php
        if(get_sub_field('anchor_tag')){
            echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
        }
        ?>
        <?php the_sub_field('ce_content'); ?>
    </div>
<?php endif ?>