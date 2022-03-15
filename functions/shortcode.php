<?php
function spouse_quotes_shortcode(){
  ob_start();
  get_template_part("partials/quotes");
  $q = ob_get_contents();
  ob_end_clean();
  return $q;
}
add_shortcode( 'quotes', 'spouse_quotes_shortcode' );