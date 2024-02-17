<?php
/**
 * Le bloc photo est utilisé sur la page d'accueil (portfolio)
 * et sur les posts photo individuelle. Il se compose de :
 * -    L'image de la photo embarquée dans un lien vers la 
 *      page individuelle (mobile)
 * -    Un overlay visible au survol (desktop) proposant :
 *      - Bouton d'accès à la lightbox
 *      - Lien vers la page individuelle
 *      - Titre et catégorie de la photo
 */
?>

<article class="card-container">

<?php if (has_post_thumbnail()) : ?>

    <a class="photo-link" href="<?php echo get_post_permalink(); ?>">

        <?php    // La photo dans son lien d'accès 
        the_post_thumbnail('medium');
        ?>

    </a>

<?php endif ?>

    <div class="card-overlay">

        <button class="lightbox-button" onclick="ShowInLightbox(this)" data-postid="<?php echo get_the_ID(); ?>"></button>

        <a class="photo-button" href="<?php echo get_post_permalink(); ?>"></a>

        <span class="titre"> <?php echo get_the_title(); ?></span>

        <span class="categories"><?php echo implode(' ',  wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names'])); ?></span>
    </div>
</article>

