<?php get_header(); ?>

<main class="container-fluid">
  <div class="row">
      <?php get_template_part('partials/hero') ?>
      <div class="col-12 pt-4"><h1 class="text-center"><?php echo the_title(); ?></h1></div>
      <div class="col-12 col-lg-6 offset-lg-3">
          <div class="single-event-meta" style="color:black;">
              <?php the_content() ?>
          </div>
      </div>

  </div>
</main>

<?php get_footer(); ?>
