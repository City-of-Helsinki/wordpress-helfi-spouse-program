<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function notify_if_required_static_pages_are_missing(): void {
	$missing_pages = check_for_missing_static_pages();

	if ( $missing_pages ) {
		echo missing_static_pages_notice( $missing_pages );
	}
}

function missing_static_pages_notice( array $names ): string {
	return sprintf(
		'<div class="notice notice-error">
			<h2>%s</h2>
			<p><strong>%s</strong>: %s.</p>
			<p>%s</p>
		</div>',
		esc_html__( 'Spouse Program', 'spouse' ),
		esc_html__( 'Required pages are not set', 'spouse' ),
		esc_html( implode( ', ', $names ) ),
		sprintf(
			'%s <a href="%s">%s</a> %s.',
			esc_html__( 'Please visit', 'spouse' ),
			esc_url( static_pages_settings_page_url() ),
			__( 'settings page', 'spouse' ),
			esc_html__( 'to set the required pages', 'spouse' )
		)
	);
}

function check_for_missing_static_pages(): array {
	$missing = get_missing_static_pages_transient();
	if ( $missing ) {
		return $missing;
	}

	foreach ( static_pages() as $key => $page ) {
		if ( ! get_static_page_id( $key ) ) {
			$missing[] = $page['title'];
		}
	}

	set_missing_static_pages_transient( $missing );

	return $missing;
}

function missing_static_pages_transient(): string {
	return 'spouse_program_missing_static_pages';
}

function set_missing_static_pages_transient( array $pages ): bool {
	return set_transient( missing_static_pages_transient(), $pages, DAY_IN_SECONDS );
}

function get_missing_static_pages_transient(): array {
	$value = get_transient( missing_static_pages_transient() );

	return is_array( $value ) ? $value : array();
}

function delete_missing_static_pages_transient(): bool {
	return delete_transient( missing_static_pages_transient() );
}
