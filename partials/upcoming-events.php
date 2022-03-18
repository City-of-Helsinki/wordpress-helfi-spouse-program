<?php
if(spouse_is_restricted_page() || is_front_page()):
    $events = spouse_get_events(6);
    if (!empty($events)): ?>
    <div class="col-12 col-sm-12 events-column">
    <div class="container position-relative">
        <h2>Upcoming events</h2>
        <?php
        if ( !is_user_logged_in() ): ?>
            <p class="event_message">In order to join the event, sign up for the Spouse Program.</p>
        <?php endif; ?>
        <div class="row">
                <?php spouse_print_events($events); ?>
        </div>
    </div>
    </div>
    <?php
    endif;
endif;