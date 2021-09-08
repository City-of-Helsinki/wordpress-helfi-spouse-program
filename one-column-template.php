<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>

<?php if(get_field('additional_graphical_elements')): ?>
<main class="container-fluid sidewave" style="background-image:url(<?php echo get_template_directory_uri(); ?>/src/scss/icons/sidedecoration.svg)" role="main">
<?php else: ?>
<main class="container-fluid" role="main">
<?php endif; ?>
    <div class="row">
        <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
        $position = get_field('hero_image_position');
        $style = "background-position: $position";
        ?>
        <div class="col-12 hero-image" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
          <img role="presentation" alt="" class="wave" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
        </div>
        <?php endif; ?>
        <div class="col-12">
            <h1><?php the_title(); ?></h1>
        </div>
        <?php
            if(is_user_logged_in()){
        ?>
            <aside class="d-none d-md-none d-lg-block col-lg-3 col-xl-2 menu">
                <div class="sidebar-menu-wrap">
                    <h2>Menu</h2>
                    <nav aria-label="Submenu">
                      <?php
                      wp_nav_menu( array(
                        'theme_location' => 'sidebar-menu',
                        'container_class' => 'sidebar-menu' ) );
                      ?>
                    </nav>
                </div>
            </aside>
        <?php
            }
        ?>

        <?php if(is_user_logged_in()): ?>
            <div id="main-content" class="col-12 offset-0 col-sm-12 col-md-12 col-lg-6 offset-lg-0 col-xl-7">
        <?php else: ?>
            <div id="main-content" class="col-12 offset-0 col-lg-6 offset-lg-3">
        <?php endif; ?>
        <?php
        // center
        if (have_rows('left_column_content')):
          echo '<div class="row">';
          while (have_rows('left_column_content')) : the_row();
            $type = get_sub_field('content_type');
            get_template_part('partials/'.$type);
          endwhile;
          echo '</div>';
        endif;
        ?>
        <?php
            $postmeta = get_post_meta(get_the_ID(),'slack-chat', FALSE);
            if($postmeta){
              foreach($postmeta as $shortcode){
                do_shortcode($shortcode);
              }
            }
        ?>
        </div>
          <?php
          if(spouse_is_restricted_page()){
            ?>
              <div class="col-12 col-sm-12 col-lg-3 col-xl-3 events-column">
                  <h2>Upcoming events</h2>
                <?php echo do_shortcode('[spouse-events]'); ?>
              </div>
            <?php
          }
          ?>
    </div>
  <?php
  // show social sharing only if the page is not behind login
  if( ! spouse_is_restricted_page()):
    ?>
      <div class="row">
          <div class="col-6 mx-auto text-center">
            <span class="social-title"><?php dynamic_sidebar( 'social_title' ); ?></span>
            <?php echo do_shortcode('[SHARING_PLUS]'); ?>
          </div>
      </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
