<?php
/**
 * La lightbox permet de visualiser les phtos dans leur
 * intégralité en haute qualité. Elle est invoquée depuis
 * n'importe quelle vignette sur le site disposant du
 * bouton de visualisation en grand.
 * Il est possible de naviguer en avant et en arrière dans
 * la photothèque jusqu'à la première ou la dernière photo.
*/
?>

<div class="lightbox">
    
    <button class="lightbox_close"></button>

    <?php // Invoque JavaScript pour requête Ajax et modification de la lightbox ?>
    <button id="lightbox_prev" onclick="ShowInLightbox(this)">
        <div class="bloc-button">
            <div class="arrow"></div>
            <span class="label"><?php _e('Précédente', 'motaphoto'); ?></span>
        </div>
    </button>

    <?php // Invoque JavaScript pour requête Ajax et modification de la lightbox ?>
    <button id="lightbox_next" onclick="ShowInLightbox(this)">
        <div class="bloc-button">
            <span class="label"><?php _e('Suivante', 'motaphoto'); ?></span>
            <div class="arrow"></div>
        </div>
    </button>

    <div class="lightbox_container">

        <div class="bloc-photo">

            <div class="image"></div>
            
            <div class="info-line">
                <div class="reference"></div>
                <div class="categorie"></div>
            </div>
        </div>
    </div>
    
</div>