<?php
/**
 * Description: Adds shortcode "spouse-events" to display activities.
 */
add_shortcode('spouse-events', 'spouse_show_eventboxes');

/**
 * @param array $atts
 *    $atts['count'] : int - number of posts to show. -1 = all
 * @return string
 */
function spouse_show_eventboxes($atts) { 

    $events = spouse_get_events();
    if (!$events->have_posts()) {
        return '<div class="d-flex justify-content-center w-100"><h4>Sorry, no activities found at the moment! :(</h4></div>';
    }

    ob_start();
    spouse_print_events($events);
    return ob_get_clean();
}

/**
 * WP_Query to show all the past activities in ascending order
 */
function spouse_get_events() {

    $today = date('Y-m-d H:i:s');

    $args = array(
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_key'       => 'start_time',
        'orderby'        => 'meta_value',
        'meta_type'      => 'DATE',
        'order'          => 'ASC',
        'paged'          => 1,
        'meta_query'     => array(
            array(
                'key'     => 'start_time',
                'value'   => $today,
                'compare' => '<',
                'type'    => 'DATETIME'
            )
    )
    );

    return new WP_Query($args);
}

/**
 * Print past activities sorted by years and months
 */
function spouse_print_events($events) {
  if (!$events->have_posts()) {
      return;
  }

  $groupedData = [];
  while ($events->have_posts()) : $events->the_post();
      $date = strtotime(get_field('start_time'));
      $year = date('Y', $date);
      $month = date('F', $date);
      $groupedData[$year][$month][] = get_the_ID();
  endwhile;
  wp_reset_postdata();

  krsort($groupedData);

  foreach ($groupedData as &$months) {
      uksort($months, function ($a, $b) {
          return date_parse($a)['month'] <=> date_parse($b)['month'];
      });
  }
  unset($months);

  // First year opened by default
  $firstYear = key($groupedData);
  ?>
<div class="event-navigation"><a href="javascript:void(0);" onclick="window.history.back(); return false;" 
class="go-back"><span class="dashicons dashicons-arrow-left-alt2"></span></a></div>
  <div id="current-events-container" class="d-flex events-wrapper">
      <?php foreach ($groupedData as $year => $months) : ?>
          <div class="year-container">
              <div class="events-year">
                  <h2 class="year-toggle <?php echo ($year === $firstYear) ? 'active' : ''; ?>" data-year="<?php echo $year; ?>">
                            <?php echo $year; ?>
                            <span class="dashicons dashicons-arrow-down-alt2 arrow <?php echo ($year === $firstYear) ? 'arrow-up' : 'arrow-down'; ?>"></span>
  
                  </h2>
              </div>
              <div id="year-<?php echo $year; ?>" class="year-content" style="display: <?php echo ($year === $firstYear) ? 'block' : 'none'; ?>;">
                  <?php foreach ($months as $month => $events_list) : ?>
                      <div id="<?php echo sanitize_title($month); ?>" class="months-container">
                          <div class="events-month">
                              <h3><?php echo $month; ?></h3>
                          </div>
                          <?php foreach ($events_list as $event_id) : ?>
                              <?php
                              $event_post = get_post($event_id);
                              if ($event_post) {
                                  global $post;
                                  $post = $event_post;
                                  setup_postdata($post);
                                  get_template_part('partials/activities-card');
                                  wp_reset_postdata();
                              }
                              ?>
                          <?php endforeach; ?>
                      </div>
                  <?php endforeach; ?>
              </div>
          </div>
      <?php endforeach; ?>
  </div>
  <?php
}
