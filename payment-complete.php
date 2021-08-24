<?php
	include_once 'include/functions.php';
	$functions = new Functions();

	require('include/Razorpay/Razorpay.php');
	use Razorpay\Api\Api;
	use Razorpay\Api\Errors\SignatureVerificationError;

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}

	if(!isset($_POST['razorpay_payment_id'])) {
		header("location: payment-error.php?INVALIDACCESS");
		exit;
	}

	$response = array();

	if(isset($_POST['razorpay_order_id']) && !empty($_POST['razorpay_order_id'])) {
		$razorpay_order_id = $functions->escape_string($functions->strip_all($_POST['razorpay_order_id']));
		$razorpay_payment_id = $functions->escape_string($functions->strip_all($_POST['razorpay_payment_id']));
		$razorpay_signature = $functions->escape_string($functions->strip_all($_POST['razorpay_signature']));

		$paymentDetailsRS = $functions->query("select * from ".PREFIX."order where razorpay_order_id='".$razorpay_order_id."'");
		if($functions->num_rows($paymentDetailsRS)>0) {
			$success = "true";

			$api = new Api(RAZORPAY_API_KEY_ID, RAZORPAY_API_KEY_SECRET);
			$attributes  = array(
				'razorpay_signature'  => $_POST['razorpay_signature'],
				'razorpay_payment_id'  => $_POST['razorpay_payment_id'],
				'razorpay_order_id' => $_POST['razorpay_order_id']
			);

			try {
				$order  = $api->utility->verifyPaymentSignature($attributes);
				$message = 'Success';
			} catch(SignatureVerificationError $e) {
				$success = "false";
				$message = 'Razorpay Error : ' . $e->getMessage();
			}
		} else {
			$success = "false";
		}

		if($success=="true") {
			$paymentDetails = $functions->fetch($paymentDetailsRS);
			$txnId = $paymentDetails['txn_id'];

			$result = $functions->completePurchaseOfProductOrder($loggedInUserDetailsArr, $txnId);
		}
		
		if($result){
			$purchaseDetails = $functions->getPurchasedProductOrderDetails($loggedInUserDetailsArr['id'], $txnId);
			if($purchaseDetails){
				// prepare data for email
				$order = $purchaseDetails['order'];
				$orderDetails = $purchaseDetails['orderDetails'];

				//$paymentAmount = $orderDetails['cartPriceDetails']['finalTotal'];

				$customerDetails = $functions->getUniqueUserById($order['customer_id']);

				// send email
				$emailSubject = "Invoice - ".$order['txn_id']." - ". SITE_NAME;
				include_once("include/cart/invoice-email.inc.php"); // $invoiceMsg
				include_once("include/classes/Email.class.php");
				$emailObj = new Email();
				$emailObj->setEmailBody($invoiceMsg);
				$emailObj->setSubject($emailSubject);
				$emailObj->setAddress($customerDetails['email']); // send email to registered email
				$emailObj->sendEmail(); // UNCOMMENT

				// send email to admin
				include_once("include/classes/Email.class.php");
				$emailSubject = SITE_NAME;
				$invoiceMsg = "New order has been placed";
				$adminEmail = $functions->getAdminDetails()['email'];
				$emailObj = new Email();
				$emailObj->setEmailBody($invoiceMsg);
				$emailObj->setSubject($emailSubject);
				$emailObj->setAddress($adminEmail); // send email to registered email
				$emailObj->sendEmail(); // UNCOMMENT

				// msg sent to user
				/* include_once("include/classes/SMS.class.php");
				$otpObj = new SMS();
				$otpMsg = SITE_NAME." \n";
				$otpMsg .= "Your order has been successfully placed. \n";
				$otpMsg .= "Your order innvoice - ".$order['txn_id'];
				$otpObj->setAddress($customerDetails['mobile']);
				$otpObj->setMessage($otpMsg);
				$smsResponse = $otpObj->sendSMS();

				// msg sent to admin
				include_once("include/classes/SMS.class.php");
				$otpObj = new SMS();
				$adminMobile = $functions->getAdminDetails()['mobile'];
				$otpMsg = SITE_NAME." \n";
				$otpMsg .= "New order has been placed. \n";
				$otpObj->setAddress($adminMobile);
				$otpObj->setMessage($otpMsg);
				$smsResponse = $otpObj->sendSMS(); */

			} else {
				// email was not sent, because order with that txn_id for that customer was NOT found
				// payment status was not updated
				$success = 'false';
				$message = 'TRANSACTIONPAYMENTFAILED';
			}
		} else {
			$success = 'false';
			$message = 'TRANSACTIONFAILED';
		}
	} else {
		$success = 'false';
		$message = 'INVALIDREQUEST';
	}

	$response['success'] = $success;
	$response['message'] = $message;

	$ajaxResponse = array();
	$ajaxResponse['response'] = $response;
	echo json_encode($ajaxResponse);
?>