<?php 
	include_once 'include/functions.php';
	$functions = new Functions();

	if(!$loggedInUserDetailsArr = $user->sessionExists()){
		header("location: login.php");
		exit;
	}

	if(isset($_GET['txnId']) && !empty($_GET['txnId'])){
		$txnId = $user->escape_string($user->strip_all($_GET['txnId']));
		$response = $user->purchaseOfProductOrderFailed($loggedInUserDetailsArr['id'], $txnId);
	} else {
		header("location: payment-error.php");
		exit;
	}
?>
<!DOCTYPE>
<html>
<head>
	<title>Paper Panda</title>
	<?php include("include/header-link.php");?>
</head>
<body class="template-body">
	<!--Top start menu head-->
	<?php include("include/header.php");?>
	<div class="main-content">
		<div class="container">
			<div class="row">
				<div class="thankyoubox">
					<h1>Payment Error!</h1>
					<p class="thankp"><b>Your transaction was not processed.</b></p>
					<div class="thanksbox">
						<p class="thankscontent">
							This can happen if an error occurred on the payment gateway while processing your transaction or if you have cancelled the transaction.
						</p>
						<a href="<?php echo BASE_URL; ?>/chekout-order-summary.php">Back to Checkout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Main End Code Here-->
	<!--footer start menu head-->
	<?php include("include/footer.php");?> 
	<!--footer end menu head-->
	<?php include("include/footer-link.php");?>
	<script>

	</script>
</body>
</html>