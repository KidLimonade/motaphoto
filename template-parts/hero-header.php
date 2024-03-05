<?php
/**
 * Le hero header contient une image en haute qualité prise au
 * hasard parmi celles de la photothèque de Nathalie Mota.
 * La mention "PHOTOGRAPHE EVENT" en lettres détourées est
 * superposé au centre et stylée/dimensionnée via le code CSS.
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
            ?>
                <div class="hero-image"><?php the_post_thumbnail('large'); ?></div>
            <?php
            }
        }
        wp_reset_postdata();
    ?>

    <h1 class="hero-title">Photographe&nbsp;Event</h1>
    
</div>
