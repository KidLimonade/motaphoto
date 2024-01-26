<?php
/**
 * The template for displaying all photo
 */

get_header();

/* Start the Loop */
while ( have_posts() ) : the_post();

    $post_ID = get_the_ID();

    the_title();
    echo '<br>';

    $reference = get_field_object('field_65af94c95d70a');
    echo $reference['label'];
    echo ' : ';
    echo $reference['value'];
    echo '<br>';
    ?>

    <script>
        jQuery( $ => {
            $(document).ready( () => {
                $("#reference-photo").val("<?php echo $reference['value']?>");
            });
        });
    </script>

    <?php
    $categories = get_the_terms($post->ID , 'categorie');
    $value = '';
    foreach ($categories as $categorie) {
        $value .= ' ' . $categorie->name;
    }
    echo 'Catégorie';
    echo ' :';
    echo $value;
    echo '<br>';

    $formats = get_the_terms($post->ID , 'format');
    $value = '';
    foreach ($formats as $format) {
        $value .= ' ' . $format->name;
    }
    echo 'Format';
    echo ' :';
    echo $value;
    echo '<br>';

    $type = get_field_object('field_65afcce1a71e0');
    echo $type['label'];
    echo ' : ';
    echo ($type['value'])['value'];
    echo '<br>';

    echo 'Année';
    echo ' : ';
    echo get_the_date('Y');
    echo '<br>';

    echo get_the_post_thumbnail($post->ID, 'thumbnail');
    echo get_the_post_thumbnail_url();
    echo '<br>';

    echo previous_post_link(
        '%link', 
        'before'
    );
    echo next_post_link(
        '%link', 
        'after'
    );
    ?>

    <button class="contact-btn">Contact</button>

    <?php
    $terms = get_terms( array(
        'taxonomy' => 'categorie',
        'hide_empty' => false
    ));
    var_dump($terms);

endwhile; // End of the loop.

get_footer();
