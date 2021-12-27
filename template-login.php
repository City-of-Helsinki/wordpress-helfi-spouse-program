<?php /* Template Name: Login Page */
get_header();
?>
<main id="main-content" class="container-fluid" role="main">
    <div class="row">
        <div class="col-12 offset-0 col-lg-6 offset-lg-3">
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
</main><!-- #site-content -->
<?php
get_footer();