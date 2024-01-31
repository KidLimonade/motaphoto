<?php
/**
 * The template for MotaPhoto front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*/

get_header();

// Composant photo individuelle
get_template_part('template-parts/hero-header');

// Request taxonomies names and terms
$taxonomies = get_object_taxonomies('photo', 'object');
foreach ($taxonomies as $taxonomy) {
    echo $taxonomy->labels->singular_name;
    echo '<br>';
    $terms = get_terms( array(
        'taxonomy' => $taxonomy->name,
        'hide_empty' => false
    ));
    foreach ($terms as $term) {
        echo $term->name;
        echo '<br>';    
    }
    echo "<br>";
}

/* Request photos */
$args = array(
    'post_type'         => 'photo',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 3,
    'paged'             => 1,
);
$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        get_template_part('template-parts/photo-block');
    endwhile;
endif;
wp_reset_postdata();
?>

<div id="zone-more"></div>
<button id="load-more"><?php _e('Charger plus', 'motaphoto'); ?></button>

<button id="ajax-call">Ajax</button>
<div id="ajax-return"></div>

<form 
    action="<?php echo admin_url('admin-ajax.php'); ?>"
    method="post"
    class="ajax-load"
>
    <input
        type="hidden"
        name="post_type"
        value="photo"
    >
    <input
        type="hidden"
        name="Format"
        value="Portrait"
    >
    <input
        type="hidden"
        name="nonce"
        value="<?php echo wp_create_nonce('request_first_photos'); ?>"
    >
    <input
        type="hidden"
        name="action"
        value="request_first_photos"
    >
    <button>Charger les photos</button>
</form>
<div id="ajax-photos"></div>




<?php
    
get_footer();
    