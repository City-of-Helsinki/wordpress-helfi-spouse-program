<?php
namespace Spouse;

class RegisterForm
{
    private $fields = null;

    public function init()
    {
        add_action("wpcf7_mail_sent", array($this, "handleSubmission"));
        // add_filter( 'wp_new_user_notification_email', array($this, 'customizeNotificationEmail'), 10, 3 );

		$this->registerCustomFormTags();

        add_action('wpcf7_init', array($this, 'initRegisterFormFields'), 5);
    }

	public function registerCustomFormTags()
	{
		if ( function_exists( 'wpcf7_add_form_tag' ) ) {
			wpcf7_add_form_tag( 'user_email', array($this, 'getRegistrationEmail' ));
		}
	}

    public function initRegisterFormFields()
    {
        $rff = new RegisterFormFields();
        $rff->init( $this );

        $this->fields = $rff;
    }

    public function getForm()
    {
        return \WPCF7_ContactForm::get_current();
    }

    public function isRegistrationForm()
    {
        return $this->hasOption('registration_form');
    }

    public function hasOption($option)
    {
        $form = $this->getForm();
        if (!$form)
            return false;

        if ($form->is_true($option) )
            return true;

        return false;
    }

    private function getFormSubmission()
    {
        return \WPCF7_Submission::get_instance();
    }

    private function getRegistrationEmail()
    {
        $form = $this->getFormSubmission();
        $values = $form->get_posted_data();
        $emailField = $this->fields->getEmailField();

        $email = sanitize_email($values[$emailField]);
        if ($email) {
            return $email;
        }
        return false;
    }

    public function handleSubmission($contact_form)
    {
        if ($this->isRegistrationForm() ) {
            $email = $this->getRegistrationEmail();
            $this->customizeNotificationEmail($email);
        }

        return $contact_form;
    }

    private function customizeNotificationEmail($email)
    {
        $customMessage = get_field('email_body_text', 'options_registration_setttings');

        if ( !empty($customMessage) ) {
            $message = $customMessage;
        } else {
            return;
        }

        $customSubject = get_field('email_subject', 'options_registration_setttings');

        if ( !empty($customSubject) ) {
            $subject = $customSubject;
        } else {
            return;
        }    
        wp_mail($email, $subject, $message);    
    }
}
