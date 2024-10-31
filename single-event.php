<?php get_header(); ?>

<main class="container" id="main-content">
<div class="event-container">
  <?php if( 'event' === get_post_type() ): ?>
    <?php get_template_part('partials/event-hero') ?>
    <div class="event-body">
      <?php get_template_part('partials/flexible-content') ?>
    </div>
  <?php endif; ?>
</div>
</main>

<?php get_footer(); 

