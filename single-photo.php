<?php
/**
 * The template for displaying all photo
 */

get_header();

while ( have_posts() ) : the_post();

    // Le titre de la photo
    the_title();
    echo '<br>';

    // La référence photo avec son label custom
    $field = get_field_object('field_65af94c95d70a');
    $ref_photo = $field['value'];
    echo $field['label'];
    echo ' : ';
    echo $ref_photo;
    echo '<br>';
    ?>

    <script>
        // Insertion reference photo sur input adapté dans CF7
        jQuery( $ => {
            $(document).ready( () => {
                $("#reference-photo").val("<?php echo $ref_photo ?>");
            });
        });
    </script>

    <?php
    // Maping taxonomie Catégorie du post dans tableau 
    $categories = wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names']);
    _e('Catégorie', 'motaphoto');
    echo ' : ';
    echo implode(' ',  $categories);
    echo '<br>';

    // Maping taxonomie Format du post dans tableau 
    _e('Format', 'motaphoto');
    echo ' : ';
    echo implode( ', ',  wp_get_post_terms( $post->ID,  'format',  ['fields' => 'names']));
    echo '<br>';

    // Le type photo (radio button WP) et son label
    $type = get_field_object('field_65afcce1a71e0');
    echo $type['label'];
    echo ' : ';
    echo $type['value']['value'];
    echo '<br>';

    // L'année de la photo depuis sa date WP
    _e('Année', 'motaphoto');
    echo ' : ';
    echo get_the_date('Y');
    echo '<br>';

    // La photo mise en avant
    ?>
        <?php if (has_post_thumbnail()): ?>
        	<div class="post__thumbnail">
            	<?php the_post_thumbnail('large'); ?>
        	</div>
        <?php endif; ?>
    <?php

    // Vignette de l'image suivante
    $next_thumbnail = get_the_post_thumbnail(
        get_next_post(), 
        'thumbnail'
    );
    echo $next_thumbnail;

    // Navigation arrière et avant (pas de boucle infinie !)
    echo previous_post_link('%link', 'before');
    echo next_post_link('%link', 'after');

    // Bouton d'affichagz de la popup Contact
    _e( 'Cette photo vous intéresse ?', 'motaphoto');
    echo '<br>';
    ?>
    <button class="contact-btn">Contact</button>
    <?php

    // Arguments de la requête "Vous aumerez aussi"
    $others_args = array(
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
    $others_query = new WP_Query($others_args);
    if  ($others_query->have_posts()) {

        _e('Vous aimerez aussi', 'motaphoto');

        while ($others_query->have_posts()) {

            $others_query->the_post();

            // Composant photo individuelle
            get_template_part('template-parts/photo-block');
        }
    }

    wp_reset_postdata();

endwhile; // End of the loop.

get_footer();