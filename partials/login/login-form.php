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