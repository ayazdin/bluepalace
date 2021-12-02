<?php

/**
 * Custom Fields
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Real Estate Custom Posts
 * @subpackage ct-real-estate-custom-posts/includes
 */

// Include & setup custom metabox and fields
$prefix = '_ct_'; // start with an underscore to hide fields from custom fields list
add_filter( 'cmb_meta_boxes', 'ct_real_estate_metaboxes' );
function ct_real_estate_metaboxes( $meta_boxes ) {
	global $prefix;

	$meta_boxes[] = array(
		'id' => 'post_options_metabox',
		'title' => __('Post Options', 'contempo'),
		'pages' => array('post','galleries'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Header', 'contempo'),
				'desc' => __('Display Post Header?', 'contempo'),
				'id' => $prefix . 'post_header',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
				'name' => __('Title', 'contempo'),
				'desc' => __('Display Post Title?', 'contempo'),
				'id' => $prefix . 'post_title',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
				'name' => __('Sub Title', 'contempo'),
				'desc' => __('Enter the sub title here, if you\'d like to use one.', 'contempo'),
				'id' => $prefix . 'sub_title',
				'type' => 'text'
			),
			array(
				'name' => __('Post Header Background Image', 'contempo'),
				'desc' => __('Use Featured Image as Header Background?', 'contempo'),
				'id' => $prefix . 'post_header_bg',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
			array(
			    'name' => __('Post Header Background Color', 'contempo'),
			    'desc' => __('If you don\'t have a featured post image, you can specify a custom bg color for your header here.)', 'contempo'),
			    'id'   => $prefix . '_post_header_bg_color',
			    'type' => 'colorpicker',
			    'default'  => '',
			    'repeatable' => false,
			),
			array(
				'name' => __('Automatic Slider', 'contempo'),
				'desc' => __('Display automatic slider if more than one image is uploaded to a post on archive &amp; category pages?', 'contempo'),
				'id' => $prefix . 'post_slider',
				'type' => 'select',
				'options' => array(
					array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),			
				)
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'listing_info',
		'title' => __('Listing Info', 'contempo'),
		'pages' => array('listings'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
					'name' => __('Listing Alternate Title', 'contempo'),
					'desc' => __('Enter the listing alternate title here replaces street address, e.g. Downtown Penthouse.', 'contempo'),
					'id' => $prefix . 'listing_alt_title',
					'type' => 'text_medium'
				),
			array(
				'name' => __('Price Prefix Text', 'contempo'),
				'desc' => __('Enter the price prefix text here, e.g. (From, Call for price, Price on ask).', 'contempo'),
				'id' => $prefix . 'price_prefix',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Price', 'contempo'),
				'desc' => __('Enter the price here, without commas or seperators. If empty no price will be shown.', 'contempo'),
				'id' => $prefix . 'price',
				'type' => 'text_money'
			),
			array(
				'name' => __('Price Postfix Text', 'contempo'),
				'desc' => __('Enter the price postfix text here, e.g. (/month, /week, /per night).', 'contempo'),
				'id' => $prefix . 'price_postfix',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Sq Ft', 'contempo'),
				'desc' => __('Enter the sq ft or sq meters here.', 'contempo'),
				'id' => $prefix . 'sqft',
				'type' => 'text_small'
			),
			array(
				'name' => __('Lot Size', 'contempo'),
				'desc' => __('Enter the lot size here.', 'contempo'),
				'id' => $prefix . 'lotsize',
				'type' => 'text_small'
			),
			array(
				'name' => __('Property ID', 'contempo'),
				'desc' => __('Enter the property ID here, e.g. 5648973', 'contempo'),
				'id' => $prefix . 'mls',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Latitude &amp; Longitude', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Only use the latitude and longitude if the regular full address can\'t be found. (ex: 37.4419, -122.1419)', 'contempo'),
				'id' => $prefix . 'latlng',
				'type' => 'text_medium'
			),
			/*not themes*/

			array(
				'name' => __('Purpose', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Purpose (either sale or rent)', 'contempo'),
				'id' => $prefix . 'purpose',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Building', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Building', 'contempo'),
				'id' => $prefix . 'building',
				'type' => 'text_medium'
			),
			array(
				'name' => __('View', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> View', 'contempo'),
				'id' => $prefix . 'view',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Parking', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Parking', 'contempo'),
				'id' => $prefix . 'parking',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Category', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Category', 'contempo'),
				'id' => $prefix . 'category',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Amenities', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Amenities', 'contempo'),
				'id' => $prefix . 'amenities',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Floorimages', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Floorimages', 'contempo'),
				'id' => $prefix . 'floorimages',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Agent Name', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Agent Name', 'contempo'),
				'id' => $prefix . 'agent_name',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Agent Number', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Agent Number', 'contempo'),
				'id' => $prefix . 'agent_number',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Agent Agent Email', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Agent Agent Email', 'contempo'),
				'id' => $prefix . 'agent_agent_email',
				'type' => 'text_medium'
			),
			array(
				'name' => __('App Price', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> App Price', 'contempo'),
				'id' => $prefix . 'app_price',
				'type' => 'text_medium'
			),
			array(
				'name' => __('Location Type', 'contempo'),
				'desc' => __('<strong>OPTIONAL:</strong> Location Type', 'contempo'),
				'id' => $prefix . 'location_type',
				'type' => 'text_medium'
			),
			/*not themes*/
			array(
				'name' => __('Owner/Agent Notes', 'contempo'),
				'desc' => __('Owner/Agent Notes (*not visible on front end).', 'contempo'),
				'id' => $prefix . 'ownernotes',
				'type' => 'textarea_small'
			),
		)
	);

	global $ct_options;
	$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';

    if($ct_rentals_booking == 'yes') {
		$meta_boxes[] = array(
			'id' => 'rental_metabox',
			'title' => __('Rental Info', 'contempo'),
			'pages' => array('listings'), // post type
			'context' => 'normal',
			'priority' => 'default',
			'show_names' => false, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('Booking Calendar Shortcode', 'contempo'),
					'desc' => __('Paste your booking calendar shortcode here, e.g. [booking nummonths=1].', 'contempo'),
					'id' => $prefix . 'booking_cal_shortcode',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Listing Title', 'contempo'),
					'desc' => __('Enter the listing title here, e.g. Villa in Bali.', 'contempo'),
					'id' => $prefix . 'rental_title',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Guests', 'contempo'),
					'desc' => __('Enter the max-number of guests here, e.g. 2.', 'contempo'),
					'id' => $prefix . 'rental_guests',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Availability', 'contempo'),
					'desc' => __('Enter minimum stay, e.g. 1 night.', 'contempo'),
					'id' => $prefix . 'rental_min_stay',
					'type' => 'text_medium'
				),
				array(
					'name' => __('Check In Time', 'contempo'),
					'desc' => __('Enter check in time.', 'contempo'),
					'id' => $prefix . 'rental_checkin',
					'type' => 'text_time'
				),
				array(
					'name' => __('Check Out Time', 'contempo'),
					'desc' => __('Enter check out time.', 'contempo'),
					'id' => $prefix . 'rental_checkout',
					'type' => 'text_time'
				),
				array(
					'name' => __('Extra People Charge', 'contempo'),
					'desc' => __('Enter extra per person charge, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_extra_people',
					'type' => 'text_money'
				),
				array(
					'name' => __('Cleaning Fee', 'contempo'),
					'desc' => __('Enter cleaning fee, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_cleaning',
					'type' => 'text_money'
				),
				array(
					'name' => __('Cancellation Fee', 'contempo'),
					'desc' => __('Enter cancellation fee, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_cancellation',
					'type' => 'text_money'
				),
				array(
					'name' => __('Security Deposit', 'contempo'),
					'desc' => __('Enter the security deposit, without commas or seperators.', 'contempo'),
					'id' => $prefix . 'rental_deposit',
					'type' => 'text_money'
				),
			)
		);
	}

	$meta_boxes[] = array(
		'id' => 'featured_order',
		'title' => __('Homepage Featured Listing Order', 'contempo'),
		'pages' => array('listings'), // post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
					'name' => __('Homepage Featured Listing Order', 'contempo'),
					'desc' => __('If you\'ve marked this listing as Featured under Status you can select the order you would like them displayed on the homepage, e.g. 1, 2, 3, etc&hellip;NOTE: You must also set Real Estate 7 Options > Homepage > Featured Listings > Manually Order Featured Listings? > to Yes, otherwise the ordering won\'t be applied.', 'contempo'),
					'id' => $prefix . 'listing_home_feat_order',
					'type' => 'text_medium'
				),
		)
	);

	$meta_boxes[] = array(
		'id' => 'files',
		'title' => __('Files & Documents', 'contempo'),
		'pages' => array('listings'), // post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Files & Documents', 'contempo'),
				'desc' => __('Supported file types are PDF, Word, Excel & PowerPoint.<br />NOTE: The files need to be uploaded/attached to this listing in order for them to show on the frontend.', 'contempo'),
				'id' => $prefix . 'files',
				'type' => 'file_list'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'page_metabox',
		'title' => __('Page Options', 'contempo'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
            array(
                'name' => __('Display Page Title?', 'contempo'),
                'desc' => __('Select whether or not you\'d like to display the page title?', 'contempo'),
                'id' => $prefix . 'inner_page_title',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
            array(
                'name' => __('Sub Title', 'contempo'),
                'desc' => __('Enter the sub title here, if you\'d like to use one.', 'contempo'),
                'id' => $prefix . 'page_sub_title',
                'type' => 'text'
            ),
            array(
                'name' => __('Page Header Background Image', 'contempo'),
                'desc' => __('Add a background image for your page header.', 'contempo'),
                'id' => $prefix . 'page_header_bg_image',
                'type' => 'file'
            ),
            array(
                'name' => __('Top Page Margin?', 'contempo'),
                'desc' => __('Select whether or not you\'d like the top page margin to seperate the header and content area?', 'contempo'),
                'id' => $prefix . 'top_page_margin',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
            array(
                'name' => __('Bottom Page Margin?', 'contempo'),
                'desc' => __('Select whether or not you\'d like the top page margin to seperate the content area and footer?', 'contempo'),
                'id' => $prefix . 'bottom_page_margin',
                'type' => 'select',
                'options' => array(
                    array('name' => __('Yes', 'contempo'), 'value' => 'Yes'),
					array('name' => __('No', 'contempo'), 'value' => 'No'),	               
                )
            ),
		)
	);

	$meta_boxes[] = array(
		'id' => 'video_metabox',
		'title' => __('Video', 'contempo'),
		'pages' => array('post','listings'), // post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Video', 'contempo'),
				'desc' => __('Paste your video url here, supports YouTube, Vimeo.', 'contempo'),
				'id' => $prefix . 'video',
				'type' => 'text_medium'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'virtualtour_metabox',
		'title' => __('Virtual Tour', 'contempo'),
		'pages' => array('post','listings'), // post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Virtual Tour', 'contempo'),
				'desc' => __('Paste your virtual tour embed code here.', 'contempo'),
				'id' => $prefix . 'virtual_tour',
				'type' => 'textarea_code'
			),
		)
	);

	global $ct_options;
	$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';

	if($ct_enable_front_end_paid == 'yes') {
		$meta_boxes[] = array(
			'id' => 'listing_paid_submission_info',
			'title' => __('Paid Submission Information', 'contempo'),
			'pages' => array('listings'), // post type
			'context' => 'normal',
			'priority' => 'default',
			'show_names' => false, // Show field names on the left
			'fields' => array(
				array(
						'name' => __('Transaction ID', 'contempo'),
						'desc' => __('Transaction ID', 'contempo'),
						'id' => $prefix . 'listing_paid_transaction_id',
						'type' => 'text_medium'
				),
			)
		);
	}
	
	return $meta_boxes;
}

// Initialize the metabox class
add_action( 'init', 'ct_real_estate_initialize_cmb_meta_boxes', 9999 );
function ct_real_estate_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once (plugin_dir_path( __FILE__ ) . 'init.php');
	}
}