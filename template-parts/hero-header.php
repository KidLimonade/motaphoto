<div>

<?php

    // Arguments de la requête "Une image au hasard dans le Hero"
    $args = array(
        'post_type'         => 'photo',
        'orderby'           => 'rand',
        'posts_per_page'    => 1,
    );

    // Requête avec boucle locale
    $query = new WP_Query($args);
    if  ($query->have_posts()) {

        $query->the_post();

        // Une photo de Nathalie Mota
        if (has_post_thumbnail()) {
            the_post_thumbnail('thumbnail');
        }
        echo '<br>';
        echo "PHOTOGRAPHE EVENT";
    }
    wp_reset_postdata();

?>

</div>
