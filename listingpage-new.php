<?php 

	include_once 'include/functions.php';

	$functions = new Functions(); 



	$permalink = '';

	$displayName ='Products';

	$breadcrumbs = '';

	$whereClasue = '';



	if(isset($_GET['cat_permalink']) && !empty($_GET['cat_permalink'])) {

		$breadcrumbs = '';

		$permalink = $functions->escape_string($functions->strip_all($_GET['cat_permalink']));

		$catDetails = $functions->getCategorybyPermlink($permalink);



		if(isset($catDetails['id']) && !empty($catDetails['id'])){

			$catId = $functions->escape_string($functions->strip_all($catDetails['id']));//2

			//exit();

			$breadcrumbs .= "<li><a href=".BASE_URL.">Home</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='javascript:;'>".ucwords($catDetails['category_name'])."</a></li>";

			$permalink = BASE_URL."/".$catDetails['permalink'];

			$displayName  = $catDetails['category_name'];



			$whereClasue .= " and id in (SELECT product_id FROM ".PREFIX."product_category_mapping WHERE `category_id` in ($catId))";

		} else {

			header("location".BASE_URL."/404-notfound.php");

			exit;

		}

		$mtitle = $catDetails['page_title'];

		$mdecription = $catDetails['meta_description'];

		$mkey = $catDetails['meta_keyword'];

		$sne="cat";

	}



	if(isset($_GET['sub_category_permalink']) && !empty($_GET['sub_category_permalink'])){

		//echo "sneha";

		$breadcrumbs = '';

		$subCategoryDetails  = $functions->getSuBCatByPermalink($_GET['sub_category_permalink'],$catId);

		if(isset($subCategoryDetails['id']) && !empty($subCategoryDetails['id'])){

			$subCatId = $functions->escape_string($functions->strip_all($subCategoryDetails['id']));

			//exit();

			$breadcrumbs .= "<li><a href=".BASE_URL.">Home</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='".BASE_URL."/".$catDetails['permalink']."'>".ucwords($catDetails['category_name'])."</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='".BASE_URL."/".$catDetails['permalink']."/".$subCategoryDetails['permalink']."'>".ucwords($subCategoryDetails['category_name'])."</a></li>";

			$permalink = BASE_URL."/".$catDetails['permalink']."/".$subCategoryDetails['permalink'];

			$displayName  = $subCategoryDetails['category_name'];



			$whereClasue .= " and id in (SELECT product_id FROM ".PREFIX."product_subcategory_mapping WHERE `subscategory_id` = '".$subCatId."')";

		} else {

			header("location".BASE_URL."/404-notfound.php");

			exit;

		}

		$mtitle = $subCategoryDetails['page_title'];

		$mdecription = $subCategoryDetails['meta_description'];

		$mkey = $subCategoryDetails['meta_keyword'];

		$sne="subcat";

	}



	if(isset($_GET['subSub_category_permalink']) && !empty($_GET['subSub_category_permalink'])){

		$breadcrumbs = '';

		$subSubCategoryDetails  = $functions->getSubSubCatByPermalink($_GET['subSub_category_permalink'],$subCatId);

		// print_r($subSubCategoryDetails);

		if(isset($subSubCategoryDetails['id']) && !empty($subSubCategoryDetails['id'])){

			$subsubcatId = $functions->escape_string($functions->strip_all($subSubCategoryDetails['id']));

			$breadcrumbs .= "<li><a href=".BASE_URL.">Home</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='".BASE_URL."/".$catDetails['permalink']."'>".ucwords($catDetails['category_name'])."</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='".BASE_URL."/".$catDetails['permalink']."/".$subCategoryDetails['permalink']."'>".ucwords($subCategoryDetails['category_name'])."</a><i class='fa fa-angle-right'></i></li>";

			$breadcrumbs .= "<li><a href='".BASE_URL."/".$catDetails['permalink']."/".$subCategoryDetails['permalink']."/".$subSubCategoryDetails['permalink']."'>".ucwords($subSubCategoryDetails['category_name'])."</a><i class='fa fa-angle-right'></i></li>";

			$permalink = BASE_URL."/".$catDetails['category_name']."/".$subCategoryDetails['permalink']."/".$subSubCategoryDetails['permalink'];

			$displayName  = $subSubCategoryDetails['category_name'];



			$whereClasue .= " and id in (SELECT product_id FROM ".PREFIX."product_subsubcategory_mapping WHERE `subsubcategory_id` in ($subSubCatId))";

		} else {

			header("location".BASE_URL."/404-notfound.php");

			exit;

		}

		$mtitle = $subSubCategoryDetails['page_title'];

		$mdecription = $subSubCategoryDetails['meta_description'];

		$mkey = $subSubCategoryDetails['meta_keyword'];

	}

	//echo $sne;

?>

<!DOCTYPE>

<html>

<head>

	<title><?php echo $mtitle; ?></title>

	<meta name="title" content="<?php echo $mtitle; ?>">

	<meta name="description" content="<?php echo $mdecription; ?>">

	<meta name="keywords" content="<?php echo $mkey; ?>">

	<meta name="author" content="SELVEL">

	<?php include("include/header-link.php");?>

	<!-- <script src="<?php echo BASE_URL; ?>js/jquery-1.10.2.min.js"></script> -->

</head>

<body class="inner-page" id="listing-page">

	<!--Top start menu head-->       

	<?php include("include/header.php");?>

	<!--Main Start Code Here-->

	<main class="main-inner-div listingbgchange" style="    margin-bottom: 5%;">

		<img src="<?php echo BASE_URL; ?>/images/inner-bg.png" class="img-full fixedimg listingsa">  
		<div class="container breadcum-header">

			<ul style="font-family: 'goutam-Font'; color:#5C5C5C;">

				<?php echo $breadcrumbs; ?>

			</ul>

		</div>

		<section class="listing-pages">
			

			<div class="container plr0" id="mobilefilters">

				<div class="filter-sorting">

					<div class="Sort-By">

						<div class="Filter-by">

							<span id="chtext" style=" font-style: normal; font-weight: normal; font-size: 14px; line-height: 13px;">Sort By</span><span style="font-family: Gotham Pro;
font-style: normal;
font-weight: normal;
font-size: 16px;
line-height: 18px;">Bestselling</span>

							<i class="fa fa-plus"></i>

							<i class="fa fa-minus hide"></i>

						</div>

						<form class="sortinform">

							<label for="popular1">

								<!--<input type="radio" name="sortBy" value="pricelow" id="popular1">-->

								<span >Price: Low to High</span>

							</label>

							<label for="highlow1">

								<!--<input type="radio" name="sortBy" id="highlow1" value="pricehigh">-->

								<span >Price: High to low</span>

							</label>

							<label>

								<!--<input type="radio" name="sortBy" value="latest">-->

								<span >Newest First</span>

							</label>

							<label>

								<!--<input type="radio" name="sortBy" value="popular">-->

								<span >Popularity</span>

							</label>

						</form>

					</div>

					<div class="Sort-By-filter">

						<div class="Filter-by">

							<span id="chtext">Filter By</span>

							<i class="fa fa-plus"></i>

							<i class="fa fa-minus hide"></i>

						</div>

						<div class="filter-boxs ">

							<form>

								<div class="filterss-flex">

									<?php

										if(isset($catId) && !empty($catId)){

											$catId = $catId;

										} else {

											$catId = 0;

										}



										$attrArr = array();

										$attributeRS =  $functions->getAttributeByCategoryId($catId);

										if($functions->num_rows($attributeRS)>0){

											while($attribute = $functions->fetch($attributeRS)){

												if(!in_array($attribute['id'], $attrArr)){

													$attrArr[] = $attribute['id'];

									?>

													<div class="flex-filtes">

														<h2><?php echo ucwords($attribute['attribute_name']); ?></h2>

														<div class="price-filp">

															<?php

																$attrFeature =  $functions->getAttributeFeaturebyAttrId($attribute['id']);

																if($functions->num_rows($attrFeature)>0){

																	while($attr = $functions->fetch($attrFeature)) {

															?>

																		<div class="form-group">

																			<input type="checkbox" id="action<?php echo $attr['id']; ?>" name="action<?php echo $attr['id']; ?>" class="common_selector attrFeatureMob" value="<?php echo $attr['id'] ?>"  > 

																			<label for="action<?php echo $attr['id']; ?>"> <?php echo ucwords($attr['feature']); ?></label>

																		</div>

															<?php

																	}

																}

															?>

														</div>

													</div>

									<?php

												}

											}

										}

									?>

									<div class="flex-filtes">

										<h2 style="font-family: 'goutam-Font'; font-weight:400px">Price</h2>

										<div class="price-filp">

											<div class="form-group">

												<input type="checkbox" class="priceFilterMob" value="0-500" id="valmo1">

												<label class="custcheck" for="valmo1">Less than Rs.500</label>

											</div>

											<div class="form-group">

												<input type="checkbox" class="priceFilterMob" value="500-1000" id="valmo2">

												<label class="custcheck" for="valmo2">

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.500 - 

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.1000

												</label>

											</div>

											<div class="form-group">

												<input type="checkbox" class="priceFilterMob" value="1001-5000" id="valmo3">

												<label class="custcheck" for="valmo3">

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.1001 - 

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.5000

												</label>

											</div>

											<div class="form-group">

												<input type="checkbox" class="priceFilterMob" value="5001-10000" id="valmo4">

												<label class="custcheck" for="valmo4">

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.5000 - 

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.10000

												</label>

											</div>

											<div class="form-group">

												<input type="checkbox" class="priceFilterMob" value="10000-1000000" id="valmo5">

												<label class="custcheck" for="valmo5">

													<!-- <i class="fa fa-rupee"></i> -->

													Rs.Above 10000

												</label>

											</div>

										</div>

									</div>

									<div class="flex-size">

										<h2  style="font-family: 'goutam-Font'; font-weight:400px">Size</h2>

										<div class="price-filp">

											<?php

												if(isset($subCatId) and !empty($subCatId)) {

													$sizeRS = $functions->query("select * from ".PREFIX."size_master where FIND_IN_SET('".$subCatId."', size_subcategory) and active=1");

												} else {

													$sizeRS = $functions->query("select * from ".PREFIX."size_master where FIND_IN_SET('".$catId."', size_category) and active=1");

												}

												if($functions->num_rows($sizeRS)==0) {

													$sizeRS = $functions->query("select * from ".PREFIX."size_master where active=1");

												}

												while($sizeDetails = $functions->fetch($sizeRS)) {

											?>

													<div class="form-group">

														<input type="checkbox" class="common_selector size_bar_mobile" value="<?php echo $sizeDetails['size'] ?>" id="mobilebar<?php echo $sizeDetails['id'] ?>"> 

														<span class="check-mark"></span>

														<label class="custcheck" for="mobilebar<?php echo $sizeDetails['id'] ?>"><?php echo $sizeDetails['size'] ?></label>

													</div>

											<?php

												}

											?>

										</div>

									</div>

									<div class="flex-filtes">

										<h2>Colours</h2>

										<div class="filtercolourformflexx">

											<span class="color-box-input" data-toggle="buttons">

												<?php

													$colorRS = $functions->query("select * from ".PREFIX."color_master where active=1");

													while($color = $functions->fetch($colorRS)) {

														$colorClause = " and productcolor='".$color['color']."'";

														// echo "SELECT * FROM ".PREFIX."product_sizes WHERE product_id IN (select id from ".PREFIX."product_master where active=1 ".$whereClasue.") ".$colorClause;

														$checksql = $functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id IN (select id from ".PREFIX."product_master where active=1 ".$whereClasue.") ".$colorClause);

														if($functions->num_rows($checksql)>0) {

															$color_image = BASE_URL."/images/color/".$color['image'];

												?>

															<label class="btn colo-btn" style="background-image: url('<?php echo $color_image ?>')">

																<input type="checkbox" name="color[]" class="colorArrMob" id="color<?php echo $color['id'] ?>" value="<?php echo $color['color'] ?>" autocomplete="off" >

																<span class="fa fa-check"></span>

															</label>

												<?php

														}

													}

												?>

											</span>

										</div>

									</div>

								</div>

								<div class="form-btnns">

									<!-- <button class="butn-apply">Apply</button>

									<button type="reset" class="butn-clear">Clear</button> -->

								</div>

							</form>

						</div>

					</div>

				</div>

				<!-- <br><br><br>		  <br><br><br> -->

			</div>

			<div class="container plr0">
				<h2 class="title_yext" style="font-family: 'goutam-Font';"><?php echo ucwords($catDetails['category_name']); ?><sup>(2)</sup></h2>
				<div class="filter_block desk-only">
					<div class="row" style="width: 100%;">
						<div class="col-lg-9 col-xs-4" style="display: flex;margin-top: 8px;">
							<h4 style="margin-right: 20px;">View</h4>
							<i style="margin-right: 11px; font-size: 20px; color: #453194; opacity: 0.1;" class="fa fa-th-large"></i>
							<i style="margin-right: 11px; font-size: 20px; color:#453194;" class="fa fa-th"></i>
						</div>						
						<div class="col-lg-3 col-xs-4">
							<span style="text-align: right" class="desktopfilterpanel">
								<div class="panel panel-default">
									<div class="panel-heading">
										<a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" style=" text-transform: capitalize; text-align: left; font-size:14px; font-family:'goutam Pro'">Sort By &nbsp;&nbsp;&nbsp; <span style="font-style: normal; font-weight: normal; font-size: 16px; line-height: 18px; color: #453194;">Bestselling</span></a>
									</div>
									<div id="collapse1" class="panel-collapse collapse">

										<div class="panel-body">

											<form class="sortinform">

												<label for="popular">

													<input type="radio" name="sortBy" value="pricelow" id="popular">

													<span style="font-size:16px;">Price: Low to High</span>

												</label>

												<label for="highlow">

													<input type="radio" name="sortBy" id="highlow" value="pricehigh">

													<span  style="font-size:16px;">Price: High to low</span>

												</label>

												<label >

													<input type="radio" name="sortBy" value="latest">

													<span style="font-size:16px;">Newest First</span>

												</label>

												<label >

													<input type="radio" name="sortBy" value="popular">

													<span style="font-size:16px;">Popularity</span>

												</label>

											</form>

										</div>

									</div>
								</div>					
							</span>
						</div>						
					</div>
				</div>
				<div class="filterandproflex">

					<div class="filteraccbox">
						<?
						 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
							 $urlbw = "https://";   
						else  
							 $urlbw = "http://";   
						// Append the host(domain name, ip) to the URL.   
						$urlbw.= $_SERVER['HTTP_HOST'];   

						// Append the requested resource location to the URL   
						$urlbw.= $_SERVER['REQUEST_URI'];    
						?>
						<div><span style="font-size: 25px; color:#453194"><strong>Filters</strong></span> <span style="float: right;"><a href="<?=$urlbw?>">Clear</a></span></div>
						<br>
						<h3 style="font-weight:400; font-size:20px; color:#453194;">Price</h3>
						<fieldset class="filter-price">
							<div class="price-field">
								<div id="slider-range"></div>
								<input type="hidden" min="0" max="3000" value="135" id="lower">
								<input type="hidden" min="0" max="3000" value="500" id="upper">
							</div>
							<div class="price-wrap">
								<div class="price-container">
									<div class="price-wrap-1">
										<label for="one"><i class="fa fa-rupee"></i></label>
										<input id="one">
									</div>
									<div class="price-wrap_line">-</div>
									<div class="price-wrap-2">
										<label for="two"><i class="fa fa-rupee"></i></label>
										<input id="two">
									</div>
								</div>
							</div>
						</fieldset>
						
						
						<h3 id="capacittext" style="font-weight:400; font-size:20px; color:#453194;">Capacity</h3><br>
						<?php

							if(isset($subCatId) and !empty($subCatId)) {

								$sizeRS = $functions->query("select * from ".PREFIX."size_master where FIND_IN_SET('".$subCatId."', size_subcategory) and active=1");

							} else {

								$sizeRS = $functions->query("select * from ".PREFIX."size_master where FIND_IN_SET('".$catId."', size_category) and active=1");

							}

							if($functions->num_rows($sizeRS)==0) {

								$sizeRS = $functions->query("select * from ".PREFIX."size_master where active=1");

							}

							while($sizeDetails = $functions->fetch($sizeRS)) {

						?>

								<div style="padding: 5px; margin-left: 17px;" class="form-group">

									<input type="checkbox" class="common_selector size_bar" value="<?php echo $sizeDetails['size'] ?>" id="sizebar<?php echo $sizeDetails['id'] ?>"> 

									<label class="custcheck" style="margin-left:7px; font-family: 'goutam-Font'; font-size:16px; color:#5C5C5C" for="sizebar<?php echo $sizeDetails['id'] ?>"><?php echo $sizeDetails['size'] ?></label>

								</div>

						<?php

							}

						?>
						<h3 style="font-weight:400px; font-size:20px; color:#453194">Color</h3><br>
						<div >

							<div class="filtercolourformflexx">

								<span class="color-box-input" data-toggle="buttons">

									<?php

										$colorRS = $functions->query("select * from ".PREFIX."color_master where active=1");

										while($color = $functions->fetch($colorRS)) {

											$colorClause = " and productcolor='".$color['color']."'";

											// echo "SELECT * FROM ".PREFIX."product_sizes WHERE product_id IN (select id from ".PREFIX."product_master where active=1 ".$whereClasue.") ".$colorClause;

											$checksql = $functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id IN (select id from ".PREFIX."product_master where active=1 ".$whereClasue.") ".$colorClause);

											if($functions->num_rows($checksql)>0) {

												$color_image = BASE_URL."/images/color/".$color['image'];

									?>

												<label class="btn colo-btn" style="background-image: url('<?php echo $color_image; ?>')">

													<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color<?php echo $color['id'] ?>" value="<?php echo $color['color'] ?>" autocomplete="off" >

													<span class="fa fa-check"></span>

												</label>

									<?php

											}

										}

									?>

								</span>

							</div>

						</div>
						

					</div>

					<div class="productlist-grid">

						<div class="AjaxFilters">

							<?php 

								include_once"include/product-listing.inc.php";

							?>

						</div>

						<div class="showLoader" style="display: none;">

							<center>

								<img src="<?php echo BASE_URL."/images/ajax-loader.gif";?>" style="width: 6%;"><br><br>

								<h3 style="color:#fa283896;">Loading Please Wait......</h3>

							</center>

						</div>

						<input type="hidden" name="permalink" id="permalink" value="<?php echo $permalink; ?>">

						<input type="hidden" name="cat_permalink" id="cat_permalink" value="<?php if(isset($_GET['cat_permalink']) && !empty($_GET['cat_permalink'])){ echo $_GET['cat_permalink']; }  ?>">

						<input type="hidden" name="sub_category_permalink" id="sub_category_permalink" value="<?php if(isset($_GET['sub_category_permalink']) && !empty($_GET['sub_category_permalink'])){ echo $_GET['sub_category_permalink']; }  ?>">

						<input type="hidden" name="sub_category_id" id="sub_category_id" value="<?php if(isset($_GET['sub_category_id']) && !empty($_GET['sub_category_id'])){ echo $_GET['sub_category_id']; }  ?>">

						<input type="hidden" name="subSub_category_id" id="subSub_category_id" value="<?php if(isset($_GET['subSub_category_id']) && !empty($_GET['subSub_category_id'])){ echo $_GET['subSub_category_id']; }  ?>">

						<input type="hidden" name="limitCount" class="limitCount" value="30">

					</div>

				</div>

			</div>

		</section>

	</main>

	<!--Main End Code Here-->

	<!--footer start menu head-->

	<?php  include("include/footer.php");?>

	<!--footer end menu head-->

	<?php  include("include/footer-link.php");?>

	<script>

		/*  $('.cartListingBtn').on('click',function(){

			setTimeout(function(){

				window.location="<?php echo BASE_URL; ?>/cart.php";

			}, 200);

		});  */



		$(".panelclickbtn").click(function(){

			$(this).closest(".panel-default").find(".panel-collapse").slideToggle();

		});

		$(document).ready(function(){

			$(".filterscroll").mCustomScrollbar();

		});



		$(document).ready(function(){

			$(document).on("change", "#sortBy", function() {

				filterFunction();

			});

			$(document).on("change", ".attrFeature", function() {

				filterFunction();

			});

			$(document).on("change", ".priceFilter", function() {

				filterFunction();

			});

			$(document).on("change", ".size_bar", function() {

				filterFunction();

			});

			$(document).on("change", ".colorFilter", function() {

				filterFunction();

			});

			$(document).on("change", "input[name='sortBy']", function() {

				filterFunction();

			});



			$(document).on("change", "#sortByMob", function() {

				filterFunctionMob();

			});

			$(document).on("change", ".attrFeatureMob", function() {

				filterFunctionMob();

			});

			$(document).on("change", ".priceFilterMob", function() {

				filterFunctionMob();

			});

			$(document).on("change", ".size_bar_mobile", function() {

				filterFunctionMob();

			});

			$(document).on("change", ".colorArrMob", function() {

				filterFunctionMob();

			});

		});



		function filterFunction(){

			$(".showLoader").show();

			$('.AjaxFilters').hide();

			// var sortBy = $('#sortBy').find(":selected").val();

			var sortBy = $('input[name="sortBy"]:checked').val();



			var permalink = $('#permalink').val();

			var cat_permalink = $('#cat_permalink').val();

			var sub_category_permalink = $('#sub_category_permalink').val();

			var subSub_category_permalink = $('#subSub_category_permalink').val();

			var limit = $('.limitCount').val();



			var attrId = [];

			$(".attrFeature").each(function(){

				if($(this).prop("checked") == true) {

					attrId.push($(this).val());

				}

			});



         	var priceArr = [];

         	$(".priceFilter").each(function(){

         		if($(this).prop("checked") == true) {

         			priceArr.push($(this).val());

         			//alert(priceArr.push($(this).val()));

         		}

         	});



         	var colorArr = [];

         	$(".colorFilter").each(function(){

         		if($(this).prop("checked") == true) {

         			colorArr.push($(this).val());

         			//alert(priceArr.push($(this).val()));

         		}

         	});



         	var sizeArr = [];

         	$(".size_bar").each(function(){

         		if($(this).prop("checked") == true) {

         			sizeArr.push($(this).val());

         			//alert(sizeArr.push($(this).val()));

         		}

         	});

         	//console.log(attrId);



         	$.ajax({

         		url:"<?php echo BASE_URL; ?>/product-filter.inc.php",

         		data:{

         			sortBy:sortBy,

         			permalink:permalink,

         			cat_permalink:cat_permalink,

         			sub_category_permalink:sub_category_permalink,

         			subSub_category_permalink:subSub_category_permalink,

         			attrId:attrId,

         			priceArr:priceArr,

         			sizeArr:sizeArr,

         			colorArr:colorArr,

         		},



         		type:"POST",

         		success: function(response){

         			// console.log("response",response);

         			$(".showLoader").hide();

         			$('.AjaxFilters').show();



         			$('.AjaxFilters').html(response);

         			MatchHeight1();



         			//$('.cartListingBtn').on('click', onRemoveFromCart);

         			$('.cartListingBtn').on('click', cartListingBtn);

         			// == CART SIDE POPUP ==



         			var sort = $("input[name='sortBy']:checked").val();

					console.log(sort);

         			$('.Jprice').sort(function (a, b) {

         				if(sort=='pricelow') {

         					return $(a).data('price') - $(b).data('price');

         				} else if(sort=='pricehigh') {

         					return $(b).data('price') - $(a).data('price');

         				} else if(sort=='latest') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='newarri') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='name') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='popular') {

         					return $(b).data('rating') - $(a).data('rating');

         				}



         			}).map(function () {

         				return $(this);

         			}).each(function (_, container) {

         				$(container).parent().append(container);

         			});

         		},

         		error: function(){

         			console.log("Unable to load data, please try again");

         		},

         		complete: function(response){

         			MatchHeight1();

         		}

         	});

		}



		function filterFunctionMob(){

			$(".showLoader").show();

			$('.AjaxFilters').hide();

			// var sortBy = $('#sortBy').find(":selected").val();

			var sortBy = $('#sortByMob').val();



			var permalink = $('#permalink').val();

			var cat_permalink = $('#cat_permalink').val();

			var sub_category_permalink = $('#sub_category_permalink').val();

			var subSub_category_permalink = $('#subSub_category_permalink').val();

			var limit = $('.limitCount').val();



			var attrId = [];

			$(".attrFeatureMob").each(function(){

				if($(this).prop("checked") == true) {

					attrId.push($(this).val());

				}

			});



         	var priceArr = [];

         	$(".priceFilterMob").each(function(){

         		if($(this).prop("checked") == true) {

         			priceArr.push($(this).val());

         			//alert(priceArr.push($(this).val()));

         		}

         	});



         	var colorArr = [];

         	$(".colorArrMob").each(function(){

         		if($(this).prop("checked") == true) {

         			colorArr.push($(this).val());

         			//alert(priceArr.push($(this).val()));

         		}

         	});



         	var sizeArr = [];

         	$(".size_bar_mobile").each(function(){

         		if($(this).prop("checked") == true) {

         			sizeArr.push($(this).val());

         			//alert(sizeArr.push($(this).val()));

         		}

         	});

         	//console.log(attrId);



         	$.ajax({

         		url:"<?php echo BASE_URL; ?>/product-filter.inc.php",

         		data:{

         			sortBy:sortBy,

         			permalink:permalink,

         			cat_permalink:cat_permalink,

         			sub_category_permalink:sub_category_permalink,

         			subSub_category_permalink:subSub_category_permalink,

         			attrId:attrId,

         			priceArr:priceArr,

         			sizeArr:sizeArr,

         			colorArr:colorArr,

         		},



         		type:"POST",

         		success: function(response){

         			// console.log("response",response);

         			$(".showLoader").hide();

         			$('.AjaxFilters').show();



         			$('.AjaxFilters').html(response);

         			MatchHeight1();



         			//$('.cartListingBtn').on('click', onRemoveFromCart);

         			$('.cartListingBtn').on('click', cartListingBtn);

         			// == CART SIDE POPUP ==



         			var sort = $("#sortByMob").val();

					console.log(sort);

         			$('.Jprice').sort(function (a, b) {

         				if(sort=='pricelow') {

         					return $(a).data('price') - $(b).data('price');

         				} else if(sort=='pricehigh') {

         					return $(b).data('price') - $(a).data('price');

         				} else if(sort=='latest') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='newarri') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='name') {

         					return $(b).data('id') - $(a).data('id');

         				} else if(sort=='popular') {

         					return $(b).data('rating') - $(a).data('rating');

         				}



         			}).map(function () {

         				return $(this);

         			}).each(function (_, container) {

         				$(container).parent().append(container);

         			});

         		},

         		error: function(){

         			console.log("Unable to load data, please try again");

         		},

         		complete: function(response){

         			MatchHeight1();

         		}

         	});

		}



		$('.selectdropdown').niceSelect();

		$('.sortselect').niceSelect();



		$(".click-open").click(function(){

			$(this).parents("ul").toggleClass("opentext");               

			$(this).next(".sidebar-filter-sub").slideToggle();               

		});
		var lowerSlider = document.querySelector('#lower');
var  upperSlider = document.querySelector('#upper');

document.querySelector('#two').value=upperSlider.value;
document.querySelector('#one').value=lowerSlider.value;

var  lowerVal = parseInt(lowerSlider.value);
var upperVal = parseInt(upperSlider.value);

upperSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);

    if (upperVal < lowerVal + 4) {
        lowerSlider.value = upperVal - 4;
        if (lowerVal == lowerSlider.min) {
        upperSlider.value = 4;
        }
    }
    document.querySelector('#two').value=this.value
};

lowerSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);
    if (lowerVal > upperVal - 4) {
        upperSlider.value = lowerVal + 4;
        if (upperVal == upperSlider.max) {
            lowerSlider.value = parseInt(upperSlider.max) - 4;
        }
    }
    document.querySelector('#one').value=this.value
}; 
	</script>

</body>

</html>