<?php

namespace Spouse;

class LoginHandler
{
    public static function init()
	{
        $self = new self();

        add_filter('wpcf7_form_elements', array($self, 'addBtnClassesToCF7Buttons') );
        $registerForm = new RegisterForm();
        $registerForm->init();
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
