<?php
/**
 * Theme Hooks
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

/*-----------------------------------------------------------------------------------*/
/* Header - header.php */
/*-----------------------------------------------------------------------------------*/

function ct_after_body() {
	// Your Code Here
}
add_action('after_body', 'ct_after_body');

function ct_before_wrapper() {
	// Your Code Here
}
add_action('before_wrapper', 'ct_after_body');

function ct_before_top_bar() {
	// Your Code Here
}
add_action('before_top_bar', 'ct_before_top_bar');

function ct_before_header() {
	// Your Code Here
}
add_action('before_header', 'ct_before_header');

function ct_before_main_content() {
	// Your Code Here
}
add_action('before_main_content', 'ct_before_main_content');

/*-----------------------------------------------------------------------------------*/
/* Footer - footer.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_footer_widgets() {
	// Your Code Here
}
add_action('before_footer_widgets', 'ct_before_footer_widgets');

function ct_before_footer() {
	// Your Code Here
}
add_action('before_footer', 'ct_before_footer');

function ct_after_wrapper() {
	// Your Code Here
}
add_action('after_wrapper', 'ct_after_wrapper');

/*-----------------------------------------------------------------------------------*/
/* Sidebar - sidebar.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_sidebar() {
	// Your Code Here
}
add_action('before_sidebar', 'ct_before_sidebar');

function ct_after_sidebar() {
	// Your Code Here
}
add_action('after_sidebar', 'ct_after_sidebar');

/*-----------------------------------------------------------------------------------*/
/* Search Listings - search-listings.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_listings_search_header() {
	// Your Code Here
}
add_action('before_listings_search_header', 'ct_before_listings_search_header');

function ct_before_listings_search_map() {
	// Your Code Here
}
add_action('before_listings_search_map', 'ct_before_listings_search_map');

function ct_before_listings_searching_on() {
	// Your Code Here
}
add_action('before_listings_searching_on', 'ct_before_listings_searching_on');

function ct_before_listings_adv_search() {
	// Your Code Here
}
add_action('before_listings_adv_search', 'ct_before_listings_adv_search');

function ct_before_listing_search_results() {
	// Your Code Here
}
add_action('before_listing_search_results', 'ct_before_listing_search_results');

function ct_after_listing_search_results() {
	// Your Code Here
}
add_action('after_listing_search_results', 'ct_after_listing_search_results');

/*-----------------------------------------------------------------------------------*/
/* Single Listing - single-listings.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_single_listing_header() {
	// Your Code Here
}
add_action('before_single_listing_header', 'ct_before_single_listing_header');

function ct_before_single_listing_content() {
	// Your Code Here
}
add_action('before_single_listing_content', 'ct_before_single_listing_content');

function ct_before_single_listing_location() {
	// Your Code Here
}
add_action('before_single_listing_location', 'ct_before_single_listing_location');

function ct_before_single_ct_listing_price() {
	// Your Code Here
}
add_action('before_single_ct_listing_price', 'ct_before_single_ct_listing_price');

function ct_before_single_listing_lead_media() {
	// Your Code Here
}
add_action('before_single_listing_lead_media', 'ct_before_single_listing_lead_media');

function ct_before_single_listing_featlist() {
	// Your Code Here
}
add_action('before_single_listing_featlist', 'ct_before_single_listing_featlist');

function ct_before_single_listing_attachments() {
	// Your Code Here
}
add_action('before_single_listing_attachments', 'ct_before_single_listing_attachments');

function ct_before_single_listing_video() {
	// Your Code Here
}
add_action('before_single_listing_video', 'ct_before_single_listing_video');

function ct_before_single_listing_map() {
	// Your Code Here
}
add_action('before_single_listing_map', 'ct_before_single_listing_map');

function ct_before_single_listing_agent() {
	// Your Code Here
}
add_action('before_single_listing_agent', 'ct_before_single_listing_agent');

function ct_before_single_listing_agent_img() {
	// Your Code Here
}
add_action('before_single_listing_agent_img', 'ct_before_single_listing_agent_img');

function ct_before_single_listing_agent_details() {
	// Your Code Here
}
add_action('before_single_listing_agent_details', 'ct_before_single_listing_agent_details');

function ct_before_single_listing_agent_contact() {
	// Your Code Here
}
add_action('before_single_listing_agent_contact', 'ct_before_single_listing_agent_contact');

function ct_before_single_listing_community() {
	// Your Code Here
}
add_action('before_single_listing_community', 'ct_before_single_listing_community');

function ct_before_single_listing_sidebar() {
	// Your Code Here
}
add_action('before_single_listing_sidebar', 'ct_before_single_listing_sidebar');

function ct_after_single_listing_sidebar() {
	// Your Code Here
}
add_action('after_single_listing_sidebar', 'ct_after_single_listing_sidebar');

/*-----------------------------------------------------------------------------------*/
/* Listing Grid - layouts/grid.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_listing_grid_img() {
	// Your Code Here
}
add_action('before_listing_grid_img', 'ct_before_listing_grid_img');

function ct_before_listing_grid_info() {
	// Your Code Here
}
add_action('before_listing_grid_info', 'ct_before_listing_grid_info');

function ct_before_listing_grid_price() {
	// Your Code Here
}
add_action('before_listing_grid_price', 'ct_before_listing_grid_price');

function ct_before_listing_grid_propinfo() {
	// Your Code Here
}
add_action('before_listing_grid_propinfo', 'ct_before_listing_grid_propinfo');

function ct_after_listing_grid_info() {
	// Your Code Here
}
add_action('after_listing_grid_info', 'ct_after_listing_grid_info');

/*-----------------------------------------------------------------------------------*/
/* Listing Grid - layouts/blog-large.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_post_header() {
	// Your Code Here
}
add_action('before_post_header', 'ct_before_post_header');

function ct_before_post_lead_media() {
	// Your Code Here
}
add_action('before_post_lead_media', 'ct_before_post_lead_media');

function ct_before_post_excerpt() {
	// Your Code Here
}
add_action('before_post_excerpt', 'ct_before_post_excerpt');

function ct_after_post_excerpt() {
	// Your Code Here
}
add_action('after_post_excerpt', 'ct_after_post_excerpt');

/*-----------------------------------------------------------------------------------*/
/* Single Post - single.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_single_header() {
	// Your Code Here
}
add_action('before_single_header', 'ct_before_single_header');

function ct_before_single_content() {
	// Your Code Here
}
add_action('before_single_content', 'ct_before_single_content');

function ct_before_single_sidebar() {
	// Your Code Here
}
add_action('before_single_sidebar', 'ct_before_single_sidebar');

function ct_after_single_sidebar() {
	// Your Code Here
}
add_action('after_single_sidebar', 'ct_after_single_sidebar');

/*-----------------------------------------------------------------------------------*/
/* Page - page.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_page_header() {
	// Your Code Here
}
add_action('before_page_header', 'ct_before_page_header');

function ct_before_page_content() {
	// Your Code Here
}
add_action('before_page_content', 'ct_before_page_content');

function ct_before_page_sidebar() {
	// Your Code Here
}
add_action('before_page_sidebar', 'ct_before_page_sidebar');

function ct_after_page_sidebar() {
	// Your Code Here
}
add_action('after_page_sidebar', 'ct_after_page_sidebar');

/*-----------------------------------------------------------------------------------*/
/* Archive - archive.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_archive_header() {
	// Your Code Here
}
add_action('before_archive_header', 'ct_before_archive_header');

function ct_before_archive_content() {
	// Your Code Here
}
add_action('before_archive_content', 'ct_before_archive_content');

function ct_before_archive_sidebar() {
	// Your Code Here
}
add_action('before_archive_sidebar', 'ct_before_archive_sidebar');

function ct_after_archive_sidebar() {
	// Your Code Here
}
add_action('after_archive_sidebar', 'ct_after_archive_sidebar');

/*-----------------------------------------------------------------------------------*/
/* Agent - author.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_agent_header() {
	// Your Code Here
}
add_action('before_agent_header', 'ct_before_agent_header');

function ct_before_agent_content() {
	// Your Code Here
}
add_action('before_agent_content', 'ct_before_agent_content');

function ct_before_agent_listings() {
	// Your Code Here
}
add_action('before_agent_listings', 'ct_before_agent_listings');

function ct_after_agent_listings() {
	// Your Code Here
}
add_action('after_agent_listings', 'ct_after_agent_listings');

/*-----------------------------------------------------------------------------------*/
/* Comments - comments.php */
/*-----------------------------------------------------------------------------------*/

function ct_before_post_comments() {
	// Your Code Here
}
add_action('before_post_comments', 'ct_before_post_comments');

function ct_after_post_comments() {
	// Your Code Here
}
add_action('after_post_comments', 'ct_after_post_comments');

?>