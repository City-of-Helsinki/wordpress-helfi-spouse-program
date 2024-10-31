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
		'account' => array(
			'slug' => 'member-account',
			'title' => __( 'Your Account', 'spouse' ),
			'content' => ''
		),
		'password-lost' => array(
			'slug' => 'password-lost',
			'title' => __( 'Forgot Your Password?', 'spouse' ),
			'content' => ''
		),
		'password-reset' => array(
			'slug' => 'member-password-reset',
			'title' => __( 'Pick a New Password', 'spouse' ),
			'content' => ''
		),
		'main-page' => array(
			'slug' => 'main-page',
			'title' => __( 'Welcome', 'spouse' ),
			'content' => ''
		),
		'main-page' => array(
			'slug' => 'activities-list',
			'title' => __( 'Acticities', 'spouse' ),
			'content' => ''
		)
	);
}
