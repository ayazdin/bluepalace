<?php
require_once("../../../../../../wp-load.php");
	$ct_options = get_option('ct_options');
	$ct_currency_code = isset( $ct_options['ct_currency_code'] ) ? esc_attr( $ct_options['ct_currency_code'] ) : 'USD';
	$API_UserName = $ct_options['ct_paypal_api_username'];
	$API_Password = $ct_options['ct_paypal_api_password'];
	$API_Signature = $ct_options['ct_paypal_api_signature'];
	$returnURL = get_template_directory_uri().'/admin/gateways/PayPal/process.php';
	$cancelURL = site_url().'/my-listings/';
  //start session in all pages
  //if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
  //if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

	// sandbox or live
	if ('sandbox' == $ct_options['ct_paypal_mode']) {
		define('PPL_MODE', 'sandbox');
	} else {
		define('PPL_MODE', 'live');
	}

	if(PPL_MODE=='sandbox'){
		
		define('PPL_API_USER', $API_UserName);
		define('PPL_API_PASSWORD', $API_Password);
		define('PPL_API_SIGNATURE', $API_Signature);
	}
	else{
		
		define('PPL_API_USER', $API_UserName);
		define('PPL_API_PASSWORD', $API_Password);
		define('PPL_API_SIGNATURE', $API_Signature);
	}
	
	define('PPL_LANG', 'EN');
	
	define('PPL_LOGO_IMG', 'http://contempothemes.com/re7-dev/wp-content/themes/realestate-7/images/re7-logo.png');
	
	define('PPL_RETURN_URL', $returnURL );
	define('PPL_CANCEL_URL', $cancelURL );

	define('PPL_CURRENCY_CODE', 'USD');
	function _GET($label='',$default='',$set_default=false){
		
		$value=$default;
		
		if(isset($_GET[$label])&&!empty($_GET[$label])){
			
			$value=$_GET[$label];
		}
		
		if($set_default===true&&(!isset($_GET[$label])||$_GET[$label]=='')){
			
			$_GET[$label]=$default;
		}

		return $value;		
	}
	
	function _POST($label='',$default='',$set_default=false){
		
		$value=$default;
		
		if(isset($_POST[$label])&&!empty($_POST[$label])){
			
			$value=$_POST[$label];
		}

		if($set_default===true&&(!isset($_POST[$label])||$_POST[$label]=='')){
			
			$_POST[$label]=$default;
		}		
		
		return $value;		
	}	
	
	function _SESSION($label='',$default='',$set_default=false){
		
		$value=$default;
		
		if(isset($_SESSION[$label])&&!empty($_SESSION[$label])){
			
			$value=$_SESSION[$label];
		}
		
		if($set_default===true&&(!isset($_SESSION[$label])||$_SESSION[$label]=='')){
			
			$_SESSION[$label]=$default;
		}	

		return $value;		
	}	

class MyPayPal {
		
		function GetItemTotalPrice($item){
		
			//(Item Price x Quantity = Total) Get total amount of product;
			return $item['ItemPrice'] * $item['ItemQty']; 
		}
		
		function GetProductsTotalAmount($products){
		
			$ProductsTotalAmount=0;

			foreach($products as $p => $item){
				
				$ProductsTotalAmount = $ProductsTotalAmount + $this -> GetItemTotalPrice($item);	
			}
			
			return $ProductsTotalAmount;
		}
		
		function GetGrandTotal($products, $charges){
			
			//Grand total including all tax, insurance, shipping cost and discount
			
			$GrandTotal = $this -> GetProductsTotalAmount($products);
			
			foreach($charges as $charge){
				
				$GrandTotal = $GrandTotal + $charge;
			}
			
			return $GrandTotal;
		}
		
		function SetExpressCheckout($products, $charges, $noshipping='1'){
			
			//Parameters for SetExpressCheckout, which will be sent to PayPal
			
			$padata  = 	'&METHOD=SetExpressCheckout';
			
			$padata .= 	'&RETURNURL='.urlencode(PPL_RETURN_URL);
			$padata .=	'&CANCELURL='.urlencode(PPL_CANCEL_URL);
			$padata .=	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
			
			foreach($products as $p => $item){
				
				$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
				$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
				$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
				$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
				$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);
			}		

			/* 
			
			//Override the buyer's shipping address stored on PayPal, The buyer cannot edit the overridden address.
			
			$padata .=	'&ADDROVERRIDE=1';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTONAME=J Smith';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOSTREET=1 Main St';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOCITY=San Jose';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOSTATE=CA';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=US';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOZIP=95131';
			$padata .=	'&PAYMENTREQUEST_0_SHIPTOPHONENUM=408-967-4444';
			
			*/
						
			$padata .=	'&NOSHIPPING='.$noshipping; //set 1 to hide buyer's shipping address, in-case products that does not require shipping
						
			$padata .=	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
			
			$padata .=	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
			$padata .=	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
			$padata .=	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
			$padata .=	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
			$padata .=	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
			
			//paypal custom template
			
			$padata .=	'&LOCALECODE='.PPL_LANG; //PayPal pages to match the language on your website;
			$padata .=	'&LOGOIMG='.PPL_LOGO_IMG; //site logo
			$padata .=	'&CARTBORDERCOLOR=FFFFFF'; //border color of cart
			$padata .=	'&ALLOWNOTE=1';
						
			############# set session variable we need later for "DoExpressCheckoutPayment" #######
			
			$_SESSION['ppl_products'] =  $products;
			$_SESSION['ppl_charges'] 	=  $charges;
			
			$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata);
			
			//Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
			
				//Redirect user to PayPal store with Token received.
				
				$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				
				header('Location: '.$paypalurl);
			}
			else{
				
				//Show error message
				
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
				echo '<pre>';
					
					print_r($httpParsedResponseAr);
				
				echo '</pre>';
			}	
		}		
		
			
		function DoExpressCheckoutPayment(){
						
			if(!empty(_SESSION('ppl_products'))){
				
				$products=_SESSION('ppl_products');
				
				$charges=_SESSION('ppl_charges');
				
				$padata  = 	'&TOKEN='.urlencode(_GET('token'));
				$padata .= 	'&PAYERID='.urlencode(_GET('PayerID'));
				$padata .= 	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
				
				//set item info here, otherwise we won't see product details later	
				
				foreach($products as $p => $item){
					
					$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
					$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
					$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
					$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
					$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);
				}
				
				$padata .= 	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
				// $padata .= 	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
				// $padata .= 	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
				// $padata .= 	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
				// $padata .= 	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
				// $padata .= 	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
				$padata .= 	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
				$padata .= 	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
				
				//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
				
				$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $padata);
					
				//vdump($httpParsedResponseAr);

				//Check if everything went ok..
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

					echo '<h2>Success</h2>';
					echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
				
					/*
					//Sometimes Payment are kept pending even when transaction is complete. 
					//hence we need to notify user about it and ask him manually approve the transiction
					*/
					
					if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						
						echo '<div style="color:green">Payment Received! Your Listing will now be seen your customers!</div>';
					}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						
						echo '<div style="color:red">Transaction Complete, but payment may still be pending! '.
						'If that\'s the case, You can manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
					}
					
					$this->GetTransactionDetails();
				}
				else{
						
					echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					
					echo '<pre>';
					
						print_r($httpParsedResponseAr);
						
					echo '</pre>';
				}
			}
			else{
				
				// Request Transaction Details
				
				$this->GetTransactionDetails();
			}
		}
				
		function GetTransactionDetails(){
		
			// we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
			// GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
			
			$padata = 	'&TOKEN='.urlencode(_GET('token'));
			
			$httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $padata, PPL_API_USER, PPL_API_PASSWORD, PPL_API_SIGNATURE, PPL_MODE);

			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
				require_once("../../../../../../wp-load.php");
				$ct_options = get_option('ct_options');
				// set post as "Featured"

				if (html_entity_decode($httpParsedResponseAr['AMT'], ENT_COMPAT, 'UTF-8') > $ct_options['ct_price'] ){ 
					$post_id = $httpParsedResponseAr['L_NUMBER0'];
					wp_set_post_terms($post_id,'Featured','ct_status',false);
				}
				// save transaction ID to post_meta  TRANSACTIONID
				update_post_meta($post_id, '_ct_listing_paid_transaction_id', $httpParsedResponseAr['TRANSACTIONID']);
				
				// Publish or Not
				if ('pending' == $ct_options['ct_auto_publish'] ){
					// do nothing :) 
				} else {
					wp_update_post(
						array(
							'ID'    =>  $post_id,
							'post_status'   =>  'publish'
						));
				}
				$redir = get_permalink($ct_options['ct_view']);
				wp_redirect($redir.'?success=1');
				 // echo '<pre>';
					// print_r($ct_options);
					// print_r($httpParsedResponseAr);
					
				 // echo '</pre>';
			} 
			else  {
				
				echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
				echo '<pre>';
				
					print_r($httpParsedResponseAr);
					
				echo '</pre>';

			}
		}
		
		function PPHttpPost($methodName_, $nvpStr_) {
				
				// Set up your API credentials, PayPal end point, and API version.
				$API_UserName = urlencode(PPL_API_USER);
				$API_Password = urlencode(PPL_API_PASSWORD);
				$API_Signature = urlencode(PPL_API_SIGNATURE);
				
				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
		
				$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
				$version = urlencode('109.0');
			
				// Set the curl parameters.
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
				
				// Turn off the server and peer verification (TrustManager Concept).
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
			
				// Set the API operation, version, and API signature in the request.
				$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
			
				// Set the request as a POST FIELD for curl.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
			
				// Get response from the server.
				$httpResponse = curl_exec($ch);
			
				if(!$httpResponse) {
					exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
				}
			
				// Extract the response details.
				$httpResponseAr = explode("&", $httpResponse);
			
				$httpParsedResponseAr = array();
				foreach ($httpResponseAr as $i => $value) {
					
					$tmpAr = explode("=", $value);
					
					if(sizeof($tmpAr) > 1) {
						
						$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
					}
				}
			
				if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
					
					exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
				}
			
			return $httpParsedResponseAr;
		}
	}

	$paypal= new MyPayPal();
	
	//Post Data received from product list page.
	if(_GET('paypal')=='checkout'){
		
		//-------------------- prepare products -------------------------
		
		//Mainly we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
		
		//Please Note : People can manipulate hidden field amounts in form,
		//In practical world you must fetch actual price from database using item id. Eg: 
		//$products[0]['ItemPrice'] = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
		
		$products = [];
		
		
		
		// set an item via POST request
		
		$products[0]['ItemName'] = _POST('itemname'); //Item Name
		$products[0]['ItemPrice'] = _POST('itemprice'); //Item Price
		$products[0]['ItemNumber'] = _POST('itemnumber'); //Item Number
		$products[0]['ItemDesc'] = _POST('itemdesc'); //Item Number
		$products[0]['ItemQty']	= _POST('itemQty'); // Item Quantity
		
		/*
		$products[0]['ItemName'] = 'my item 1'; //Item Name
		$products[0]['ItemPrice'] = 0.5; //Item Price
		$products[0]['ItemNumber'] = 'xxx1'; //Item Number
		$products[0]['ItemDesc'] = 'good item'; //Item Number
		$products[0]['ItemQty']	= 1; // Item Quantity		
		*/
		/*
		
		// set a second item
		
		$products[1]['ItemName'] = 'my item 2'; //Item Name
		$products[1]['ItemPrice'] = 10; //Item Price
		$products[1]['ItemNumber'] = 'xxx2'; //Item Number
		$products[1]['ItemDesc'] = 'good item 2'; //Item Number
		$products[1]['ItemQty']	= 3; // Item Quantity
		*/		
		
		//-------------------- prepare charges -------------------------
		
		$charges = [];
		
		//Other important variables like tax, shipping cost
		$charges['TotalTaxAmount'] = 0;  //Sum of tax for all items in this order. 
		$charges['HandalingCost'] = 0;  //Handling cost for this order.
		$charges['InsuranceCost'] = 0;  //shipping insurance cost for this order.
		$charges['ShippinDiscount'] = 0; //Shipping discount for this order. Specify this as negative number.
		$charges['ShippinCost'] = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
		
		//------------------SetExpressCheckOut-------------------
		
		//We need to execute the "SetExpressCheckOut" method to obtain paypal token

		$paypal->SetExpressCheckOut($products, $charges);		
	}
	elseif(_GET('token')!=''&&_GET('PayerID')!=''){
		
		//------------------DoExpressCheckoutPayment-------------------		
		
		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
		//we will be using these two variables to execute the "DoExpressCheckoutPayment"
		//Note: we haven't received any payment yet.
		
		$paypal->DoExpressCheckoutPayment();
	}
	else{
		
		//order form
		

	}
