<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    <div class="form-group">
        <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
        <input type="text" name="user_login" id="user_login" 
            class="form-control <?php echo (!$args["valid"]) ? 'is-invalid' : '' ?>"
            <?php echo (!$args["valid"]) ? 'aria-invalid="true"' : '' ?>
        >
        <?php if (!$args["valid"]): ?>
            <div class="invalid-feedback">
                <?php _e('Please check your email address') ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="btn-group">
        <input type="submit" name="submit" class="btn btn-primary" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
    </div>
</form>