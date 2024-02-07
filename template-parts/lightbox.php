<?php
/**
 * La lightbox permet de visualiser les phtos dans leur
 * intégralité en haute qualité. Elle est invoquée depuis
 * n'importe quelle vignette sur le site disposant du
 * bouton de visualisation en grand.
 * Il est possible de naviguer en avant et en arrière dans
 * la photothèque jusqu'à la première ou la dernière photo
*/
?>

<div class="lightbox">
    
    <button class="lightbox__close"></button>

    <button id="lightbox__prev" onclick="ShowInLightbox(this)">
        <span class="label"><?php _e('Précédente', 'motaphoto'); ?></span>
    </button>

    <button id="lightbox__next" onclick="ShowInLightbox(this)">
        <span class="label"><?php _e('Suivante', 'motaphoto'); ?></span>
    </button>

    <div class="lightbox__container">
        <div class="bloc-photo">
            <div class="image"></div>
            <div class="info-line">
                <div class="reference"></div>
                <div class="categorie"></div>
            </div>
        </div>
    </div>
    
</div>