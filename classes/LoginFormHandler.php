<?php

namespace Spouse;

abstract class LoginFormHandler
{

    abstract public static function init(LoginHandler $loginHandler);

    public function doActions()
	{
        if (!empty($this->template)){
            add_filter( 'body_class', array($this, 'addBodyClass') );
            add_filter( 'template_include', array($this, 'loadTemplate'), 99 );
        }
    }
    public function setupForm()
	{
        $page_id = apply_filters( 'spouse_program_static_page_id', 0, $this->slugKey );

        if ( get_the_ID() === $page_id ) {
            add_action('spouse_after_content', array($this, 'renderForm'), 5);
            $this->doActions();
        }
    }

    function loadTemplate( $template )
	{
        $new_template = locate_template( array( $this->template ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }

        return $template;
    }

    public function addBodyClass($classes)
	{
        return array_map(function($class) {
            $query = 'page-template-';
            if ( substr($class, 0, strlen($query)) === $query ){
                return 'page-' . str_replace('.php', '', $this->template);
            }
            return $class;
        }, $classes);
    }

    public function get_error_message($code)
	{
        switch ($code){
            case 'expiredkey':
            case 'invalidkey':
                return __( 'The password reset link you used is not valid anymore.', 'personalize-login' );

            case 'password_reset_mismatch':
                return __( "The two passwords you entered don't match.", 'personalize-login' );

            case 'password_reset_empty':
                return __( "Sorry, we don't accept empty passwords.", 'personalize-login' );
        }
    }
}
