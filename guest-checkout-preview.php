<?php 
	include_once 'include/functions.php';
	$functions = new Functions();

	if(!$_SESSION[SITE_NAME]['cart']) {
		header("location: index.php");
		exit;
	}

	$defaultAddress = $functions->getAddressById($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
	$defaultAddress = $functions->fetch($defaultAddress);
?>
<!DOCTYPE>
<html>
<head>
	<title>SELVEL - Checkout</title>
	<meta name="description" content="SELVEL">
	<meta name="keywords" content="SELVEL">
	<meta name="author" content="SELVEL">
	<?php include("include/header-link.php");?>
</head>
<body class="inner-page dashboard-pages chekout-order-summary-page" id="address-book">
	<!--Top start menu head-->       
	<?php include("include/header.php");?>
	<!--Main Start Code Here-->
	<main class="main-inner-div">
		<img src="images/details-banner-header.jpg" class="img-full fixedimg">        
		<div class="container breadcum-header">
			<ul>
				<li>
					<a href="guest-checkout.php" class="current-page" style="cursor: pointer;pointer-events: visible;">Information</a> 
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="javascript:void(0);" class="current-page" style="cursor: pointer;pointer-events: visible;">Shipping</a> 
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#" style="cursor: pointer;pointer-events: none;">Payment</a>                  
				</li>
			</ul>
		</div>

         <div class="container cart-container">
			<div class="inner-wrapper paddbothzero">
				<!-- <h1 class="page-heading">CHECKOUT</h1> -->
				<div class="latest-flex" id="latest-flex-news">
					<form action="process-payment.php" class="form latest-flex" id="addAddress" method="post" novalidate="novalidate">
						<section class="billing-shipping">
							<div class="billing-add match" style="">
								<div class="box-inner-ctn">
									<div class="priviewcheckout">
										<div class="row mguskodekh">
											<div class="col-md-2">
												<p class="conpss">Contact</p>
											</div>
											<div class="col-md-8">
												<p class="detailspao"><?php echo $_SESSION[SITE_NAME]['BILLADDRESS']['email'] ?></p>
											</div>
											<div class="col-md-2">
												<a href="guest-checkout.php" class="linktobsp">Change</a>
											</div>
										</div>
										<hr>
										<div class="row mguskodekh">
											<div class="col-md-2">
												<p class="conpss">Ship to</p>
											</div>
											<div class="col-md-8">
												<p class="detailspao"><?php echo $functions->getDisplayAddress($_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress']," "); ?></p>
											</div>
											<div class="col-md-2">
												<a href="guest-checkout.php" class="linktobsp">Change</a>
											</div>
										</div>
									</div>
									<div class="section section--shipping-method">
										<div class="section__header">
											<h3 class="section__title" id="main-header" tabindex="-1">
												Shipping method
											</h3>
										</div>
										<div class="section__content">
											<div class="content-box">
												<div class="content-box__row">
													<div class="radio-wrapper" >
														<div class="radio__input">
															<input style="display: none;" class="input-radio-plus" name="frosomepayment" type="radio" checked="checked">
														</div>
														<?php
															$shippingChargeDetails = $functions->fetch($functions->query("select * from ".PREFIX."shipping_charge"));
															$totalWeight = 0;
															$cartObj = new Cart;
															$cartArr = $cartObj->getCart();
															foreach($cartArr as $oneProduct){
																$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."' and productcolor='".$oneProduct['color']."'"));
																$totalWeight = $totalWeight + $getProductsizeDetails['weight'];
															}
															$d_pin = $_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress']['pincode'];

															$shippingURL = "https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?ss=Delivered&pt=Pre-paid&cgm=".$totalWeight."&cl=SELVEL 0064514&md=S&o_pin=400063&d_pin=".$d_pin;

															$headers = array();
															$headers[] = 'Authorization: Token ecb8abc65cb0076e95617e2c67c21c7656fd8a9f';

															$curl = curl_init();
															curl_setopt_array($curl, array(
																CURLOPT_RETURNTRANSFER => 1,
																CURLOPT_URL => $shippingURL,
																CURLOPT_USERAGENT => '',
															));
															curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
															// Send the request & save response to $resp
															$resp = curl_exec($curl); // Getting jSON result string
															$responseArr = json_decode($resp, true);
															$shippingCharges = $responseArr[0]['total_amount'];
														?>
														<label class="radio__label" for="frosomepayment">
															<span class="radio__label__primary">
																Shipping
															</span>
															<span class="radio__label__accessory">
																<span class="content-box__emphasis">
																	<!-- MRP --> Rs. <?php echo $shippingCharges ?>
																</span>
															</span>
														</label>
													</div>
													<!-- /radio-wrapper-->
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									<p id="billError" style="color:red;"></p>
									<div class="checkout-btns flestarvatas">
										<a href="guest-checkout.php" class="shop-now-btn dark-yellow-btn text-center">Return to Information</a>
										<a href="guest-checkout-payment.php" class="shop-now-btn purple-btn text-center sbtbnall">Continue to payment</a>
										<!-- <a href="" class="shop-now-btn dark-yellow-btn text-center">Continue Shopping</a>                                     -->
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</section>
						<div id="checkout-cart-wrapper">
							<?php 
								include_once "include/cart/checkout-cart-page.inc.php";
								echo $checkoutCartPageHTML;
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>
	<!--Main End Code Here-->
	<!--footer start menu head-->
	<?php include("include/footer.php");?> 
	<!--footer end menu head-->
	<?php include("include/footer-link.php");?>
   </body>
</html>