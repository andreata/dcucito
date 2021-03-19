<?php
/* ==========================================================================
 * Theme Setup
 * ========================================================================== */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Include Iubenda consent solution
include_once( get_stylesheet_directory() . '/lib/iubenda_consent_solution.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Maker Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/maker/' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'maker_scripts_styles' );
function maker_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Martel:200,700,900|Roboto+Condensed:700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'Font Awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', array(), CHILD_THEME_VERSION );


	wp_enqueue_script( 'maker-fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array(), CHILD_THEME_VERSION );
  	wp_enqueue_script( 'maker-global', get_stylesheet_directory_uri() . '/js/global.js', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'maker-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Add screen reader class to archive description
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

/* ==========================================================================
 * Header
 * ========================================================================== */

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 400,
	'height'          => 150,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add Image Sizes
add_image_size( 'maker_archive', 800, 500, TRUE );
add_image_size( 'maker_wide', 1600, 600, TRUE );

//* Overide Genesis Portfolio Pro featured Image
add_image_size( 'portfolio', 800, 600, TRUE );


/* ==========================================================================
 * Navigation
 * ========================================================================== */

//* Rename primary and secondary navigation menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'Header Menu', 'maker' ) ) );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'maker_remove_genesis_metaboxes' );
function maker_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}


/* ==========================================================================
 * Widget Areas
 * ========================================================================== */

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );

//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Setup widget counts
function maker_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function maker_widget_area_class( $id ) {

	$count = maker_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves even';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

//* Flexible widget classes
function maker_halves_widget_area_class( $id ) {

	$count = maker_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1: Thin Width', 'maker' ),
	'description' => __( 'This is the 1st section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2: Full Width', 'maker' ),
	'description' => __( 'This is the 2nd section on the front page. It is full width but will respond to the number of widgets inside.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3: Thin Width', 'maker' ),
	'description' => __( 'This is the 3rd section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'maker' ),
	'description' => __( 'This is the 4th section on the front page. It has the default width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5: Full Width', 'maker' ),
	'description' => __( 'This is the 5th section on the front page. It is full width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6: Left Aligned Titles', 'maker' ),
	'description' => __( 'This is the 6th section on the front page. It is the default width and puts the widget titles to the left of the content.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'maker' ),
	'description' => __( 'This is the 7th section on the front page. It is the default width and responds to the number of widgets in it.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'maker' ),
	'description' => __( 'This is the 8th section on the front page. It is the default width and responds to the number of widgets in it.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-9',
	'name'        => __( 'Front Page 9: Thin Width', 'maker' ),
	'description' => __( 'This is the 9th section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-10',
	'name'        => __( 'Front Page 10: Full Width', 'maker' ),
	'description' => __( 'This is the 10th section on the front page. It is full width.', 'maker' )
) );

//* Add support for 4-column footer widget
add_theme_support( 'genesis-footer-widgets', 5 );


/* ==========================================================================
 * Blog Related
 * ========================================================================== */

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'maker_entry_meta_header' );
function maker_entry_meta_header($post_info) {

	$post_info = '[post_categories before="" after=" &middot;"] [post_date] [post_edit before=" &middot; "]';
	return $post_info;

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'maker_content_limit_read_more_markup', 10, 3 );
function maker_content_limit_read_more_markup( $output, $content, $link ) {

	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'maker_read_more_link' );
function maker_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

//* Customize author box title
add_filter( 'genesis_author_box_title', 'maker_author_box_title' );
function maker_author_box_title() {

	return '<span itemprop="name">' . get_the_author() . '</span>';

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'maker_author_box_gravatar' );
function maker_author_box_gravatar( $size ) {

	return 160;

}

//* Remove entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'maker_remove_entry_footer' );
function maker_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Display author box on archive pages
add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );

//* Add the footer text
function before_credits() {
	echo '<h4 class="text-center in-footer">“Divulgare l&rsquo;arte del cucito nelle sue forme più innovative
senza mai perdere di vista le tradizioni.”</h4>';
}
//add_action('genesis_footer', 'before_credits', 1);

//* Change the footer text
add_filter('genesis_pre_get_option_footer_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; ERRATI FEDERICO | P.IVA 02269180200 | C.F: RRTFRC77E27L949H | REA: MN-238542 | <a href="https://www.iubenda.com/privacy-policy/8228255" class="iubenda-nostyle iubenda-embed" title="Privacy Policy ">Privacy Policy</a> | <a href="https://www.iubenda.com/privacy-policy/8228255/cookie-policy" class="iubenda-nostyle iubenda-embed" title="Cookie Policy ">Cookie Policy</a>';
	return $creds;
}

function add_script_iubenda() { ?>
	<script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src="https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>	
<?php }
add_action('wp_footer', 'add_script_iubenda');


//* Change position Pirce
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

//* Change position Review
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
	unset( $tabs['description'] );
    unset( $tabs['reviews'] );  // Removes the reviews tab
    unset( $tabs['additional_information'] );  // Removes the additional information tab
    return $tabs;
}

function woocommerce_template_product_reviews() {
	wc_get_template( 'single-product-reviews.php' );
}
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_product_reviews', 50 );



//* Add icon in product

function machine_icon() { ?>
<?php if ( get_field( 'vuoi_aggiungere_le_icone' ) ):

$image = get_field('immagine_icona_1');
$image2 = get_field('immagine_icona_2');
$image3 = get_field('immagine_icona_3');

	?>

<div class="flex-ico">
<div class="one-third first">
	<img alt="dottor cucito spedizione" class="ico-product" src="<?php echo $image['url']; ?>">
	<p><?php the_field('testo_1'); ?></p>
</div>
<div class="one-third">
	<img alt="dottor cucito spedizione" class="ico-product" src="<?php echo $image2['url']; ?>">
	<p><?php the_field('testo_2'); ?></p>
</div>
<div class="one-third">
	<img alt="dottor cucito spedizione" class="ico-product" src="<?php echo $image3['url']; ?>">
	<p><?php the_field('testo_3'); ?></p>
</div>
<div class="clearfix"></div>
</div>
<img class="center-block pallini" src="<?php echo get_stylesheet_directory_uri() ?>/images/border/pallini.png" alt="Dottor cucito separatore">

<?php else: // field_name returned false ?>

<?php endif; // end of if field_name logic ?>


<?php }

add_action('woocommerce_after_single_product_summary', 'machine_icon');


// hook order
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_after_order_notes', 'woocommerce_order_review', 10 );

// hook checkout
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_after_order_notes', 'woocommerce_checkout_payment', 10 );


function your_order_text() {
	echo '<h3>Il tuo ordine</h3>';
}
add_action('woocommerce_after_order_notes', 'your_order_text', 1);

add_action( 'woocommerce_before_checkout_form', 'remove_checkout_coupon_form', 9 );
function remove_checkout_coupon_form(){
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}

// * Remove breadcumps
add_action( 'genesis_before', 'wps_remove_genesis_breadcrumbs' );

function wps_remove_genesis_breadcrumbs() {
  if (  is_cart() ) // Change 5 to whatever category ID you want.
    remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
}

add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}


/**
 * Change number of related products output
 */
function woo_related_products_limit() {
  global $product;

	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}



// Append cart item (and cart count) to end of main menu.
add_filter( 'wp_nav_menu_items', 'am_append_cart_icon', 10, 2 );
function am_append_cart_icon( $items, $args ) {
	$cart_item_count = WC()->cart->get_cart_contents_count();
	$cart_count_span = '';
	if ( $cart_item_count ) {
		$cart_count_span = '<span class="count">'.$cart_item_count.'</span>';
	}
	$cart_link = '<li class="cart menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_permalink( wc_get_page_id( 'cart' ) ) . '"><i class="fas fa-shopping-cart"></i>'.$cart_count_span.'</a></li>';
	// Add the cart link to the end of the menu.
	$items = $items . $cart_link;
	return $items;
}

// change text add to cart
add_filter('woocommerce_product_add_to_cart_text', 'wh_archive_custom_cart_button_text');   // 2.1 +

function wh_archive_custom_cart_button_text()
{
    return __('Acquista ora', 'woocommerce');
}

// Remove the sorting dropdown from Woocommerce
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering', 30 );
// Remove the result count from WooCommerce
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );

// Change 'add to cart' text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'bryce_add_to_cart_text' );
function bryce_add_to_cart_text() {
        return __( 'Aggiungi al carrello', 'your-slug' );
}

add_action( 'woocommerce_review_order_before_submit', 'dcucito_add_checkout_privacy_policy', 9 );

function dcucito_add_checkout_privacy_policy() {

woocommerce_form_field( 'privacy_policy', array(
    'type'          => 'checkbox',
    'class'         => array('form-row privacy'),
    'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
    'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
    'required'      => true,
    'label'         => 'Ho letto e acconsento all&rsquo;utilizzo dei miei dati personali in conformità alla <a href="https://www.iubenda.com/privacy-policy/8228255" class="iubenda-nostyle iubenda-embed" title="Privacy Policy ">Privacy Policy</a>',
));

}

// Show notice if customer does not tick

add_action( 'woocommerce_checkout_process', 'dcucito_not_approved_privacy' );

function dcucito_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Per continuare devi accettare il trattamento dei tuoi dati personali' ), 'error' );
    }
}


// If you wont disable cart, remove comment to this and remove check in woocommerce setting page, in section cart
/*add_filter('woocommerce_add_to_cart_redirect', 'themeprefix_add_to_cart_redirect');
function themeprefix_add_to_cart_redirect() {
 global $woocommerce;
 $checkout_url = wc_get_checkout_url();
 return $checkout_url;
}*/

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continua a leggere</a>';
}

// Custom post video
add_action( 'init', 'create_custom_post_type' );

function create_custom_post_type() {

   $labels = array(
    'name' => __( 'Video Pillole' ),
    'singular_name' => __( 'Video pillola' )
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'page-attributes', 'thumbnail'),
    'rewrite' => array('slug' => 'videopillole'),
    'taxonomies' => array( 'video_pillole_cat' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => '',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
    );

  register_post_type( 'video_pillole', $args);
}

//fatured Video only for custom post video
function change_post_types( $post_types ) {
    // only use plugin on posts and books
    $my_cpts = array(
        'video_pillole',
    );

    // set $post_types to your cpt array
    $post_types = $my_cpts;

    return $post_types;
}
add_filter( 'gfv_post_types', 'change_post_types' );

add_action( 'pre_get_posts', 'add_video_to_posts', 1 );
function add_video_to_posts() {
    remove_action( 'pre_get_posts', 'gfv_hide_video_on_post', 10 ) ;
}




//create a custom taxonomy name it "type" for your posts
if ( ! function_exists( 'video_pillole' ) ) {

// Register Custom Taxonomy
function video_pillole() {

	$labels = array(
		'name'                       => _x( 'Video pillole', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Video Pillola', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Video Pillole Categorie', 'text_domain' ),
		'all_items'                  => __( 'Tutti', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'Nuovo', 'text_domain' ),
		'add_new_item'               => __( 'Aggiungi nuovo', 'text_domain' ),
		'edit_item'                  => __( 'Modifica', 'text_domain' ),
		'update_item'                => __( 'Aggiorna', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'video-pillole',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'video_pillole_cat', array( 'video_pillole' ), $args );

}
add_action( 'init', 'video_pillole', 0 );

}

// enable real category in post type video pillole
function wpa_cpt_in_categories( $query ){
    if ( ! is_admin()
        && $query->is_category()
        && $query->is_main_query() ) {
            $query->set( 'post_type', array( 'video_pillole' ) );
        }
}
add_action( 'pre_get_posts', 'wpa_cpt_in_categories' );

// create ajax function for video pillole
function video_pillole_filter_function(){
    $args = array(
        'orderby' => 'date',
        'order' => $_POST['date']
    );

    if( isset( $_POST['categoryfilter'] ) )
        $args['tax_query'] = array(
            array(
                'post_type' => 'video_pillole',
				'taxonomy' => 'video_pillole_cat',
                'field' => 'id',
                'terms' => $_POST['categoryfilter']
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
		//genesis_posts_nav();

      /*  while( $wp_query->have_posts() ): $query->the_post();

            echo '<div class="col-md-4">' . get_the_post_thumbnail() . '<a href="' . get_the_permalink() . '"><h2>' . $query->post->post_title . '</h2></div>';
        endwhile;*/

        wp_reset_postdata();
    else :
        echo 'Nessun video trovato';
    endif;

    die();
}


add_action('wp_ajax_myfilter', 'video_pillole_filter_function');
add_action('wp_ajax_nopriv_myfilter', 'video_pillole_filter_function');

function sub_header_do() { ?>

	<div class="sub-header grey-h"">
		<div class="wrap">
			<div class="flex-search">
				<!-- <p>Non perdere l'occasione di entrare in contatto con Dottor Cucito!</p> -->
				<div class="f-r">
					<?php if (is_user_logged_in()) { ?>
						<a href="/mio-account/" class="sub-contact" title="dottor cucito pagina account">Il mio profilo</a> | 
					<?php } else { ?>
						<a href="/mio-account/" class="sub-contact" title="dottor cucito pagina account">Non sei registrato? Registrati</a> |
					<?php } ?> 
					<a href="/contatti" class="sub-contact" title="dottor cucito pagina contatti">Contattami</a> |
					<a target="_blank" title="facebook link" href="https://www.facebook.com/dottorcucito/"><i class="fab fa-facebook"></i></a>
					<a target="_blank" title="instagram link" href="https://www.instagram.com/dottorcucito/"><i class="fab fa-instagram"></i></a>
					<a target="_blank" title="you tube link" href="https://www.youtube.com/channel/UCTaydpujzeNwNiNESlIj2Cg"><i class="fab fa-youtube"></i></a>
				</div>
				<?php echo do_shortcode('[wcas-search-form]'); ?>
			</div>
		</div>
	</div>
<?php }

add_action('genesis_before_header', 'sub_header_do');


/* 
Add request Info button in single product page 
*/
function display_request_info( $meta_boxes ) {

	$meta_boxes[] = array(
		'id' => 'inforequest',
		'title' => esc_html__( 'Badge Richiesta Infromazioni', 'metabox-online-generator' ),
		'post_types' => array('product' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => 'radioinfo',
				'name' => esc_html__( 'Sistema di visualizzazione in pagina prodotto', 'metabox-online-generator' ),
				'type' => 'radio',
				'placeholder' => '',
				'options' => array(
					'onlyinfoTrue' => esc_html__( 'Visualizza solo badge Informazioni', 'metabox-online-generator' ),
					'onlypriceTrue' => esc_html__( 'Visualizza solo il pulsante acquista (standard)', 'metabox-online-generator' ),
					'infoPriceTrue' => esc_html__( 'Visualizza sia il pulsante acquista sia la richiesta informazioni', 'metabox-online-generator' ),
				),
				'inline' => 'true',
				'std' => 'infoPriceTrue',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'display_request_info' );



function woocommerce_request_info() {
	
	$infoRadio = rwmb_meta( 'radioinfo' );

	if ($infoRadio == "onlypriceTrue") : ?>
		
	<?php elseif ($infoRadio == "onlyinfoTrue") : ?>
		<?php if ( !(is_user_logged_in()) ) : ?>
			<style>form.cart {display: none;!important}</style>
			<style>.price {display: none;!important}</style>
		<?php endif; ?>
		<div class="tabs">
			<div class="tab">
				<input type="checkbox" id="chck1">
				<label class="tab-label" for="chck1">Richiedi informazioni</label>
				<div class="tab-content">
					<?php if ( !(is_user_logged_in()) ) : ?>
						<p class="mb-0">Registrati per scoprire il prezzo ed ottenere molti vantaggi!</p>
						<a class="button btn-account" href="mio-account/">Registrati</a>
						<p class="mb-0">oppure:</p>
					<?php endif; ?>
				<?php echo do_shortcode('[contact-form-7 id="9" title="Modulo di contatto pagina contatti | Dottor Cucito"]'); ?>
				</div>
			</div>
		</div>
	<?php elseif ($infoRadio == "infoPriceTrue") : ?>
		<div class="tabs">
			<div class="tab">
				<input type="checkbox" id="chck1">
				<label class="tab-label" for="chck1">Richiedi informazioni</label>
				<div class="tab-content">
				<?php echo do_shortcode('[contact-form-7 id="9" title="Modulo di contatto pagina contatti | Dottor Cucito"]'); ?>
				</div>
			</div>
		</div>
	<?php endif; 
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_request_info', 30 );
  
/* 
Define sidebar WooCommerce 
*/
genesis_register_sidebar( array(
    'id'            => 'woo_primary_sidebar',
    'name'          => __( 'Webshop Sidebar', 'Dottor Cucito Theme' ),
    'description' => __( 'This is the WooCommerce webshop sidebar', 'Dottor Cucito Theme' ),
) );

function dcucito_woo_sidebar() {
    if ( ! dynamic_sidebar( 'woo_primary_sidebar' ) && current_user_can( 'edit_theme_options' )  ) {
        genesis_default_widget_area_content( __( 'WooCommerce Primary Sidebar', 'genesis' ) );
    }
}

add_action( 'genesis_before', 'wpstudio_add_woo_sidebar', 20 );
function wpstudio_add_woo_sidebar() {

    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if( (is_woocommerce()) && (!is_product()) ) {
            remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
            remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
            add_action( 'genesis_sidebar', 'dcucito_woo_sidebar' );
        }
    }
    
}

function dcucito_remove_sidebar() {
if ( is_product() ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
        remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
		remove_action( 'genesis_sidebar', 'dcucito_woo_sidebar' );
    }
}
add_action( 'wp', 'dcucito_remove_sidebar' );

//Full Width Pages on WooCommerce
function themeprefix_cpt_layout() {
    if( is_product() ) {
        return 'full-width-content';
    }
}
add_filter( 'genesis_site_layout', 'themeprefix_cpt_layout' );

/* 
Change number per row related product 
*/
function dcucito_commerce_child_related_products_args( $args ) {
    $args = array( 
        'posts_per_page' => 4,  
        'columns' => 4,  
        'orderby' => 'DESC',  
 	); 
 	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'dcucito_commerce_child_related_products_args', 99, 3 );

/* 
Complessity machine 
*/
function complessity_machine( $meta_boxes ) {

	$meta_boxes[] = array(
		'id' => 'machine_complex',
		'title' => esc_html__( 'Complessità macchina', 'metabox-online-generator' ),
		'post_types' => array('product' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => 'complexmachinelevel',
				'name' => esc_html__( 'Complessità macchina', 'metabox-online-generator' ),
				'type' => 'radio',
				'placeholder' => '',
				'options' => array(
					'livelOne' => esc_html__( 'Principiante', 'metabox-online-generator' ),
					'livelTwo' => esc_html__( 'Professionale', 'metabox-online-generator' ),
					'livelThree' => esc_html__( 'Esperta', 'metabox-online-generator' ),
					'livelFor' => esc_html__( 'Per bambini', 'metabox-online-generator' ),
					'livelCreative' => esc_html__( 'Cucito creativo', 'metabox-online-generator' ),
				),
				'inline' => 'true',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'complessity_machine' );

function show_badge_complex() {
	$complex = rwmb_meta( 'complexmachinelevel' );
	if ($complex) {
		if ($complex == "livelOne") : ?>
			<span class="complex-machine level1">Principiante</span>
		<?php elseif ($complex == "livelTwo") : ?>
			<span class="complex-machine level2">Professionale</span>
		<?php elseif ($complex == "livelThree") : ?>
			<span class="complex-machine level3">Esperta</span>
		<?php elseif ($complex == "livelFor") : ?>
			<span class="complex-machine level3">Per bambini</span>
		<?php elseif ($complex == "livelCreative") : ?>
			<span class="complex-machine level3">Intermedia</span>
		<?php endif; 
	}
}
add_action('woocommerce_before_shop_loop_item_title', 'show_badge_complex');
add_action('woocommerce_single_product_summary', 'show_badge_complex',1);

// Create Extra Description Meta Box
function add_extra_descriptio( $meta_boxes ) {

	$meta_boxes[] = array(
		'id' => 'extradescription',
		'title' => esc_html__( 'Caratteristiche prodotto', 'metabox-online-generator' ),
		'post_types' => array('product' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => 'extra_description',
				'name' => esc_html__( 'Caratteristiche prodotto', 'metabox-online-generator' ),
				'type' => 'wysiwyg',
				'desc' => esc_html__( 'lasciare vuoto se non ci sono caratteristiche da evidenziare', 'metabox-online-generator' ),
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'add_extra_descriptio' );

// Add Read More links
function add_read_more_link() {
	?>
	<a href="#wooDescr" title="leggi altro"><?php _e('Continua a leggere', 'woocommmerce'); ?></a>
	<?php
}

add_action('woocommerce_single_product_summary', 'add_read_more_link', 10);


// Review Accordion
function add_review() {
	?>
		<div class="tabs tab-comment">
			<div class="tab ">
				<input type="checkbox" id="chck2">
				<label class="tab-label" for="chck2">Scrivi la tua recensione</label>
				<div class="tab-content">
				<?php wc_get_template( 'single-product-reviews.php' ); 
				?>
				</div>
			</div>
		</div>
	<?php
}

add_action('woocommerce_after_single_product', 'add_review');


function review_echo() {
	$product = wc_get_product();
	$id = $product->get_id();   
	$args = array ('post_type' => 'product', 'status'=>'approve', 'post_id' => $id);
    $comments = get_comments( $args );
    wp_list_comments( array( 'callback' => 'woocommerce_comments', 'status'=>'approve' ), $comments);
}

add_action('woocommerce_after_single_product', 'review_echo');



function wpb_custom_new_menu() {
  register_nav_menu('Menu Footer',__( 'Footer Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

add_action( 'init', 'custom_taxonomy_Item' );
function custom_taxonomy_Item()  {
$labels = array(
    'name'                       => 'usabilità',
    'singular_name'              => 'Usabilità',
    'menu_name'                  => 'Usabilità',
    'all_usage'                  => 'Tutte le Usabilità',
    'parent_item'                => 'Parent Usabilità',
    'parent_item_colon'          => 'Parent Usabilità:',
    'new_item_name'              => 'Nuova Usabilità',
    'add_new_item'               => 'Aggiungi nuova Usabilità',
    'edit_item'                  => 'Modifica Usabilità',
    'update_item'                => 'Aggionra Usabilità',
    'separate_usage_with_commas' => 'Separate Item with commas',
    'search_usage'               => 'Cerca Usabilità',
    'add_or_remove_usage'        => 'Add or remove usage',
    'choose_from_most_used'      => 'Choose from the most used usage',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'usage', 'product', $args );
register_taxonomy_for_object_type( 'usage', 'product' );
}

// First we create a function
function list_terms_custom_taxonomy( $atts ) {

	$args = array( 
		'taxonomy' => 'usage',
		'title_li' => '',
		'echo' => '0'
	);

	$output = '';
	$output .= '<ul>'; 
	$output .= wp_list_categories($args);
	$output .= '</ul>';

	return $output;
}
 
// Add a shortcode that executes our function
add_shortcode( 'usage_terms', 'list_terms_custom_taxonomy' );
 
//Allow Text widgets to execute shortcodes
add_filter('widget_text', 'do_shortcode');


function restyling_product_page() { 
$extra = rwmb_meta( 'extra_description' );
 	if ($extra) {
		?>
		<div id="wooDescr" class="" style="display: block; clear: both;">
		<h2>Descrizione</h2>
			<div class="two-thirds first"><?php the_content(); ?></div>
			<div class="one-third features"><?php echo $extra; ?></div>
			<div class="clearfix"></div>
		</div>
		<?php 
	} else {
		?>
		<div id="wooDescr" class="" style="display: block; clear: both;">
		<h2>Descrizione</h2>
			<?php the_content(); ?>
		</div>
		<?php 
	}
}

add_action('woocommerce_after_single_product_summary', 'restyling_product_page');

function sidebar_widget_mobile() {
?>
	<div class="tabs tab-comment mx-none">
		<div class="tab ">
			<input type="checkbox" id="chck3">
			<label class="tab-label" for="chck3">Apri i filtri</label>
			<div class="tab-content filter-cat">
			<h4 class="title-filter"><?php _e('Livelli', 'woocommerce'); ?></h4>
			<?php echo do_shortcode('[usage_terms]'); ?>
			<h4 class="title-filter"><?php _e('Categorie', 'woocommerce'); ?></h4>
			<?php 
				$args = array( 
					'taxonomy' => 'product_cat',
					'title_li' => '',
					'echo' => '0'
				);

				$output = '';
				$output .= '<ul>'; 
				$output .= wp_list_categories($args);
				$output .= '</ul>';

				echo $output;
			?>
			</div>
		</div>
	</div>
<?php
}

add_action('woocommerce_archive_description', 'sidebar_widget_mobile');

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = 'Tu sei qui: ';
	$args['labels']['author'] = 'Autori: ';
	$args['labels']['category'] = 'Archivi di '; // Genesis 1.6 and later
	$args['labels']['tag'] = 'Archivi di ';
	$args['labels']['date'] = 'Archivi di ';
	$args['labels']['search'] = 'Cerca per ';
	$args['labels']['tax'] = 'Archivi di ';
	$args['labels']['post_type'] = 'Archivi di ';
	$args['labels']['404'] = 'Non trovato: '; // Genesis 1.5 and later
return $args;
}


function genesis_theme_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'genesis_theme_setup' );

add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product  ) {
    $button_text = __("Scopri", "woocommerce");
    $button = '<a class="button btn-dcucito" href="' . $product->get_permalink() . '">' . $button_text . '</a>';

    return $button;
}

// Coutdown 
function countdown() {

	global $post;
	$sales_price_to = esc_html__(get_post_meta($post->ID, '_sale_price_dates_to', true),'sale-counter');

	if (is_single() && $sales_price_to != "") {
		$sales_price_date_to = date("M j, y", $sales_price_to);
		$finaldate=(strtotime($sales_price_date_to) - strtotime(date("j M y")))/ ( 60 * 60 * 24);


		?>
		<p class="scade"><strong>Compra ora!</strong> Scade tra: <span id="countDown"></span></p>

		<script>
			var countDownDate = new Date("<?php echo $sales_price_date_to ?>, 23:59:59").getTime();

			var x = setInterval(function() {
				var now = new Date().getTime();

				var distance = countDownDate - now;

				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				document.getElementById("countDown").innerHTML = days + "Giorni " + hours + "Ore "
				+ minutes + "M " + seconds + "S ";

				if (distance < 0) {
					clearInterval(x);
					document.getElementById("countDown").innerHTML = "EXPIRED";
					}
			}, 1000);
		</script>
	<?php
	}

}

add_action('woocommerce_single_product_summary', 'countdown', 2);

function add_to_cart_fixed() {
	
	global $product;
	if ( (is_product()) && (!$product->is_type( 'variable' )) ) {

		$id = $product->get_id();
		$title = $product->get_title();

		$infoRadio = rwmb_meta( 'radioinfo', array( 'object_type' => 'term' ) );

		if ( !($infoRadio == "onlyinfoTrue") ) {
			?>
			<div style="display: none;" class="sicky-add-to-cart">
				<p><?php echo $title ?></p>
				<a class="button" href="/carrello/?add-to-cart=<?php echo $id ?>">Acquista</a>
			</div>
			<?php
		} 
	}

}

add_action('wp_footer', 'add_to_cart_fixed');



// Popup Exit Intent
function add_popup_exit_intent() {

	$cookie_name = "popCookie";
	$cookie_value = "set";
	//setcookie($cookie_name, $cookie_value, time() + (86400 * 3), "/");

	if(!isset($_COOKIE[$cookie_name])) {
		?>
		<div class="lightbox">
			<div class="box">
			<a href="#" class="close">X</a>
				<h2>Non Andartene!</h2>
				<p>In regalo per te uno sconto del 10% da utilizziare immediatamente</p>
				<p>Inserisci il seguente codice promozionale nel carrello</p>
				<input class="d-none" type="text" value="DCUCITO_10_OFF" id="codeCoupon">
				<span onclick="copyCoupon()" >DCUCITO_10_OFF</span>
			</div>
		</div>

		<script>
			function copyCoupon() {
				var copyText = document.getElementById("codeCoupon");
				copyText.select();
				copyText.setSelectionRange(0, 99999)
				document.execCommand("copy");
				alert("Hai copiato il coupon: " + copyText.value);
			}
		</script>
		
		<?php
	} 
}

add_action('wp_footer', 'add_popup_exit_intent');


// Video reserved Area
function dcucito_add_premium_support_endpoint() {
    add_rewrite_endpoint( 'video-area', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'dcucito_add_premium_support_endpoint' );
  
  
function dcucito_premium_support_query_vars( $vars ) {
    $vars[] = 'video-area';
    return $vars;
}
  
add_filter( 'query_vars', 'dcucito_premium_support_query_vars', 0 );
  
  
function dcucito_add_premium_support_link_my_account( $items ) {
    $items['video-area'] = 'Video riservati';
    return $items;
}
  
add_filter( 'woocommerce_account_menu_items', 'dcucito_add_premium_support_link_my_account' );
  
  
function dcucito_premium_support_content() {
	echo '<h3>Scopri i video dedicati agli utenti di Dottor Cucito </h3><p>Di seguito puoi trovare tutti i video dedicati agli utenti iscritti al sito Dottor Cucito. Ti preghiamo di non condividere questi video con nessuno.</p>';

	global $current_user; wp_get_current_user(); 
	if ( is_user_logged_in() ) { 
		$user_info = $current_user->ID;
	}	

	$video_posts = get_field('video_associati_ad_user', 'user_' . $user_info . '');
	$videos = [];
	$categories = [];

	if ($video_posts) {
		foreach (  $video_posts as $video_post => $data ) {
			$post = get_post($data);
			$terms = get_the_terms($data, 'video-category');

			if(!isset($videos[$terms[0]->term_id])) {
				$videos[$terms[0]->term_id] = [$post];
				$categories[$terms[0]->term_id] = $terms[0]->name;
			} else {
				$videos[$terms[0]->term_id][] = $post;
			}
		}


		foreach($videos as $term_id => $v) {
			
			echo '<h2 class="cat-h2">' . esc_html( $categories[$term_id] ) . '</h2>';

			echo '<div class="priv-videos">';
			foreach($v as $video) {
				echo '<div class="priv-video">
					<h4>'. $video->post_title .'</h4>
						<div>'.$video->post_content.'</div>
						</div>';
			}
			echo '</div>';
		}
	}
}
  
add_action( 'woocommerce_account_video-area_endpoint', 'dcucito_premium_support_content' );

if ( ! function_exists('video_private_area') ) {

// Register Custom Post Type
function video_private_area() {

	$labels = array(
		'name'                  => _x( 'Video Privati', 'Post Type General Name', 'dcucito' ),
		'singular_name'         => _x( 'Video Privato', 'Post Type Singular Name', 'dcucito' ),
		'menu_name'             => __( 'Video Privati', 'dcucito' ),
		'name_admin_bar'        => __( 'Video Privati', 'dcucito' ),
		'archives'              => __( 'Item Archives', 'dcucito' ),
		'attributes'            => __( 'Item Attributes', 'dcucito' ),
		'parent_item_colon'     => __( 'Parent Item:', 'dcucito' ),
		'all_items'             => __( 'All Items', 'dcucito' ),
		'add_new_item'          => __( 'Add New Item', 'dcucito' ),
		'add_new'               => __( 'Aggiungi nuovo', 'dcucito' ),
		'new_item'              => __( 'Nuovo', 'dcucito' ),
		'edit_item'             => __( 'Modifica', 'dcucito' ),
		'update_item'           => __( 'Aggiorna', 'dcucito' ),
		'view_item'             => __( 'Guarda', 'dcucito' ),
		'view_items'            => __( 'View Items', 'dcucito' ),
		'search_items'          => __( 'Search Item', 'dcucito' ),
		'not_found'             => __( 'Not found', 'dcucito' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dcucito' ),
		'featured_image'        => __( 'Featured Image', 'dcucito' ),
		'set_featured_image'    => __( 'Set featured image', 'dcucito' ),
		'remove_featured_image' => __( 'Remove featured image', 'dcucito' ),
		'use_featured_image'    => __( 'Use as featured image', 'dcucito' ),
		'insert_into_item'      => __( 'Insert into item', 'dcucito' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'dcucito' ),
		'items_list'            => __( 'Items list', 'dcucito' ),
		'items_list_navigation' => __( 'Items list navigation', 'dcucito' ),
		'filter_items_list'     => __( 'Filter items list', 'dcucito' ),
	);
	$args = array(
		'label'                 => __( 'Video Privato', 'dcucito' ),
		'description'           => __( 'Video privati', 'dcucito' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'video-category' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'video_private', $args );

}
add_action( 'init', 'video_private_area', 0 );

}

register_taxonomy("video-category", 
	array("video_private"), 
	array("hierarchical"  =>  true,
	"label" => "Video categorie",
	"singular_label" => "Video categoria",
	"rewrite" => true
));

// Trust element
function add_trust_element() {
	?>
	<p class="p-trust"><strong>Paga in totale sicurezza su questo sito</strong></p>
	<img class="d-trust" src="<?php echo get_stylesheet_directory_uri() ?>/images/trust/desktop-trust-dcucito.png" alt="sicurezza acquisto">
	<img class="m-trust" src="<?php echo get_stylesheet_directory_uri() ?>/images/trust/mobile-trust-dcucito.png" alt="sicurezza acquisto">
	<?php
}

add_action('woocommerce_after_add_to_cart_button', 'add_trust_element', 10);

// PopUp Add to cart
function add_to_cart_popup() {

	$crosssells = get_post_meta( get_the_ID(), '_crosssell_ids',true);

    if(empty($crosssells)){
        return;
    }

    $args = array( 
        'post_type' => 'product', 
        'posts_per_page' => 4, 
        'post__in' => $crosssells 
        );
    $products = new WP_Query( $args );
    if( $products->have_posts() ) : 
        echo '<div class="cross-sells"><h4>Spesso acquistato insieme:</h4>';
        woocommerce_product_loop_start();
        while ( $products->have_posts() ) : $products->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile; // end of the loop.
        woocommerce_product_loop_end();
        echo '</div>';
    endif;
    wp_reset_postdata();
}
//add_action('woocommerce_before_single_product', 'add_to_cart_popup');
add_action('xoo_cp_before_btns', 'add_to_cart_popup');

add_filter( 'woocommerce_product_upsells_products_heading', 'bbloomer_translate_may_also_like' );
  
function bbloomer_translate_may_also_like() {
   return 'Ti potrebbe interessare anche...';
}

// Set quantity for gruped product
add_filter( 'woocommerce_quantity_input_args', 'custom_quantity', 10, 2 );
function custom_quantity( $args, $product ) {
    $args['input_value'] = 1;
    return $args;
}

function woocommerce_subcats_from_parentcat_by_ID($parent_cat_ID) {

	if (!is_shop()) {
		$category = get_queried_object();
		$ac_cat = $category->term_id;
		$args = array(
		'hierarchical' => 1,
		'show_option_none' => '',
		'hide_empty' => 0,
		'parent' => $ac_cat,
		'taxonomy' => 'product_cat'
		);
		$subcats = get_categories($args);
			echo '<ul class="wooc_sclist">';
			foreach ($subcats as $sc) {
				if (!($sc->category_count == 0)) {
					$link = get_term_link( $sc->slug, $sc->taxonomy );
					$var_cat = $sc->name;
					$cat_clean = str_replace(array('Macchine da cucire', 'prezzi', 'Ricamatrici', 'Cucito e Ricamo', 'Tagliacuci'), '', $var_cat);
					echo '<li><a href="'. $link .'">'.$cat_clean.'</a></li>';
				}
			}
		echo '</ul>';
	}
}

add_action('woocommerce_archive_description', 'woocommerce_subcats_from_parentcat_by_ID');


// Custom Kit Product
function custom_kit_product( $meta_boxes ) {

	$meta_boxes[] = array(
		'id' => 'custom_kit',
		'title' => esc_html__( 'Prodotto Kit per UpSell', 'metabox-online-generator' ),
		'post_types' => array('product' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => 'id_kit_product',
				'type' => 'text',
				'name' => esc_html__( 'ID kit Prodotto', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Inserire l\'ID del prodotto kit da associare al prodotto corrente. l\'ID si trova nella pagina \"tutti i prodotti\" > metti il cursore su un singolo prodotto > accanto ai tasti di modifica, come primo elemento vedrai l\'ID del prodotto', 'metabox-online-generator' ),
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'custom_kit_product' );

function html_kit_product_id() {
	
	$value = rwmb_get_value( 'id_kit_product' );
	if ($value) {
	?>
	<div  style="clear: both" class="full-w-rel">
		<div class="wrap">
			<div class="ultra-upsell">
				
				<?php
				$params = array(
					'p' => $value, 
					'post_type' => 'product'
				);
				$wc_query = new WP_Query($params); 
				
				?>
				<?php if ($wc_query->have_posts()) :  ?>
				<?php while ($wc_query->have_posts()) : $wc_query->the_post();
					$product = wc_get_product( $wc_query->ID());
					$id_prod = $product->get_id();
				?>
				<div class="cross-item grid-1">
					
					<img src="<?php echo get_the_post_thumbnail_url( $wc_query->ID());?>">
				</div>

				

				<div class="cross-item grid-3">
			
						<h4><?php the_title(); ?></h4>
						<div class="reg-price">
							Avresti pagato: <?php echo $product->get_regular_price(); ?>€
						</div>
							<?php 
							if( $product->is_on_sale() ) {
								?> <div class="sal-price">
									Acquistando insieme: <?php echo $product->get_sale_price(); ?>€
								</div><?php
							}
							?> 
						<?php
					$cart_url = wc_get_cart_url();
					?> <a class="button btn-add" href="<?php echo $cart_url ?>?add-to-cart=<?php echo $id_prod ?>">Aggiungi al carrello</a> 
				</div>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>
				<?php else: ?>
				<p><?php _e( 'No Product' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	}
}

add_action('woocommerce_after_single_product_summary', 'html_kit_product_id', 9);

// pulsante acquista diventa aggiungi al carrello

// Add video private
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

function add_code_upsell() {
	global $product;
	$upsells = is_callable( array( $product, 'get_upsell_ids' ) ) ? $product->get_upsell_ids() : $product->get_upsells();
	
	
	if ( !empty( $upsells )) { ?>

		<div class="full-w">
			<div class="wrap">
				<?php woocommerce_upsell_display(); ?>
			</div>
		</div>

<?php } } 

add_action( 'woocommerce_after_single_product_summary', 'add_code_upsell', 14 );

// Styling account page
function account_page_style() { ?>
	<style>
	.breadcrumb, .entry-title {
		display: none;
	}
	.site-inner {
		margin-top: 0 !important;
	}
	</style>
	<div class="alignfull" style="background-size: cover; background-image:url('<?php echo get_stylesheet_directory_uri() ?>/images/club.jpg')" >
		<img class="img-club" src="<?php echo get_stylesheet_directory_uri() ?>/images/clublogo.png">
	</div>

	<div style="margin: 20px 0;" class="one-half first">
		
		<h2>Entra nel Club di Dottor Cucito</h2>
		<div class="one-half first">
			<img  src="<?php echo get_stylesheet_directory_uri() ?>/images/dcucito-federico.jpg">
		</div>
		<div class="one-half ">
			<p>Iscrivendoti al Club potrai usufruire di vantaggi esclusivi e otterrai subito uno sconto del 10% da utilizzare all'interno dello shop per il tuo primo acquisto e tantissimi altri vantaggi.
Ti ricordiamo che la registrazione è GRATUITA e per iscriverti dovrai soltanto inserire i tuoi dati qui di seguito.</p>
		</div>
	</div>

	<div class="one-half vantaggi">
		<h2>I vantaggi del club</h2>
		<h4>SCONTO DI BENVENUTO</h4>
		<p>Con l'iscrizione al club riceverai un codice sconto del 10% da utilizzare per il tuo primo acquisto sullo shop di Dottor cucito. </p>

		<h4>FORMAZIONE VIDEO GRATUITA</h4>
		<p>Acquistando una macchina per cucire, tagliacuci o ricamatrice*, fra quelle presenti sul sito avrai accesso a video tutorial GRATUITI che ti daranno spunti e insegnamenti sull'utilizzo della macchina che hai acquistato.</p>

		<h4>PROMOZIONI E VANTAGGI ESCLUSIVI</h4>
		<p>Far parte del Club di Dottor Cucito ti consentirà di ricevere offerte esclusive e se ti iscrivi alla newsletter, sarai sempre aggiornato su tutte le novità e promozioni in arrivo.</p>
	</div>

	<div class="clearfix"></div>

<?php }

add_action('woocommerce_before_customer_login_form', 'account_page_style');


function internal_account_style() { ?>

<style>
	.breadcrumb, .entry-title {
		display: none;
	}
	.site-inner {
		margin-top: 0 !important;
	}
	.woocommerce-MyAccount-navigation {
		background: #eeece3;
		padding: 20px;
		border-radius: 20px;
	}
	.woocommerce-MyAccount-navigation ul {
		margin-bottom: 0;
	}
</style>



<?php }

add_action('woocommerce_account_content', 'internal_account_style');

function add_logo_account_page() { ?>
<div class="alignfull" style="margin-bottom: 30px;background-size: cover; background-image:url('<?php echo get_stylesheet_directory_uri() ?>/images/club.jpg')" >
		<img class="img-club" src="<?php echo get_stylesheet_directory_uri() ?>/images/clublogo.png">
	</div>
<?php }

add_action('woocommerce_before_account_navigation', 'add_logo_account_page');

function coupon_accotun_page() { ?>
	<h4>⚠️Utilizza questo coupon sul tuo primo acquisto per risparmiare subito il 10%!</h4>
	<h4 class="coupon-style">BENVENUTA10</h4>
							<hr>
	<h4>&#x1F381; In omaggio per te il 1°numero del Magazine di Dottor Cucito <a target="_blank" title="magazine dottor cucito" style="text-decoration: underline;" href="https://dottorcucito.it/wp-content/themes/dcucito/magazine/Dottor_Cucito_Magazine_1_ottobre%202020.pdf">Clicca qui per scaricare</a></h4>
	
<h4>&#x1F381; In omaggio per te il 2°numero del Magazine di Dottor Cucito <a target="_blank" title="magazine dottor cucito" style="text-decoration: underline;" href="https://dottorcucito.it/wp-content/uploads/magazine/dottorcucito-magazine-2-gennaio-marzo-2021.pdf">Clicca qui per scaricare</a></h4>
	
<?php }

add_action('woocommerce_account_dashboard', 'coupon_accotun_page');

add_action( 'woocommerce_login_form_start','bbloomer_add_login_text' );
  
function bbloomer_add_login_text() {
   if ( is_checkout() ) return;
   echo '<h4 style="font-size: 30px;" class="bb-login-subtitle">Sei registrato? Accedi</h4>';
}
  
add_action( 'woocommerce_register_form_start','bbloomer_add_reg_text' );
  
function bbloomer_add_reg_text() {
   echo '<h4 style="font-size: 30px;" class="bb-register-subtitle">Sei nuovo? Registrati</h4>';
}



add_filter( 'woocommerce_package_rates', 'bbloomer_unset_shipping_when_free_is_available_in_zone', 10, 2 );
   
function bbloomer_unset_shipping_when_free_is_available_in_zone( $rates, $package ) {
      
// Only unset rates if free_shipping is available
if ( isset( $rates['free_shipping:3'] ) ) {
     unset( $rates['flat_rate:4'] );
}     
     
return $rates;
  
}

function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Creare un account?' :
            $translated_text = __( 'Vuoi iscriverti al Club di Dottor Cucito? Iscrivendoti rIceverai promozioni e video tutorial dedicati a te.', 'woocommerce' );
            break;
    }
    return $translated_text;
}

add_filter( 'gettext', 'my_text_strings', 20, 3 );

function disable_price_archive() {
	global $product;
	$id = $product->get_id();
		

	$infoRadio = rwmb_meta( 'radioinfo', array( 'object_type' => 'term' ) );
	//var_dump($infoRadio);
	if ($infoRadio == "onlyinfoTrue") {
		
		if ( !(is_user_logged_in()) ) {
			
			?><style>.woocommerce ul.products li.post-<?php echo $id ?> .price{display: none;!important}</style><?php
		}
		
	}
}

add_action( 'woocommerce_before_shop_loop_item', 'disable_price_archive', 30 );

function change_admin_email_to_store_manager_email( $wp_new_user_notification_email_admin ) {
    $wp_new_user_notification_email_admin['to'] = 'info@dottorcucito.it';
    return $wp_new_user_notification_email_admin;
  }
  add_action( 'wp_new_user_notification_email_admin', 'change_admin_email_to_store_manager_email' );

function woocommerce_created_customer_admin_notification( $customer_id ) {
  wp_send_new_user_notifications( $customer_id, 'admin' );
}

add_action( 'woocommerce_created_customer', 'woocommerce_created_customer_admin_notification' );

function site_ver_header_metadata() {
  ?><meta name="google-site-verification" content="0l8JCTmHXEeFjFzaL5Vpg9S8dWvEJVlm3I12X2NPVIg" /><?php
}
add_action( 'wp_head', 'site_ver_header_metadata' );



