<?php

/**
* MotaPhoto theme default version number
*/
if ( !defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.132' );
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

    // Lightbox JavaScript script and Ajax URL parameter
    wp_enqueue_script(
        'motaphoto-lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array(),
        _S_VERSION
        // Script loaded in <head>
    );
    wp_localize_script(
        'motaphoto-lightbox',
        'motaphoto_js',
        array('ajax_url' => admin_url('admin-ajax.php'))
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

    // Authentification de l'origine de la requête
    if (!isset( $_REQUEST['nonce'] ) or
        !wp_verify_nonce( $_REQUEST['nonce'], 'request_filtered_photos' )
    ) { wp_send_json_error('Unauthorized operation.', 403);}

    // Récupération de la valeur pour la taxonomie custom 'categorie'
    // Ici elle provient du formulaire, donc une seule valeur reçue
    // Alors si '*''... on les mets toutes pour la requête
    $categorie = $_POST['categorie'];
    if ($categorie === '*') {
        $terms = get_terms( ['taxonomy' => 'categorie', 'hide_empty' => false] );
        $categories = [];
        foreach ($terms as $term) {
            array_push($categories, $term->name);
        }
    } else {
        $categories = [$categorie];
    }

    // Récupération de la valeur pour la taxonomue custom 'format'
    // Ici elle provient du formulaire, donc une seule valeur reçue
    // Alors si '*''... on les mets tous pour la requête
    $format = $_POST['format'];
    if ($format === '*') {
        $terms = get_terms( ['taxonomy' => 'format', 'hide_empty' => false] );
        $formats = [];
        foreach ($terms as $term) {
            array_push($formats, $term->name);
        }
    } else {
        $formats = [$format];
    }

    // Arguments de la requête wp_qiery
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
        'orderby'           => 'date',
        'order'             => $_POST['ordre_tri'],
        'posts_per_page'    => 8,
        'paged'             => $_POST['paged'],
    );

    // Lancement de la requête wp_query
    $query = new WP_Query($args);

    // Boucle éventuelle sur le retour de la requête
    if ($query->have_posts()) {

        ob_start();

        // Chaque photo dans son bloc
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
        $html_buffer = ob_get_contents();

        ob_end_clean();

        $result = array(
            'max_pages' => $query->max_num_pages,   // Nombre de pages maximum
            'html'      => $html_buffer             // Cumul des blocs photos
        );
        echo json_encode($result);
    } else {
        echo json_encode(false);
    }

    die();
}

/**
* WP query getting one photo stored into the MotaPhoto site
* as Custom Post Type post referenced by its post id.
*/
function request_photo_by_ID() {

    // Vérification de la présence du post id
    if ( !isset($_POST['post_id']) ) {
        wp_send_json_error("Missing photo identifier.", 400);
    }

    $post_id = $_POST['post_id'];

    // Vérification que la photo n'est pas en "brouillon"
    if ( get_post_status($post_id) !== 'publish' ) {
        wp_send_json_error("Photo avvess denied.", 403);
    }

    // Arguments de la requête wp_qiery
    $args = array(
        'post_type' => 'photo',
        'p' => $post_id
    );

    // Lancement de la requête wp_query
    $query = new WP_Query($args);

    // Si le retour de le retour de la requête est un succès
    if ($query->have_posts()) {
        $query->the_post();
        $url_image = get_the_post_thumbnail_url(null, 'large');
        $reference = get_field_object('field_65af94c95d70a')['value'];
        $categorie = implode(' ',  wp_get_post_terms($post_id, 'categorie', ['fields' => 'names']));
        $prev_id = get_previous_post()->ID;
        $next_id = get_next_post()->ID;

        // Informations sur le post trouvé
        $result = array(
            'url_image' => $url_image,  // url de l'image de la photo
            'reference' => $reference,  // Référence de la photo
            'categorie' => $categorie,  // Termes de la taxonomie custom 'categorie'
            'prev_id'   => $prev_id,    // Post id photo précédente
            'next_id'   => $next_id     // Post id photo suivante
        );
        echo json_encode($result);
    } else {
        echo json_encode(false);
    }

    die();
}

/**
* Ajoute à la fin de chacun des menus WordPress du thème un item :
* - Bouton 'Contact' pour la navigation bar dans le header.
* - La mention 'Tous droits réservés' en fin du menu du footer.
*/
function add_item_to_motaphoto_menus($items, $args) {
    
    if ($args->theme_location === 'mota-header') {
        $items .= '<li><span class="contact-button popup-contact-link">' . __('Contact', 'motaphoto') . '</span></li>';
    } else if ($args->theme_location === 'mota-footer') {
        $items .= '<li>' . __('Tous droits réservés', 'motaphoto') . '</li>';
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
add_action('wp_ajax_request_photo_by_ID', 'request_photo_by_ID');
add_action('wp_ajax_nopriv_request_photo_by_ID', 'request_photo_by_ID');
add_filter('wp_nav_menu_items', 'add_item_to_motaphoto_menus', 10, 2);

