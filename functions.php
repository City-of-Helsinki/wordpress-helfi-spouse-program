<?php

require_once('functions/autoloader.php');

function spouse_setup_theme(){
  add_theme_support( 'widgets' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'custom-logo', array(
    'flex-height' => true,
    'flex-width'  => true
) );
}

add_action('after_setup_theme', 'spouse_setup_theme');

add_filter( 'get_custom_logo', 'change_logo_class' );

function change_logo_class( $html ) {

    $html = str_replace( 'custom-logo', 'logo d-inline-block align-top', $html );
    $html = str_replace( 'custom-logo-link', 'navbar-brand', $html );

    return $html;
}

// add styles and javascripts
function spouse_enqueue_scripts() {

  $thank_you_page = apply_filters( 'spouse_program_static_page_url', '', 'thank-you' );
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/dist/bootstrap/dist/css/bootstrap.css');
  wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/dist/bootstrap/dist/js/bootstrap.min.js', array('jquery'));
  
  // Load Dashicons in front-end
  wp_enqueue_style( 'dashicons' );

  wp_enqueue_style('style', get_stylesheet_uri());

  if ( is_page_template('archives.php') ) {
    wp_enqueue_script('news-visited', get_template_directory_uri() . '/js/news-visited.js');
  }
  wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js');
  wp_localize_script('main', 'mainVars', array('thankYouPage' => $thank_you_page));
  wp_enqueue_script('target-blank-accessible', get_template_directory_uri() . '/js/targetblank.js');
}
add_action('wp_enqueue_scripts', 'spouse_enqueue_scripts');

if ( function_exists('register_sidebar') ) {

  $footerWidgets = [
    'footer_content_left' => 'footer content left',
    'footer_content' => 'footer content middle',
    'footer_content_right' => 'footer content right',
  ];
  $otherWidgets = [
    'sidebar_menu' => 'Sidebar menu on main page'
  ];
  foreach($footerWidgets as $key => $widget){
    register_sidebar([
        'name' => __($widget),
        'id' => $key,
        'description' => 'This is the content that is shown in site footer',
        'before_widget' => '<div class="footer-content">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
      ]
    );
  }

  foreach($otherWidgets as $key => $widget) {
    register_sidebar([
        'name' => __($widget),
        'id' => $key,
        'description' => "Content widget: $key",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
      ]
    );
  }

}

add_action( 'init', 'spouse_add_shortcodes' );

function spouse_add_shortcodes() {
  // Login form as shortcode.
  add_shortcode( 'custom-login-form', 'spouse_login_form_shortcode' );
}

function spouse_login_form_shortcode() {
  $form = wp_login_form( array( 'echo' => false ) );
  $form = str_replace('type="password"', 'type="password" autocomplete="password"', $form);
  $form = str_replace('name="log"', 'name="log" autocomplete="username"', $form);
  return $form;
}

function spouse_get_template_part($slug, $name = null) {
  do_action("ccm_get_template_part_{$slug}", $slug, $name);

  $templates = array();
  if (isset($name))
    $templates[] = "{$slug}-{$name}.php";

  $templates[] = "{$slug}.php";

  spouse_get_template_path($templates, true, false);
}

function spouse_get_template_path($template_names, $load = false, $require_once = true ) {
  $located = '';
  foreach ( (array) $template_names as $template_name ) {
    if ( !$template_name )
      continue;

    /* search file within the PLUGIN_DIR_PATH only */
    if ( file_exists(PLUGIN_DIR_PATH . $template_name)) {
      $located = PLUGIN_DIR_PATH . $template_name;
      break;
    }
  }

  if ( $load && '' != $located )
    load_template( $located, $require_once );

  return $located;
}

function spouse_create_posttypes() {
  register_post_type( 'People',
    array(
      'labels' => array(
        'name' => __( 'People' ),
        'singular_name' => __( 'Person' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'People'),
      'show_in_rest' => true,
      'supports' => array(),
    )
  );
}
add_action( 'init', 'spouse_create_posttypes' );

// Init Event CPT
function spouse_create_event_post_type() {
  register_post_type('event',
      array(
          'labels'      => array(
              'name'          => __('Activities', 'spouse'),
              'singular_name' => __('Activity', 'spouse'),
          ),
          'public'      => true,
          'has_archive' => false,
          'show_ui' => true,
          'supports' => array('title', 'thumbnail'),
          'rewrite'     => array( 'slug' => 'activities' )
      )
  );
}
add_action('init', 'spouse_create_event_post_type');

// Create "Target Group" taxonomy for events
function spouse_create_event_taxonomies() {
  register_taxonomy('target_group', array('event'), array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x( 'Target group', 'taxonomy general name' ),
      'singular_name' => _x( 'Target group', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Target groups' ),
      'all_items' => __( 'All Target groups' ),
      'parent_item' => __( 'Parent Target group' ),
      'parent_item_colon' => __( 'Parent Target group:' ),
      'edit_item' => __( 'Edit Target group' ),
      'update_item' => __( 'Update Target group' ),
      'add_new_item' => __( 'Add New Target group' ),
      'new_item_name' => __( 'New Target group Name' ),
      'menu_name' => __( 'Target groups' ),
    ),

    'rewrite' => array(
      'slug' => 'target_group',
      'with_front' => false,
      'hierarchical' => true
    ),
  ));

  register_taxonomy('location', array('event'), array(
    'hierarchical' => false,
    'labels' => array(
      'name' => _x( 'Location', 'taxonomy general name' ),
      'singular_name' => _x( 'Location', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Locations' ),
      'all_items' => __( 'All Locations' ),
      'edit_item' => __( 'Edit Location' ),
      'update_item' => __( 'Update Location' ),
      'add_new_item' => __( 'Add New Location' ),
      'new_item_name' => __( 'New Location Name' ),
      'menu_name' => __( 'Locations' )
    ),

    'rewrite' => array(
      'slug' => 'location',
      'with_front' => false,
      'hierarchical' => false
    ),
  ));
}
add_action( 'init', 'spouse_create_event_taxonomies');

function spouse_access_control_check(){
    global $post;
    global $wp;
    if($check = get_field('authenticated_users_only', $post)){
        if(!is_user_logged_in()){
          $current = home_url( $wp->request );
          $redirect_url = add_query_arg( 'redirect_to', $current, spouse_login_url() );
          wp_redirect($redirect_url);
        }
    }
}
add_action( 'template_redirect', 'spouse_access_control_check' );

function spouse_is_restricted_page(){
  global $post;
  if($check = get_field('authenticated_users_only', $post)){
      return true;
  }
  return false;
}

function spouse_is_user_allowed_page(){
  global $post;
  if($check = get_field('authenticated_users_only', $post)){
    if(!is_user_logged_in()){
      return true;
    }
  }
  return false;
}

function remove_editor() {
  if (isset($_GET['post'])) {
    $id = $_GET['post'];
    $template = get_post_meta($id, '_wp_page_template', true);
    switch ($template) {
      case 'one-column-template.php':
      case 'two-column-template.php':
        remove_post_type_support('page', 'editor');
        break;
      default :
        // Don't remove any other template.
        break;
    }
  }
}
add_action('init', 'remove_editor');

add_action('after_setup_theme', 'spouse_remove_admin_bar');

function spouse_remove_admin_bar() {
  if (!current_user_can('administrator') && !current_user_can('editor')) {
    show_admin_bar(false);
  }
}

function spouse_edit_role_caps() {
  $role = get_role( 'editor' );

  $allowed = [
    'manage_options',
    'edit_users',
    'delete_users',
    'create_users',
    'list_users',
    'remove_users',
    'promote_users',
    'mc_add_events',
    'mc_approve_events',
    'mc_manage_events',
    'mc_edit_cats',
    'mc_edit_styles',
    'mc_edit_behaviors',
    'mc_edit_templates',
    'mc_edit_settings',
    'mc_edit_locations',
  ];
  foreach($allowed as $capability) {
      $role->add_cap( $capability, true );
  }
}

// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'spouse_edit_role_caps', 11 );

add_filter( 'flamingo_map_meta_cap', 'spouse_flamingo_map_meta_cap' );

function spouse_flamingo_map_meta_cap( $meta_caps ) {
  $meta_caps = array_merge( $meta_caps, array(
    'flamingo_edit_contacts' => 'edit_pages',
    'flamingo_edit_inbound_messages' => 'edit_pages',
  ) );

  return $meta_caps;
}

add_action( 'admin_init', 'spouse_remove_menu_pages' );

function spouse_remove_menu_pages() {
    if(current_user_can('administrator')){
      return;
    }
    remove_menu_page( 'admin.php?page=wp-mailplus-settings' );
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'options-general.php' );
    remove_menu_page( 'edit.php?post_type=acf' );
    remove_menu_page( 'admin.php?page=theseoframework-settings' );
    remove_menu_page( 'admin.php?page=mobile-menu-options' );
    remove_menu_page( 'admin.php?page=sharing-plus' );
    remove_menu_page( 'admin.php?page=wow-company' );
    remove_menu_page( 'index.php' );
}

//List archives by year, then month
function wp_custom_archive($args = '') {
  global $wpdb, $wp_locale;

  $defaults = array(
    'limit' => '',
    'format' => 'html', 'before' => '',
    'after' => '', 'show_post_count' => false,
    'echo' => 1
  );

  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );

  // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
  $archive_date_format_over_ride = 0;

  // options for daily archive (only if you over-ride the general date format)
  $archive_day_date_format = 'Y/m/d';

  // options for weekly archive (only if you over-ride the general date format)
  $archive_week_start_date_format = 'Y/m/d';
  $archive_week_end_date_format   = 'Y/m/d';

  if ( !$archive_date_format_over_ride ) {
    $archive_day_date_format = get_option('date_format');
    $archive_week_start_date_format = get_option('date_format');
    $archive_week_end_date_format = get_option('date_format');
  }

  //filters
  $where = apply_filters('customarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
  $join = apply_filters('customarchives_join', "", $r);

  $output = '<ul>';

  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_custom_archive' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
    $arcresults = $wpdb->get_results($query);
    $cache[ $key ] = $arcresults;
    wp_cache_set( 'wp_custom_archive', $cache, 'general' );
  } else {
    $arcresults = $cache[ $key ];
  }
  if ( $arcresults ) {
    foreach ( (array) $arcresults as $arcresult ) {
      $url = get_month_link( $arcresult->year, $arcresult->month );
      $year_url = get_year_link($arcresult->year);
      /* translators: 1: month name, 2: 4-digit year */
      $text = sprintf(__('%s'), $wp_locale->get_month($arcresult->month));
      $year_text = sprintf('%d', $arcresult->year);
      $year_output = get_archives_link($year_url, $year_text, 'html', '','');
      $output .= ( $arcresult->year != $temp_year ) ? $year_output : '';
      #$output .= get_archives_link($url, $text, 'html', '<span class="month">', '</span>');

      $temp_year = $arcresult->year;
    }
  }

  $output .= '</ul>';

  echo $output;
}

\Spouse\LoginHandler::init();

function spouse_login_url(): string {
    return apply_filters( 'spouse_program_static_page_url', wp_login_url(), 'login' );
}

function spouse_register_url(): string {
    return apply_filters( 'spouse_program_static_page_url', '', 'register' );
}

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Theme General Settings'),
            'menu_title'    => __('Theme Settings'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}

function get_the_background_image_style( $size = 'full'){
  if ( has_post_thumbnail()){
    echo sprintf('style="background-image: url(%s);"', get_the_post_thumbnail_url(get_the_ID(), $size));
  }
}

function get_hero_text(){
  $hero = get_field('hero_text');
  return $hero ? preg_replace('/_(.*?)_/', '<span class="highlight">$1</span>', $hero) : '';
}

add_action( 'admin_head', function () {
  if (!current_user_can('manage_options')){
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    ob_start( function( $subject ) {
        $subject = preg_replace( '#<h[0-9]>'.__("Personal Options").'</h[0-9]>.+?/table>#s', '', $subject, 1 );
        return $subject;
    });
  }
});

add_action( 'admin_footer', function(){
  if (!current_user_can('manage_options')){
    ob_end_flush();
  }
});

function spouse_customize_app_password_availability( $available, $user) {
  if ( ! user_can( $user, 'manage_options' ) ) {
      $available = false;
  }

  return $available;
}
add_filter('wp_is_application_passwords_available_for_user', 'spouse_customize_app_password_availability', 10, 2);



function spouse_acf_input_admin_footer() {

  ?>
  <script type="text/javascript">
  (function($) {
      acf.add_filter('color_picker_args', function( args, $field ){

          // Add colors to color palette
          args.palettes = ["#01a090", "#4dbdb1", "#f8f3ab", "#fbd0c8", "#bac1f2", "#231f20", "#ffffff"]

          // return
          return args;

      });
})(jQuery);
</script>
<?php

}
add_action('acf/input/admin_footer', 'spouse_acf_input_admin_footer');

function spouse_notification( $wp_customize ) {
  //Setting
  $wp_customize->add_setting( 'notification_enabled', array( 'default' => false ) );
  $wp_customize->add_setting( 'notification_title', array( 'default' => '') );
  $wp_customize->add_setting( 'notification_body', array( 'default' => '' ) );
  $wp_customize->add_setting( 'notification_visibility', array( 'default' => false) );
  $wp_customize->add_setting( 'notification_color', array( 'default' => '#f0e856'));

  // Section
  $wp_customize->add_section(
    'sp-notifications',
    array(
      'title' => __('Notification', 'spouse'),
      'priority' => 30,
      'description' => __( 'Enter notification title and description' , 'spouse' )
    )
  );

  //Control
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize, 'notification_enabled',
      array(
        'label' => __( 'Enabled', 'spouse'),
        'section' => 'sp-notifications',
        'settings' => 'notification_enabled',
        'type' => 'checkbox'
      )
    )
  );
  
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize, 'notification_title',
      array(
        'label' => __( 'Title', 'spouse'),
        'section' => 'sp-notifications',
        'settings' => 'notification_title'
      )
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize, 'notification_body',
      array(
        'label' => __( 'Message', 'spouse'),
        'section' => 'sp-notifications',
        'settings' => 'notification_body'
      )
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize, 'notification_color',
      array(
        'label' => __( 'Background color (hex code)', 'spouse'),
        'section' => 'sp-notifications',
        'settings' => 'notification_color'
      )
    )
  );

}
add_action( 'customize_register', 'spouse_notification' );

// Disable admin email notifications
add_filter( 'wp_new_user_notification_email_admin', '__return_false' );
add_filter( 'send_password_change_email', '__return_false' );

add_action( 'customize_register', 'spouse_notification' );

// [spouse-cta text="some text" href="some url" rectangle="true"]
function cta($atts) {

	$a = shortcode_atts( array(
		'text' => '',
		'href' => '',
    'rectangle' => false
	), $atts );

  $cta_button = '<a class="btn btn-outline-dark mr-auto py-3 sp-cta ' . ($a["rectangle"] ? "rounded-0" : "" ) . '" href="' . esc_attr($a["href"]) . '">' . esc_attr($a["text"]) . '</a>';
  return $cta_button;
}
add_shortcode('spouse-cta', 'cta');

// Newsletter
function spouse_create_newsletter_post_type() {
  register_post_type( 'Newsletter',
  array(
    'labels' => array(
      'name' => __( 'Newsletters' ),
      'singular_name' => __( 'Newsletter' )
    ),
    'public' => true,
    'supports' => array( 'title', 'thumbnail' ),
  ) );
}
add_action( 'init' , 'spouse_create_newsletter_post_type' );

function spouse_footer_color( $wp_customize ) {
  $wp_customize->add_setting( 'footer_color', array( 'default' => ''));

  $wp_customize->add_section(
    'spouse-footer',
    array(
      'title' => __('Footer color', 'spouse'),
      'priority' => 30,
      'description' => __( 'Set footer color' , 'spouse' )
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize, 'notification_color',
      array(
        'label' => __( 'Footer color (hex code)', 'spouse'),
        'section' => 'spouse-footer',
        'settings' => 'footer_color'
      )
    )
  );
}
add_action( 'customize_register', 'spouse_footer_color');

function spouse_load_more_newsletters() {
  $ajaxposts = new WP_Query([
    'post_type' => 'newsletter',
    'posts_per_page' => 3,
    'offset' => 4,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $_POST['paged'],
    'no_found_rows' => true
  ]);

  $response = '';
  $max_pages = $ajaxposts->max_num_pages;

  if($ajaxposts->have_posts()) {
    ob_start();
    while($ajaxposts->have_posts()) : $ajaxposts->the_post();
      $response .= get_template_part('partials/newsletter-card', '', array( 'id' => get_the_ID()));
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
  } else {
    $response = '';
  }

  $result = [
    'max' => $max_pages,
    'html' => $output,
  ];

  echo json_encode($result);
  exit;
}

add_action( "wp_ajax_spouse_load_more_newsletters", "spouse_load_more_newsletters" );
add_action( "wp_ajax_no_priv_spouse_load_more_newsletters", "spouse_load_more_newsletters" );
