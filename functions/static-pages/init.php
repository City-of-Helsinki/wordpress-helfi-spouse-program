<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'admin_notices', __NAMESPACE__ . '\\notify_if_required_static_pages_are_missing' );

add_action( 'admin_init', __NAMESPACE__ . '\\register_static_pages_settings' );
add_action( 'updated_option', __NAMESPACE__ . '\\handle_static_page_option_updated', 10, 3 );
add_action( 'after_delete_post', __NAMESPACE__ . '\\handle_page_removed' );
add_action( 'trashed_post', __NAMESPACE__ . '\\handle_page_removed' );

add_action( static_pages_settings_section(), __NAMESPACE__ . '\\render_generate_static_pages_button' );
add_action( 'admin_post_' . generate_static_pages_action(), __NAMESPACE__ . '\\handle_auto_generate_static_pages' );
add_action( 'spouse_program_page_created', __NAMESPACE__ . '\\handle_spouse_program_page_created', 10, 3 );

add_filter( 'spouse_program_static_page_id', __NAMESPACE__ . '\\provide_static_page_id', 1, 2 );
add_filter( 'spouse_program_static_page_url', __NAMESPACE__ . '\\provide_static_page_url', 1, 2 );
add_filter( 'display_post_states', __NAMESPACE__ . '\\display_static_page_state', 10, 2 );
