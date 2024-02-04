<?php
/**
 * Le template MotapPhoto single photo
*/

get_header();

// La boucle
while ( have_posts() ) :
    the_post();
?>

<main id="site-content">

<div class="photo-info">
    <div class="photo-info-text">
        <h1><?php the_title() ?></h1>
        <p><?php
                // Accès à la référence par l'id ACF plutôt que le slug
                $ref = get_field_object('field_65af94c95d70a');
                $ref_photo = $ref['value'];
                echo $ref['label'] . ' : ' . $ref_photo;
        ?></p>
        <script>
            // Insertion reference sur input adapté dans CF7
            jQuery( $ => {
                $(document).ready( () => {
                    $("#reference-photo").val("<?php echo $ref_photo ?>");
                });
            });
        </script>
        <p><?php
                // categories conservées pour wp_query qui suit
                $categories = wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names']);
                echo get_taxonomy('categorie')->labels->singular_name . ' : ' . implode(' ',  $categories);
        ?></p>
        <p><?php
                echo get_taxonomy('format')->labels->singular_name . ' : ' . implode( ', ',  wp_get_post_terms( $post->ID,  'format',  ['fields' => 'names']));
        ?></p>
        <p><?php
                // Accès au type via l'id ACF et double indirection car champ radio bouton
                $type = get_field_object('field_65afcce1a71e0');
                echo $type['label'] . ' : ' . $type['value']['value'];
        ?></p>
        <p><?php echo __('Année', 'motaphoto') . ' : ' . get_the_date('Y'); ?></p>
    </div>
    <div class="photo-info-photo">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
    </div>
</div>

<div class="photo-navigation">
    <div class="photo-navigation-contact">
        <?php _e( 'Cette photo vous intéresse ?', 'motaphoto'); ?>
        <button class="contact-btn">Contact</button>
    </div>
    <div class="photo-navigation-prev-next">
        <div class="photo-navigation-prev-next-img">
            <?php echo get_the_post_thumbnail(get_next_post(), 'thumbnail'); ?>
        </div>
        <div class="photo-navigation-prev-next-btns">
            <?php
                echo previous_post_link('%link', 'before');
                echo next_post_link('%link', 'after');
            ?>
        </div>
    </div>
</div>

<div class="photo-similaire">
    <div class="photo-similaire-titre">
        <?php _e('Vous aimerez aussi', 'motaphoto'); ?>
    </div>
    <div class="photo-similaire-galerie">
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

            // Requête avec boucle locale
            $query = new WP_Query($args);
            if  ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/photo-block');
                }
            }
            wp_reset_postdata();
        ?>
    </div>
</div>

<?php endwhile; // Fin de la boucle ?>

</main><!-- #site-content -->

<?php
get_footer();