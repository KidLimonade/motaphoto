<?php
/**
 * MotaPhoto theme footer.
*/

?>
    <footer class="site-footer">

        <?php get_template_part('template-parts/lightbox'); ?>
        <?php get_template_part('template-parts/popup-contact'); ?>

        <?php wp_nav_menu( array(
            'theme_location'  => 'mota-footer'
        )); ?>

    </footer>

<?php wp_footer(); ?>

</body>
</html>