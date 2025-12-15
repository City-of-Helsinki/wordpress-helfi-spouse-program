<?php

require_once( get_stylesheet_directory() . '/classes/cookies/Spouse_News_Visited_Cookie.php' );
require_once( get_stylesheet_directory() . '/classes/cookies/Spouse_Hide_Notification_Cookie.php' );

/**
 * Add Spouseprogram custom made cookies to the cookie banner.
 * Each cookie is separated into their own classes as shown below.
 */
if ( did_action( 'wordpress_helfi_cookie_consent_loaded' ) ) {
    add_filter( 'wordpress_helfi_cookie_consent_known_cookies', function( array $cookies ): array {
        return array_merge( $cookies, [
            Spouse_News_Visited_Cookie::class,
            Spouse_Hide_Notification_Cookie::class,
        ] );
    } );
}