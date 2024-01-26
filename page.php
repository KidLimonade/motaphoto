<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

if ( is_front_page() ) {

    $query = new WP_Query( array(
        'post_type'         => 'photo',
        'posts_per_page'    => -1
    ));

    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {
            $query->the_post();
            the_title('<p>', '</p>');
            echo get_the_post_thumbnail(null,'thumbnail');
            echo get_the_post_thumbnail(null,'medium');
            echo get_the_post_thumbnail(null,'medium_large');
            echo get_the_post_thumbnail(null,'large');
            echo get_the_post_thumbnail(null,'full');
        }
    } else {

        esc_html_e('Aucune photo publiée');
    }

    wp_reset_postdata();

    // Récupérer les termes d'une taxonomie
    $terms = get_terms( array(
        'taxonomy' => 'categorie',
        'hide_empty' => false
    ));
    var_dump($terms);
}

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-page' );

endwhile; // End of the loop.

get_footer();
