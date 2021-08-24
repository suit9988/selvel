<?php 
	include_once 'include/functions.php';
	$functions = new Functions();

	if(!$_SESSION[SITE_NAME]['cart']) {
		header("location: index.php");
		exit;
	}
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
					<a href="#" class="current-page" style="cursor: pointer;pointer-events: none;">Payment</a>                  
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
												<p class="detailspao"><?php echo $_SESSION[SITE_NAME]['BILLADDRESS']['email']; ?></p>
											</div>
											<div class="col-md-2">
												<a href="guest-checkout.php" class="linktobsp">Change</a>
											</div>
										</div>
										<hr>
										<div class="row mguskodekh">
											<div class="col-md-2">
												<p class="conpss">Ship To</p>
											</div>
											<div class="col-md-8">
												<p class="detailspao"><?php echo $functions->getDisplayAddress($_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress']," "); ?></p>
											</div>
											<div class="col-md-2">
												<a href="guest-checkout.php" class="linktobsp">Change</a>
											</div>
										</div>
										<hr>
										<?php
											$shippingChargeDetails = $functions->fetch($functions->query("select * from ".PREFIX."shipping_charge"));
										?>
										<?php /*
											<div class="row mguskodekh bgbtmsps">
											<div class="col-md-2">
												<p class="conpss">Method</p>
											</div>
											<div class="col-md-10">
												<p class="detailspao">Free Shipping Across India on Orders Above Rs. <?php echo $shippingChargeDetails['free_shipping_above'] ?> · <b><!-- MRP --> Rs. <?php echo $shippingChargeDetails['shipping_charges'] ?></b></p>
											</div>
										</div>
										*/?>
									</div>
									<div class="section section--shipping-method">
										<div class="section__header">
											<h3 class="section__title" id="main-header-minus" tabindex="-1">
												Payment
											</h3>
											<p class="text-left-psd">All transactions are secure and encrypted.</p>
										</div>
										<div class="section__content">
											<div class="content-box mgremocs">
												<div class="content-box__row">
													<div class="radio-wrapper">
														<div class="radio__input radioforpay">
															<input class="input-radio-plus" name="paymentMode" value="Online" id="frosomepayment1" type="radio" checked="checked">
														</div>
														<label class="radio__label" for="frosomepayment1">
															<span class="radio__label__primary">
																Razorpay (Cards, UPI, NetBanking, Wallets)
															</span>
															<ul>
																<li>
																	<img src="images/visa-card.jpg">
																</li>
																<li>
																	<img src="images/master-card.jpg">
																</li>
																<li>
																	<img src="images/american_express.jpg">
																</li>
																<li>
																	<img src="images/rupay-card.jpg">
																</li>
																<li>
																	and more..
																</li>
															</ul>
														</label>
													</div>
													<!-- /radio-wrapper-->
												</div>
											</div>
											<div class="carddetsilheres nobtmsd">
												<img src="images/offsite-cardimag.svg" class="hidedivs">
												<p class="hidedivs">
													After clicking “Complete order”, you will be redirected to Razorpay (Cards, UPI, NetBanking, Wallets) to complete your purchase securely.
												</p>
											</div>
											<div class="radio-wrapper bordersames">
												<div class="radio__input radioforpay">
													<input class="input-radio-plus" name="paymentMode" value="COD" id="frosomepayment2" type="radio" >
												</div>
												<label class="radio__label" for="frosomepayment2">
													<span class="radio__label__primary">
														Cash On Delivery
													</span>   
													<img src="images/Payment-cash.jpg">                                      
												</label>      
											</div>
										</div>
									</div>
									<div class="section section--shipping-method" id="addressmodeheres">
										<div class="section__header">
											<h3 class="section__title" id="main-header-minus" tabindex="-1">
												Billing address
											</h3>
											<p class="text-left-psd">Select the address that matches your card or payment method.</p>
										</div>
										<div class="section__content">
											<div class="content-box mgremocs">
												<div class="content-box__row">
													<input class="input-radio-plus addressdivois" name="sameshipping" value="1" id="sameaddress" type="radio" checked="checked">
													<label class="radio__label__primary " for="sameaddress">
														Same as shipping address
													</label>
												</div>
												<div class="content-box__row">
													<input class="input-radio-plus addressdivois" name="sameshipping" value="0" id="diffrentaddess" type="radio">
													<label class="radio__label__primary" for="diffrentaddess">
														Use a different billing address
													</label>
												</div>
											</div>
											<div class="carddetsilheres" style="display: none;" id="addrefornewsa">
												<div class="row">
													<div class="col-md-12 col-sm-12">
														<div class="form-group">
															<!-- <label>First Name<em>*</em></label> -->
															<input type="text" class="form-control" placeholder="Name" name="customer_fname" value="">
														</div>
													</div>
													<div class="col-md-12 col-sm-12">
														<div class="form-group">
															<!-- <label>Address<em>*</em></label> -->
															<input type="text" class="form-control" name="address1" value="" placeholder="Address">
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="col-md-12 col-sm-12">
														<div class="form-group">
															<!-- <label>Apartment, suite, etc.</label> -->
															<input type="text" class="form-control" name="address2" value="" placeholder="Apartment, suite, etc.">
															<span class="bar"></span>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<!-- <label>State<em>*</em></label> -->
															<select name="country" class="form-control" >
																<option value="">Country/Region</option>
																<option value="India" selected>India</option>
															</select>
														</div>
													</div>
													<!-- <div class="clearfix"></div> -->
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<!-- <label>City<em>*</em></label> -->
															<select class="form-control" name="state" onchange="getShippingCity(this.value)">
																<option value="">State</option>
																<?php
																	$stateRS = $functions->getListOfStates();
																	while($stateRow = $functions->fetch($stateRS)) {
																?>
																		<option value="<?php echo $stateRow['statename'] ?>" <?php if(isset($addressDetails) and ($stateRow['statename']==$addressDetails['state'] || ucwords($stateRow['statename'])==ucwords($addressDetails['state']))) { echo "selected"; } ?>><?php echo ucwords($stateRow['statename']) ?></option>
																<?php
																	}
																?>
															</select>
														</div>
													</div>
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<select class="form-control" name="city">
																<option value="">Please Select City</option>
															</select>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="col-md-6 col-sm-6">
														<div class="form-group">
															<!-- <label>Enter Pincode<em>*</em></label> -->
															<input name="pincode" class="form-control" maxlength="6" type="text" value="" placeholder="PIN code">
															<span class="bar"></span>
														</div>
													</div>
													<div class="col-md-6 col-sm-6">
														<div class="form-group">
															<!-- <label>Enter your Contact No.<em>*</em></label> -->
															<input type="text" class="form-control" placeholder="Phone" name="customer_contact" value="">
															<i class="fa fa-question tootltops" data-toggle="tooltip" title="In case we need to contact you about your order"></i>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									<p id="billError" style="color:red;"></p>
									<div class="checkout-btns flestarvatas">
										<a href="guest-checkout.php" class="shop-now-btn dark-yellow-btn text-center">Return to Information</a>
										<?php /* <a href="guest-checkout-preview.php" class="shop-now-btn purple-btn text-center sbtbnall">Complete Order</a> */ ?>
										<button class="shop-now-btn purple-btn text-center sbtbnall" type="submit">Complete Order</button>
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
	<script type="text/javascript">
		$(document).ready(function() {
			$(".addressdivois").change(function(){
				if($("#diffrentaddess").is(":checked")) {
					$("#addrefornewsa").show();
					$("#addrefornewsa").find('input').attr('required', true);
					$("#addrefornewsa").find('select').attr('required', true);
				} else {
					$("#addrefornewsa").hide();
					$("#addrefornewsa").find('input').attr('required', false);
					$("#addrefornewsa").find('select').attr('required', false);
				}
			});
			$(".radioforpay").change(function(){
				if($("#frosomepayment2").is(":checked")){
					$(".nobtmsd").hide();
					$(".bordersames").addClass("brtm");
				} else {
					$(".nobtmsd").show();      
					$(".bordersames").removeClass("brtm");
				}
			});
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<script>
		$(document).ready(function(){
			$("#addAddress").validate({
                ignore: ".ignore",
                rules: {
                    customer_contact: {
                        number:true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    pincode: {
                        number:true,
                        minlength: 6,
                        maxlength: 6,
						remote:{
							url:"<?php echo BASE_URL; ?>/ajaxCheckDeliveryPincode.php",
							type: "post",
						}
                    },
                },
                messages: {
                    customer_fname: {
                        required: "Please enter name",
                    },
                    state: {
                        required: "Please Select state",
                    },
                    city: {
                        required: "Please Select city",
                    },
                    address1: {
                        required: "Please add Address",
                    },
                    customer_contact: {
                        required: "please enter contact number",
                        remote:'Sorry, this contact is already registered.'
                    },
                    pincode: {
                        required: "please enter pincode number",
                        minlength: "please enter valid pincode number",
                        maxlength: "please enter valid pincode number",
						remote: "Sorry, we do not deliver to this location"
                    },
                    customer_email: {
                        required: 'please enter email address',
                    },
                }
            });
		});

		function getShippingCity(state) {
			$.ajax({
				url:"<?php echo BASE_URL."/ajaxGetCityByState.php" ?>",
				data:{state:state},
				type:"post",
				success: function(response){
					var response = JSON.parse(response);
					$("select[name='city']").html(response.cityStr);
				},
				error: function(){
					// alert("Something went wrong, please try again");
				},
				complete: function(response){
				}
			});
		}
	</script>
</body>
</html>