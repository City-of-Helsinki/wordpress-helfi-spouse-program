<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function display_static_page_state( array $post_states, \WP_Post $post ): array {
	if ( 'page' !== $post->post_type ) {
		return $post_states;
	}

	$states = get_static_page_states();
	if ( isset( $states[$post->ID] ) ) {
		$post_states[$states[$post->ID]['key']] = $states[$post->ID]['title'];
	}

	return $post_states;
}


function get_static_page_states(): array {
	$states = get_static_page_states_transient();
	if ( $states ) {
		return $states;
	}

	$states = array();
	foreach ( static_pages() as $key => $page ) {
		$page_id = get_static_page_id( $key );

		if ( $page_id ) {
			$states[$page_id] = array(
				'key' => $key,
				'title' => $page['title'],
			);
		}
	}

	set_static_page_states_transient( $states );

	return $states;
}

function static_page_states_transient(): string {
	return 'spouse_program_static_pages';
}

function set_static_page_states_transient( array $pages ): bool {
	return set_transient( static_page_states_transient(), $pages, DAY_IN_SECONDS );
}

function get_static_page_states_transient(): array {
	$value = get_transient( static_page_states_transient() );

	return is_array( $value ) ? $value : array();
}

function delete_static_page_states_transient(): bool {
	return delete_transient( static_page_states_transient() );
}
