<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function render_generate_static_pages_button(): void {
	if ( check_for_missing_static_pages() ) {
		printf(
			'<p><a class="button button-primary" href="%s">%s</a></p>',
			esc_url( static_pages_action_url() ),
			esc_html__( 'Generate required pages', 'spouse' )
		);
	}
}

function static_pages_action_url(): string {
	return wp_nonce_url(
		add_query_arg(
			'action',
			generate_static_pages_action(),
			admin_url( 'admin-post.php' )
		),
		generate_static_pages_action()
	);
}

function generate_static_pages_action(): string {
	return 'spouse_program_generate_static_pages';
}
