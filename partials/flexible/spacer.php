<?php
$spacing = get_sub_field('spacing');
$spacers = array(
    "small" => 1,
    "medium" => 3,
    "large" => 5
);
?>

<div class="container">
    <div class="spacer m-<?php echo( $spacers[ $spacing ] ); ?>">&nbsp;</div>
</div>