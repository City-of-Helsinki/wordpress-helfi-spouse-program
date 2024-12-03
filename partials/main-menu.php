<nav class="navbar navbar-expand-lg navbar-light navbar-light bg-light fixed-top" role="navigation">
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
                wp_nav_menu(
                    array(
                        'menu' => 'main-menu',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'            => new WP_Bootstrap_Navwalker(),
                ));
            ?>
            </ul>
            <div class="navbar-login-nav ml-auto ">
                <?php get_template_part('partials/main-menu-signup'); ?> 
            </div>
        </div>
    </div>
</nav>