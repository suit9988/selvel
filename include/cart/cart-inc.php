<?php 
	ob_start();
	$cartObj = new Cart;
	$cartArr = $cartObj->getCart();
	

	
	if($cartArr){
?>
		<section class="order-summery">
			<div class="row">
				<div class="col-xl-8 col-md-8 col-sm-12">
					<div class="cart-table-responsive">
						<table class="table">
							<tbody class="cart_details">
								<?php
									$subTotal = 0;
									$finalTotal = 0;
									$totalPrice = 0;
									$totaltaxamount = 0;
									$totalWeight = 0;
									foreach($cartArr as $oneProduct) {
										$cartProductDetail = $functions->getUniqueProductById($oneProduct['productId']);

										//$productBanner = $functions->getImageUrl('products',$cartProductDetail['main_image'],'crop','');

										$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."' and productcolor='".$oneProduct['color']."'"));
										$currentPageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME); // eg: example.php
										$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');
										if($currentPageName=="input-group" || (isset($isCartPage) && $isCartPage=="2") || $currentPageName=="chekout-order-summary.php" || $currentPageName=="shipping.php" || $currentPageName=="payment-method.php"){
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
										//$price = $price + $taxAmount;
										$price1 = $price;
										$subTotal += $price1;//productprice
										$taxAmount1 += $taxAmount;
								?>
										<tr class="cart_details">
											<td>
												<div class="item-thumb">
													<img src="<?php echo $productBanner; ?>" alt=""/>
												</div>
											</td>
											<td>
												<ul class="product-name">
													<li><?php echo $cartProductDetail['product_name'].' ('.$oneProduct['size'].')<br>Color: '.$oneProduct['color'];  ?>												
												</ul><br>
												<div class="input-num">
													<ul class="list-inline">
														<li><button type="button" class="btn-number <?php echo $cartDecrementClass; ?>" <?php //if($oneProduct['quantity']<=1){ echo 'disabled="disabled"'; } ?> data-type="minus" data-field="qty[<?php echo $cartProductDetail['id']; ?>]">-</button></li>

														<li><input type="number" id="number" name="qty[<?php echo $cartProductDetail['id']; ?>]" class="number percent_amount cartQty" value="<?php echo $oneProduct['quantity']; ?>" min="1" max="<?php echo $getProductsizeDetails['available_qty']; ?>" readonly></li>

														<li><button type="button" class="btn-number <?php echo $cartIncrementClass; ?>" data-type="plus" <?php if($oneProduct['quantity']>=$getProductsizeDetails['available_qty']){ echo 'disabled="disabled"'; } ?> data-type="plus" data-field="qty[<?php echo $cartProductDetail['id']; ?>]">+</button></li>
													</ul>
												</div><br><br>
												
												<input type="hidden" name="productNo" value="<?php echo $cartProductDetail['id']; ?>" />
												<input type="hidden" name="size" value="<?php echo $oneProduct['size']; ?>" />
												<input type="hidden" name="color" value="<?php echo $oneProduct['color']; ?>" />
												<input type="hidden" value="<?php echo $getProductsizeDetails['available_qty']; ?>" name="available_qty" class="available_qty" />
												<input type="hidden" value="<?php echo $getProductsizeDetails['customer_discount_price']; ?>" name="price" class="price" />
												
											</td>
											
											
											<td>
												<button class="delete-btn <?php echo $cartRemoveClass; ?>" style="background: #fff;border: none;" data-id="<?php echo $cartProductDetail['id']; ?>"><i class="fa fa-times"></i></button>
												<ul style="margin-top: 22%;">
													<div class="pricelist">
														<p><!-- <i class="fa fa-inr" aria-hidden="true"></i> --> <i class="fa fa-inr"></i> <?php echo $price; ?></p>
													</div>
												</ul>
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
						<div class="checkbox-wrapper gift-note-check">

    										<div class="checkbox__input">
    
    											<input name="checoutcheck" type="hidden" value="0">
    
    											<input class="input-checkbox" type="checkbox" value="1" checked="checked" name="subscribe" id="checkout_buyer_accepts_marketing">
    
    										</div>
    
    										<label class="checkbox__label" for="checkout_buyer_accepts_marketing">
    
    											Add a gift note
    
    										</label>
    									</div>
    									<br>
    									
						
						<div class="gift-note-check-message">

											<div class="form-group">

												<!-- <label>Enter Pincode<em>*</em></label> -->
                                                
												<textarea class="form-control" placeholder="Write your message here"></textarea>

												<span class="bar"></span>

											</div>

										</div>
										<br>
										<br>
						                
					</div>
				</div>
				<div class="col-xl-4 col-md-4 col-sm-12">
					<div class="cart-tatal-sec">
						<div class="cart-total text-center">
							<!--<div class="cart-sub-total">
								<p class="sub-ttl-title pull-right width30"><b><i class="fa fa-inr"></i> <?php echo $subTotal; ?></b></p>
								<p class="sub-ttl-title pull-right">Sub Total</p>
								<div class="clearfix"></div>
							</div>
							<div>

							</div>


							<div class="summery cart-delivery ">
								<?php 
									$totaltaxamount =  $taxAmount1;
								?>
								<p class="sub-ttl-title pull-right rs-span width30"><i class="fa fa-inr" aria-hidden="true"></i> <b><?php echo $totaltaxamount; ?></b></p>
								<p class="sub-ttl-title pull-right delivery">Tax</p>
								<div class="clearfix">
								</div>
							</div>-->


							<div class="ttl-div">
								<span class="span-ttl span-ttl-rs">Order Subtotal </span><br><br> <span class="span-ttl-rs width30"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subTotal + $shippingCharges + $totaltaxamount; ?></span>
							</div>

							<!--<div class="clearfix"></div>-->

							<!--<div class="checkout-btns">-->
								<!--<a href="<?php echo BASE_URL; ?>/chekout-order-summary.php" class="shop-now-btn purple-btn text-center" id="proceedCheckout">Proceed to CheckOut</a>-->
							<!--	<a href="<?php echo BASE_URL; ?>/chekout-order-summary.php" class="shop-now-btn purple-btn text-center" id="proceedCheckout">CheckOut</a>-->
							<!--</div>-->
							<div class="commonbtn">
					          
					          <a href="<?php echo BASE_URL; ?>/chekout-order-summary.php" style="font-family: 'Gotham-Font';" class="knowmoere" id="proceedCheckout">Checkout &nbsp;<img src="https://solvoix.xyz/selvel/include/right-arrow.png"></a>
				          </div>
						  <div class="checkout-btn-info"><p>Shipping, taxes, and promotions calculated at checkout</p></div>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php
	}
	else { 
	?><h2 class="cartemts" style="    font-size: 30px;
    font-weight: bold;
    text-align: center;">Your Cart is Empty</h2><?php }
	$cartHTML = ob_get_contents(); // do not change variable name $checkoutCartPageHTML
	ob_end_clean();
?>