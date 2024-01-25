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

/* Start the Loop */
while ( have_posts() ) : the_post();

    echo 'the_title:' . the_title() . '<br>';
    echo 'reference:' . get_post_meta(get_the_ID(), 'reference')[0] . '<br>';
    echo 'type: ' . get_post_meta(get_the_ID(), 'type')[0] . '<br>';
    echo 'the_date: ' . the_date() . ' ' . the_time() . '<br>';
    echo 'url: ' . get_the_post_thumbnail_url();
    // echo get_the_terms( $post->ID , 'categorie' )[0] . ' <- categorie' . '<br>';
    // echo get_the_terms( $post->ID , 'format' )[0] . ' <- format' . '<br>';
    echo previous_post_link() . ' <- previous_post_link' . '<br>';
    echo next_post_link() . ' <- next_post_link' . '<br>';
    echo the_ID() . ' <- the_ID' . '<br>';

    echo '<br>------------------------------<br>';
    $categorie = get_the_terms( $post->ID , 'categorie' );
    var_dump($categorie);
    echo '<br>------------------------------<br>';
    $format = get_the_terms( $post->ID , 'format' );
    var_dump($format);
    echo '<br>------------------------------<br>';

endwhile; // End of the loop.

get_footer();
