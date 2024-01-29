<?php

    // Arguments de la requête "Une image au hasard dans le Hero"
    $hero_args = array(
        'post_type'         => 'photo',
        'orderby'           => 'rand',
        'posts_per_page'    => 1,
    );

    // Requête avec boucle locale
    $hero_query = new WP_Query($hero_args);
    if  ($hero_query->have_posts()) {

        $hero_query->the_post();

        // Une photo de Nathalie Mota
        if (has_post_thumbnail()) {
            the_post_thumbnail('full');
        }
        echo "PHOTOGRAPHE EVENT";
    }
    wp_reset_postdata();

?>