<?php
namespace Spouse;

class RegisterForm{
    private $fields = null;


    public  function init(){
        add_action("wpcf7_before_send_mail", array($this, "handleSubmission"));
        add_filter( 'wp_new_user_notification_email', array($this, 'customizeNotificationEmail'), 10, 3 );
        wpcf7_add_form_tag( 'user_email', array($this, 'getRegistrationEmail' ));

        $rff = new RegisterFormFields();
        $rff->init();
        $this->fields = $rff;
    }

    public function getForm(){
        return \WPCF7_ContactForm::get_current();
    }

    public function isRegistrationForm(){
        return $this->hasOption('registration_form');
    }

    public function hasOption($option){
        $form = $this->getForm();
        if (!$form)
            return false;

        if ($form->is_true($option) )
            return true;

        return false;
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

    private function getRegistrationEmail(){
        return $this->getEmailFromSubmission();
    }

    private function getPostedData(){
        $form = $this->getFormSubmission();
        $posted_data = $form->get_posted_data();
        return $posted_data;
    }

    public function handleSubmission($contact_form){

        if ($this->isRegistrationForm() ) {
            $this->create_user($contact_form);
        }

        if ($this->hasOption('data_as_attachment') ){
            $this->dataAsAttachment();
        }
        
        return $contact_form;
    }

    public function create_user($contact_form){     
        $password = wp_generate_password( 20, false );
        $email = $this->getEmailFromSubmission();

        $user_data = array(
            'user_login'    => $email,
            'user_email'    => $email,
            'user_pass'     => $password
        );
     
        $user_id = wp_insert_user( $user_data );
        wp_new_user_notification( $user_id, $password );

        return $contact_form;
    }

    public function dataAsAttachment(){
        $attachment = new RegisterFormAttachment();
        $attachmentPath = $attachment->generateExcelFromSubmission( $this->getPostedData() );

        $submission = $this->getFormSubmission();
        $submission->add_extra_attachments($attachmentPath);
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