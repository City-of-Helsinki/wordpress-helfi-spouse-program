<div class="card col-md-4 col-sm-12">
  <div class="card-body">
    <p class="quote card-text">
      <span class="first-quote-mark">“</span>
      <?php the_sub_field('quote') ?>”
    </p>
    <img class="thumbnail" src="<?php the_sub_field('quote_thumbnail')?>" alt="Thumbnail image of <?php the_sub_field('quote_name') ?>">
    <p class="quote-name"><?php the_sub_field('quote_name') ?></p>
  </div>
</div>