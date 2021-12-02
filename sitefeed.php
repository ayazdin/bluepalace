<?php
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";
include_once("xml_writer.php");
$websiteaddress = 'http://digirems.com/demo/';
$host = "localhost";
$name = "root";
$password = "c2Wbdy2BP1yy";
$db = "digirems_newroutes";
$masterdb='digirems_master';
$table_prefix = 'vox_';
$link = mysql_connect($host, $name, $password) or die(mysql_error());
mysql_select_db($db, $link) or die(mysql_error());
header('Content-Type: application/xml; charset=ISO-8859-1');
$today = date('Y-m-d H:i:s'); 
$pattern = "#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#";
// $results = mysql_query("SELECT a.*, a.`reference_number`, b.`area_name`, c.`projects_name`, d.`sub_projects_name`, e.`sub_projects_name` AS `building`, f.`type_name`, g.`user_photo`, g.`user_fullname`, g.`user_contactno`, g.`user_email`, g.`brokerno` FROM  `site_properties` AS a
	// LEFT JOIN `site_areas` AS b ON b.area_id = a.`area`
	// LEFT JOIN `site_projects` AS c ON c.`projects_id` = a.`project`
	// LEFT JOIN `site_subprojects` AS d ON d.`projects_id` = a.`subproject`
	// LEFT JOIN `site_subprojects2` AS e ON e.`projects_id` = a.`subproject2`
	// LEFT JOIN `site_types` AS f ON f.`type_id` = a.`type`
	// LEFT JOIN `site_users` AS g ON g.`user_id` = a.`user`
// WHERE a.`status` = 1 ORDER BY a.`updated_time` DESC");

   $results1="SELECT a.*, a.`property_refno`,a.city_id,a.community_id,a.subcommunity_id,a.building_id,a.property_title,a.location_type,a.featured, g.profile_fullname AS agent_name,g.profile_image as agent_image,g.profile_mobileno as agent_mobileno,c.uaccount_email as agent_email FROM  `vox_properties` AS a 
 LEFT JOIN `vox_user_profiles` AS g ON a.`listing_agent_id` = g.`uaccount_id`
 LEFT JOIN `vox_user_accounts` AS c ON a.`listing_agent_id` = c.`uaccount_id`
 WHERE a.`status` = 1 ORDER BY a.`updated_date` DESC";

 $results = mysql_query("SELECT a.*, a.`property_refno`,a.city_id,a.property_order,a.community_id,a.subcommunity_id,a.building_id,a.property_title,a.location_type,a.featured, g.profile_fullname AS agent_name,g.profile_image as agent_image, g.profile_mobileno as agent_mobileno,c.uaccount_email as agent_email,youtube FROM  `vox_properties` AS a 
 LEFT JOIN `vox_user_profiles` AS g ON a.`listing_agent_id` = g.`uaccount_id`
 LEFT JOIN `vox_user_accounts` AS c ON a.`listing_agent_id` = c.`uaccount_id`
   WHERE a.`status` = 1 ORDER BY a.`updated_date` DESC");
$xml = new XmlWriters();
$xml->push('array');
$xml->push('listings'); 
while($row = mysql_fetch_array($results)){
	// echo '<pre>';
	// print_r($row);
	// echo '</pre>';
	//die('fvgfd');
	$RN=$AN=$PN=$SPN=$BN=$TL=$DES=$BED=$PUR=$PRO=$TN=$AME=$IMG=$AP=$AFN=$AE=$ABN=$YT = '-';
	$SF=$BATH=$PARK=$PR=$ACN=$HP=$POA=$LT=$PORDER=0;	
	$AT=$UT = $today;
	if(!empty($row['property_refno']))
		$RN = $row['property_refno'];
	if(!empty($row['city_id']))
	{
		$AN=getCityname($row['city_id']);
	}
		
	if(!empty($row['community_id']))
		$CN = getCommunityname($row['community_id']);
	if(!empty($row['subcommunity_id']))
		$SCN = getSubcommunityname($row['subcommunity_id']);
	if(!empty($row['building_id']))
		$BN = getBuildingname($row['building_id']);
	if(!empty($row['property_title']))
		$TL = ucwords(strtolower(strip_tags($row['property_title'])));
		//$TL = ucwords(strtolower($row['property_title']));
	//if(!empty($row['property_desc']))	
	if(!empty($row['property_desc']))	
		$DES = "<![CDATA[". preg_replace($pattern, '', strip_tags($row['property_desc'], '<p><a><ul><li><br>')) ."]]>";
		//$DES = $row['property_desc'];
	if(!empty($row['sqft']))
		$SF = $row['sqft'];
	//$studio = 0;
	// switch(strtolower($row['type_name'])){
		// case 'apartment':$studio = 1;
		// break;
		// case 'penthouse':$studio = 1;
		// break;
		// case 'townhouse':$studio = 1;
		// break;
		// case 'bungalow':$studio = 1;
		// break;
		// case 'duplex':$studio = 1;
		// break;
		// case 'villa':$studio = 1;
		// break;
		// default:$studio = 0;
		// break;
	// }  
	// if(empty($row['beds']) && $row['property']=='res' && $studio == 1)
		// $BED = -1;
	// else if($row['property']=='res')
		// $BED = !empty($row['beds']) ? $row['beds'] : 0;
	// else
		// $BED = '-';
	
	
	
	// if(!empty($row['total_price']))
		// $PR = $row['total_price'];
	if(!empty($row['bedrooms']))
		$BED = $row['bedrooms'];
	 if(!empty($row['bathrooms']))
		$BATH = $row['bathrooms'];
	if(!empty($row['parking']))
		$PARK = $row['parking'];
	if(!empty($row['purpose']))
		$PUR = ucfirst($row['purpose']);
	if($row['purpose']=="Rent")
	{
			$PRO = "Residential";
			$PR = $row['rental_price'];
	}
	else
	{
			$PRO = "Commercial";
			$PR = $row['selling_price'];
	}
	if(!empty($row['type_id']))
		$TN = getPropertytypesname($row['type_id']);
	// if(!empty($row['special_price']))
		// $PR = $row['special_price']; 
	// else if(!empty($row['price']))
		// $PR = $row['price'];
	
	
	// $amenities = '';
	// if($row['maid_room'] == 1)
		// $amenities .= 'Maids Room,';
	// if($row['security'] == 1)
		// $amenities .= 'Security,';
	// if($row['study'] == 1)
		// $amenities .= 'Study,';
	// if($row['concierge'] == 1)
		// $amenities .= 'Concierge Service,';
	// if($row['central_ac'] == 1 || $row['centralheating'] == 1)
		// $amenities .= 'Central A/C & Heating,';
	// if($row['maidservice'] == 1)
		// $amenities .= 'Maid Service,';
	// if($row['balcony'] == 1 || $row['balconyview'] == 1)
		// $amenities .= 'Balcony,';
	// if($row['coveredparking'] == 1)
		// $amenities .= 'Covered Parking,';
	// if($row['garden'] == 1)
		// $amenities .= 'Private Garden,';
	// if($row['wardrobes'] == 1)
		// $amenities .= 'Built in Wardrobes,';
	// if($row['privatepool'] == 1)
		// $amenities .= 'Private Pool,';
	// if($row['closet'] == 1)
		// $amenities .= 'Walk-in Closet,';
	// if($row['privategym'] == 1)
		// $amenities .= 'Private Gym,';
	// if($row['kitchen'] == 1)
		// $amenities .= 'Built in Kitchen Appliances,';
	// if($row['privatejacuzzi'] == 1)
		// $amenities .= 'Private Jacuzzi,';
	// if($row['waterview'] == 1)
		// $amenities .= 'View of Water,';
	// if($row['sharedpool'] == 1)
		// $amenities .= 'Shared Pool,';
	// if($row['landmark'] == 1)
		// $amenities .= 'View of Landmark,';
	// if($row['sharedspa'] == 1)
		// $amenities .= 'Shared Spa,';
	// if($row['pets'] == 1)
		// $amenities .= 'Pets Allowed,';
	// if($row['gym'] == 1)
		// $amenities .= 'Shared Gym,';
	// if(!empty($amenities))
		// $AME = substr($amenities, 0, -1);
	/*$images = '';
	if(!empty($row['property_img_path']))
		$images .= 'http://'.$websiteaddress.'/'.$row['property_img_path'].',';
	$imagesql = "SELECT `property_image` FROM `site_photos` WHERE `property_id` = ".$row['id'];
	$imageresult = mysql_query($imagesql);
	while ($image_prop = mysql_fetch_array($imageresult, MYSQL_ASSOC))
		$images .= 'http://'.$websiteaddress.'/'.$image_prop['property_image'].',';
	if(!empty($images))
		$IMG = substr($images, 0, -1);*/
	// if(!empty($row['user_photo']))
		// $AP = 'http://'.$websiteaddress.'/'.$row['user_photo'];
	if(!empty($row['agent_name']))
		$AFN = $row['agent_name'];
	if(!empty($row['agent_mobileno']))
		$ACN = str_replace(" ", "", $row['agent_mobileno']);
	if(!empty($row['agent_email']))
		$AE = $row['agent_email'];
	if(!empty($row['agent_image']))
		$AImg = $websiteaddress.$row['agent_image'];
	// if(!empty($row['brokerno']))
		// $ABN = $row['brokerno'];
	// if($row['hot_property'] == 1)
		// $HP = 1;
	if(!empty($row['featured']))
		$HP = $row['featured'];
	if(!empty($row['app_price']))
		$POA = $row['app_price'];
	if(!empty($row['created_date']))
		$AT = $row['created_date'];
	if(!empty($row['updated_date']))
		$UT = $row['updated_date'];
	if(!empty($row['youtube']))
		$YT = $row['youtube'];	
	if(!empty($row['location_type']))
		$LT = $row['location_type'];
	
	if(!empty($row['view']))
		$VV = $row['view'];	
	
	if(!empty($row['property_order']))
		$PORDER = $row['property_order'];
	
	if(!empty($row['latitude']))
		$LAT = $row['latitude'];
	
	if(!empty($row['longitude']))
		$LONGI = $row['longitude'];

	$xml->push('listing');	
	$xml->element('reference', $RN);
	$xml->element('city', $AN);
	$xml->element('community', $CN);
	$xml->element('subcommunity', $SCN);	
	$xml->element('building', $BN);
	$xml->element('title_en', $TL);
	$xml->element('description_en', utf8_encode($DES)); 
	 $xml->element('sqft', $SF);
	 $xml->element('view', $VV);
	 $xml->element('latitude', $LAT);
	 $xml->element('longitude', $LONGI);
	
	$xml->element('bedrooms', $BED);	
	$xml->element('bathrooms', $BATH);
	$xml->element('parking', $PARK); 
	$xml->element('purpose', $PUR);
	$xml->element('category', $PRO);
	$xml->element('type', $TN);
	$xml->element('price', $PR);
	$xml->element('propertyorder', $PORDER);
	
	
	
	$sel_amq = mysql_query("SELECT b.amenity_name FROM  ".$db.".vox_property_amenities AS a LEFT JOIN ".$masterdb.".vox_amenities AS b ON b.`amenity_id` = a.`amenity_id` WHERE b.`status` = 1 AND property_id=".$row['property_id']);	
	$amenity='';	
	while ($sel_amresult = mysql_fetch_array($sel_amq, MYSQL_ASSOC))
	{	
		$amenity .=$sel_amresult['amenity_name'].',';
	}
	if(!empty($amenity))
		$AME = substr($amenity, 0, -1);
	$xml->element('amenities',$AME);
	//$xml->push('Amenities');$xml->pop();
	
	$sel_imgQ = mysql_query("SELECT image_url FROM  ".$db.".vox_property_images WHERE image_type='P' AND property_id=".$row['property_id']);	
	$images='';
	while ($sel_imgresult = mysql_fetch_array($sel_imgQ, MYSQL_ASSOC))
	{	
		$images .= $websiteaddress.$sel_imgresult['image_url'].',';
	}
	if(!empty($images))
		$IMG = substr($images, 0, -1);	
	$xml->element('images',$IMG);	
	//$xml->push('Images');	//$xml->pop();
	
	$sel_imgFP = mysql_query("SELECT image_url FROM  ".$db.".vox_property_images WHERE image_type='F' AND property_id=".$row['property_id']);	
	$floorimages='';
	while ($sel_imgresult = mysql_fetch_array($sel_imgFP, MYSQL_ASSOC))
	{	
		$floorimages .= $websiteaddress.$sel_imgresult['image_url'].',';
	}
	if(!empty($floorimages))
		$FLOORPLAN = substr($floorimages, 0, -1);	
	$xml->element('floorimages',$FLOORPLAN);
	
	
	// $xml->element('agent_photo', $AP);
	$xml->element('youtube', $YT);
	$xml->element('agent_name', $AFN);	 
	$xml->element('agent_number', $ACN);
	$xml->element('agent_email', $AE);
	$xml->element('agent_image', $AImg);
	// $xml->element('agent_brokerno', $ABN);
	$xml->element('featured',$HP);
	$xml->element('app_price',$POA);
	 $xml->element('location_type', $LT);
	$xml->element('added_date',$AT);
	$xml->element('last_updated',$UT);
	$xml->pop();
}
//$xml->pop();
// $results = mysql_query("SELECT `banner_name`, `banner_description`, `banner_path`, `banner_page` FROM `site_banners` WHERE `banner_path` <> ''");
// $xml->push('banners');
// while($banner = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $BT=$BD=$BP = '-';
	// if(!empty($banner['banner_name']))
		// $BT = $banner['banner_name'];
	// if(!empty($banner['description']))
		// $BD = strip_tags($banner['description']);
	// if(!empty($banner['banner_page']))
		// $BP = strip_tags($banner['banner_page']);
	// $xml->push('banner');
	// $xml->element('title', $BT);
	// $xml->element('description', $BD);
	// $xml->element('page', $BP);
	// $xml->element('image', 'http://'.$websiteaddress.'/'.$banner['banner_path']);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT a.`projects_name`, a.`projects_description`, a.`projects_image_path`, a.`lat`, a.`long`, b.`area_name` FROM `site_projects` a LEFT JOIN `site_areas` b ON a.`area_id` = b.`area_id` WHERE a.`projects_name` <> '' AND a.`area_guide` = 1");
// $xml->push('areaguides');
// while($areaguide = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $APN=$APD=$API=$AAN = '-';
	// $AL=$ALO = 0;
	// if(!empty($areaguide['projects_name']))
		// $APN = $areaguide['projects_name'];
	// if(!empty($areaguide['projects_description']))
		// $APD = "<![CDATA[". preg_replace($pattern, '', strip_tags($areaguide['projects_description'], '<p><a><ul><li><br>')) ."]]>";
	// if(!empty($areaguide['projects_image_path']))
		// $API = $areaguide['projects_image_path'];
	// if(!empty($areaguide['area_name']))
		// $AAN = $areaguide['area_name'];
	// if(!empty($areaguide['lat']))
		// $AL = $areaguide['lat'];
	// if(!empty($areaguide['long']))
		// $ALO = $areaguide['long'];
	// $xml->push('areaguide');
	// $xml->element('title', $APN);
	// $xml->element('description', utf8_encode($APD));
	// $xml->element('image', $API);
	// $xml->element('city', $AAN);
	// $xml->element('latitude', $AL);
	// $xml->element('longitude', $ALO);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT a.`projects_name`, a.`projects_description`, a.`projects_image_path`, a.`lat`, a.`long`, b.`area_name` FROM `site_projects` a LEFT JOIN `site_areas` b ON a.`area_id` = b.`area_id` WHERE a.`projects_name` <> '' AND a.`projects_id` IN (SELECT DISTINCT(c.`project`) from `site_properties` AS c WHERE c.`status` = 1)");
// $xml->push('projects');
// while($project = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $APN=$APD=$API=$AAN = '-';
	// $AL=$ALO = 0;
	// if(!empty($project['projects_name']))
		// $APN = $project['projects_name'];
	// if(!empty($project['projects_description']))
		// $APD = "<![CDATA[". preg_replace($pattern, '', strip_tags($project['projects_description'], '<p><a><ul><li><br>')) ."]]>";
	// if(!empty($project['projects_image_path']))
		// $API = $project['projects_image_path'];
	// if(!empty($project['area_name']))
		// $AAN = $project['area_name'];
	// if(!empty($project['lat']))
		// $AL = $project['lat'];
	// if(!empty($project['long']))
		// $ALO = $project['long'];
	// $xml->push('project');
	// $xml->element('title', $APN);
	// $xml->element('description', utf8_encode($APD));
	// $xml->element('image', $API);
	// $xml->element('city', $AAN);
	// $xml->element('latitude', $AL);
	// $xml->element('longitude', $ALO);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT `title`, `description` FROM `site_aboutus` WHERE `description` <> ''");
// $xml->push('aboutus');
// while($aboutus = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $AUT=$AUD = '-';
	// if(!empty($aboutus['title']))
		// $AUT = $aboutus['title'];
	// if(!empty($aboutus['description']))
		// $AUD = "<![CDATA[". preg_replace($pattern, '', strip_tags($aboutus['description'], '<h2><p><a><strong><ul><li><br>')) ."]]>";
	// $xml->push('about');
	// $xml->element('title', $AUT);
	// $xml->element('description', utf8_encode($AUD));
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT `testimonials_title`, `testimonials_description`, `testimonials_phone`, `testimonials_email`, `testimonials_image_path` FROM `site_testimonials` WHERE `testimonials_description` <> ''");
// $xml->push('testimonials');
// while($testimonial = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $TT=$TD=$TE=$TI = '-';
	// $TP = 0;
	// if(!empty($testimonial['testimonials_title']))
		// $TT = $testimonial['testimonials_title'];
	// if(!empty($testimonial['testimonials_description']))
		// $TD = "<![CDATA[". preg_replace($pattern, '', strip_tags($testimonial['testimonials_description'], '<p><a><strong><ul><li><br>')) ."]]>";
	// if(!empty($testimonial['testimonials_phone']))
		// $TP = $testimonial['testimonials_phone'];
	// if(!empty($testimonial['testimonials_email']))
		// $TE = $testimonial['testimonials_email'];
	// if(!empty($testimonial['testimonials_image_path']))
		// $TI = $testimonial['testimonials_image_path'];	
	// $xml->push('testimonial');
	// $xml->element('title', $TT);
	// $xml->element('description', utf8_encode($TD));
	// $xml->element('phone', $TP);
	// $xml->element('email', $TE);
	// $xml->element('image', $TI);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT `job_title`, `job_department`, `jemail_id`, `jdesc`, `job_post_date`, `job_expiry_date` FROM `site_careers` WHERE `job_title` <> ''");
// $xml->push('careers');
// while($careers = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $JT=$JDP=$JE=$JD=$JPD=$JEXP = '-';
	// if(!empty($careers['job_title']))
		// $JT = $careers['job_title'];	
	// if(!empty($careers['job_department']))
		// $JDP = $careers['job_department'];
	// if(!empty($careers['jemail_id']))
		// $JE = $careers['jemail_id'];
	// if(!empty($careers['jdesc']))
		// $JD = "<![CDATA[". preg_replace($pattern, '', strip_tags($careers['jdesc'], '<p><a><strong><ul><li><br>')) ."]]>";
	// if(!empty($careers['job_post_date']))
		// $JPD = $careers['job_post_date'];
	// if(!empty($careers['job_expiry_date']))
		// $JEXP = $careers['job_expiry_date'];	
	// $xml->push('career');
	// $xml->element('title', $JT);
	// $xml->element('department', $JDP);
	// $xml->element('email', $JE);
	// $xml->element('description', utf8_encode($JD));
	// $xml->element('post_date', $JPD);
	// $xml->element('expiry_date', $JEXP);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT `user_fullname`, `user_contactno`, `user_email`, `brokerno`, `user_photo` FROM `site_users` WHERE `on_website` = 1 AND `user_fullname` <> ''");
// $xml->push('team_members');
// while($team_members = mysql_fetch_array($results, MYSQL_ASSOC)){
	// $UFN=$UCN=$UE=$UBN=$UP = '-';
	// if(!empty($team_members['user_fullname']))
		// $UFN = $team_members['user_fullname'];
	// if(!empty($team_members['user_contactno']))
		// $UCN = $team_members['user_contactno'];
	// if(!empty($team_members['user_email']))
		// $UE = $team_members['user_email'];
	// if(!empty($team_members['brokerno']))
		// $UBN = $team_members['brokerno'];
	// if(!empty($team_members['user_photo']))
		// $UP = 'http://'.$websiteaddress.'/'.$team_members['user_photo'];	
	// $xml->push('member');
	// $xml->element('full_name', $UFN);
	// $xml->element('contact_no', $UCN);
	// $xml->element('email', $UE);
	// $xml->element('broker_no', $UBN);
	// $xml->element('image', $UP);
	// $xml->pop();
// }
// $xml->pop();
// $results = mysql_query("SELECT * FROM  `site_upcoming_projects`
// WHERE `status` = 1 ORDER BY `updated_time` DESC");
// $xml->push('upcomings'); 
//while($row = mysql_fetch_array($results)){
	// $RN=$AN=$LA=$LO=$PN=$SPN=$BN=$TL=$DES=$BED=$PUR=$PRO=$TN=$AME=$IMG=$AP=$AFN=$AE=$ABN = '-';
	// $SF=$BATH=$PARK=$PR=$ACN=$HP = 0;	
	// $AT=$UT = $today;
	// if(!empty($row['reference_number']))
		// $RN = $row['reference_number'];
	// if(!empty($row['locations']))
		// $PN = $row['locations'];
	// if(!empty($row['latitude']))
		// $LA = $row['latitude'];
	// if(!empty($row['longitude']))
		// $LO = $row['longitude'];
	// if(!empty($row['dmp']))
		// $TL = ucwords(strtolower(strip_tags($row['dmp'])));
	// if(!empty($row['description']))	
		// $DES = "<![CDATA[". preg_replace($pattern, '', strip_tags($row['description'], '<p><a><ul><li><br>')) ."]]>";
	// $amenities = '';
	// if($row['maid_room'] == 1)
		// $amenities .= 'Maids Room,';
	// if($row['availablenetworked'] == 1)
		// $amenities .= 'Available Networked,';		
	// if($row['security'] == 1)
		// $amenities .= 'Security,';
	// if($row['study'] == 1)
		// $amenities .= 'Study,';
	// if($row['concierge'] == 1)
		// $amenities .= 'Concierge Service,';
	// if($row['central_ac'] == 1 || $row['centralheating'] == 1)
		// $amenities .= 'Central A/C & Heating,';
	// if($row['maidservice'] == 1)
		// $amenities .= 'Maid Service,';
	// if($row['balcony'] == 1 || $row['balconyview'] == 1)
		// $amenities .= 'Balcony,';
	// if($row['coveredparking'] == 1)
		// $amenities .= 'Covered Parking,';
	// if($row['garden'] == 1)
		// $amenities .= 'Private Garden,';
	// if($row['wardrobes'] == 1)
		// $amenities .= 'Built in Wardrobes,';
	// if($row['privatepool'] == 1)
		// $amenities .= 'Private Pool,';
	// if($row['closet'] == 1)
		// $amenities .= 'Walk-in Closet,';
	// if($row['privategym'] == 1)
		// $amenities .= 'Private Gym,';
	// if($row['kitchen'] == 1)
		// $amenities .= 'Built in Kitchen Appliances,';
	// if($row['privatejacuzzi'] == 1)
		// $amenities .= 'Private Jacuzzi,';
	// if($row['waterview'] == 1)
		// $amenities .= 'View of Water,';
	// if($row['sharedpool'] == 1)
		// $amenities .= 'Shared Pool,';
	// if($row['landmark'] == 1)
		// $amenities .= 'View of Landmark,';
	// if($row['sharedspa'] == 1)
		// $amenities .= 'Shared Spa,';
	// if($row['pets'] == 1)
		// $amenities .= 'Pets Allowed,';
	// if($row['gym'] == 1)
		// $amenities .= 'Shared Gym,';
	// if(!empty($amenities))
		// $AME = substr($amenities, 0, -1);
	// $images = '';
	// if(!empty($row['property_img_path']))
		// $images .= 'http://'.$websiteaddress.'/'.$row['property_img_path'].',';
	// $imagesql = "SELECT `property_image` FROM `site_photos` WHERE `project_id` = ".$row['id'];
	// $imageresult = mysql_query($imagesql);
	// while ($image_prop = mysql_fetch_array($imageresult, MYSQL_ASSOC))
		// $images .= 'http://'.$websiteaddress.'/'.$image_prop['property_image'].',';
	// if(!empty($images))
		// $IMG = substr($images, 0, -1);
	// if(!empty($row['user_photo']))
		// $AP = 'http://'.$websiteaddress.'/'.$row['user_photo'];
	// if(!empty($row['added_time']))
		// $AT = $row['added_time'];
	// if(!empty($row['updated_time']))
		// $UT = $row['updated_time'];	
	// $xml->push('upcoming');	
	// $xml->element('reference', $RN);
	// $xml->element('locations', $PN);
	// $xml->element('latitude', $LA);
	// $xml->element('longitude', $LO);
	// $xml->element('title_en', $TL);
	// $xml->element('description_en', utf8_encode($DES));
	// $xml->element('amenities', $AME);
	// $xml->element('images', $IMG);
	// $xml->element('added_date',$AT);
	// $xml->element('last_updated',$UT);
	// $xml->pop();
//}
$xml->pop();
$xml->pop();
print $xml->getXml();
	function getCityname($city_id)
	{
		//echo $sel="select * from ".$masterdb.".vox_city where city_id='".$city_id."'";
		$sel="select * from digirems_master.vox_city where city_id='".$city_id."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if($row['city_name'])
			return  $row['city_name'];		
		else
			return '0';		
	}
	function getAmenities($prop_id,$db,$db_master)
	{
		$sel_am="SELECT b.amenity_name FROM  ".$db.".vox_property_amenities AS a LEFT JOIN ".$db_master.".vox_amenities AS b ON b.`amenity_id` = a.`amenity_id` WHERE b.`status` = 1 AND property_id=".$prop_id;
		//echo $sel_am;
		$res_am=mysql_query($sel_am);
		$row_am=mysql_fetch_array($res_am);
		var_dump($row_am);exit;
		if($row_am)
			return  $row_am;		
		else
			return '0';		
	}

	function getCommunityname($community_id)
	{
		$sel="select * from digirems_master.vox_community where community_id='".$community_id."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if($row['community_name'])
			return  $row['community_name'];		
		else
			return '0';		
	}
	
	function getSubcommunityname($sub_community_id)
	{
		$sel="select * from digirems_master.vox_subcommunity where subcommunity_id='".$sub_community_id."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if($row['subcommunity_name'])
			return  $row['subcommunity_name'];		
		else
			return '0';		
	}
	
	function getBuildingname($building_id)
	{
		$sel="select * from digirems_master.vox_building where building_id like '".$building_id."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if($row['building_name']!='')
			return  $row['building_name'];
		else
			return '0';	
	}
	
	function getPropertytypesname($type_id)
	{
		$sel="select * from digirems_master.vox_property_types where type_id='".$type_id."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if($row['type_name']!='')
			return  $row['type_name'];
		else
			return '0';
	}
?>