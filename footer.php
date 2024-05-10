<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
	</div> <!-- ast-container -->
	</div><!-- #content -->


<?php 
	astra_content_after();
		
	astra_footer_before();
		

	$args = array(
        'post_type' => 'footer',
        'posts_per_page' => 1,
        'post_title' => 'footer',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $query = new WP_Query($args);

    // Verificar si hay publicaciones
    if ($query->have_posts()){
        while ($query->have_posts()) : $query->the_post();
            // Aquí puedes mostrar el contenido del Custom Post Type
            the_content();
        endwhile;
        wp_reset_postdata();
    }else{
        // Si no hay publicaciones
        astra_footer();
    };

	//astra_footer();
		
	astra_footer_after(); 
?>
	</div><!-- #page -->
<?php 
	astra_body_bottom();    
	wp_footer(); 
?>
	</body>
</html>
