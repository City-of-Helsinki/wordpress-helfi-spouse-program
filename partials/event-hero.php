<?php 
$id = get_the_ID();
$event_url = get_field('event_url', $id );
$event_url_text = get_field('read_more_text', $id ) ? get_field('read_more_text', $id ) : 'Read more';
$event_color = get_field('event_color', $id );
$start = ( new \DateTime() )->setTimestamp( strtotime( get_field( 'start_time', $id)));
$end = ( new \DateTime() )->setTimestamp( strtotime( get_field( 'end_time', $id )));
$location = get_field('location', $id);

$event_img = get_the_post_thumbnail_url(get_the_ID(), 'large');
$placeholder_img = 'https://spouseprogram.fi/wp-content/uploads/2024/10/Logo-without-text-and-favicon.png';

$startDate = $start->format('l j F Y');
$startTime = $start->format('H.i');
$endTime   = $end->format('H.i');
$terms = get_the_terms($id, 'target_group');
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
        $color = '#4dbdb1';
    }
?>
<div class="event-navigation"><a href="<?php echo site_url('/activities'); ?>" class="go-back"><span class="dashicons dashicons-arrow-left-alt2"></span></a> </div>
<div class="event-top">
    <?php if( $event_img ):?>
        <div class="event-image" style="background-image: url(' <?php echo $event_img; ?>');"></div>
    <?php else:?>
        <div class="event-image" style="background-image: url(' <?php echo $placeholder_img; ?>'); background-size: contain;"></div>
    <?php endif; ?>
    
      <div class="event-details">
        <span class="event-publish-date">
        </span>
        <div class="event-header">
            <h1><?php echo get_the_title();?></h1>
            <h2><?php echo get_field('event_short_description', $id); ?></h2>
        </div>
        <div class="event-meta">
            <?php
            if (!empty($category)) :
            ?>
            <div class="event-category"><span class="category-btn" style="background-color: <?php echo $color; ?>;"><?php echo $category; ?></span></div>
            <?php endif; ?>  
            <div class="meta-table">
                <div class="event-info"><span class="meta-title">Date:</span><span class="meta-info"><?php echo $startDate; ?></span></div>
                <div class="event-info"><span class="meta-title">Time:</span><span class="meta-info"><?php echo $startTime . ' &ndash; ' . $endTime; ?></span></div>
                <div class="event-info"><span class="meta-title">Place:</span><span class="meta-info"><?php echo $location->name; ?></span></div>
            </div>
            <?php if( ! empty($event_url)): ?>    
                <a class="event-read-more btn" href="<?php echo get_field('event_url', $id ); ?>" target="_blank"><?php echo $event_url_text; ?></a>
            <?php endif; ?>
            </div>
        </div>
    </div>