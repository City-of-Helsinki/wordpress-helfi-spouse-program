<?php 
$notification_enabled = get_theme_mod('notification_enabled');
$notification_title = get_theme_mod('notification_title');
$notification_body = get_theme_mod('notification_body');
$notification_visibility = get_theme_mod('notification_visibility');
?>

<?php if (true == $notification_enabled): ?>
<div class="container-fluid sp-notification">
    <div class="sp-notification-title">
        <?php echo $notification_title; ?>
        <!-- <?php //echo $notice; ?> -->
    </div>
    <div class="sp-notification-body">
        <?php echo $notification_body; ?>
    </div>
</div>
<?php endif; ?>