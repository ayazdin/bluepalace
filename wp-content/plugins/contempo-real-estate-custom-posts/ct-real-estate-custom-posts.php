<?php

/**
 *
 * @link              http://contempographicdesign.com
 * @since             1.4.8
 * @package           CT_Real_Estate_Custom_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Contempo Real Estate Custom Posts
 * Plugin URI:        http://wordpress.org/contempo-real-estate-custom-posts/
 * Description:       This plugin registers listings & testimonials custom post types, along with related custom fields & taxonomies.
 * Version:           1.4.8
 * Author:            Contempo
 * Author URI:        http://contempographicdesign.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contempo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*-----------------------------------------------------------------------------------*/
/* Load Plugin Textdomain */
/*-----------------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'ct_recp_load_textdomain' );

function ct_recp_load_textdomain() {
  load_plugin_textdomain( 'contempo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

/*-----------------------------------------------------------------------------------*/
/* Load Metaboxes, CPT, Shortcodes, Taxonomies */
/*-----------------------------------------------------------------------------------*/

$theme = wp_get_theme(); // gets the current theme
if ($theme->name != 'WP Pro Real Estate 6' && $theme->name != 'WP Pro Real Estate 5') {

	/*-----------------------------------------------------------------------------------*/
	/* Load ReduxFramework */
	/*-----------------------------------------------------------------------------------*/

	require plugin_dir_path( __FILE__ ) . 'ct-real-estate-cmb2-functions.php';
	
	if ( ! function_exists( 'ct_metaboxes' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/metabox/metaboxes.php';
	}
	//require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-functions.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-post-types.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-shortcodes.php';
	require plugin_dir_path( __FILE__ ) . 'includes/ct-real-estate-custom-taxonomies.php';
	//require plugin_dir_path( __FILE__ ) . 'includes/class-ct-real-estate-custom-posts-i18n.php';

} else {

	function ct_admin_notices() {
		global $current_user;
		$user_id = $current_user->ID;
		
		if ( ! get_user_meta($user_id, 'ct_install_nag_ignore') ) {
			echo '<div class="updated notice is-dismissible">';
		        _e('<h3><strong>You currently have the incorrect real estate custom posts plugin installed/activated!</strong></h3>', 'contempo');
		        echo '<ol>';
			        echo '<li>You need to Deactivate and Delete <a href="' . site_url() . '/wp-admin/plugins.php">Contempo Real Estate Custom Posts</a>.';
			        echo '<li>Then Install and Activate <a href="' .site_url() . '/wp-admin/themes.php?page=install-required-plugins">CT Real Estate Custom Posts</a>.</li>';
			        echo '<li>Once you\'ve done that you\'ll be good to go!</li>';
		        echo '</ol>';
	        echo '</div>';
		}
	}
	add_action( 'admin_notices', 'ct_admin_notices' );
}

?>