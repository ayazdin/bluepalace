<?php
/**
 * Functions
 *
 * @package Royal Oasis
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

/*-----------------------------------------------------------------------------------*/
/* Framework Functions
/*-----------------------------------------------------------------------------------*/

function ct_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
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

//Excel importer
require_once (ADMIN_PATH . 'excel-importer.php');
//Location importer
require_once (ADMIN_PATH . 'location-importer.php');

// Theme Hooks
require_once (ADMIN_PATH . 'theme-hooks.php');

// CT Social Widget
require_once (ADMIN_PATH . 'ct-social/ct-social.php');

// Widgets
require_once (INC_PATH . 'widgets.php');

//add_action( 'admin_menu', 'fetchFeed' );

/*function fetchFeed() {
    add_options_page(
        'Fetch Listings',
        'Fetch Listings',
        'manage_options',
        'get-properties',
        'get_properties'
    );
}*/

function get_properties()
{
    global $wpdb;
    echo 'success';

    $wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
    $wpdb->query("delete t from rs_term_relationships t join rs_posts p on t.object_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
    $wpdb->query("ALTER TABLE rs_posts AUTO_INCREMENT = 1500");
    $wpdb->query("ALTER TABLE rs_postmeta AUTO_INCREMENT = 1500");
    $wpdb->query("ALTER TABLE rs_term_relationships AUTO_INCREMENT = 1500");
    $xmldata = curl_get_file_contents('http://newroutesrealestate.com/sitefeed.php');
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

    foreach ($simplifiedArray as $value5) {
        // echo "<pre>";print_r($value5);echo "</pre>";exit;
        $my_post = array();
        $my_post = array(
            'post_title'    => wp_strip_all_tags( $value5['title_en'] ),
            'post_content'  => $value5['description_en'],
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'menu_order'   => '786',
            'post_type'   => 'listings'
        );

        //echo "<pre>";print_r($my_post);echo "</pre>";
        $lastid = wp_insert_post($my_post);
        //echo $lastid;// = $wpdb->insert_id;

        if ( ! add_post_meta( $lastid, '_ct_price', $value5['price'], true ) ) {
            update_post_meta ( $lastid, '_ct_price', $value5['price'] );
        }

        $tempImages = explode(',', $value5['images']);
        $images = serialize($tempImages);
        if ( ! add_post_meta( $lastid, '_ct_slider', $images, true ) ) {
            update_post_meta ( $lastid, '_ct_slider', $images );
        }

        if ( ! add_post_meta( $lastid, '_ct_reference', $value5['reference'], true ) ) {
            update_post_meta ( $lastid, '_ct_reference', $value5['reference'] );
        }

        if ( ! add_post_meta( $lastid, '_ct_sqft', $value5['sqft'], true ) ) {
            $sqft = floor( $value5['sqft'] );
            update_post_meta ( $lastid, '_ct_sqft', $sqft );
        }

        if($value5['youtube'] !="-"){
            if ( ! add_post_meta( $lastid, '_ct_video', $value5['youtube'], true ) ) {
                update_post_meta ( $lastid, '_ct_video', $value5['youtube'] );
            }
        }

        if ( ! add_post_meta( $lastid, '_ct_latlng', $value5['latitude'].','.$value5['longitude'] , true ) ) {
            update_post_meta ( $lastid, '_ct_latlng', $value5['latitude'].','.$value5['longitude'] );
        }
        /*not in theme*/
        if ( ! add_post_meta( $lastid, '_ct_building', $value5['building'] , true ) ) {
            update_post_meta ( $lastid, '_ct_building', $value5['building'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_view', $value5['view'] , true ) ) {
            update_post_meta ( $lastid, '_ct_view', $value5['view'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_parking', $value5['parking'] , true ) ) {
            update_post_meta ( $lastid, '_ct_parking', $value5['parking'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_purpose', $value5['purpose'] , true ) ) {
            update_post_meta ( $lastid, '_ct_purpose', $value5['purpose'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_category', $value5['category'] , true ) ) {
            update_post_meta ( $lastid, '_ct_category', $value5['category'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_amenities', $value5['amenities'] , true ) ) {
            update_post_meta ( $lastid, '_ct_amenities', $value5['amenities'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_floorimages', $value5['floorimages'] , true ) ) {
            update_post_meta ( $lastid, '_ct_floorimages', $value5['floorimages'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_agent_name', $value5['agent_name'] , true ) ) {
            update_post_meta ( $lastid, '_ct_agent_name', $value5['agent_name'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_agent_number', $value5['agent_number'] , true ) ) {
            update_post_meta ( $lastid, '_ct_agent_number', $value5['agent_number'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_agent_email', $value5['agent_email'] , true ) ) {
            update_post_meta ( $lastid, '_ct_agent_email', $value5['agent_email'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_agent_image', $value5['agent_image'] , true ) ) {
            update_post_meta ( $lastid, '_ct_agent_image', $value5['agent_image'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_app_price', $value5['app_price'] , true ) ) {
            update_post_meta ( $lastid, '_ct_app_price', $value5['app_price'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_location_type', $value5['location_type'] , true ) ) {
            update_post_meta ( $lastid, '_ct_location_type', $value5['location_type'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_added_date', $value5['added_date'] , true ) ) {
            update_post_meta ( $lastid, '_ct_added_date', $value5['added_date'] );
        }
        if ( ! add_post_meta( $lastid, '_ct_last_updated', $value5['last_updated'] , true ) ) {
            update_post_meta ( $lastid, '_ct_last_updated', $value5['last_updated'] );
        }
        /*not in theme*/
        /*Taxonomies*/
        //Insert Custom Taxonomies

        wp_set_post_terms($lastid,array($value5['type']),'property_type',true);
        wp_set_post_terms($lastid,array($value5['bedrooms']),'beds',true);
        wp_set_post_terms($lastid,array($value5['bathrooms']),'baths',true);
        if($value5['featured'] == 1){
            wp_set_post_terms($lastid,array('featured'),'ct_status',true);
        }
        wp_set_post_terms($lastid,array($value5['city']),'city',true);
        wp_set_post_terms($lastid,array($value5['subcommunity']),'state',false);
        // wp_set_post_terms($lastid,array($value5['subcommunity']),'zipcode',false);
        wp_set_post_terms($lastid,array($value5['community']),'country',false);
        wp_set_post_terms($lastid,array($value5['community']),'community',true);

    }
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

/*-----------------------------------------------------------------------------------*/
/* Framework Functions
/*-----------------------------------------------------------------------------------*/

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
/*-----------------------------------------------------------------------------------*/
/* Custom posts */
/*-----------------------------------------------------------------------------------*/

// Custom Posts
//require_once (INC_PATH . 'floor-plan.php');

//meta box for referance number in listings
add_action( 'add_meta_boxes', 'referance_number_meta_box_add' );
function referance_number_meta_box_add()
{
    add_meta_box( 'referance_number', 'Reference Number', 'meta_box_referance', 'listings', 'side', 'high' );
    //add_meta_box( 'referance_number', 'Unit Number', 'meta_box_referance', 'listings', 'side', 'high' );
}

function meta_box_referance( $post )
{
    $values = get_post_custom( $post->ID );
    $text = isset( $values['_ct_reference'] ) ? esc_attr( $values['_ct_reference'][0] ) : "BP".$post->ID;
    $selected = isset( $values['_ct_reference_select'] ) ? esc_attr( $values['_ct_reference_select'][0] ) : "";
    $check = isset( $values['_ct_reference_check'] ) ? esc_attr( $values['_ct_reference_check'][0] ) : "";
    ?><input type="text" name="_ct_reference" id="_ct_reference" value="<?php echo $text; ?>" /><?php
}

//save meta box referance data
add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );

    // Make sure your data is set before trying to save it
    if( isset( $_POST['_ct_reference'] ) )
        update_post_meta( $post_id, '_ct_reference', wp_kses( $_POST['_ct_reference'], $allowed ) );

    if( isset( $_POST['_ct_reference_select'] ) )
        update_post_meta( $post_id, '_ct_reference_select', esc_attr( $_POST['_ct_reference_select'] ) );

    // This is purely my personal preference for saving check-boxes
    $chk = isset( $_POST['_ct_reference_check'] ) && $_POST['_ct_reference_select'] ? 'on' : 'off';
    update_post_meta( $post_id, '_ct_reference_check', $chk );
}
function my_theme_scripts() {
    wp_enqueue_style('fancybox',get_template_directory_uri().'/css/fancybox/jquery.fancybox.css',false,'1.1','all');
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/css/fancybox/jquery.fancybox.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

//function my_theme_style(){
//    wp_enqueue_style('fancybox',get_template_directory_uri().'css/fancybox/jquer.fancybox.css',false,'1.1','all');
//}
//add_action( 'wp_enqueue_scripts', 'my_theme_style' );
// Custom Posts for projects
require_once (INC_PATH . 'projects.php');


//to run cron without loggin to admin
add_action('wp_ajax_get_properties', 'get_properties' );
add_action('wp_ajax_nopriv_get_properties', 'get_properties');
//to run cron without loggin to admin


//dropdown options for bed
function add_theme_box_beds() {
    add_meta_box('theme_beds_ID', __('Bedroom'), 'beds_styling_function', array('post_type'=>'listings'), 'side', 'core');
}

function add_theme_menus_beds() {

    if ( ! is_admin() )
        return;

    add_action('admin_menu', 'add_theme_box_beds');
}

add_theme_menus_beds();
function beds_styling_function($post) {

    echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
        wp_create_nonce( 'taxonomy_theme' ) . '" />';


    // Get all theme taxonomy terms
    $themes = get_terms('beds', 'hide_empty=0');

    ?>
    <select name='newtag[beds]' id='new-tag-beds' class="newtag form-input-tip">
        <!-- Display themes as options -->
        <?php
        $names = wp_get_object_terms($post->ID, 'beds');
        ?>
        <?php
        foreach ($themes as $theme) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n";
        }
        ?>
    </select>
    <?php
}
//dropdown options for bed


//dropdown options for baths
function add_theme_box_baths() {
    add_meta_box('theme_baths_ID', __('Bathroom'), 'bath_styling_function', array('post_type'=>'listings'), 'side', 'core');
}

function add_theme_menus_baths() {

    if ( ! is_admin() )
        return;

    add_action('admin_menu', 'add_theme_box_baths');
}

add_theme_menus_baths();
function bath_styling_function($post) {

    echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
        wp_create_nonce( 'taxonomy_theme' ) . '" />';


    // Get all theme taxonomy terms
    $themes = get_terms('baths', 'hide_empty=0');

    ?>
    <select name='newtag[baths]' id='new-tag-baths' class="newtag form-input-tip">
        <!-- Display themes as options -->
        <?php
        $names = wp_get_object_terms($post->ID, 'baths');
        ?>
        <?php
        foreach ($themes as $theme) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n";
        }
        ?>
    </select>
    <?php
}
//dropdown options for baths

//dropdown options for agents
function add_theme_box_agents() {
    add_meta_box('theme_agents_ID', __('Agents'), 'agents_styling_function', array('post_type'=>'listings'), 'side', 'core');
}

function add_theme_menus_agents() {

    if ( ! is_admin() )
        return;

    add_action('admin_menu', 'add_theme_box_agents');
}

add_theme_menus_agents();
function agents_styling_function($post) {

    echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
        wp_create_nonce( 'taxonomy_theme' ) . '" />';


    // Get all theme taxonomy terms
    $themes = get_terms('agents', 'hide_empty=0');

    ?>
    <select name='newtag[agents]' id='new-tag-agents' class="newtag form-input-tip">
        <!-- Display themes as options -->
        <?php
        $names = wp_get_object_terms($post->ID, 'agents');
        ?>
        <?php
        foreach ($themes as $theme) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n";
        }
        ?>
    </select>
    <?php
}
//dropdown options for agents


//dropdown options for Property type
function add_theme_box_property_type() {
    add_meta_box('theme_agents_property_type', __('Property Type'), 'property_type_styling_function', array('post_type'=>'listings'), 'side', 'core');
}

function add_theme_menus_property_type() {

    if ( ! is_admin() )
        return;

    add_action('admin_menu', 'add_theme_box_property_type');
}

add_theme_menus_property_type();
function property_type_styling_function($post) {

    echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
        wp_create_nonce( 'taxonomy_theme' ) . '" />';


    // Get all theme taxonomy terms
    $themes = get_terms('property_type', 'hide_empty=0');

    ?>
    <select name='newtag[property_type]' id='new-tag-property_type' class="newtag form-input-tip">
        <!-- Display themes as options -->
        <?php
        $names = wp_get_object_terms($post->ID, 'property_type');
        ?>
        <?php
        foreach ($themes as $theme) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n";
        }
        ?>
    </select>
    <?php
}
//dropdown options for Property type

//dropdown options for Status
function add_theme_box_status() {
    add_meta_box('theme_agents_status', __('Status'), 'status_styling_function', array('post_type'=>'listings'), 'side', 'core');
}

function add_theme_menus_status() {

    if ( ! is_admin() )
        return;

    add_action('admin_menu', 'add_theme_box_status');
}

add_theme_menus_status();
function status_styling_function($post) {

    echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
        wp_create_nonce( 'taxonomy_theme' ) . '" />';


    // Get all theme taxonomy terms
    $themes = get_terms('ct_status', 'hide_empty=0');

    ?>
    <select name='newtag[ct_status]' id='new-tag-ct_status' class="newtag form-input-tip">
        <!-- Display themes as options -->
        <?php
        $names = wp_get_object_terms($post->ID, 'property_type');
        ?>
        <?php
        foreach ($themes as $theme) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n";
        }
        ?>
    </select>
    <?php
}
//dropdown options for Status

add_action('admin_enqueue_scripts','load_admin_location_script');
function  load_admin_location_script($hook){

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'listings' === $post->post_type ) {
            wp_enqueue_script(  'location', get_stylesheet_directory_uri() . '/admin/location.js' );
        }
    }
}


//admin city change to get community
function getcommunity(){
    global $wpdb;
    global $post;
    $table_name = $wpdb->prefix . "location";
    $city = $_POST['city'];
    echo $postID = $_POST['postID'];
    $communitymeta = get_post_meta($postID,'_ct_community');

    $communities = $wpdb->get_results( "SELECT DISTINCT(community) FROM $table_name  where city = '$city'ORDER BY community ASC " );
    $allcommunity = '';
    foreach($communities as $community){
        $allcommunity .= '<option value="'.$community->community.'">'.$community->community.'</option>';
    }
    echo $allcommunity;
    exit();
}
add_action('wp_ajax_getcommunity', 'getcommunity'); // Call when user logged in
add_action('wp_ajax_nopriv_getcommunity', 'getcommunity'); // Call when user in not logged in


//admin community change to get sub community
function getsubcommunity(){
    global $wpdb;
    $table_name = $wpdb->prefix . "location";
    $city = $_POST['city'];
    $community = $_POST['community'];


    $subcommunities = $wpdb->get_results( "SELECT DISTINCT(sub_community) FROM $table_name  where city = '$city'  and community = '$community' ORDER BY sub_community ASC " );
    $output = '';
    foreach($subcommunities as $subcommunity){
        $output['sub_communities'] .= '<option value="'.$subcommunity->sub_community.'">'.$subcommunity->sub_community.'</option>';
    }

    $firstsubcumm = $wpdb->get_results( "SELECT DISTINCT(sub_community) FROM $table_name  where city = '$city'  and community = '$community' ORDER BY sub_community ASC Limit 1" );
    $firstsubcommname = $firstsubcumm[0]->sub_community;
    $building = $wpdb->get_results( "SELECT DISTINCT(building) FROM $table_name  where city = '$city'  and community = '$community'  and sub_community = '$firstsubcommname' " );
    $buildingname = $building[0]->building;
    $output['building'] .= $buildingname;

    echo json_encode($output);
    exit();
}
add_action('wp_ajax_getsubcommunity', 'getsubcommunity'); // Call when user logged in
add_action('wp_ajax_nopriv_getsubcommunity', 'getsubcommunity'); // Call when user in not logged in


//admin get building on page load
function getbuilding(){
    global $wpdb;
    $table_name = $wpdb->prefix . "location";
   $city = $_POST['city'];
    $community = $_POST['community'];
   $subcommunity = $_POST['sub_community'];

    $building = $wpdb->get_results( "SELECT DISTINCT(building) FROM $table_name  where city = '$city'  and community = '$community'  and sub_community = '$subcommunity' " );
    $buildingname = $building[0]->building;
    echo $buildingname;
    exit();
}
add_action('wp_ajax_getbuilding', 'getbuilding'); // Call when user logged in
add_action('wp_ajax_nopriv_getbuilding', 'getbuilding'); // Call when user in not logged in