<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'ct_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/*-----------------------------------------------------------------------------------*/
/*
/* Custom Fields & Conditionals */
/*
/*-----------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/* Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter */
	/* @param  CMB2 object $cmb CMB2 object */
	/* @return bool True if metabox should show	*/
	/*------------------------------------------------------------------------------------------------------*/

	function ct_show_if_front_page( $cmb ) {
		// Don't show this metabox if it's not the front page template
		if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
			return false;
		}
		return true;
	}

	/*-----------------------------------------------------------------------------------*/
	/* Gets a number of posts and displays them as options */
	/* @param array $query_args Optional. Overrides defaults. */
	/*-----------------------------------------------------------------------------------*/

	function ct_get_post_options( $query_args ) {

	    $args = wp_parse_args( $query_args, array(
	        'post_type'   => 'post',
	        'numberposts' => 10,
	    ) );

	    $posts = get_posts( $args );

	    $post_options = array();
	    $post_options[] = __('Choose a Brokerage', 'contempo');
	    if ( $posts ) {
	        foreach ( $posts as $post ) {
	          $post_options[ $post->ID ] = $post->post_title;
	        }
	    }

	    return $post_options;
	}

	/**
	 * Get all brokerage posts
	 * @return array An array of options that matches the CMB2 options array
	 */
	function ct_get_custom_post_type_options() {
	    return ct_get_post_options( array( 'post_type' => 'brokerage', 'numberposts' => -1 ) );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Gets all users that are agents and displays them as options */
	/*-----------------------------------------------------------------------------------*/

	function ct_get_user_options() {

		$args = array(
			'order'		 => 'DESC',
			'orderby'	 => 'display_name',
		);

	    $wp_user_query = new WP_User_Query($args);

	    $users = $wp_user_query->get_results();

	    $get_users = array();
	    if ($users) {
		    foreach ($users as $user) {
		        $user_info = get_userdata($user->ID);
		        if($user_info->isagent == 'yes') {
			        $get_users[ $user_info->ID ] = $user_info->first_name . ' ' . $user_info->last_name;
			    }
		    }
		}

	    return $get_users;
	}

	/*------------------------------------------------------------------------------------------------------*/
	/* Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter */
	/* @param  CMB2_Field object $field Field object */
	/* @return bool True if metabox should show */
	/*------------------------------------------------------------------------------------------------------*/

	function ct_hide_if_no_cats( $field ) {
		// Don't show this field if not in the cats category
		if ( ! has_tag( 'cats', $field->object_id ) ) {
			return false;
		}
		return true;
	}

/*-----------------------------------------------------------------------------------*/
/*
/* Register Metaboxes */
/*
/*-----------------------------------------------------------------------------------*/

	/*-----------------------------------------------------------------------------------*/
	/* Slider Images Metabox for Listings */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_slider_images_metabox' );

	function ct_register_slider_images_metabox() {

		$prefix = '_ct_';

		/**
		 * Slider Images Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'sliderimages',
			'title'         => __( 'Slider Images', 'contempo' ),
			'object_types'  => array( 'listings', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
			'name'         => __( 'Slider Images', 'contempo' ),
			'desc'         => __( 'Upload all your slider images here, drag and drop to reorder.', 'contempo' ),
			'id'           => $prefix . 'slider',
			'type'         => 'file_list',
			'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Brokerage Metabox for Listings */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_brokerage_metabox' );

	function ct_register_brokerage_metabox() {

		$prefix = '_ct_';

		/**
		 * Broker Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'brokerage',
			'title'         => __( 'Brokerage', 'contempo' ),
			'object_types'  => array( 'listings', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'default',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Brokerage', 'contempo' ),
		    'desc'       => __( 'If the listing agent is affiliated with a brokerage you can select that here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage',
		    'type'       => 'select',
		    'options_cb' => 'ct_get_custom_post_type_options',
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Multi-floor Plans Metabox for Listings */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_repeatable_group_field_metabox' );

	function ct_register_repeatable_group_field_metabox() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = '_ct_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Multi-floor Plans', 'cmb2' ),
			'object_types' => array( 'listings', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'multiplan',
			'type'        => 'group',
			'description' => __( 'Use this area to add multiple floor plans to your listing along with pricing and descriptions. <strong>NOTE:</strong> Make sure you also go into Real Estate 7 Options > Listings > Enable Multi-Floorplan & Pricing Fields? > Select Yes <a href="http://cl.ly/3F3y1t1V2Z0u">screenshot</a>, otherwise the floor plans will not be shown.', 'contempo' ),
			'options'     => array(
				'group_title'   => __( 'Floor Plan {#}', 'contempo' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Floor Plan', 'contempo' ),
				'remove_button' => __( 'Remove Floor Plan', 'contempo' ),
				'sortable'      => true, // beta
				'closed'     => true, // true to have the groups closed by default
			),
		) );

		/**
		 * Group fields works the same, except ids only need
		 * to be unique to the group. Prefix is not needed.
		 *
		 * The parent field's id needs to be passed as the first argument.
		 */
		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Title', 'contempo' ),
			'id'         => $prefix . 'plan_title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Beds', 'contempo' ),
			'id'         => $prefix . 'plan_beds',
			'type'       => 'text_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Baths', 'contempo' ),
			'id'         => $prefix . 'plan_baths',
			'type'       => 'text_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Sq Ft or Sq Meters', 'contempo' ),
			'id'         => $prefix . 'plan_size',
			'type'       => 'text_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Price', 'contempo' ),
			'id'         => $prefix . 'plan_price',
			'type'       => 'text_currency',
			'description' => 'Can be a single price or a range, e.g. 1875-2395',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Availability', 'contempo' ),
			'description' => __( 'Add the availability here, e.g. (Available, Call for Availability)', 'contempo' ),
			'id'          => $prefix . 'plan_availability',
			'type'        => 'text',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Floor Plan Image', 'contempo' ),
			'id'   => $prefix . 'plan_image',
			'type' => 'file',
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Brokerage Info Metabox for Brokerages */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_brokerage_info_metabox' );

	function ct_register_brokerage_info_metabox() {

		$prefix = '_ct_';

		/**
		 * Broker Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'brokerage_contact_info',
			'title'         => __( 'Contact Info', 'contempo' ),
			'object_types'  => array( 'brokerage', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Phone', 'contempo' ),
		    'desc'       => __( 'Enter the office phone number here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_phone',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Fax', 'contempo' ),
		    'desc'       => __( 'Enter the office fax number here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_fax',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Email', 'contempo' ),
		    'desc'       => __( 'Enter the office email here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_email',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Street Address', 'contempo' ),
		    'desc'       => __( 'Enter the office street address here e.g. (101 Front Street)', 'contempo' ),
		    'id'         => $prefix . 'brokerage_street_address',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Address Two', 'contempo' ),
		    'desc'       => __( 'Address two, e.g. (Suite 100)', 'contempo' ),
		    'id'         => $prefix . 'brokerage_address_two',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'City', 'contempo' ),
		    'desc'       => __( 'Enter the office city here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_city',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'State or Area', 'contempo' ),
		    'desc'       => __( 'Enter the office state or area here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_state',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Zipcode, Postcode or Postal Code', 'contempo' ),
		    'desc'       => __( 'Enter the office zipcode, postcode or postal code here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_zip',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Country', 'contempo' ),
		    'desc'       => __( 'Enter the office country here (optional).', 'contempo' ),
		    'id'         => $prefix . 'brokerage_country',
		    'type'       => 'text',
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Brokerage Info Metabox for Brokerages */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_brokerage_social_metabox' );

	function ct_register_brokerage_social_metabox() {

		$prefix = '_ct_';

		/**
		 * Broker Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'brokerage_social_info',
			'title'         => __( 'Social Info', 'contempo' ),
			'object_types'  => array( 'brokerage', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Twitter', 'contempo' ),
		    'desc'       => __( 'Enter the office Twitter URL here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_twitter',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Facebook', 'contempo' ),
		    'desc'       => __( 'Enter the office Facebook URL here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_facebook',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'LinkedIn', 'contempo' ),
		    'desc'       => __( 'Enter the office LinkedIn URL here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_linkedin',
		    'type'       => 'text',
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Google+', 'contempo' ),
		    'desc'       => __( 'Enter the office Google+ URL here.', 'contempo' ),
		    'id'         => $prefix . 'brokerage_gplus',
		    'type'       => 'text',
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Brokerage Agents Metabox for Brokerages */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_brokerage_agents_metabox' );

	function ct_register_brokerage_agents_metabox() {

		$prefix = '_ct_';

		/**
		 * Broker Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'brokerage_agents',
			'title'         => __( 'Agents', 'contempo' ),
			'object_types'  => array( 'brokerage', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Agents', 'contempo' ),
		    'desc'       => __( 'Assign agents to this brokerage here.', 'contempo' ),
		    'id'         => $prefix . 'agents',
		    'type'       => 'multicheck',
		    'options_cb' => 'ct_get_user_options',
		) );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Expire Metabox for Listings */
	/*-----------------------------------------------------------------------------------*/

	add_action( 'cmb2_admin_init', 'ct_register_listing_expire_metabox' );

	function ct_register_listing_expire_metabox() {

		$prefix = '_ct_';

		/**
		 * Listing Expire Meta Box
		 */
		$ct_post_cmb = new_cmb2_box( array(
			'id'            => $prefix . 'expire_listing',
			'title'         => __( 'Listing Expire Time', 'contempo' ),
			'object_types'  => array( 'listings', ), // Post type
			// 'show_on_cb' => 'ct_show_if_front_page', // function should return a bool value
			'context'    => 'normal',
			'priority'   => 'low',
			'show_names' => false, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			'closed'     => true, // true to keep the metabox closed by default
		) );

		$ct_post_cmb->add_field( array(
		    'name'       => __( 'Days', 'contempo' ),
		    'desc'       => __( 'The amount of days the listing will be shown.', 'contempo' ),
		    'id'         => $prefix . 'listing_expire',
		    'type'       => 'text',
		) );

	}