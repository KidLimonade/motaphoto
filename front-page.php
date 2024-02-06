<?php
/**
 * La MotaPhoto front page
*/

get_header();

// Reqête bloc initial de 8 photos récentes
$args = array(
    'post_type'         => 'photo',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => 8,
);
$query = new WP_Query($args);

// La page
if ($query->have_posts()) :

    // Hero header photo au hasard
    get_template_part('template-parts/hero-header');

    // Filtre et tri dans la photothèque
    get_template_part('template-parts/filter-sort-form');

    // Bloc principal des photos
    echo '<div id="photos-container">';

    // La boucle principale
    while ($query->have_posts()) : 
        $query->the_post();
        get_template_part('template-parts/photo-block');
    endwhile; // Fin de la oucle principale

    echo '</div>';
?>

<button id="load-more-btn" class="motaphoto-button"><?php _e('Charger plus', 'motaphoto'); ?></button>

<?php
endif; // Fin de la page

get_footer();
    