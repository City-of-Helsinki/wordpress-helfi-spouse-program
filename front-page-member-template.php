<?php /*Template Name: Front-page-member-template */ ?>

<?php get_header(); ?>

      <div class="row">
          <?php get_template_part("partials/hero"); ?>
          <div class="container">
            <?php get_template_part("partials/user"); ?>
            <?php get_template_part("partials/upcoming-events") ?>
      </div>
    </div>
  <?php
  // show social sharing only if the page is not behind login
  get_template_part("partials/socials") ?>
</main>

<?php get_footer(); ?>
