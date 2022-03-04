<div class="testimonials">
  <div class="row flex-row">
    <?php 
      while (have_rows('quotes')): the_row(); ?>
        <?php get_template_part('partials/quotes-single'); ?>
    <?php endwhile; ?>
  </div>
</div>