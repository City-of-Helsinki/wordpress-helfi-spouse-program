<?php
$bannerTextColor = "#212529";
$bannerColor = get_sub_field('al_background_color');
if(get_sub_field('al_text_color')){
    $bannerTextColor = get_sub_field('al_text_color');
}
?>

<div class="anchorlink-container" style="background: <?php echo $bannerColor; ?>">
    <nav class="container anchorlink-navigation" aria-label="Anchor links">
        <?php
        // Check rows exists.
        if( have_rows('anchor_links') ):

            echo '<ul>';

            // Loop through rows.
            while( have_rows('anchor_links') ) : the_row();

                echo '<li>';
                echo '<a style="color: ' . $bannerTextColor  . ';" href="#' . get_sub_field('al_anchor_tag') . '"><span class="inline-svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.6 32.1" xml:space="preserve" role="presentation"><path style="fill-rule:evenodd;clip-rule:evenodd" d="M32.6 16.1 16.5 0l-2.8 2.8 11.4 11.3H0v4h25L13.7 29.3l2.8 2.8z"></path></svg></span>' . get_sub_field('al_anchor_link_text') . '</a>';
                echo '</li>';

            // End loop.
            endwhile;

            echo '</ul>';

        endif;
        ?>
    </nav>
</div>