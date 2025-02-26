<?php

$selected_taxonomy = isset($_GET['taxonomy']) ? sanitize_text_field($_GET['taxonomy']) : 'all';
$target_group = get_sub_field('ab_target_group');
$show_filters = get_sub_field('ab_show_filters');
$anchor_tag = get_sub_field('ab_anchor_tag');
$action_container = get_sub_field('ab_show_action_container');
$activities_url = apply_filters('spouse_program_static_page_url', '', 'activities');
$compact_mode = get_sub_field('ab_compact_mode');
$activities_header = get_sub_field('ab_header');

$count = get_sub_field('ab_posts_amount') ? get_sub_field('ab_posts_amount') : 6;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$today = date('Y-m-d H:i:s');

/**
 * WP_Query to show the future activities in ascending order in the first page
 * Default count amount: 6
 */
$args = array(
    'post_type'      => 'event',
    'post_status'    => 'publish',
    'posts_per_page' => $count,
    'meta_key'       => 'start_time',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'paged'          => $paged,
    'meta_query'     => array(
        array(
            'key'     => 'start_time',
            'value'   => $today,
            'compare' => '>=',
            'type'    => 'DATETIME'
        )
    )
);

// Check taxonomies to be filtered by filter-button or ACF-field
if ($selected_taxonomy !== 'all') {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'target_group',
            'field'    => 'slug',
            'terms'    => array($selected_taxonomy),
            'operator' => 'IN',
        ),
    );
} elseif (!empty($target_group)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'target_group',
            'field'    => 'term_id',
            'terms'    => $target_group->term_id,
            'operator' => 'IN',
        ),
    );
}

$events = new WP_Query($args);

if ( !empty($compact_mode) ) { echo '<div class="container">'; }

if ( !empty($activities_header) ) {  
    echo '<h3 class="activities-header mb-5"><strong>' . $activities_header . '</strong></h3>';
}

if ( $events->have_posts() ) :
    $current_month_year = null;

    if ( !empty($show_filters) && empty($compact_mode) ) :
       
        $terms = get_terms([
            'taxonomy'   => 'target_group',
            'hide_empty' => true,
        ]);
    
        $active_filter = isset($_GET['taxonomy']) ? sanitize_text_field($_GET['taxonomy']) : 'all';
        $default_bg_color = '#4dbdb1';
        ?>
        
        <div class="event-filters">
            <h3>Types of activities</h3>
            
            <button class="taxonomy-filter-button btn <?php echo ($active_filter === 'all') ? 'active' : ''; ?>" 
            data-filter="all" 
            style="<?php echo ($active_filter === 'all') ? "background-color: $default_bg_color; border: 2px solid $default_bg_color;" : "border: 2px solid $default_bg_color;"; ?>"
            <?php echo ($active_filter === 'all') ? 'disabled' : ''; ?>>
            All activities
            </button>
    
            <?php foreach ($terms as $term) :
                switch ($term->name) {
                    case 'Community':
                        $button_bg_color = '#bac1f2';
                        break;
                    case 'Career support':
                        $button_bg_color = '#fbd0c8';
                        break;
                    case 'Company partner':
                        $button_bg_color = '#f8f3ab';
                        break;
                    default:
                        $button_bg_color = '#4dbdb1';
                        break;
                }
    
                $is_active = ($active_filter === $term->slug);
                ?>
                <button class="taxonomy-filter-button btn <?php echo $is_active ? 'active' : ''; ?>"
                    data-filter="<?php echo esc_attr($term->slug); ?>" 
                    style="<?php echo $is_active ? "background-color: $button_bg_color; border: 2px solid $button_bg_color;" : "border: 2px solid $button_bg_color;"; ?>"
                    <?php echo $is_active ? 'disabled' : ''; ?>>
                    <?php echo esc_html($term->name); ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div id="current-events-container" class="d-flex events-wrapper">

    <?php 
        if ($compact_mode): 
        // Compact mode
        ?>
            <div class="events-row">
                <?php while ($events->have_posts()) : $events->the_post();
                    get_template_part('partials/activities-card');
                endwhile; ?>
            </div>
        
        <?php else:

        // Normal mode
            while ($events->have_posts()) : $events->the_post();
                $start_timestamp = strtotime(get_field('start_time', get_the_ID()));
                $event_month_year = date('F Y', $start_timestamp);

                if ($event_month_year !== $current_month_year) {
                    if (!is_null($current_month_year)) {
                        echo '</div></div>';
                    }
                    $current_month_year = $event_month_year;
                    ?>
                    <div class="events-row">
                    <div id="<?php echo sanitize_title($current_month_year); ?>" class="months-container">
                        <div class="events-month">
                            <h3><?php echo $current_month_year; ?></h3>
                        </div>
                    <?php
                }

                get_template_part('partials/activities-card');

            endwhile;

        echo '</div></div>';

        endif;
        
        if ( !empty($action_container) && empty($compact_mode) ):
        ?>
            <div id="load-more-container">
                <!-- Load more events -->
            </div>

            <div id="action-container">
                <?php if ($events->max_num_pages > 1) : ?>
                <div class="load-more mt-4">
                    <a id="load-more-events" href="javascript:void(0);" 
                    data-paged="1" 
                    data-taxonomy="<?php echo esc_attr($selected_taxonomy); ?>">
                        <span class="dashicons dashicons-arrow-down-alt"></span>Load More Activities
                    </a>
                </div>
                <?php endif; ?>
                
                <div class="see-past mt-5">
                    <a id="see-past-events" href="<?php echo $activities_url; ?>"><span class="dashicons dashicons-arrow-right-alt"></span>See past activities</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
endif;
wp_reset_postdata();

if ( !empty($compact_mode) ) { echo '</div>'; }