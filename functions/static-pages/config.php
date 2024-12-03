<?php

namespace Spouse;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function static_pages(): array {
	return array(
		'login' => array(
			'slug' => 'login',
			'title' => __( 'Sign In', 'spouse' ),
			'content' => ''
		),
		'register' => array(
			'slug' => 'register',
			'title' => __( 'Sign up', 'spouse' ),
			'content' => ''
		),
		'main-page' => array(
			'slug' => 'main-page',
			'title' => __( 'Welcome', 'spouse' ),
			'content' => ''
		),
		'activities' => array(
			'slug' => 'activities-list',
			'title' => __( 'Activities', 'spouse' ),
			'content' => ''
		),
		'thank-you' => array(
			'slug' => 'thank-you-page',
			'title' => __( 'Thank You Page', 'spouse' ),
			'content' => ''
		)
	);
}
