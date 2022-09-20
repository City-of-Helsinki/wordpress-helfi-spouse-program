<?php

namespace Spouse;

class RegisterFormFields{
    private ?RegisterForm $rForm = null;

    public function init( RegisterForm $rForm ){
        $this->rForm = $rForm;
        add_action( 'wpcf7_init', array($this, 'addCustomRegistrationTag' ), 10 );
        add_filter( 'wpcf7_validate_registration', array($this, 'validationFilter'), 20, 2 );

    }

    public function addCustomRegistrationTag() {
        wpcf7_add_form_tag( 'registration', array($this, 'registrationTagHandler' ));
    }

 
    public function registrationTagHandler( $tag ) {
        $form = $this->generateForm();
        $form = wpcf7_do_shortcode( $form );
    
        return $form;
    }

    public function getFormTags(){
        $tags = $this->generateForm();
        $manager = \WPCF7_FormTagsManager::get_instance();
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
          if (in_array($tag->type, array('text', 'text*', 'email') ) ) {
            $result = $this->wpcf7_text_validation_filter( $result, $tag );
          } elseif ( in_array($tag->type, array('textarea', 'textarea*'))){
            $result = $this->wpcf7_textarea_validation_filter($result, $tag);
          } elseif ( in_array($tag->type, array('email*'))){
            $result = $this->wpcf7_text_validation_filter( $result, $tag );
            if ( $this->rForm->isRegistrationForm() ){
              $this->validate_registration_email($result, $tag);
            }
          }
        }
        

        return $result;
    }

    private function wpcf7_textarea_validation_filter( $result, $tag ) {
      $type = $tag->type;
      $name = $tag->name;
    
      $value = isset( $_POST[$name] )
        ? wp_unslash( (string) $_POST[$name] )
        : '';
    
      if ( $tag->is_required() and '' === $value ) {
        $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
      }
    
      if ( '' !== $value ) {
        $maxlength = $tag->get_maxlength_option();
        $minlength = $tag->get_minlength_option();
    
        if ( $maxlength and $minlength
        and $maxlength < $minlength ) {
          $maxlength = $minlength = null;
        }
    
        $code_units = wpcf7_count_code_units( $value );
    
        if ( false !== $code_units ) {
          if ( $maxlength and $maxlength < $code_units ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_too_long' ) );
          } elseif ( $minlength and $code_units < $minlength ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_too_short' ) );
          }
        }
      }
    
      return $result;
    }

    private function wpcf7_text_validation_filter( $result, $tag ) {
      $name = $tag->name;
    
      $value = isset( $_POST[$name] )
        ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) )
        : '';
    
      if ( 'text' == $tag->basetype ) {
        if ( $tag->is_required() and '' === $value ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        }
      }
    
      if ( 'email' == $tag->basetype ) {
        if ( $tag->is_required() and '' === $value ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        } elseif ( '' !== $value and ! wpcf7_is_email( $value ) ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_email' ) );
        }
      }
    
      if ( 'url' == $tag->basetype ) {
        if ( $tag->is_required() and '' === $value ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        } elseif ( '' !== $value and ! wpcf7_is_url( $value ) ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_url' ) );
        }
      }
    
      if ( 'tel' == $tag->basetype ) {
        if ( $tag->is_required() and '' === $value ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        } elseif ( '' !== $value and ! wpcf7_is_tel( $value ) ) {
          $result->invalidate( $tag, wpcf7_get_message( 'invalid_tel' ) );
        }
      }
    
      if ( '' !== $value ) {
        $maxlength = $tag->get_maxlength_option();
        $minlength = $tag->get_minlength_option();
    
        if ( $maxlength and $minlength and $maxlength < $minlength ) {
          $maxlength = $minlength = null;
        }
    
        $code_units = wpcf7_count_code_units( $value );
    
        if ( false !== $code_units ) {
          if ( $maxlength and $maxlength < $code_units ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_too_long' ) );
          } elseif ( $minlength and $code_units < $minlength ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_too_short' ) );
          }
        }
      }
    
      return $result;
    }
    
    public function validate_registration_email($result, $tag){
      $name = $tag->name;

      $value = isset( $_POST[$name] )
        ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) )
        : '';

      if ( email_exists($value) ){
        $result->invalidate( $tag, "Email already exists" );
      }
      
      return $result;
    }

    private function getPostID(){
      $ID = get_the_ID();
      if ($ID){
        return $ID;
      }
      
      $submission = \WPCF7_Submission::get_instance();
      if ($submission){
          $ID = $submission->get_meta('container_post_id');
          if ($ID){
            return $ID;
          }
      }

      $ID = url_to_postid(wp_get_referer());
      if ($ID){
        return $ID;
      }

      return false;
    }


    private function generateForm(){
        $ID = $this->getPostID();

        if (! $ID){
          return null;
        }

        $form = '<div class="row">';
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
                } else if( get_row_layout() == 'select'){
                    $isRequired = $this->isRequired(get_the_ID());

                    $label = get_sub_field('label');

                    $field = get_sub_field('type');
                    $element = 'legend';
                    if ($field == 'select'){
                      $element = 'label';
                    }
                    
                    if ($isRequired && $field != 'radio'){
                        $field .= '*';
                    }
                    $id = sprintf('form-%s', sanitize_title($label));
                    $select = $this->getSelectFields(get_the_ID());
                    $values = array_column($select, 'value');
                    $form .= '<div class="form-group col-12 form-select-with-messages">';
                    $form .= sprintf('<%1$s for="%2$s">%3$s</%1$s>', $element, $id, $label);
                    $form .= sprintf('[%s %s id:%s include_blank use_label_element class:form-control class:select-has-messages %s]', $field, sanitize_title($label), $id, implode(" ", $values));

                        $form .= '<div class="select-messages">';
                        foreach ($select as $s){
                                $form .= sprintf('<div class="select-message d-none">%s</div>', $s["message"]);
                        }
                        $form .= '</div>';
                        
                    $form .= '</div>';

                } else if( get_row_layout() == 'note'){
                $form .= sprintf('<div class="col-12">%s</div>', get_sub_field("message"));
              }
          endwhile;
        endif;
        $form .= '</div>';
      
        return $form;
      }
      private function isRequired($post_id){
        return get_sub_field('is_required', $post_id);
      }

      private function getSelectFields($post_id){

            if( have_rows('options', $post_id) ):
                while( have_rows('options', $post_id) ) : the_row();
                    $value = get_sub_field('value');
                    $message = get_sub_field('message');
                    $values[] = array("value" => sprintf('"%s"', $value), "message" => $message);
                endwhile;
            endif;
            return $values;
      }
}
