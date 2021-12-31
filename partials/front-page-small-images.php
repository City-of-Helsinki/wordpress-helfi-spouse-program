<div class="small-images py-2">
    <?php
    while ( have_rows('images') ) : the_row();
        $img = get_sub_field('image');
        if (!empty($img['url'])):
        ?>
        <div class="small-images__image">
            <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>"/>
        </div>
    <?php
        endif;
    endwhile;
    ?>
</div>