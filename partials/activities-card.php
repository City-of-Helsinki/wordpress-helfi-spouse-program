<?php
$event_color = get_field('event_color', get_the_ID() );
$event_title = get_the_title( get_the_ID() );

if (empty($target_group)) {

    $category = '';
    $terms = get_the_terms( get_the_ID(), 'target_group');

    if($terms && $term = reset($terms)) {
        $category = $term->name;
    } 
} else {
    $category = $target_group->name;
}

if (!empty($bg_color)) {
    $color = $bg_color;
}
elseif (!empty($event_color)) {
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

if( get_field( 'start_time', get_the_ID()) ) {

     $start = strtotime( get_field( 'start_time', get_the_ID() ));
     $end = strtotime( get_field( 'end_time', get_the_ID() ));

     $start_date = date('l j F Y', $start);
     $start_date_short = date('j F Y', $start);
     $end_date_short = date('j F Y', $end);
     $start_time = date('H.i', $start);
     $end_time = date('H.i', $end);
 }

$aria_title = "$category. $event_title.";
if (!empty($start_date) && !empty($start_time) && !empty($end_time)) {
    $aria_title .= " $start_date from $start_time to $end_time.";
}

$event_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$placeholder_img = get_field('placeholder_image', 'options_activity_setttings');

?>
<div class="events-column">
    <div class="event clearfix" <?php if (isset($color)) : ?>style="background-color:<?php echo esc_attr($color); ?>" <?php endif; ?>>
        <a href="<?php echo get_permalink(get_the_ID()); ?>" <?php if (!empty($aria_title)) : ?>aria-label="<?php echo esc_attr($aria_title); ?>" <?php endif; ?>>
            <div class="event-content-wrap card border-0 flex-fill">
                <div class="event-content">
                    <?php if (!empty($event_img)) : ?>
                        <div class="event-img" style="background-image: url(<?php echo esc_url($event_img); ?>);"></div>
                    <?php elseif (empty($event_img) && !empty($category)) : ?>
                        <div class="event-no-image" style="background-color: <?php echo esc_attr($color); ?>;">
                            <span class="event-category"><?php echo esc_html($category); ?> Activity</span>
                        </div>
                    <?php else : ?>
                        <div class="event-no-image-cat" style="background-image: url(<?php echo esc_url($placeholder_img); ?>);"></div>
                    <?php endif; ?>

                    <div class="text-content card-body">
                        <p class="post-title"><?php echo esc_html($event_title); ?></p>
                        <div class="event-schedule">
                            <?php if (!empty($start_date_short) && !empty($end_date_short) && $start_date_short !== $end_date_short) : ?>
                                <p class="start-date"><?php echo esc_html($start_date_short . ' ' . $start_time); ?> &ndash;</p>
                                <p class="start-date"><?php echo esc_html($end_date_short . ' ' . $end_time); ?></p>
                            <?php elseif (!empty($start_date)) : ?>
                                <p class="start-date"><?php echo esc_html($start_date); ?></p>
                                <?php if (!empty($start_time) && !empty($end_time)) : ?>
                                    <p class="duration"><?php echo esc_html($start_time); ?> &ndash; <?php echo esc_html($end_time); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>