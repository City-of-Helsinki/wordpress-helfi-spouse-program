<?php
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// add main menu
function spouse_menu() {
  register_nav_menu('main-menu', __( 'Main menu' ));
  register_nav_menu('sidebar-menu', __('Sidebar menu on main page') );
}
add_action( 'init', 'spouse_menu' );

function spouse_main_menu(){
    if (!is_user_logged_in()){
        return spouse_get_nav_primary();
    }
    $wrap  = '<li class="nav-item dropdown">';
    $wrap .= '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">%s</a>';
    $wrap .= '<ul class="dropdown-menu">%s</ul>';
    $wrap .= '</li>'; 
    $nav = sprintf($wrap, __("Start"), spouse_get_nav_primary(false));
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
        $args['walker'] = null;
        $args['depth'] = 1;
    }

    $menu = wp_nav_menu($args);

    if (!$hasWrapper){
        $menu = preg_replace('/<a /', '<a class="nav-link"', $menu);
    }

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