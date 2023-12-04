<?php if( get_sub_field('youtube_video_id')) : ?>
    <div class="container mb-5">
        <?php
        if(get_sub_field('anchor_tag')){
            echo '<div id="' . get_sub_field('anchor_tag') . '" class="anchor-tag"></div>';
        }
        ?>
        <?php if(get_sub_field('text_content')){ ?>
            <div class="row">
                <div class="col-lg-6">
                    <?php the_sub_field('text_content'); ?>
                </div>
        <?php }else{ ?>
            <div class="rox d-flex justify-content-center">
        <?php } ?>
            <div class="video-wrapper <?php if(get_sub_field('text_content')){ echo 'col-lg-6'; } ?>">
                <a href="https://youtu.be/<?php the_sub_field('youtube_video_id'); ?>" class="image fancybox-youtube" data-autoplay="true" data-vbtype="video" aria-label="Video">
                    <svg class="play-btn" fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 260 180" enable-background="new 0 0 260 180" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M220,2H40C19.01,2,2,19.01,2,40v100c0,20.99,17.01,38,38,38h180c20.99,0,38-17.01,38-38V40C258,19.01,240.99,2,220,2z M102,130V50l68,40L102,130z"></path> </g></svg>
                    <?php if(get_sub_field('video_thumbnail')){
                        $image = get_sub_field('video_thumbnail');
                        $size = 'large'; // (thumbnail, medium, large, full or custom size)
                        if( $image ) {
                            echo wp_get_attachment_image( $image, $size );
                        }
                    }else{ ?>
                        <img src="https://img.youtube.com/vi/<?php echo get_sub_field('youtube_video_id'); ?>/sddefault.jpg" alt="Play video">
                    <?php } ?>
                    
                </a>
            </div>
        </div>
    </div>
<?php endif ?>