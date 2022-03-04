<div class="card col-md-4 col-sm-12">
  <div class="card-body">
    <blockquote class="quote card-text">
      <p class="quote-text">“<?php the_sub_field('quote') ?>”</p>
      <div class="footer">
        <?php if (!empty(get_sub_field('quote_thumbnail'))): ?>
          <img src="<?php the_sub_field('quote_thumbnail') ?>" >
        <?php else: ?>
          <!-- TODO FIX IMAGE PATH -->
          <img src="/wp-content/uploads/2022/03/user.svg" >
        <?php endif; ?>
        <span class="author"><?php the_sub_field('quote_name') ?></span>
      </div>
    </blockquote>
  </div>
</div>