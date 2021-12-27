<?php

class RegisterFormFields{
    public function init(){
        add_action( 'wpcf7_init', array($this, 'addCustomRegistrationTag' ), 10 );
        add_filter( 'wpcf7_validate_registration', array($this, 'validationFilter'), 20, 2 );
    }

    public function addCustomRegistrationTag() {
        wpcf7_add_form_tag( 'registration', array($this, 'registrationTagHandler' ));
        wpcf7_add_form_tag( 'user_email', array($this, 'userEmailTagHandler' ));
        wpcf7_add_form_tag( 'user_password_url', array($this, 'userPasswordUrlTagHandler' ));
    }

 
    public function registrationTagHandler( $tag ) {
        $form = $this->generateForm();
        $form = wpcf7_do_shortcode( $form );
    
        return $form;
    }

    public function userEmailTagHandler(){
        return "mikko@testaa.com";
    }

    public function userPasswordUrlTagHandler(){
        return "foobaa";
    }

    public function getFormTags(){
        $tags = $this->generateForm();
        $manager = WPCF7_FormTagsManager::get_instance();
    
        $scan = $manager->scan( $tags);
        return $scan;
    }

    public function getEmailField(){
        $fields = $this->getFormTags();
        foreach($fields as $field){
            if ($field->type == 'email*'){
                return $field->name;
            }
        }

        return false;
    }

    public function validationFilter( $result, $tag ) {
        $tags = $this->getFormTags();
        foreach($tags as $tag){
          if (in_array($tag->type, array('text', 'text*', 'email', 'email*') ) ) {
            wpcf7_text_validation_filter( $result, $tag );
          } elseif ( in_array($tag->type, array('textarea', 'textarea*'))){
            wpcf7_textarea_validation_filter($result, $tag);
          }
        }
      
        return $result;
    }
    private function generateForm(){
        $form = '<div class="row">';
        $ID = LoginStaticPagesGenerator::getPostId('register');

        if( have_rows('form', $ID ) ):
          while ( have_rows('form', $ID) ) : the_row();
              if( get_row_layout() == 'textfield' || get_row_layout() == 'email' ){
                  $label = get_sub_field('label');
                  $multiline = get_sub_field('multiline');
                  $isRequired = get_sub_field('is_required');
                  $size = get_sub_field('size');
                  $field = 'text';
        
                  if (get_row_layout() == 'textfield' && $multiline == true){
                    $field = 'textarea';
                  } elseif (get_row_layout() == 'email') {
                    $field = 'email';
                  }
        
                  if ($isRequired){
                    $field .= '*';
                  }
                  $sizeClass = sprintf('class="%s"', 'col-12');
                  if ($size == 's'){
                    $sizeClass = sprintf('class="%s"', 'col-md-6');
                  }
                  $form .= sprintf('<div %s><label>%s [%s %s]</label></div>', $sizeClass, $label, $field, sanitize_title($label)); 
              } else if( get_row_layout() == 'note'){
                $form .= sprintf('<div class="col-12">%s</div>', get_sub_field("message"));
              }
          endwhile;
        endif;
        $form .= '</div>';
      
        return $form;
      }
}
