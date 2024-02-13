<?php
/**
 * MotaPhoto theme header.
 * Le header contient :
 * - logo WordPress du site faisant office de bouton 'home'
 * - menu de navigation comportant les items WordPress
 * - item de menu 'Contact' ajouté (function.php)
 * - icone burger pour la version mobile
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>

<body>
    <header class="site-header">

        <div class="navigation-bar">

            <?php if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }?>

            <?php   // menu_class pour style ul
                    // container_class pour responsive 
            wp_nav_menu( array(
                'theme_location'    => 'mota-header',
                'container'         => 'nav',
                'container_class'   => 'custom-nav-menu-container',
                'menu_class'        => 'custom-header-menu'
            )); ?>

            <div class="burger-button"></div>

        </div>

    </header>
