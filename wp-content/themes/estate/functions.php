<?php
/**
 * Child theme functions
 *
 * When using a child theme please review the following helpful links
 * http://contempothemes.com/wp-real-estate-7/documentation/#childthemes
 * http://contempothemes.com/wp-real-estate-7/documentation/#advdev
 * http://codex.wordpress.org/Child_Themes
 *
 * Text Domain: contempo
 *
 */

/**
 * Load the parent theme style.css file
 */
function ct_child_enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'ct_child_enqueue_parent_theme_style');

/*
 *  creating cron for getting xml data
 */
function activate()
{
    wp_schedule_event(time(), 'hourly', 'my_hourly_event');
} // end activate

function deactivate()
{
    wp_clear_scheduled_hook('my_hourly_event');
} // end activate
function update_db_hourly()
{
    global $wpdb;
    $wpdb->query('TRUNCATE TABLE rs_xml_data');
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
    foreach ($simplifiedArray as $value5) {
        $wpdb->insert(
            'rs_xml_data',
            array(
                'reference' => $value5['reference'],
                'city' => $value5['city'],
                'community' => $value5['community'],
                'subcommunity' => $value5['subcommunity'],
                'building' => $value5['building'],
                'title_en' => $value5['title_en'],
                'description_en' => $value5['description_en'],
                'sqft' => $value5['sqft'],
                'view' => $value5['view'],
                'latitude' => $value5['latitude'],
                'longitude' => $value5['longitude'],
                'bedrooms' => $value5['bedrooms'],
                'bathrooms' => $value5['bathrooms'],
                'parking' => $value5['parking'],
                'purpose' => $value5['purpose'],
                'category' => $value5['category'],
                'type' => $value5['type'],
                'price' => $value5['price'],
                'propertyorder' => $value5['propertyorder'],
                'amenities' => $value5['amenities'],
                'images' => $value5['images'],
                'floorimages' => $value5['floorimages'],
                'youtube' => $value5['youtube'],
                'agent_name' => $value5['agent_name'],
                'agent_number' => $value5['agent_number'],
                'agent_email' => $value5['agent_email'],
                'featured' => $value5['featured'],
                'app_price' => $value5['app_price'],
                'location_type' => $value5['location_type'],
                'added_date' => $value5['added_date'],
                'last_updated' => $value5['last_updated']
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%f',
                '%s',
                '%f',
                '%f',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s'
            )
        );
    }//end insert query


} // end update_csv_hourly

/*function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}*/

/*
*   function to convert XML data to array
*/
/*function xml2array($contents, $get_attributes = 1, $priority = 'tag')
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
}  */