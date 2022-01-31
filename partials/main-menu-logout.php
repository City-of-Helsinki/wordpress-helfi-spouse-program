<?php 
$current_user = wp_get_current_user();
$uname =  $current_user->display_name;
?>
<ul class="list-group list-group-horizontal list-unstyled profile-actions">
    <li><a href="<?php echo get_edit_profile_url( $current_user->id ); ?>" class="btn btn-sign-up mr-2"><?php echo $uname ?></a></li>
    <li><a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-icon btn-logout"><?php _e("Logout") ?><i class="icon-login icon-logout" role="presentation"></i></a></li>
</ul>