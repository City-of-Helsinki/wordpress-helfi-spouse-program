<?php 
    $current_user = wp_get_current_user();
    $welcome = "Welcome {$current_user->first_name} {$current_user->last_name}!";
    $intro = "Here you will find all available services and upcoming events. Don't be shy and become an active member of our Spouse Community! &#128578";
?>

<div class="col-12 col-lg-9 welcome">
    <h2><?php echo $welcome; ?></h2>
    <p class="p-0"><?php echo $intro; ?></p>
</div>