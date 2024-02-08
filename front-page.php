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
    ?>

    <main class="site-content">
        <div class="zone-criteres">

        <?php // Filtre et tri dans la photothèque
        get_template_part('template-parts/filter-sort-form');
        ?>

        </div>
            <div id="photos-container">

            <?php
            // Boucle initiale de recherche de photos
            while ($query->have_posts()) : 
                $query->the_post();
                get_template_part('template-parts/photo-block');
            endwhile;
            ?>

            </div>
        <div class="zone-more">
            <button id="load-more-btn" class="motaphoto-button"><?php _e('Charger plus', 'motaphoto'); ?>
            </button>
        </div>
    </main>

<?php
endif; // Fin de la page

get_footer();
    