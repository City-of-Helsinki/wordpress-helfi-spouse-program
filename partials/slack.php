<?php
$buttonText = get_field("button_text");
$slackLogo = get_stylesheet_directory_uri() . "/src/scss/icons/Slack_RGB.svg";
$slackLink = get_field("slack_link");
?>
<div class="col-12 col-lg-3 join-slack">
    <img src=<?php echo $slackLogo; ?> alt="Slack logo"></img>
    <a class="btn btn-outline-dark btn-block" href=<?php echo $slackLink; ?> role="button">
        <span class="btn-text"><?php echo $buttonText; ?></span>
    </a>
</div>
