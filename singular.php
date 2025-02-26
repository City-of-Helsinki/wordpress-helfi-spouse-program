<?php
get_header();
$activities_url = apply_filters('spouse_program_static_page_url', '', 'activities');
$alternative_header = get_field('alternative_page_header', get_the_ID() );
?>
<div class="container-fluid">
    <div class="row">
      <?php get_template_part( 'partials/hero' ) ?>
    </div>
</div>
<main id="main-content" class="container">
            <div class="row">
                <div class="col-12 pt-4">
                <?php
                if ($alternative_header) {
                  the_title('<h1 class="header-left medium-size">', '</h1>');
                } else {
                  the_title('<h1 class="text-center">', '</h1>');
                }
                ?>       
                </div>
            </div>
            <div class="row">
              <div class="col-12">
              <?php
              if (have_posts()) :
                while (have_posts()) :
                  the_post();
                  the_content();
                endwhile;
              endif;
            ?>
            </div>
          </div>
    <?php get_template_part('partials/flexible-content') ?>
</main><!-- #site-content -->
<?php
get_footer();
