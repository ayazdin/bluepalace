<?php
/**
 * Search Listings Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;
$ct_home_adv_search_style = isset( $ct_options['ct_home_adv_search_style'] ) ? $ct_options['ct_home_adv_search_style'] : '';
$ct_disable_listing_search_results_adv_search = isset( $ct_options['ct_disable_listing_search_results_adv_search'] ) ? $ct_options['ct_disable_listing_search_results_adv_search'] : '';
$ct_search_results_layout = isset( $ct_options['ct_search_results_layout'] ) ? $ct_options['ct_search_results_layout'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
$ct_header_listing_search = isset( $ct_options['ct_header_listing_search'] ) ? esc_html( $ct_options['ct_header_listing_search'] ) : '';

/*-----------------------------------------------------------------------------------*/
/* Query multiple taxonomies */
/*-----------------------------------------------------------------------------------*/

$taxonomies_to_search = array(
	'beds' => 'Bedrooms',
	'baths' => 'Bathrooms',
	'property_type' => 'Property Type',
	'ct_status' => 'Status',
	'state' => 'State',
	'zipcode' => 'Zipcode',
	'city' => 'City',
	'country' => 'Country',
	'community' => 'Community',
	'additional_features' => 'Additional Features',
	'furnished_unfurnished' => 'Furnished/Unfurnished'
);                                                                       

$search_values = array();

foreach ($taxonomies_to_search as $t => $l) {
	$var_name = 'ct_'. $t;
	
	if (!empty($_GET[$var_name])) {  
		$search_values[$t] = utf8_encode($_GET[$var_name]);
	}                                                     
}                                                          
                                   
$search_values['post_type'] = 'listings';
$search_values['paged'] = ct_currentPage();
$search_num = $ct_options['ct_listing_search_num'];
$search_values['showposts'] = $search_num;

/*-----------------------------------------------------------------------------------*/
/* Exclude Ghost Status */
/*-----------------------------------------------------------------------------------*/ 

$search_values['tax_query'] = array (
	array(
	    'taxonomy'  => 'ct_status',
	    'field'     => 'slug',
	    'terms'     => 'ghost', // exclude media posts in the news-cat custom taxonomy
	    'operator'  => 'NOT IN'
    ),
);

/*-----------------------------------------------------------------------------------*/
/* Keyword Search on Title and Content */
/*-----------------------------------------------------------------------------------*/

//add_action( 'pre_get_posts', function( $q ) {
//    if($title = $q->get('_meta_or_title')) {
//        add_filter( 'get_meta_sql', function($sql) use ($title) {
//            global $wpdb;
//
//            // Only run once:
//            static $nr = 0;
//            if(0 != $nr++) return $sql;
//
//            // Modify WHERE part:
//            $sql['where'] = sprintf(
//                " AND ( %s OR %s ) ",
//                $wpdb->prepare("{$wpdb->posts}.post_title like '%%%s%%'", $title),
//                $wpdb->prepare("{$wpdb->posts}.post_content like '%%%s%%'", $title),
//                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
//            );
//            return $sql;
//        });
//    }
//});

if (!empty($_GET['ct_keyword'])) {

	$ct_keyword = $_GET['ct_keyword'];
	$search_values['_meta_or_title'] = $ct_keyword; 

	$search_values['meta_query'] = array(
		array(
			'meta_key' => 'keywords',
			'value' => $ct_keyword,
			'compare' => 'LIKE'
		)
	);

}

// Order by Price
if (!empty($_GET['ct_orderby_price'])) {

	$order = utf8_encode($_GET['ct_orderby_price']);

	$search_values['orderby'] = 'meta_value';
	$search_values['meta_key'] = '_ct_price';
	$search_values['meta_type'] = 'numeric';
	$search_values['order'] = $order;

}

/*-----------------------------------------------------------------------------------*/
/* Order by (Title, Price or upload date) */
/*-----------------------------------------------------------------------------------*/ 

if (!empty($_GET['ct_orderby'])) {
	$orderBy = $_GET['ct_orderby'];

	if ($orderBy == 'priceASC') {
		$search_values['orderby'] = 'meta_value';
		$search_values['meta_key'] = '_ct_price';
		$search_values['meta_type'] = 'numeric';
		$search_values['order'] = 'ASC';		
	} elseif ($orderBy == 'priceDESC') {
		$search_values['orderby'] = 'meta_value';
		$search_values['meta_key'] = '_ct_price';
		$search_values['meta_type'] = 'numeric';
		$search_values['order'] = 'DESC';
	} elseif ($orderBy == 'dateDESC') {
		$search_values['orderby'] = 'date';
		$search_values['order'] = 'DESC';
	}elseif ($orderBy == 'dateASC') {
		$search_values['orderby'] = 'date';
		$search_values['order'] = 'ASC';
	} else { //	titleASC	
		$search_values['orderby'] = 'title';
		$search_values['order'] = 'ASC';
	}
} 

$mode = 'search'; 
    
/*-----------------------------------------------------------------------------------*/
/* Check Price From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_price_from']) && !empty($_GET['ct_price_to'])) {
	$ct_price_from = str_replace(',', '', $_GET['ct_price_from']);
	$ct_price_to = str_replace(',', '', $_GET['ct_price_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_price',
			'value' => array( $ct_price_from, $ct_price_to ),
			'type' => 'NUMERIC',
			'compare' => 'BETWEEN'
		)
	);
}
else if (!empty($_GET['ct_price_from'])) {               
	$ct_price_from = str_replace(',', '', $_GET['ct_price_from']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_price',
			'value' => $ct_price_from,
			'type' => 'NUMERIC',
			'compare' => '>='
		)
	);	
}
else if (!empty($_GET['ct_price_to'])) {               
	$ct_price_to = str_replace(',', '', $_GET['ct_price_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_price',
			'value' => $_GET['ct_price_to'],
			'type' => 'NUMERIC',
			'compare' => '<='
		)
	);	
}

/*-----------------------------------------------------------------------------------*/
/* Check Dwelling Size From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_sqft_from']) && !empty($_GET['ct_sqft_to'])) {
	$ct_sqft_from = str_replace(',', '', $_GET['ct_sqft_from']);
	$ct_sqft_to = str_replace(',', '', $_GET['ct_sqft_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_sqft',
			'value' => array( $ct_sqft_from, $ct_sqft_to ),
			'type' => 'NUMERIC',
			'compare' => 'BETWEEN'
		)
	);
}
else if (!empty($_GET['ct_sqft_from'])) {               
	$ct_sqft_from = str_replace(',', '', $_GET['ct_sqft_from']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_sqft',
			'value' => $ct_sqft_from,
			'type' => 'NUMERIC',
			'compare' => '>='
		)
	);	
}
else if (!empty($_GET['ct_sqft_to'])) {               
	$ct_sqft_to = str_replace(',', '', $_GET['ct_sqft_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_sqft',
			'value' => $ct_sqft_to,
			'type' => 'NUMERIC',
			'compare' => '<='
		)
	);	
}

/*-----------------------------------------------------------------------------------*/
/* Check Lot Size From/To */
/*-----------------------------------------------------------------------------------*/

if (!empty($_GET['ct_lotsize_from']) && !empty($_GET['ct_sqft_to'])) {
	$ct_lotsize_from = str_replace(',', '', $_GET['ct_lotsize_from']);
	$ct_lotsize_to = str_replace(',', '', $_GET['ct_lotsize_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_lotsize',
			'value' => array( $ct_sqft_from, $ct_sqft_to ),
			'type' => 'NUMERIC',
			'compare' => 'BETWEEN'
		)
	);
}
else if (!empty($_GET['ct_lotsize_from'])) {               
	$ct_lotsize_from = str_replace(',', '', $_GET['ct_lotsize_from']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_lotsize',
			'value' => $ct_lotsize_from,
			'type' => 'NUMERIC',
			'compare' => '>='
		)
	);	
}
else if (!empty($_GET['ct_lotsize_to'])) {               
	$ct_lotsize_to = str_replace(',', '', $_GET['ct_lotsize_to']);
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_lotsize',
			'value' => $ct_lotsize_to,
			'type' => 'NUMERIC',
			'compare' => '<='
		)
	);	
}

/*-----------------------------------------------------------------------------------*/
/* Check if pet friendly */
/*-----------------------------------------------------------------------------------*/ 
 
if (!empty($_GET['pet_friendly'])) {
	$pet_friendly = $_GET['pet_friendly'];
	$search_values['meta_query'] = array(
		array(
			'key' => 'pet_friendly',
			'value' => $pet_friendly,
			'type' => 'char',
			'compare' => '='
		)
	);	
}

/*-----------------------------------------------------------------------------------*/
/* Check to see if reference number matches */
/*-----------------------------------------------------------------------------------*/ 
 
if (!empty($_GET['ct_mls'])) {
	$ct_mls = $_GET['ct_mls'];
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_mls',
			'value' => $ct_mls,
			'type' => 'char',
			'compare' => '='
		)
	);	
}

/*-----------------------------------------------------------------------------------*/
/* Check to see if number of guests matches */
/*-----------------------------------------------------------------------------------*/ 
 
if (!empty($_GET['ct_rental_guests'])) {
	$ct_rental_guests = $_GET['ct_rental_guests'];
	$search_values['meta_query'] = array(
		array(
			'key' => '_ct_rental_guests',
			'value' => $ct_rental_guests,
			'type' => 'num',
			'compare' => '<='
		)
	);	
}

global $wp_query;

/*-----------------------------------------------------------------------------------*/
/* Save the existing query */
/*-----------------------------------------------------------------------------------*/ 

$existing_query_obj = $wp_query;

$wp_query = new WP_Query( $search_values ); 
$total_results = $wp_query->found_posts;
unset($search_values['post_type']);
unset($search_values['paged']);
unset($search_values['showposts']);   

/*-----------------------------------------------------------------------------------*/
/* Prepare the title string by looping through all
/* the values we're going to query and put them together
/*-----------------------------------------------------------------------------------*/                             

$search_params = array(); 
$loop = 0;

foreach ($search_values as $t => $s) {                                  
	$term = get_term_by('slug',$s,$t);
	if($term != '0') {
		$search_params[] = $term->name;   
	}
}
$search_params[] = $_GET['ct_keyword'];
$search_params = implode(', ', $search_params);

get_header();

	do_action('before_listings_search_header');
	
	if($ct_header_listing_search != 'yes') {
		echo '<!-- Title Header -->';
	    echo '<header id="title-header" class="marB0">';
	        echo '<div class="container">';
	            /*echo '<h5 class="marT0 marB0 left">';
				echo esc_html($total_results);
				echo ' ';
				if($total_results != '1') { esc_html_e('listings found', 'contempo'); } else { esc_html_e('listing found', 'contempo'); }
				echo '</h5>';*/
				echo '<div class="muted right">';
					esc_html_e('Find A Home', 'contempo');
				echo '</div>';
			echo '<div class="clear"></div>';
	        echo '</div>';
	    echo '</header>';
	    echo '<!-- //Title Header -->';
	}

    if($ct_disable_listing_search_results_adv_search == 'no' &&  $ct_search_results_layout == 'sidebyside') {
    	echo '<!-- Searching On -->';
		echo '<div class="side-by-side searching-on ' . $ct_home_adv_search_style . '">';
			echo '<div class="container">';
				echo '<span class="searching">' . __('Searching:', 'contempo') . '</span>';
				if($search_params != "") {
					echo '<span class="search-params">' . $search_params . '</span>';
				} else { 
					echo '<span class="search-params">' . __('All listings', 'contempo') . '</span>';
				}
				echo '<span class="search-toggle"><span id="text-toggle">' . __('Open Search', 'contempo') . '</span><i class="fa fa-plus-square-o"></i></span>';
			echo '</div>';
		echo '</div>';
		echo '<!-- //Searching On -->';
	
		do_action('before_listings_adv_search');

		echo '<section class="side-by-side search-results advanced-search ' . $ct_home_adv_search_style . '">';
			echo '<div class="container">';
				get_template_part('/includes/advanced-search');
			echo '</div>';
		echo'</section>';
		echo '<div class="clear"></div>';
	}

    do_action('before_listings_search_map');
	
	// Start Search Results Map
	$wp_query = new wp_query( $search_values ); 
	// if( ($ct_options['ct_disable_google_maps_search'] == 'yes' && $wp_query->have_posts() )  || ( $ct_options['ct_disable_google_maps_search'] == 'no' && $search_params == "" ) || $ct_header_listing_search == 'yes' ) {
	// 	echo '<!-- Map -->';

	// 	if($ct_search_results_layout == 'sidebyside') {
	// 		echo '<div id="map-wrap" class="listings-results-map col span_6 side-map">';
	// 	} else {
	// 		echo '<div id="map-wrap" class="listings-results-map">';
	// 	}
		 
	// 		//wp_reset_postdata();
			
	// 		$search_values['post_type'] = 'listings';
	// 		$search_values['paged'] = ct_currentPage();
	// 		$search_values['showposts'] = $search_num;
	// 		$wp_query = new wp_query( $search_values ); 
	
	// 			ct_search_results_map();
		
	// 	// End Search Results Map
	// 	echo '</div>';
	// 	echo '<!-- //Map -->';
	// }

	if($ct_header_listing_search == 'yes') {
		echo '<!-- Title Header -->';
	    echo '<header id="title-header" class="marT0 marB0">';
	        echo '<div class="container">';
	            echo '<h5 class="marT0 marB0 left">';
				echo esc_html($total_results);
				echo ' ';
				if($total_results != '1') { esc_html_e('listings found', 'contempo'); } else { esc_html_e('listing found', 'contempo'); }
				echo '</h5>';
				echo '<div class="muted right">';
					esc_html_e('Find A Home', 'contempo');
				echo '</div>';
			echo '<div class="clear"></div>';
	        echo '</div>';
	    echo '</header>';
	    echo '<!-- //Title Header -->';

	    echo '<!-- Searching On -->';
				echo '<div class="searching-on ' . $ct_home_adv_search_style . '">';
					echo '<div class="container">';
						echo '<span class="searching">' . __('Searching:', 'contempo') . '</span>';
						if($search_params != "") {
							echo '<span class="search-params">' . $search_params . '</span>';
						} else { 
							echo '<span class="search-params">' . __('All listings', 'contempo') . '</span>';
						}
						//echo '<span class="map-toggle"><span id="text-toggle">' . __('Close Map', 'contempo') . '</span><i class="fa fa-minus-square-o"></i></span>';
						echo '</div>';
				echo '</div>';
				echo '<!-- //Searching On -->';
	}

	do_action('before_listings_searching_on');
	
	echo '<!-- Search Results -->';
		if($ct_disable_listing_search_results_adv_search == 'no' &&  $ct_search_results_layout == 'sidebyside') {
		echo '<div class="col span_6 side-results">';
		}
			if($ct_disable_listing_search_results_adv_search == 'no' &&  $ct_search_results_layout != 'sidebyside') {
				echo '<!-- Searching On -->';
				echo '<div class="searching-on ' . $ct_home_adv_search_style . '">';
					echo '<div class="container">';
						echo '<span class="searching">' . __('Searching:', 'contempo') . '</span>';
						if($search_params != "") {
							echo '<span class="search-params">' . $search_params . '</span>';
						} else { 
							echo '<span class="search-params">' . __('All listings', 'contempo') . '</span>';
						}
						// echo '<span class="map-toggle"><span id="text-toggle">' . __('Close Map', 'contempo') . '</span><i class="fa fa-minus-square-o"></i></span>';
						echo '</div>';
				echo '</div>';
				echo '<!-- //Searching On -->';
			
				do_action('before_listings_adv_search');

				echo '<section class="search-results advanced-search ' . $ct_home_adv_search_style . '">';
					echo '<div class="container">';
						get_template_part('/includes/advanced-search');
					echo '</div>';
				echo'</section>';
				echo '<div class="clear"></div>';
			}
			?>

			<?php do_action('before_listing_search_results'); ?>

			<div class="container">
				<!-- Listing Results -->
				<div id="listings-results" class="listing-search-results col span_12 first">

					<div class="col span_12 <?php if($ct_disable_listing_search_results_adv_search == 'yes') { echo 'marT30'; } ?>">
						<?php ct_sort_by(); ?>
					</div>

					<?php
	                
						// Reset Query for Listings
						wp_reset_query();
						wp_reset_postdata();

						$search_values['post_type'] = 'listings';
						$search_values['paged'] = ct_currentPage();
						$search_values['showposts'] = $search_num;
						$wp_query = new wp_query( $search_values ); 
						
						if($ct_search_results_listing_style == 'list') {
							get_template_part( 'layouts/list');
						} else {
							get_template_part( 'layouts/grid');
						}
					
				// End Listing Results
						echo '<div class="clear"></div>';
				echo '</div>';
				echo '<!-- Listing Results -->';

			// Restore WP_Query object
			$wp_query = $existing_query_obj;

			echo '<div class="clear"></div>';
		echo '</div>';
	if($ct_search_results_layout == 'sidebyside') {
	echo '</div>';
	}
	echo '<!-- //Search Results -->';

	do_action('after_listing_search_results');

get_footer(); ?>