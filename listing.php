<?php 

	include_once 'include/functions.php';

	$functions = new Functions(); 



	$permalink = '';

	$displayName ='Products';

   $breadcrumbs = '';

   

	if(isset($_GET['cat_permalink']) && !empty($_GET['cat_permalink'])){

		

		

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

	<main class="main-inner-div listingbgchange">


		<div class="banner-inner container plr0">

			<?php

				if($sne=="subcat"){

			?>

				<img src="<?php echo BASE_URL; ?>/images/slider-banner/<?php echo $subCategoryDetails['banner']; ?>" class="various-img-listing">  

				<h2><?php echo ucwords($subCategoryDetails['category_name']); ?></h2> 

			<?php

				} else if($sne=="cat") {

			?>

					<img src="<?php echo BASE_URL; ?>/images/slider-banner/<?php echo $catDetails['banner']; ?>" class="various-img-listing">  

					<h2><?php echo ucwords($catDetails['category_name']); ?></h2> 

			<?php } ?>

        </div>

		<div class="container breadcum-header">

			<ul>

				<?php echo $breadcrumbs; ?>

			</ul>

		</div>                 

		<section class="listing-pages">

			<div class="container plr0">

				<div class="filter-sorting">

					<div class="Sort-By">

						<select name="sortBy" id="sortBy" class="Sort-By-filter sortselect niceSelect" style="z-index:1111">

							<option selected >Sort By</option>

							<option value="popular">Popular</option>

							<option value="newarri">Latest</option>

							<option value="name">Name</option>

						</select>

					</div>

					<div class="Sort-By-filter">

						<div class="Filter-by">

							<div id="chtext">Filter By</div>

							<i class="fa fa-plus"></i>

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

																			<input type="checkbox" id="action<?php echo $attr['id']; ?>" class="common_selector attrFeature" value="<?php echo $attr['id'] ?>"  > 

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

								<h2>Price</h2>

								<div class="price-filp">

                                 <!--<div class="form-group">

                                    <input type="checkbox" id="400-500" name="price" value="400">

                                    <label for="400-500"> <i class="fa fa-rupee"></i>400 - <i class="fa fa-rupee"></i>500</label>

                                 </div>

                                 <div class="form-group">

                                    <input type="checkbox" id="500-1000" name="price" value="500">

                                    <label for="500-1000"> <i class="fa fa-rupee"></i>500 - <i class="fa fa-rupee"></i>1000</label>

                                 </div>

                                 <div class="form-group">

                                    <input type="checkbox" id="1000-1500" name="price" value="1000">

                                    <label for="1000-1500"> <i class="fa fa-rupee"></i>1000 - <i class="fa fa-rupee"></i>1500</label>

                                 </div>

                                 <div class="form-group">

                                    <input type="checkbox" id="1500-2000" name="price" value="1500">

                                    <label for="1500-2000"> <i class="fa fa-rupee"></i>1500 - <i class="fa fa-rupee"></i>2000</label>

                                 </div>

                                 <div class="form-group">

                                    <input type="checkbox" id="2000-more" name="price" value="2000">

                                    <label for="2000-more"> <i class="fa fa-rupee"></i>2000 - <i class="fa fa-rupee"></i>more</label>

                                 </div> -->

								

									<div class="form-group">

									<input type="checkbox" class="priceFilter" value="0-500">

									<span class="check-mark"></span>

									<label class="custcheck">Less than Rs.500</label>

									</div>

									<div class="form-group">

									<input type="checkbox" class="priceFilter" value="500-1000">

									<span class="check-mark"></span>

									<label class="custcheck">

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.500 - 

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.1000

									</label>

									</div>

									<div class="form-group">

									<input type="checkbox" class="priceFilter" value="1001-5000" >

									<span class="check-mark"></span>

									<label class="custcheck">

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.1001 - 

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.5000

									</label>

									</div>

									<div class="form-group">

									<input type="checkbox" class="priceFilter" value="5001-10000" >

									<span class="check-mark"></span>

									<label class="custcheck">

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.5000 - 

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.10000

									</label>

									</div>

									<div class="form-group">

									<input type="checkbox" class="priceFilter" value="10000-1000000" >

									<span class="check-mark"></span>

									<label class="custcheck">

									<!-- <i class="fa fa-rupee"></i> -->

									Rs.Above 10000

									</label>

									</div>

								</div>

                           </div>

                           <div class="flex-size">

								<h2>

								Size

								</h2>

								<div class="price-filp">

									<?php

									$connects = new PDO("mysql:host=localhost;dbname=selvel", "root", "hJ8yW3cP0wV4aW8c");



									$query = "SELECT DISTINCT(size) FROM slv_product_sizes";

									$statement = $connects->prepare($query);

									$statement->execute();

									$result = $statement->fetchAll();

									foreach($result as $row)

									{

									?>

									<div class="form-group">

									<input type="checkbox" class="common_selector size_bar" value="<?php echo $row['size']; ?>"  > 

									<label for="<?php echo $row['size']; ?>"> <?php echo $row['size']; ?></label>

									</div>

									<?php

									}



									?>

									<!--

								  

									 <div class="form-group">

										<input type="checkbox" class="common_selector brand" id="500ml" name="size" value="<?php echo $row['product_brand']; ?>">

										<label for="500ml"> <i class="fa fa-rupee"></i><?php echo $row['product_brand']; ?></label>

									 </div>

									 <div class="form-group">

										<input type="checkbox" id="600ml" name="size" value="600">

										<label for="600ml"> <i class="fa fa-rupee"></i>600ml</label>

									 </div>

									  <div class="form-group">

										<input type="checkbox" id="700ml" name="size" value="700">

										<label for="700ml"> <i class="fa fa-rupee"></i>700ml</label>

									 </div>

									  <div class="form-group">

										<input type="checkbox" id="800ml" name="size" value="800">

										<label for="800ml"> <i class="fa fa-rupee"></i>800ml</label>

									 </div>

									  <div class="form-group">

										<input type="checkbox" id="900ml" name="size" value="1000">

										<label for="900ml"> <i class="fa fa-rupee"></i>1000ml</label>

									 </div>  --> 

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

      <div class="productlist-grid row">

     

<div class="AjaxFilters">

								<?php 

									include_once"include/product-listing.inc.php";

								?>

							</div>

							<div class="showLoader" style="display: none;">

								<center><img src="<?php echo BASE_URL."/images/ajax-loader.gif";?>" style="width: 6%;"><br><br>

								<h3 style="color:#fa283896;">Loading Please Wait......</h3></center>

							</div>

							<input type="hidden" name="permalink" id="permalink" value="<?php echo $permalink; ?>">

							<input type="hidden" name="cat_permalink" id="cat_permalink" value="<?php if(isset($_GET['cat_permalink']) && !empty($_GET['cat_permalink'])){ echo $_GET['cat_permalink']; }  ?>">

							<input type="hidden" name="sub_category_permalink" id="sub_category_permalink" value="<?php if(isset($_GET['sub_category_permalink']) && !empty($_GET['sub_category_permalink'])){ echo $_GET['sub_category_permalink']; }  ?>">

							<input type="hidden" name="sub_category_id" id="sub_category_id" value="<?php if(isset($_GET['sub_category_id']) && !empty($_GET['sub_category_id'])){ echo $_GET['sub_category_id']; }  ?>">

							<input type="hidden" name="subSub_category_id" id="subSub_category_id" value="<?php if(isset($_GET['subSub_category_id']) && !empty($_GET['subSub_category_id'])){ echo $_GET['subSub_category_id']; }  ?>">



							<input type="hidden" name="limitCount" class="limitCount" value="30">





        



                 



         



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



		});



		function filterFunction(){

			$(".showLoader").show();

			$('.AjaxFilters').hide();

			var sortBy = $('#sortBy').find(":selected").val();



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

					sizeArr:sizeArr

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



					var sort = $("#sortBy").val();

					$('.Jprice').sort(function (a, b) {

						if(sort=='lower') {

							return $(a).data('price') - $(b).data('price');

						} else if(sort=='higher') {

							return $(b).data('price') - $(a).data('price');

						} else if(sort=='popular') {

							return $(b).data('id') - $(a).data('id');

						}else if(sort=='newarri') {

							return $(b).data('id') - $(a).data('id');

						}else if(sort=='name') {

							return $(b).data('id') - $(a).data('id');

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

	</script>

   </body>



</html>