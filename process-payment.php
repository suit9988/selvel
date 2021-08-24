<?php
	include_once 'include/functions.php';
	$functions = new Functions();

	require('include/Razorpay/Razorpay.php');
	use Razorpay\Api\Api;
	use Razorpay\Api\Errors\SignatureVerificationError;

	if(!$loggedInUserDetailsArr = $functions->sessionExists()) {
		// header("location: ".BASE_URL);
		// exit;
		$email = $functions->escape_string($functions->strip_all($_SESSION[SITE_NAME]['BILLADDRESS']['email']));
		$customerRS = $functions->query("select * from ".PREFIX."customers where email='".$email."'");
		if($functions->num_rows($customerRS)>0) {
			$customerDetails = $functions->fetch($customerRS);
			$first_name = $customerDetails['first_name'];
			$id = $customerDetails['id'];
		} else {
			$first_name = $_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress']['customer_fname'];
			$functions->query("insert into ".PREFIX."customers(first_name, email, user_type) values ('".$first_name."', '".$email."', 'Guest')");
			$id = $functions->last_insert_id();
		}
		$functions->loginSession($id, $first_name, "", 'customer');

		$addressId = $functions->addCustomerAddress($_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress'], $id);
		$_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $addressId;

		if(isset($_POST['sameshipping'])) {
			if($_POST['sameshipping']==1) {
				$_SESSION[SITE_NAME]['BILLADDRESS']['Billing'] = $_SESSION[SITE_NAME]['BILLADDRESS']['shipping'];
			} else {
				$addressId = $functions->addCustomerAddress($_POST, $id);
				$_SESSION[SITE_NAME]['BILLADDRESS']['Billing'] = $addressId;
			}
		}
	}
	$loggedInUserDetailsArr = $functions->sessionExists();

	/* if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL);
		exit;
	} */
	if(isset($_POST['paymentMode']) && !empty($_POST['paymentMode'])) {
		include_once('include/classes/Cart.class.php');
		if(!isset($cartObj)){
			$cartObj = new Cart();
		}
		if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){
			$getAddress = $functions->getAddressByAddressid($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'],$loggedInUserDetailsArr);
			if($functions->num_rows($getAddress)>0){
				$addressShipDetails = $functions->fetch($getAddress);
			} else {
				header("location:checkout.php");
				exit;
			}
		} else{
			$addressId = $functions->addCustomerAddress($_POST, $loggedInUserDetailsArr['id']);
			$_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $addressId;
		}
		$orderDetails = $functions->processTransaction($cartObj, $loggedInUserDetailsArr, $_REQUEST);

		$finalGatewatAmt = 1;
		// $finalGatewatAmt = $orderDetails['cartPriceDetails']['finalTotal'];

		if(isset($_POST['paymentMode']) && $_POST['paymentMode']=="COD"){
			header("location:payment-complete-cod.php?txnId=".$orderDetails['txnId']);
			exit;
		}

		$paymentAmount = $finalGatewatAmt * 100;
		// $paymentAmount = $finalGatewatAmt * 100;
		$api = new Api(RAZORPAY_API_KEY_ID, RAZORPAY_API_KEY_SECRET);
		$order  = $api->order->create([
			'receipt'         => $orderDetails['txnId'],
			'amount'          => $paymentAmount,
			'currency'        => 'INR',
			'payment_capture' =>  '1',
		]);
		$razorpay_order_id = $order->id;

		$functions->query("update ".PREFIX."order set razorpay_order_id='".$razorpay_order_id."' where id='".$orderDetails['orderId']."'");
	}
?>
<!DOCTYPE>
<html>
<head>
	<title>Selvel</title>

	<?php include("include/header-link.php");?>
	<style>
		.razorpay-payment-button{
			display: none;
		}
	</style>
</head>
<body class="thankyoubody">
	<!--Top start menu head-->
	<?php include("include/header.php");?>
	<main class="main-inner-div">

	         <img src="images/details-banner-header.jpg" class="img-full fixedimg">  
	<div class="content-body">
		<section class="breadcrumbesection">
			
		</section>

		<div class="container-fluid processpaymet" id="paymenpageiso">
			<div class="row">
				<div class="col-md-12">
					<section class="thankyou text-center">
						<div class="site-header" id="header">
							<p class="site-header__title" data-lead-id="site-header-title"><i class="fa fa-refresh fa-spin"></i> Processing Payment!</p>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</main>
	<!--Main End Code Here-->
	<!--footer start menu head-->
	<?php include("include/footer.php");?> 
	<!--footer end menu head-->
	<?php include("include/footer-link.php");?>
	<script>
		/* $(document).ready(function() {
			$(".razorpay-payment-button").click();
		}); */
	</script>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script type="text/javascript">
		var txn_id = "<?php echo $orderDetails['txnId']; ?>";			

		var options = {
			"key": "<?php echo RAZORPAY_API_KEY_ID; ?>",
			"amount": <?php echo $paymentAmount; ?>, // 2000 paise = INR 20
			"currency": "INR",
			"name": "SELVEL",
			"description": "Product Purchase Payment",
			"order_id": '<?php echo $razorpay_order_id; ?>',
			"image": "<?php echo LOGO ?>",
			"handler": function (responseData) {
				var razorpay_signature = responseData.razorpay_signature;
				var razorpay_payment_id = responseData.razorpay_payment_id;
				var razorpay_order_id = responseData.razorpay_order_id;
				$.ajax({
					url:"<?php echo BASE_URL; ?>/payment-complete.php",
					data:{razorpay_payment_id: razorpay_payment_id, razorpay_signature: razorpay_signature, razorpay_order_id: razorpay_order_id},
					type:"POST",
					success: function(responseUpdate){
						var responseUpdate = JSON.parse(responseUpdate);
						if(responseUpdate.response.success=="true") {
							window.location.replace("<?php echo BASE_URL ?>/thankyou.php?txnId=<?php echo $orderDetails['txnId'] ?>");
						} else {
							window.location.replace("<?php echo BASE_URL ?>/payment-error.php?error="+responseUpdate.response.message);
						}
					},
					error: function(){alert("Unable to process payment, please try again");},
					complete: function(response) {
						
					}
				});
			},
			"modal": {
		        "ondismiss": function(){
		        	window.location.replace("<?php echo BASE_URL; ?>/chekout-order-summary.php");
		        }
		    },
			"prefill": {
				"name": "<?php echo $loggedInUserDetailsArr['first_name']; ?>",
				"email": "<?php echo $loggedInUserDetailsArr['email']; ?>",
				"contact": "<?php echo $loggedInUserDetailsArr['mobile']; ?>"
			},
			"notes": {
				"address": ""
			},
			"theme": {
				"color": "#000000"
			}
		};
		var rzp1 = new Razorpay(options);
		
		rzp1.open();
	</script>
</body>
</html>