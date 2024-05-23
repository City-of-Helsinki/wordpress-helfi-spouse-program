<?php

namespace Spouse;

class LoginLostPasswordHandler extends LoginFormHandler
{
    private $loginHandler = null;
    public $slugKey = 'password-lost';
    public $template = 'template-login.php';

    public static function init(LoginHandler $loginHandler)
	{
        $self = new self();
        $self->loginHandler = $loginHandler;
            add_action( 'login_form_lostpassword', array( $self, 'redirectCustomLostPassword' ) );
            add_action('template_redirect', array($self, 'setupForm'), 10);
            add_action( 'login_form_lostpassword', array( $self, 'do_password_lost' ) );
    }

    public function doActions()
	{
        remove_action('spouse_after_body_open', 'spouse_render_main_menu', 10);
    }

    public function redirectCustomLostPassword()
	{
        if ( 'GET' === $_SERVER['REQUEST_METHOD'] ) {
            if ( is_user_logged_in() ) {
                $this->loginHandler->redirect_logged_in_user();
                exit;
            }

            $redirect_url = apply_filters( 'spouse_program_static_page_url', '', $this->slugKey );
			if ($redirect_url) {
				wp_redirect($redirect_url);
				exit;
			}
        }
    }

    public function renderForm()
	{
        $attr = array(
            "valid" => true
        );
        if($_REQUEST['errors'] == 1){
            $attr["valid"] = false;
        }
        get_template_part('partials/login/lostpassword-form', null, $attr);
    }

    public function do_password_lost()
	{
        if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
            $errors = retrieve_password();
            if ( is_wp_error( $errors ) ) {
                // Errors found
                $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'password-lost' );
                $redirect_url = $redirect_url ? add_query_arg( 'errors', 1, $redirect_url ) : '';
            } else {
                // Email sent
                $redirect_url = apply_filters( 'spouse_program_static_page_url', '', 'login' );
                $redirect_url = $redirect_url ? add_query_arg( 'checkemail', 'confirm', $redirect_url ) : '';
            }

			if ($redirect_url) {
				wp_redirect($redirect_url);
				exit;
			}
        }
    }
}
