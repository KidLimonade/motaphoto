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
    'order'             => 'ASC',
    'posts_per_page'    => -1,
);
$query = new WP_Query($args);

if ($query->have_posts()) {
    
    while ($query->have_posts()) {

        $query->the_post();

        // Composant photo individuelle
        get_template_part('template-parts/photo-block');
    }
}
?>

<button id="ajax_call">Ajax</button>
<div id="ajax_return"><p>Résultat :</p></div>

<?php
wp_reset_postdata();
    
get_footer();
    