<?php
/**
 * MotaPhoto theme footer.
 * Intégration du html des éléments pouvant apparaître
 * sous la forme de popus modale sur une page du site.
 * Le footer contient :
 * - liens d'accès complémentaires (items WordPress)
 * - mention texte ajoutée (function.php)
*/

?>
    <footer class="site-footer">

        <?php   // Intégration du formulaire de contact
        get_template_part('template-parts/popup-contact'); ?>

        <?php   // Integration de la lightbox
        get_template_part('template-parts/lightbox'); ?>

        <?php   // menu_class pour style ul
        wp_nav_menu( array(
            'theme_location'    => 'mota-footer',
            'menu_class'        => 'custom-footer-menu'
        )); ?>

    </footer>

<?php wp_footer(); ?>

</body>
</html>