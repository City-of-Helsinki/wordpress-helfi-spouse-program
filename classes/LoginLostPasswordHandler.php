<?php

class LoginLostPasswordHandler extends LoginFormHandler{
    private $loginHandler = null;
    public $slugKey = 'password-lost';

    public static function init(LoginHandler $loginHandler){
        $self = new self();
        $self->loginHandler = $loginHandler;    
            add_action( 'login_form_lostpassword', array( $self, 'redirectCustomLostPassword' ) );
            add_action('template_redirect', array($self, 'setupForm'), 10);
            add_action( 'login_form_lostpassword', array( $self, 'do_password_lost' ) );
    }

    public function redirectCustomLostPassword() {
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
            if ( is_user_logged_in() ) {
                $this->loginHandler->redirect_logged_in_user();
                exit;
            }
     
            $redirect_url = LoginStaticPagesGenerator::url($this->slugKey);
            wp_redirect($redirect_url);
            exit;
        }
    }

    public function renderForm(){
        $attr = array(
            "valid" => true
        );
        if($_REQUEST['errors'] == 1){
            $attr["valid"] = false;
        }
        get_template_part('partials/login/lostpassword-form', null, $attr);
    }

    public function do_password_lost() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $errors = retrieve_password();
            if ( is_wp_error( $errors ) ) {
                // Errors found
                $redirect_url = LoginStaticPagesGenerator::url('password-lost');
                $redirect_url = add_query_arg( 'errors', 1, $redirect_url );
            } else {
                // Email sent
                $redirect_url = LoginStaticPagesGenerator::url('login');
                $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
            }
     
            wp_redirect( $redirect_url );
            exit;
        }
    }
}