<?php
$linkType = get_field('functionality');

$buttonUrl = NULL;
$buttonText = NULL;
$class = NULL;

switch($linkType) {
  case 'Internal link':
    $buttonUrl = get_field('button_url');
      break;
  case 'External link':
    $buttonUrl = get_field('external_url');
      break;
  case 'Sign in button':
    $buttonUrl = '#';
    $class = 'wow-modal-id-1';
      break;
  case 'Advanced functionality':
    $class = get_field('class');
      break;

}

$buttonText = get_field('button_text');
$url = get_field('button_url');

?>
<div class="col-12">
    <a href="<?php echo $buttonUrl; ?>" onClick="spouse_focus(event)" data-modal="wow-modal" class="<?php echo $class ?>" ><?php echo $buttonText ?></a>
</div>
<?php
