<nav class="navbar navbar-expand-lg navbar-light" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->

    <?php 
        if ( has_custom_logo() ) :
                the_custom_logo();
        endif; 
    ?>
    <button class="navbar-toggler" 
            type="button" data-toggle="collapse" 
            data-target="#main-menu" 
            aria-controls="main-menu" 
            aria-expanded="false" 
            aria-label="<?php esc_attr_e( 'Toggle navigation'); ?>">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div id="main-menu" class="collapse navbar-collapse ml-2">
            <ul class="nav navbar-nav">
            <?php
                echo spouse_main_menu();
            ?>
            </ul>
            <div class="navbar-login-nav ml-auto ">
                <?php if (is_user_logged_in()):
                    get_template_part('partials/main-menu-logout');
                else:
                    get_template_part('partials/main-menu-login');
                endif; ?> 
            </div>
        </div>
    </div>
</nav>