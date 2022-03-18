<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>
      <div class="container-fluid">
        <div class="row">
          <?php get_template_part("partials/hero"); ?>
        </div>
      </div>
      <div class="container">
          <div id="main-content" class="col-12">
            <div class="row">
                <div class="col-12 pt-4">
                  <h1 class="text-center"><?php the_title(); ?></h1>
                </div>
            </div>
      <?php
      // center
      if (have_rows('left_column_content')):
        echo '<div class="row">';
        while (have_rows('left_column_content')) : the_row();
          $type = get_sub_field('content_type');
          get_template_part('partials/'.$type);
        endwhile;
        echo '</div>';
      endif;
      ?>
      </div>
        <?php get_template_part("partials/upcoming-events") ?>
  </div>
  <?php
  // show social sharing only if the page is not behind login
    get_template_part("partials/socials") ?>
</main>

<?php get_footer(); ?>
