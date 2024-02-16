<?php
/**
 * Le template minimal pour afficher un contenu
 * quelconque associé au custom theme MotaPhoto
 *
 * @link https://github.com/KidLimonade/motaphoto.git
 */

get_header();

/* Début de la boucle */
while ( have_posts() ) :
	the_post();

    the_content();

endwhile; // Fin de la boucle.

get_footer();
