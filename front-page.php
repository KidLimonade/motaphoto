<?php
/**
 * The template for MotaPhoto front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*/

get_header();

// Composant photo individuelle au hasard
get_template_part('template-parts/hero-header');

// 8 photos maximum affichées sans critère ni ordre
$args = array(
    'post_type'         => 'photo',
    'posts_per_page'    => 3,
);
$query = new WP_Query($args);
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        get_template_part('template-parts/photo-block');
    endwhile;
endif;
wp_reset_postdata();
?>

<div id="zone-photos"></div>

<!-- Formulaire de sélection et de tri -->
<form id="filtre-tri-form">

    <input type="hidden" name="post_type" value="photo">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('request_filtered_photos'); ?>">
    <input type="hidden" name="action" value="request_filtered_photos">

    <?php foreach (get_object_taxonomies('photo', 'object') as $tax) : ?>
    <label for="filtre-<?php echo $tax->name ?>"></label>
    <select id="filtre-<?php echo $tax->name ?>" class="taxonomie">
        <option value=""><?php echo $tax->labels->singular_name ?></option>
        <?php foreach(get_terms(['taxonomy' => $tax->name]) as $choice) : ?>
        <option value="<?php echo $choice->slug ?>"><?php echo $choice->name ?></option>
        <?php endforeach ?>
    </select>
    <?php endforeach ?>

    <label for="ordre-tri"></label>
    <select id="ordre-tri">
        <option value=""><?php echo _e('Trier par'); ?></option>
        <option value="DESC"><?php echo _e('À partir des plus récentes'); ?></option>
        <option value="ASC"><?php echo _e('À partir des plus anciennes'); ?></option>
    </select>

</form>

<!-- Bloc d'affichage des résultats sélecteur/tri -->
<div id="filtre-tri-result"></div>

<button id="load-more-btn"><?php _e('Charger plus', 'motaphoto'); ?></button>

<?php

get_footer();
    