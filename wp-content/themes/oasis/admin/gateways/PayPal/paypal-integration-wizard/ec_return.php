<?php
require('constants.php');
$url = "https://api-3t.sandbox.paypal.com/nvp";
   $nvps = 
   "&USER=$user"
   ."&PWD=$password"
   ."&SIGNATURE=$signature";
   
	
	$token = $_GET['token'];
	$PayerID = $_GET['PayerID'];
	
	$nvpset= $nvps."&localecode=US"
	 ."&SOLUTIONTYPE=Sole"
	 ."&method=DoExpressCheckoutPayment"
	 ."&token=$token"
	 ."&payerid=$PayerID"
	 ."&version=76.0"	
	 ."&paymentrequest_0_currencycode=JPY"
	 ."&paymentrequest_0_amt=34"
	 // ."&paymentrequest_0_itemamt=34.95"
	 // ."&paymentrequest_0_taxamt=0.00"
	 ."&paymentrequest_0_custom=wc_order_5359dcc2eee4f"
	 ."&paymentrequest_0_desc=Payment for Order #888"
	 // ."&paymentrequest_0_invnum=812188"
	 ."&paymentrequest_0_paymentaction=Sale"
	 ."&L_PAYMENTREQUEST_0_NAME0=dsadsadad "
	 ."&L_PAYMENTREQUEST_0_QTY0=1"
	  ."&PAYMENTREQUEST_0_SHIPTOPHONENUM=317-533-4877"
	 // ."&paymentrequest_0_taxamt=0.00"
	 ."&L_PAYMENTREQUEST_0_AMT0=34";
	
	  $response = RunAPICall($nvpset); 
	echo '<pre>';
	print_r($response);exit;
	
	
	
	//Make API call
function RunAPICall($nvps){
global $url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 45);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$nvps);
 
$result = curl_exec($ch);
    $httpResponseAr = explode("&", strtoupper($result));
    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $value) {
        $tmpAr = explode("=", $value);
        if(sizeof($tmpAr) > 1) {
            $httpParsedResponseAr[$tmpAr[0]] = urldecode($tmpAr[1]);
        }
    }

curl_close ($ch); 
return $httpParsedResponseAr;
}?>