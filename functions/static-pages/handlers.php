<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function handle_static_page_option_updated( string $option, $old_value, $value ): void {
	if ( false !== strpos( $option, static_pages_settings_prefix() ) ) {
		delete_missing_static_pages_transient();
		delete_static_page_states_transient();
	}
}

function handle_page_removed( int $post_id ): void {
	$states = get_static_page_states();
	if ( isset( $states[$post_id]['key'] ) ) {
		update_static_page_id( $states[$post_id]['key'], 0 );
	}

	delete_missing_static_pages_transient();
	delete_static_page_states_transient();
}

function provide_static_page_id( int $post_id, string $key ): int {
	return get_static_page_id( $key ) ?: $post_id;
}

function provide_static_page_url( string $url, string $key ): string {
	$page_id = get_static_page_id( $key );
	$permalink = $page_id ? get_permalink( $page_id ) : '';

	return $permalink ?: $url;
}

function handle_auto_generate_static_pages(): void {
	if ( can_handle_auto_generate_static_pages() ) {
		generate_static_pages();
	}

	wp_redirect( static_pages_settings_page_url() );
	die;
}

function can_handle_auto_generate_static_pages(): bool {
	return check_admin_referer( generate_static_pages_action() )
		&& current_user_can( static_pages_settings_capability() );
}

function generate_static_pages(): void {
	foreach ( static_pages() as $key => $page ) {
		if ( ! get_static_page_id( $key ) ) {
			$post_id = wp_insert_post(
				array(
					'post_content'   => $page['content'],
					'post_name'      => $page['slug'],
					'post_title'     => $page['title'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'ping_status'    => 'closed',
					'comment_status' => 'closed',
				)
			);

			do_action( 'spouse_program_page_created', $post_id, $key, $page );
		}
	}
}

function handle_spouse_program_page_created( int $page_id, string $key, array $data ): void {
	if ( $page_id ) {
		update_static_page_id( $key, $page_id );
	}
}
