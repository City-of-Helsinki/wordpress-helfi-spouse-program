<?php 
$notification_enabled = get_theme_mod('notification_enabled');
$notification_title = get_theme_mod('notification_title');
$notification_body = get_theme_mod('notification_body');
$notification_visibility = get_theme_mod('notification_visibility');
$notification_color = get_theme_mod('notification_color');
?>

<?php if ($notification_enabled): ?>
<div id="sp-notification"
     style="background-color:<?php echo $notification_color; ?>"
     class="alert alert-dismissible fade show container-fluid sp-notifications rounded-0 mt-3 pt-3"
     aria-label="<?php echo __( 'Temporary notification', 'spouse' ); ?>"
     role="region">
    <div class="sp-notification">
        <div class="sp-notification-title text-center font-weight-bolder">
            <?php echo $notification_title; ?>
        </div>
        <div class="sp-notification-body text-center">
            <?php echo $notification_body; ?>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="<?php echo __('Close the notification', 'spouse' ); ?>">
        <span aria-hidden="true">x</span>
    </button>
</div>
<?php endif; ?>