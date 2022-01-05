<?php
if(spouse_is_restricted_page()){
    ?>
    <div class="col-12 col-sm-12 events-column">
    <div class="container position-relative">
        <h2>Upcoming events</h2>
        <div class="row">
                <?php echo do_shortcode('[spouse-events]'); ?>
        </div>
    </div>
    </div>
    <?php
}