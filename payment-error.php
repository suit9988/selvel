<?php 
	include_once 'include/functions.php';
	$functions = new Functions();
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
					<p class="thankp"><b>An error occurred while processing your transaction</b></p>
					<div class="thanksbox">
						<p class="thankscontent">
							This can happen when you are not properly redirected to <?php echo SITE_NAME; ?> by the payment gateway. Your transaction is not complete, please contact <?php echo SITE_NAME; ?> for further details.
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