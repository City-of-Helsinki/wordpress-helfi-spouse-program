<?php if (!$args["valid"]): ?>
<div class="alert alert-danger" role="alert">
  Check your username and password
</div>
<?php endif; ?>

<?php if ($args["checkemail"]): ?>
<div class="alert alert-warning" role="alert"> 
  <?php _e( 'Check your email for the confirmation link.' ) ?>
</div>
<?php endif; ?>

<?php echo $args["form"] ?>

<div class="login-form-bottom">
<div class="container">
    Not registered yet? 
    <a class="" href="<?php echo spouse_register_url(); ?>">
      <?php _e( 'Create an account.', 'personalize-login' ); ?>
    </a>
  </div>
  <div class="container">
    Or
    <a href="<?php echo wp_lostpassword_url(); ?>">
      <?php _e( 'lost password?', 'personalize-login' ); ?>
    </a>
  </div>

</div>