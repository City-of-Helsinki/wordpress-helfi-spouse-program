<?php
    $border_color = "";
    $name_color = "";
    $quote_thumbnail_shape = get_sub_field('tm_quote_thumbnail_shape'); 
    $x = 1;
    if(get_sub_field('tm_line_color')){
        $border_color = "border-color: " . get_sub_field('tm_line_color') . ";";
    }
    if(get_sub_field('tm_name_color')){
        $name_color = "color: " . get_sub_field('tm_name_color') . ";";
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
                            $quote_thumbnail_url = wp_get_attachment_image_url($image);
                            ?>
                            <?php if($quote_thumbnail_shape): ?>
                                <figure class="clipped d-inline-block">
                                    <svg class="clipped__media" viewBox="0 0 600 600" width="48" height="48">
                                        <defs>
                                        <clipPath id="quote-heart-img<?php echo $x; ?>" clipPathUnits="userSpaceOnUse">
                                            <path d="m351.82,600.2H18.17C8.13,600.21,0,592.08,0,582.04V248.39C.01,27.54,267.03-83.06,423.19,73.1l103.91,103.91c156.17,156.16,45.57,423.18-175.28,423.19Z" />
                                        </clipPath>
                                        </defs>
                                        <image
                                        width="100%"
                                        height="100%"
                                        preserveAspectRatio="xMinYMin slice"
                                        xlink:href="<?php echo $quote_thumbnail_url; ?>"
                                        clip-path="url(#quote-heart-img<?php echo $x; ?>)"
                                        />
                                    </svg>
                                </figure>
                            <?php elseif($image):
                                echo wp_get_attachment_image( $image, $size, "", array('class' => 'rounded-circle') );
                            endif; ?>
                        <?php else: ?>
                            <img class="rounded-circle placeholder" >
                        <?php endif; ?>
                        <span class="author"  style="<?php echo $name_color; ?>"><?php the_sub_field('tm_quote_name') ?></span>
                        </div>
                    </blockquote>
                    </div>
                </div>
            </div>
            <?php $x++; ?>
        <?php endwhile; ?>
      </div>
    </div>

</div>
