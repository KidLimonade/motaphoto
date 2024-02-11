<?php
/**
 * Le bloc photo est utilisé sur la page d'accueil (portfolio de
 * Nathalie Mota) et sur les pages photos individuelles. Il comporte :
 * -    L'image de la photo proprement-dite en qualité moyenne embarquée
 *      dans un lien vers la page individuelle correspondante (mobile)
 * -    Un overlay ombré visible au survol (desktop) proposant :
 *      - Bouton d'accès à la lightbox
 *      - Lien d'accès à la page individuelle correspondante
 *      - Titre de la photo et catégories de classement
 */
?>

<div class="card-container">

<?php if (has_post_thumbnail()) : ?>
    <a class="single-link" href="<?php echo get_post_permalink(); ?>">
    <?php the_post_thumbnail('medium'); ?>
    </a>
<?php endif ?>

    <div class="card-overlay">

        <button class="lightbox-btn" onclick="ShowInLightbox(this)" data-postid="<?php echo get_the_ID(); ?>"></button>

        <a class="single-link" href="<?php echo get_post_permalink(); ?>"></a>

        <span class="titre"> <?php echo get_the_title(); ?></span>

        <span class="categories"><?php echo implode(' ',  wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names'])); ?></span>
    </div>
</div>

