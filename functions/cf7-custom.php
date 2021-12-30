<?php
/**
 * Description: Contact form 7 custom functionalities
 */


function spouse_create_event_on_form_submission(&$contact_form){
  global $current_user;

  if ($contact_form->id() != 593) {
    return;
  }

  $form = WPCF7_Submission::get_instance();
  $values = $form->get_posted_data();

  $title = sanitize_text_field($values['event-title']);
  $description = sanitize_textarea_field($values['description']);

  $eventdata = array(
    'post_title'   => $title,
    'post_content' => $description,
    'post_type'    => 'eventbrite_events',
    'post_status'  => 'pending',
    'post_author'  => get_current_user_id(),
  );

  wp_insert_post($eventdata);

}

// Catch sign in form submission
add_action("wpcf7_before_send_mail", "spouse_create_event_on_form_submission");

function spouse_random_str(
  $length,
  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_.,'
)
{
  $str = '';
  $max = mb_strlen($keyspace, '8bit') - 1;
  if ($max < 1) {
    throw new Exception($keyspace.'must be at least two characters long');
  }
  for ($i = 0; $i < $length; ++$i) {
    $str .= $keyspace[random_int(0, $max)];
  }
  return $str;
}

function filter_wpcf7_validation_error( $error, $name, $instance ) {
    $submission = WPCF7_Submission::get_instance();
    $invalid_fields = $submission->get_invalid_fields();

    $posted_data = $submission->get_posted_data();
  return $error;
};

// add the filter
add_filter( 'wpcf7_validation_error', 'filter_wpcf7_validation_error', 10, 3 );

add_filter( 'wpcf7_display_message', 'spouse_validation_messages_fail', 10, 2 );

function spouse_validation_messages_fail( $message, $status ) {
  $submission = WPCF7_Submission::get_instance();

  if ( $submission->is( 'validation_failed' ) ) {
    $invalid_fields = $submission->get_invalid_fields();
    $fields = implode(', ',array_keys($invalid_fields));
    $message = 'Your form has invalid values in fields: '. $fields;

    return $message;
  }

  return $message;
}
