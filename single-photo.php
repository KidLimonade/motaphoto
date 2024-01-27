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
    // À reprendre pour ne prendre que le premier
    $categories = get_the_terms($post->ID, 'categorie');
    $value = '';
    foreach ($categories as $categorie) {
        $value .= ' ' . $categorie->name;
    }
    echo 'Catégorie : ';
    echo implode(
        ', ', 
        wp_get_post_terms(
            get_the_ID(), 
            'categorie', 
            array('fields' => 'names')
        )
    ) . '<br>';

    echo 'Format : ';
    echo implode(
        ', ', 
        wp_get_post_terms(
            get_the_ID(), 
            'format', 
            array('fields' => 'names')
        )
    ) . '<br>';

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
    $args = array(
        'post_type' => 'photo',
        'tax_query' => array(
            array(
                'taxonomy'  => 'categorie',
                'field'     => 'slug',
                'terms'     => $categories[0]
            )
        ),
        'post__not_in'      => array($post_ID),
        'orderby'           => 'rand',
        'posts_per_page'    => -1,
    );

    $my_query = new WP_Query($args);
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            the_title('<p>', '</p>');
            the_post_thumbnail('thumbnail');
        }
    }
    wp_reset_postdata();

endwhile; // End of the loop.

get_footer();
