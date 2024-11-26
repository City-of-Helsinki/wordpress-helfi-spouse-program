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
function spouse_show_eventboxes($atts){ 
  $count = -1;
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
  $args = array (
    'post_type' => 'event',
    'post_status' => 'publish',
    'numberposts' => $count,
    'meta_key' => 'start_time',
    'orderby' => 'meta_value',
    'order' => 'ASC',
  );

  $posts = wp_get_recent_posts($args, OBJECT);

  return $posts;
}

function spouse_print_events($events) {
  ?>
  <div class="col-12 col-sm-12 d-flex events-wrapper">
  <?php

  if ( is_array($events) ) {
    foreach( $events as $event ) {

      if ( strtotime(get_field( 'start_time', $event->ID )) < current_time('timestamp') ) {
        continue;
      }

      $terms = get_the_terms($event->ID, 'target_group');
      $event_color = get_field('event_color', $event->ID );
      $category = '';

      if($terms && $term = reset($terms)) {
        $category = $term->name;
      }

      if (!empty($event_color)) {
        $color = $event_color;
      }
      elseif ($category === 'Community') {
        $color = '#bac1f2';
      }
      elseif ($category === 'Career support') {
        $color = '#fbd0c8';
      }
      elseif ($category === 'Company partner') {
        $color = '#f8f3ab';
      } else {
        $color = '#fff';
      }

      if( get_field( 'start_time', $event->ID) ) {

        $start = ( new \DateTime() )->setTimestamp( strtotime( get_field( 'start_time', $event->ID )));
        $end = ( new \DateTime() )->setTimestamp( strtotime( get_field( 'end_time', $event->ID )));

        $start_date = $start->format('l j F Y');
        $start_date_short = $start->format('j F Y');
        $end_date_short = $end->format('j F Y');
        $start_time = $start->format('H.i');
        $end_time = $end->format('H.i');
      }

      $aria_title = "$category. $event->post_title. { $start_date } from $start_time to $end_time. ";
      $event_img = get_the_post_thumbnail_url($event->ID, 'medium');
      $placeholder_img = get_field('placeholder_image', 'options_activity_setttings');

      ?>
      <div class="events-column">
        <div class="event clearfix" <?php if(isset($color)): ?>style="background-color:<?php echo $color; ?>" <?php endif; ?>>
          <a href="<?php echo get_permalink($event) ?>" <?php if($aria_title): ?>aria-label="<?php echo $aria_title; ?>" <?php endif; ?>>
          <div class="event-content-wrap card border-0 flex-fill">       
            <div class="event-content">
              <?php if( !empty($event_img) ) : ?>
                <div class="event-img" style="background-image: url(<?php echo $event_img ?>);"></div>
              <?php elseif(empty($event_img) && !empty($category)) : ?>
                <div class="event-no-image" style="background-color: <?php echo $color ?>;"><span class="event-category"><?php echo $category ?> Activity</span></div>
              <?php else : ?>
                <div class="event-no-image-cat" style="background-image: url(<?php echo $placeholder_img ?>);"></div>
              <?php endif; ?>
              <div class="text-content card-body">
                <p class="post-title"><?php echo $event->post_title ?></p>
                <div class="event-schedule">
                <?php if($start_date_short !== $end_date_short): ?>
                  <p class="start-date"> <?php echo $start_date_short . ' ' . $start_time; ?> &ndash; </p>
                  <p class="start-date"> <?php echo $end_date_short . ' ' . $end_time; ?></p>
                <?php else: ?>
                  <p class="start-date"> <?php echo $start_date; ?></p>
                  <p class="duration"> <?php echo $start_time; ?> &ndash; <?php echo $end_time; ?></p>
                <?php endif; ?>
              </div>             
              </div>
            </div>
          </div>          
          </a>
        </div>
      </div>
      <?php
    }
  }
  ?>
  </div>
  <?php
}



