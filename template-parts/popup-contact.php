<?php
/**
 * La fenêtre de prise de contact est réalisée avec le plugin
 * Contact Form 7.
 * Elle est présentée dans une fenêtre modale bloquant toute
 * action sur le site.
 */
?>

<div id="popup-contact" class="modal">

    <div class="modal-content">
        
        <div class="contact-form">
        <?php 
            echo do_shortcode('[contact-form-7 id="32bd04f" title="Formulaire de contact MotaPhoto"]') 
        ?>
        </div>
    </div>
</div>
