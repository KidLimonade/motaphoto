<?php
/**
 * Le hero header avec un umage en haute qualité prise au hasard 
 * parmi celles de la photothèque de Nathalie Mota
 * Le titre en lettres détourées comme un filigrane "PHOTOGRAPHE EVENT"
 * est introduit via le css et un ::after pour être responsive
*/
?>

<div class="hero-container">
    <?php

        // Arguments de la requête "Une image au hasard dans la photothèque"
        $args = array(
            'post_type'         => 'photo',
            'orderby'           => 'rand',
            'posts_per_page'    => 1,
        );
        
        // Requête puis récupération de l'image
        $query = new WP_Query($args);
        if  ($query->have_posts()) {
            $query->the_post();
            if (has_post_thumbnail()) {
                the_post_thumbnail('full');
            }
        }
        wp_reset_postdata();
    ?>
</div>
