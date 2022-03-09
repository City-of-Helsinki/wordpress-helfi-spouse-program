<div class="testimonials">
  <div class="grid">
      <div class="row">
        <?php 
          while (have_rows('quotes')): the_row(); ?>
            <?php get_template_part('partials/quotes-single'); ?>
        <?php endwhile; ?>
      </div>
  </div>
</div>