<?php
/**
 * Ajax Submit - Contact Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$email=$_POST['email'];
$name=$_POST['name'];
$phone=$_POST['phone'];
$message=$_POST['message'];
$youremail=$_POST['ctyouremail'];
$subject=$_POST['subject'];

$isValidate = true;

if($isValidate == true){
	$to = $youremail;
	$subject = $subject;
	$msg = "$message" . "\n\n" .
	"Phone: $phone" . "\n" .
	"Email: $email" . "\n";
	$headers = "From:" . $name ."<" . $email . ">" . "\r\n";
	$headers .= "Reply-To:" . $email . "\r\n";
	//$headers = "Bcc: someone@domain.com" . "\r\n";
	$headers = "X-Mailer: PHP/" . phpversion();
	mail ($to, $subject, $msg, "From: $name <$email>");
	echo "true";
} else {
	echo '{"jsonValidateReturn":'.json_encode($arrayError).'}';
} ?>