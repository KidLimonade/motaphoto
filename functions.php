<?php

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

/**
* Enqueue MotaPhoto scripts and styles.
*/
function motaphoto_scripts_styles() {

    // Javascript, JQuery and Ajax URL
    wp_enqueue_script(
        'motaphoto-scripts-js',
        get_template_directory_uri() . '/js/scripts.js',
        array('jquery'),
        _S_VERSION,
        true
    );
    wp_localize_script(
        'motaphoto-scripts-js',
        'motaphoto_js',
        array('ajax_url' => admin_url('admin-ajax.php'))
    );

    // @font-face css style file for locally loaded font files
    wp_enqueue_style(
        'motaphoto-fonts-style',
        get_template_directory_uri() . '/css/fonts.css',
        array(),
        _S_VERSION
    );

    // Main MotaPhoto css style file
    wp_enqueue_style(
        'motaphoto-main-style',
        get_template_directory_uri() . '/css/motaphoto.css',
        array('motaphoto-fonts-style'),
        _S_VERSION
    );
}
add_action('wp_enqueue_scripts', 'motaphoto_scripts_styles');

/**
* Register two theme menus. One for the header
* navigation bar and one for the footer menu.
*/
function register_motaphoto_menus() {
    
    register_nav_menus( array(
        'mota-header' => 'Mota header',
        'mota-footer' => 'Mota footer'
    ));
}
add_action("after_setup_theme", 'register_motaphoto_menus');

/**
* Add extra menu items at the end of theme menus:
* - 'Contact' button in header navigation bar.
* - 'Tous droits réservés' text in footer menu.
*/
function add_last_menu_item($items, $args) {
    
    if ($args->theme_location === 'mota-header') {
        $items .= '<li><span class="contact-btn">Contact</span></li>';
    } else if ($args->theme_location === 'mota-footer') {
        $items .= '<li>Tous droits réservés</li>';
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'add_last_menu_item', 10, 2);

/**
* Add 'custom-logo' feature to WordPress MotaPhoto theme.
* Add 'post-thumbnails' feature to WordPress MotaPhoto theme.
*/
function add_motaphoto_wordpress_features() {
    
    add_theme_support('custom-logo', array(
        'height'      => 22,
        'width'       => 345,
        'flex-height' => true,
        'flex-width'  => true
    ));
    
    // add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'add_motaphoto_wordpress_features');

/**
* WP query getting all the photos stored into the
* MotaPhoto site as Custom Post Type posts.
*/
function request_motaphoto_photos() {
    $args = [
        'post_type'         => 'photo',
        'posts_per_page'    => 4
    ];
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $response = $query;
    } else {
        $response = false;
    }

    wp_send_json($response);
    wp_die();
}
add_action('wp_ajax_request_photos', 'request_motaphoto_photos');
add_action('wp_ajax_nopriv_request_photos', 'request_motaphoto_photos');
