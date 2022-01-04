    <footer id="site-footer" <?php if(is_user_logged_in()): ?>style="background-color: #F0C3B8;" <?php endif; ?>>
        <div class="container">
            <div class="footer-box-container">
                <div class="footer-box">

                  <?php if( is_active_sidebar( 'footer_content_left' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_left' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
                <div class="footer-box">

                  <?php if( is_active_sidebar( 'footer_content' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
                <div class="footer-box">

                  <?php if( is_active_sidebar( 'footer_content_right' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_right' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

    </body>
</html>
