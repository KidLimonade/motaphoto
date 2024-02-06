<?php
/**
 * Bloc photo 
 */
?>

<div class="photo-container">
    <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
    <div class="photo-overlay">
        <span class="reference">
            <?php echo get_field_object('field_65af94c95d70a')['value']; ?>
        </span>
        <span class="categories">
            <?php echo implode(' ',  wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names'])); ?>
        </span>
        <a class="single-link" href="<?php echo get_post_permalink(); ?>"></a>
        <button class="lightbox-btn" onclick="ShowInLightbox(this)" data-postid="<?php echo get_the_ID(); ?>">
            Lightbox
        </button>
    </div>
</div>

