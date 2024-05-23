<?php

namespace Spouse;

class LoginForm extends LoginFormHandler{
    public $slugKey = 'login';
    public $template = 'template-login.php';

    public static function init(LoginHandler $loginHandler)
	{
        $self = new self();
        $self->loginHandler = $loginHandler;

        add_action('template_redirect', array($self, 'setupForm'), 10);
    }

    public function doActions()
	{
        parent::doActions();
        remove_action('spouse_after_body_open', 'spouse_render_main_menu', 10);
    }

    function renderForm()
	{
        $redirect = '';
        if ( isset( $_REQUEST['redirect_to'] ) ) {
			$redirect = wp_validate_redirect( $_REQUEST['redirect_to'], $redirect );
        }
        $form = wp_login_form(
            array(
				'echo' => false,
				'label_username' => __( 'Email' ),
				'label_log_in' => __( 'Sign In' ),
				'redirect' => $redirect,
			)
		);

        $form = str_replace('type="password"', 'type="password" autocomplete="password"', $form);
        $form = str_replace('name="log"', 'name="log" autocomplete="username"', $form);

        $attr = array(
			'form' => $form,
            'valid' => $this->request_value_is( 'login', 'invalid' ) ? false : true,
			'checkemail' => $this->request_value_is( 'checkemail', 'confirm' ) ? true : false,
        );

        get_template_part('partials/login/login-form', null, $attr);
    }

	protected function request_value_is( string $key, $value ): bool
	{
		return isset( $_REQUEST[$key] ) && $_REQUEST[$key] === $value;
	}
}
