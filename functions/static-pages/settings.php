<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function static_pages_settings_page(): string {
	return 'reading';
}

function static_pages_settings_capability(): string {
	return 'manage_options';
}

function static_pages_settings_page_url(): string {
	return admin_url( 'options-reading.php' );
}

function static_pages_settings_section(): string {
	return 'spouse_program_static_pages';
}

function static_pages_settings_prefix(): string {
	return 'spouse_program_page_';
}

function get_static_page_id( string $key ): int {
	return (int) get_option( static_pages_settings_prefix() . $key, 0 );
}

function update_static_page_id( string $key, int $page_id ): bool {
	return update_option( static_pages_settings_prefix() . $key, $page_id );
}

function register_static_pages_settings(): void {
	$settings_section = static_pages_settings_section();
	$settings_page = static_pages_settings_page();

	add_settings_section(
		$settings_section,
		__( 'Spouse Program static pages', 'spouse' ),
		__NAMESPACE__ . '\\render_static_page_settings_section',
		$settings_page
	);

	$prefix = static_pages_settings_prefix();
	$page_options = get_static_pages_options();

	foreach ( static_pages() as $key => $page ) {
		$setting_name = $prefix . $key;

		register_setting(
			$settings_page,
			$setting_name,
			array(
				'type' => 'integer',
				'description' => $page['title'],
				'sanitize_callback' => 'absint',
				'show_in_rest' => false,
				'default' => 0,
			)
		);

		add_settings_field(
			$setting_name,
			$page['title'],
			__NAMESPACE__ . '\\render_static_page_setting_field',
			$settings_page,
			$settings_section,
			array(
				'key' => $key,
				'name' => $setting_name,
				'value' => get_static_page_id( $key ),
				'options' => $page_options,
			)
		);
	}
}

function render_static_page_settings_section( array $args ): void {
	do_action( static_pages_settings_section() );
}

function render_static_page_setting_field( array $args ): void {
	printf(
		'<select name="%s">%s</select>',
		esc_attr( $args['name'] ),
		get_select_options_html( $args['options'], $args['value'] )
	);

	$url = apply_filters( 'spouse_program_static_page_url', '', $args['key'] );
	if ( $url ) {
		printf(
			'<p class="description"><a href="%s" target="_blank">%s<a/></p>',
			esc_url( $url ),
			esc_html__( 'View page', 'spouse' )
		);
	}
}

function get_select_options_html( array $options, $current ): string {
	$html = array(
		0 => get_select_option_html( '', __( 'Select' ), $current ),
	);

	foreach ( $options as $value => $label ) {
		$html[] = get_select_option_html( $value, $label, $current );
	}

	return implode( '', $html );
}

function get_select_option_html( $value, $label, $current ): string {
	return sprintf(
		'<option value="%s" %s>%s</option>',
		esc_attr( $value ),
		selected( $value, $current, false ),
		esc_html( $label )
	);
}

function get_static_pages_options(): array {
	$options = array();
	foreach ( query_published_pages() as $page ) {
		$options[$page->ID] = $page->post_title;
	}

	return $options;
}

function query_published_pages(): array {
	return ( new \WP_Query() )->query( array(
		'post_type' => 'page',
		'post_status' => 'publish',
		'posts_per_page' => 500,
		'orderby' => 'ASC',
		'order' => 'title',
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	) );
}
