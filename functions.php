<?php

/**
* MotaPhoto theme default version number
*/
if ( !defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.25' );
}

/**
* Enqueue MotaPhoto scripts and styles
*/
function motaphoto_scripts_styles() {

    // JavaScript scripts, JQuery dependency and Ajax URL parameter
    wp_enqueue_script(
        'motaphoto-scripts-js',
        get_template_directory_uri() . '/js/scripts.js',
        ['jquery'],
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
* navigation bar and one for the footer menu
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
* WP query getting photos stored into the MotaPhoto site
* as Custom Post Type posts. Filtering is possible for
* categories and formats taxonomies. Sorting by date.
*/
function request_filtered_photos() {

    if (!isset( $_REQUEST['nonce'] ) or
        !wp_verify_nonce( $_REQUEST['nonce'], 'request_filtered_photos' )
    ) { wp_send_json_error('Unauthorized operation.', 403);}

    $categorie = $_POST['categorie'];
    if ($categorie === '') {
        $terms = get_terms( ['taxonomy' => 'categorie', 'hide_empty' => false] );
        $categories = [];
        foreach ($terms as $term) {
            array_push($categories, $term->name);
        }
    } else {
        $categories = [$categorie];
    }

    $format = $_POST['format'];
    if ($format === '') {
        $terms = get_terms( ['taxonomy' => 'format', 'hide_empty' => false] );
        $formats = [];
        foreach ($terms as $term) {
            array_push($formats, $term->name);
        }
    } else {
        $formats = [$format];
    }

    $ordre_tri = $_POST['ordre_tri'];
    if ($ordre_tri === '') {
        $by = 'none';
        $order = 'DESC';
    } else {
        $by = 'date';
        $order = $_POST['ordre_tri'];
    }

    $args = array(
        'post_type' => 'photo',
        'tax_query' => array(
            'relation'      => 'AND',
            array(
                'taxonomy'  => 'categorie',
                'field'     => 'slug',
                'terms'     => $categories
            ),
            array(
                'taxonomy'  => 'format',
                'field'     => 'slug',
                'terms'     => $formats
            )
        ),
        'orderby'           => $by,
        'order'             => $order,
        'posts_per_page'    => 3,
        'paged'             => $_POST['paged'],
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {

        ob_start();

        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
        $output = ob_get_contents();

        ob_end_clean();
    }

    $result = array(
        'max_pages' => $query->max_num_pages,
        'html'      => $output
    );

    echo json_encode($result);
    die();
}

/**
* Add extra menu items at the end of theme menus:
* - 'Contact' button in header navigation bar.
* - 'Tous droits réservés' text in footer menu.
*/
function add_item_to_motaphoto_menus($items, $args) {
    
    if ($args->theme_location === 'mota-header') {
        $items .= '<li><span class="contact-btn popup-link">Contact</span></li>';
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
add_action('wp_ajax_request_filtered_photos', 'request_filtered_photos');
add_action('wp_ajax_nopriv_request_filtered_photos', 'request_filtered_photos');
add_filter('wp_nav_menu_items', 'add_item_to_motaphoto_menus', 10, 2);
