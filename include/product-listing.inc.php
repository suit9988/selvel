<div class="listing-modules wow fadeInUp" >
	<div class="sellers-slider">
		<?php
			$checkUserLogedInOrNot = $functions->sessionExists();

			$productResult = $functions->getFilterProductlist($_REQUEST);
			if($functions->num_rows($productResult)>0) {
				while($productDetails = $functions->fetch($productResult)) {
					if(!$productDetails['productSizeId']) {
						$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' ORDER BY id ASC LIMIT 0,1"));
						$productDetails['productSizeId'] = $getProductsizeDetails['id'];
					}
					//$productBanner = $functions->getImageUrl('products',$productDetails['main_image'],'crop','');
					$productPermalink = $functions->getProductDetailPageURL($productDetails['id'], $productDetails['productSizeId']);
					// $getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' ORDER BY id ASC LIMIT 1"));
					$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE id='".$productDetails['productSizeId']."'"));
					$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');
					$color_bw = $getProductsizeDetails['productcolor'];
					if(!empty($getProductsizeDetails['customer_discount_price'])) {
						$Jprice = $getProductsizeDetails['customer_discount_price'];
					} else {
						$Jprice = $getProductsizeDetails['customer_price'];
					}
		?>
					<div class="produc-main Jprice" data-price="<?php echo $Jprice; ?>" data-id="<?php echo $productDetails['id']; ?>" data-rating="<?php echo $productDetails['avg_rating']; ?>">
						<div class="img-prods">	
							<span class="listingWish pric-cart-add heart_bw " style="display: grid;z-index: 9;top: 10px;">
								<?php
									if($loggedInUserDetailsArr = $functions->sessionExists()){
										$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
										if($functions->num_rows($wishlistRS)>0){
											$hearticon = '<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_red.png">';
										} else {
											$hearticon = '<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_black.png">';
										}
								?>
										<a style="align-items: baseline;" class="clsWishlist"  data-color="<?php echo $getProductsizeDetails['productcolor']; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" >  
											<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_red.png" </a>
								<?php } else { ?>
										<a  class="wishlistbtnnew" style="align-items: baseline;" href="">
										<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_black.png"> </a>
								<?php } ?>
							</span>
							<a href="<?php echo BASE_URL; ?>/<?php echo $productPermalink; ?>"> 
								<img src="<?php echo $productBanner; ?>" alt="<?php echo $productDetails["product_name"]; ?>" class="img-responsive">
								
							</a>
							
						</div>
						<div class="prods-desc">							
							<a href="<?php echo BASE_URL; ?>/<?php echo $productPermalink; ?>">
								<h2 style="font-family: "Gotham-Font";     color: #5C5C5C;">
									<?php echo $productDetails['product_name']; 
										/* if($getProductsizeDetails['size']){
											echo ' ('.$getProductsizeDetails['size'].')';
										} */
										$productColorArray = explode(",", $getProductsizeDetails['productcolor']);
					
									?>
								</h2>
								<input type="hidden" name="id" class="id" value="<?php echo $productDetails["id"]; ?>">
								<div class="product-cat-details">
									<h2><?php echo $productDetails['product_code'] ?> | Capacity: <?php echo $getProductsizeDetails['size']; ?></h2>
								</div>
								<div class="prods-price">                        
									<?php if($getProductsizeDetails['customer_discount_price']){  ?>                          

									<span class="text-price-og" style="font-size:24px; font-family:'Gotham Pro'; color:#5C5C5C" >                          
									<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_discount_price'] ?>                          
									</span>  
									<span class="text-drop"  style="font-size:24px; font-family:'Gotham Pro' color:#C2C2C2">                          
									<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>                          
									</span> 
									<span style="font-family: Gotham Pro; color: #EB2B2B; font-style: normal; font-weight: normal; font-size: 14px;"><font>(10% Discount)</font></span>
									<?php }else{ ?>                           
									<span class="text-price-og">                             
									<i class="fa fa-rupee" style="font-size:24px; font-family:'Gotham Pro' color:#5C5C5C"></i> <?php echo $getProductsizeDetails['customer_price'] ?>                           
									</span>                           
									<?php } ?>                       
								</div>                                      
								<div class="pric-cart-add" style="text-align: left; justify-content: flex-start; top:80px;left: 0px">                          
									 <span>
										 <?
										 foreach($productColorArray as $value_color){
										 ?>
										<a href="">                          
										<i class="fa fa-circle" style="color: <?=$value_color?>;border:1px solid #000; background-color:<?=$value_color?>; border-radius:50%"></i>                          
										</a> 
										<?
										 }
										 ?>
									</span>                                            

								</div> 
								
								<div class="pric-cart-add">
									<?php /* <span>
										<a href="#">
											<i class="fa fa-eye"></i>
										</a> 
									</span> */ ?>
									
									<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">
										<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
										<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
										<input type="hidden" name="color" value="<?php echo $getProductsizeDetails['productcolor']; ?>">
									</span>
								</div>
							</a>
						</div>
					</div>
		<?php
				}
			} else {
		?>
				<div class="emptyListPage">
					<h4 class="h2emps">
						Oops ! Products Not Available.       
					</h4>
					<img src="<?php echo BASE_URL; ?>/images/empty.png">
				</div>
		<?php
			}
		?>
	</div>
</div>