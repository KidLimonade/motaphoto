<?php
/**
 * MotaPhoto theme header.
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

        <?php wp_nav_menu( array(
            'theme_location'    => 'mota-header',
            'container'         => 'nav'
        )); ?>

        <div class="mobile-button-container">
		</div>

        </div>

    </header>
