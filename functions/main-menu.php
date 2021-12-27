<?php
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// add main menu
function spouse_menu() {
  register_nav_menu('main-menu', __( 'Main menu' ));
  register_nav_menu('sidebar-menu', __('Sidebar menu on main page') );
}
add_action( 'init', 'spouse_menu' );

function spouse_main_menu(){
  return wp_nav_menu( array(
      'theme_location'  => 'main-menu',
      'depth'           => 2,
      'container'       => 'div',
      'container_class' => 'collapse navbar-collapse',
      'container_id'    => 'bs-example-navbar-collapse-1',
      'menu_class'      => 'navbar-nav mr-auto',
      'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
      'walker'          => new WP_Bootstrap_Navwalker()
  ) );
}