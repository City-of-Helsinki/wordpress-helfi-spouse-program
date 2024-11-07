<?php
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// add main menu
function spouse_menu() {
  register_nav_menu('main-menu', __( 'Main menu' ));
}
add_action( 'init', 'spouse_menu' );
add_filter( 'wp_nav_menu_objects', 'spouse_add_main_menu_to_dropdpwn', 10, 2 );

function spouse_add_main_menu_to_dropdpwn( $items, $args ) {

    // check we are in the right menu
    if( $args->theme_location == "main-menu" && is_user_logged_in() ) {
    
        $new_links = array();
        // Create a nav_menu_item object

        $menu_class = array( 'menu-item' );
        $parent_id = PHP_INT_MAX;
        foreach($items as &$item){
            $item->menu_item_parent = $parent_id;
            if ($item->current == true){
                $item->current_item_ancestor = $parent_id;
                $menu_class[] = 'active';
            }
        }

        $newItem = array(
            'title'            => __("Spouse Program"),
            'ID'               => 'spouse_main_drop_down',
            'db_id'            => $parent_id,
            'url'              => "#",
            'classes'          => $menu_class
        );

        $items[] = (object) $newItem;   // add to end of existing object.    
        return $items;
    }

    return $items;
}


function spouse_main_menu(){

    if (!is_user_logged_in()){
        return spouse_get_nav_primary();
    }

    $nav = spouse_get_nav_primary(false);
    $nav .= spouse_get_nav_secondary();
    return $nav;
}

function spouse_get_nav_primary($hasWrapper = true){
    $args = array(
        'theme_location'    => 'main-menu',
        'depth'             => 2,
        'container'         => false,
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
        'walker'            => new WP_Bootstrap_Navwalker(),
        'echo'              => false
    );
    if (!$hasWrapper){
        $args['items_wrap'] = '%3$s';
        $args['depth'] = 2;
    }

    $menu = wp_nav_menu($args);

    return $menu;
}

function spouse_get_nav_secondary(){
    return wp_nav_menu( array(
        'theme_location'    => 'sidebar-menu',
        'depth'             => 2,
        'container'         => false,
        'items_wrap'        => '%3$s',
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
        'walker'            => new WP_Bootstrap_Navwalker(),
        'echo'              => false
    ) );
}

function spouse_render_main_menu(){
    get_template_part('partials/after-body-open');
}

add_action('spouse_after_body_open', 'spouse_render_main_menu', 10);