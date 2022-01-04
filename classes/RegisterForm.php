<?php
namespace Spouse;

class RegisterForm{
    private $fields = null;


    public  function init(){
        add_filter('wpcf7_validate_email*', array($this, 'custom_email_confirmation_validation_filter'), 5, 2 );
        add_action("wpcf7_before_send_mail", array($this, "create_user"));
        add_filter( 'wp_new_user_notification_email', array($this, 'customizeNotificationEmail'), 10, 3 );

        $rff = new RegisterFormFields();
        $rff->init();
        $this->fields = $rff;
    }

    public function getForm(){
        return \WPCF7_ContactForm::get_current();
    }

    public function isRegistrationForm(){
        $form = $this->getForm();
        if (!$form)
            return false;

        if ($form->is_true('registration_form') )
            return true;

        return false;
    }

    public function custom_email_confirmation_validation_filter( $result, $tag ) {
       
        if (!$this->isRegistrationForm() ) {
          return $result;
        }
        $emailField = $this->fields->getEmailField();

        if ($emailField == $tag->name) {
            if ( $this->checkIfEmailExists() )
                $result->invalidate( $tag, "Email already exists" );
        }
      
        return $result;
    }

    private function getFormSubmission(){
        return \WPCF7_Submission::get_instance();
    }

    private function getEmailFromSubmission(){
        $form = $this->getFormSubmission();
        $values = $form->get_posted_data();
        $emailField = $this->fields->getEmailField();

        $email = sanitize_email($values[$emailField]);

        if ($email)
            return $email;

        return false;
    }

    private function checkIfEmailExists(){
        $email = $this->getEmailFromSubmission();
    
        return email_exists($email);
    }

    private function getPostedData(){
        $form = $this->getFormSubmission();
        $posted_data = $form->get_posted_data();
        return $posted_data;
    }

    public function create_user($contact_form){
        if (! $this->isRegistrationForm() ) {
            return;
        }
      
        $password = wp_generate_password( 20, false );
        $email = $this->getEmailFromSubmission();

        $user_data = array(
            'user_login'    => $email,
            'user_email'    => $email,
            'user_pass'     => $password
        );
     
        $user_id = wp_insert_user( $user_data );
        wp_new_user_notification( $user_id, $password );

        $attachment = new RegisterFormAttachment();
        $attachmentPath = $attachment->generateExcelFromSubmission( $this->getPostedData() );

        $submission = $this->getFormSubmission();
        $submission->add_extra_attachments($attachmentPath);

        return $contact_form;
    }

    public function customizeNotificationEmail($wp_new_user_notification_email, $user, $blogname){
        $customMessage = get_field('registration_setttings', 'option');
        $message = $wp_new_user_notification_email["message"];
        if (!empty($customMessage["email_body_text"])){
            $message = $customMessage["email_body_text"] . "\r\n\r\n" . $message;
        }
        
        $subject = $customMessage["email_subject"];
        if (!empty($subject)){
            $wp_new_user_notification_email["subject"] = $subject;
        }

        $wp_new_user_notification_email["message"] = $message;
        
        return $wp_new_user_notification_email;
    }
}