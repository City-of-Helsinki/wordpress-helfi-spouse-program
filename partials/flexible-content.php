<?php

    // check if the flexible content field has rows of data
    if( have_rows('block_elements') ):

         // loop through the rows of data
        while ( have_rows('block_elements') ) : the_row();

            if ('event' === get_post_type() ) :

                if( get_row_layout() == 'image_text_box' ): 

                    get_template_part( 'partials/flexible/image_text_box' );

                elseif( get_row_layout() == 'content_editor' ): 

                    get_template_part( 'partials/flexible/content_editor' );

                elseif( get_row_layout() == 'video' ): 

                    get_template_part( 'partials/flexible/video' );

                elseif( get_row_layout() == 'banner' ): 

                    get_template_part( 'partials/flexible/banner' );
                    
                elseif( get_row_layout() == 'spacer' ): 

                    get_template_part( 'partials/flexible/spacer' );

                elseif( get_row_layout() == 'separator' ): 

                    get_template_part( 'partials/flexible/separator' );

                elseif( get_row_layout() == 'accordion' ): 

                    get_template_part( 'partials/flexible/accordion' );

                endif;
            
            else:

                if( get_row_layout() == 'newsletter' ):
                    
                    get_template_part( 'partials/flexible/newsletter' );

                elseif( get_row_layout() == 'highlighted_content' ): 

                    get_template_part( 'partials/flexible/highlighted_content' );

                elseif( get_row_layout() == 'image_text_box' ): 

                    get_template_part( 'partials/flexible/image_text_box' );

                elseif( get_row_layout() == 'content_editor' ): 

                    get_template_part( 'partials/flexible/content_editor' );

                elseif( get_row_layout() == 'anchor_navigation' ): 

                    get_template_part( 'partials/flexible/anchor_navigation' );

                elseif( get_row_layout() == 'video' ): 

                    get_template_part( 'partials/flexible/video' );

                elseif( get_row_layout() == 'testimonials' ): 

                    get_template_part( 'partials/flexible/testimonials' );
            
                elseif( get_row_layout() == 'spacer' ): 

                    get_template_part( 'partials/flexible/spacer' );

                elseif( get_row_layout() == 'separator' ): 

                    get_template_part( 'partials/flexible/separator' );

                elseif( get_row_layout() == 'accordion' ): 

                    get_template_part( 'partials/flexible/accordion' );

                elseif( get_row_layout() == 'call_to_action' ): 

                    get_template_part( 'partials/flexible/call_to_action' );

                endif;
            endif;
        endwhile;

    else :

        // no layouts found

    endif;

?>