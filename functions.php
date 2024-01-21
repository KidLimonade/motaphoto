<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Enqueue scripts and styles.
 */
function motaphoto_scripts() {
    wp_enqueue_script(
        'motaphoto-scripts',
        get_template_directory_uri() . '/js/scripts.js',
        array(),
        _S_VERSION,
        true
    );
    wp_enqueue_style(
        'motaphoto-style',
        get_template_directory_uri() . '/css/main.css',
        array(),
        _S_VERSION
    );
}
add_action('wp_enqueue_scripts', 'motaphoto_scripts');

function register_motaphoto_menus() {
    register_nav_menu('mota-header', __('Mota header', 'motaphoto'));
    register_nav_menu('mota-footer', __('Mota footer', 'motaphoto'));
}
add_action("after_setup_theme", 'register_motaphoto_menus');

function add_last_motaphoto_item($items, $args) {
    if ($args->theme_location == 'mota-header') {
        $items .= '<li><span class="contact-btn">Contact</span></li>';
    } else if ($args->theme_location == 'mota-footer') {
        $items .= '<li>Tous droits réservés</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_last_motaphoto_item', 10, 2);

function motaphoto_prefix_setup() {
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 200,
        'flex-height' => true,
        'flex-width'  => true
    ));
}
add_action('after_setup_theme', 'motaphoto_prefix_setup');