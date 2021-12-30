<?php

namespace Spouse;

class RegisterFormFields{
    public function init(){
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
                } else if( get_row_layout() == 'select'){
                    $isRequired = $this->isRequired(get_the_ID());

                    $label = get_sub_field('label');

                    $field = 'select';
                    if ($isRequired){
                        $field .= '*';
                    }
                    $id = sprintf('form-%s', sanitize_title($label));
                    $select = $this->getSelectFields(get_the_ID());
                    $values = array_column($select, 'value');
                    $form .= '<div class="form-group col-12 form-select-with-messages">';
                    $form .= sprintf('<label for="%s">%s</label>', $id, $label);
                    $form .= sprintf('[%s %s id:%s include_blank class:form-control class:select-has-messages %s]', $field, sanitize_title($label), $id, implode(" ", $values));

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
