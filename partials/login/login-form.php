<?php if (!$args["valid"]): ?>
<div class="alert alert-danger" role="alert">
  Check your username and password
</div>
<?php endif; ?>

<?php echo $args["form"] ?>

<a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
        <?php _e( 'Forgot your password?', 'personalize-login' ); ?>
</a>