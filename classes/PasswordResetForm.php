<?php

namespace Spouse;

class PasswordResetForm extends LoginFormHandler
{
    public $slugKey = 'password-reset';
    public $template = 'template-login.php';

    public static function init(LoginHandler $loginHandler)
    {
        $self = new self();
        $self->loginHandler = $loginHandler;

            add_action('template_redirect', array($self, 'setupForm'), 10);
            add_action( 'login_form_rp', array( $self, 'redirect_to_custom_password_reset' ) );
            add_action( 'login_form_resetpass', array( $self, 'redirect_to_custom_password_reset' ) );
            add_action( 'login_form_rp', array( $self, 'do_password_reset' ) );
            add_action( 'login_form_resetpass', array( $self, 'do_password_reset' ) );

    }

    public function redirect_to_custom_password_reset()
    {
        if ( 'GET' === $_SERVER['REQUEST_METHOD']) {
            // Verify key / login combo
            $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
            if ( ! $user || is_wp_error( $user ) ) {
				$redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );

				if ( $redirect_url ) {
					$key_value = ($user && $user->get_error_code() === 'expired_key') ? 'expiredkey' : 'invalidkey';

					wp_redirect( add_query_arg( 'login', $key_value, $redirect_url) );
					exit;
				}
            }

            $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'password-reset' );
			if ( $redirect_url ) {
				wp_redirect(
					add_query_arg( array(
						'login' => esc_attr( $_REQUEST['login'] ),
						'key' => esc_attr( $_REQUEST['key'] ),
					), $redirect_url )
				);
				exit;
			}
        }
    }

    public function renderForm()
    {
        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );

        if ( is_user_logged_in() ) {
            echo __( 'You are already signed in.', 'personalize-login' );
        } else {
            if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
                $attributes['login'] = $_REQUEST['login'];
                $attributes['key'] = $_REQUEST['key'];

                // Error messages
                $errors = array();
                if ( isset( $_REQUEST['error'] ) ) {
                    $error_codes = explode( ',', $_REQUEST['error'] );

                    foreach ( $error_codes as $code ) {
                        $errors[] = $this->get_error_message( $code );
                    }
                }
                $attributes['errors'] = $errors;

                get_template_part('partials/login/password-reset-form', null, $attributes);
            } else {
                echo __( 'Invalid password reset link.', 'personalize-login' );
            }
        }
    }

    public function do_password_reset()
    {
        if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
            $rp_key = $_REQUEST['rp_key'];
            $rp_login = $_REQUEST['rp_login'];

            $user = check_password_reset_key( $rp_key, $rp_login );

            if ( ! $user || is_wp_error( $user ) ) {
				$redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );

				if ( $redirect_url ) {
					$key_value = ($user && $user->get_error_code() === 'expired_key') ? 'expiredkey' : 'invalidkey';

					wp_redirect( add_query_arg( 'login', $key_value, $redirect_url) );
					exit;
				}
            }

            if ( isset( $_POST['pass1'] ) ) {
                if ( $_POST['pass1'] != $_POST['pass2'] ) {
                    // Passwords don't match
                    $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'password-reset' );

					if ( $redirect_url ) {
						wp_redirect( add_query_arg( array(
							'key' => $rp_key,
							'login' => $rp_login,
							'error' => 'password_reset_mismatch',
						), $redirect_url ) );
						exit;
					}
                }

                if ( empty( $_POST['pass1'] ) ) {
                    // Password is empty
                    $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'password-reset' );

					if ( $redirect_url ) {
						wp_redirect( add_query_arg( array(
							'key' => $rp_key,
							'login' => $rp_login,
							'error' => 'password_reset_empty',
						), $redirect_url ) );
						exit;
					}
                }

                // Parameter checks OK, reset password
                reset_password( $user, $_POST['pass1'] );
                $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );

				if ($redirect_url) {
					wp_redirect( add_query_arg( 'password', 'changed', $redirect_url ) );
					exit;
				}
            } else {
                echo "Invalid request.";
            }

            exit;
        }
    }
}
