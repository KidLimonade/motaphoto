<?php

/**
* MotaPhoto theme default version number
*/
if ( !defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.0' );
}

/**
* Enqueue MotaPhoto scripts and styles
*/
function motaphoto_scripts_styles() {

    // JavaScript scripts, JQuery dependency and Ajax URL parameter
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

/**
* Add 'custom-logo' feature to WordPress MotaPhoto theme
*/
function add_motaphoto_wordpress_features() {
    
    add_theme_support('custom-logo', array(
        'height'      => 22,
        'width'       => 345,
        'flex-height' => true,
        'flex-width'  => true
    ));
}

/**
* WP query getting photos stored into the
* MotaPhoto site as Custom Post Type posts.
*/
function request_motaphoto_photos() {
    $args = [
        'post_type'         => 'photo',
        'posts_per_page'    => 8
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

/**
* Add extra menu items at the end of theme menus:
* - 'Contact' button in header navigation bar.
* - 'Tous droits réservés' text in footer menu.
*/
function add_item_to_motaphoto_menus($items, $args) {
    
    if ($args->theme_location === 'mota-header') {
        $items .= '<li><span class="contact-btn">Contact</span></li>';
    } else if ($args->theme_location === 'mota-footer') {
        $items .= '<li>Tous droits réservés</li>';
    }
    
    return $items;
}

/**
 * Actions and filters
 */
add_action('wp_enqueue_scripts', 'motaphoto_scripts_styles');
add_action("after_setup_theme", 'register_motaphoto_menus');
add_action('after_setup_theme', 'add_motaphoto_wordpress_features');
add_action('wp_ajax_request_photos', 'request_motaphoto_photos');
add_action('wp_ajax_nopriv_request_photos', 'request_motaphoto_photos');
add_filter('wp_nav_menu_items', 'add_item_to_motaphoto_menus', 10, 2);
