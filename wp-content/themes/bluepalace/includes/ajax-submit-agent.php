<?php
/**
 * Ajax Submit - Agent Contact Modal
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$email=$_POST['email'];
$name=$_POST['name'];
$message=$_POST['message'];
$youremail=$_POST['ctyouremail'];
$subject=$_POST['ctsubject'];
$ctphone=$_POST['ctphone'];

$isValidate = true;

if($isValidate == true){
	$to = "$youremail";
	$subject = "$subject";
	$msg = "$message" . "\n\n" .
	"Phone: $ctphone" . "\n" .
	"Email: $email" . "\n";
	$headers = "From: $name <$email>" . "\r\n" .
		"Reply-To: $email" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, "From: $name <$email>");
	echo "true";
} else {
	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';
}
?>