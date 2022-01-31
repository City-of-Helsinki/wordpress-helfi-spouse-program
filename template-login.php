<?php /* Template Name: Login Page */
get_header();
?>
<main id="main-content" class="login container-fluid" role="main">
    <div class="login__container row">
        <div class="col-12 offset-0 col-lg-5 login__content p-4">
            <div class="row">
                <div class="col-6">
                    <?php  if ( has_custom_logo() ) : the_custom_logo(); endif; ?>
                </div>
                <div class="col-6 align-self-center back-link">
                    <a href="<?php echo home_url() ?>">&lt; <?php _e("Back to front page"); ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1><?php the_title(); ?></h1>
                    <?php
                    do_action('spouse_before_content');
                    if (have_posts()) :
                        while (have_posts()) :
                        the_post();
                        the_content();
                        endwhile;
                    endif;
                    do_action('spouse_after_content');
                ?>
                </div>
            </div>
        </div>
        <div class="col-lg-7 login__hero d-flex" <?php get_the_background_image_style() ?>>
            <?php if($hero_text = get_hero_text() ): ?>
                    <div class="row align-self-center justify-content-center hero-text">
                        <div class="col-md-8 col-lg-6 text-container">
                            <p><?php echo $hero_text ?></p>
                        </div>
                    </div>
            <?php endif ?>
        </div>
    </div>
</main><!-- #site-content -->

<?php wp_footer(); ?>

    </body>
</html>
