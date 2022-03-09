<div class="col-md-4 col-sm-12 testimonial mb-2">
  <div class="card h-100 mb-2">
    <div class="card-body">
      <blockquote class="quote card-text">
        <p class="quote-text">
          <?php the_sub_field('quote') ?>”
        </p>
        <div class="footer">
          <?php if (!empty(get_sub_field('quote_thumbnail'))): ?>
            <img src="<?php the_sub_field('quote_thumbnail') ?>" class="rounded-circle" >
          <?php else: ?>
            <!-- TODO FIX IMAGE PATH -->
            <img class="rounded-circle placeholder" >
          <?php endif; ?>
          <span class="author"><?php the_sub_field('quote_name') ?></span>
        </div>
      </blockquote>
    </div>
  </div>
</div>