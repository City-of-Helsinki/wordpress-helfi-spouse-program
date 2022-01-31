<?php
get_header();
?>
  <main id="main-content" role="main">
    <div class="container">
      <div class="row">
        <div class="col-12 archive pt-4">
          <h1 class="text-center"><?php post_type_archive_title() ?></h1>
        </div>

      <div class="col-12 events-column">
        <?php
        if (have_posts()) :
          while (have_posts()) :
            the_post();
            ?>
            <div class="col-lg-4 col-12 col-sm-12 d-flex">
            <a href="<?php echo get_permalink($post) ?>">
            <div class="event">
              <div class="event-content-wrap">
              <div class="event-content">
              <?php
              $rl = new Responsive_Lightbox_Galleries(true);
              $images = $rl->get_gallery_images( get_the_ID(), array( 'exclude' => true ) );
              if ($images):
                $thumbId  = $images[0]["id"];
                ?>
                <div class="event-img" style="background-image: url(<?php echo wp_get_attachment_image_url($thumbId, 'medium') ?>"></div>
                <?php
              endif;
              ?>
              <div class="card-body">

              <div class="event-schedule">
                <p class="post-title"><?php the_title() ?></p>
              </div>
              </div>
              </div>
            </div>
              
            
            </div></a>
                
            </div> 
                <?php
          endwhile;
        endif;
        ?>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
