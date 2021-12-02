<?php
/**
 * Theme Functions
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

global $ct_options;

/*-----------------------------------------------------------------------------------*/
/* Bump Server Memory Limit & Max Execution Time */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_mem_time_bump')) {
	function ct_mem_time_bump() {
		if (current_user_can( 'manage_options')) {
			ini_set('memory_limit', '256M');
			ini_set('max_execution_time', 6000);
		}
	}
}
add_action( 'admin_init', 'ct_mem_time_bump' );

/*-----------------------------------------------------------------------------------*/
/* Admin CSS */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_admin_css')) {
	function ct_admin_css() {
		echo '<style>';
		echo '[data-slug="slider-revolution"] + .plugin-update-tr, .vc_license-activation-notice, .rs-update-notice-wrap { display: none;}';
		echo '</style>';
	}
}
add_action('admin_head', 'ct_admin_css');

/*-----------------------------------------------------------------------------------*/
/* Redirect to Theme Options on Activate */
/*-----------------------------------------------------------------------------------*/

if(is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" && !is_child_theme()) {
	add_action('admin_head','ct_option_setup');
	header( 'Location: '.admin_url().'admin.php?page=WPProRealEstate7&tab=45' );
}

/*-----------------------------------------------------------------------------------*/
/* Body IDs */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_body_id')) {
	function ct_body_id() {
		if (is_home() || is_front_page()) {
			echo ' id="home"';
		} elseif (is_single()) {
			echo ' id="single"';
		} elseif (is_page()) {
			echo ' id="page"';
		} elseif (is_search()) {
			echo ' id="search"';
		} elseif (is_archive()) {
			echo ' id="archive"';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Body Classes */
/*-----------------------------------------------------------------------------------*/

function ct_body_classes($classes) {

	global $ct_options;

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';

	// Listing Single Layout
	if(is_singular('listings')) {
		$classes[] = $ct_listing_single_layout;
	}

	// Listings Search
	if (strpos($url,'search-listings=true') !== false) {
		$classes[] = 'search-listings';
	}

	return $classes;
}
add_filter( 'body_class','ct_body_classes' );

/*-----------------------------------------------------------------------------------*/
/* Add Automatic Feed Links */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );

/*-----------------------------------------------------------------------------------*/
/* Add Title Tag Support */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_title_tag')) {
	function ct_title_tag() {
		add_theme_support( 'title-tag' );
	}
}
add_action( 'after_setup_theme', 'ct_title_tag' );

/*-----------------------------------------------------------------------------------*/
/* Add Editor Stylesheet Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('add_editor_style') ) {
	add_editor_style();
}

/*-----------------------------------------------------------------------------------*/
/* Add Post Thumbnail Support */
/*-----------------------------------------------------------------------------------*/

add_theme_support('post-thumbnails');

/*-----------------------------------------------------------------------------------*/
/* Set Content Width */
/*-----------------------------------------------------------------------------------*/

if(!isset($content_width)) $content_width = 1100;

/*-----------------------------------------------------------------------------------*/
/* Add WordPress 3.0 Menu Support */
/*-----------------------------------------------------------------------------------*/

if (function_exists('register_nav_menu')) {
	register_nav_menus( array( 'primary_left' => __( 'Primary Left Menu', 'contempo' ) ) );
	register_nav_menus( array( 'primary_right' => __( 'Primary Right Menu', 'contempo' ) ) );
	register_nav_menus( array( 'primary_full_width' => __( 'Primary Full Width', 'contempo' ) ) );
	register_nav_menus( array( 'footer' => __( 'Footer Menu', 'contempo' ) ) );
}

/*-----------------------------------------------------------------------------------*/
/* Enqueue Admin Scripts */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_enqueue_admin_scripts')) {
	function ct_enqueue_admin_scripts() {
		wp_enqueue_script('megaMenu', get_template_directory_uri() . '/js/ct.megamenu.js', '', '1.0', true);
	}
	add_action('admin_enqueue_scripts', 'ct_enqueue_admin_scripts');
}

/*-----------------------------------------------------------------------------------*/
/* Mega Menu Walker */
/*-----------------------------------------------------------------------------------*/

class CT_Menu_Class_Walker extends Walker_Nav_Menu {
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */


	function start_el(&$output, $item, $depth=0, $args =array(), $id = 0) {
		if( ! is_object( $args )) {
			return ;
		}

		global $first_item_counter;
		if( !isset ($first_item_counter) ) $first_item_counter = 0;

		$classes     = empty ( $item->classes ) ? array () : (array) $item->classes;

		$class_names = join(
			' '
			,   apply_filters(
				'nav_menu_css_class'
				,   array_filter( $classes ), $item
			)
		);

		// find multi column class name and find the column count		
		$re = '/(multicolumn-)+(\d)/U';
		$matches  = preg_grep ($re, $classes);

		$column_count = isset( $matches ) && is_array( $matches ) && count( $matches ) > 0 ? explode("-", reset( $matches ) ) : array(1=>0);
		$column_count = is_array( $column_count ) ? $column_count[1] : $column_count;

		if( $depth == 0 ){
			$class_names = ( 0 < $column_count ) ? $class_names.' multicolumn ': $class_names;
		}

		$sub_title = esc_attr( $item->description );
		$title = apply_filters( 'the_title', $item->title, $item->ID );


		//add class name to li if item has description 
		$class_names .= ! empty( $sub_title ) ? " has-sub-title" : "";

		//find if an icon used as class name - remove from li - use for a 
		if( ! empty ( $class_names ) ){

			if ( strpos( $class_names, "icon-" ) !== false ) {

				$new_class_names = "";
				$icon_name = "";

				foreach (explode(" ", $class_names) as $value) {
					if ( strpos(  $value, "icon-" ) === false ) {
						$new_class_names .= " ". $value ;
					}else{
						$icon_name = $value;
					}
				}

				$class_names = ' class="'. esc_attr( $new_class_names ) . '"';

			}else{
				$class_names = ' class="'. esc_attr( $class_names ) . '"';
			}
		}

		$output .= "<li id='menu-item-$item->ID' $class_names data-depth='$depth' data-column-size='$column_count'>";

		$attributes  = '';

		! empty( $icon_name )
		and $attributes .= ' class="'  . esc_attr( $icon_name ) .'"';

		! empty( $item->attr_title )
		and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';

		! empty( $item->target )
		and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';

		! empty( $item->xfn )
		and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';

		! empty( $item->url )
		and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		if( ! empty($sub_title) ){
			$item_output = $args->before
				. "<a $attributes>"
				. $args->link_before
				. $title
				//. '<span>'.$sub_title.'</span>'
				. '</a> '
				. $args->link_after
				. $args->after;
		}else{
			$item_output = $args->before
				. "<a $attributes>"
				. $args->link_before
				. $title
				. '</a> '
				. $args->link_after
				. $args->after;
		}

		// Since $output is called by referuce we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);

	}

}

/*-----------------------------------------------------------------------------------*/
/* Main Navigation
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_nav_left')) {
	function ct_nav_left() { ?>
		<nav class="left">
			<?php //wp_nav_menu( array( 'container_id' => 'nav-left', 'menu_class' => 'cbp-tm-menu', 'menu_id' => 'cbp-tm-menu', 'theme_location' => 'primary_left', 'fallback_cb' => false) ); ?>
			<?php wp_nav_menu (
				array(
					'menu'            => "primary-left",
					'menu_id'         => "ct-menu",
					'menu_class'      => "ct-menu",
					'echo'            => true,
					'container'       => '',
					'container_class' => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'container_id'    => 'nav-left',
					'theme_location'  => 'primary_left',
					'fallback_cb'	  => false,
					'walker'          => new CT_Menu_Class_Walker
				)
			); ?>
		</nav>
	<?php }
}

if(!function_exists('ct_nav_right')) {
	function ct_nav_right() { ?>
		<nav class="right">
			<?php //wp_nav_menu( array( 'container_id' => 'nav-right', 'menu_class' => 'cbp-tm-menu', 'menu_id' => 'cbp-tm-menu', 'theme_location' => 'primary_right', 'fallback_cb' => false) ); ?>
			<?php wp_nav_menu (
				array(
					'menu'            => "primary-right",
					'menu_id'         => "ct-menu",
					'menu_class'      => "ct-menu",
					'echo'            => true,
					'container'       => '',
					'container_class' => '',
					'container_id'    => 'nav-left',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'container_id'    => 'nav-right',
					'theme_location'  => 'primary_right',
					'fallback_cb'	  => false,
					'walker'          => new CT_Menu_Class_Walker
				)
			); ?>
		</nav>
	<?php }
}

if(!function_exists('ct_nav_full_width')) {
	function ct_nav_full_width() { ?>
		<nav>
			<?php //wp_nav_menu( array( 'container_id' => 'nav-left', 'menu_class' => 'cbp-tm-menu', 'menu_id' => 'cbp-tm-menu', 'theme_location' => 'primary_left', 'fallback_cb' => false) ); ?>
			<?php wp_nav_menu (
				array(
					'menu'            => "primary-full-width",
					'menu_id'         => "ct-menu",
					'menu_class'      => "ct-menu",
					'echo'            => true,
					'container'       => '',
					'container_class' => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'container_id'    => 'nav-full-width',
					'theme_location'  => 'primary_full_width',
					'fallback_cb'	  => false,
					'walker'          => new CT_Menu_Class_Walker
				)
			); ?>
		</nav>
	<?php }
}

if(!function_exists('ct_footer_nav')) {
	function ct_footer_nav() { ?>
		<nav class="left">
			<?php wp_nav_menu( array( 'container_id' => 'footer-nav', 'theme_location' => 'footer', 'fallback_cb' => false) ); ?>
		</nav>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Mobile Header
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_mobile_header')) {
	function ct_mobile_header() {
		global $ct_options;
		$header_layout = isset( $ct_options['ct_header_layout'] ) ? esc_html( $ct_options['ct_header_layout'] ) : '';

		?>

		<div id="cbp-spmenu" class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">

			<?php if($header_layout == "left") { ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary_right', 'fallback_cb' => false) ); ?>

			<?php } elseif($header_layout  == "center") { ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary_left', 'fallback_cb' => false) ); ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary_right', 'fallback_cb' => false) ); ?>

			<?php } elseif($header_layout  == "right") { ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary_right', 'fallback_cb' => false) ); ?>

			<?php } elseif($header_layout  == "none") { ?>
				<?php //No Nav ?>
			<?php } ?>

		</div>

	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* DNS Prefetch
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_dns_prefetch')) {
	function ct_dns_prefetch() {

		echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
		echo '<link rel="dns-prefetch" href="//maps.google.com">';

	}
}
add_action('wp_enqueue_scripts', 'ct_dns_prefetch');

/*-----------------------------------------------------------------------------------*/
/* Google Fonts
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_heading_fonts_url')) {
	function ct_heading_fonts_url() {
		global $ct_options;

		$font_url = '';
		$ct_heading_font = isset( $ct_options['ct_heading_font'] ) ? esc_attr( $ct_options['ct_heading_font'] ) : '';
		$ct_heading_font = str_replace(' ','+', $ct_heading_font);

		$font_url = add_query_arg( 'family', esc_html($ct_heading_font) . ':300,400,700', "//fonts.googleapis.com/css" );

		return $font_url;
	}
}

if(!function_exists('ct_body_fonts_url')) {
	function ct_body_fonts_url() {
		global $ct_options;

		$font_url = '';
		$ct_body_font = isset( $ct_options['ct_body_font'] ) ? esc_attr( $ct_options['ct_body_font'] ) : '';
		$ct_body_font = str_replace(' ','+', $ct_body_font);

		$font_url = add_query_arg( 'family', esc_html($ct_body_font) . ':300,400,700', "//fonts.googleapis.com/css" );

		return $font_url;
	}
}

if(!function_exists('ct_init_scripts')) {
	function ct_init_scripts() {

		global $ct_options, $post;

		/*-----------------------------------------------------------------------------------*/
		/* Enqueue Styles */
		/*-----------------------------------------------------------------------------------*/

		wp_enqueue_style('base', get_template_directory_uri() . '/css/base.css', '', '4.6.4', 'screen, projection');
		wp_enqueue_style('headingFont', ct_heading_fonts_url(), array(), '1.0.0' );
		wp_enqueue_style('bodyFont', ct_body_fonts_url(), array(), '1.0.0' );
		wp_enqueue_style('framework', get_template_directory_uri() . '/css/responsive-gs-12col.css', '', '', 'screen, projection');
		wp_enqueue_style('ie', get_template_directory_uri() . '/css/ie.css', '', '', 'screen, projection');
		wp_enqueue_style('layout', get_template_directory_uri() . '/css/layout.css', '', '', 'screen, projection');
		wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css', '', '4.6.4', 'screen, projection');
		wp_enqueue_style('ctFlexslider', get_template_directory_uri() . '/css/flexslider.css', '', '', 'screen, projection');
		wp_enqueue_style('ctFlexsliderNav', get_template_directory_uri() . '/css/flexslider-direction-nav.css', '', '', 'screen, projection');
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', '', '', 'screen, projection');
		wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.min.css', '', '', 'screen, projection');
		wp_enqueue_style('ctModal', get_template_directory_uri() . '/css/ct-modal-overlay.css', '', '', 'screen, projection');
		wp_enqueue_style('ctSlidePush', get_template_directory_uri() . '/css/ct-sp-menu.css', '', '', 'screen, projection');

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_active( 'dsidxpress/dsidxpress.php' ) ) {
			wp_enqueue_style('dsidxpress', get_template_directory_uri() . '/css/dsidxpress.css', '', '', 'screen, projection');
		}

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if(is_plugin_active('js_composer/js_composer.php')) {
			wp_enqueue_style('ctVisualComposer', get_template_directory_uri() . '/css/ct-visual-composer.css', '', '', 'screen, projection');
		}

		$mode = isset( $ct_options['ct_mode'] ) ? esc_html( $ct_options['ct_mode'] ) : '';
		if(is_singular('listings') || $mode == "single-listing") {
			wp_enqueue_style('print', get_template_directory_uri() . '/css/listing-print.css', '', '', 'print');
			wp_enqueue_style('ctLightbox', get_template_directory_uri() . '/css/ct-lightbox.css', '', '', 'screen, projection');
		}

		$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
		if($ct_listing_single_layout == 'listings-two' && is_singular( 'listings' )) {
			wp_enqueue_style('owlCarousel', get_template_directory_uri() . '/css/owl-carousel.css', '', '', 'screen, projection');
		}

		if(is_single() || is_page()) {
			wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css', '', '', 'screen, projection');
		}

		if(is_single() || is_author() || is_page_template('template-contact.php') || is_page_template('template-submit-listing.php') || is_front_page() || is_page_template('template-agents.php')) {
			wp_enqueue_style('validationEngine', get_template_directory_uri() . '/css/validationEngine.jquery.css', '', '', 'screen, projection');
		}

		if(is_page_template('template-edit-profile.php')) {
			wp_enqueue_style('ctFPE', get_template_directory_uri() . '/css/ct-fpe.css', '', '', 'screen, projection');
		}

		if ($ct_options['ct_rtl'] == 'yes') {
			wp_enqueue_style('rtl', get_template_directory_uri() . '/rtl.css', '', '', 'screen, projection');
		}

		/*-----------------------------------------------------------------------------------*/
		/* Enqueue Scripts */
		/*-----------------------------------------------------------------------------------*/

		if ( $ct_options['ct_mode'] == 'multi-listing') {
			if(has_nav_menu( 'primary_left' ) || has_nav_menu( 'primary_right' ) ) {
				wp_enqueue_style('dropdowns', get_template_directory_uri() . '/css/ct-dropdowns.css', '', '', 'screen, projection');
				wp_enqueue_script('mobileMenu', get_template_directory_uri() . '/js/ct.mobile.menu.js', array('jquery'), '1.0', true);
			}
		}

		wp_enqueue_script('adv-search', get_template_directory_uri() . '/js/ct.advanced.search.js', array('jquery'), '1.0', false );

		$mode = isset( $ct_options['ct_mode'] ) ? esc_html( $ct_options['ct_mode'] ) : '';
		if(is_singular('listings') || $mode == "single-listing") {
			wp_enqueue_script('ctLightbox', get_template_directory_uri() . '/js/ct.lightbox.min.js', 'jquery', '1.0', false);
		}

		$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
		if($ct_listing_single_layout == 'listings-two' && is_singular( 'listings' )) {
			wp_enqueue_script('owlCarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.0', false);
		}

		if(is_page_template('template-edit-profile.php')) {
			wp_enqueue_script( 'password-strength-meter' );
			wp_enqueue_script('ctPassStrength', get_template_directory_uri() . '/js/ct.passwordstrength.js', array('jquery'), '1.0', false);
		}

		if(!is_page_template('template-dsidxpress.php')) {
			wp_enqueue_script('customSelect', get_template_directory_uri() . '/js/jquery.customSelect.min.js', array('jquery'), '1.0', false);
			wp_enqueue_script('ctSelect', get_template_directory_uri() . '/js/ct.select.js', array('jquery'), '1.0', false);
		}

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if (is_plugin_active('wp-favorite-posts/wp-favorite-posts.php')) {
			wp_enqueue_script('ctWPFP', get_template_directory_uri() . '/js/ct.wpfp.js', array('jquery'), '1.0', true);
		}

		$ct_header_currency_switcher = isset( $ct_options['ct_header_currency_switcher'] ) ? esc_html( $ct_options['ct_header_currency_switcher'] ) : '';
		if($ct_header_currency_switcher == 'yes') {
			wp_enqueue_script('currencyConvert', get_template_directory_uri() . '/js/curry-0.8.1.min.js', array('jquery'), '1.0', true);
			wp_enqueue_script('jsCookie', get_template_directory_uri() . '/js/js.cookie.js', array('jquery'), '1.0', true);
		}

		wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '1.0', true);
		wp_enqueue_script('cycle', get_template_directory_uri() . '/js/jquery.cycle.lite.js', array('jquery'), '1.0', true);
		wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '1.0', true);

		if(!is_page_template('template-submit-listing.php')){
			$google_maps_api_key = isset( $ct_options['ct_google_maps_api_key'] ) ? esc_html( $ct_options['ct_google_maps_api_key'] ) : '';
			if($google_maps_api_key != '') {
				$google_maps_api_key_output = '?key=' . $google_maps_api_key;
			} else {
				$google_maps_api_key_output = '';
			}
			wp_enqueue_script('gmaps', '//maps.google.com/maps/api/js' . $google_maps_api_key_output, '', '1.0', false);
		}

		if(is_page_template('template-submit-listing.php')){
			$google_maps_api_key = isset( $ct_options['ct_google_maps_api_key'] ) ? esc_html( $ct_options['ct_google_maps_api_key'] ) : '';
			if($google_maps_api_key != '') {
				$google_maps_api_key_output = '&key=' . $google_maps_api_key;
			} else {
				$google_maps_api_key_output = '';
			}
			wp_enqueue_script('gmapsPlaces', '//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places' . $google_maps_api_key_output, '', '1.0', false);
			wp_enqueue_script('ctAddressAutocomplete', get_template_directory_uri() . '/js/ct.address.autocomplete.js', 'gmaps', '1.0', true);
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('plUpload', get_template_directory_uri() . '/js/plupload.full.min.js', array('jquery'), '1.0', false);
			wp_enqueue_script('plupload-handlers');  // RF added
			wp_enqueue_script('wp-plupload');  // RF added
			wp_enqueue_script('submit-listing', get_template_directory_uri() . '/js/ct.submit.listing.js', array('jquery'), '1.0', false);
			$admin_url = array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) );
			$template_url = array( 'templateUrl' => get_stylesheet_directory_uri() );
			wp_localize_script( 'submit-listing', 'PostID' , array( 'post_id'=>(isset($_GET['listings'])? $_GET['listings'] : $post->ID) ) );
			wp_localize_script( 'submit-listing', 'AdminURL', $admin_url  );
			wp_localize_script( 'submit-listing', 'TemplatePath', $template_url );
		}

		if(is_page_template('template-edit-listing.php')){
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('plupload');  // RF added
			wp_enqueue_script('plupload-handlers');  // RF added
			wp_enqueue_script('wp-plupload');  // RF added
			wp_enqueue_script('edit-listing', get_template_directory_uri() . '/js/ct.edit.listing.js', array('jquery'), '1.0', false);
			$admin_url = array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) );
			$template_url = array( 'templateUrl' => get_stylesheet_directory_uri() );
			wp_localize_script( 'edit-listing', 'PostID' , array( 'post_id'=>(isset($_GET['listings'])? $_GET['listings'] : $post->ID) ) );
			wp_localize_script( 'edit-listing', 'AdminURL', $admin_url  );
			wp_localize_script( 'edit-listing', 'TemplatePath', $template_url );
		}

		if(is_home() || is_front_page() || is_archive() || is_page_template('template-contact.php') || is_page_template('template-contact-no-form.php') || is_page_template('template-big-map.php') || is_page_template('template-demo-home-map.php')){
			wp_enqueue_script('infobox', get_template_directory_uri() . '/js/ct.infobox.js', array('gmaps'), '1.0', true);
			wp_enqueue_script('marker', get_template_directory_uri() . '/js/markerwithlabel.js', array('gmaps'), '1.0', true);
			wp_enqueue_script('markerCluster', get_template_directory_uri() . '/js/markerclusterer.js', array('gmaps'), '1.0', true);
			wp_enqueue_script('mapping', get_template_directory_uri() . '/js/ct.mapping.js', array('gmaps'), '1.0', true);
		}

		$ct_sticky_header = isset( $ct_options['ct_sticky_header'] ) ? esc_attr( $ct_options['ct_sticky_header'] ) : '';
		if ( $ct_sticky_header == 'yes') {
			wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '1.0', true);
		}

		wp_enqueue_script('modernizer', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '1.0', true);
		wp_enqueue_script('classie', get_template_directory_uri() . '/js/classie.js', array('jquery'), '1.0', true);
		wp_enqueue_script('hammer', get_template_directory_uri() . '/js/jquery.hammer.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('touchEffects', get_template_directory_uri() . '/js/toucheffects.js', array('jquery'), '1.0', true);
		wp_enqueue_script('base', get_template_directory_uri() . '/js/base.js', array('jquery'), '1.0', true);
		wp_enqueue_script('ctaccount', get_template_directory_uri() . '/js/ct.account.js', array('jquery'), '1.0', true);

		// Localize the script with new data
		$translation_array = array(
			'close_map' => __( 'Close Map', 'contempo' ),
			'open_map' => __( 'Open Map', 'contempo' ),
			'close_search' => __( 'Close Search', 'contempo' ),
			'open_search' => __( 'Open Search', 'contempo' ),
			'close_tools' => __( 'Close', 'contempo' ),
			'open_tools' => __( 'Open', 'contempo' ),
			'a_value' => '10',
			'ct_ajax_url' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'base', 'object_name', $translation_array );

		if(is_single() || is_author() || is_page_template('template-contact.php') || is_page_template('template-submit-listing.php') || is_front_page() || is_page_template('template-agents.php')) {
			wp_enqueue_script('validationEngine', get_template_directory_uri() . '/js/jquery.validationEngine.js', array('jquery'), '1.0', true);
			// Localize the script with new data
			$ct_validationEngine_errors = array(
				'required' => __('* This field is required', 'contempo'),
				'requiredCheckboxMulti' => __('* Please select an option', 'contempo'),
				'requiredCheckbox' => __('* This checkbox is required', 'contempo'),
				'invalidTelephone' => __('* Invalid phone number', 'contempo'),
				'invalidEmail' => __('* Invalid email address', 'contempo'),
				'invalidDate' => __('* Invalid date, must be in YYYY-MM-DD format', 'contempo'),
				'numbersOnly' => __('* Numbers only', 'contempo'),
				'noSpecialChar' => __('* No special caracters allowed', 'contempo'),
				'letterOnly' => __('* Letters only', 'contempo'),
			);
			wp_localize_script('validationEngine', 'validationError', $ct_validationEngine_errors);
		}
	}
}
add_action('wp_enqueue_scripts', 'ct_init_scripts');

/*-----------------------------------------------------------------------------------*/
/* Enqueue main stylesheet
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_theme_style')) {
	function ct_theme_style() {
		wp_enqueue_style( 'ct-theme-style', get_bloginfo( 'stylesheet_url' ), array(), '1.0', 'screen, projection', 99 );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_theme_style' );

/*-----------------------------------------------------------------------------------*/
/* CT Head */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_wp_head')) {
	function ct_wp_head() {

		/* Load Theme Options */
		global $ct_options; ?>

		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script>
			jQuery(window).load(function() {

				<?php if(!empty($ct_options['ct_custom_js'])) {
                    /*-----------------------------------------------------------------------------------*/
                    /* Custom JS */
                    /*-----------------------------------------------------------------------------------*/
                    print($ct_options['ct_custom_js']);
                } ?>

				<?php if ( $ct_options['ct_sticky_header'] == 'yes' && $ct_options['ct_mode'] != 'single-listing') { ?>
				var masthead_anim_to;
				var masthead = jQuery('#header-wrap'),
					masthead_h = masthead.height();
				masthead_anim_to = (jQuery('body').hasClass('admin-bar')) ? '32px' : '0px';
				masthead.waypoint(function(direction) {
					if(direction == 'down') {
						masthead.css('top', '-'+masthead_h+'px').addClass('sticky').animate({'top': masthead_anim_to});
					}
					if(direction == 'up') {
						masthead.removeClass('sticky').css('top', '');
					}
				}, {
					offset: function() { return -jQuery(this).height(); }
				});
				<?php } ?>

				<?php
                $ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
                if($ct_listing_single_layout == 'listings-two' && is_singular( 'listings' )) { ?>
// Single Listing Carousel
				var owl = jQuery('.owl-carousel');
				owl.owlCarousel({
					items: 3,
					loop: true,
					margin: 0,
					autoplay: true,
					autoplayTimeout: 4000,
					autoplayHoverPause: true,
					responsive:{
						0:{
							items: 1,
							nav: false
						},
						600:{
							items: 2,
							nav: false
						},
						1000:{
							items: 3,
							nav: false,
							loop: false
						}
					}
				});
				<?php } ?>

				<?php if(!is_singular('listings') && $ct_options['ct_mode'] != "single-listing") { ?>
// Slider			
				jQuery('.flexslider').flexslider({
					animation: "<?php echo strtolower($ct_options['ct_flex_animation']); ?>",
					slideDirection: "<?php echo strtolower($ct_options['ct_flex_direction']); ?>",
					slideshow: true,
					slideshowSpeed: <?php echo esc_html($ct_options['ct_flex_speed']); ?>,
					animationDuration: <?php echo esc_html($ct_options['ct_flex_duration']); ?>,
					controlNav: false,
					directionNav: true,
					keyboardNav: true,
					randomize: <?php echo esc_html($ct_options['ct_flex_randomize']); ?>,
					pauseOnAction: true,
					pauseOnHover: false,
					animationLoop: true
				});
				<?php } ?>
			});
		</script>

		<script>

		</script>

		<?php if(is_page_template('template-contact.php')) { ?>
			<script>
				jQuery(document).ready(function() {
					jQuery("#contactform").validationEngine({
						ajaxSubmit: true,
						ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-contact.php",
						ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
						success :  false,
						failure : function() {}
					});
				});
			</script>
		<?php } ?>

		<?php
		$mode = isset( $ct_options['ct_mode'] ) ? esc_html( $ct_options['ct_mode'] ) : '';
		if(is_singular('listings') || $mode == "single-listing") { ?>
			<script>
				jQuery(window).load(function() {
					jQuery('#carousel').flexslider({
						animation: "slide",
						controlNav: false,
						animateHeight: true,
						directionNav: true,
						animationLoop: false,
						slideshow: true,
						slideshowSpeed: <?php echo esc_html($ct_options['ct_flex_speed']); ?>,
						animationDuration: <?php echo esc_html($ct_options['ct_flex_duration']); ?>,
						<?php if($ct_options['ct_mode'] == "single-listing") { ?>
						itemWidth: 200,
						<?php } else { ?>
						itemWidth: 120,
						<?php } ?>
						itemMargin: 0,
						asNavFor: '#slider'
					});

					jQuery('#slider').flexslider({
						animation: "slide",
						<?php
                        $smooth = $ct_options['ct_enable_smootheight'];
                        if($smooth == 'yes') {
                            echo 'smoothHeight: true,';
                        }
                        ?>
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						sync: "#carousel"
					});

					// Slider for Testimonails
					jQuery('.flexslider').flexslider({
						animation: "<?php echo strtolower($ct_options['ct_flex_animation']); ?>",
						slideDirection: "<?php echo strtolower($ct_options['ct_flex_direction']); ?>",
						slideshow: true,
						slideshowSpeed: <?php echo esc_html($ct_options['ct_flex_speed']); ?>,
						animationDuration: <?php echo esc_html($ct_options['ct_flex_duration']); ?>,
						controlNav: false,
						directionNav: true,
						keyboardNav: true,
						randomize: <?php echo esc_html($ct_options['ct_flex_randomize']); ?>,
						pauseOnAction: true,
						pauseOnHover: false,
						animationLoop: true
					});
				});

				jQuery(document).ready(function() {
					jQuery("#listingscontact").validationEngine({
						ajaxSubmit: true,
						ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-listings.php",
						ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
						success :  false,
						failure : function() {}
					});
					jQuery('.gallery-item').magnificPopup({
						type: 'image',
						gallery:{
							enabled:true
						}
					});
				});
			</script>
		<?php } ?>

		<?php

		$ct_header_listing_search = isset( $ct_options['ct_header_listing_search'] ) ? esc_html( $ct_options['ct_header_listing_search'] ) : '';
		$ct_hero_search_bg = isset( $ct_options['ct_hero_search_bg']['url'] ) ? esc_html( $ct_options['ct_hero_search_bg']['url'] ) : '';
		$ct_hero_search_top_pad = isset( $ct_options['ct_hero_search_top_pad'] ) ? esc_html( $ct_options['ct_hero_search_top_pad'] ) : '';
		$ct_hero_search_btm_pad = isset( $ct_options['ct_hero_search_btm_pad'] ) ? esc_html( $ct_options['ct_hero_search_btm_pad'] ) : '';
		$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
		$ct_home_testimonials_style = isset( $ct_options['ct_home_testimonials_style'] ) ? esc_html( $ct_options['ct_home_testimonials_style'] ) : '';

		/*-----------------------------------------------------------------------------------*/
		/* Custom Google Fonts & iHomeFinder CSS */
		/*-----------------------------------------------------------------------------------*/

		echo '<style type="text/css">';
		echo 'h1, h2, h3, h4, h5, h6 { font-family: "' . esc_html($ct_options['ct_heading_font']) . '";}';
		echo 'body, .slider-wrap, input[type="submit"].btn { font-family: "' . esc_html($ct_options['ct_body_font']) . '";}';
		echo '.fa-close:before { content: "\f00d";}';
		if($ct_hero_search_bg != '' || $ct_hero_search_top_pad || $ct_hero_search_btm_pad != '') { echo '.hero-search { background: url(' . $ct_hero_search_bg . ') no-repeat center center; background-size: cover; padding-top:' . $ct_hero_search_top_pad . '%; padding-bottom:' . $ct_hero_search_btm_pad . '%;}';}
		if($ct_hero_search_top_pad || $ct_hero_search_btm_pad != '') { }
		if($ct_header_listing_search == 'yes') { echo '.search-listings #map-wrap { margin-bottom: 0; background-color: #fff;} span.map-toggle, span.search-toggle { border-bottom-right-radius: 3px;} span.searching { border-bottom-left-radius: 3px;}'; }
		if($ct_use_propinfo_icons == 'icons') { echo '.propinfo li { line-height: 2.35em;} .row.baths svg { position: relative; top: 3px; left: -2px;} .row.sqft svg { position: relative; top: 3px;}'; }
		if($ct_home_testimonials_style == 'testimonials-style-two') {
			echo '.aq-block-aq_testimonial_block figure { width: 30%;} .aq-block-aq_testimonial_block .flexslider .slides img { top: 50%; left: 25%; height: 260px; width: 260px; border-radius: 240px;}';
			echo '@media only screen and (max-width: 959px) { .aq-block-aq_testimonial_block .flexslider .slides img { height: 180px; width: 180px; border-radius: 180px;} }';
			echo '@media only screen and (max-width: 767px) { .aq-block-aq_testimonial_block .flexslider .slides img { height: 130px; width: 130px; border-radius: 130px;} }';
			echo '@media only screen and (max-width: 479px) { .aq-block-aq_testimonial_block .flexslider .slides img { height: 80px; width: 80px; border-radius: 80px;} }';
		}
		// Custom Styles for iHomeFinder Homepage Search Widget
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_active( 'optima-express/iHomefinder.php' ) ) {
			echo '.advanced-search.dsidxpress, .home .widget_ihomefinderquicksearchwidget { overflow: visible;}';
			echo '.home .widget_ihomefinderquicksearchwidget .ihf-widget { padding: 0; border: 1px solid #d5d9dd; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px;}';
			echo '.home .widget_ihomefinderquicksearchwidget, .home #ihf-main-container .mb-25 { margin-bottom: 0;}';
			echo '.home #searchProfile select { z-index: 99;}';
			echo '#searchProfile .customSelect, #ihf-main-search-form .customSelect { display: none !important;}';
			echo '.ihf-widget { padding: 20px; overflow: visible;}';
			echo '.widget.widget_ihomefinderpropertiesgallery .gallery-prop-info { padding: 20px;}';
			echo '.ihf-widget .customSelect { display: none !important;}';
		}
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_active( 'idx-broker-platinum/idx-broker-platinum.php' ) ) {
			echo '.idx-omnibar-form { display: none;}';
			echo '.idx-omnibar-form input { line-height: 2em;}';
			echo '.idx-omnibar-form button.idx-omnibar-extra-button { height: auto; margin-bottom: 10px; padding: 1% 0; font-size: .9em; background: #29333d; color: #fff; vertical-align: initial; border: none;}';
			echo '.home .advanced-search.dsidxpress .IDX-quicksearchWrapper { box-shadow: none !important; -webkit-box-shadow: none !important; border: none !important;}';
			echo '.home .advanced-search.dsidxpress .IDX-quicksearchWrapper form { background: #fff !important;}';
			echo '.home .advanced-search.dsidxpress .IDX-quicksearchWrapper label { display: block !important; float: none !important; margin: 0 !important;}';
			echo '.IDX-qsFieldWrap { float: left !important; padding: 0 !important; margin: 0 20px 20px 0 !important; text-align: left !important;}';
			echo '.IDX-quicksearchWrapper input, .IDX-quicksearchWrapper select { width: auto !important;}';
		}
		echo '</style>';

		/*-----------------------------------------------------------------------------------*/
		/* Custom Stylesheet */
		/*-----------------------------------------------------------------------------------*/

		$ct_use_styles = isset( $ct_options['ct_use_styles'] ) ? esc_attr( $ct_options['ct_use_styles'] ) : '';
		if($ct_use_styles == "yes") {
			include(TEMPLATEPATH . '/includes/custom-stylesheet.php');
		}

		/*-----------------------------------------------------------------------------------*/
		/* Custom CSS */
		/*-----------------------------------------------------------------------------------*/

		if(!empty($ct_options['ct_custom_css'])) {
			echo '<style type="text/css">';
			print($ct_options['ct_custom_css']);
			echo '</style>';
		}

		/*-----------------------------------------------------------------------------------*/
		/* Boxed Layout */
		/*-----------------------------------------------------------------------------------*/

		$ct_boxed = isset( $ct_options['ct_boxed'] ) ? esc_attr( $ct_options['ct_boxed'] ) : '';
		if($ct_boxed == "boxed") {
			echo '<style type="text/css">';
			echo 'body { background-color: #ececec;} #wrapper { background: #fff;} .container { padding-right: 20px !important; padding-left: 20px !important;} #top #top-inner { width: 1020px;} footer { padding-left: 0; padding-right: 0;}';
			echo '</style>';
		}

	}
}
add_action('wp_head', 'ct_wp_head');

/*-----------------------------------------------------------------------------------*/
/* CT Footer */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_wp_footer')) {
	function ct_wp_footer() {

		global $ct_options;

		$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
		$ct_header_currency_switcher = isset( $ct_options['ct_header_currency_switcher'] ) ? esc_html( $ct_options['ct_header_currency_switcher'] ) : '';

		if($ct_search_results_listing_style == 'list' || $ct_header_currency_switcher == 'yes') { ?>
			<script>
				jQuery(window).load(function($) {
					<?php if($ct_header_currency_switcher == 'yes') { ?>

					var savedRate, savedCurrency;

					jQuery('#ct-currency-switch').curry({
						change: true,
						target: '.listing-price',
						base: savedCurrency
					}).change(function(){
						var selected = jQuery(this).find(':selected'), // get selected currency
							rate = selected.data('rate'), // get currency rate
							currency = selected.val(); // get currency name
						Cookies.remove('site_currency', { path: '' });
						Cookies.remove('site_rate', { path: '' });
						Cookies.set('site_currency', currency, { expires: 7, path: '' });
						Cookies.set('site_rate', rate, { expires: 7, path: '' });
						console.log( currency, rate );
					});
					var CookieSet = Cookies.get('site_currency')

					if (CookieSet == 'undefined') {
						savedRate = 1;
						savedCurrency = '$ USD';
						console.log('CookieSet Empty. Set to '+savedCurrency);
					}
					else {
						savedRate = Cookies.get('site_rate');
						savedCurrency = Cookies.get('site_currency');
						console.log('CookieSet read from cookie. Saved Rate: '+savedRate+' Saved currency: '+savedCurrency);
					}

					jQuery('#ct-currency-switch').val( savedCurrency );
					jQuery('#ct-currency-switch').show();
					<?php } ?>
					jQuery('.listing-list').find('.list-listing-info').css('height', jQuery('.listing-list').innerHeight());
					jQuery('.list-listing-info').find('.list-listing-info-inner').css('height', jQuery('.list-listing-info').innerHeight());
					jQuery('.list-listing-info .brokerage').show();
					jQuery('.idx-omnibar-form').show();
				});
			</script>
		<?php }

		//if(is_page($ct_options['ct_view'])) {
		echo '<script src="//www.paypalobjects.com/api/checkout.js" async></script>';
		//}

	}
}
add_action('wp_footer', 'ct_wp_footer');

/*-----------------------------------------------------------------------------------*/
/* Disable Visual Composer Updater */
/*-----------------------------------------------------------------------------------*/

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('js_composer/js_composer.php')) {
	if ( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme( $disable_updater = true );
	}
}

//add_action('vc_before_init', function(){
//	if(defined('WPB_VC_VERSION')){
//		$_COOKIE['vchideactivationmsg_vc11'] = WPB_VC_VERSION;
//	}
//});

/*-----------------------------------------------------------------------------------*/
/* Disable Slider Revolution Updater */
/*-----------------------------------------------------------------------------------*/

//add_action('plugins_loaded', function(){
//	remove_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));
//});

/*-----------------------------------------------------------------------------------*/
/* Add Listing Search to Admin */
/*-----------------------------------------------------------------------------------*/

if ( is_admin() ) {
	function listing_search_where( $where ){
		//I check the post type parameter

		if(isset($_GET['post_type']) && $_GET['post_type'] == 'listings') {
			//I overwrite the where clause
			$where = str_replace("AND wp_posts.post_type IN ('post', 'page')", "AND wp_posts.post_type IN ('post', 'page', 'listings')", $where);
		}

		return $where;
	}
	add_filter( 'posts_where', 'listing_search_where');
}

/*-----------------------------------------------------------------------------------*/
/* Admin Notice on How to Update Visual Composer */
/*-----------------------------------------------------------------------------------

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('js_composer/js_composer.php')) {
	// Display Notice
	function ct_vc_admin_notices() {
		global $current_user;
		$user_id = $current_user->ID;

		if(!get_user_meta($user_id, 'ct_vc_install_nag_ignore')) {
			echo '<div class="updated notice is-dismissible">';
		        _e('<h3><strong>Critical Instructions on How to Update Visual Composer!</strong></h3>', 'contempo');
		        echo '<ol>';
			        echo '<li>You need to Deactivate and Delete "WPBakery Visual Composer" by <a href="' . site_url() . '/wp-admin/plugins.php">Clicking Here</a>.';
			        echo '<li>Then Install and Activate the New Version 4.11.2.1 "Visual Composer" by <a href="' .site_url() . '/wp-admin/themes.php?page=install-required-plugins">Clicking Here</a>.</li>';
			        echo '<li>Once you\'ve done that you\'ll be good to go!</li>';
			        echo '<li>From here on out you\'ll be able to use the standard method of updating normally via Appearance > Install Plugins > Update Available.</li>';
			        echo '<li>Once everything is complete just dismiss this notice, cheers.</li>';
		        echo '</ol>';
		        echo '<p><strong><a class="dismiss-notice" href="' . site_url() . '/wp-admin/admin.php?page=WPProRealEstate7&tab=1&ct_vc_install_nag_ignore=0" target="_parent">Dismiss this notice</a></strong></p>';
		    echo '</div>';
		}
	}

	// Set Dismiss Referer
	function ct_vc_admin_notices_init() {
	    if ( isset($_GET['ct_vc_install_nag_ignore']) && '0' == $_GET['ct_vc_install_nag_ignore'] ) {
	        $user_id = get_current_user_id();
	        add_user_meta($user_id, 'ct_vc_install_nag_ignore', 'true', true);
	        if (wp_get_referer()) {
	            /* Redirects user to where they were before 
	            wp_safe_redirect(wp_get_referer());
	        } else {
	            /* if there is no referrer you redirect to home 
	            wp_safe_redirect(home_url());
	        }
	    }
	}
	
	add_action('admin_init', 'ct_vc_admin_notices_init');
	add_action( 'admin_notices', 'ct_vc_admin_notices' );
}

/*-----------------------------------------------------------------------------------*/
/* Expire Listing after X Days */
/*-----------------------------------------------------------------------------------*/

function ct_expire_listings() {
	global $ct_options, $wpdb, $post, $wp_query;

	$author_level = get_the_author_meta('user_level');

	$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
	$ct_listing_trans_id = get_post_meta($post->ID, "_ct_listing_paid_transaction_id", true);
	$ct_listing_expiration = isset( $ct_options['ct_listing_expiration'] ) ? esc_attr( $ct_options['ct_listing_expiration'] ) : '';

	if($ct_enable_front_end_paid == 'yes' && $author_level <= '2' && $ct_listing_expiration != '') {

		$ct_daystogo = $ct_listing_expiration;

		$sql =
			"UPDATE {$wpdb->posts}
		SET post_status = 'pending'
		WHERE (post_type = 'listings' AND post_status = 'publish')
		AND DATEDIFF(NOW(), post_date) > %d";

		$wpdb->query( $wpdb->prepare( $sql, $ct_daystogo ) );
	}

}
add_action('wp_head', 'ct_expire_listings');

/*-----------------------------------------------------------------------------------*/
/* Add Agent User Role */
/*-----------------------------------------------------------------------------------*/

$ct_add_agent_role = add_role( 'agent', 'Agent', array( 'level_7' => true ) );


/*-----------------------------------------------------------------------------------*/
/* WPML Language Switcher */
/*-----------------------------------------------------------------------------------*/

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
	add_filter('icl_ls_languages', 'wpml_ls_filter');
	function wpml_ls_filter($languages) {
		global $sitepress;

		// If a query variable is in the URL
		if(strpos(basename($_SERVER['REQUEST_URI']), '?') !== false){
			foreach($languages as $lang_code => $language){
				$orig_url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$languages[$lang_code]['url'] = $sitepress->convert_url($orig_url, $language['language_code']);
			}
		}
		return $languages;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get translated slugs for WPML */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_taxo_translated')) {
	function ct_get_taxo_translated() {
		$get_term = get_term_by( 'name', 'featured', 'ct_status' );
		$get_term_id = apply_filters( 'wpml_object_id', $get_term->term_id, 'category', true );
		return get_term_by( 'id', $get_term_id, 'ct_status' )->name;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get Current Page */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_currentPage')) {
	function ct_currentPage() {
		global $page;
		return $page ? $page : 1;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Custom Excerpt Length */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_excerpt')) {
	function ct_excerpt() {
		global $ct_options;
		$limit = '22';
		$excerpt = explode(' ', get_the_excerpt(), $limit);

		if (count($excerpt)>=$limit && $limit != 0) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} elseif($limit == 0) {
			$excerpt = '';
		} else {
			$excerpt = implode(" ",$excerpt);
		}
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);

		return $excerpt;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Sort By */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_sort_by')) {
	function ct_sort_by() {

		$extraVars = "";
		foreach($_GET AS $key=>$value) {
			$extraVars .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
		} ?>

		<form action="<?php get_site_url(); ?>"  name="order "class="formsrch right" method="get">
			<?php echo $extraVars;?>
			<select class="ct_orderby" id="ct_orderby" name="ct_orderby">
				<option value=""><?php esc_html_e('Sort By', 'contempo'); ?></option>
				<option value="priceASC" <?php if(isset($_GET['ct_orderby']) && $_GET['ct_orderby'] == 'priceASC'){ ?> selected="selected" <?php } ?>><?php esc_html_e('Price - Low to High', 'contempo'); ?></option>
				<option value="priceDESC" <?php if(isset($_GET['ct_orderby']) && $_GET['ct_orderby'] == 'priceDESC'){ ?> selected="selected" <?php } ?>><?php esc_html_e('Price - High to Low', 'contempo'); ?></option>
				<option value="dateASC" <?php if(isset($_GET['ct_orderby']) && $_GET['ct_orderby'] == 'dateASC'){ ?> selected="selected" <?php } ?>><?php esc_html_e('Date - Old to New', 'contempo'); ?></option>
				<option value="dateDESC" <?php if(isset($_GET['ct_orderby']) && $_GET['ct_orderby'] == 'dateDESC'){ ?> selected="selected" <?php } ?>><?php esc_html_e('Date - New to Old', 'contempo'); ?></option>
			</select>
		</form>

	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Theme Directory URI */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_theme_directory_uri')) {
	function ct_theme_directory_uri() {

		$images = get_stylesheet_directory() . '/images/';

		if(is_child_theme() && file_exists($images)) {
			return get_stylesheet_directory_uri();
		} else {
			return get_template_directory_uri();
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Geocode Address */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_geocode_address')) {
	function ct_geocode_address($post_id) {

		global $ct_options;
		if($ct_options['ct_listing_lat_long'] == "on" && !is_page_template('template-submit-listing')) {

			global $post;
			global $wp_query;

			if(isset( $_POST['post_type'] ) && $_POST['post_type'] != 'listings')
				return;

			$city = wp_get_post_terms($post_id, 'city');
			$city = $city[0];
			$city = $city->name;

			$state = wp_get_post_terms($post_id, 'state');
			$state = $state[0];
			$state = $state->name;

			$zip = wp_get_post_terms($post_id, 'zipcode');
			$zip = $zip[0];
			$zip = $zip->name;

			$street = get_the_title($post_id);

			if($street && $city) {
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($street.' '.$city.', '.$state.' '.$zip)."&sensor=false";
				$resp = wp_remote_get($url);
				if ( 200 == $resp['response']['code'] ) {
					$body = $resp['body'];
					$data = json_decode($body);
					if($data->status=="OK"){
						$latitude = $data->results[0]->geometry->location->lat;
						$longitude = $data->results[0]->geometry->location->lng;
						update_post_meta($post_id, "_ct_latlng", $latitude.','.$longitude);
					}
				}
			}
		}
	}
	add_action('save_post', 'ct_geocode_address', 999);
}

/*-----------------------------------------------------------------------------------*/
/* Contact Us Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_contact_us_map')) {
	function ct_contact_us_map() {
		global $ct_options;
		if($ct_options['ct_contact_map'] =="yes") { ?>
			<script>
				function setMapAddress(address) {
					var geocoder = new google.maps.Geocoder();
					geocoder.geocode( { address : address }, function( results, status ) {
						if( status == google.maps.GeocoderStatus.OK ) {
							var location = results[0].geometry.location;
							var options = {
								zoom: 15,
								center: location,
								mapTypeId: google.maps.MapTypeId.<?php echo esc_html(strtoupper($ct_options['ct_contact_map_type'])); ?>,
								streetViewControl: true,
								scrollwheel: false,
								draggable: false,
								<?php 
								$ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';    
								if($ct_gmap_style != "default") { ?>
								styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
								<?php } ?>
							};
							var mymap = new google.maps.Map( document.getElementById( 'map' ), options );
							var marker = new google.maps.Marker({
								map: mymap,
								animation: google.maps.Animation.DROP,
								flat: true,
								icon: '<?php echo get_template_directory_uri(); ?>/images/map-pin-com.png',
								position: results[0].geometry.location
							});
						}
					});
				}
				setMapAddress( "<?php echo esc_html($ct_options['ct_contact_map_location']); ?>" );
			</script>
			<div id="location" class="marB18">
				<div id="map" style="height: 300px;"></div>
			</div>
		<?php }
	}
}

/*-----------------------------------------------------------------------------------*/
/* Brokerage Single Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_brokerage_single_map')) {
	function ct_brokerage_single_map($brokerage_address) {
		global $ct_options;
		?>
		<script>
			function setMapAddress(address) {
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode( { address : address }, function( results, status ) {
					if( status == google.maps.GeocoderStatus.OK ) {
						var location = results[0].geometry.location;
						var options = {
							zoom: 15,
							center: location,
							mapTypeId: google.maps.MapTypeId.<?php echo esc_html(strtoupper($ct_options['ct_contact_map_type'])); ?>,
							streetViewControl: true,
							scrollwheel: false,
							draggable: false,
							<?php 
							$ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';    
							if($ct_gmap_style != "default") { ?>
							styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
							<?php } ?>
						};

						jQuery('ul.tabs li.brokerage-map').click(function(e) {
							setTimeout(function() {
								var mymap = new google.maps.Map( document.getElementById( 'map' ), options );

								var marker = new google.maps.Marker({
									map: mymap,
									animation: google.maps.Animation.DROP,
									flat: true,
									icon: '<?php echo get_template_directory_uri(); ?>/images/map-pin-com.png',
									position: results[0].geometry.location
								});
								google.maps.event.trigger(mymap, "resize");
								marker.setMap(mymap);
							}, 1000);
						});
					}
				});
			}
			setMapAddress( "<?php echo $brokerage_address; ?>" );
		</script>
		<div id="location" class="marB18">
			<div id="map" style="height: 300px;"></div>
		</div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Multi Location Contact Us Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_multi_contact_us_map')) {
	function ct_multi_contact_us_map() {
		global $ct_options;
		$count = 0;

		$location_one = isset( $ct_options['ct_contact_map_location_one'] ) ? esc_html( $ct_options['ct_contact_map_location_one'] ) : '';
		$location_one_img = isset( $ct_options['ct_contact_map_location_image']['url'] ) ? esc_html( $ct_options['ct_contact_map_location_image']['url'] ) : '';

		$location_two = isset( $ct_options['ct_contact_map_location_two'] ) ? esc_html( $ct_options['ct_contact_map_location_two'] ) : '';
		$location_two_img = isset( $ct_options['ct_contact_map_location_two_image']['url'] ) ? esc_html( $ct_options['ct_contact_map_location_two_image']['url'] ) : '';

		$location_three = isset( $ct_options['ct_contact_map_location_three'] ) ? esc_html( $ct_options['ct_contact_map_location_three'] ) : '';
		$location_three_img = isset( $ct_options['ct_contact_map_location_three_image']['url'] ) ? esc_html( $ct_options['ct_contact_map_location_three_image']['url'] ) : '';

		$location_four = isset( $ct_options['ct_contact_map_location_four'] ) ? esc_html( $ct_options['ct_contact_map_location_four'] ) : '';
		$location_four_img = isset( $ct_options['ct_contact_map_location_four_image']['url'] ) ? esc_html( $ct_options['ct_contact_map_location_four_image']['url'] ) : '';

		$map_locations = array(
			0 => array(
				'address' => $location_one,
				'image' => $location_one_img
			),
			1 => array(
				'address' => $location_two,
				'image' => $location_two_img
			),
			2 => array(
				'address' => $location_three,
				'image' => $location_three_img
			),
			3 => array(
				'address' => $location_four,
				'image' => $location_four_img
			),
		);
		?>

		<script>
			var property_list = [];
			var default_mapcenter = [];
			var ctMapGlobal = {
				mapStyle: "<?php $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';  echo esc_html($ct_gmap_style); ?>"
			}

			<?php if ($map_locations) {

                for ($i = 0; $i < count($map_locations); $i++) {

                    $count++; ?>

			var property = {
				thumb: "<?php echo esc_url($map_locations[$i]['image']); ?>",
				street: "<?php echo esc_html($map_locations[$i]['address']); ?>",
				commercial: "commercial",
				contactpage: "contactpage",
				siteURL: "<?php echo ct_theme_directory_uri(); ?>"
			}
			property_list.push(property);

			<?php
        }
    }
    ?>
		</script>
		<script>var defaultmapcenter = {mapcenter: ""}; google.maps.event.addDomListener(window, 'load', function(){ estateMapping.init_property_map(property_list, defaultmapcenter); });</script>
		<div id="location" class="marB18">
			<div id="map" style="height: 460px;"></div>
		</div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Single Listing Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listing_map')) {
	function ct_listing_map() {
		global $ct_options;
		?>
		<script>
			function setMapAddress(address) {
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode( { address : address }, function( results, status ) {
					if( status == google.maps.GeocoderStatus.OK ) {
						<?php  if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>
						var location = new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>);
						<?php } else { ?>
						var location = results[0].geometry.location;
						<?php } ?>
						var options = {
							zoom: 15,
							center: location,
							scrollwheel: false,
							mapTypeId: google.maps.MapTypeId.<?php echo esc_html(strtoupper($ct_options['ct_contact_map_type'])); ?>,
							streetViewControl: true,
							<?php
                            $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';
                            if($ct_gmap_style != "default") { ?>
							styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
							<?php } ?>
						};
						var mymap = new google.maps.Map( document.getElementById( 'map' ), options );
						var marker = new google.maps.Marker({
							map: mymap,
							animation: google.maps.Animation.DROP,
							draggable: false,
							flat: true,
							<?php if(ct_has_type('commercial')) { ?>
							icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-com.png',
							<?php } elseif(ct_has_type('land')) { ?>
							icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-land.png',
							<?php } else { ?>
							icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-res.png',
							<?php } ?>
							<?php  if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>
							position: new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>)
							<?php } else { ?>
							position: results[0].geometry.location
							<?php } ?>
						});
					}
				});
			}

			<?php if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>
			setMapAddress( "<?php echo esc_html(get_post_meta(get_the_ID(), "_ct_latlng", true)); ?>" );
			<?php } elseif(is_page_template('template-edit-listing.php')) { ?>
			setMapAddress( "<?php esc_html($title); ?> <?php esc_html($city); ?> <?php esc_html($state); ?> <?php esc_html($zipcode); ?>" );
			<?php } else { ?>
			setMapAddress( "<?php the_title(); ?> <?php ct_taxonomy('city'); ?> <?php ct_taxonomy('state'); ?> <?php ct_taxonomy('zipcode'); ?>" );
			<?php } ?>

		</script>
		<div id="map"></div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Multi Marker Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_multi_marker_map')) {
	function ct_multi_marker_map() {
		global $ct_options;
		global $post;
		$count = 0;
		query_posts(array(
			'post_type' => 'listings',
			'posts_per_page' => 1000,
			'order' => 'DSC'
		)); ?>

		<script>
			var property_list = [];
			var default_mapcenter = [];
			var ctMapGlobal = {
				mapStyle: "<?php $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';  echo esc_html($ct_gmap_style); ?>"
			}

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

            $count++; ?>

			var property = {
				thumb: '<?php ct_first_image_map_tn(); ?>',
				fullPrice: "<?php ct_listing_price(); ?>",
				bed: "<?php ct_taxonomy('beds'); ?>",
				bath: "<?php ct_taxonomy('baths'); ?>",
				size: "<?php echo get_post_meta($post->ID, "_ct_sqft", true); ?> <?php ct_sqftsqm(); ?>",
				street: "<?php ct_listing_title(); ?>",
				city: "<?php ct_taxonomy('city'); ?>",
				state: "<?php ct_taxonomy('state'); ?>",
				zip: "<?php ct_taxonomy('zipcode'); ?>",
				latlong: "<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>",
				permalink: "<?php the_permalink(); ?>",
				agentThumb: "<?php $agent = the_author_meta('ct_profile_url'); echo aq_resize($agent,40); ?>",
				agentName: "<?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?>",
				agentTagline: "<?php if(get_the_author_meta('tagline')) { the_author_meta('tagline'); } ?>",
				agentPhone: "<?php if(get_the_author_meta('office')) { the_author_meta('office'); } ?>",
				agentEmail: "<?php if(get_the_author_meta('email')) { the_author_meta('email'); } ?>",
				isHome: "<?php if(is_home()) { echo "false"; } else { echo "true"; } ?>",
				commercial: "<?php if(ct_has_type('commercial')) { echo 'commercial'; } ?>",
				land: "<?php if(ct_has_type('land')) { echo 'land'; } ?>",
				siteURL: "<?php echo ct_theme_directory_uri(); ?>"
			}
			property_list.push(property);

			<?php
            endwhile; endif;
            wp_reset_query();
            ?>
		</script>
		<script>var defaultmapcenter = {mapcenter: ""}; google.maps.event.addDomListener(window, 'load', function(){ estateMapping.init_property_map(property_list, defaultmapcenter); });</script>
		<div id="map"></div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Featured Listings Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_featured_listings_map')) {
	function ct_featured_listings_map() {
		global $ct_options;
		global $post;
		$count = 0;
		query_posts(array(
			'post_type' 		=> 'listings',
			'status' 			=> 'featured',
			'posts_per_page' 	=> 1000,
			'order' 			=> 'DSC'
		)); ?>

		<script>
			var property_list = [];
			var default_mapcenter = [];
			var ctMapGlobal = {
				mapStyle: "<?php $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';  echo esc_html($ct_gmap_style); ?>"
			}

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

            $count++; ?>

			var property = {
				thumb: '<?php ct_first_image_map_tn(); ?>',
				fullPrice: "<?php ct_listing_price(); ?>",
				bed: "<?php ct_taxonomy('beds'); ?>",
				bath: "<?php ct_taxonomy('baths'); ?>",
				size: "<?php echo get_post_meta($post->ID, "_ct_sqft", true); ?> <?php ct_sqftsqm(); ?>",
				street: "<?php ct_listing_title(); ?>",
				city: "<?php ct_taxonomy('city'); ?>",
				state: "<?php ct_taxonomy('state'); ?>",
				zip: "<?php ct_taxonomy('zipcode'); ?>",
				latlong: "<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>",
				permalink: "<?php the_permalink(); ?>",
				agentThumb: "<?php $agent = the_author_meta('ct_profile_url'); echo aq_resize($agent,40); ?>",
				agentName: "<?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?>",
				agentTagline: "<?php if(get_the_author_meta('tagline')) { the_author_meta('tagline'); } ?>",
				agentPhone: "<?php if(get_the_author_meta('office')) { the_author_meta('office'); } ?>",
				agentEmail: "<?php if(get_the_author_meta('email')) { the_author_meta('email'); } ?>",
				isHome: "<?php if(is_home()) { echo "false"; } else { echo "true"; } ?>",
				commercial: "<?php if(ct_has_type('commercial')) { echo 'commercial'; } ?>",
				land: "<?php if(ct_has_type('land')) { echo 'land'; } ?>",
				siteURL: "<?php echo ct_theme_directory_uri(); ?>"
			}
			property_list.push(property);

			<?php
            endwhile; endif;
            wp_reset_query();
            ?>
		</script>
		<script>var defaultmapcenter = {mapcenter: ""}; google.maps.event.addDomListener(window, 'load', function(){ estateMapping.init_property_map(property_list, defaultmapcenter); });</script>
		<div id="map"></div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Search Results Map */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_search_results_map')) {
	function ct_search_results_map() {
		global $ct_options;
		global $post;
		$count = 0;
		?>

		<script>
			var property_list = [];
			var default_mapcenter = [];
			var ctMapGlobal = {
				mapStyle: "<?php $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';  echo esc_html($ct_gmap_style); ?>"
			}

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

            $count++; ?>

			var property = {
				thumb: '<?php ct_first_image_map_tn(); ?>',
				fullPrice: "<?php ct_listing_price(); ?>",
				bed: "<?php ct_taxonomy('beds'); ?>",
				bath: "<?php ct_taxonomy('baths'); ?>",
				size: "<?php echo get_post_meta($post->ID, "_ct_sqft", true); ?> <?php ct_sqftsqm(); ?>",
				street: "<?php ct_listing_title(); ?>",
				city: "<?php ct_taxonomy('city'); ?>",
				state: "<?php ct_taxonomy('state'); ?>",
				zip: "<?php ct_taxonomy('zipcode'); ?>",
				latlong: "<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>",
				permalink: "<?php the_permalink(); ?>",
				agentThumb: "<?php $agent = the_author_meta('ct_profile_url'); echo aq_resize($agent,40); ?>",
				agentName: "<?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?>",
				agentTagline: "<?php if(get_the_author_meta('tagline')) { the_author_meta('tagline'); } ?>",
				agentPhone: "<?php if(get_the_author_meta('office')) { the_author_meta('office'); } ?>",
				agentEmail: "<?php if(get_the_author_meta('email')) { the_author_meta('email'); } ?>",
				isHome: "<?php if(is_home()) { echo "false"; } else { echo "true"; } ?>",
				commercial: "<?php if(ct_has_type('commercial')) { echo 'commercial'; } ?>",
				land: "<?php if(ct_has_type('land')) { echo 'land'; } ?>",
				siteURL: "<?php echo ct_theme_directory_uri(); ?>"
			}
			property_list.push(property);

			<?php
            endwhile; endif;
            wp_reset_query();
            ?>
		</script>
		<script>var defaultmapcenter = {mapcenter: ""}; google.maps.event.addDomListener(window, 'load', function(){ estateMapping.init_property_map(property_list, defaultmapcenter); });</script>
		<div id="map"></div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Homepage Slider */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_slider')) {
	function ct_slider() {
		global $ct_options;
		global $post;
		$slides = $ct_options['ct_flex_slider'];
		if($slides > 1) { ?>
			<div id="slider" class="flexslider">
				<ul class="slides">

					<?php
					foreach ($slides as $slide => $value) {
						$imgURL = $value['url'];
						$imgID = ct_get_attachment_id_from_src($imgURL);
						?>
						<li>
							<div class="flex-container">
								<?php if(!empty ($value['title']) || !empty ($value['description'])) { ?>
									<div class="flex-caption">
										<div class="flex-inner">
											<?php if(!empty ($value['title'])) { ?>
												<h3><?php echo esc_html($value['title']); ?></h3>
												<?php if(!empty ($value['description'])) { ?>
													<p><?php echo esc_html($value['description']); ?></p>
												<?php } ?>
											<?php } ?>
										</div>
										<div class="clear"></div>
									</div>
								<?php } ?>
							</div>
							<?php if(!empty ($value['url'])) { ?>
								<a href="<?php echo $value['url']; ?>">
									<img src="<?php echo $value['image']; ?>" />
								</a>
							<?php } else { ?>
								<img src="<?php echo $value['image']; ?>" />
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="clear"></div>

		<?php }
	}
}

/*-----------------------------------------------------------------------------------*/
/* Front End Featured Image Uploads */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_insert_attachment')) {
	function ct_insert_attachment($file_handler,$post_id,$setthumb='false') {
		// check to make sure its a successful upload
		if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');

		$attach_id = media_handle_upload( $file_handler, $post_id );

		if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
		return $attach_id;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Front End Delete Attachment */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_delete_attachment')) {
	function ct_delete_attachment( $post ) {
		//echo $_POST['att_ID'];
		$msg = 'Attachment ID [' . $_POST['att_ID'] . '] has been deleted!';
		if( wp_delete_attachment( $_POST['att_ID'], true )) {
			echo $msg;
		}
		die();
	}
}
add_action( 'wp_ajax_delete_attachment', 'ct_delete_attachment' );

/*-----------------------------------------------------------------------------------*/
/* User Listing Post Count */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listing_post_count')) {
	function ct_listing_post_count( $userid, $post_type = ‘post’ ) {
		if( empty( $userid ) )
			return false;

		// if we get there, great so all fine and ready to go
		$args = array(
			'post_type'    => $post_type,
			'author'     => $userid
		);

		$the_query = new WP_Query( $args );
		$user_post_count = $the_query->found_posts;

		return $user_post_count;
	}
				}

/*-----------------------------------------------------------------------------------*/
/* Front End Delete Post */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_delete_post_link')) {
	function ct_delete_post_link($link = 'Delete This', $before = '', $after = '') {
		global $post;
		if ( $post->post_type == 'page' ) {
			if ( !current_user_can( 'edit_page', $post->ID ) )
				return;
		} else {
			if ( !current_user_can( 'edit_post', $post->ID ) )
				return;
		}
		$message = 'Are you sure you want to delete ' . get_the_title($post->ID) .' ?';
		$delLink = wp_nonce_url( esc_url( home_url() ) . '/wp-admin/post.php?action=delete&amp;post=' . $post->ID, 'delete-post_' . $post->ID);
		$htmllink = '<a class="btn delete-listing" href="' . $delLink . '" onclick = "if ( confirm(\'' . $message . '\' ) ) { execute(); return true; } return false;" />' . $link . '</a>';
		echo $before . $htmllink . $after;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Submit Listing from Front End */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_submit_listing')) {
	function ct_submit_listing() {

		global $ct_options;
		$view = $ct_options['ct_view'];
		$ct_auto_publish = $ct_options['ct_auto_publish'];

		if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

			if(trim($_POST['postTitle']) === '') {
				$postTitleError = 'Please enter an address.';
				$hasError = true;
			} else {
				$postTitle = trim($_POST['postTitle']);
			}

			$post_information = array(
				'post_title' => wp_strip_all_tags( $_POST['postTitle'] ),
				'post_content' => $_POST['postContent'],
				'post_type' => 'listings',
				'post_status' => $ct_auto_publish
			);

			$post_id = wp_insert_post($post_information);

			if ($_FILES) {
				foreach ($_FILES as $file => $array) {
					$newupload = ct_insert_attachment($file,$post_id);
				}
			}

			if($post_id) {

				// Update Custom Meta
				update_post_meta($post_id, '_ct_listing_alt_title', esc_attr(strip_tags($_POST['customMetaAltTitle'])));
				update_post_meta($post_id, '_ct_price', esc_attr(strip_tags($_POST['customMetaPrice'])));
				update_post_meta($post_id, '_ct_price_prefix', esc_attr(strip_tags($_POST['customMetaPricePrefix'])));
				update_post_meta($post_id, '_ct_price_postfix', esc_attr(strip_tags($_POST['customMetaPricePostfix'])));
				update_post_meta($post_id, '_ct_sqft', esc_attr(strip_tags($_POST['customMetaSqFt'])));
				update_post_meta($post_id, '_ct_video', esc_attr(strip_tags($_POST['customMetaVideoURL'])));
				update_post_meta($post_id, '_ct_mls', esc_attr(strip_tags($_POST['customMetaMLS'])));
				update_post_meta($post_id, '_ct_rental_guests', esc_attr(strip_tags($_POST['customMetaMaxGuests'])));
				update_post_meta($post_id, '_ct_rental_min_stay', esc_attr(strip_tags($_POST['customMetaMinStay'])));
				update_post_meta($post_id, '_ct_rental_checkin', esc_attr(strip_tags($_POST['customMetaCheckIn'])));
				update_post_meta($post_id, '_ct_rental_checkout', esc_attr(strip_tags($_POST['customMetaCheckOut'])));
				update_post_meta($post_id, '_ct_rental_extra_people', esc_attr(strip_tags($_POST['customMetaExtraPerson'])));
				update_post_meta($post_id, '_ct_rental_cleaning', esc_attr(strip_tags($_POST['customMetaCleaningFee'])));
				update_post_meta($post_id, '_ct_rental_cancellation', esc_attr(strip_tags($_POST['customMetaCancellationFee'])));
				update_post_meta($post_id, '_ct_rental_deposit', esc_attr(strip_tags($_POST['customMetaSecurityDeposit'])));

				//Update Custom Taxonomies
				wp_set_post_terms($post_id,array($_POST['ct_property_type']),'property_type',true);
				wp_set_post_terms($post_id,array($_POST['customTaxBeds']),'beds',true);
				wp_set_post_terms($post_id,array($_POST['customTaxBaths']),'baths',true);
				wp_set_post_terms($post_id,array($_POST['ct_ct_status']),'ct_status',true);
				wp_set_post_terms($post_id,array($_POST['customTaxCity']),'city',true);
				wp_set_post_terms($post_id,array($_POST['customTaxState']),'state',true);
				wp_set_post_terms($post_id,array($_POST['customTaxZip']),'zipcode',true);
				wp_set_post_terms($post_id,array($_POST['customTaxFeat']),'additional_features',true);

				// Redirect
				wp_redirect( home_url() . '/?page_id=' . $view ); exit;
			}
		}

	}
}


/*-----------------------------------------------------------------------------------*/
/* PayPal for Paid Submissions */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_paypal')) {
	require_once (ADMIN_PATH . 'gateways/paypalnow.php');
}

/*-----------------------------------------------------------------------------------*/
/* Deactivate Old Frontend Edit Profile Plugins */
/*-----------------------------------------------------------------------------------*/

deactivate_plugins('/frontend-edit-profile/fep.php');
deactivate_plugins('/ct-frontend-edit-profile/fep.php');

/*-----------------------------------------------------------------------------------*/
/* Deactivate Old Envato Toolkit Plugin */
/*-----------------------------------------------------------------------------------*/

deactivate_plugins('/envato-wordpress-toolkit-master/index.php');

/*-----------------------------------------------------------------------------------*/
/* Login & Registration */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_registration_form')) {
	function ct_registration_form() {

		// only show the registration form to non-logged-in members
		if(!is_user_logged_in()) {

			// check to make sure user registration is enabled
			$registration_enabled = get_option('users_can_register');

			// only show the registration form if allowed
			if($registration_enabled) {
				$output = ct_registration_form_fields();
			} else {
				$output = '<p class="no-registration">' . __('User registration is not enabled', 'contempo') . '</p>';
			}
			return $output;
		}
	}
}

// User login form
if(!function_exists('ct_login_form')) {
	function ct_login_form() {

		if(!is_user_logged_in()) {
			$output = ct_login_form_fields();
		} else {
			// could show some logged in user info here
			$output = '<!-- logged in -->';
		}
		return $output;
	}
}

// Login Form Fields
if(!function_exists('ct_login_form_fields')) {
	function ct_login_form_fields() {

		ob_start(); ?>
		<h4 class="marB20"><?php esc_html_e('Log in', 'contempo'); ?></h4>
		<p class="muted marB20"><?php esc_html_e('Don\'t have an account?', 'contempo'); ?> <a class="ct-registration" href="#"><?php esc_html_e('Create your account,', 'contempo'); ?></a> <?php esc_html_e('it takes less than a minute.', 'contempo'); ?></p>
		<div class="clear"></div>

		<div id="ct_account_errors">
			<?php
			// show any error messages after form submission
			ct_show_error_messages(); ?>
		</div>

		<form id="ct_login_form"  class="ct_form" action="" method="post">
			<fieldset>
				<label id="ct_user_login" for="ct_user_Login"><?php esc_html_e('Username', 'contempo'); ?></label>
				<input name="ct_user_login" id="ct_user_login" class="required" type="text" required />

				<label id="ct_user_pass" for="ct_user_pass"><?php esc_html_e('Password', 'contempo'); ?></label>
				<input name="ct_user_pass" id="ct_user_pass" class="required" type="password" required />

				<div class="clear"></div>
				<input type="hidden" name="ct_login_nonce" value="<?php echo wp_create_nonce('ct-login-nonce'); ?>"/>
				<input type="hidden" name="action" value="ct_login_member_ajax"/>
				<input class="btn marT10" id="ct_login_submit" type="submit" value="Login"/>
			</fieldset>
		</form>
		<p class="marB0"><small><a class="muted ct-lost-password" href="#" title="Lost your password?"><?php _e('Lost your password?', 'contempo'); ?></a></small></p>
		<?php
		return ob_get_clean();
	}
}

// Lost Password Fields
if(!function_exists('ct_lost_password_fields')) {
	function ct_lost_password_fields() { ?>

		<h4 class="marB20"><?php esc_html_e('Lost Password?', 'contempo'); ?></h4>
		<p class="muted"><?php _e('Enter your email address and we\'ll send you a link you can use to pick a new password.', 'contempo'); ?></p>
		<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
			<label for="user_login"><?php _e( 'Username or Email', 'contempo' ); ?>
				<input type="text" name="user_login" id="user_login">
				<input type="submit" name="user-submit" class="btn marT10" value="<?php _e( 'Get New Password', 'contempo' ); ?>"/>
				</p>
		</form>
	<?php }
}

if(!function_exists('ct_password_lost')) {
	function ct_password_lost() {
		if('POST' == $_SERVER['REQUEST_METHOD']) {
			$errors = retrieve_password();
			if ( is_wp_error( $errors ) ) {
				// Errors found
				$redirect_url = home_url();
				$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
			} else {
				// Email sent
				$redirect_url = home_url();
				$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
			}

			wp_redirect( $redirect_url );
			exit;
		}
	}
}

// Registration form fields
if(!function_exists('ct_registration_form_fields')) {
	function ct_registration_form_fields() {

		ob_start(); ?>
		<h4 class="marB20"><?php esc_html_e('Create an account', 'contempo'); ?></h4>
		<p class="muted marB20"><?php esc_html_e('It takes less than a minute. If you already have an account ', 'contempo'); ?><a class="ct-login" href="#"><?php esc_html_e('login', 'contempo'); ?></a>.</p>

		<div id="ct_account_errors">
			<?php
			// show any error messages after form submission
			ct_show_error_messages(); ?>
		</div>

		<form id="ct_registration_form" class="ct_form" action="" method="POST">
			<fieldset>
				<label for="ct_user_Login"><?php esc_html_e('Username', 'contempo'); ?></label>
				<input name="ct_user_login" id="ct_user_login" class="required" type="text"/>

				<label for="ct_user_email"><?php esc_html_e('Email', 'contempo'); ?></label>
				<input name="ct_user_email" id="ct_user_email" class="required" type="email"/>

				<!--<label for="ct_user_first"><?php esc_html_e('First Name', 'contempo'); ?></label>
						<input name="ct_user_first" id="ct_user_first" type="text"/>

						<label for="ct_user_last"><?php esc_html_e('Last Name', 'contempo'); ?></label>
						<input name="ct_user_last" id="ct_user_last" type="text"/>-->

				<div class="col span_6 first">
					<label for="password"><?php esc_html_e('Password', 'contempo'); ?></label>
					<input name="ct_user_pass" id="password" class="required" type="password"/>
				</div>

				<div class="col span_6">
					<label for="password_again"><?php esc_html_e('Password Again', 'contempo'); ?></label>
					<input name="ct_user_pass_confirm" id="password_again" class="required" type="password"/>
				</div>

				<input type="hidden" name="ct_register_nonce" value="<?php echo wp_create_nonce('ct-register-nonce'); ?>"/>
				<input class="marT10" type="submit" value="<?php esc_html_e('Register', 'contempo'); ?>"/>
			</fieldset>
		</form>
		<?php
		return ob_get_clean();
	}
}

// Register a new user
if(!function_exists('ct_add_new_member')) {
	function ct_add_new_member() {
		if (isset( $_POST["ct_user_login"] ) && wp_verify_nonce($_POST['ct_register_nonce'], 'ct-register-nonce')) {
			$user_login		= $_POST["ct_user_login"];
			$user_email		= $_POST["ct_user_email"];
			$user_first 	= $_POST["ct_user_first"];
			$user_last	 	= $_POST["ct_user_last"];
			$user_pass		= $_POST["ct_user_pass"];
			$pass_confirm 	= $_POST["ct_user_pass_confirm"];

			// this is required for username checks
			require_once(ABSPATH . WPINC . '/registration.php');

			if(username_exists($user_login)) {
				// Username already registered
				ct_errors()->add('username_unavailable', __('Username already taken', 'contempo'));
			}
			if(!validate_username($user_login)) {
				// invalid username
				ct_errors()->add('username_invalid', __('Invalid username', 'contempo'));
			}
			if($user_login == '') {
				// empty username
				ct_errors()->add('username_empty', __('Please enter a username', 'contempo'));
			}
			if(!is_email($user_email)) {
				//invalid email
				ct_errors()->add('email_invalid', __('Invalid email', 'contempo'));
			}
			if(email_exists($user_email)) {
				//Email address already registered
				ct_errors()->add('email_used', __('Email already registered', 'contempo'));
			}
			if($user_pass == '') {
				// passwords do not match
				ct_errors()->add('password_empty', __('Please enter a password', 'contempo'));
			}
			if($user_pass != $pass_confirm) {
				// passwords do not match
				ct_errors()->add('password_mismatch', __('Passwords do not match', 'contempo'));
			}

			$errors = ct_errors()->get_error_messages();

			// only create the user in if there are no errors
			if(empty($errors)) {

				$new_user_id = wp_insert_user(array(
						'user_login'		=> $user_login,
						'user_pass'	 		=> $user_pass,
						'user_email'		=> $user_email,
						'first_name'		=> $user_first,
						'last_name'			=> $user_last,
						'user_registered'	=> date('Y-m-d H:i:s'),
						'role'				=> 'contributor'
					)
				);
				if($new_user_id) {
					// send an email to the admin alerting them of the registration
					wp_new_user_notification($new_user_id);

					// log the new user in
					wp_setcookie($user_login, $user_pass, true);
					wp_set_current_user($new_user_id, $user_login);
					do_action('wp_login', $user_login);

					// send the newly created user to the home page after logging them in
					wp_redirect(home_url()); exit;
				}

			}

		}
	}
}
add_action('init', 'ct_add_new_member');

// Logs a member in after submitting a form
if(!function_exists('ct_login_member')) {
	function ct_login_member() {

		if(isset($_POST['ct_user_login']) && wp_verify_nonce($_POST['ct_login_nonce'], 'ct-login-nonce')) {

			// this returns the user ID and other info from the user name
			$user = get_userdatabylogin($_POST['ct_user_login']);

			if(!$user) {
				// if the user name doesn't exist
				ct_errors()->add('empty_username', __('Invalid username', 'contempo'));
			}

			if(!isset($_POST['ct_user_pass']) || $_POST['ct_user_pass'] == '') {
				// if no password was entered
				ct_errors()->add('empty_password', __('Please enter a password', 'contempo'));
			}

			// check the user's login with their password
			if(!wp_check_password($_POST['ct_user_pass'], $user->user_pass, $user->ID)) {
				// if the password is incorrect for the specified user
				ct_errors()->add('empty_password', __('Incorrect password', 'contempo'));
			}

			// retrieve all error messages
			$errors = ct_errors()->get_error_messages();

			// only log the user in if there are no errors
			if(empty($errors)) {

				wp_setcookie($_POST['ct_user_login'], $_POST['ct_user_pass'], true);
				wp_set_current_user($user->ID, $_POST['ct_user_login']);
				do_action('wp_login', $_POST['ct_user_login']);

				wp_redirect(home_url()); exit;
			}
		}
	}
}
add_action('init', 'ct_login_member');

if(!function_exists('ct_login_member_ajax')) {
	function ct_login_member_ajax() {

		if(isset($_POST['ct_user_login']) && wp_verify_nonce($_POST['ct_login_nonce'], 'ct-login-nonce')) {

			// this returns the user ID and other info from the user name
			$user = get_userdatabylogin($_POST['ct_user_login']);

			if(!$user) {
				// if the user name doesn't exist
				ct_errors()->add('empty_username', __('Invalid username', 'contempo'));
			}

			if(!isset($_POST['ct_user_pass']) || $_POST['ct_user_pass'] == '') {
				// if no password was entered
				ct_errors()->add('empty_password', __('Please enter a password', 'contempo'));
			}

			// check the user's login with their password
			if(!wp_check_password($_POST['ct_user_pass'], $user->user_pass, $user->ID)) {
				// if the password is incorrect for the specified user
				ct_errors()->add('empty_password', __('Incorrect password', 'contempo'));
			}

			// retrieve all error messages
			$errors = ct_errors()->get_error_messages();

			// only log the user in if there are no errors
			if(empty($errors)) {

				$creds = array();
				$creds['user_login'] = $_POST['ct_user_login'];
				$creds['user_password'] = $_POST['ct_user_pass'];
				$creds['remember'] = true;
				$user = wp_signon( $creds, false );

				wp_send_json(array('success'=>true, 'redirect'=>home_url()));
			} else {
				wp_send_json(array('success'=>false, 'errors'=>ct_get_errors()));
			}
		} else {
			wp_send_json(array('success'=>false, 'errors'=>array('Invalid session')));
		}
	}
}
add_action( 'wp_ajax_nopriv_ct_login_member_ajax', 'ct_login_member_ajax' );

// displays error messages from form submissions
if(!function_exists('ct_show_error_messages')) {
	function ct_show_error_messages() {
		if($codes = ct_errors()->get_error_codes()) {
			echo '<div class="ct_errors">';
			// Loop error codes and display errors
			foreach($codes as $code){
				$message = ct_errors()->get_error_message($code);
				echo '<span class="error"><strong>' . __('Error', 'contempo') . '</strong>: ' . $message . '</span><br/>';
			}
			echo '</div>';
		}
	}
}

if(!function_exists('ct_get_errors')) {
	function ct_get_errors() {
		$errors = array();
		if($codes = ct_errors()->get_error_codes()) {
			// Loop error codes and display errors
			foreach($codes as $code){
				$message = ct_errors()->get_error_message($code);
				array_push($errors, $message);
			}
		}
		return $errors;
	}
}

// used for tracking error messages
if(!function_exists('ct_errors')) {
	function ct_errors(){
		static $wp_error; // Will hold global variable safely
		return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
	}
}

/*-----------------------------------------------------------------------------------*/
/* WPML Flags */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_language_selector_flags')) {
	function ct_language_selector_flags(){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			echo '<ul>';
			foreach($languages as $l){
				echo '<li>';
				if(!$l['active']) echo '<a href="'.$l['url'].'">';
				echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
				if(!$l['active']) echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* WPML Lang */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_language_selector_lang')) {
	function ct_language_selector_lang(){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			echo '<ul>';
			foreach($languages as $l){
				echo '<li>';
				if(!$l['active']) echo '<a href="'.$l['url'].'">';
				echo $l['language_code'];
				if(!$l['active']) echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Remove CPTs from Blog Search */
/*-----------------------------------------------------------------------------------

if(!function_exists('ct_searchfilter')) {
	//if(!is_admin()) {
		function ct_searchfilter($query) {
			if ($query->is_search) {
				$query->set('post_type',array('post','page'));
			}
			return $query;
		}
	//}
}
add_filter('pre_get_posts','ct_searchfilter');

/*-----------------------------------------------------------------------------------*/
/* Deregister Visual Composer Flexslider CSS */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_remove_vc_styles')) {
	function ct_remove_vc_styles() {
		wp_deregister_style( 'flexslider' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_remove_vc_styles', 99 );

/*-----------------------------------------------------------------------------------*/
/* Deregister Mortgage Calc Plugin CSS */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_deregister_styles')) {
	function ct_deregister_styles() {
		wp_deregister_style( 'ct_mortgage_calc' );
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if(is_plugin_active('frontend-edit-profile/fep.php')) {
			wp_deregister_style( 'fep-forms-style' );
			wp_deregister_style( 'fep-forms-style' );
		}
	}
}
add_action( 'wp_print_styles', 'ct_deregister_styles', 100 );

/*-----------------------------------------------------------------------------------*/
/* Add user profile fields. */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_modify_contact_methods')) {
	function ct_modify_contact_methods($profile_fields) {

		// Add new fields
		$profile_fields['twitterhandle'] = 'Twitter Username';
		$profile_fields['facebookurl'] = 'Facebook URL';
		$profile_fields['linkedinurl'] = 'LinkedIn URL';
		$profile_fields['gplus'] = 'Google+ URL';

		return $profile_fields;
	}
}
add_filter('user_contactmethods', 'ct_modify_contact_methods');

/*-----------------------------------------------------------------------------------*/
/* Move Featured Image Meta Box To The Top */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_move_meta_box')) {
	function ct_move_meta_box() {
		remove_meta_box( 'postimagediv', 'listings', 'side' );
		add_meta_box('postimagediv', __('Featured Image', 'contempo'), 'post_thumbnail_meta_box', 'listings', 'side', 'high');
		remove_meta_box( 'postimagediv', 'Brokerages', 'side' );
		add_meta_box('postimagediv', __('Brokerage Logo', 'contempo'), 'post_thumbnail_meta_box', 'brokerage', 'side', 'high');
		remove_meta_box( 'postimagediv', 'testimonials', 'side' );
		add_meta_box('postimagediv', __('Featured Image', 'contempo'), 'post_thumbnail_meta_box', 'testimonials', 'side', 'high');
	}
}
add_action('do_meta_boxes', 'ct_move_meta_box');

/*-----------------------------------------------------------------------------------*/
/* Fix Pagination on Search Results */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_fix_query')) {
	function ct_fix_query($query) {
		global $paged;
		if( $query->is_main_query() && $query->is_home() ) {
			$query->set('post_type', array('post', 'listings'));
		}
	}
}
add_action('pre_get_posts', 'ct_fix_query');

/*-----------------------------------------------------------------------------------*/
/* Filter "Enter title here" with custom text */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_change_default_title')) {
	function ct_change_default_title( $title ){
		$screen = get_current_screen();

		if  ( 'listings' == $screen->post_type ) {
			$title = 'Enter the listing address here';
		}

		return $title;
	}
}
add_filter( 'enter_title_here', 'ct_change_default_title' );

/*-----------------------------------------------------------------------------------*/
/* Listing Title */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listing_title')) {
	function ct_listing_title() {
		global $post;
		global $ct_options;
		$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {

			$listing_alt_title = get_post_meta($post->ID, "_ct_listing_alt_title", true);
			$rental_title = get_post_meta($post->ID, "_ct_rental_title", true);

			if(!empty($listing_alt_title)) {
				echo esc_html($listing_alt_title);
			} elseif(!empty($rental_title)) {
				echo esc_html($rental_title);
			} else {
				the_title();
			}

		} else {

			$listing_alt_title = get_post_meta($post->ID, "_ct_listing_alt_title", true);

			if(!empty($listing_alt_title)) {
				echo esc_html($listing_alt_title);
			} else {
				the_title();
			}
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listing Permalink */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listing_permalink')) {
	function ct_listing_permalink() {
		global $ct_options;

		$ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? $ct_options['ct_listings_login_register'] : '';

		if($ct_listings_login_register == 'yes' && !is_user_logged_in()) {
			echo 'class="login-register"';
		} else {
			echo 'href="';
			the_permalink();
			echo '"';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Add meta_value_num parameter for User Query Orderby */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_pre_user_query')) {
	function ct_pre_user_query( &$query ) {
		global $wpdb;

		if ( isset( $query->query_vars['orderby'] ) && 'meta_value_num' == $query->query_vars['orderby'] )
			$query->query_orderby = str_replace( 'user_login', "$wpdb->usermeta.meta_value+0", $query->query_orderby );
	}
}
add_action( 'pre_user_query', 'ct_pre_user_query' );

/*-----------------------------------------------------------------------------------*/
/* Favorite Listings */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_fav_listing')) {
	function ct_fav_listing() {
		global $ct_options;
		$ct_fav_only_reg_users = isset( $ct_options['ct_fav_only_reg_users'] ) ? esc_html( $ct_options['ct_fav_only_reg_users'] ) : '';

		if (function_exists('wpfp_link')) {
			if($ct_fav_only_reg_users == 'yes') {
				if(is_user_logged_in()) {
					echo '<span class="save-this">';
					wpfp_link();
					echo '</span>';
				} else {
					echo '<span class="login-register save-this">';
					echo '<a href="#"><i class="fa fa-heart-o"></i></a>';
					echo '</span>';
				}
			} else {
				echo '<span class="save-this">';
				wpfp_link();
				echo '</span>';
			}
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Return Taxonomy */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_taxonomy_return')) {
	function ct_taxonomy_return($name){
		global $post;
		global $wp_query;
		$terms_as_text = strip_tags( get_the_term_list( $wp_query->post->ID, $name, '', ', ', '' ) );
		if($terms_as_text != '') {
			return esc_html($terms_as_text);
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Bath SVG Icon */
/*-----------------------------------------------------------------------------------*/

function ct_bath_icon() { ?>
	<svg class="muted" style="width: 25px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 viewBox="-240.6 138.8 142.1 107.1" enable-background="new -240.6 138.8 142.1 107.1" xml:space="preserve">
<g>
	<path fill="#878c92" d="M-121.3,188.2c0,0,0-17.3,0-33.6c0-16.3-17.8-14.6-17.8-14.6c-12.5,0-13.3,10.7-13.4,12.5
	c-9.2,3.7-8.7,11.5-8.7,11.5h24c0-7.3-5.5-10.1-7.6-11.1c1.5-4.9,4.6-4.6,4.6-4.6c0.3,0,1.3,0,4.6,0c5.7,0,6.5,6.5,6.5,6.5v33.5
	h-89.2c-3.8,0-3.7,3.7-3.7,3.7s0,0.5,0,4.3c0,3.7,4.1,4.1,4.1,4.1s0.2,1.1,0.2,14.3c0,13.2,12.2,16.5,15.8,17.6
	c0.2,4.3-3.3,4.7-3.3,4.7c-4.2-0.1-4.6,2.5-4.6,3.7c0.2,3.7,3.3,4.1,3.3,4.1h2.1c9.9,0,10.3-11.9,10.3-11.9s39.6,0,49.1,0
	c1.8,11.7,10.1,12.1,11.3,12.1c1.2,0,4.6-0.6,4.6-4.2c0-3.6-3.3-3.7-4.6-3.7c-2.3-0.3-3.3-3.5-3.5-4.9
	c16.9-4.1,16.2-17.5,16.2-17.5v-14.3c3.8,0,4.1-3.7,4.1-3.7s0-0.4,0-4.2S-121.3,188.2-121.3,188.2z M-140.3,224.7
	c-11.2,0-57.8,0-57.8,0S-210,224.8-210,213s0-12.5,0-12.5h80.6v13.3C-129.3,213.8-129.2,224.7-140.3,224.7z"/>
	<circle fill="#878c92" cx="-157.8" cy="168.4" r="2.2"/>
	<circle fill="#878c92" cx="-159.6" cy="176.1" r="2.6"/>
	<circle fill="#878c92" cx="-161.5" cy="183.6" r="2.8"/>
	<circle fill="#878c92" cx="-141.1" cy="168.4" r="2.2"/>
	<circle fill="#878c92" cx="-149.4" cy="168.4" r="2.2"/>
	<circle fill="#878c92" cx="-139.2" cy="176.1" r="2.6"/>
	<circle fill="#878c92" cx="-149.5" cy="176.1" r="2.6"/>
	<circle fill="#878c92" cx="-137.3" cy="183.6" r="2.8"/>
	<circle fill="#878c92" cx="-149.2" cy="183.6" r="2.8"/>
</g>
</svg>
<?php }

/*-----------------------------------------------------------------------------------*/
/* Land SVG Icon */
/*-----------------------------------------------------------------------------------*/

function ct_listing_size_icon() { ?>
	<svg class="muted" style="width: 17px;" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
	<style type="text/css">
		.st0{fill:#878C92;stroke:#878C92;stroke-width:36;stroke-miterlimit:10;}
	</style>
		<path class="st0" d="M492.1,10H19.9c-5.5,0-9.9,4.4-9.9,9.9v472.2c0,5.5,4.4,9.9,9.9,9.9h288c5.5,0,9.9-4.4,9.9-9.9
	s-4.4-9.9-9.9-9.9H29.8V251.8h137.9v94.8c0,5.5,4.4,9.9,9.9,9.9c5.5,0,9.9-4.4,9.9-9.9v-207c0-5.5-4.4-9.9-9.9-9.9
	c-5.5,0-9.9,4.4-9.9,9.9V232H29.8V29.8H298v123.8c0,5.5,4.4,9.9,9.9,9.9h104.5c5.5,0,9.9-4.4,9.9-9.9s-4.4-9.9-9.9-9.9h-94.7V29.8
	h164.4v306.9H307.9c-5.5,0-9.9,4.4-9.9,9.9s4.4,9.9,9.9,9.9h174.3v125.8h-69.8c-5.5,0-9.9,4.4-9.9,9.9s4.4,9.9,9.9,9.9h79.7
	c5.5,0,9.9-4.4,9.9-9.9V19.9C502,14.4,497.6,10,492.1,10z"/>
</svg>
<?php }

/*-----------------------------------------------------------------------------------*/
/* Listing Property Info */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_propinfo')) {
	function ct_propinfo() {
		global $post;
		global $wp_query;
		global $ct_options;

		$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';

		$beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
		$baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );
		/*not themes code*/
		$purpose = get_post_meta( $wp_query->post->ID, '_ct_purpose',true) ;
		$parking = get_post_meta( $wp_query->post->ID, '_ct_parking',true) ;
		$view = get_post_meta( $wp_query->post->ID, '_ct_view',true ) ;
		/*not themes code*/

		/*city type area sub project sq ft*/
		$city = get_post_meta( $wp_query->post->ID, '_ct_city',true);
		$community = get_post_meta( $wp_query->post->ID, '_ct_community',true);
		$subcommunity = get_post_meta( $wp_query->post->ID, '_ct_sub_community',true);
		$building = get_post_meta( $wp_query->post->ID, '_ct_building',true);
		$type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
		$sqft = get_post_meta( $wp_query->post->ID, '_ct_sqft',true);
		/*city type area sub project sq ft*/

		$ct_walkscore = isset( $ct_options['ct_enable_walkscore'] ) ? esc_html( $ct_options['ct_enable_walkscore'] ) : '';
		$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
		$ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

		if($ct_walkscore == 'yes') {
			/* Walk Score */
			$latlong = get_post_meta($post->ID, "_ct_latlng", true);
			if($latlong != '') {
				list($lat, $long) = explode(',',$latlong,2);
				$address = get_the_title() . ct_taxonomy_return('city') . ct_taxonomy_return('state') . ct_taxonomy_return('zipcode');
				$json = ct_get_walkscore($lat,$long,$address);

				$ct_ws = json_decode($json);
			}
		}

		if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) {
			// Dont Display Bed/Bath
		} else {

			if(!empty($building[0])) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Building', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $building;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Building', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}
			/*city type area sub project sq ft*/
			/*if(!empty($city[0])) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('City', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $city;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('City', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}
			if(!empty($type)) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Type', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $type;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Type', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}*/
			if(!empty($community[0])) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Community', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $community;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Community', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}

			/*if(!empty($subcommunity[0])) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Sub Community', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $subcommunity;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Sub Community', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}*/
			if(!empty($sqft[0])) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Size Sq. ft', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $sqft;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Size Sq. ft', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}

			/*city type area sub project sq ft*/

			if(!empty($beds)) {
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Bed', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $beds;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row beds">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Bed', 'contempo');
				} else {
					echo '<i class="fa fa-bed"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}
			if(!empty($baths)) {
				echo '<li class="row baths">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Baths', 'contempo');
				} else {
					ct_bath_icon();
				}
				echo '</span>';
				echo '<span class="right">';
				echo $baths;
				echo '</span>';
				echo '</li>';
			}
			else{
				echo '<li class="row baths">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Baths', 'contempo');
				} else {
					ct_bath_icon();
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}
			/*not themes code*/
			/*if(!empty($parking)) {
                echo '<li class="row baths">';
                    echo '<span class="muted left">';
                        if($ct_use_propinfo_icons != 'icons') {
                            _e('Parking', 'contempo');
                        } else {
                            ct_bath_icon();
                        }
                    echo '</span>';
                    echo '<span class="right">';
                       echo $parking;
                    echo '</span>';
                echo '</li>';
            }
            if(!empty($purpose)) {
                echo '<li class="row baths">';
                echo '<span class="muted left">';
                if($ct_use_propinfo_icons != 'icons') {
                    _e('Purpose', 'contempo');
                } else {
                    ct_bath_icon();
                }
                echo '</span>';
                echo '<span class="right">';
                echo $purpose;
                echo '</span>';
                echo '</li>';
            }
            else{
                echo '<li class="row baths">';
                echo '<span class="muted left">';
                if($ct_use_propinfo_icons != 'icons') {
                    _e('Purpose', 'contempo');
                } else {
                    ct_bath_icon();
                }
                echo '</span>';
                echo '<span class="right">';
                echo 'N/A';
                echo '</span>';
                echo '</li>';
            }*/
			if(!empty($view)) {
				echo '<li class="row baths">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('View', 'contempo');
				} else {
					ct_bath_icon();
				}
				echo '</span>';
				echo '<span class="right">';
				echo $view;
				echo '</span>';
				echo '</li>';
			}else{
				echo '<li class="row baths">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('View', 'contempo');
				} else {
					ct_bath_icon();
				}
				echo '</span>';
				echo '<span class="right">';
				echo 'N/A';
				echo '</span>';
				echo '</li>';
			}
			/*not themes code*/

		}

		/*if($ct_walkscore == 'yes') {
			if(!empty($ct_ws->walkscore)) {
				echo '<li class="row walkscore">';
				echo '<span class="muted left">';
				_e('Walk Score&reg;', 'contempo');
				echo '</span>';
				echo '<span class="right">';
				echo '<a class="tooltips" href=" ' . $ct_ws->ws_link , '" target="_blank">';
				echo $ct_ws->walkscore;
				echo '<span>' . $ct_ws->description. '</span>';
				echo '</a>';
				echo '</span>';
				echo '</li>';
			}
		}*/

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		/*if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
			global $pixreviews_plugin;
			$ct_rating_avg = $pixreviews_plugin->get_average_rating();
			if($ct_rating_avg != '') {
				echo '<li class="row rating">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Rating', 'contempo');
				} else {
					echo '<i class="fa fa-star"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo $pixreviews_plugin->get_average_rating();
				echo '</span>';
				echo '</li>';
			}
		}*/

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		/*if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
			if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
				echo '<li class="row guests">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Guests', 'contempo');
				} else {
					echo '<i class="fa fa-group"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo get_post_meta($post->ID, "_ct_rental_guests", true);
				echo '</span>';
				echo '</li>';
			}

			if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
				echo '<li class="row min-stay">';
				echo '<span class="muted left">';
				if($ct_use_propinfo_icons != 'icons') {
					_e('Min Stay', 'contempo');
				} else {
					echo '<i class="fa fa-calendar"></i>';
				}
				echo '</span>';
				echo '<span class="right">';
				echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
				echo '</span>';
				echo '</li>';
			}
		}*/

		/*if(get_post_meta($post->ID, "_ct_sqft", true)) {
			if($ct_use_propinfo_icons != 'icons') {
				echo '<li class="row sqft">';
				echo '<span class="muted left">';
				ct_sqftsqm();
				echo '</span>';
				echo '<span class="right">';
				echo floor(get_post_meta($post->ID, "_ct_sqft", true))." sq.ft";
				echo '</span>';
				echo '</li>';
			} else {
				echo '<li class="row sqft">';
				echo '<span class="muted left">';
				ct_listing_size_icon();
				echo '</span>';
				echo '<span class="right">';
				echo floor(get_post_meta($post->ID, "_ct_sqft", true))." sq.ft";
				echo ' ' . ct_sqftsqm();
				echo '</span>';
				echo '</li>';
			}
		}*/

		/*if(get_post_meta($post->ID, "_ct_lotsize", true)) {
			if(get_post_meta($post->ID, "_ct_lotsize", true)) {
				echo '<li class="row lotsize">';
			}
			echo '<span class="muted left">';
			if($ct_use_propinfo_icons != 'icons') {
				_e('Lot Size', 'contempo');
			} else {
				echo '<i class="fa fa-arrows-alt"></i>';
			}
			echo '</span>';
			echo '<span class="right">';
			echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
			ct_acres();
			echo '</span>';

			if((get_post_meta($post->ID, "_ct_lotsize", true))) {
				echo '</li>';
			}
		}*/
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listing Rental Info */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_rental_info')) {
	function ct_rental_info() {
		global $post;
		if(get_post_meta($post->ID, "_ct_rental_checkin", true)) {
			echo '<li class="row rental-checkin">';
			echo '<span class="muted left"><strong>';
			esc_html_e('Check In', 'contempo');
			echo '</strong></span>';
			echo '<span class="right">';
			$checkin = get_post_meta(get_the_ID(), '_ct_rental_checkin', true);
			echo date("g:i A", strtotime($checkin));
			echo '</span>';
			echo '</li>';
		}
		if(get_post_meta($post->ID, "_ct_rental_checkout", true)) {
			echo '<li class="row rental-checkout">';
			echo '<span class="muted left"><strong>';
			esc_html_e('Check Out', 'contempo');
			echo '</strong></span>';
			echo '<span class="right">';
			$checkout = get_post_meta(get_the_ID(), '_ct_rental_checkout', true);
			echo date("g:i A", strtotime($checkout));
			echo '</span>';
			echo '</li>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listing Rental Costs */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_rental_costs')) {
	function ct_rental_costs() {
		global $post;
		if((get_post_meta($post->ID, "_ct_rental_extra_people", true))) {
			echo '<li class="row rental-cancel">';
			echo '<span class="muted left">';
			esc_html_e('Extra People', 'contempo');
			echo '</span>';
			echo '<span class="right">';
			ct_currency();
			echo get_post_meta($post->ID, "_ct_rental_extra_people", true);
			echo '</span>';
			echo '</li>';
		}
		if((get_post_meta($post->ID, "_ct_rental_cleaning", true))) {
			echo '<li class="row cleaning-fee">';
			echo '<span class="muted left">';
			esc_html_e('Cleaning Fee', 'contempo');
			echo '</span>';
			echo '<span class="right">';
			ct_currency();
			echo get_post_meta($post->ID, "_ct_rental_cleaning", true);
			echo '</span>';
			echo '</li>';
		}
		if((get_post_meta($post->ID, "_ct_rental_cancellation", true))) {
			echo '<li class="row cleaning-fee">';
			echo '<span class="muted left">';
			esc_html_e('Cancellation Fee', 'contempo');
			echo '</span>';
			echo '<span class="right">';
			ct_currency();
			echo get_post_meta($post->ID, "_ct_rental_cancellation", true);
			echo '</span>';
			echo '</li>';
		}
		if((get_post_meta($post->ID, "_ct_rental_deposit", true))) {
			echo '<li class="row rental-deposit">';
			echo '<span class="muted left">';
			esc_html_e('Security Deposit', 'contempo');
			echo '</span>';
			echo '<span class="right">';
			ct_currency();
			echo get_post_meta($post->ID, "_ct_rental_deposit", true);
			echo '</span>';
			echo '</li>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Brokerage Address */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_brokerage_address')) {
	function ct_brokerage_address($postID) {

		global $post;

		$brokerage = new WP_Query(array(
			'post_type' => 'brokerage',
			'p' => $postID,
			'nopaging' => true
		));

		if ( $brokerage->have_posts() ) : while ( $brokerage->have_posts() ) : $brokerage->the_post();

			$ct_brokerage_street_address = get_post_meta($post->ID, "_ct_brokerage_street_address", true);
			$ct_brokerage_address_two = get_post_meta($post->ID, "_ct_brokerage_address_two", true);
			$ct_brokerage_city = get_post_meta($post->ID, "_ct_brokerage_city", true);
			$ct_brokerage_state = get_post_meta($post->ID, "_ct_brokerage_state", true);
			$ct_brokerage_zip = get_post_meta($post->ID, "_ct_brokerage_zip", true);
			$ct_brokerage_country = get_post_meta($post->ID, "_ct_brokerage_country", true);

			?>
			<?php
			if($ct_brokerage_street_address != '') {
				echo $ct_brokerage_street_address . ', ';
			}
			if($ct_brokerage_address_two != '') {
				echo $ct_brokerage_address_two . ', ';
			}
			if($ct_brokerage_city != '') {
				echo $ct_brokerage_city . ', ';
			}
			if($ct_brokerage_state != '') {
				echo $ct_brokerage_state . ', ';
			}
			if($ct_brokerage_zip != '') {
				echo $ct_brokerage_zip . ' ';
			}
			if($ct_brokerage_country != '') {
				echo $ct_brokerage_country;
			}
			?>
		<?php endwhile; endif; wp_reset_postdata();

	}
}

/*-----------------------------------------------------------------------------------*/
/* Broker Info */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_brokered_by')) {
	function ct_brokered_by() {
		global $ct_options, $post;
		$ct_listing_brokerage_name = isset( $ct_options['ct_listing_brokerage_name'] ) ? $ct_options['ct_listing_brokerage_name'] : '';
		$ct_user_meta_brokerage = get_the_author_meta( 'brokerage' );
		$ct_cpt_brokerage = get_post_meta( get_the_ID(), '_ct_brokerage', true );

		if($ct_listing_brokerage_name == 'yes' && $ct_cpt_brokerage != '') {

			$brokerage = new WP_Query(array(
				'post_type' => 'brokerage',
				'p' => $ct_cpt_brokerage,
				'nopaging' => true
			));

			if ( $brokerage->have_posts() ) : while ( $brokerage->have_posts() ) : $brokerage->the_post(); ?>
				<?php
				$ct_brokerage_permalink = get_permalink();
				$ct_brokerage_name = get_the_title();
				?>
			<?php endwhile; endif; wp_reset_postdata();

			?>

			<div class="brokerage">
				<p class="muted marB0"><small><?php _e('Brokered by', 'contempo'); ?></small></p>
				<p class="marB0"><a href="<?php echo $ct_brokerage_permalink; ?>"><?php echo $ct_brokerage_name; ?></a></p>
			</div>
		<?php } elseif($ct_listing_brokerage_name == 'yes' && $ct_user_meta_brokerage != '') { ?>
			<div class="brokerage">
				<p class="muted marB0"><small><?php _e('Brokered by', 'contempo'); ?></small></p>
				<p class="marB0"><?php the_author_meta( 'brokerage' ); ?></p>
			</div>
		<?php }
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display Brokerage Logo */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_brokerage_logo')) {
	function ct_brokerage_logo($postID) {

		$brokerage = new WP_Query(array(
			'post_type' => 'brokerage',
			'p' => $postID,
			'nopaging' => true
		));

		if ( $brokerage->have_posts() ) : while ( $brokerage->have_posts() ) : $brokerage->the_post(); ?>
			<?php if(has_post_thumbnail()) {
				the_post_thumbnail('thumb');
			} ?>
		<?php endwhile; endif; wp_reset_postdata();

	}
}

/*-----------------------------------------------------------------------------------*/
/* Status Snipes */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_has_status')) {
	function ct_has_status( $status, $_post = null ) {
		if ( empty( $status ) )
			return false;

		if ( $_post )
			$_post = get_post( $_post );
		else
			$_post =& $GLOBALS['post'];

		if ( !$_post )
			return false;

		$r = is_object_in_term( $_post->ID, 'ct_status', $status );

		if ( is_wp_error( $r ) )
			return false;

		return $r;
	}
}

if(!function_exists('ct_status_slug')) {
	function ct_status_slug() {

		global $post;
		global $wp_query;

		$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );

		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
			foreach ( $status_terms as $term ) {
				echo esc_html($term->slug) . ' ';
			}
		}
	}
}

if(!function_exists('ct_status')) {
	function ct_status() {

		global $post;
		global $wp_query;

		$status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
		if($status_tags != '') {
			/*echo '<h6 class="snipe ';
            ct_status_slug();
            echo '">';*/
			echo '<span class="listpurpose ';
			ct_status_slug();
			echo '">';
			echo esc_html($status_tags);
			echo '</span>';
			/*echo '</h6>';*/
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Property Type Icon */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_property_type_icon')) {
	function ct_property_type_icon() {
		global $post;

		if(ct_has_type('commercial')) {
			echo '<span class="prop-type-icon"><i class="fa fa-building-o"></i></span>';
		} elseif(ct_has_type('land')) {
			echo '<span class="prop-type-icon"><i class="fa fa-tree"></i></span>';
		} else {
			echo '<span class="prop-type-icon"><i class="fa fa-home"></i></span>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* ct_currency */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_currency')) {
	function ct_currency() {
		global $ct_options;
		if($ct_options['ct_currency']) {
			echo esc_html($ct_options['ct_currency']);
		} else {
			echo "$";
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Listing Price */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listing_price')) {
	function ct_listing_price() {
		global $post;
		global $ct_options;

		$ct_currency_placement = $ct_options['ct_currency_placement'];

		$price_prefix = get_post_meta(get_the_ID(), '_ct_price_prefix', true);
		$price_postfix = get_post_meta(get_the_ID(), '_ct_price_postfix', true);

		$price_meta = get_post_meta(get_the_ID(), '_ct_price', true);
		$price_meta= preg_replace('/[\$,]/', '', $price_meta);

		if($ct_currency_placement == 'after') {
			if(!empty($price_prefix)) {
				echo esc_html($price_prefix) . ' ';
			}
			if(!empty($price_meta)) {
				echo "<span class='listing-price'> ";
				echo number_format_i18n($price_meta, 0);
				ct_currency();
				echo '</span>';
			}
			if(!empty($price_postfix)) {
				echo  ' ' . esc_html($price_postfix) . ' ';
			}
		} else {
			if(!empty($price_prefix)) {
				echo esc_html($price_prefix) . ' ';
			}
			if(!empty($price_meta)) {
				echo "<span class='listing-price'>";
				ct_currency();
				echo number_format_i18n($price_meta, 0);
				echo '</span>';
			}
			if(!empty($price_postfix)) {
				echo  ' ' . esc_html($price_postfix);
			}
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Sq Ft or Sq Meters */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_sqftsqm')) {
	function ct_sqftsqm() {
		global $ct_options;
		if($ct_options['ct_sq'] == "sqft") {
			return esc_html_e(' Size', 'contempo');
		} elseif($ct_options['ct_sq'] == "sqmeters") {
			return _e(' m²', 'contempo');
		} elseif($ct_options['ct_sq'] == "area") {
			return esc_html_e('Area', 'contempo');
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Acres or Sq Meters */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_acres')) {
	function ct_acres() {
		global $ct_options;
		if($ct_options['ct_acres'] == "acres") {
			return esc_html_e('Acres', 'contempo');
		} elseif($ct_options['ct_acres'] == "sqft") {
			return esc_html_e('Sq Ft', 'contempo');
		} elseif($ct_options['ct_acres'] == "sqmeters") {
			return esc_html_e('m²', 'contempo');
		} elseif($ct_options['ct_acres'] == "area") {
			return esc_html_e('Area', 'contempo');
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Zip or Postcode */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_zip_or_post')) {
	function ct_zip_or_post() {
		global $ct_options;
		$ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? esc_html( $ct_options['ct_zip_or_post'] ) : '';
		echo esc_html(ucfirst($ct_zip_or_post));
	}
}

/*-----------------------------------------------------------------------------------*/
/* Community, Neighborhood or District */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_community_neighborhood_or_district')) {
	function ct_community_neighborhood_or_district() {
		global $ct_options;
		$ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? esc_html( $ct_options['ct_community_neighborhood_or_district'] ) : '';
		echo esc_html(ucfirst($ct_community_neighborhood_or_district));
	}
}

/*-----------------------------------------------------------------------------------*/
/* Property Type Tags */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_has_type')) {
	function ct_has_type( $type, $_post = null ) {
		if ( empty( $type ) )
			return false;

		if ( $_post )
			$_post = get_post( $_post );
		else
			$_post =& $GLOBALS['post'];

		if ( !$_post )
			return false;

		$r = is_object_in_term( $_post->ID, 'property_type', $type );

		if ( is_wp_error( $r ) )
			return false;

		return $r;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Order Beds by Number */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('beds_terms_order_as_number')) {
	function beds_terms_order_as_number($order_by, $args, $taxonomies){

		$taxonomy_to_sort = "beds";

		if(in_array($taxonomy_to_sort, $taxonomies)){
			$order_by .=  " * 1";
		}

		return $order_by;
	}
}
add_filter( 'get_terms_orderby', 'beds_terms_order_as_number', 10,  3);

/*-----------------------------------------------------------------------------------*/
/* Order Baths by Number */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('baths_terms_order_as_number')) {
	function baths_terms_order_as_number($order_by, $args, $taxonomies){

		$taxonomy_to_sort = "baths";

		if(in_array($taxonomy_to_sort, $taxonomies)){
			$order_by .=  " * 1";
		}

		return $order_by;
	}
}
add_filter( 'get_terms_orderby', 'baths_terms_order_as_number', 10,  3);

/*-----------------------------------------------------------------------------------*/
/* Advanced Search Select */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_search_form_select')) {
	function ct_search_form_select($name, $taxonomy_name = null) {
		global $search_values;
		global $ct_options;

		$ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';
		$ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';
		$ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

		if(!$taxonomy_name) {
			$taxonomy_name = $name;
			$tax_label = str_replace('_', ' ', $name);
			$tax_name_stripped = str_replace('ct ', '', $tax_label);

			if($tax_name_stripped == 'property type') {
				$tax_name = __('Property Type', 'contempo');
			} elseif($tax_name_stripped == 'country') {
				$tax_name = __('Community', 'contempo');
				// $tax_name = __('Country', 'contempo');
			} elseif($tax_name_stripped == 'city') {
				$tax_name = __('City', 'contempo');
			} elseif($tax_name_stripped == 'state' && $ct_state_or_area == 'area') {
				$tax_name = __('Area', 'contempo');
			} elseif($tax_name_stripped == 'state' && $ct_state_or_area == 'suburb') {
				$tax_name = __('Suburb', 'contempo');
			} elseif($tax_name_stripped == 'state' && $ct_state_or_area == 'province') {
				$tax_name = __('Province', 'contempo');
			} elseif($tax_name_stripped == 'state') {
				$tax_name = __('Subcommunity', 'contempo');
				// $tax_name = __('State', 'contempo');
			} elseif($tax_name_stripped == 'beds') {
				$tax_name = __('Beds', 'contempo');
			} elseif($tax_name_stripped == 'baths') {
				$tax_name = __('Baths', 'contempo');
			} elseif($tax_name_stripped == 'status') {
				$tax_name = __('Status', 'contempo');
			} elseif($tax_name_stripped == 'additional features') {
				$tax_name = __('Additional Features', 'contempo');
			} elseif($tax_name_stripped == 'community' && $ct_community_neighborhood_or_district == 'neighborhood') {
				$tax_name = __('Neighborhood', 'contempo');
			} elseif($tax_name_stripped == 'community' && $ct_community_neighborhood_or_district == 'district') {
				$tax_name = __('District', 'contempo');
			} elseif($tax_name_stripped == 'community' && $ct_community_neighborhood_or_district == 'suburb') {
				$tax_name = __('Suburb', 'contempo');
			} elseif($tax_name_stripped == 'community' && $ct_community_neighborhood_or_district == 'building') {
				$tax_name = __('Building', 'contempo');
			} elseif($tax_name_stripped == 'community') {
				$tax_name = __('Community', 'contempo');
			} elseif($tax_name_stripped == 'zipcode' && $ct_zip_or_post == 'postcode') {
				$tax_name = __('Postcode', 'contempo');
			} elseif($tax_name_stripped == 'zipcode' && $ct_zip_or_post == 'postalcode') {
				$tax_name = __('Postal Code', 'contempo');
			} elseif($tax_name_stripped == 'zipcode') {
				$tax_name = __('Zipcode', 'contempo');
			} elseif($tax_name_stripped == 'pet friendly') {
				$tax_name = __('Pet Friendly?', 'contempo');
			} elseif($tax_name_stripped == 'furnished unfurnished') {
				$tax_name = __('Furnished/Unfurnished?', 'contempo');
			}
		}
		?>
		<select id="ct_<?php echo esc_html($name); ?>" name="ct_<?php echo esc_html($name); ?>">
			<option value="0"><?php echo esc_html(ucfirst($tax_name)); ?></option>
			<?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
				<?php if ($search_values[$name] == $t->slug) { $selected = 'selected=selected '; } else { $selected = ''; } ?>
				<option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html(ucwords(strtolower($t->name))); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Advanced Search Checkboxes - Header */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_search_form_checkboxes_header')) {
	function ct_search_form_checkboxes_header($name, $taxonomy_name = null) {
		global $search_values;
		global $ct_options;

		if(!$taxonomy_name) {
			$taxonomy_name = $name;
		}
		?>
		<ul class="check-list">
			<?php $count = 0; foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
				<?php if ($search_values[$name] == $t->slug) { $checked = 'checked'; } else { $checked = ''; } ?>
				<li class="col span_3 <?php if($count % 4 == 0) { echo 'first'; } ?>">
					<input type="checkbox" id="ct_<?php echo esc_html($name); ?>" name="ct_<?php echo esc_html($name); ?>" value="<?php echo esc_attr($t->slug); ?>" <?php echo esc_html($checked); ?>><span><?php echo esc_html($t->name); ?></span>
				</li>
				<?php
				$count++;

				if($count % 4 == 0) {
					echo '<div class="clear"></div>';
				} ?>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Advanced Search Checkboxes */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_search_form_checkboxes')) {
	function ct_search_form_checkboxes($name, $taxonomy_name = null) {
		global $search_values;
		global $ct_options;

		if(!$taxonomy_name) {
			$taxonomy_name = $name;
		}
		?>
		<ul class="check-list">
			<?php $count = 0; foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
				<?php if ($search_values[$name] == $t->slug) { $checked = 'checked'; } else { $checked = ''; } ?>
				<li class="col span_4 <?php if($count % 3 == 0) { echo 'first'; } ?>">
					<input type="checkbox" id="ct_<?php echo esc_html($name); ?>" name="ct_<?php echo esc_html($name); ?>" value="<?php echo esc_attr($t->slug); ?>" <?php echo esc_html($checked); ?>><span><?php echo esc_html($t->name); ?></span>
				</li>
				<?php
				$count++;

				if($count % 3 == 0) {
					echo '<div class="clear"></div>';
				} ?>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Edit Listings Select */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_edit_listing_form_select')) {
	function ct_edit_listing_form_select($name, $taxonomy_name = null) {
		global $search_values;

		if(!$taxonomy_name) {
			$taxonomy_name = $name;
		}
		?>
		<select id="ct_<?php echo esc_html($name); ?>" name="ct_<?php echo esc_html($name); ?>">
			<option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
			<?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
				<?php if ($ct_property_type == $t->slug) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
				<option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Submit Listings Select */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_submit_listing_form_select')) {
	function ct_submit_listing_form_select($name, $taxonomy_name = null) {
		global $search_values;

		$ct_property_type = '';

		if(!$taxonomy_name) {
			$taxonomy_name = $name;
		}
		?>
		<select id="ct_<?php echo esc_html($name); ?>" name="ct_<?php echo esc_html($name); ?>">
			<option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
			<?php foreach( get_terms($taxonomy_name, 'hide_empty=0') as $t ) : ?>
				<?php if ($ct_property_type == $t->slug) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
				<option <?php echo esc_html($selected); ?> value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Yelp API */
/*-----------------------------------------------------------------------------------*/

// Globals
$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = '';
$DEFAULT_LOCATION = '';
$SEARCH_LIMIT = 3;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';

/**
 * Makes a request to the Yelp API and returns the response
 *
 * @param    $host    The domain host of the API
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request
 */
function request($host, $path) {

	global $ct_options;

	$ct_yelp_consumer_key = isset($ct_options['ct_yelp_consumer_key'] ) ? esc_html( $ct_options['ct_yelp_consumer_key'] ) : '';
	$ct_yelp_consumer_secret_key = isset($ct_options['ct_yelp_consumer_secret_key'] ) ? $ct_options['ct_yelp_consumer_secret_key'] : '';
	$ct_yelp_token_key = isset($ct_options['ct_yelp_token_key'] ) ? $ct_options['ct_yelp_token_key'] : '';
	$ct_yelp_token_secret_key = isset($ct_options['ct_yelp_token_secret_key'] ) ? $ct_options['ct_yelp_token_secret_key'] : '';

	$unsigned_url = "https://" . $host . $path;
	// Token object built using the OAuth library
	$token = new OAuthToken($ct_yelp_token_key, $ct_yelp_token_secret_key);
	// Consumer object built using the OAuth library
	$consumer = new OAuthConsumer($ct_yelp_consumer_key, $ct_yelp_consumer_secret_key);
	// Yelp uses HMAC SHA1 encoding
	$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
	$oauthrequest = OAuthRequest::from_consumer_and_token(
		$consumer,
		$token,
		'GET',
		$unsigned_url
	);

	// Sign the request
	$oauthrequest->sign_request($signature_method, $consumer, $token);

	// Get the signed URL
	$signed_url = $oauthrequest->to_url();

	// Send Yelp API Call
	try {
		$ch = curl_init($signed_url);
		if (FALSE === $ch)
			throw new Exception('Failed to initialize');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		if (FALSE === $data)
			throw new Exception(curl_error($ch), curl_errno($ch));
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (200 != $http_status)
			throw new Exception($data, $http_status);
		curl_close($ch);
	} catch(Exception $e) {
		trigger_error(sprintf(
			'Curl failed with error #%d: %s',
			$e->getCode(), $e->getMessage()),
			E_USER_ERROR);
	}

	return $data;
}

/**
 * Query the Search API by a search term and location
 *
 * @param    $term        The search term passed to the API
 * @param    $location    The search location passed to the API
 * @return   The JSON response from the request
 */
function ct_yelp_search($term, $location) {
	global $ct_options;

	$ct_yelp_limit = isset($ct_options['ct_yelp_limit'] ) ? esc_html( $ct_options['ct_yelp_limit'] ) : '';
	$ct_yelp_cc = isset($ct_options['ct_yelp_cc'] ) ? esc_html( $ct_options['ct_yelp_cc'] ) : '';

	$url_params = array();

	$url_params['term'] = $term;
	$url_params['cc'] = $ct_yelp_cc;
	$url_params['location'] = $location;
	if($ct_yelp_limit !=''){
		$url_params['limit'] = $ct_yelp_limit;
	} else {
		$url_params['limit'] = 3;
	}
	$search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

	return request($GLOBALS['API_HOST'], $search_path);
}
/**
 * Query the Business API by business_id
 *
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request
 */
function ct_get_yelp_business($business_id) {
	$business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);

	return request($GLOBALS['API_HOST'], $business_path);
}
/**
 * Queries the API by the input values from the user
 *
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function ct_query_yelp_api($term, $location,$fontawesome_class) {

	global $ct_options;

	$ct_yelp_miles_kilometers = isset($ct_options['ct_yelp_miles_kilometers'] ) ? esc_html( $ct_options['ct_yelp_miles_kilometers'] ) : '';
	$ct_yelp_links = isset($ct_options['ct_yelp_links'] ) ? esc_html( $ct_options['ct_yelp_links'] ) : '';
	$ct_yelp_cc = isset($ct_options['ct_yelp_cc'] ) ? esc_html( $ct_options['ct_yelp_cc'] ) : '';

	$response = json_decode(ct_yelp_search($term, $location));

	if($response != '') {
		echo '<ul class="marB20 yelp-nearby">';
		$i = 0;
		foreach($response->businesses as $business) {

			$business_distance_meters = $response->businesses[$i]->distance;

			if($ct_yelp_miles_kilometers == 'kilometers') {
				$business_distance_miles = $business_distance_meters*0.001;
			} else {
				$business_distance_miles = $business_distance_meters*0.000621371192;
			}

			echo '<li>';
			echo '<i class="fa ' . $fontawesome_class . '"></i> <a href="' . $response->businesses[$i]->url . '" target="' . $ct_yelp_links . '">' . $response->businesses[$i]->name . ' <span class="business-distance muted">(' . round($business_distance_miles, 2);
			if($ct_yelp_miles_kilometers == 'km') {
				_e(' km', 'contempo');
			} else {
				_e(' mi', 'contempo');
			}
			echo ')</span><span class="right"><img src="' . $response->businesses[$i]->rating_img_url_small . '" /></span></a>';
			echo '</li>';
			$i++;
		}
		echo '</ul>';
	}
}

function ct_yelp_api_output($term, $location) {
	$longopts  = array(
		"term::",
		"location::",
	);

	$options = getopt("", $longopts);
	$term = $options['term'];
	$location = $options['location'];
	ct_query_yelp_api($term, $location);
}

/*-----------------------------------------------------------------------------------*/
/* Walk Score */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_walkscore')) {
	function ct_get_walkscore($lat, $lon, $address) {
		global $ct_options;
		$ct_walkscore_api_key = isset( $ct_options['ct_walkscore_apikey'] ) ? esc_html( $ct_options['ct_walkscore_apikey'] ) : '';

		$address = urlencode($address);
		$url = "http://api.walkscore.com/score?format=json&address=$address";
		$url .= "&lat=$lat&lon=$lon&wsapikey=$ct_walkscore_api_key";
		$str = @file_get_contents($url);
		return $str;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Numeric Pagination */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_numeric_pagination')) {
	function ct_numeric_pagination() {

		if( is_singular() )
			return;

		global $wp_query;

		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 )
			return;

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );

		/**	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;

		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="pagination"><ul>' . "\n";

		/**	Previous Post Link */
		if ( get_previous_posts_link() )
			printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

		/**	Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="current"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) )
				echo '<li>…</li>';
		}

		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="current"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/**	Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				echo '<li>…</li>' . "\n";

			$class = $paged == $max ? ' class="current"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/**	Next Post Link */
		if ( get_next_posts_link() )
			printf( '<li id="next-page-link">%s</li>' . "\n", get_next_posts_link() );
		echo '<div class="clear"></div>';
		echo '</ul></div>' . "\n";

	}
}

/*-----------------------------------------------------------------------------------*/
/* Pagination */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_pagination')) {
	function ct_pagination($pages = '', $range = 2) {
		$showitems = ($range * 2)+1;

		global $paged;
		if(empty($paged)) $paged = 1;

		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		if(1 != $pages) {
			echo "<div class='pagination'>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
				}
			}

			if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			echo "<div class='clear'></div>\n";
			echo "</div>\n";
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get the Slug */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_the_slug')) {
	function ct_the_slug() {
		$post_data = get_post($post->ID, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Get image ID from URL
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_attachment_id_from_src')) {
	function ct_get_attachment_id_from_src($image_src) {
		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var($query);
		return $id;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Read More Link */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_read_more_link')) {
	function ct_read_more_link() {
		global $ct_options;
		$ct_read_more = $ct_options['ct_read_more']; ?>
		<a class="read-more right" href="<?php the_permalink(); ?>'">
			<?php if($ct_read_more) {
				echo esc_html($ct_read_more);
			} else {
				echo "Read more <em>&rarr;</em>";
			} ?>
		</a>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Custom Author */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_author')) {
	function ct_author() {
		global $post;
		if(get_post_meta($post->ID, "_ct_custom_author", true)) {
			echo get_post_meta($post->ID, "_ct_custom_author", true);
		} else {
			the_author_meta('display_name');
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Archive & Search Header */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_archive_header')) {
	function ct_archive_header() {

		global $post;

		if ( is_category() ) :
			single_cat_title();

		elseif(is_home() || is_front_page() ) :
			_e('Home', 'contempo');
		elseif(is_search() ) :
			printf( __( 'Search Results for: %s', '_s' ), '<span>' . get_search_query() . '</span>' );

		elseif ( is_tag() ) :
			single_tag_title();

		elseif ( is_author() ) :
			printf( __( 'Author: %s', '_s' ), '<span class="vcard">' . get_the_author() . '</span>' );

		elseif ( is_day() ) :
			printf( __( 'Day: %s', '_s' ), '<span>' . get_the_date() . '</span>' );

		elseif ( is_month() ) :
			printf( __( 'Month: %s', '_s' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', '_s' ) ) . '</span>' );

		elseif ( is_year() ) :
			printf( __( 'Year: %s', '_s' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', '_s' ) ) . '</span>' );

		else :
			_e('Archives', 'contempo');

		endif;

	}
}

/*-----------------------------------------------------------------------------------*/
/* Add Categories to Attachments */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_add_categories_to_attachments')) {
	function ct_add_categories_to_attachments() {
		register_taxonomy_for_object_type( 'category', 'attachment' );
	}
}
add_action( 'init' , 'ct_add_categories_to_attachments' );

/*-----------------------------------------------------------------------------------*/
/* Display Featured Category Image */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_display_category_image')) {
	function ct_display_category_image() {

		global $post;
		global $wp_query;

		$args = null;

		if(is_archive()) {
			$currentcat = get_queried_object();
			$currentcatname = $currentcat->slug;

			$args = array(
				'post_type' => 'attachment',
				'post_status'=>'inherit',
				'category_name' => $currentcatname,
			);
		} elseif(is_search()) {
			$args = array(
				'post_type' => 'attachment',
				'post_status'=>'inherit'
			);
		}
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();

			echo'<style type="text/css">';
			echo '#archive-header { background: url(';
			echo wp_get_attachment_url( $post->ID, 'large' );
			echo ') no-repeat center center; background-size: cover;}';
			echo '</style>';

		endwhile;

		wp_reset_postdata();
	}
}

/*-----------------------------------------------------------------------------------*/
/* Post Social */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_post_social')) {
	function ct_post_social() { ?>

		<div class="col span_12 first post-social">
			<h6><?php esc_html_e('Share This', 'contempo'); ?></h6>

			<ul class="social">
				<li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great article on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php the_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
				<li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great article on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php the_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
				<li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great article on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php the_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
				<li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
			</ul>
		</div>
		<div class="clear"></div>

	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Post Tags */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_post_tags')) {
	function ct_post_tags() {
		if(get_the_tag_list()) {
			echo get_the_tag_list('<ul class="tags"><li><i class="fa fa-tag"></i></li><li>',',</li><li> ','</li></ul>');
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Author Info */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_author_info')) {
	function ct_author_info() {

		global $ct_options;

		$ct_author_img = isset( $ct_options['ct_author_img'] ) ? $ct_options['ct_author_img'] : '';
		$facebookurl = get_the_author_meta('facebookurl');
		$twitterhandle = get_the_author_meta('twitterhandle');
		$linkedinurl = get_the_author_meta('linkedinurl');
		$gplus = get_the_author_meta('gplus');

		?>

		<div id="authorinfo">
			<?php if($ct_author_img == 'yes') { ?>
				<h5 class="marB30"><?php esc_html_e('About The Author', 'contempo'); ?></h5>
				<div class="col span_3 first">
					<?php if(get_the_author_meta('ct_profile_url')) {
						echo '<a href="';
						echo site_url() . '/?author=';
						echo the_author_meta('ID');
						echo '">';
						echo '<img class="authorimg" src="';
						echo aq_resize(the_author_meta('ct_profile_url'),80);
						echo '" />';
						echo '</a>';
					} else {
						echo '<a href="';
						echo site_url() . '/?author=';
						echo the_author_meta('ID');
						echo '">';
						echo get_avatar( get_the_author_meta('email'), '80' );
						echo '</a>';
					} ?>
				</div>
			<?php } ?>

			<div class="col <?php if($ct_author_img == 'yes') { echo 'span_9'; } else { echo 'span_12 first'; } ?>">
				<div class="author-inner <?php if($ct_author_img == 'no') { echo 'pad0'; } ?>">
					<h5 class="the-author marB10"><a href="<?php the_author_meta('url'); ?>"><?php the_author(); ?></a></h5>
					<p><?php the_author_meta('description'); ?></p>
					<ul class="social">
						<?php if($facebookurl != '') { ?>
							<li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>"><i class="fa fa-facebook"></i></a></li>
						<?php } ?>
						<?php if($twitterhandle != '') { ?>
							<li class="twitter"><a href="http://twitter.com/<?php echo esc_url($twitterhandle); ?>"><i class="fa fa-twitter"></i></a></li>
						<?php } ?>
						<?php if($linkedinurl != '') { ?>
							<li class="linkedin"><a href="<?php echo esc_url($linkedinurl); ?>"><i class="fa fa-linkedin"></i></a></li>
						<?php } ?>
						<?php if($gplus != '') { ?>
							<li class="google"><a href="<?php echo esc_url($gplus); ?>"><i class="fa fa-google-plus"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>

	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Related Posts */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_related_posts')) {
	function ct_related_posts() {
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			echo '<h5 class="related-title marT40">' . __('Related Posts', 'contempo') . '</h5>';
			echo '<ul class="related">';
			$first_tag = $tags[0]->term_id;
			$args=array(
				'tag__in' => array($first_tag),
				'post__not_in' => array($post->ID),
				'showposts'=>3,
				'ignore_sticky_posts'=>1
			);
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post(); ?>

					<li class="col span_4">
						<figure>
							<a href="<?php the_permalink() ?>">
								<?php the_post_thumbnail(); ?>
							</a>
						</figure>
						<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h6>
						<?php ct_custom_length_excerpt(12); ?>
					</li>

					<?php
				endwhile; wp_reset_query();
			}
			echo '</ul>';
			echo '<div class="clear"></div>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Custom Length Excerpt */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_custom_length_excerpt')) {
	function ct_custom_length_excerpt($word_count_limit) {
		echo '<p>' . wp_trim_words(get_the_content(), $word_count_limit) . '</p>';
	}
}

/*-----------------------------------------------------------------------------------*/
/* Content Navigation */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_content_nav')) {
	function ct_content_nav() { ?>
		<div class="clear"></div>
		<nav class="content-nav">
			<div class="nav-prev left"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older', 'contempo' ) ); ?></div>
			<div class="nav-next right"><?php previous_posts_link( __( 'Newer <span class="meta-nav">&rarr;</span>', 'contempo' ) ); ?></div>
		</nav>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Post Navigation */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_post_nav')) {
	function ct_post_nav() { ?>
		<nav class="post-nav">
			<div class="nav-prev left"><?php next_post_link('%link', '<i class="fa fa-chevron-left"></i> %title'); ?></div>
			<div class="nav-next right"><?php previous_post_link('%link', '%title <i class="fa fa-chevron-right"></i>'); ?></div>
			<div class="clear"></div>
		</nav>
		<div class="clear"></div>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Allow Shortcodes to be used in widgets */
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/* Get the Attachment MIME Type */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_mime_for_attachment')) {
	function ct_get_mime_for_attachment( $attID ) {
		global $wp_query;

		$type = get_post_mime_type( $attID );

		if( ! $type )
			return '';

		switch( $type ) {

			case 'application/doc':
			case 'application/msword':
				return "word";

			case 'application/excel':
			case 'application/x-excel':
			case 'application/x-msexcel':
			case 'application/vnd.ms-excel':
				return "excel";

			case 'application/powerpoint':
			case 'application/mspowerpoint':
			case 'application/vnd.ms-powerpoint':
				return "powerpoint";

			case 'application/pdf':
				return "pdf";

			case 'application/zip':
				return "zip";

			default:
				return "text";
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Remove height & width from post thumbnails */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_remove_thumbnail_dimensions')) {
	function ct_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
}
add_filter( 'post_thumbnail_html', 'ct_remove_thumbnail_dimensions', 10, 3 );

/*-----------------------------------------------------------------------------------*/
/* Get all of the images attached to the current post */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_images')) {
	function ct_get_images($size = 'full') {
		global $post;
		$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
		$results = array();
		if ($photos) {
			foreach ($photos as $photo) {
				// get the correct image html for the selected size
				$results[$photo->ID] = wp_get_attachment_url($photo->ID);
			}
		}
		return $results;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images attached to post - detail */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_gallery_images')) {
	function ct_gallery_images() {
		$photos = ct_get_images('full');
		if ($photos) {
			foreach ($photos as $photo) { ?>
				<img class="marB18" src="<?php echo aq_resize($photo,945); ?>" />
			<?php }
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images attached to post - thumbs */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_gallery_images_thumb')) {
	function ct_gallery_images_thumb() {
		$photos = ct_get_images('full');
		if ($photos) {
			foreach ($photos as $photo) { ?>
				<figure class="col span_3 gallery-thumb">
					<img src="<?php echo aq_resize($photo,300); ?>" />
				</figure>
			<?php }
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display first image thumbnail - float right */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_tn_right')) {
	function ct_first_image_tn_right() {
		global $post;
		if(has_post_thumbnail()) { ?>
			<div class="tn">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail(69,40); ?>
				</a>
			</div>
		<?php }
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get the first image attached to the current post */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_post_image')) {
	function ct_get_post_image() {
		global $post;
		$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID'));
		if ($photos) {
			$photo = array_shift($photos);
			return wp_get_attachment_url($photo->ID);
		}
		return false;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display first image thumb */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_tn')) {
	function ct_first_image_tn() { ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail(array(150,150)); ?>
		</a>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Display first image thumb */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_lrg')) {
	function ct_first_image_lrg() {
		the_post_thumbnail('full');
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display first image linked portfolio widget */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_linked_portfolio_widget')) {
	function ct_first_image_linked_portfolio_widget() { ?>
		<a class="thumb" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('large'); ?>
		</a>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Display all images attached to post */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_slider_images')) {
	function ct_slider_images() {
		global $post;

		$photos = ct_get_images('full');
		$position = get_post_meta($post->ID, '_ct_images_position', true);

		if($position = "") {
			if ($photos) {
				foreach ($photos as $photo) { ?>
					<li data-thumb="<?php echo esc_url($photo); ?>">
						<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
							<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
						</a>
					</li>
				<?php }
			}
		}
		else {
			$position = explode(',',$position);
			foreach ($position as $pos) {  if($pos!="" && isset($photos[$pos])){  $photo=$photos[$pos]; unset($photos[$pos]); ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</a>
				</li>
			<?php } }

			foreach ($photos as $photo) { ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</a>
				</li>
			<?php }
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images uploaded to slides custom field */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_slider_field_images')) {
	function ct_slider_field_images() {

		global $post;

		$photoss = get_post_meta($post->ID, "_ct_slider", true);
		$position = get_post_meta($post->ID, '_ct_images_position', true);
		$photosFloorPlan = get_post_meta($post->ID, '_ct_floorimages', true);
// echo "here";die();
		//$photos = unserialize($photoss);
		$photos = $photoss;
		if($position == "") {
			if ($photos) {
				foreach ($photos as $photo) { ?>
					<li data-thumb="<?php echo esc_url($photo); ?>">
						<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
							<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
						</a>
					</li>
				<?php }
				?>
				<!--<li data-thumb="<?php /*echo esc_url($photosFloorPlan); */?>">
						<a href="<?php /*echo esc_url($photosFloorPlan); */?>" class="gallery-item">
							<img src="<?php /*echo esc_url($photosFloorPlan); */?>" title="<?php /*the_title(); */?>" />
							</a>
						</li>-->
				<?php
			}
		}
		else {
			$position = explode(',',$position);
			foreach ($position as $pos) {  if($pos!="" && isset($photos[$pos])){  $photo=$photos[$pos]; unset($photos[$pos]); ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</a>
				</li>
			<?php } }

			foreach ($photos as $photo) { ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</a>
				</li>
			<?php }

		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images attached to post - Single Home Layout */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_sh_slider_images')) {
	function ct_sh_slider_images() {
		$photos = ct_get_images('full');
		if ($photos) {
			foreach ($photos as $photo) { ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<a href="<?php echo esc_url($photo); ?>" class="gallery-item">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</a>
				</li>
			<?php }
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images attached to post */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_slider_carousel_images')) {
	function ct_slider_carousel_images() {
		global $post;

		$photos = ct_get_images('full');
		$position = get_post_meta($post->ID, '_ct_images_position', true);

		if($position=="") {
			if ($photos) {
				foreach ($photos as $photo) { ?>
					<li data-thumb="<?php echo esc_url($photo); ?>">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</li>
				<?php }
			}
		}
		else{
			$position = explode(',',$position);
			foreach ($position as $pos) {  if($pos!="" && isset($photos[$pos])){  $photo=$photos[$pos]; unset($photos[$pos]); ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
				</li>
			<?php } }

			foreach ($photos as $photo) { ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
				</li>
			<?php }
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display all images uploaded to slides custom field */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_slider_field_carousel_images')) {
	function ct_slider_field_carousel_images() {
		global $post;

		$photoss = get_post_meta($post->ID, "_ct_slider", true);
		$photosFloorPlan = get_post_meta($post->ID, "_ct_floorimages", true);
		$position = get_post_meta($post->ID, '_ct_images_position', true);
		//$photos = unserialize($photoss);
		$photos = $photoss;

		if($position = "") {
			if ($photos) {
				foreach ($photos as $photo) { ?>
					<li data-thumb="<?php echo esc_url($photo); ?>">
						<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
					</li>
				<?php }
			}
		}
		else {
			$position = explode(',',$position);
			foreach ($position as $pos) {  if($pos!="" && isset($photos[$pos])){  $photo=$photos[$pos]; unset($photos[$pos]); ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
				</li>
			<?php } }

			foreach ($photos as $photo) { ?>
				<li data-thumb="<?php echo esc_url($photo); ?>">
					<img src="<?php echo esc_url($photo); ?>" title="<?php the_title(); ?>" />
				</li>
			<?php } ?>
			<!--<li data-thumb="<?php /*echo esc_url($photosFloorPlan); */?>">
						<img src="<?php /*echo esc_url($photosFloorPlan); */?>" title="<?php /*the_title(); */?>" />
					</li>-->
			<?php
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display first image linked */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_linked')) {
	function ct_first_image_linked() { ?><a <?php ct_listing_permalink(); ?>><?php the_post_thumbnail('large'); ?></a><?php }
}

/*-----------------------------------------------------------------------------------*/
/* Display first image linked widget */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_linked_widget')) {
	function ct_first_image_linked_widget() { ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(800,600)); ?></a><?php }
}

/*-----------------------------------------------------------------------------------*/
/* Display first image map thumb */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_first_image_map_tn')) {
	function ct_first_image_map_tn() {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'medium', true);
		echo '<img src="' . $thumb_url[0] . '" width="250" />';
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get users */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_get_users')) {
	function ct_get_users($users_per_page = 10, $paged = 1, $role = '', $orderby = 'login', $order = 'ASC', $usersearch = '' ) {

		global $blog_id;

		$args = array(
			'number' => $users_per_page,
			'offset' => ( $paged-1 ) * $users_per_page,
			'role' => $role,
			'search' => $usersearch,
			'fields' => 'all_with_meta',
			'blog_id' => $blog_id,
			'orderby' => $orderby,
			'order' => $order
		);

		$wp_user_search = new WP_User_Query( $args );
		$user_results = $wp_user_search->get_results();

		return $user_results;

	}
}

/*-----------------------------------------------------------------------------------*/
/* Listings Navigation */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_listings_nav')) {
	function ct_listings_nav() { ?>
		<div class="clear"></div>
		<nav class="content-nav marB30">
			<div class="nav-previous left"><?php next_posts_link( __( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> Older listings', 'contempo' ) ); ?></div>
			<div class="nav-next right"><?php previous_posts_link( __( 'Newer listings <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>', 'contempo' ) ); ?></div>
			<div class="clear"></div>
		</nav>
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Content Navigation */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_archive_content_nav')) {
	function ct_archive_content_nav() { ?>

		<div class="nav-previous"><?php previous_posts_link('Previous') ?></div>
		<div class="nav-next"><?php next_posts_link('Next','') ?></div>

	<?php }
}

if(!function_exists('ct_single_content_nav')) {
	function ct_single_content_nav() { ?>

		<div class="nav-previous"><?php previous_post_link( __( '%link', 'contempo' ) ); ?></div>
		<div class="nav-next"><?php next_post_link( __( '%link', 'contempo' ) ); ?></div>

	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Browser Detection */
/*-----------------------------------------------------------------------------------*/

class Browser {

	private static $known_browsers = array(
		'msie', 'firefox', 'safari',
		'webkit', 'opera', 'netscape',
		'konqueror', 'gecko', 'chrome'
	);

	private function __construct() {}

	static public function get_info ($agent = null) {
		// Clean up agent and build regex that matches phrases for known browsers
		// (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
		// version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
		$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);

		// This pattern throws an exception if server is not up to date on regex lib
		//$pattern = '#(?<browser>' . join('|', $known) .
		//           ')[/ ]+(?<version>[0-9]+(?:.[0-9]+)?)#';
		// So we use this one
		$pattern = '#(' . join('|',self::$known_browsers) .
			')[/ ]+([0-9]+(?:.[0-9]+)?)#';

		// Find all phrases (or return empty array if none found)
		if(!preg_match_all($pattern, $agent, $matches)) return array();

		// Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
		// Opera 7,8 have a MSIE phrase), use the last two found (the right-most one
		// in the UA).  That's usually the most correct.

		$i = count($matches[1])-1;
		$r = array($matches[1][$i] => $matches[2][$i]);
		if ($i) $r[$matches[1][$i-1]] = $matches[2][$i-1];

		return $r;
	}

	/******************************************************************************/

	/**
	 * Is the user's browser that %#$@! of IE ?
	 * @return boolean
	 */
	static public function isIE () {
		$bi = self::get_info();
		return (!empty($bi['msie']));
	}
	static public function isIE6 () {
		$bi = self::get_info();
		return (!empty($bi['msie']) && $bi['msie'] == 6.0);
	}
	static public function isIE7 () {
		$bi = self::get_info();
		return (!empty($bi['msie']) && $bi['msie'] == 7.0);
	}
	static public function isIE8 () {
		$bi = self::get_info();
		return (!empty($bi['msie']) && $bi['msie'] == 8.0);
	}
	static public function isIE9 () {
		$bi = self::get_info();
		return (!empty($bi['msie']) && $bi['msie'] == 9.0);
	}

	/**
	 * Is the user's browser da good ol' Firefox ?
	 * @return boolean
	 */
	static public function isFirefox () {
		return (strpos ($_SERVER['HTTP_USER_AGENT'], "Firefox") !== false);
	}

	/**
	 * Is the user's browser the shiny Chrome ?
	 * @return boolean
	 */
	static public function isChrome () {
		$bi = self::get_info();
		return (!empty($bi['chrome']));
	}

	/**
	 * Is the user's browser Safari ?
	 * @return boolean
	 */
	static public function isSafari () {
		$bi = self::get_info();
		return (!empty($bi['safari']) && !empty($bi['webkit']));
	}

	/**
	 * Is the user's browser the almighty Opera ?
	 * @return boolean
	 */
	static public function isOpera () {
		$bi = self::get_info();
		return ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera') !== false );
	}

	/**
	 * Is the user's platform iPhone ?
	 * @return boolean
	 */
	static public function isIphone () {
		return ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone') !== false );
	}

	/**
	 * Is the user's platform iPad ?
	 * @return boolean
	 */
	static public function isIpad () {
		return ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad') !== false );
	}

	/**
	 * Is the user's platform the awesome Android ?
	 * @return boolean
	 */
	static public function isAndroid () {
		return ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') !== false );
	}

}

/**
 * The code below is inspired by Justin Tadlock's Hybrid Core.
 *
 * ct_breadcrumbs() shows a breadcrumb for all types of pages.  Themes and plugins can filter $args or input directly.
 * Allow filtering of only the $args using get_the_breadcrumb_args.
 *
 * @since 3.7.0
 * @param array $args Mixed arguments for the menu.
 * @return string Output of the breadcrumb menu.
 */

if(!function_exists('ct_breadcrumbs')) {
	function ct_breadcrumbs( $args = array() ) {
		global $wp_query, $wp_rewrite;

		/* Create an empty variable for the breadcrumb. */
		$breadcrumb = '';

		/* Create an empty array for the trail. */
		$trail = array();
		$path = '';

		/* Set up the default arguments for the breadcrumb. */
		$defaults = array(
			'separator' => '<i class="fa fa-angle-right"></i>',
			'before' => '<span class="breadcrumb-title"></span>',
			'after' => false,
			'front_page' => true,
			'show_home' => __( 'Home', 'contempo' ),
			'echo' => true
		);

		/* Allow singular post views to have a taxonomy's terms prefixing the trail. */
		if ( is_singular() )
			$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;

		/* Apply filters to the arguments. */
		$args = apply_filters( 'ct_breadcrumbs_args', $args );

		/* Parse the arguments and extract them for easy variable naming. */
		extract( wp_parse_args( $args, $defaults ) );

		/* If $show_home is set and we're not on the front page of the site, link to the home page. */
		if ( !is_front_page() && $show_home )
			$trail[] = '<a id="bread-home" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="trail-begin">' . $show_home . '</a>';

		/* If viewing the front page of the site. */
		if ( is_front_page() ) {
			if ( !$front_page )
				$trail = false;
			elseif ( $show_home )
				$trail['trail_end'] = "{$show_home}";
		}

		/* If viewing the "home"/posts page. */
		elseif ( is_home() ) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, ct_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
			$trail['trail_end'] = get_the_title( $home_page->ID );
		}

		/* If viewing a singular post (page, attachment, etc.). */
		elseif ( is_singular() ) {

			/* Get singular post variables needed. */
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_type = $post->post_type;
			$parent = $post->post_parent;

			/* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
			if ( 'page' !== $post_type ) {

				$post_type_object = get_post_type_object( $post_type );

				$rewrite['with_front'] = isset( $rewrite['with_front'] ) ? $rewrite['with_front'] : '';

				/* If $front has been set, add it to the $path. */
				if ( 'post' == $post_type || 'attachment' == $post_type || ( /*$post_type_object->rewrite['with_front'] &&*/ $wp_rewrite->front ) )
					$path .= trailingslashit( $wp_rewrite->front );

				/* If there's a slug, add it to the $path. */
				if ( !empty( $post_type_object->rewrite['slug'] ) )
					$path .= $post_type_object->rewrite['slug'];

				/* If there's a path, check for parents. */
				if ( !empty( $path ) )
					$trail = array_merge( $trail, ct_breadcrumbs_get_parents( '', $path ) );

				/* If there's an archive page, add it to the trail. */
				if ( !empty( $post_type_object->rewrite['archive'] ) && function_exists( 'get_post_type_archive_link' ) )
					$trail[] = '<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
			}

			/* If the post type path returns nothing and there is a parent, get its parents. */
			if ( empty( $path ) && 0 !== $parent || 'attachment' == $post_type )
				$trail = array_merge( $trail, ct_breadcrumbs_get_parents( $parent, '' ) );

			/* Display terms for specific post type taxonomy if requested. */
			if ( isset( $args["singular_{$post_type}_taxonomy"] ) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) )
				$trail[] = $terms;

			/* End with the post title. */
			$post_title = get_the_title( $post_id ); // Force the post_id to make sure we get the correct page title.
			if ( !empty( $post_title ) )
				$trail['trail_end'] = $post_title;
		}

		/* If we're viewing any type of archive. */
		elseif ( is_archive() ) {

			/* If viewing a taxonomy term archive. */
			if ( is_tax() || is_category() || is_tag() ) {

				/* Get some taxonomy and term variables. */
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );

				/* Get the path to the term archive. Use this to determine if a page is present with it. */
				if ( is_category() )
					$path = get_option( 'category_base' );
				elseif ( is_tag() )
					$path = get_option( 'tag_base' );
				else {
					if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front )
						$path = trailingslashit( $wp_rewrite->front );
					$path .= $taxonomy->rewrite['slug'];
				}

				/* Get parent pages by path if they exist. */
				if ( $path )
					$trail = array_merge( $trail, ct_breadcrumbs_get_parents( '', $path ) );

				/* If the taxonomy is hierarchical, list its parent terms. */
				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent )
					$trail = array_merge( $trail, ct_breadcrumbs_get_term_parents( $term->parent, $term->taxonomy ) );

				/* Add the term name to the trail end. */
				$trail['trail_end'] = $term->name;
			}

			/* If viewing a post type archive. */
			elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {

				/* Get the post type object. */
				$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

				/* If $front has been set, add it to the $path. */
				if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front )
					$path .= trailingslashit( $wp_rewrite->front );

				/* If there's a slug, add it to the $path. */
				if ( !empty( $post_type_object->rewrite['archive'] ) )
					$path .= $post_type_object->rewrite['archive'];

				/* If there's a path, check for parents. */
				if ( !empty( $path ) )
					$trail = array_merge( $trail, ct_breadcrumbs_get_parents( '', $path ) );

				/* Add the post type [plural] name to the trail end. */
				$trail['trail_end'] = $post_type_object->labels->name;
			}

			/* If viewing an author archive. */
			elseif ( is_author() ) {

				/* If $front has been set, add it to $path. */
				if ( !empty( $wp_rewrite->front ) )
					$path .= trailingslashit( $wp_rewrite->front );

				/* If an $author_base exists, add it to $path. */
				if ( !empty( $wp_rewrite->author_base ) )
					$path .= $wp_rewrite->author_base;

				/* If $path exists, check for parent pages. */
				if ( !empty( $path ) )
					$trail = array_merge( $trail, ct_breadcrumbs_get_parents( '', $path ) );

				/* Add the author's display name to the trail end. */
				$trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
			}

			/* If viewing a time-based archive. */
			elseif ( is_time() ) {

				if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
					$trail['trail_end'] = get_the_time( __( 'g:i a', 'contempo' ) );

				elseif ( get_query_var( 'minute' ) )
					$trail['trail_end'] = sprintf( __( 'Minute %1$s', 'contempo' ), get_the_time( __( 'i', 'contempo' ) ) );

				elseif ( get_query_var( 'hour' ) )
					$trail['trail_end'] = get_the_time( __( 'g a', 'contempo' ) );
			}

			/* If viewing a date-based archive. */
			elseif ( is_date() ) {

				/* If $front has been set, check for parent pages. */
				if ( $wp_rewrite->front )
					$trail = array_merge( $trail, ct_breadcrumbs_get_parents( '', $wp_rewrite->front ) );

				if ( is_day() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'contempo' ) ) . '">' . get_the_time( __( 'Y', 'contempo' ) ) . '</a>';
					$trail[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( esc_attr__( 'F', 'contempo' ) ) . '">' . get_the_time( __( 'F', 'contempo' ) ) . '</a>';
					$trail['trail_end'] = get_the_time( __( 'j', 'contempo' ) );
				}

				elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'contempo' ) ) . '">' . get_the_time( __( 'Y', 'contempo' ) ) . '</a>';
					$trail['trail_end'] = sprintf( __( 'Week %1$s', 'contempo' ), get_the_time( esc_attr__( 'W', 'contempo' ) ) );
				}

				elseif ( is_month() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'contempo' ) ) . '">' . get_the_time( __( 'Y', 'contempo' ) ) . '</a>';
					$trail['trail_end'] = get_the_time( __( 'F', 'contempo' ) );
				}

				elseif ( is_year() ) {
					$trail['trail_end'] = get_the_time( __( 'Y', 'contempo' ) );
				}
			}
		}

		/* If viewing search results. */
		elseif ( is_search() )
			$trail['trail_end'] = sprintf( __( 'Search results for &quot;%1$s&quot;', 'contempo' ), esc_attr( get_search_query() ) );

		/* If viewing a 404 error page. */
		elseif ( is_404() )
			$trail['trail_end'] = __( '404 Not Found', 'contempo' );

		/* Connect the breadcrumb trail if there are items in the trail. */
		if ( is_array( $trail ) ) {

			/* Open the breadcrumb trail containers. */
			$breadcrumb = '<div class="breadcrumb breadcrumbs ct-breadcrumbs right muted"><div class="breadcrumb-trail">';

			/* If $before was set, wrap it in a container. */
			if ( !empty( $before ) )
				$breadcrumb .= '<span class="trail-before">' . $before . '</span> ';

			/* Wrap the $trail['trail_end'] value in a container. */
			if ( !empty( $trail['trail_end'] ) )
				$trail['trail_end'] = '<span class="trail-end">' . $trail['trail_end'] . '</span>';

			/* Format the separator. */
			if ( !empty( $separator ) )
				$separator = '<span class="sep">' . $separator . '</span>';

			/* Join the individual trail items into a single string. */
			$breadcrumb .= join( " {$separator} ", $trail );

			/* If $after was set, wrap it in a container. */
			if ( !empty( $after ) )
				$breadcrumb .= ' <span class="trail-after">' . $after . '</span>';

			/* Close the breadcrumb trail containers. */
			$breadcrumb .= '</div></div>';
		}

		/* Allow developers to filter the breadcrumb trail HTML. */
		$breadcrumb = apply_filters( 'ct_breadcrumbs', $breadcrumb );

		/* Output the breadcrumb. */
		if ( $echo )
			echo $breadcrumb;
		else
			return $breadcrumb;

	}
}

/*-----------------------------------------------------------------------------------*/
/* Get parents */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_breadcrumbs_get_parents')) {
	function ct_breadcrumbs_get_parents( $post_id = '', $path = '' ) {

		/* Set up an empty trail array. */
		$trail = array();

		/* If neither a post ID nor path set, return an empty array. */
		if ( empty( $post_id ) && empty( $path ) )
			return $trail;

		/* If the post ID is empty, use the path to get the ID. */
		if ( empty( $post_id ) ) {

			/* Get parent post by the path. */
			$parent_page = get_page_by_path( $path );

			if( empty( $parent_page ) )
				// search on page name (single word)
				$parent_page = get_page_by_title ( $path );

			if( empty( $parent_page ) )
				// search on page title (multiple words)
				$parent_page = get_page_by_title ( str_replace( array('-', '_'), ' ', $path ) );

			/* End Modification */

			/* If a parent post is found, set the $post_id variable to it. */
			if ( !empty( $parent_page ) )
				$post_id = $parent_page->ID;
		}

		/* If a post ID and path is set, search for a post by the given path. */
		if ( $post_id == 0 && !empty( $path ) ) {

			/* Separate post names into separate paths by '/'. */
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			/* If matches are found for the path. */
			if ( isset( $matches ) ) {

				/* Reverse the array of matches to search for posts in the proper order. */
				$matches = array_reverse( $matches );

				/* Loop through each of the path matches. */
				foreach ( $matches as $match ) {

					/* If a match is found. */
					if ( isset( $match[0] ) ) {

						/* Get the parent post by the given path. */
						$path = str_replace( $match[0], '', $path );
						$parent_page = get_page_by_path( trim( $path, '/' ) );

						/* If a parent post is found, set the $post_id and break out of the loop. */
						if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
					}
				}
			}
		}

		/* While there's a post ID, add the post link to the $parents array. */
		while ( $post_id ) {

			/* Get the post by ID. */
			$page = get_page( $post_id );

			/* Add the formatted post link to the array of parents. */
			$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';

			/* Set the parent post's parent to the post ID. */
			$post_id = $page->post_parent;
		}

		/* If we have parent posts, reverse the array to put them in the proper order for the trail. */
		if ( isset( $parents ) )
			$trail = array_reverse( $parents );

		/* Return the trail of parent posts. */
		return $trail;

	}
}

/*-----------------------------------------------------------------------------------*/
/* Get term parents */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_breadcrumbs_get_term_parents')) {
	function ct_breadcrumbs_get_term_parents( $parent_id = '', $taxonomy = '' ) {

		/* Set up some default arrays. */
		$trail = array();
		$parents = array();

		/* If no term parent ID or taxonomy is given, return an empty array. */
		if ( empty( $parent_id ) || empty( $taxonomy ) )
			return $trail;

		/* While there is a parent ID, add the parent term link to the $parents array. */
		while ( $parent_id ) {

			/* Get the parent term. */
			$parent = get_term( $parent_id, $taxonomy );

			/* Add the formatted term link to the array of parent terms. */
			$parents[] = '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a>';

			/* Set the parent term's parent as the parent ID. */
			$parent_id = $parent->parent;
		}

		/* If we have parent terms, reverse the array to put them in the proper order for the trail. */
		if ( !empty( $parents ) )
			$trail = array_reverse( $parents );

		/* Return the trail of parent terms. */
		return $trail;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Front End Set Attachment As Featured */
/*-----------------------------------------------------------------------------------*/

function ct_set_attachment_featured( $post ) {
	$msg = 'Attachment ID [' . $_POST['att_ID'] . '] set as featured!';
	if( set_post_thumbnail($_POST['post_ID'], $_POST['att_ID'])) {
		echo $msg;
	}
	die();
}
add_action( 'wp_ajax_ct_set_attachment_featured', 'ct_set_attachment_featured' );

/*-----------------------------------------------------------------------------------*/
/* Front End Image Upload */
/*-----------------------------------------------------------------------------------*/

function ct_front_img_upload( $post ) {
	if (empty($_FILES) || $_FILES['file']['error']) { die('{"OK": 0, "info": "Failed to move uploaded file."}'); }

	$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

	$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
	$wp_upload_dir = wp_upload_dir();
	$filePath = $wp_upload_dir['path'].'/'.$fileName;
	$filePath2 = $wp_upload_dir['url'].'/'.$fileName;


	// Open temp file
	$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
	if ($out) {
		$in = @fopen($_FILES['file']['tmp_name'], "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"OK": 0, "info": "Failed to open input stream."}');

		@fclose($in);
		@fclose($out);

		@unlink($_FILES['file']['tmp_name']);
	} else
		die('{"OK": 0, "info": "Failed to open output stream."}');

	$name=$filePath2.'.part';
	if(!$chunks || $chunk == $chunks - 1) {
		$name=$filePath;
		rename($filePath.".part", $filePath);

		$filename2 = $filePath;
		$filetype = wp_check_filetype( basename( $filename2 ), null );
		$wp_upload_dir = wp_upload_dir();
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename2 ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename2 ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		if(isset($_GET['postid'])) $attach_id = wp_insert_attachment( $attachment, $filename2, $_GET['postid'] );
		else $attach_id = wp_insert_attachment( $attachment, $filename2 );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename2 );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		if(is_int($attach_id)){
			$link=wp_get_attachment_url($attach_id);
			die('{"jsonrpc" : "2.0", "success" : true, "id" : "id", "id_att" : "'.$attach_id.'", "link" : "'.$link.'"}');
		}
		else die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Error uplaoding file."}, "id" : "id"}');
	}

	die('{"OK": 1, "info": "Upload successful.", "link": "'.$name.'"}');
}
add_action( 'wp_ajax_ct_front_img_upload', 'ct_front_img_upload' );

/*-----------------------------------------------------------------------------------*/
/* Front End Delete Attachment */
/*-----------------------------------------------------------------------------------*/

function ct_delete_attachment_edit( $post ) {
	//echo $_POST['att_ID'];
	$msg = 'Attachment ID [' . $_POST['att_ID'] . '] has been deleted!';
	if( wp_delete_attachment( $_POST['att_ID'], true )) {
		echo $msg;
	}
	die();
}
add_action( 'wp_ajax_ct_delete_attachment_edit', 'ct_delete_attachment_edit' );

/*-----------------------------------------------------------------------------------*/
/* Advanced Search Ajax Chaining */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_returnPostsTax')) {
	function ct_returnPostsTax($posts,$taxonomy) {
		if($taxonomy=="") return array();
		$r=array();
		foreach($posts as $post_t){
			$tax=wp_get_post_terms($post_t->ID, $taxonomy);
			if(!is_wp_error($tax) && (isset($tax[0]) && $tax[0]->name!=null)) $r[$tax[0]->slug]=$tax[0]->name;
		}
		return $r;
	}
}

if(!function_exists('ct_returnPostsByTax')) {
	function ct_returnPostsByTax($taxonomies) {
		$taxonomies_q=array();
		foreach($taxonomies as $k=>$tax){
			$taxonomies_q[]=array( 'taxonomy' => $k, 'field' => 'slug', 'terms' => $tax );
		}
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'listings',
			'tax_query' => array( $taxonomies_q )
		);
		$posts=get_posts( $args );
		return $posts;
	}
}

if(!function_exists('ct_getTaxonomiesRelational')) {
	function ct_getTaxonomiesRelational($current,$filters="") {
		$args=array();
		if($filters==""){ $args=array('state'=>'','city'=>'','zipcode'=>''); }
		else { foreach($filters as $k=>$f){ $args[$k]=$f; } }
		$posts=ct_returnPostsByTax($args);
		$return=ct_returnPostsTax($posts,$current);
		return $return;
	}
}

if(!function_exists('ct_getAllTerms')) {
	function ct_getAllTerms($taxonomy_name) {
		$return=array();
		$terms=get_terms($taxonomy_name, 'hide_empty=true');
		foreach ( $terms as $k=>$term ) {
			$return[$term->slug]=$term->name;
		}
		return $return;
	}
}

add_action( 'wp_ajax_nopriv_country_ajax', 'ct_country_ajax_callback' );
add_action( 'wp_ajax_country_ajax', 'ct_country_ajax_callback' );
add_action( 'wp_ajax_nopriv_state_ajax', 'ct_state_ajax_callback' );
add_action( 'wp_ajax_state_ajax', 'ct_state_ajax_callback' );
add_action( 'wp_ajax_nopriv_city_ajax', 'ct_city_ajax_callback' );
add_action( 'wp_ajax_city_ajax', 'ct_city_ajax_callback' );
add_action( 'wp_ajax_nopriv_zipcode_ajax', 'ct_zipcode_ajax_callback' );
add_action( 'wp_ajax_zipcode_ajax', 'ct_zipcode_ajax_callback' );

if(!function_exists('ct_country_ajax_callback')) {
	function ct_country_ajax_callback() {
		global $wpdb;
		$return['success']=true;
		if($_POST['country']=="0"){
			$return['state']=ct_getAllTerms('state');
			$return['city']=ct_getAllTerms('city');
			$return['zipcode']=ct_getAllTerms('zipcode');
		}
		else{
			$return['state']=ct_getTaxonomiesRelational('state',array('country'=>$_POST['country']));
			$return['city']=ct_getTaxonomiesRelational('city',array('country'=>$_POST['country']));
			$return['zipcode']=ct_getTaxonomiesRelational('zipcode',array('country'=>$_POST['country']));
		}
		echo json_encode($return);
		wp_die();
	}
}

if(!function_exists('ct_state_ajax_callback')) {
	function ct_state_ajax_callback() {
		global $wpdb;
		$return['success']=true;
		if($_POST['firstsearch']){
			$return['country']=ct_getTaxonomiesRelational('country',array('state'=>$_POST['state']));
			$return['city']=ct_getTaxonomiesRelational('city',array('state'=>$_POST['state']));
			$return['zipcode']=ct_getTaxonomiesRelational('zipcode',array('state'=>$_POST['state']));
		}else{
			$return['city']=ct_getTaxonomiesRelational('city',array('country'=>$_POST['country'],'state'=>$_POST['state']));
			$return['zipcode']=ct_getTaxonomiesRelational('zipcode',array('country'=>$_POST['country'],'state'=>$_POST['state']));
		}
		echo json_encode($return);
		wp_die();
	}
}

if(!function_exists('ct_city_ajax_callback')) {
	function ct_city_ajax_callback() {
		global $wpdb;
		$return['success']=true;
		if($_POST['firstsearch']){
			$return['country']=ct_getTaxonomiesRelational('country',array('city'=>$_POST['city']));
			$return['state']=ct_getTaxonomiesRelational('state',array('city'=>$_POST['city']));
			$return['zipcode']=ct_getTaxonomiesRelational('zipcode',array('city'=>$_POST['city']));
		}else{
			$return['zipcode']=ct_getTaxonomiesRelational('zipcode',array('country'=>$_POST['country'],'state'=>$_POST['state'],'zipcode'=>$_POST['zipcode']));
		}
		echo json_encode($return);
		wp_die();
	}
}

if(!function_exists('ct_zipcode_ajax_callback')) {
	function ct_zipcode_ajax_callback() {
		global $wpdb;
		$return['success']=true;
		$return['country']=ct_getTaxonomiesRelational('country',array('zipcode'=>$_POST['zipcode']));
		$return['state']=ct_getTaxonomiesRelational('state',array('zipcode'=>$_POST['zipcode']));
		$return['city']=ct_getTaxonomiesRelational('city',array('zipcode'=>$_POST['zipcode']));
		echo json_encode($return);
		wp_die();
	}
}

if(!function_exists('ct_add_localize_to_head')) {
	function ct_add_localize_to_head(){
		?>
		<script type="text/javascript">
			var ajax_link='<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script>
		<?php
	}
}
add_action('wp_head','ct_add_localize_to_head');



//search by reference number
add_filter( 'posts_join', 'reference_search_join' );
function reference_search_join ( $join ) {
	global $pagenow, $wpdb;

	// I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
	if ( is_admin() && 'edit.php' === $pagenow && 'listings' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
		$join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}
	return $join;
}

add_filter( 'posts_where', 'reference_search_where' );
function reference_search_where( $where ) {
	global $pagenow, $wpdb;

	// I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
	if ( is_admin() && 'edit.php' === $pagenow && 'listings' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
		$where = preg_replace(
			"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
	}
	return $where;
}

?>