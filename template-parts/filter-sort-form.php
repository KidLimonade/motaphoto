<?php
/**
 * Formulaire de filtrage par catégorie et format des photos.
 * Possibilité de trier les photos par date WordPress des plus
 * técentes au plus anciennes et inversement.
 * Tout changement de valeur provoque une nouvelle requête.
 * Les champs sont aussi utilisés par le bouton "Charger plus".
*/
?>

<form id="filtre-tri-form" class="zone-filtres-tri">

    <input type="hidden" name="post_type" value="photo">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('request_filtered_photos'); ?>">
    <input type="hidden" name="action" value="request_filtered_photos">

    <div class="zone-filtres">

        <?php foreach (get_object_taxonomies('photo', 'object') as $tax) : ?>
        <div id="filtre-<?php echo $tax->name ?>" class="dropdown">

            <div class="dropdown-button">
                <span class="default-label"><?php echo $tax->labels->name ?></span>
                <span class="selected-label"></span>
            </div>

            <div class="dropdown-list collapsed">

                <input 
                    class="option" 
                    type="radio" 
                    id="filtre-all-<?php echo $tax->name ?>" 
                    name="<?php echo $tax->name ?>" 
                    value="*">
                <label 
                    class="dropdown-item" 
                    for="filtre-all-<?php echo $tax->name ?>"
                >
                    &nbsp;
                </label>

                <?php foreach(get_terms(['taxonomy' => $tax->name]) as $choice) : ?>
                <input 
                    class="option" 
                    type="radio"
                    id="filtre-<?php echo $tax->name ?>-<?php echo $choice->slug ?>"
                    name="<?php echo $tax->name ?>"
                    value="<?php echo $choice->slug ?>"
                >
                <label 
                    class="dropdown-item" 
                    for="filtre-<?php echo $tax->name ?>-<?php echo $choice->slug ?>"
                >
                    <?php echo $choice->name ?>
                </label>
                <?php endforeach ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>

    <div class="zone-tri">

        <div id="select-order" class="dropdown">

            <div class="dropdown-button">
                <span class="default-label"><?php _e('Trier par', 'motaphoto'); ?></span>
                <span class="selected-label"></span>
            </div>

            <div class="dropdown-list collapsed">

                <input class="option" type="radio" id="select-desc" name="order" value="DESC">
                <label class="dropdown-item" for="select-desc"><?php echo _e('À partir des plus récentes'); ?></label>

                <input class="option" type="radio" id="select-asc" name="order" value="ASC">
                <label class="dropdown-item" for="select-asc"><?php echo _e('À partir des plus anciennes'); ?></label>
            </div>
        </div>
    </div>
</form>
