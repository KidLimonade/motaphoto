<?php
/**
 * Bloc photo 
 * Le hero header avec une image en haute qualité prise au
 * hasard parmi celles de la photothèque de Nathalie Mota.
 * La mention "PHOTOGRAPHE EVENT" en lettres détourées est
 * superposé au centre via le code CSS pour être responsive.
*/
?>

<div>
</div>
<?php

if (has_post_thumbnail()) {
    the_post_thumbnail('medium');
}

echo '<br>';
echo get_field_object('field_65af94c95d70a')['value'];
echo ' ';
echo implode(' ',  wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names']));
echo ' ';
?>
<span>
    <a href="<?php echo get_post_permalink(); ?>">Oeil</a>
</span>
<button onclick="ShowInLightbox(this)" data-postid="<?php echo get_the_ID(); ?>">
    Lightbox
</button>
<?php

?>

