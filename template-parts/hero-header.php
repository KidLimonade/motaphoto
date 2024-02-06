<?php
/**
 * Le hero header avec une image en haute qualité prise au
 * hasard parmi celles de la photothèque de Nathalie Mota.
 * La mention "PHOTOGRAPHE EVENT" en lettres détourées est
 * superposé au centre via le code CSS pour être responsive.
*/
?>

<div class="hero-container">
    <?php

        // Requête "Une photo prise au hasard dans la photothèque"
        $query = new WP_Query( array(
            'post_type'         => 'photo',
            'orderby'           => 'rand',
            'posts_per_page'    => 1,
        ));
        
        // Si image trouvée, affichage en haute qualité
        if  ($query->have_posts()) {
            $query->the_post();

            if (has_post_thumbnail()) {
                the_post_thumbnail('full');
            }
        }
        wp_reset_postdata();
    ?>
</div>
