<div>
<?php

if (has_post_thumbnail()) {
    the_post_thumbnail('medium');
}

echo '<br>';
echo get_field_object('field_65af94c95d70a')['value'];
echo ' ';
echo implode(' ',  wp_get_post_terms($post->ID, 'categorie', ['fields' => 'names']));
echo '<br>';

?>
</div>
