<?php
if ( is_user_logged_in() && !current_user_can('administrator') && !current_user_can('editor')) {
    if(wp_redirect('main-page')) {
      exit;
    }
}
?>
<?php
get_header();

$side = 'right';
if(get_field('image_position')){
  $side = 'left';  
}
$card_title = get_the_title();
$highlightTextColor = "#212529";
$highlightColor = get_field('background_color');
if(get_field('text_color')){
  $highlightTextColor = get_field('text_color');
}
$post_thumbnail_url = get_the_post_thumbnail_url();
?>

<style>
    #hero-heart a{
        color: <?php echo $highlightTextColor; ?>;
    }
    #hero-heart .lift-100-wide__links a.arrow{
        color: <?php echo $highlightTextColor; ?> !important;
    }

</style>

<main id="main-content" role="main">
  <div class="col-12 col-sm-12 <?php if(!get_field('hero_style')){ echo 'cta-column'; } ?> p-0 container-fluid">
        <?php if(get_field('hero_style')): ?>
          <div id="hero-heart" class="lift-100-wide lift-100-wide-drop lift-100-wide--<?php echo $side; ?> w-100 h-100" style="background-color: <?php echo $highlightColor; ?>;">
            <div class="container">
                <div class="row position-relative">

                    <?php if($side == 'right'): ?>
                        <div class="p-lg-4 p-3 col-lg-6 d-flex flex-column justify-content-center" style="color: <?php echo $highlightTextColor; ?>;" >
                            <h3 class="lift-100-wide__title"><?php echo $card_title ; ?></h3>
                            <p class="lift-100-wide__text"><?php the_field("ingress"); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="p-lg-4 <?php if($side == 'right'){ echo 'pl-lg-5'; }else{ echo 'pr-lg-5'; } ?> p-sm-3 col-lg-6 d-flex flex-column justify-content-center" >
                        <?php if($post_thumbnail_url):?>
                            <figure class="clipped">
                                <svg class="clipped__media" viewBox="0 0 600 600">
                                    <defs>
                                    <clipPath id="hero-heart-img" clipPathUnits="userSpaceOnUse">
                                        <path d="m351.82,600.2H18.17C8.13,600.21,0,592.08,0,582.04V248.39C.01,27.54,267.03-83.06,423.19,73.1l103.91,103.91c156.17,156.16,45.57,423.18-175.28,423.19Z" />
                                    </clipPath>
                                    </defs>
                                    <image
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMinYMin slice"
                                    xlink:href="<?php echo $post_thumbnail_url; ?>"
                                    clip-path="url(#hero-heart-img)"
                                    />
                                </svg>
                            </figure>
                        <?php else: ?>
                            <figure class="clipped">
                                <svg class="clipped__media" viewBox="0 0 600 600">
                                    <defs><style>.hero-heart-img {fill:#4dbdb1;}</style></defs>
                                    <path class="hero-heart-img" d="m351.82,600.2H18.17C8.13,600.21,0,592.08,0,582.04V248.39C.01,27.54,267.03-83.06,423.19,73.1l103.91,103.91c156.17,156.16,45.57,423.18-175.28,423.19Z" />
                                </svg>
                            </figure>
                        <?php endif; ?>
                    </div>

                    <?php if($side == 'left'): ?>
                        <div class="p-lg-4 p-3 col-lg-6 d-flex flex-column justify-content-center" style="color: <?php echo $highlightTextColor; ?>;" >
                            <h3 class="lift-100-wide__title"><?php echo $card_title ; ?></h3>
                            <p class="lift-100-wide__text"><?php the_field("ingress"); ?></p>
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
          <div class="cta-background" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>); background-position: center center;">
            <?php $buttonEnabled = get_field('enable_cta-button') ?>
            <?php if($buttonEnabled): ?>
              <?php get_template_part('partials/cta'); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      
  </div>
  <div class="container">
      <div class="row flex-column">
          <div class="col-12 col-sm-12 main-content">
              <div class="main-content-container">
                <?php
                if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                endif;
                ?>
                <?php get_template_part("partials/upcoming-events") ?>
                <?php get_template_part('partials/front-page-small-images') ?>
              </div>
          </div>
          
      </div>
  </div>
  <?php get_template_part('partials/flexible-content') ?>
</main><!-- #site-content -->

<?php
get_footer();
