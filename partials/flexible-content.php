<?php

    // check if the flexible content field has rows of data
    if( have_rows('block_elements') ):

         // loop through the rows of data
        while ( have_rows('block_elements') ) : the_row();

            if( get_row_layout() == 'newsletter' ):
                
                get_template_part( 'partials/flexible/newsletter' );

            elseif( get_row_layout() == 'highlighted_content' ): 

                get_template_part( 'partials/flexible/highlighted_content' );

            elseif( get_row_layout() == 'image_text_box' ): 

                get_template_part( 'partials/flexible/image_text_box' );

            elseif( get_row_layout() == 'content_editor' ): 

                get_template_part( 'partials/flexible/content_editor' );

            endif;

        endwhile;

    else :

        // no layouts found

    endif;

?>