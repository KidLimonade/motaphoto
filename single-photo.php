<?php
/**
 * Le template MotapPhoto single photo
*/

get_header();

// La boucle
while ( have_posts() ) :
    the_post();
?>

<main class="site-content">

<div class="photo-detail">
    <div class="photo-detail-text">
        <h1><?php the_title() ?></h1>
        <p>
            <?php
            // Accès à la référence par l'id ACF plutôt que le slug
            $ref = get_field_object('field_65af94c95d70a');
            $ref_photo = $ref['value'];
            echo $ref['label'] . ' : ' . $ref_photo;
            ?>
        </p>
        <?php // Insertion reference sur input adapté dans CF7 ?>
        <script>
            jQuery( $ => {
                $(document).ready( () => {
                    $("#reference-photo").val("<?php echo $ref_photo ?>");
                });
            });
        </script>
        <p>
            <?php
            // categories conservées pour wp_query qui suit
            $categories = wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names']);
            echo get_taxonomy('categorie')->labels->singular_name . ' : ' . implode(' ',  $categories);
            ?>
        </p>
        <p>
            <?php
            echo get_taxonomy('format')->labels->singular_name . ' : ' . implode( ', ',  wp_get_post_terms( $post->ID,  'format',  ['fields' => 'names']));
            ?>
        </p>
        <p>
            <?php
            // Accès au type via l'id ACF et double indirection car champ radio bouton
            $type = get_field_object('field_65afcce1a71e0');
            echo $type['label'] . ' : ' . $type['value']['value'];
            ?>
        </p>
        <p><?php echo __('Année', 'motaphoto') . ' : ' . get_the_date('Y'); ?></p>
    </div>
    <div class="photo-detail-image">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
    </div>
</div>

<div class="photo-action">
    <div class="photo-action-contact">
        <p><?php _e( 'Cette photo vous intéresse ?', 'motaphoto'); ?></p>
        <button class="contact-button motaphoto-button">
            <?php _e('Contact', 'motaphoto') ?>
        </button>
    </div>
    <div class="photo-action-navigate">
        <div class="featured">
            <div class="current">
                <?php echo get_the_post_thumbnail(null, 'thumbnail'); ?>
            </div>
            <div class="previous">
                <?php echo get_the_post_thumbnail(get_previous_post(), 'thumbnail'); ?>
            </div>
            <div class="next">
                <?php echo get_the_post_thumbnail(get_next_post(), 'thumbnail'); ?>
            </div>
        </div>
        <div class="arrows">
            <div class="previous detectable">
                <?php echo previous_post_link('%link', '<div class="arrow-left"></div>'); ?>
            </div>
            <div class="next detectable">
                <?php echo next_post_link('%link', '<div class="arrow-right"></div>'); ?>
            </div>
        </div>
    </div>
</div>

<div class="photo-like">

    <p class="photo-like-titre"><?php _e('Vous aimerez aussi', 'motaphoto'); ?></p>
    
    <div class="photo-like-galerie">
        <?php

            // Arguments de la requête "Vous aumerez aussi"
            $args = array(
                'post_type' => 'photo',
                'tax_query' => array(
                    array(
                        'taxonomy'  => 'categorie',
                        'field'     => 'slug',
                        'terms'     => $categories
                    )
                ),
                'post__not_in'      => [$post->ID],
                'orderby'           => 'rand',
                'posts_per_page'    => 2,
            );

            // Exécution de la requête WordPress
            $query = new WP_Query($args);
            if  ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    // Fabriquation d'un bloc photo avec l'image similaire
                    get_template_part('template-parts/photo-block');
                }
            }
            wp_reset_postdata();
        ?>
    </div>
</div>

<?php endwhile; // Fin de la boucle ?>

</main>

<?php
get_footer();