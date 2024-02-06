<?php
/**
 * Formulaire de filtrage par catégorie et format des photos.
 * Tout changement de valeur provoque une nouvelle requête.
 * Les champs sont aussi utilisés par le bouton "Charger plus".
*/
?>

<form id="filtre-tri-form">

    <input type="hidden" name="post_type" value="photo">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('request_filtered_photos'); ?>">
    <input type="hidden" name="action" value="request_filtered_photos">

    <?php foreach (get_object_taxonomies('photo', 'object') as $tax) : ?>
        <label for="filtre-<?php echo $tax->name ?>"></label>
        <select id="filtre-<?php echo $tax->name ?>" class="taxonomie">
            <option value="*" selected><?php echo $tax->labels->singular_name ?></option>
            <?php foreach(get_terms(['taxonomy' => $tax->name]) as $choice) : ?>
            <option value="<?php echo $choice->slug ?>"><?php echo $choice->name ?></option>
            <?php endforeach ?>
        </select>
    <?php endforeach ?>

    <label for="ordre-tri"></label>
    <select id="ordre-tri">
        <option value=""><?php _e('Trier par', 'motaphoto'); ?></option>
        <option value="DESC"><?php echo _e('À partir des plus récentes'); ?></option>
        <option value="ASC"><?php echo _e('À partir des plus anciennes'); ?></option>
    </select>

</form>

