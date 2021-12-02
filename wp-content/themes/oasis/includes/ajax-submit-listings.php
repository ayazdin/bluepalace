<?php
/**
 * Ajax Submit - Listing Contact Widget
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

global $ct_options;
// $ct_listing_agent_contact_cc_email_address = isset( $ct_options['ct_listing_agent_contact_cc_email_address'] ) ? esc_html( $ct_options['ct_listing_agent_contact_cc_email_address'] ) : '';

$email=$_POST['email'];
$name=$_POST['name'];
$message=$_POST['message'];
$youremail=$_POST['ctyouremail'];
// $youremail=get_bloginfo( 'admin_email' );
$subject=$_POST['ctsubject'];
$ctproperty=$_POST['ctproperty'];
$ctpermalink=$_POST['ctpermalink'];
$ctphone=$_POST['ctphone'];
$reference=$_POST['reference'];

$isValidate = true;

if($isValidate == true){
	$to = "$youremail";
	$subject = "$subject";
	$msg = "$message" . "\n\n" .
	"Phone: $ctphone" . "\n" .
	"Reference: $reference" . "\n" .
	"Email: $email" . "\n" .
	"Property Address: $ctproperty" . "\n" .
	"Permalink: $ctpermalink" . "\n";
	$headers = "From: $name <$email>" . "\r\n" .
		"Reply-To: $email" . "\r\n" .
		// "CC: $ct_listing_agent_contact_cc_email_address" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, "From: $name <$email>");
	echo "true";
} else {
	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';
}
?>