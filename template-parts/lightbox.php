<div class="lightbox">
<button class="lightbox__close"></button>
<button class="lightbox__previous"><?php //_e('Précédente', 'motaphoto'); ?></button>
<button class="lightbox__next"><?php //_e('Suivante', 'motaphoto'); ?></button>
<div class="lightbox__container">

<?php
    $query = new WP_Query(array('post_type'  => 'photo', 'orderby' => 'rand', 'posts_per_page' => 1));
    if  ($query->have_posts()) { $query->the_post();
        if (has_post_thumbnail()) { the_post_thumbnail('large'); } }
    wp_reset_postdata();
?>

</div>
</div>