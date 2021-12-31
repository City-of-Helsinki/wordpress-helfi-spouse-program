<?php 

namespace Spouse;

abstract class LoginFormHandler{
    abstract public static function init(LoginHandler $loginHandler);
    public function doActions(){
        if (!empty($this->template))
            add_filter( 'template_include', array($this, 'loadTemplate'), 99 );
    }
    public function setupForm(){
        $slug = get_post_field( 'post_name', get_post() );
        $page = LoginStaticPagesGenerator::get($this->slugKey);

        if ($slug == $page['slug']){
            add_action('spouse_after_content', array($this, 'renderForm'), 5);
            $this->doActions();
        }
    }

    function loadTemplate( $template ) {
        $new_template = locate_template( array( $this->template ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }

        return $template;
    }

    public function get_error_message($code){
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