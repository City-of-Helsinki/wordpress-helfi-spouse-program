<nav class="navbar navbar-expand-sm navbar-light" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <button class="navbar-toggler" 
            type="button" data-toggle="collapse" 
            data-target="#main-menu" 
            aria-controls="main-menu" 
            aria-expanded="false" 
            aria-label="<?php esc_attr_e( 'Toggle navigation'); ?>">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php 
        if ( has_custom_logo() ) :
                the_custom_logo();
        endif; 
    ?>
        <div id="main-menu" class="collapse navbar-collapse ml-2">
            <?php
            wp_nav_menu( array(
                'theme_location'    => 'main-menu',
                'depth'             => 2,
                'container'         => false,
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),
            ) );
            ?>
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