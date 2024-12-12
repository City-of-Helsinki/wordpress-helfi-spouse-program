<?php /*Template Name: Front-page-member-template */ ?>

<?php get_header(); ?>

      <div class="row">
          <?php get_template_part("partials/hero"); ?>
          <div class="container">
            <?php get_template_part("partials/user"); ?>
            <?php get_template_part("partials/upcoming-events") ?>
      </div>
    </div>
</main>

<?php get_footer(); ?>
