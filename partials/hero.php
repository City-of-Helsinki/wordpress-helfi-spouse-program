<?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
        $position = get_field('hero_image_position');
        $style = "background-position: $position";
        ?>
            <div class="col-12 hero-image d-flex align-items-center justify-content-center" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
                <?php if($hero_text = get_hero_text()): ?>
                    <div class="container hero-text d-flex align-self-center justify-content-center">
                        <div class="text-container align-self-center justify-content-center">
                            <?php echo $hero_text ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
<?php endif; ?>