<?php 

class PPLShortcode {

    var $ppl = null;
    var $paypalf = null;

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;
    protected static $payment_buttons = array();

    function __construct() {
		global $ct_options;
		
        $this->ppl = PPL::get_instance();
        $this->paypalf = PayPalFunctions::get_instance();

        //add_shortcode('paypal_for_listings', array(&$this, 'shortcode_paypal_for_listings'));
        add_shortcode('ppl_checkout', array(&$this, 'shortcode_ppl_checkout'));
        if (!is_admin()) {
            add_filter('widget_text', 'do_shortcode');
        }

        add_action('wp_footer', array(&$this, 'hook_footer'));
        add_action('wp', array(&$this, 'interfer_for_redirect'));
    }

    public function interfer_for_redirect() {
        global $post;
        if (!is_admin()) {
            if (has_shortcode($post->post_content, 'ppl_checkout')) {
                $this->shortcode_ppl_checkout();
                exit;
            }
        }
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function ct_paypal( ) {
		global $ct_options, $post;
		ob_start();
		$ct_currency_code = isset( $ct_options['ct_currency_code'] ) ? esc_attr( $ct_options['ct_currency_code'] ) : 'USD';

		$name = 'Listing ID-' . $post->ID;
		$url = get_the_permalink($post->ID);
		$url = base64_encode($url);
        $button_id = 'paypal_button_' . count(self::$payment_buttons);
        self::$payment_buttons[] = $button_id;
		$price = 10;

        $trans_name = 'wp-ppl-' . sanitize_title_with_dashes($name);//Create key using the item name.
        set_transient( $trans_name, $price, 2 * 3600 );//Save the price for this item for 2 hours.
		
		?>
        <input type='submit' class='btn' name='submit' value='Pay with PayPal' alt='PayPal - The safer, easier way to pay online'>
			<div class='payment-drop'>
				<form action='<?php echo $ct_options['checkout_url']; ?>' METHOD='POST' class='paypalbutton marB0 left'>
					<div class='submission-fee'>
						<!--<input type='hidden' name='item_price' value='<?php echo $total; ?>' /> -->
						<?php echo _e('Cost:', 'contempo'); ?>
						<span class='cost right'>$10</span>
					</div>
					<div class='featured-fee'>
						<input type='checkbox' name='featured' />
						<?php echo _e('Featured?', 'contempo'); ?>
						<span class='cost right'>$5</span>
					</div>
					<div class='total'>
						<input type='hidden' name='total' />
						<?php echo _e('Total:', 'contempo'); ?>
						<span class='cost right'><?php echo $total; ?></span>
					</div>
					<input type='hidden' name='business' value='<?php echo esc_attr($ct_options['ct_paypal_addy']); ?>' />
					<input type='hidden' value='<?php echo $name; ?>' name='item_name' />
					<input type='hidden' value='1' name='item_quantity' />
					<input type='hidden' value='<?php echo $ct_currency_code; ?>' name='currency_code' />
					<input type='hidden' value='<?php echo $url; ?>' name='url' />
					<input type='hidden' value='checkout' name='step' />
		
					<button name='paypal_submit' class='paypal_submit' id='<?php echo $button_id; ?>' alt='PayPal'>Pay With PayPal</button>
				</form>
			</div>
		<?php 
        return ob_get_clean();
        // src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top'
    }

    public function hook_footer() {
        // PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.

        if (count(self::$payment_buttons) > 0) {
            echo "<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>";

            echo "<script type='text/javascript'>";
            foreach (self::$payment_buttons as $button_id) {

                echo " var dg = new PAYPAL.apps.DGFlow(
						{
							trigger: '{$button_id}',
							expType: 'instant'
						});
					";
            }
            echo "</script>";
        }
    }

    public function shortcode_ppl_checkout() {
        $step = '';
        if (!empty($_REQUEST['step'])) {
            $step = sanitize_text_field($_REQUEST['step']);
        }
        switch ($step) {
            case 'checkout':
                // ==================================
                // PayPal Express Checkout Module
                // ==================================
                //' The paymentAmount is the total value of 
                //' the purchase.
                //'------------------------------------

                //Sanitization
                $item_name = sanitize_text_field($_POST['item_name']);
                if (empty($item_name)) {
                    wp_die('Error! Product name must not be empty.');
                }                
                $item_qty = sanitize_text_field($_POST['item_quantity']);
                if(!is_numeric($item_qty)){
                    wp_die('Error! Item quantity must be a numeric value.');
                }
                $currency_code = sanitize_text_field($_POST['currency_code']);
                if (empty($currency_code)) {
                    wp_die('Error! Please specify currency code either in the shortcode or in General > PPL section in admin panel.');
                }
                
                //Read the price for this item from the system.
                $trans_name = 'wp-ppl-' . sanitize_title_with_dashes($item_name);
                $price = get_transient($trans_name);
                
                //Validate the price
                if (!is_numeric($price)) {
                    wp_die('Error! Product price must be a numeric value.');
                }                
                if (empty($price)) {
                    wp_die('Error! Product price must not be zero.');
                }
                
                $paymentAmount = $price * $item_qty;

                //'------------------------------------
                //' The currencyCodeType  
                //' is set to the selections made on the Integration Assistant 
                //'------------------------------------
                $currencyCodeType = strtoupper($currency_code);
                $paymentType = "Sale";

                //'------------------------------------
                //' The returnURL is the location where buyers return to when a
                //' payment has been succesfully authorized.
                //'
                //' This is set to the value entered on the Integration Assistant 
                //'------------------------------------
                //$returnURL = $this->ppl->get_setting('checkout_url') . '?step=confirm';
                $returnURL = add_query_arg( 'step', 'confirm', $ct_options['checkout_url'] );

                //'------------------------------------
                //' The cancelURL is the location buyers are sent to when they hit the
                //' cancel button during authorization of payment during the PayPal flow
                //'
                //' This is set to the value entered on the Integration Assistant 
                //'------------------------------------
                //$cancelURL = $this->ppl->get_setting('checkout_url') . '?step=cancel';
                $cancelURL = add_query_arg( 'step', 'cancel', $ct_options['checkout_url'] );

                //'------------------------------------
                //' Calls the SetExpressCheckout API call
                //'
                //' The CallSetExpressCheckout function is defined in the file PayPalFunctions.php,
                //' it is included at the top of this file.
                //'-------------------------------------------------


                $items = array();
                $items[] = array('name' => $item_name, 'amt' => $price, 'qty' => $item_qty);

                //::ITEMS::
                // to add anothe item, uncomment the lines below and comment the line above 
                // $items[] = array('name' => 'Item Name1', 'amt' => $itemAmount1, 'qty' => 1);
                // $items[] = array('name' => 'Item Name2', 'amt' => $itemAmount2, 'qty' => 1);
                // $paymentAmount = $itemAmount1 + $itemAmount2;
                // assign corresponding item amounts to "$itemAmount1" and "$itemAmount2"
                // NOTE : sum of all the item amounts should be equal to payment  amount 

                $resArray = $this->paypalf->SetExpressCheckoutDG($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL, $items);

                $ack = strtoupper($resArray["ACK"]);
                if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
                    $token = urldecode($resArray["TOKEN"]);
                    $pfdg_txn_data = array('token' => $token, 'item_f_val' => sanitize_text_field($_POST['item_f_val']));
                    $_SESSION['pfdg_resarray'] = $pfdg_txn_data;
                    $this->paypalf->RedirectToPayPalFunctions($token);
                } else {
                    //Display a user friendly Error on the page using any of the following error information returned by PayPal
                    $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                    $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                    $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                    $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

                    echo __("SetExpressCheckout API call failed. ");
                    echo __("Detailed Error Message: ") . $ErrorLongMsg;
                    echo __("Short Error Message: ") . $ErrorShortMsg;
                    echo __("Error Code: ") . $ErrorCode;
                    echo __("Error Severity Code: ") . $ErrorSeverityCode;
                }
                break;
            case 'cancel':
                include dirname(dirname(__FILE__)) . '/views/cancel.php';
                break;
            case 'confirm':
                $res = $this->paypalf->GetExpressCheckoutDetails(sanitize_text_field($_REQUEST['token']));

                // The paymentAmount is the total value of the purchase. 
                $finalPaymentAmount = $res["PAYMENTREQUEST_0_AMT"];

                //Format the  parameters that were stored or received from GetExperessCheckout call.
                $token = sanitize_text_field($_REQUEST['token']);
                $payerID = sanitize_text_field($_REQUEST['PayerID']);
                $paymentType = 'Sale';
                $currencyCodeType = $res['CURRENCYCODE'];
                $items = array();
                $i = 0;
                // adding item details those set in setExpressCheckout
                while (isset($res["L_PAYMENTREQUEST_0_NAME$i"])) {
                    $items[] = array('name' => $res["L_PAYMENTREQUEST_0_NAME$i"], 'amt' => $res["L_PAYMENTREQUEST_0_AMT$i"], 'qty' => $res["L_PAYMENTREQUEST_0_QTY$i"]);
                    $i++;
                }


                $resArray = $this->paypalf->ConfirmPayment($token, $paymentType, $currencyCodeType, $payerID, $finalPaymentAmount, $items);
                $ack = strtoupper($resArray["ACK"]);

                if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
                    $order = OrdersPPL::get_instance();
                    $order->insert($res, $resArray);

                    do_action('ppl_payment_completed', $res, $resArray);

                    $GLOBALS['PaymentSuccessfull'] = true;
                    $item_url = '';
                    if (isset($_SESSION['pfdg_resarray'])) {
                        $pfdg_txn_data = $_SESSION['pfdg_resarray'];
                        $saved_token = $pfdg_txn_data['token'];
                        if ($saved_token == $token) {
                            $item_url = base64_decode($pfdg_txn_data['item_f_val']);
                        }
                    }
                    /*
                     * TODO: Proceed with desired action after the payment 
                     * (ex: start download, start streaming, Add coins to the game.. etc)
                      '********************************************************************************************************************
                      '
                      ' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE
                      '                    transactionId & orderTime
                      '  IN THEIR OWN  DATABASE
                      ' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT
                      '
                      '********************************************************************************************************************
                     */

                    $transactionId = $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // Unique transaction ID of the payment.
                    $transactionType = $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; // The type of transaction Possible values: l  cart l  express-checkout
                    $paymentType = $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  // Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant
                    $orderTime = $resArray["PAYMENTINFO_0_ORDERTIME"];  // Time/date stamp of payment
                    $amt = $resArray["PAYMENTINFO_0_AMT"];  // The final amount charged, including any  taxes from your Merchant Profile.
                    $currencyCode = $resArray["PAYMENTINFO_0_CURRENCYCODE"];  // A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD.
                    // $feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  // PayPal fee amount charged for the transaction
                    //	$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  // Amount deposited in your PayPal account after a currency conversion.
                    // $taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  // Tax charged on the transaction.
                    //	$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  // Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.

                    $paymentStatus = $resArray["PAYMENTINFO_0_PAYMENTSTATUS"];

                    /*
                      'The reason the payment is pending:
                      '  none: No pending reason
                      '  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile.
                      '  echeck: The payment is pending because it was made by an eCheck that has not yet cleared.
                      '  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview.
                      '  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.
                      '  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.
                      '  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service.
                     */

                    $pendingReason = $resArray["PAYMENTINFO_0_PENDINGREASON"];

                    /*
                      'The reason for a reversal if TransactionType is reversal:
                      '  none: No reason code
                      '  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer.
                      '  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee.
                      '  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer.
                      '  refund: A reversal has occurred on this transaction because you have given the customer a refund.
                      '  other: A reversal has occurred on this transaction due to a reason not listed above.
                     */

                    $reasonCode = $resArray["PAYMENTINFO_0_REASONCODE"];

                    // Add javascript to close Digital Goods frame. You may want to add more javascript code to
                    // display some info message indicating status of purchase in the parent window
                } else {

                    $GLOBALS['PaymentSuccessfull'] = false;
                    //Display a user friendly Error on the page using any of the following error information returned by PayPal
                    $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                    $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                    $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                    $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

                    echo __("DoExpressCheckoutDetails API call failed. ");
                    echo __("Detailed Error Message: ") . $ErrorLongMsg;
                    echo __("Short Error Message: ") . $ErrorShortMsg;
                    echo __("Error Code: ") . $ErrorCode;
                    echo __("Error Severity Code: ") . $ErrorSeverityCode;
                }

                include dirname(dirname(__FILE__)) . '/views/confirm.php';
                break;
            default:
                break;
        }
    }

}