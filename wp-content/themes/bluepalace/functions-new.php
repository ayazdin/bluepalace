<?php
/**
 * Functions
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

/*-----------------------------------------------------------------------------------*/
/* Define some constant paths */
/*-----------------------------------------------------------------------------------*/

define('ADMIN_PATH', get_template_directory() . '/admin/');
define('INC_PATH', get_template_directory() . '/includes/');

/*-----------------------------------------------------------------------------------*/
/* Load ReduxFramework */
/*-----------------------------------------------------------------------------------*/

require_once(ADMIN_PATH . 'ReduxFramework/redux-extensions-loader/loader.php');
require_once(ADMIN_PATH . 'ReduxFramework/ReduxCore/framework.php');
require_once(ADMIN_PATH . 'ReduxFramework/theme-options/re7-config.php');

/*-----------------------------------------------------------------------------------*/
/* Localization Support */
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('contempo', get_template_directory() . '/languages');
 
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";

if (is_readable($locale_file)) {
    require_once($locale_file);
}

add_action( 'admin_menu', 'fetchFeed' );

function fetchFeed() {
	add_options_page( 
		'Fetch Listings',
		'Fetch Listings',
		'manage_options',
		'get-properties',
		'get_properties'
	);
}

function get_properties()
{
	global $wpdb;
    
    $wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.post_excerpt = '1'");

    $xmldata = curl_get_file_contents('http://newroutes.co/demo/newroutes_sitefeed.php');
    $tempval = xml2array($xmldata);
    /*
    *   loop for extracting value at array[$i]
    */
    $simplifiedArray = array();
    foreach ($tempval as $key => $value) {
        foreach ($value as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                foreach ($value2 as $key3) {
                    array_push($simplifiedArray, $key3);
                }
            }
        }
    }//end of loop
    //insert data to database
    $iCount = 1;
    foreach ($simplifiedArray as $value5) {
    	print_r($value5);exit;
    	if($iCount<2)
    	{
	        $my_post = array();
	        $my_post = array(
	          'post_title'    => wp_strip_all_tags( $value5['title_en'] ),
	          'post_content'  => $value5['description_en'],
	          'post_status'   => 'publish',
	          'post_author'   => get_current_user_id(),
	          'post_excerpt'   => '1',
	          'post_type'   => 'listings'
	          );
	        $lastid = wp_insert_post($my_post);
	        //echo $lastid;// = $wpdb->insert_id;

	        if ( ! add_post_meta( $lastid, '_ct_price', $value5['price'], true ) ) { 
	            update_post_meta ( $lastid, '_ct_price', $value5['price'] );
	        }
	        
	        $tempImages = explode(',', $value5['images']);
	        $images = serialize($tempImage);
	        if ( ! add_post_meta( $lastid, '_ct_slider', $images, true ) ) { 
	            update_post_meta ( $lastid, '_ct_slider', $images );
	        }

	        if ( ! add_post_meta( $lastid, '_ct_reference', $value5['reference'], true ) ) { 
	            update_post_meta ( $lastid, '_ct_reference', $value5['reference'] );
	        }

	        if ( ! add_post_meta( $lastid, '_ct_sqft', $value5['sqft'], true ) ) { 
	            update_post_meta ( $lastid, '_ct_sqft', $value5['sqft'] );
	        }

	        if ( ! add_post_meta( $lastid, '_ct_video', $value5['youtube'], true ) ) { 
	            update_post_meta ( $lastid, '_ct_video', $value5['youtube'] );
	        }

	        if ( ! add_post_meta( $lastid, '_ct_latlng', $value5['latitude'].','.$value5['longitude'] , true ) ) { 
	            update_post_meta ( $lastid, '_ct_latlng', $value5['latitude'].','.$value5['longitude'] );
	        }
	        /*Taxonomies*/
	        //Insert Custom Taxonomies

	        wp_set_post_terms($lastid,array($value5['type']),'property_type',true);
	        wp_set_post_terms($lastid,array($value5['bedrooms']),'beds',true);
	        wp_set_post_terms($lastid,array($value5['bathrooms']),'baths',true);
	        wp_set_post_terms($lastid,array('featured'),'ct_status',true);
	        wp_set_post_terms($lastid,array($value5['city']),'city',true);
	        // wp_set_post_terms($lastid,array($_POST['customTaxState']),'state',false);
	        // wp_set_post_terms($lastid,array($_POST['customTaxZip']),'zipcode',false);
	        // wp_set_post_terms($lastid,array($_POST['customTaxCountry']),'country',false);
	        wp_set_post_terms($lastid,array($value5['community']),'community',true);
	        $iCount++;
	    }
	}
}

/*-----------------------------------------------------------------------------------*/
/* Framework Functions
/*-----------------------------------------------------------------------------------*/




add_filter( 'getMe', function() { return '<strong>This is a test</strong>'; } );



function ct_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}

/*
*   function to convert XML data to array
*/
function xml2array($contents, $get_attributes = 1, $priority = 'tag')
{
    if (!$contents) return array();

    if (!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!"; 
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if (!$xml_values) return;//Hmm...

    //Initializations 
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference 

    //Go through the tags. 
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
    foreach ($xml_values as $data) {
        unset($attributes, $value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope 
        // tag(string), type(string), level(int), attributes(array). 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = array();
        $attributes_data = array();

        if (isset($value)) {
            if ($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode 
        }

        //Set the attributes too. 
        if (isset($attributes) and $get_attributes) {
            foreach ($attributes as $attr => $val) {
                if ($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
            }
        }

        //See tag status and do the needed. 
        if ($type == "open") {//The starting of the tag '<tag>'
        $parent[$level - 1] = &$current;
            if (!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if ($attributes_data) $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name 

                if (isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag], $result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag . '_' . $level] = 2;

                    if (isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset($current[$tag . '_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif ($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken. 
            if (!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data) $current[$tag . '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array) 
                if (isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array. 
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;

                    if ($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;

                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag], $result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes) {
                        if (isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well

                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset($current[$tag . '_attr']);
                        }

                        if ($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }

        } elseif ($type == 'close') { //End of tag '</tag>'
        $current = &$parent[$level - 1];
    }
}

return ($xml_array);
} 

// OAuth
require_once (ADMIN_PATH . 'OAuth.php');

// Child Theme Creator
require_once (ADMIN_PATH . 'ct-child-theme/ct-child-theme.php');

// Custom Profile Fields
require_once (ADMIN_PATH . 'profile-fields.php');

// Plugin Activation
require_once (ADMIN_PATH . 'plugins/class-tgm-plugin-activation.php');
require_once (ADMIN_PATH . 'plugins/register.php');

// Aqua Resizer
require_once (ADMIN_PATH . 'aq-resizer/aq_resizer.php');

// Register Sidebars
require_once (ADMIN_PATH . 'sidebars.php');

// Theme Functions
require_once (ADMIN_PATH . 'theme-functions.php');

// Theme Hooks
require_once (ADMIN_PATH . 'theme-hooks.php');

// CT Social Widget
require_once (ADMIN_PATH . 'ct-social/ct-social.php');

// Widgets
require_once (INC_PATH . 'widgets.php');

?>