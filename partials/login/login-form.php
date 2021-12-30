<?php if (!$args["valid"]): ?>
<div class="alert alert-danger" role="alert">
  Check your username and password
</div>
<?php endif; ?>

<?php echo $args["form"] ?>

<div class="login-form-bottom">
  Not registered yet? 
  <a class="create-account" href="<?php echo wp_lostpassword_url(); ?>">
    <?php _e( 'Create an account.', 'personalize-login' ); ?>
  </a>
</div>