<div>
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
<button onclick="bip(this)" class="lightbox-btn" data-postid="<?php echo get_the_ID(); ?>">
    Lightbox
</button>
<?php

?>
</div>
