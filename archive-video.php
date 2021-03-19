<?php

//* Template Name: Video-pillole

remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'custom_category_loop' ); // Add custom loop


/**
 * Custom loop that display a list of categories with corresponding posts.
 */
/*function custom_category_loop() {
    // Grab all the categories from the database that have posts.
	$categories = get_terms( ['taxonomy' => 'video_pillole_cat', 'hide_empty' => false]);
	echo '<div class="menu-video"><h4>Scegli la categoria</h4>';
	foreach ( $categories as $category ) {
		echo '<a href="#' . $category->name . '"><p class="post-title">' . $category->name . '</p></a>';
	}
	echo '</div>';
	// Loop through categories
	//var_dump($categories);
	foreach ( $categories as $category ) {
		// Display category name
		echo '<h2 id="' . $category->name . '" class="post-title">' . $category->name . '</h2>';
		echo '<div class="flex-grid">';
		//var_dump($category);
		$args = array (
			'post_type' => 'video_pillole',
			'taxonomy' => 'video_pillole_cat',
    		'term' => $category->name,
		);

		$wp_query = new WP_Query( $args  );
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
			 ?>

				<div class="col">
				<p class="video-p"><?php the_title(); ?></p>


				<a href="<?php the_field('video_url'); ?>" rel="wp-videolightbox" title="">
					<?php the_post_thumbnail('medium'); ?>
				</a>
				</div><?php
			endwhile;

		endif;
		wp_reset_postdata();
		echo '</div>';

	}

}*/
// Start the engine.
genesis();


function custom_category_loop() {

the_title('<h2>', '</h2>');

?>
<h4>Seleziona una categoria</h4>
	<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
		<?php
		if( $terms = get_terms( 'video_pillole_cat', 'orderby=name' ) ) :
		echo '<select style="height: 60px;  margin-bottom: 20px; background: white;" id="selectAjax" name="categoryfilter"><option>Seleziona una categoria...</option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
			endforeach;
			echo '</select>';
		endif;
		?>
		<input type="hidden" name="action" value="myfilter">
	</form>

	<div id="response"></div>


		<hr>
		<!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/images/dottorcucito_images/dottorcucito-video-cerca.png" alt="dottorcucito-cerca"> -->
	<div class="more-view">
		<h2>I più visti</h2>
	<?php
	 $args = array(
        'orderby' => 'date',
    );

        $args['tax_query'] = array(
            array(
                'post_type' => 'video_pillole',
				'taxonomy' => 'video_pillole_cat',
                'field' => 'id',
                'terms' => '31'
            )
        );

    $wp_query = new WP_Query( $args );

    if( $wp_query->have_posts() ) :

		$counter = 0;
		$i = 1;
		while( $wp_query->have_posts() ): $wp_query->the_post(); ?>

				<?php if ( has_post_thumbnail() ) { ?>
					<div class="one-fourth <?php if($counter % 4 == 0) { echo 'first'; } ?>">
					<a href="<?php the_field('video_url'); ?>" class="wplightbox"><?php the_post_thumbnail('medium'); ?></a><a href="<?php the_field('video_url'); ?>" class="wplightbox"><h5><?php echo get_the_title(); ?></h5></a>
					</div>
					<?php if($i % 4 == 0 && !$i == 0) { echo '<div class="clearfix"></div>'; } ?>
				<?php }
		$counter++;
		$i++;
		endwhile;
		    wp_reset_postdata();
    else :
        echo 'Nessun video trovato';
    endif;
	?></div><?php
}

add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
    return 'Custom Next Page Link &#x000BB;';
}


?>
<script>

	jQuery(function($){

		$('#selectAjax').change(function(){
			var filter = $('#filter');

			$.ajax({
				url:filter.attr('action'),
				data:filter.serialize(),
				type:filter.attr('method'),

				success:function(data){

				//alert(data);
				//$(".img-find img").fadeOut();
				$('#response').hide().html(data).fadeIn("slow"); // insert data
				$(".wplightbox").wonderpluginlightbox();
			}
		});
			return false;
		});

	});
</script>