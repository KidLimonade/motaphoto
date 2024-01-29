<?php
/**
 * The template for MotaPhoto front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*/

get_header();

// Request taxonomes terms
$taxonomies = get_taxonomies(
    array('public' => true, '_builtin' => false),
    'names',
    'and'
);
foreach ($taxonomies as $key => $value) {
    echo $key . '<br>';
}
echo '<br>';

$categories = get_terms( array(
    'taxonomy' => 'categorie',
    'hide_empty' => false
));
foreach ($categories as $categorie) {
    echo $categorie->name . '<br>';
}
echo '<br>';

$formats = get_terms( array(
    'taxonomy' => 'format',
    'hide_empty' => false
));
foreach ($formats as $format) {
    echo $format->name . '<br>';
}
echo '<br>';

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
    