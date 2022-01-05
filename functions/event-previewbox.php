<?php
/**
 * Description: Adds shortcode to display eventbrite events.
 */

add_shortcode('spouse-events', 'spouse_show_eventboxes');

/**
 * @param array $atts
 *    $atts['count'] : int - number of posts to show. -1 = all
 * @return void
 */
function spouse_show_eventboxes($atts = []){
  $count = 5;
  if(isset($atts['count']) && $atts['count'] != 0) {
    $count = $atts['count'];
  }

  $events = spouse_get_events($count);
  if(!$events){
    return '';
  }
  spouse_print_events($events);
}

function spouse_get_events($count) {
  $args = [
    'post_type' => 'eventbrite_events',
    'post_status' => 'publish',
    'numberposts' => $count,
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key'       => 'event_start_date',
            'compare'   => '>=',
            'value'     => date('Y-m-d'),
            'type'      => 'DATE',
        )
    )
  ];

  $posts = get_posts($args, OBJECT);

  return $posts;
}

function spouse_print_events($events = []){
  foreach($events as $event){

    $color = '#fff';

    $startDate = null;

    $terms = get_the_terms($event->ID, 'eventbrite_category');

    $icon = get_field('icon', $event->ID);

    $category = '';
    if($terms && $term = reset($terms)) {
      $color = get_field('event_color', $term);
      $category = $term->name;
    }

    if($dateData = get_post_meta($event->ID, 'event_start_date')) {

      $date = new \DateTime();
      $date->setTimestamp(strtotime($dateData[0]));
      $startDate = $date->format('d F');

      $hour = get_post_meta($event->ID, 'event_start_hour')[0];
      $minute = get_post_meta($event->ID, 'event_start_minute')[0];

      $endHour = get_post_meta($event->ID, 'event_end_hour')[0];
      $endMinute = get_post_meta($event->ID, 'event_end_minute')[0];
      $meridian = get_post_meta($event->ID, 'event_start_meridian')[0];
      $endMeridian = get_post_meta($event->ID, 'event_end_meridian')[0];

      $startTime = "$hour:$minute $meridian";
      $endTime = "$endHour:$endMinute $endMeridian";

      $userLoggedIn = is_user_logged_in();

      $ariaTitle = "$category. $event->post_title. {$date->format('F, d')} from $startTime to $endTime. ";
      $ariaTitle .= $userLoggedIn ? '' : __('Sign in to see more');
    }
    ?>
    <div class="col-lg-4 col-12 col-sm-12 d-flex">
    <?php if($userLoggedIn): ?>
      <a href="<?php echo get_permalink($event) ?>" <?php if($ariaTitle): ?>aria-label="<?php echo $ariaTitle; ?>" <?php endif; ?>>
          <div class="event clearfix">
    <?php else: ?>
          <div <?php if(!$userLoggedIn): ?>tabindex="0"<?php endif; ?> <?php if($ariaTitle): ?>aria-label="<?php echo $ariaTitle; ?>" <?php endif; ?> class="event clearfix">
    <?php endif; ?>

      <div class="event-content-wrap card border-0 shadow flex-fill">
          <div class="event-color" <?php if(isset($color) && $color): ?>style="background-color:<?php echo $color; ?>" <?php endif; ?>></div>
          <div class="event-content">
            <div class="event-img"  style="background-image: url(<?php echo get_the_post_thumbnail_url($event->ID, 'medium') ?>);"></div>
              <p class="event-category"><?php echo $category ?></p>
              <div class="text-content card-body">
                  <div class="event-schedule">
                    <p class="start-date"> <?php echo $startDate; ?></p>
                    <p class="duration"> <?php echo $startTime; ?> - <?php echo $endTime; ?></p>
                  </div>
                  <p class="post-title"><?php echo $event->post_title ?></p>
              </div>
          </div>
          <div class="event-icon"><img src="<?php echo $icon ?>"></div>
      </div>
    <?php if(is_user_logged_in()): ?>
      </div>
    </a>
    <?php else: ?>
    </div>
    <?php endif; ?>
    </div>
    <?php

  }
}
