<?php

namespace Spouse;

class LoginHandler
{
    public static function init()
	{
        $self = new self();
        add_action( 'login_form_login', array( $self, 'redirect_to_custom_login' ) );
        add_filter( 'authenticate', array( $self, 'maybe_redirect_at_authenticate' ), 101, 3 );
        add_action( 'wp_logout', array( $self, 'redirect_after_logout' ) );
        add_filter( 'login_redirect', array( $self, 'redirect_after_login' ), 10, 3 );
        add_filter('wpcf7_form_elements', array($self, 'addBtnClassesToCF7Buttons') );
        $registerForm = new RegisterForm();
        $registerForm->init();

        LoginLostPasswordHandler::init( $self );
        LoginForm::init( $self );
        PasswordResetForm::init( $self );
    }

    public function redirect_logged_in_user( $redirect_to = null )
	{
        $user = wp_get_current_user();
        if ( user_can( $user, 'manage_options' ) ) {
            if ( $redirect_to ) {
                wp_safe_redirect( $redirect_to );
            } else {
                wp_redirect( admin_url() );
            }
        } else {
            //wp_redirect( home_url( 'member-account' ) );
        }
    }

    public function redirect_after_login( $redirect_to, $requested_redirect_to, $user )
	{
        $redirect_url = home_url();

        if ( ! isset( $user->ID ) ) {
            return $redirect_url;
        }

        if ( user_can( $user, 'manage_options' ) ) {
			$redirect_url = $requested_redirect_to ?: admin_url();
        } else {
			$redirect_url = $requested_redirect_to ?: apply_filters( 'spouse_program_static_page_url', '', 'main-page' );
        }

        return wp_validate_redirect( $redirect_url, home_url() );
    }

    public function redirect_to_custom_login()
	{
        if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

            // The rest are redirected to the login page
			$login_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );
			if ($login_url) {
				wp_redirect( add_query_arg( 'redirect_to', $_REQUEST['redirect_to'] ?? '', $login_url ) );
	            exit;
			}
        }
    }

    public function maybe_redirect_at_authenticate( $user, $username, $password )
	{
        // Check if the earlier authenticate filter (most likely,
        // the default WordPress authentication) functions have found errors
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            if ( is_wp_error( $user ) ) {
                $login_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );

				if ($login_url) {
					wp_redirect( add_query_arg( 'login', 'invalid', $login_url ) );
	                exit;
				}
            }
        }

        return $user;
    }

    public function redirect_after_logout()
	{
        wp_safe_redirect( home_url()  );
        exit;
    }

    public function addBtnClassesToCF7Buttons($elements)
	{
        return str_replace(
            array(
                'wpcf7-submit',
            ),
            array(
                'wpcf7-submit wpcf7-submit btn btn-primary',
            ),
            $elements
        );
    }
}
