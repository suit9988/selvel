<?php 
	include_once 'include/functions.php';
	$functions = new Functions(); 
	
	include_once("include/classes/Email.class.php");

	if(isset($_POST['prodemail'])) {
		$email = $functions->escape_string($functions->strip_all($_POST['prodemail']));
		$notify_prod_id = $functions->escape_string($functions->strip_all($_POST['notify_prod_id']));
		$notify_prod_size = $functions->escape_string($functions->strip_all($_POST['notify_prod_size']));
		$query = $functions->query("INSERT INTO ".PREFIX."subscription (email, product_id, size_id) values ('".$email."', '".$notify_prod_id."', '".$notify_prod_size."')");
		$emailObj = new Email();
		$mailBody = "
		<p>
		Dear Customer
		<br>
		Thank you for subscribing to Selvel Insights. We will notify you when the product is back in stock.
		<br>
		<br>For any other queries or requests, please write to us at <a href='mailto:info@selvel.com'> info@selvel.com</a>.
		</p>";

		$emailObj->setEmailBody($mailBody);
		$emailObj->setSubject(SITE_NAME." | Thank You Subscribe to Selvel");
		$emailObj->setAddress($_POST['prodemail']);
		//$adminemail = $functions->getAdminEmail();
		//$emailObj->setAdminAddress($adminemail);
		$res = $emailObj->sendEmail();
	}

	$permalink = '';
	if(!isset($_GET['permalink']) || empty($_GET['permalink'])) {
		header("location: ".BASE_URL);
		exit;
	}

	$permalink = $functions->strip_all($_GET['permalink']);
	$productDetails = $functions->getProductByproductPermalink($permalink);
	if(!$productDetails) {
		header("location".BASE_URL."/404-notfound.php");
		exit;
	}

	$pageTitle = !empty($productDetails['page_title']) ? $productDetails['page_title'] : $productDetails['product_name'];
	$meta_keyword = !empty($productDetails['meta_keyword']) ? $productDetails['meta_keyword'] : $productDetails['product_name'];
	$meta_description = !empty($productDetails['meta_description']) ? $productDetails['meta_description'] : $productDetails['product_name'];
	$sne_p_id=$productDetails['id'];

	$sne_qry = "SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE product_id='".$sne_p_id."'";
	$sne_f = $functions->query($sne_qry);
	$sne_row = $functions->fetch($sne_f);
	$cc_id=$sne_row['category_id'];
	$ss_id=$sne_row['subscategory_id'];

	$sql_cat1 = "select * from ".PREFIX."category_master where id='$cc_id'";
	$results_cat1 = $functions->query($sql_cat1);
	$row_cat1 = $functions->fetch($results_cat1);
	$row_cat1['category_name'];

	$sql_cat2 = "select * from ".PREFIX."sub_category_master where id='$ss_id'";
	$results_cat2 = $functions->query($sql_cat2);
	$row_cat2 = $functions->fetch($results_cat2);
	$row_cat2['category_name'];
	//exit();

	$ratingsRS = $functions->getRatingByProductId($productDetails['id']);

	$ip = $_SERVER['REMOTE_ADDR'];
	$ipCheckSql = "SELECT * FROM ".PREFIX."product_views WHERE ip='".$ip."' and product_id='".$productDetails['id']."'";
	$ipCheckRes = $functions->query($ipCheckSql);
	if($functions->num_rows($ipCheckRes)==0) {
		$ipInSql = "INSERT INTO ".PREFIX."product_views (product_id, views, ip) VALUES ('".$productDetails['id']."','1','".$ip."')";
		$queryIp = $functions->query($ipInSql);
		$functions->query("update ".PREFIX."product_master set total_views=total_views+1 where id='".$productDetails['id']."'");
	}
   
	if(isset($_POST['color']) && isset($_POST['size'])) {
		$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' AND size='".$_POST['size']."' and productcolor='".$_POST['color']."' ORDER BY id ASC LIMIT 1"));
		if(!$getProductsizeDetails) {
			$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' AND size='".$_POST['size']."' ORDER BY id ASC LIMIT 1"));
		}
		$color = $_POST['color'];
	} else {
		$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' ORDER BY id ASC LIMIT 1"));
		$color='';
	}
?>
<!DOCTYPE>

<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta name="description" content="<?php echo $meta_description; ?>">
		<meta name="keywords" content="<?php echo $meta_keyword; ?>">
		<meta name="author" content="SELVEL">
		<?php include("include/header-link.php");?>
	</head>

	<body class="inner-page" id="details-page" onLoad="preLoad()">
		<!--Top start menu head-->
		<?php include("include/header.php");?>
		<!--Main Start Code Here-->
		<main class="main-inner-div">
			<img src="<?php echo BASE_URL; ?>/images/details-banner-header.jpg" class="img-full fixedimg">        
			<div class="container breadcum-header">
				<ul>
					<li>
						<a href="<?php echo BASE_URL; ?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="<?php echo BASE_URL; ?>/<?php echo 	 $row_cat1['permalink']; ?>"><?php echo 	 $row_cat1['category_name']; ?></a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="<?php echo BASE_URL; ?>/<?php echo 	 $row_cat1['permalink']; ?>/<?php echo 	 $row_cat2['permalink']; ?>" ><?php echo 	 $row_cat2['category_name']; ?></a>  
					</li>
				</ul>
			</div>
			<section class="details-section" id="details-section-sub">
				<div class="container">
					<div class="row"> 
						<div class="col-md-5">
							<div class="zoom-gallery">
								<?php
									if($getProductsizeDetails['image1_color']) {
										$file_name = str_replace('', '-', strtolower( pathinfo($getProductsizeDetails['image1_color'], PATHINFO_FILENAME)));
										$ext = pathinfo($getProductsizeDetails['image1_color'], PATHINFO_EXTENSION);
								?>
										<img id="zoom_03" src="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>" data-zoom-image="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>" width="100%" />
										<div class="imga-galsa">
											<div id="gallery_01">
												<?php
													$imageFields = array('image1_color', 'image2_color', 'image3_color', 'image4_color');
													$i=1;
													$ii=0;

													foreach($imageFields as $oneField) {
														if(!empty($getProductsizeDetails[$oneField])) {
															$file_name = str_replace('', '-', strtolower( pathinfo($getProductsizeDetails[$oneField], PATHINFO_FILENAME)));
															$ext = pathinfo($getProductsizeDetails[$oneField], PATHINFO_EXTENSION);
												?>
															<div>
																<a href="#" class="elevatezoom-gallery <?php if($i++==1) { echo "active"; } ?>" data-update="" data-image="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>" data-zoom-image="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>">
																	<img src="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>" width="100" />
																</a>
															</div>
												<?php
														}
														$ii++;
													}
												?> 
											</div>
										</div>
								<?php
									}
								?>
							</div>
						</div>
						<div class="col-md-7">
							<div class="descidetails">
								<h2 class="product-name"><?php echo ucwords($productDetails['product_name']); ?></h2>
								<div class="product-copdes">
									<span>Product code : <?php echo ucwords($productDetails['product_code']); ?></span> |
									<span>HSN code : <?php echo ucwords($productDetails['hsn_code']); ?></span>
								</div>
								<ul class="review-result-strip list-inline mainlist-top">
									<span class="ratingSpan star<?php echo str_replace(".","",$productDetails['avg_rating']);  ?>"></span>
									<li>
										<div class="total-reviews">
											<?php if($loggedInUserDetailsArr = $functions->sessionExists()) { ?>
												<a data-fancybox="" data-type="iframe" data-src="<?php echo BASE_URL; ?>/write-a-review.php?product_id=<?php echo $productDetails['id'];  ?>" href="javascript:;" class="btn default-btn">Write a review</a>
											<?php } else { ?>
												<a data-fancybox data-src="#sign-in-pop" href="javascript:;" class="btn default-btn before-login">Write a product Review</a>
											<?php } ?>
										</div>
									</li>
								</ul>
								<div class="pricestags">
									<?php
										if(isset($getProductsizeDetails['customer_discount_price']) && !empty($getProductsizeDetails['customer_discount_price'])) {
									?>
											<span class="dicount-price">
												<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>
											</span>
											<span class="actual-rate-price">
												<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_discount_price'] ?>
											</span>
									<?php 
										} else {
									?>
											<span class="actual-rate-price">
												<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>
											</span>
									<?php
										}

										if($getProductsizeDetails['available_qty']>0) {
									?>
											<span class="outofsstock">IN Stock</span>
									<?php
										} else {
									?>
											<span class="outofsstock">Out of Stock</span>									
									<?php
										}
									?>
								</div>
								<?php if($getProductsizeDetails['available_qty']==0) { ?>
									<div class="emailnotify">
										<form class="form-notify-produt" method="POST">
											<div class="form-group">
												<input type="email" name="prodemail" id="peodemail" placeholder="Email ID" required>
												<input type="hidden" name="notify_prod_id" value="<?php echo $productDetails['id']; ?>" >
												<input type="hidden" name="notify_prod_size" value="<?php echo $getProductsizeDetails['id']; ?>" >
												<button class="submit-pros" type="submit">Notify ME</button>
											</div>
										</form>
									</div>
								<?php } ?>

								<hr class="linediv">
								<form id="formcolorsizebox" method="POST">
									<?php 
										if($getProductsizeDetails['productcolor']) {
									?>
											<div class="size-boxes">
												<span class="w10">
													<h2 class="comson2">Size</h2>
												</span>
												<span class="size-names samspop w25"><?php echo $getProductsizeDetails['size']; ?></span>
												<span class="size-box-input" data-toggle="buttons">
													<?php
														$getProductsizeDetailsList = $functions->query("SELECT DISTINCT(size) FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."'");
														while($getProductsizeDetailsListRow = $functions->fetch($getProductsizeDetailsList)) {
													?>
															<label class="btn size-btn <?php if($getProductsizeDetailsListRow['size']==$getProductsizeDetails['size']) { echo "active"; } ?>">
																<?php if($getProductsizeDetailsListRow['size']==$getProductsizeDetails['size']) { ?>
																	<!-- <span class="fa fa-check"></span> -->
																<?php } ?>
																<?php echo $getProductsizeDetailsListRow['size']; ?> ML
																<input type="radio" name="size" id="<?php echo $getProductsizeDetailsListRow['size']; ?>"  value="<?php echo $getProductsizeDetailsListRow['size']; ?>" autocomplete="off" <?php if($getProductsizeDetailsListRow['size']==$getProductsizeDetails['size']) { ?>checked<?php } ?>>
															</label>
													<?php
														}
													?>
												</span>
											</div>

											<div class="color-boxes">
												<span class="w10">
													<h2 class="comson2">Color</h2>
												</span>
												<span class="color-names samspop w25"> 
													<?php
														echo $getProductsizeDetails['productcolor'];
														$color=$getProductsizeDetails['productcolor'];
													?>
												</span>

												<?php
													$sne_qry_col_dis = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' and size='".$getProductsizeDetails['size']."'";
													$sne_f_col_dis = $functions->query($sne_qry_col_dis);
													while($sne_row_col_dis = $functions->fetch($sne_f_col_dis)) {
														$sne_col= $sne_row_col_dis['productcolor'];
														$sne_qry_col = "SELECT * FROM ".PREFIX."color_master WHERE color='".$sne_col."'";
														$sne_f_col = $functions->query($sne_qry_col);
														$sne_row_col = $functions->fetch($sne_f_col);
														$cc_id_col=$sne_row_col['image'];
														$ss1= BASE_URL."/images/color/".$cc_id_col;
												?>
														<span class="color-box-input" data-toggle="buttons">
															<label class="btn colo-btn <?php if($sne_row_col_dis['productcolor']==$getProductsizeDetails['productcolor']) { ?>active<?php } ?>" style="background-image: url('<?php echo $ss1; ?>')">
																<input type="radio" name="color" id="<?php echo $sne_col; ?>"  value="<?php echo $sne_col; ?>" autocomplete="off" <?php if($sne_row_col_dis['productcolor']==$getProductsizeDetails['productcolor']) { ?>checked<?php } ?>>
																<?php if($sne_row_col_dis['productcolor']==$getProductsizeDetails['productcolor']) { ?>
																	<span class="fa fa-check"></span>
																<?php } ?>
															</label>
														</span>
												<?php
													}
												?>
											</div>
									<?php 
										}
									?>
								</form>
								<hr class="linediv">
								<?php
									$inCartQty = '1';
									if(isset($cartObj)) {
										// $cartObj = new Cart();
										$tempInCartQty = $cartObj->getProductQuantity($productDetails['id'], $functions);
										if($tempInCartQty) {
											$inCartQty = $tempInCartQty;
										}
									}
								?>
								<div class="quantity">
									<span>
										<h2 class="comson2">Quantity</h2>
									</span>
									<ul class="list-inline">
										<li><button class="btn-number" data-type="minus" data-field="productCount">-</button></li>
										<li class="numm"><input type="number" id="number" name="productCount" value="<?php echo $inCartQty; ?>" min="1" max="<?php echo $getProductsizeDetails['available_qty']; ?>" readonly></li>

										<li><button class="btn-number" data-type="plus" data-field="productCount">+</button></li>
										<input type="hidden" id="available_qty" class="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>" name="available_qty" >
									</ul>
								</div>
								<div class="scrlll">
									<ul class="btn-groups list-inline">
										<?php
											if($getProductsizeDetails['available_qty']>0) {
										?>
												<button name="cartBtn" id="cartBtn" data-color="<?php echo $getProductsizeDetails['productcolor']; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" data-id="<?php echo $productDetails['id']; ?>" ><img src="<?php echo BASE_URL; ?>/images/checkout-cart.png"> Add to Cart</button>
										<?php
											} else {
										?>
												<button name="OUTOFSTOC" id="OUTOFSTOC" class="outofstockbtn btn-animation"><span style="color:red;">Out of stock</span></button>
										<?php
											}
										?>

										<li class="detailwish">
											<?php
												if($loggedInUserDetailsArr = $functions->sessionExists()){
													$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
													if($functions->num_rows($wishlistRS)>0){
														$hearticon = 'fa-heart addedwish';
													} else {
														$hearticon = 'fa-heart';
													}
											?>
													<button type="button" class="clsWishlist"  data-color="<?php echo $color; ?>" data-size="<?php if(isset($_POST['size'])){ echo $_POST['size']; }else{ echo $getProductsizeDetails['size']; } ?>" data-id="<?php echo $productDetails['id'];  ?>" >
														<i class="fa <?php echo $hearticon ?>"></i> Wishlist
													</button>
											<?php
												} else {
											?>
													<a  class="wishlistbtnnew" href="<?php echo BASE_URL; ?>/login.php?productredirect=<?php echo $permalink; ?>" style="width: auto !important;"><img src="<?php echo BASE_URL; ?>/images/wishlist.png" alt="" >  Wishlist</a>
											<?php
												}
											?>
										</li>

										<li>
											<?php 
												if($getProductsizeDetails['available_qty']>0){
											?>
													<button id="buyNowBtn" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $getProductsizeDetails['productcolor']; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>"  value="<?php echo $productDetails['id']; ?>"> Buy Now</button>
											<?php
												}
											?>
										</li>
										<li>
											<a href="javascript:void(0);" class="a2a_dd">
												<img src="<?php echo BASE_URL; ?>/images/share.png" alt="">
											</a>
										</li>
									</ul>
								</div>

								<div class="delivery-code">
									<form class="delivery-form">
										<label>
											Delivery
											<input type="number"  name="deliverycode" value="" placeholder="Enter Delivery Pincode" required="">
										</label>
										<button type="button" class="checkDeliveryBtn">Check</button>
										<div class="deliveryMsg"></div>
									</form>
								</div>
								<?php if($productDetails['amazon_link']){ ?>
									<a href="<?php echo $productDetails['amazon_link']; ?>"target="_blank" class="amazon-links">View product on amazon</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

				<div class="container">
					<div class="description-devips">
						<div class="tab-list-pros">
							<a href="#fetures" class="active bntlpop">Features</a>
							<a href="#reviews" class="bntlpop">Reviews</a>
						</div>

						<div class="tabs-descripton-detail">
							<div class="tab-destils-descop" id="fetures">
								<div class="black-text">
									<?php
										if($getProductsizeDetails['features_color']) {
											echo $getProductsizeDetails['features_color'];
										}
									?>
								</div>
							</div>

							<div class="tab-destils-descop" id="reviews">
								<h2 class="titlespesu">Reviews</h2>
								<?php
									$starRating1 = 0;
									$starRating2 = 0;
									$starRating3 = 0;
									$starRating4 = 0;
									$starRating5 = 0;
									$totalRating = 0;
									$rating1Percent = 0;
									$rating2Percent = 0;
									$rating3Percent = 0;
									$rating4Percent = 0;
									$rating5Percent = 0;

									$staRCountData = $functions->getProductReviewPercentagebyProductid($productDetails['id']);
									if($functions->num_rows($staRCountData)>0) {
										while($starCount = $functions->fetch($staRCountData)) {
											if(round($starCount['rating'])==1) {
												$starRating1 =  $starCount['starCount'];
											} elseif(round($starCount['rating'])==2) {
												$starRating2 =  $starCount['starCount'];
											} elseif(round($starCount['rating'])==3) {
												$starRating3 =  $starCount['starCount'];
											} elseif(round($starCount['rating'])==4) {
												$starRating4 =  $starCount['starCount'];
											} elseif(round($starCount['rating'])==5) {
												$starRating5 =  $starCount['starCount'];
											}
											$starRating =  $starCount['starCount'];
										}

										if(!empty($starRating)) {
											$rating1Percent = ($starRating1 / $starRating * 100);
											$rating2Percent = ($starRating2 / $starRating * 100);
											$rating3Percent = ($starRating3 / $starRating * 100);
											$rating4Percent = ($starRating4 / $starRating * 100);
											$rating5Percent = ($starRating5 / $starRating * 100);
										}
									}
								?>
								<div class="review-result">
									<ul class="left-doso match">
										<li>
											<div class="ratingDiv" id="ratingDiv1">
												<span class="ratingSpan star<?php echo str_replace(".","",$productDetails['avg_rating']);  ?>"></span>
											</div>
										</li>
										<li>
											<div class="total-reviews">
												<p>Based on <?php echo $functions->num_rows($ratingsRS); ?> Reviews</p>
											</div>
										</li>
									</ul>

									<div class="reviews_left match">
										<div class="skill-shortcode">
											<div class="skill">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: <?php echo $rating5Percent.'%'; ?>">
														<span class="progress-bar-span">5 star</span>
														<span class="perc_only"><?php echo $rating5Percent; ?>%</span>
													</div>
												</div>
											</div>
											<div class="skill">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: <?php echo $rating4Percent.'%'; ?>">
														<span class="progress-bar-span">4 star</span>
														<span class="perc_only"><?php echo $rating4Percent; ?>%</span>
													</div>
												</div>
											</div>
											<div class="skill">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width:  <?php echo $rating3Percent.'%'; ?>">
														<span class="progress-bar-span">3 star</span>
														<span class="perc_only"><?php echo $rating3Percent; ?>%</span>
													</div>
												</div>
											</div>
											<div class="skill">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width:  <?php echo $rating2Percent.'%'; ?>">
														<span class="progress-bar-span">2 star</span>
														<span class="perc_only"> <?php echo $rating2Percent; ?>%</span>
													</div>
												</div>
											</div>
											<div class="skill">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width:  <?php echo $rating1Percent.'%'; ?>">
														<span class="progress-bar-span">1 star</span>
														<span class="perc_only"><?php echo $rating1Percent; ?>%</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<ul class="review-result-strip list-inline match">
										<li class="product-review-btn">
											<?php if($loggedInUserDetailsArr = $functions->sessionExists()) { ?>
												<a data-fancybox="" data-type="iframe" data-src="<?php echo BASE_URL; ?>/write-a-review.php?product_id=<?php echo $productDetails['id'];  ?>" href="javascript:;" class="btn default-btnwis">Write a product Review</a>
											<?php } else { ?>
												<a data-fancybox data-src="#sign-in-pop" href="javascript:;" class="before-login btn default-btnwis">Write a product Review</a>
											<?php } ?>
										</li>
									</ul>
								</div>

								<div class="reviews-lists">
									<?php
										if($functions->num_rows($ratingsRS)>0) {
											while($userDetails = $functions->fetch($ratingsRS)) {
									?>
												<div class="reviews-lists-design">
													<h3><?php echo $userDetails['name'] ?></h3>
													<h4>
														<?php echo "on ".date('d F Y' ,strtotime($userDetails['created'])); ?>
													</h4>

													<div class="ratingDiv" id="ratingDiv1">
														<span class="ratingSpan star<?php echo str_replace(".","", $userDetails['rating']); ?>"></span>
													</div>
													<p><?php echo  $userDetails['review']; ?></p>
												</div>
									<?php
											}
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="container">
					<div class="similar-poorsdus">
						<h6>you may also like</h6>
						<div class="listing-modules">
							<div class="sellers-slider" id="slider-simmi">
								<?php
									$getProductIdDetails1 = $functions->query("SELECT * FROM ".PREFIX."products_related_products WHERE product_id='".$productDetails['id']."'");
									$num=$functions->num_rows($getProductIdDetails1);
									if($num!=0) {
										while($rowProductIdList1 = $functions->fetch($getProductIdDetails1)) {
											//echo $rowProductIdList1['related_product_id'];
											$productDetails1 = $functions-> getUniqueProductById($rowProductIdList1['related_product_id']);
											$getProductsizeDetails1 = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList1['related_product_id']."' ORDER BY id ASC LIMIT 1"));
											if($productDetails1['active']) {
												$productBanner = $functions->getImageUrl('products',$getProductsizeDetails1['image1_color'],'crop','');
								?>
												<div class="produc-main" id="slide-simmi1">
													<div class="img-prods">							
														<?php $product_link1 = $functions-> getProductDetailPageURL($productDetails1['id']); ?>
														<a href="<?php echo BASE_URL ?>/<?php echo $product_link1; ?>">
															<?php
																$file_name1 = str_replace('', '-', strtolower( pathinfo($productDetails1['main_image'], PATHINFO_FILENAME)));
																$ext1 = pathinfo($productDetails1['main_image'], PATHINFO_EXTENSION);
															?>
															<img src="<?php echo $productBanner ?>"  width="250">
															<div class="prohover">
																<img src="<?php echo BASE_URL?>/images/logo.png">
																<h6>Buy Now</h6>
															</div> 
														</a>
													</div>
													<div class="prods-desc">
														<h2>
															<?php
																echo $productDetails1['product_name'];
																$productColorArray1 = explode(",", $getProductsizeDetails1['productcolor']);
															?> 
														</h2>
														<div class="prods-price">
															<?php if($getProductsizeDetails1['customer_discount_price']){  ?>
																<span class="text-drop">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails1['customer_price'] ?>
																</span>
																<span class="text-price-og">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails1['customer_discount_price'] ?>
																</span>
															<?php } else { ?>
																<span class="text-price-og">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails1['customer_price'] ?>
																</span>
															<?php } ?>
														</div>
														<div class="pric-cart-add">
															<!-- <span>
																<a href="<?php// echo BASE_URL ?>/<?php //echo $product_link1; ?>">
																	<i class="fa fa-eye"></i>
																</a>
															</span> -->
															<span>
																<?php
																	if($loggedInUserDetailsArr1 = $functions->sessionExists()){
																		$wishlistRS1 = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails1['id']."' and customer_id='".$loggedInUserDetailsArr1['id']."'");
																		if($functions->num_rows($wishlistRS1)>0){
																			$hearticon1 = 'fa-heart';
																		} else {
																			$hearticon1 = 'fa-heart-o';
																		}
																?>
																		<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails1['id']; ?>" data-color="<?php echo $productColorArray1[0]; ?>" data-size="<?php echo $getProductsizeDetails1['size']; ?>" onclick="addToWishList()">  
																			<i class="fa <?php echo $hearticon1; ?>"></i>
																		</a>
																<?php } else { ?>
																	<a  class="wishlistbtnnew" href="">
																	<i class="fa fa-heart-o"></i> </a>
																<?php } ?>
															</span>
															<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails1['id']; ?>"> <i class="fa fa-shopping-cart"></i>
																<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails1['available_qty']; ?>">
																<input type="hidden" name="size" value="<?php echo $getProductsizeDetails1['size']; ?>">
																<input type="hidden" name="color" value="<?php echo $productColorArray1[0]; ?>">
															</span>
														</div>
													</div>
												</div>
								<?php
											}
										}
									} else {
										$categoryDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE product_id='".$productDetails['id']."' ORDER BY id DESC LIMIT 1"));

										$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$categoryDetails['category_id']."' AND subscategory_id='".$categoryDetails['subscategory_id']."'");
										while($rowProductIdList = $functions->fetch($getProductIdDetails)) {
											$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
											$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' ORDER BY id ASC LIMIT 1"));
											$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');

											if($productDetails['active']) {
								?>
												<div class="produc-main" id="slide-simmi1">
													<div class="img-prods">
														<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
														<a href="<?php echo BASE_URL ?>/<?php echo $product_link; ?>">
														<?php
															$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
															$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
														?>
														<img src="<?php echo $productBanner; ?>"  width="250">

															<div class="prohover">
																<img src="<?php echo BASE_URL?>/images/logo.png">
																<h6>Buy Now</h6>
															</div> 
														</a>
													</div>
													<div class="prods-desc">
														<h2>
															<?php echo $productDetails['product_name'];
															$productColorArray = explode(",", $getProductsizeDetails['productcolor']);
															?>
														</h2>
														<div class="prods-price">
															<?php if($getProductsizeDetails['customer_discount_price']){  ?>
																<span class="text-drop">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>
																</span>
																<span class="text-price-og">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_discount_price'] ?>
																</span>
															<?php }else{ ?>
																<span class="text-price-og">
																	<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>
																</span>
															<?php } ?>
														</div>
														<div class="pric-cart-add">
															<!-- <span>
																<a href="<?php //echo BASE_URL ?>/<?php //echo $product_link; ?>">
																	<i class="fa fa-eye"></i>
																</a> 
															</span> -->
															<span>
																<?php
																	if($loggedInUserDetailsArr = $functions->sessionExists()) {
																		$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
																		if($functions->num_rows($wishlistRS)>0){
																			$hearticon = 'fa-heart';
																		} else {
																			$hearticon = 'fa-heart-o';
																		}
																?>
																		<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
																			<i class="fa <?php echo $hearticon; ?>"></i>
																		</a>
																<?php } else { ?>
																	<a  class="wishlistbtnnew" href="">
																		<i class="fa fa-heart-o"></i> </a>
																<?php } ?>
															</span>
															<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>"> <i class="fa fa-shopping-cart"></i>
																<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
																<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
																<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">
															</span>
														</div>
													</div>
												</div>
								<?php
											}
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>

		<!--Main End Code Here-->
		<!--footer start menu head-->

		<?php include("include/footer.php");?> 

		<!--footer end menu head-->

		<?php include("include/footer-link.php");?>
		<script async src="https://static.addtoany.com/menu/page.js"></script>
		<script>
			var a2a_config = a2a_config || {};
			a2a_config.onclick = 1;
		</script>
		<script>
			$("[data-fancybox]").fancybox({
				toolbar  : false,
				smallBtn : true,
				iframe : {
					preload : true,
					css : {
						width : '600px',
						height : '350px'
					}
				}
			});

			$('.bntlpop').on('click', function (e) {
				$(".bntlpop").toggleClass("active");

				// $(".tab-list-pros").toggleClass("fixed");

				e.preventDefault()

				$('html, body').animate({
					scrollTop: $($(this).attr('href')).offset().top - 100,
				},500,'linear')
			});

			// $("input[name='color']")[0].click();
			// $("input[name='size']")[0].click();

			$(".colo-btn").on('change', function() {
				var radioValue = $("input[name='color']:checked"). val();

				$(".color-names").text(radioValue);
				$('#formcolorsizebox').submit();
			});

			$(".size-btn").on('change', function() {
				var radioValue = $("input[name='size']:checked"). val();

				$(".size-names").text(radioValue);
				$('#formcolorsizebox').submit();
			});

			$(function($) {
				// define the gallery object
				var $gallery = $('#gallery_01');

				// Build array of objects to open in Fancybox.

				var $imgs = [];
				$('a', $gallery).each(function() {
					$imgs.push({'src': $(this).data('zoom-image')});
				});

				if ($(window).width() > 780) {
					var elevateZoomOptions = {
						gallery:'gallery_01',
						cursor: 'pointer',
						zoomType:'window',
						zoomLens :false,
						easing : true,
						scrollZoom : true,
						galleryActiveClass: "active",
						imageCrossfade: true,
						loadingIcon: "<?php echo BASE_URL; ?>/images/ajax-loader.gif"
					};

					$("#zoom_03").elevateZoom(elevateZoomOptions);

					// Bind Fancybox to clicking the zoom image.

					// Open it to the currently active index.

					$("#zoom_03").on("click", function(e) {
						e.preventDefault();
						var active_index = $('.active', $gallery).index();
						$.fancybox.open($imgs, false, active_index);
					});
				}

				if ($(window).width() < 770) {
					var elevateZoomOptions = {
						gallery:'gallery_01',
						cursor: 'pointer',
						zoomType:'none',
						easing : true,
						scrollZoom : true,
						galleryActiveClass: "active",
						imageCrossfade: true,
						loadingIcon: "<?php echo BASE_URL; ?>/images/ajax-loader.gif"
					};

					$("#zoom_03").elevateZoom(elevateZoomOptions);

					// Bind Fancybox to clicking the zoom image.

					// Open it to the currently active index.

					$("#zoom_03").on("click", function(e) {
						e.preventDefault();
						var active_index = $('.active', $gallery).index();
						$.fancybox.open($imgs, false, active_index);
					});
				}

				$('.gallery').on('click', '.slick-slide', function(e){
					if($(this).hasClass('hasVideo')){
						$('.videoShow').show();
					} else {
						$('.videoShow').hide();
					}
				});

				$('.demonvideo1').click(function(){
					$(".vmdemo1").show();
					$(".zoomContainer").hide();
					$(".vmdemo2").hide();
					$(".vmdemo3").hide();
					$(".vmdemo4").hide();
					$(".vmdemo5").hide();
				});

				$('.demonvideo2').click(function(){
					$(".vmdemo1").hide();
					$(".zoomContainer").hide();
					$(".vmdemo2").show();
					$(".vmdemo3").hide();
					$(".vmdemo4").hide();
					$(".vmdemo5").hide();
				});

				$('.demonvideo3').click(function(){
					$(".vmdemo1").hide();
					$(".vmdemo2").hide();
					$(".zoomContainer").hide();
					$(".vmdemo3").show();
					$(".vmdemo4").hide();
					$(".vmdemo5").hide();
				});

				$('.demonvideo4').click(function(){
					$(".vmdemo1").hide();
					$(".vmdemo2").hide();
					$(".zoomContainer").hide();
					$(".vmdemo3").hide();
					$(".vmdemo4").show();
					$(".vmdemo5").hide();
				});

				$('.demonvideo5').click(function(){
					$(".vmdemo1").hide();
					$(".vmdemo2").hide();
					$(".zoomContainer").hide();
					$(".vmdemo3").hide();
					$(".vmdemo4").hide();
					$(".vmdemo5").show();
				});

				$('.elevatezoom-gallery img').click(function(){
					$('.videoShow').hide();
					$(".zoomContainer").show();
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$(".scroll").mCustomScrollbar({
					theme: "inset-dark",
					scrollButtons: {enable:true}
				});

				$(".checkDeliveryBtn").click(function() {
					$(".deliveryMsg").html();
					var deliverycode = $('input[name="deliverycode"]').val();
					if(deliverycode=='') {
						$(".deliveryMsg").html('<span style="color: red">Please enter your pincode</span>');
						return false;
					}
					$.ajax({
						type: "post",
						data: {pincode: deliverycode},
						url: "<?php echo BASE_URL ?>/ajaxCheckDeliveryPincode.php",
						success: function(response) {
							if(response=='true') {
								$(".deliveryMsg").html('<span style="color: green">We deliver to this location</span>');
							} else {
								$(".deliveryMsg").html('<span style="color: red">We do not deliver to this location</span>');
							}
						}
					});
				});
			});

			/*  $('#cartBtn').on('click',function(){
				setTimeout(function(){         
					window.location="<?php echo BASE_URL; ?>/cart.php?productredirect=<?php echo $permalink; ?>";
				}, 200);
			});

			$('.clsWishlist').on('click',function(){
				setTimeout(function(){         
					window.location="<?php echo BASE_URL; ?>/my-wishlist.php";
				}, 200);
			});

			$('.cartListingBtn').on('click',function(){
				setTimeout(function(){         
					window.location="<?php echo BASE_URL; ?>/cart.php";
				}, 200);
			}); */
		</script>
	</body>
</html>