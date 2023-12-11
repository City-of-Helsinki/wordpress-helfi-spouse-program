<?php
    $border_color = "";
    if(get_sub_field('tm_line_color')){
        $border_color = "border-color: " . get_sub_field('tm_line_color') . ";";
    }
?>
<div class="testimonials testimonials-flexible container mb-5">
    <?php
    if(get_sub_field('anchor_tag')){
        echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
    }
    ?>
    <div class="grid">
      <div class="row">
        <?php 
        $count = count(get_sub_field('tm_quotes'));
        $single_class = "";
        if($count == 1){
            $single_class = "testimonial-single";
        }
          while (have_rows('tm_quotes')): the_row(); ?>
            <div class="<?php if($count != 1){ echo 'col-md-4 '; } ?> col-sm-12 testimonial <?php echo $single_class; ?> mb-2">
                <div class="card h-100 mb-2">
                    <div class="card-body" style="<?php echo $border_color; ?>">
                    <blockquote class="quote card-text">
                        <p class="quote-text">
                        <?php 
                        if($count == 1){
                            echo '“' . get_sub_field('tm_quote') . '”';
                        }else{
                            echo get_sub_field('tm_quote') . '”';
                        }
                        ?>
                        </p>
                        <div class="footer">
                        <?php if (!empty(get_sub_field('tm_quote_thumbnail'))): ?>
                            <?php 
                            $image = get_sub_field('tm_quote_thumbnail');
                            $size = 'medium'; // (thumbnail, medium, large, full or custom size)
                            if( $image ) {
                                echo wp_get_attachment_image( $image, $size, "", array('class' => 'rounded-circle') );
                            }
                            ?>
                        <?php else: ?>
                            <img class="rounded-circle placeholder" >
                        <?php endif; ?>
                        <span class="author"><?php the_sub_field('tm_quote_name') ?></span>
                        </div>
                    </blockquote>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
      </div>
    </div>

</div>
