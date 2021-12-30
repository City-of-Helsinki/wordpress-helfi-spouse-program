<?php 
    $current_user = wp_get_current_user();
    $welcome = "Welcome {$current_user->first_name} {$current_user->last_name}!";
    $intro = get_field('intro_text');
?>

<div class="col-12 col-lg-9 welcome">
    <h2><?php echo $welcome; ?></h2>
    <p class="p-0"><?php echo $intro; ?></p>
</div>