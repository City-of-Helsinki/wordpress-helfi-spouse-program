<?php get_header(); ?>

<script>
  window.spouse_events_counts = JSON.parse('<?php echo json_encode($count)?>');
  window.spouse_events = JSON.parse('<?php echo json_encode($events)?>');
</script>

<main class="container" id="main-content">
  <div class="row">
    <div class="col-12">
        <h1 class="text-center"><?php _e("Events") ?></h1>
    </div>
  </div>
  <div class="row">
    <?php get_template_part("partials/upcoming-events") ?>
  </div>
</main>
<?php get_footer();
