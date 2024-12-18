<?php
$accordionObject = get_sub_field('accordion_items');
?>
<div class="container">
    <div class="accordion my-3">
        <h3><?php echo get_sub_field('section_header'); ?></h3>
        <?php
        if ( have_rows('accordion_items') ) :
            while ( have_rows('accordion_items') ) : the_row(); ?>
                <div class="accordion-item">
                    <div 
                        id="question-<?php echo get_row_index(); ?>"
                        class="h-3 w-100 py-2 d-block border-bottom"
                        data-toggle="collapse" 
                        data-target="#answer-<?php echo get_row_index(); ?>"
                    >
                        <span>
                            <?php echo get_sub_field('accordion_question'); ?>
                        </span>
                    </div>
    
                    <div
                        id="answer-<?php echo get_row_index(); ?>" 
                        class="py-2 collapse"
                    >
                        <?php echo get_sub_field('accordion_answer'); ?>
                    </div>
                </div>
            <?php endwhile;
        endif; ?>
    </div>
</div>