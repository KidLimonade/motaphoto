<?php
/**
 * The  MotaPhoto front page
 *
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

if ($query->have_posts()) :

    // Hero header photo au hasard
    get_template_part('template-parts/hero-header');

    // Filtre et tri dans la phototèque
    get_template_part('template-parts/filter-sort-form');

    echo '<div id="photos-container">';

    while ($query->have_posts()) : 
        $query->the_post();
        get_template_part('template-parts/photo-block');
    endwhile;

    echo '</div>';

//wp_reset_postdata();
?>

<button id="load-more-btn"><?php _e('Charger plus', 'motaphoto'); ?></button>

<?php
endif;

get_footer();
    