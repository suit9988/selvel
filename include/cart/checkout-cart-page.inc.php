<?php 

	ob_start();

	$cartObj = new Cart;

	$cartArr = $cartObj->getCart();

	if($cartArr){

		$currentPageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);

?>

		<section class="order-summery">

			<div class="cart-table-responsive">

				<table class="table">

					<tbody class="cart_details">

						<?php

							$subTotal = 0;

							$finalTotal = 0;

							$totalPrice = 0;

							$totaltaxamount = 0;

							$totalWeight = 0;

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





								$totalWeight = $totalWeight + $getProductsizeDetails['weight'];

								$tax = $cartProductDetail['tax'];

								$taxAmount = $price * ($tax/100);

								$totaltaxamount = $totaltaxamount + $taxAmount;

								$price = $price + $taxAmount;

								$subTotal += $price;

						?>

								<tr class="cart_details">

									<td>

										<div class="item-thumb">

											<img src="<?php echo $productBanner; ?>" alt=""/>

											<input type="hidden" name="size" value="<?php echo $oneProduct['size']; ?>" />

											<input type="hidden" name="color" value="<?php echo $oneProduct['color']; ?>" />

											<span class="cart-item"><?php echo $oneProduct['quantity']; ?></span>

										</div>

									</td>

									<td>

										<ul class="product-name">

											<li><?php echo $cartProductDetail['product_name'].' ('.$oneProduct['color'].' '.$oneProduct['size'].')';  ?>

											</li>

											<li>

												<span class="cartdelets delete-btn <?php echo $cartRemoveClass; ?>" data-id="<?php echo $cartProductDetail['id']; ?>">

												<i class="fa fa-trash"></i>

												</span> 

											</li>										

										</ul>

									</td>

									<td>

										<ul>

											<div class="product-name">

												<p><i class="fa fa-inr"></i> <?php echo $price; ?></p>

											</div>

										</ul>

									</td>

								</tr>

						<?php

							}

						?>

					</tbody>

				</table>

			</div>

			<div class="cart-tatal-sec">

				<div class="cart-tatal-sec">

					<div class="cart-total text-right">
						
						<div class="copsidcode">

							<form class="apply-coupon-form">

								<?php

									// CHECK IF DISCOUNT COUPON IS VALID FOR THIS USER

									$loggedInUserDetailsArr = $functions->sessionExists();

									// echo '<pre>';

									// print_r($_SESSION[SITE_NAME]);

									if( isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])){ // user is logged in, apply discount

										$subTotalArr = $functions->getNewSubtotalAfterCouponCode($subTotal, $cartObj, $loggedInUserDetailsArr);

										$couponDiscount = $subTotalArr['couponDiscount'];

										$finalTotal = $subTotalArr['subTotal'];

								?>

										<p class="dklepsdispdsd">

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

												<span class="input-group-addon coupon-addon <?php echo $couponCodeApplyId; ?>">Apply <i class="fa fa-arrow-right" style="color:#000"></i></span>

												<div class="clearfix"></div>

											</div>

							<?php 	} ?>				

										<p class="couponErrorMsg" style="color: rgb(255, 0, 0);"></p>

							</form>

						</div>
						<br><hr><br>

						<div class="cart-sub-total">

							<p class="sub-ttl-title pull-right width30"><b><i class="fa fa-inr"></i> <?php echo $subTotal; ?></b></p>

							<p class="sub-ttl-title pull-right">Sub Total</p>

							<div class="clearfix"></div>
							

						</div>

						<?php if($currentPageName=='checkout.php') { ?>

									<div class="summery cart-delivery ">

										<p class="sub-ttl-title pull-right rs-span width30">

											<!--   <i class="fa fa-inr" aria-hidden="true"></i>   --><b style="font-size: 12px;">Calculated at next step</b>

										</p>

										<p class="sub-ttl-title pull-right delivery">Shipping</p>

										<div class="clearfix"></div>

									</div>

								<?php } else {

									$shippingPost = array();

									$shippingPost['md'] = "S";

									$shippingPost['pt'] = "Pre-paid";

									$shippingPost['pt'] = "Pre-paid";

									$shippingPost['cl'] = "SELVEL 0064514";

									$shippingPost['cgm'] = $totalWeight;

									$postJson = json_encode($shippingPost);



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



									// $shippingCharges = $functions->getShippingCharge($finalTotal);

									$finalTotal = $finalTotal + $shippingCharges;

								?>

									<div class="summery cart-delivery ">

										<p class="sub-ttl-title pull-right rs-span width30">

											<i class="fa fa-inr" aria-hidden="true"></i>  <b><?php echo $shippingCharges; ?></b>

										</p>

										<p class="sub-ttl-title pull-right delivery">Shipping</p>

										<div class="clearfix"></div>

									</div>

								<?php } ?>

						
						<hr>
						<div class="ttl-div flexstos">

							<span class="span-ttl span-ttl-rs">Total <br>


							</span> 

							<span class="span-ttl-rs width30">

								<i class="fa fa-inr" aria-hidden="true"></i> <?php echo $finalTotal; ?>

							</span>

						</div>

						<div class="clearfix"></div>

					</div>

				</div>

			</div>

		</section>

<?php

	}

	$checkoutCartPageHTML = ob_get_contents(); // do not change variable name $checkoutCartPageHTML

	ob_end_clean();

?>