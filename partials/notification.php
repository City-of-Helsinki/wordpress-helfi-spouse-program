<?php 
$notification_enabled = get_theme_mod('notification_enabled');
$notification_title = get_theme_mod('notification_title');
$notification_body = get_theme_mod('notification_body');
$notification_visibility = get_theme_mod('notification_visibility');
?>

<?php if ( true == $notification_enabled ): ?>
<div id="sp-notification" class="alert alert-dismissible fade show container-fluid sp-notifications rounded-0 mt-3 pt-3" role="alert">
    <div class="sp-notification">
        <div class="sp-notification-title text-center font-weight-bolder">
            <?php echo $notification_title; ?>
        </div>
        <div class="sp-notification-body text-center">
            <?php echo $notification_body; ?>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="<?php echo __('Close', 'spouse' ); ?>">
        <span aria-hidden="true">x</span>
    </button>
</div>
<?php endif; ?>