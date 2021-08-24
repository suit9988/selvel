<?php 
	ob_start();
	$cartObj = new Cart;
	$cartArr = $cartObj->getCart();
	if($cartArr){
?>
		<section class="order-summery">
			<div class="cart-table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Item</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Unit Price</th>
							<th>Tax</th>
							<th>Price</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="cart_details">
						<?php
							$subTotal = 0;
							$finalTotal = 0;
							$totalPrice = 0;
							$totaltaxamount = 0;
							foreach($cartArr as $oneProduct){
								$cartProductDetail = $functions->getUniqueProductById($oneProduct['productId']);
								//$oneProduct['productId']."sne";
								//$productBanner = $functions->getImageUrl('products',$cartProductDetail['main_image'],'crop','');
								$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."' and productcolor='".$oneProduct['color']."'"));
								$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');
								$currentPageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME); // eg: example.php
								//if($currentPageName=="input-group" || (isset($isCartPage) && $isCartPage=="2") || $currentPageName=="chekout-order-summary.phps" || $currentPageName=="shipping.php" || $currentPageName=="payment-method.php"){
									$cartIncrementClass = "checkoutPageIncrementFromCartBtn";
									$cartDecrementClass = "checkoutPageDecrementFromCartBtn";
									$cartRemoveClass = "checkoutPageRemoveFromCartBtn";

									$couponCodeApplyId = "applyCouponCodeCheckoutBtn";
									$couponCodeRemoveId = "removeCouponCodeCheckoutBtn";

									$displayingCheckoutPageCart = true;
								// } else {
								// 	$cartIncrementClass = "incrementCartBtn";
								// 	$cartDecrementClass = "decrementCartBtn";
								// 	$cartRemoveClass = "removeFromCartBtn";

								// 	$couponCodeApplyId = "applyCouponCodeCartBtn";
								// 	$couponCodeRemoveId = "removeCouponCodeCartBtn";

								// 	$displayingCheckoutPageCart = false;
								// }
								 if(!empty($getProductsizeDetails['customer_discount_price'])) {
									$discountedPrice = $getProductsizeDetails['customer_discount_price'];
									$unitPrice = $discountedPrice;
									$price = $discountedPrice * $oneProduct['quantity'];
									unset($discountedPrice);
								} else {
									$unitPrice = $getProductsizeDetails['customer_price'];
									$price = $getProductsizeDetails['customer_price'] * $oneProduct['quantity'];
								}


								$tax = $cartProductDetail['tax'];
								$taxAmount = $price * ($tax/100);
								$price = $price + $taxAmount;
								$subTotal += $price;
						?>
								<tr>
									<td>
										<div class="item-thumb">
											<img src="<?php echo $productBanner; ?>" alt=""/>
										</div>
									</td>
									<td>
										<ul class="product-name">
											<li><?php echo $cartProductDetail['product_name'].' ('.$oneProduct['color'].' '.$oneProduct['size'].')';  ?>												
										</ul>
									</td>
									<td class="input-group1">
										<div class="input-num">
											<ul class="list-inline">
												<li><button type="button" class="btn-number <?php echo $cartDecrementClass; ?>" <?php if($oneProduct['quantity']<=1){ echo 'disabled="disabled"'; } ?> data-type="minus" data-field="qty[<?php echo $cartProductDetail['id']; ?>]">-</button></li>
												<li><input type="number" id="number" name="qty[<?php echo $cartProductDetail['id']; ?>]" class="number percent_amount cartQty" value="<?php echo $oneProduct['quantity']; ?>" min="1" max="<?php echo $getProductsizeDetails['available_qty']; ?>" readonly></li>
												<li><button type="button" class="btn-number <?php echo $cartIncrementClass; ?>" data-type="plus" <?php if($oneProduct['quantity']>=$getProductsizeDetails['available_qty']){ echo 'disabled="disabled"'; } ?> data-type="plus" data-field="qty[<?php echo $cartProductDetail['id']; ?>]">+</button></li>
											</ul>
										</div>
										<input type="hidden" name="productNo" value="<?php echo $cartProductDetail['id']; ?>" />
										<input type="hidden" name="size" value="<?php echo $oneProduct['size']; ?>" />
										<input type="hidden" name="color" value="<?php echo $oneProduct['color']; ?>" />
										<input type="hidden" value="<?php echo $getProductsizeDetails['available_qty']; ?>" name="available_qty" class="available_qty" />
									</td>
									<td>
										<p> <!-- <i class="fa fa-inr" aria-hidden="true"></i> --> <i class="fa fa-inr"></i> <?php echo $unitPrice; ?></p>
									</td>
									<td>
										<ul>
											<div class="product-name">
												<p><?php echo $cartProductDetail['tax']." %"; ?> </p>
											</div>
										</ul>
									</td>
									<td>
										<ul>
											<div class="product-name">
												<p><!-- <i class="fa fa-inr" aria-hidden="true"></i> --><i class="fa fa-inr"></i> <?php echo $price; ?></p>
											</div>
										</ul>
									</td>
									<td><button class="delete-btn <?php echo $cartRemoveClass; ?>" data-id="<?php echo $cartProductDetail['id']; ?>"><i class="fa fa-times"><i></button></td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="cart-tatal-sec">
				<div class="cart-total text-right">
					<div class="cart-sub-total">
						<p class="sub-ttl-title pull-right width30"><b><!-- <i class="fa fa-inr" aria-hidden="true"></i> --><i class="fa fa-inr"></i> <?php echo $subTotal; ?></b></p>
						<p class="sub-ttl-title pull-right">Sub Total</p>
						<div class="clearfix"></div>
					</div>
					<div>
						<form class="apply-coupon-form">
							<?php
								// CHECK IF DISCOUNT COUPON IS VALID FOR THIS USER
								$loggedInUserDetailsArr = $functions->sessionExists();
								// echo '<pre>';
								// print_r($_SESSION[SITE_NAME]);
								if( isset($loggedInUserDetailsArr) && !empty($loggedInUserDetailsArr) && count($loggedInUserDetailsArr)>0 &&
									isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])){ // user is logged in, apply discount
									$subTotalArr = $functions->getNewSubtotalAfterCouponCode($subTotal, $cartObj, $loggedInUserDetailsArr);
									$couponDiscount = $subTotalArr['couponDiscount'];
									$finalTotal = $subTotalArr['subTotal'];
							?>
									<p>
										<span>Coupon Discount</span>
										<span>- <i class="fa fa-inr" aria-hidden="true"></i><?php echo $couponDiscount; ?> 
										<button class="btn btn-danger removeCouponCodeCheckoutBtn" type="button">x</button></span>
										<div class="clearfix"></div>
									</p>
						<?php 	} else{ 
									$finalTotal = $subTotal;
							?>
										<div class="input-group input-group1">
											<input id="coupon-code" type="text" class="form-control" name="couponCode" placeholder="Enter Your Coupon Code">
											<span class="input-group-addon coupon-addon <?php echo $couponCodeApplyId; ?>">Apply</span>
											<div class="clearfix"></div>
										</div>
						<?php 	} ?>				
									<p class="couponErrorMsg" style="color: rgb(255, 0, 0);"></p>

						</form>
					</div>
					<div class="summery cart-delivery ">
						<?php 
							$shippingCharges = $functions->getShippingCharge($finalTotal)
						?>
						<p class="sub-ttl-title pull-right rs-span width30"><i class="fa fa-inr" aria-hidden="true"></i> <b><?php echo $shippingCharges; ?></b></p>
						<p class="sub-ttl-title pull-right delivery">Delivery</p>
						<div class="clearfix">
						</div>
					</div>
					
					<?php /* <div class="summery cart-delivery ">
						<?php 
							$totaltaxamount = $totaltaxamount + $taxAmount;
							// $finalTotal = $finalTotal + $totaltaxamount;
						?>
						<p class="sub-ttl-title pull-right rs-span width30"><i class="fa fa-inr" aria-hidden="true"></i> <b><?php echo $totaltaxamount; ?></b></p>
						<p class="sub-ttl-title pull-right delivery">Tax</p>
						<div class="clearfix">
						</div>
					</div> */ ?>
					
					
					<div class="ttl-div">
						<span class="span-ttl span-ttl-rs">Total </span> <span class="span-ttl-rs width30"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $finalTotal + $shippingCharges; ?></span>
					</div>
						<div class="payment-mode">
						<ul class="list-inline">
							<li>
							Payment Method
							</li>
							<li>
								<label class="radio-container" for="online">COD
								<input type="radio" id="online" checked="checked" name="payment_method" value="COD" class="pay">
								<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="radio-container" for="cod">Online Payment
								<input type="radio" id="cod" name="payment_method" value="Online" class="pay">
								<span class="checkmark"></span>
								</label>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
					
					<div class="checkout-btns">
						<a href="<?php echo BASE_URL; ?>" class="shop-now-btn dark-yellow-btn text-center">Continue Shopping</a>
						<?php 	
							if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'])){ ?>
								<a href="javascript:;" id="proceedCheckout" class="shop-now-btn purple-btn text-center" id="proceedCheckout">Proceed to CheckOut</a>
						<?php 
							}else{ ?>
								<a href="javascript:;" class="shop-now-btn purple-btn text-center" id="proceedCheckout">Proceed to CheckOut</a>	
						<?php 
							}
						?>
					</div>
				</div>
			</div>
		</section>
<?php
	}
	$checkoutCartPageHTML = ob_get_contents(); // do not change variable name $checkoutCartPageHTML
	ob_end_clean();
?>