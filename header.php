<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a id="skip-to-main-content" href="#main-content" class="visually-hidden focusable">
    Skip to main content
</a>

<?php
wp_body_open();

do_action("spouse_after_body_open");