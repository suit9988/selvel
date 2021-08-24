<?php
$basename = basename($_SERVER['REQUEST_URI']);
$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
include_once("include/classes/Cart.class.php");
$cartObj = new Cart;
$amtArr = $functions->getCartAmountAndQuantity($cartObj, null);
?>
<style>
	.typeahead li {
		display: block;
	}

	.typeahead {
		display: block !important
	}
@media only screen and (min-width: 360px) and (max-width: 760px) {
  .slick-slider .slick-track {
    top: 120px !important;
    height: auto !important;
}
}
@media only screen and  (max-width: 760px) {
.header_right_two{
	margin-top: 41px;
}
}
	.cart-notification {
		width: auto;
		padding: 0 30px;
		left: 80%;
		top: 0;
		margin: 77px 0;
		text-align: center;
		transition: all .5s ease-in-out;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		position: fixed;
		z-index: 99999997;
		background: #fff;
		border-radius: 0;
		border: 0;
		color: #431a92;
		box-shadow: 0px 3px 7px #c9c9c9, -11px -11px 14px #7269880d;
	}

	.cart-notification-container.alert {
		margin: 0px;
		font-weight: bold;
		padding: 10px 30px;
	}

	.animated {
		-webkit-animation-duration: 1s;
		animation-duration: 1s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
	}

	.fadeInDown {
		-webkit-animation-name: fadeInDown;
		animation-name: fadeInDown;
	}

	p,
	a,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	strong,
	body,
	html, label {
		font-family: "Gotham-Font" !important;
		font-style: normal;
	}

	flex-propers {
		width: 100% !important;
	}
	.slick-slide img{
	display:initial; 
	}
	
	#capacittext{
		margin-top: 10px;
	}
	.my_cart, #my_cart
	{
	    max-width:600px;
	}
	@media only screen and (max-width: 767px) {
		.logo img {
			max-width: 120px;
		}
		#cart-text-show{
			display:none;
		}
		
		#cart-icon-show{
			display:block;
		}	  
	}
</style>
<!-- Loader start -->
<div id="loader-wrapper">
	<div class="loader">
		<img src="<?php echo BASE_URL; ?>/images/logo.png">
		<h2>Please Wait</h2>
	</div>
</div>
<div class="off_canvars_overlay">

</div>
<div class="offcanvas_menu">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="canvas_open">
					<a href="javascript:void(0)"><img src="https://solvoix.xyz/selvel/images/icons8-menu-50.png" style="width:26px"></a>
				</div>
				<div class="offcanvas_menu_wrapper">
					<div class="canvas_close">
						<a href="javascript:void(0)"><i class="fa fa-times"></i></a>
					</div>

					<div id="menu" class="text-left ">
						<ul class="offcanvas_main_menu">

							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/">Home</a>
							</li>
							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/about-us.php">About Us</a>
							</li>
							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/eat">Eat </a>
								<ul class="sub-menu">
									<li style="list-style: none;width: 30%;"><a href="https://solvoix.xyz/selvel/eat/casserole">Casserole</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/eat/lunch-box">Lunch Box</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/drink">Drink </a>
								<ul class="sub-menu">
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/drink/bottles-flask">Bottles & Flask</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/drink/glasses">Glasses</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/drink/mugs">Mugs</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/drink/sippers">Sippers</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/drink/drink-set">Drink Set</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/serve">Serve </a>
								<ul class="sub-menu">
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/serve/tray-bowl-set">Tray & Bowl Set</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/serve/coaster">Coaster</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/serve/multipurpose-box">Multipurpose Box</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/serve/serving-bowls">Serving Bowls</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/serve/ice-trays">Ice Trays</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/store">Store </a>
								<ul class="sub-menu">
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/racks">Racks</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/trolleys">Trolleys</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/containers">Containers</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/baskets">Baskets</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/trays">Trays</a></li>
									<li style="width: 30%;list-style: none"><a href="https://solvoix.xyz/selvel/store/stands">Stands</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Loader end -->
<div class="wrapper">
	<header class="<?php if ($loggedInUserDetailsArr = $functions->sessionExists()) { echo 'afteloginstyle';	} ?>">
		<div id="top-bar">
			<div class="flex">
				<div class="left-top" style="height: 23px; width: 100%; text-align: center">
					<p>
						<strong style="font-size: 12px;">SHIPPING TO SELECTIVE PIN-CODES AREA ONLY !</strong>
					</p>
				</div>

			</div>
		</div>
		<div style="padding: 0; padding-top: 10px; padding-bottom: 8px; height:100px" class="main_header header_transparent sticky-header">
			<div class="header_container">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-5 col-md-3 col-xs-4">
							<!--main menu start-->
							<div class="main_menu menu_two menu_position">
								<nav>
									<ul>
										<li <?php if ($currentPage == 'index.php') { echo 'class="active"';	} ?>><a href="<?php echo BASE_URL; ?>"> <img src="https://solvoix.xyz/selvel/images/icons8-home-50.png" style="width:26px;margin-top:-9px"></a></li>
										<?php
										$getMainCategoryList = $functions->getMainCategories();
										$getProductCategoryMapping = $functions->fetch($functions->query("SELECT * FROM " . PREFIX . "product_category_mapping"));
										while ($rowCategoryList = $functions->fetch($getMainCategoryList)) {
											$categotyIdHeader = $rowCategoryList['id'];
											$getSubCategoryList = $functions->getSubCategoryByCategoryId($categotyIdHeader);
											// print_r($rowCategoryList);
											?>											
											<li class="<?php if ($currentPage == 'listing.php' || $currentPage == 'details.php') {
												echo 'active';
											} ?> ">
												<a href="<?php echo BASE_URL; ?>/<?php echo $rowCategoryList['permalink']; ?>"><?php echo $rowCategoryList['category_name']; ?> </a>
											
												<div class="mega_menu">
													<ul class="mega_menu_inner">
														<li style="list-style: none;width: 50%;">
															<ul class="sub-meu-list-style">
																<?php
																	while ($rowSubCategoryList = $functions->fetch($getSubCategoryList)) {																		

																		?>
																		<li style="list-style: none;width: 50%;margin-left: 50px;"><a href="<?php echo BASE_URL; ?>/<?= $rowCategoryList['permalink'] ?>/<?= $rowSubCategoryList['permalink'] ?>"><?= $rowSubCategoryList['category_name'] ?></a></li>
																		<?php
																	}
																?>
																<li style="list-style: none;width: 33%;margin-left: 50px;"><a id="shop_all_text" href="<?php echo BASE_URL; ?>/<?= $rowCategoryList['permalink'] ?>" >Shop All <i class="fa fa-long-arrow-right"></i></a></li>
															</ul>
														</li>
														<li style="list-style: none;width: 100%;">
															<ul>
																<li><a href=""><img style="width: 50%;border-radius: 5px;" src="https://solvoix.xyz/selvel/images/131340.jpg"></a></li>
															</ul>
														</li>
													</ul>
												</div>
											</li>
										<?php
										}	
										?>
									</ul>
								</nav>
							</div>
							<!--main menu end-->
						</div>
						<div class="col-lg-2 col-md-3 col-xs-4">
							<div class="logo">
								<a href="<?php echo BASE_URL; ?>"><img style="height: 77px;width: 108px; margin:0;" src="https://solvoix.xyz/selvel/images/logo.png" alt=""></a>
							</div>
						</div>
						<div class="col-lg-5 col-md-6 col-sm-5 col-xs-4">
							<div class="header_right_info header_right_two">
								<div class="header_account_area header_account_area1">
									<div class="header_account-list header_wishlist abpout_bf">
										<a href="about-us.php">About Us</a>
									</div>
									<div class="no-unline header_account-list header_wishlist abpout_bf">
										<a data-fancybox data-src="#sign-in-pop" href="javascript:;">Join/Login</a>
									</div>
									<div class=" header_account-list header_wishlist abpout_bf">
										<a class="no_unline" href="<?php echo BASE_URL; ?>/my-wishlist.php">
											<!-- <img src="https://solvoix.xyz/selvel/heart-con.png" style="width:26px"> -->
											<i class="fa fa-heart-o"></i>
										</a>
									</div>
								</div>							
								<div class="header_account_area header_account_area2">
									<div class="header_account-list header_wishlist">
										
											<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16 fa-3x"><path fill="currentColor" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" class=""></path></svg>
										</a>
									</div>
									<?php
										ob_start();
										$qty_bw = 0;
										$cartObj = new Cart;
										$cartArr = $cartObj->getCart();
										if ($cartArr) {
											foreach ($cartArr as $oneProduct) {
												$qty_bw = $oneProduct['quantity'];
											}
										} else {
											$qty_bw = 0;
										}	
									?>	
									<div class="header_account-list  mini_cart_wrapper" style="max-width:600px;">
										<a id="cart-text-show" href="javascript:void(0)">Cart (<?= $qty_bw ?>)</a>
										<a  id="cart-icon-show" href="javascript:void(0)">
											
											<i class="fa fa-shopping-cart"></i>
										</a>
										<!--mini cart-->
										<div class="my_cart">
										<div class="mini_cart my_cart" id="my_cart" style="max-width:600px !important;">
											<div class="cart_gallery">
												<?php
												$subTotal = 0;
												$finalTotal = 0;
												$totalPrice = 0;
												$totaltaxamount = 0;
												$totalWeight = 0;
												// if ($cartArr) {
												    foreach ($cartArr as $oneProduct) {
    													$cartProductDetail = $functions->getUniqueProductById($oneProduct['productId']);
    
    													//$productBanner = $functions->getImageUrl('products',$cartProductDetail['main_image'],'crop','');
    
    													$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM " . PREFIX . "product_sizes WHERE product_id='" . $oneProduct['productId'] . "' AND size='" . $oneProduct['size'] . "' and productcolor='" . $oneProduct['color'] . "'"));
    													$currentPageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME); // eg: example.php
    													$productBanner = $functions->getImageUrl('products', $getProductsizeDetails['image1_color'], 'crop', '');
    													if ($currentPageName == "input-group" || (isset($isCartPage) && $isCartPage == "2") || $currentPageName == "chekout-order-summary.php" || $currentPageName == "shipping.php" || $currentPageName == "payment-method.php") {
    														$cartIncrementClass = "checkoutPageIncrementFromCartBtn";
    														$cartDecrementClass = "checkoutPageDecrementFromCartBtn";
    														$cartRemoveClass = "checkoutPageRemoveFromCartBtn";
    
    														$couponCodeApplyId = "applyCouponCodeCheckoutBtn";
    														$couponCodeRemoveId = "removeCouponCodeCheckoutBtn";
    
    														$displayingCheckoutPageCart = true;
    													} else {
    														$cartIncrementClass = "incrementCartBtn";
    														$cartDecrementClass = "decrementCartBtn";
    														$cartRemoveClass = "removeFromCartBtn";
    
    														$couponCodeApplyId = "applyCouponCodeCartBtn";
    														$couponCodeRemoveId = "removeCouponCodeCartBtn";
    
    														$displayingCheckoutPageCart = false;
    													}
    													if (!empty($getProductsizeDetails['customer_discount_price'])) {
    														$discountedPrice = $getProductsizeDetails['customer_discount_price'];
    														$unitPrice = $discountedPrice;
    														$price = $discountedPrice * $oneProduct['quantity'];
    														unset($discountedPrice);
    													} else {
    														$unitPrice = $getProductsizeDetails['customer_price'];
    														$price = $getProductsizeDetails['customer_price'] * $oneProduct['quantity'];
    													}
    
    													$totalWeight = $totalWeight + $getProductsizeDetails['weight'];
    													$tax = $cartProductDetail['tax'];
    													$taxAmount = $price * ($tax / 100);
    													//$price = $price + $taxAmount;
    													$price1 = $price;
    													$subTotal += $price1; //productprice
    													$taxAmount1 += $taxAmount;
    												?>
    													<div class="cart_item">
    														<div class="cart_img">
    															<a href="#"><img src="<?php echo $productBanner; ?>" alt=""></a>
    														</div>
    														<div class="cart_info">
    															<a href="#"><?= $cartProductDetail['product_name'] ?></a>
    															<p><?php echo $oneProduct['quantity']; ?> x <span> <i class="fa fa-rupee"></i> <?= $price ?></span></p>
    														</div>
    														<div class="cart_remove">
    															<input type="hidden" name="productNo" value="<?php echo $cartProductDetail['id']; ?>" />
    															<input type="hidden" name="size" value="<?php echo $oneProduct['size']; ?>" />
    															<input type="hidden" name="color" value="<?php echo $oneProduct['color']; ?>" />
    															<input type="hidden" value="<?php echo $getProductsizeDetails['available_qty']; ?>" name="available_qty" class="available_qty" />
    															<input type="hidden" value="<?php echo $getProductsizeDetails['customer_discount_price']; ?>" name="price" class="price" />
    															<button class="delete-btn <?php echo $cartRemoveClass; ?>" style="background: #fff;border: none;" data-id="<?php echo $cartProductDetail['id']; ?>"><i class="fa fa-times"></i></button>
    														</div>
    													</div>
    												<?php
    												}
    												/*
												}else{
												    ?>
												    
												    <?php
												}
												*/
												?>
											</div>
											<div class="mini_cart_table">
												<div class="cart_table_border">
													<div class="cart_total">
														<span>Sub total:</span>
														<span class="price"><i class="fa fa-rupee"></i> 968</span>
													</div>
													<div class="cart_total mt-10">
														<span>total:</span>
														<span class="price"><i class="fa fa-rupee"></i> 429</span>
													</div>
												</div>
											</div>
											<div class="mini_cart_footer">
												<div class="cart_button">
													<a href="#"><i class="fa fa-shopping-cart"></i> View cart</a>
												</div>
												<div class="cart_button">
													<a href="#"><i class="fa fa-sign-in"></i> Checkout</a>
												</div>

											</div>
										</div>
										</div>
										<!--mini cart end-->
										
									</div>
									
									<!---->
								</div>
							</div>                          
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<?php
	$show_sidebar=$ac = "";
	ob_start();
	$cartObj = new Cart;
	$cartArr = $cartObj->getCart();
	if ($show_sidebar == 'yes') {
		$ac = "active";
	} else {
		$ac = "";
	}
	?>
	<div class="mini_cart">

		<div class="cart_gallery">
			<div class="cart_close">
				<div class="cart_text">
					<h3>Your Cart</h3>
				</div>
				<?php if ($cartArr) { ?>
					<div class="mini_cart_value-items">
						<p><?php echo count($cartArr); ?> <span>Items</span></p>
					</div>
				<?php } ?>
				<div class="mini_cart_close">
					<a href="javascript:void(0)"><i class="fa fa-times"></i></a>
				</div>
			</div>

			<?php if ($cartArr) { ?>
				
				<div class="cart-items-wrapper">
					<div class="cart-items">
						<?php
						$subTotal = 0;
						$finalTotal = 0;
						$totalPrice = 0;
						$totaltaxamount = 0;
						$totalWeight = 0;

						$product_categories = array(); // used for related products
						$cart_product_ids = array(); // used for related products

						foreach ($cartArr as $oneProduct) {

							$cartProductDetail = $functions->getUniqueProductById($oneProduct['productId']);

							$cart_product_ids[] = $oneProduct['productId'];

							$product_categories_q = $functions->query("SELECT * FROM " . PREFIX . "product_category_mapping pcm INNER JOIN " . PREFIX . "category_master cm ON pcm.category_id = cm.id WHERE product_id='" . $oneProduct['productId'] . "'");

							$category_name = '';

							if (mysqli_num_rows($product_categories_q) > 0) {
								while($r = mysqli_fetch_array($product_categories_q)) {
									$product_categories[] = $r['category_id'];
									$category_name = $r['category_name'];
								}
							}
						
							//$productBanner = $functions->getImageUrl('products',$cartProductDetail['main_image'],'crop','');

							$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM " . PREFIX . "product_sizes WHERE product_id='" . $oneProduct['productId'] . "' AND size='" . $oneProduct['size'] . "' and productcolor='" . $oneProduct['color'] . "'"));
							$currentPageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME); // eg: example.php
							$productBanner = $functions->getImageUrl('products', $getProductsizeDetails['image1_color'], 'crop', '');
							if ($currentPageName == "input-group" || (isset($isCartPage) && $isCartPage == "2") || $currentPageName == "chekout-order-summary.php" || $currentPageName == "shipping.php" || $currentPageName == "payment-method.php") {
								$cartIncrementClass = "checkoutPageIncrementFromCartBtn";
								$cartDecrementClass = "checkoutPageDecrementFromCartBtn";
								$cartRemoveClass = "checkoutPageRemoveFromCartBtn";

								$couponCodeApplyId = "applyCouponCodeCheckoutBtn";
								$couponCodeRemoveId = "removeCouponCodeCheckoutBtn";

								$displayingCheckoutPageCart = true;
							} else {
								$cartIncrementClass = "incrementCartBtn";
								$cartDecrementClass = "decrementCartBtn";
								$cartRemoveClass = "removeFromCartBtn";

								$couponCodeApplyId = "applyCouponCodeCartBtn";
								$couponCodeRemoveId = "removeCouponCodeCartBtn";

								$displayingCheckoutPageCart = false;
							}
							if (!empty($getProductsizeDetails['customer_discount_price'])) {
								$discountedPrice = $getProductsizeDetails['customer_discount_price'];
								$unitPrice = $discountedPrice;
								$price = $discountedPrice * $oneProduct['quantity'];
								unset($discountedPrice);
							} else {
								$unitPrice = $getProductsizeDetails['customer_price'];
								$price = $getProductsizeDetails['customer_price'] * $oneProduct['quantity'];
							}

							$totalWeight = $totalWeight + $getProductsizeDetails['weight'];
							$tax = $cartProductDetail['tax'];
							$taxAmount = $price * ($tax / 100);
							//$price = $price + $taxAmount;
							$price1 = $price;
							$subTotal += $price1; //productprice
							$taxAmount1 += $taxAmount;
						?>

							<div class="cart_item">
								<div class="cart_img">
									<a href="#"><img src="<?php echo $productBanner; ?>" alt="" style="width: 100%;"></a>
								</div>
								<div class="cart_info">
									<a href="#"><?php echo $cartProductDetail['product_name'] ?></a>

									<?php if ( !empty($category_name) ) : ?>
										<p class="item-category"><?php echo $category_name; ?></p>
									<?php endif ?>

									<?php if (isset($oneProduct['color']) && ! empty($oneProduct['color']) ) : ?>
										<p class="item-color"><?php echo $oneProduct['color']; ?></p>
									<?php endif ?>

									
									<!--<p><?php //echo $oneProduct['quantity']; 
											?> x <span> <i class="fa fa-rupee"></i> <?= $price ?>   </span></p>-->
									<div class="cart-quantity-info">
										<div class="quantity cart-quantity">
											<ul class="list-inline">
												<li><button class="btn-number plus" data-field="productCount">+</button></li>
												<li class="numm"><input type="number" id="number" name="productCount" value="<?php echo $oneProduct['quantity'] ?>" min="1" max="5" readonly=""></li>
												<input type="hidden" id="available_qty" class="available_qty" value="5" name="available_qty">
												<li><button class="btn-number minus" data-field="productCount">-</button></li>
											</ul>
										</div>

										<div class="item-total-price">
											<span class="price"><i class="fa fa-rupee"></i> <?php echo $subTotal + $shippingCharges + $totaltaxamount; ?></span>
										</div>
									</div>
								</div>
								<div class="cart_remove cart_details">
									<input type="hidden" name="productNo" value="<?php echo $cartProductDetail['id']; ?>" />
									<input type="hidden" name="size" value="<?php echo $oneProduct['size']; ?>" />
									<input type="hidden" name="color" value="<?php echo $oneProduct['color']; ?>" />
									<input type="hidden" value="<?php echo $getProductsizeDetails['available_qty']; ?>" name="available_qty" class="available_qty" />
									<input type="hidden" value="<?php echo $getProductsizeDetails['customer_discount_price']; ?>" name="price" class="price" />
									<button class="delete-btn removeFromCartBtn" style="background: #fff;border: none;" data-id="<?php echo $cartProductDetail['id']; ?>"><i class="fa fa-times"></i></button>
								</div>
							</div>
						<?php  } ?>
					</div> <!-- // cart items -->
					
					<?php 
						// $product_categories  = array_unique($product_categories);
						$cart_product_ids  = implode(',', array_unique($cart_product_ids));
						
						$related_products_q = $functions->query("SELECT * FROM " . PREFIX . "products_related_products rp INNER JOIN " . PREFIX . "product_master pm ON pm.id = rp.related_product_id WHERE product_id IN (" . $oneProduct['productId'] . ")");
						
						if (mysqli_num_rows($related_products_q) > 0) { ?>

							<div class="related-items-slider">
								<h3>You may also like</h3>

								<div id="minicart-related-items_slider" class="owl-carousel" style="width: 600px !important">

								<?php
								while($related_product = mysqli_fetch_array($related_products_q)) {
									$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM " . PREFIX . "product_sizes WHERE product_id='" . $related_product['id'] . "'"));

									$getProductsizeDetails1 = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$related_product['id']."' ORDER BY id ASC LIMIT 1"));

									$productBanner = $functions->getImageUrl('products', $getProductsizeDetails1['image1_color'], 'crop', '');
									
									$product_link1 = $functions->getProductDetailPageURL($related_product['id'], $getProductsizeDetails1['id']);
									?>
										<div class="item">
											<a href="<?php echo BASE_URL ?>/<?php echo $product_link1; ?>">
												<div class="cart_item">
													<div class="cart_img">
														<a href="<?php echo BASE_URL ?>/<?php echo $product_link1; ?>"><img src="<?php echo $productBanner ?>" alt="" style="width: 100%;"></a>
													</div>
													<div class="cart_info">
														<a href="<?php echo BASE_URL ?>/<?php echo $product_link1; ?>"><?php echo $related_product['product_name'] ?></a>

														<div class="related-cart-info">
															<span class="item-color">Silver</span>
														</div>
												
														<div class="cart_action">
															<a class="add-cart-btn" href="<?php echo BASE_URL ?>/<?php echo $product_link1; ?>"><i class="fa fa-plus"></i> Add</a>
														</div>
														
													</div>

												</div>
											</a>
										</div>
									<?php
								}

							?>
								</div>
							</div>
							<?php
						}

					?>
				</div> <!-- // cart items wrapper -->
			<?php } else { ?>
		
					<!-- <table class="table">
					<tbody>
						<tr>
						<td><img src="https://1.bp.blogspot.com/-XWrWnBpLYqA/YR-VYf_oFxI/AAAAAAAAL5g/FyCZja-xImgAcGpXU1zQHiApa0FlNjO_QCLcBGAsYHQ/s0/06.JPG" class="img-fluid" / height="100" width="100"></td>
						<td><h2><b>Swirl Casserole</b></h2>
					<p>Royal Set <br/> Mint - Black</p></td>
						<td><h1 style="font-size:30px"> ₹ 989</h1></td>
						</tr>
							<tr>
						<td><img src="https://1.bp.blogspot.com/-XWrWnBpLYqA/YR-VYf_oFxI/AAAAAAAAL5g/FyCZja-xImgAcGpXU1zQHiApa0FlNjO_QCLcBGAsYHQ/s0/06.JPG" class="img-fluid" / height="100" width="100"></td>
						<td><h2><b>Swirl Casserole</b></h2>
					<p>Royal Set <br/> Mint - Black</p></td>
						<td><h1 style="font-size:30px"> ₹ 989</h1></td>
						</tr>
							<tr>
						<td><img src="https://1.bp.blogspot.com/-XWrWnBpLYqA/YR-VYf_oFxI/AAAAAAAAL5g/FyCZja-xImgAcGpXU1zQHiApa0FlNjO_QCLcBGAsYHQ/s0/06.JPG" class="img-fluid" / height="100" width="100"></td>
						<td><h2><b>Swirl Casserole</b></h2>
					<p>Royal Set <br/> Mint - Black</p></td>
						<td><h1 style="font-size:30px"> ₹ 989</h1></td>
						</tr>
							<tr>
						<td><img src="https://1.bp.blogspot.com/-XWrWnBpLYqA/YR-VYf_oFxI/AAAAAAAAL5g/FyCZja-xImgAcGpXU1zQHiApa0FlNjO_QCLcBGAsYHQ/s0/06.JPG" class="img-fluid" / height="100" width="100"></td>
						<td><h2><b>Swirl Casserole</b></h2>
					<p>Royal Set <br/> Mint - Black</p></td>
						<td><h1 style="font-size:30px"> ₹ 989</h1></td>
						</tr>
							<tr>
						<td><img src="https://1.bp.blogspot.com/-XWrWnBpLYqA/YR-VYf_oFxI/AAAAAAAAL5g/FyCZja-xImgAcGpXU1zQHiApa0FlNjO_QCLcBGAsYHQ/s0/06.JPG" class="img-fluid" / height="100" width="100"></td>
						<td><h2><b>Swirl Casserole</b></h2>
					<p>Royal Set <br/> Mint - Black</p></td>
						<td><h1 style="font-size:30px"> ₹ 989</h1></td>
						</tr>
					</tbody>
					</table> -->
				<h2 class="cartemts" style="font-size: 30px; font-weight: bold; text-align: center;">Your Cart is Empty</h2>
			<?php } ?>
		</div>

		<?php if ($cartArr) { ?>
			<div class="mini_cart_table">
				<div class="cart_table_border">
					<div class="cart_total">
						<div class="sub-total">
							<h3>Sub-total :</h3>
							<span>Shipping, taxes, and promotions calculated at checkout</span>
						</div>
						<span class="price"><i class="fa fa-rupee"></i> <?php echo $subTotal + $shippingCharges + $totaltaxamount; ?></span>
					</div>
				</div>
				<div class="mini_cart_footer">
					<!--<div class="cart_button">
							<a href=""><i class="fa fa-shopping-cart"></i> View cart</a>
						</div>-->
					<div class="cart_button">
						<a class="active" href="https://solvoix.xyz/selvel/cart.php"> View Cart
							<!--<i style="transform: translateY(6px);" class="glyphicon glyphicon-arrow-right" style="color:#CADB2A"></i>--> <i class="fa fa-long-arrow-right"></i>
						</a>
					</div>
	
				</div>
			</div>
		<?php } ?>
	</div>




</div>