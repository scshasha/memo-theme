<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <nav id="sidebarMenu">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Memo
 * @since Memo 1.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="">
    <meta name="author" content="Sivuyile Christopher Shasha, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <link rel="shortcut icon" href="/wp-content/themes/memo/assets/images/icon.png" />
	<?php wp_head(); ?>
</head>
<body>
    <nav class="navbar flex-md-nowrap p-0" id="navigation">
        <?php

        /**
         * -------------------------------------------------------------------------
         * DISPLAYING SITE LOGO
         * -------------------------------------------------------------------------
         * 
         * Retrieving website logo from settings (Customizable). Otherwise load the
         * themes default logo.
         */
        $src = ( ( function_exists( 'the_custom_logo' ) && ! empty( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) ) ) && isset( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) )[0] ) ) ) ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) )[0] : null;

        if ( $src === null ) {
            if ( file_exists( sprintf( '%s/assets/images/logo.png', get_template_directory() ) ) ) {
                $src =  sprintf( '%s/assets/images/logo.png', get_template_directory_uri() );
            } else {
                // Set a placeholder for now.
                $src = 'https://placehold.it/32x32.png';
            }
        }
        ?>
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="<?php home_url(); ?>">
            <img src="<?php echo $src; ?>" alt="logo" class="img-responsive mx-auto logo" />&nbsp;&nbsp;<?php echo bloginfo('name'); ?>
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <?php // get_search_form() ?>
    </nav>
    <div class="container-fluid" id="container">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="sidebar-sticky pt-5 mt-5 mb-5">
                    <?php 
                        wp_nav_menu([
                            'menu' => 'primary',
                            'container' => null,
                            'theme_location' => 'primary',
                            'items_wrap' => '<ul id="" class="nav flex-column">%3$s</ul>',
                        ]);
                    ?>
    
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <!-- <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span class="fa fa-plus-circle"></span>
                    </a> -->
                    </h6>
                    
                    <?php 
                        wp_nav_menu([
                            'menu' => 'profile',
                            'container' => null,
                            'theme_location' => 'profile',
                            'items_wrap' => '<ul id="" class="nav flex-column mb-2 pt-5">%3$s</ul>',
                        ]);
                    ?>
                </div>
            </nav>
