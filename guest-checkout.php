<?php 
	include_once 'include/functions.php';
    $functions = new Functions();

	if(!$_SESSION[SITE_NAME]['cart']) {
		header("location: index.php");
		exit;
	}

	if(isset($_GET['sameASBilling'])) {
		$_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $_SESSION[SITE_NAME]['BILLADDRESS']['Billing'];

		header("location: guest-checkout.php");
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
					<a href="javascript:void(0);" class="current-page" style="cursor: pointer;pointer-events: visible;">Information</a> 
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#" style="cursor: pointer;pointer-events: none;">Shipping</a> 
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
					<form action="process-guest-checkout.php" class="form latest-flex" id="addAddress" method="post" novalidate="novalidate">
						<section class="billing-shipping">
							<?php if(!$loggedInUserDetailsArr = $functions->sessionExists()) { ?>
								<div class="flelops">
									<div>
										<h2>Contact information</h2>
									</div>
									<div>
										<p class="already">Already have an account? <a class="green-text" href="login.php?redirect=guest-checkout.php">Login Here</a></p>
									</div>
								</div>
							<?php } ?>

							<?php	
								if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){
									$defaultAddress = $functions->getAddressById($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
								} else{
									$defaultAddress = $functions->getPrimaryAddress($loggedInUserDetailsArr['id']);
								}

								$addressDetails = $functions->fetch($defaultAddress);
							?>
							<div class="billing-add match" style="">
								<div class="box-inner-ctn">
									<div class="new-frosm">
										<div class="form-group">
											<!-- <label>Email<em>*</em></label> -->
											<input type="email" class="form-control" placeholder="Email Id." name="customer_email" value="<?php if(isset($addressDetails['customer_email'])){ echo $addressDetails['customer_email']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['email']; } else { echo ""; } ?>">
										</div>
									</div>
									<div class="checkbox-wrapper">
										<div class="checkbox__input">
											<input name="checoutcheck" type="hidden" value="0">
											<input class="input-checkbox" type="checkbox" value="1" checked="checked" name="subscribe" id="checkout_buyer_accepts_marketing">
										</div>
										<label class="checkbox__label" for="checkout_buyer_accepts_marketing">
											Keep me up to date on news and exclusive offers
										</label>
									</div>
									<h3>Shipping  Address</h3>
									<?php if($loggedInUserDetailsArr = $functions->sessionExists()){ ?>
										<div class="form-group selctioosn">
											<label>Select address from address book</label>
											<a class="checkout-summery-pop" data-fancybox="" data-type="iframe" data-src="" href="<?php echo BASE_URL; ?>/checkout-summery-popup.php?shipping=shipping">
												Select Address
												<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
											</a>
										</div>
									<?php } ?>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<!-- <label>First Name<em>*</em></label> -->
												<input type="text" class="form-control" placeholder="Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['first_name']; } else { echo ""; } ?>">
											</div>
										</div>
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<!-- <label>Address<em>*</em></label> -->
												<input type="text" class="form-control" required="" name="address1" value="<?php if(isset($addressDetails['address1'])){ echo $addressDetails['address1']; } ?>" placeholder="Address">
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<!-- <label>Apartment, suite, etc.</label> -->
												<input type="text" class="form-control" name="address2" value="<?php if(isset($addressDetails['address2'])){ echo $addressDetails['address2']; } ?>" placeholder="Apartment, suite, etc.">
												<span class="bar"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-4 col-sm-4">
											<div class="form-group">
												<!-- <label>State<em>*</em></label> -->
												<select name="country" class="form-control" required="required">
													<option value="">Country/Region</option>
													<option value="India" selected>India</option>
												</select>
											</div>
										</div>
										<!-- <div class="clearfix"></div> -->
										<div class="col-md-4 col-sm-4">
											<div class="form-group">
												<!-- <label>City<em>*</em></label> -->
												<select required="" class="form-control" name="state" onchange="getShippingCity(this.value)">
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
												<!-- <label>City<em>*</em></label> -->
												<select required="" class="form-control" name="city">
													<option value="">Please Select City</option>
													<?php
														if(isset($addressDetails)) {
															$state = $functions->escape_string($functions->strip_all($addressDetails['state']));
															$sql="select DISTINCT(name),id from ".PREFIX."states where name='".$state."' order by name";
															$result = $functions->query($sql);
															$stateData =$functions->fetch($result);

															$sql = "SELECT * FROM ".PREFIX."cities WHERE `state_id`='".$stateData['id']."'";
															$cityResult = $functions->query($sql);

															while($cityRow = $functions->fetch($cityResult)) {
													?>
																<option value="<?php echo $cityRow['name'] ?>" <?php if($cityRow['name']==$addressDetails['city'] || ucwords($cityRow['name']) == ucwords($addressDetails['city'])) { echo "selected"; } ?>><?php echo $cityRow['name'] ?></option>
													<?php
															}
														}
													?>
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<!-- <label>Enter Pincode<em>*</em></label> -->
												<input name="pincode" class="form-control" required="required" maxlength="6" type="text" value="<?php if(isset($addressDetails['pincode'])){ echo $addressDetails['pincode']; } ?>" placeholder="PIN code">
												<span class="bar"></span>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<!-- <label>Enter your Contact No.<em>*</em></label> -->
												<input type="text" class="form-control" placeholder="Phone" name="customer_contact" value="<?php if(isset($addressDetails['customer_contact'])){ echo $addressDetails['customer_contact']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['mobile']; } else { echo ""; } ?>">
												<i class="fa fa-question tootltops"  data-toggle="tooltip" title="In case we need to contact you about your order"></i>
											</div>
										</div>
									</div>
									<div class="same-as-billing">
										<label class="container-ck">
											<input type="checkbox" value="sameaddnext" name="sameaddnext"> Save this information for next time
											<span class="checkmark-ck"></span>
										</label>
									</div>
									<div class="pull-left">
									</div>
									<div class="pull-right btnsdjs" style="display: none;">
										<input type="submit" class="savechanges shop-now-btn black-btn" name="addAddress" value="Add Address">
									</div>
									<div class="clearfix"></div>
									<p id="billError" style="color:red;"></p>
									<div class="checkout-btns">
										<?php /* <a href="guest-checkout-preview.php" class="shop-now-btn purple-btn text-center sbtbnall" >Continue to Shipping</a> */ ?>
										<button class="shop-now-btn purple-btn text-center sbtbnall" type="submit">Continue to Shipping</button>
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
	<script>
		$("[data-fancybox]").fancybox({
			iframe : {
				css : {
					width : '450px'
				}
			}
		});
	</script>

	<script>
		$(document).ready(function(){
			$("#addAddress").validate({
                ignore: ".ignore",
                rules: {
                    customer_fname: {
                        required : true,
                    },
                    state: {
                        required:true,
                    },
                    city: {
                        required:true,
                    },
                    address1: {
                        required:true
                    },
                    customer_email: {
                        required: true,
                        email:true,
                    },
                    customer_contact: {
                        required: true,
                        number:true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    pincode: {
                        required: true,
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

	<script>
		$('.checkout-summery-pop').fancybox({
			iframe : {
				css : {
					width : '424',
					height : '438'
				}
			},
			buttons : [
				'close'
			],
			afterClose: function () {
				parent.location.reload(true);
			}
		});
	</script>
</body>
</html>