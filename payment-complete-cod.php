<?php
	include_once 'include/functions.php';
	$functions = new Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
      	exit;
	}

	if(isset($_GET['txnId']) && !empty($_GET['txnId'])){
		$txnId = $functions->escape_string($functions->strip_all($_GET['txnId']));

		$result = $functions->completePurchaseOfProductOrder($loggedInUserDetailsArr, $txnId);
		if($result){
			$purchaseDetails = $functions->getPurchasedProductOrderDetails($loggedInUserDetailsArr['id'], $txnId);
			if($purchaseDetails) {
				// prepare data for email
				$order = $purchaseDetails['order'];
				$orderDetails = $purchaseDetails['orderDetails'];

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
/*
				// msg sent to user
				include_once("include/classes/SMS.class.php");
				$otpObj = new SMS();
				$otpMsg = SITE_NAME." - ";
				$otpMsg .= "Your order has been successfully placed. ";
				$otpMsg .= "Your order innvoice - ".$order['txn_id'];
				$otpObj->setAddress($customerDetails['mobile']);
				$otpObj->setMessage($otpMsg);
				//$smsResponse = $otpObj->sendSMS();

				// msg sent to admin
				include_once("include/classes/SMS.class.php");
				$otpObj = new SMS();
				$adminMobile = $functions->getAdminDetails()['mobile'];
				$otpMsg = SITE_NAME." \n";
				$otpMsg .= "New order has been placed. \n";
				$otpObj->setAddress($adminMobile);
				$otpObj->setMessage($otpMsg);
				//$smsResponse = $otpObj->sendSMS();
*/
				header("location: ".BASE_URL."/thankyou.php?codSuccess&codTxnId=".$txnId);
				exit;
			} else {
				// email was not sent, because order with that txn_id for that customer was NOT found
				// payment status was not updated
				header("location: ".BASE_URL."/payment-error.php?error=TRANSACTIONPAYMENTFAILED");
				exit;
			}
		} else {
			header("location: ".BASE_URL."/payment-error.php?error=TRANSACTIONFAILED");
			exit;
		}
	} else {
		header("location: ".BASE_URL."/payment-error.php");
		exit;
	}
?>
<!DOCTYPE>
<html>
<head>
	<title>Selvel</title>
	<?php include("include/header-link.php");?>
</head>
<body class="login-body headerback">
	<!--Top start menu head-->
	<?php include("include/header.php");?>

	<!--Main End Code Here-->
	<section class="thankyou text-center">
		<div class="site-header" id="header">
			<h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
		</div>

		<div class="main-content">
			<?php
				if(isset($_GET['error']) && !empty($_GET['error'])){ 
					$errorArr = explode("|", $_GET['error']);
					foreach($errorArr as $oneError){
						switch($oneError){
							case "INVALIDURL":
								$text1 = "<div class=\"alert alert-danger\"><li><i class=\"fa fa-warning\"></i> This link is no longer active</li></ul></div>";
								$text2 = "Please Try Again.";
								break;
							default:
								break;
						}
					}
				}
			?>
			<div class="container">
				<p>&nbsp;</p>
				<h2 class="text-center"><?php echo $text1; ?></h2>
				<p><center><?php echo $text2; ?></center></p>
				<p>&nbsp;</p>
			</div>
		</div>
	</section>
	<!--footer start menu head-->
	<?php include("include/footer.php");?> 
	<!--footer end menu head-->
	<?php include("include/footer-link.php");?>
</body>
</html>