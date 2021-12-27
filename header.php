<!DOCTYPE html>

<?php spouse_access_control_check(); ?>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a href="#main-content" class="visually-hidden focusable">
    Skip to main content
</a>

<?php
wp_body_open();
?>

<header id="site-header" role="banner">
        <?php get_template_part('partials/main-menu'); ?>
</header><!-- #site-header -->

<?php echo do_shortcode('[spouse_notice]'); ?>

<?php
// Output the menu modal.
get_template_part( 'template-parts/modal-menu' );
