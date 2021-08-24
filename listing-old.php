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

   </head>

   <body class="inner-page" id="listing-page">
      <!--Top start menu head-->       
      <?php include("include/header.php");?>
      <!--Main Start Code Here-->
      <main class="main-inner-div">
         <img src="<?php echo BASE_URL; ?>/images/inner-bg.png" class="img-full fixedimg listingsa">   
        <div class="banner-inner container plr0">
		<?php
		if($sne=="subcat"){
		?>
         <img src="<?php echo BASE_URL; ?>/images/slider-banner/<?php echo $subCategoryDetails['banner']; ?>" class="various-img-listing">  
		  <h2><?php echo ucwords($subCategoryDetails['category_name']); ?></h2> 
		<?php 
		} 
		else if($sne=="cat")
		{ 
		echo "hii"; ?>
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
                    <select name="sortBy" id="sortBy" class="Sort-By-filter" onchange="showUser(this.value)">
                       <option selected >Sort By</option>
                       <option value="date">Date</option>
                       <option value="newarri">Latest</option>
                       <option value="name">Name</option>  
                    </select>
                 </div>
                 <div class="Sort-By-filter">
                   <span class="Filter-by">
                      Filter By
                      <i class="fa fa-plus"></i>
                   </span>
                   <div class="filter-boxs ">
                      <form>
                        <div class="filterss-flex">
                           <div class="flex-filtes">
                             <h2>
                                Price
                             </h2>
                              <div class="price-filp">
                                 <div class="form-group">
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
                                 </div>
                              </div>
                           </div>
                           <div class="flex-size">
                             <h2>
                                Size
                             </h2>
                              <div class="price-filp">
                                 <div class="form-group">
                                    <input type="checkbox" id="500ml" name="size" value="500">
                                    <label for="500ml"> <i class="fa fa-rupee"></i>500ml</label>
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
                                 </div>   
                              </div>
                           </div>
                        </div>
                        <div class="form-btnns">
                           <button class="butn-apply">Apply</button>
                           <button type="reset" class="butn-clear">Clear</button>
                        </div>
                      </form>
                   </div>
                 </div>
              </div>
           </div>
           <div class="listing-modules wow fadeInUp">
              <div class="sellers-slider" id="txtHint">
<script>
function showUser(str) {
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getuser.php?q="+str+"&catid="+<?php echo $catId; ?>,true);
    xmlhttp.send();
  }
}
</script>
         <?php 
			if($catId!='' && $subCatId!='')
			{				
				/*if($_GET['size']!='')
				{
					$sz=$_GET['size']."ML";
				
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
				//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
				while($rowProductIdList = $functions->fetch($getProductIdDetails))
				{
					$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
					$getProductsizeDetailsq = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' and size='$sz' ORDER BY id ASC LIMIT 1";
					$getProductsizeDetails1 = $functions->query($getProductsizeDetailsq);
					$getProductsizeDetails = $functions->fetch($getProductsizeDetails1);

					if($functions->num_rows($getProductsizeDetails1)>0)	
					{ ?>
            
						<div class="produc-main">
							<div class="img-prods">
								<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
								<a href="<?php echo $product_link; ?>">
									<?php 
										$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
										$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
									?>
									<img src="<?php echo BASE_URL.'/images/products/'.$file_name.'.'.$ext; ?>"  width="250">
								</a>
							</div>
							<div class="prods-desc">
								<h2>
								<?php echo $productDetails['product_name']; 
								if($getProductsizeDetails['size']){
								echo ' ('.$getProductsizeDetails['size'].')';
								}
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
									<span>
										<a href="<?php echo $product_link; ?>">
											<i class="fa fa-eye"></i>
										</a> 
									</span>
									<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">
										Add to Cart
										<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
										<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
										<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">
									</span>
									<span>
										<?php
											if($loggedInUserDetailsArr = $functions->sessionExists()){
											$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
											if($functions->num_rows($wishlistRS)>0){
											$hearticon = 'fa-heart';
											} else {
											$hearticon = 'fa-heart-o';
											}
										?>
										<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
										<i class="fa <?php echo $hearticon; ?>"></i> </a>
										<?php } else { ?>
											<a  class="wishlistbtnnew" href="">
											<i class="fa fa-heart-o"></i> </a>
										<?php } ?>
									</span>
								</div>
							</div>
						</div>
				<?php 
					}
				}
				}
				else if($_GET['price']!='')
				{
					echo "price";
					exit();
					//echo "hii";
					$pr=$_GET['price'];
					if($pr=="400"){
					$pr1=$_GET['price']+100;}else if($pr=="2000"){$pr1=2222222222222;}else {
					$pr1=$_GET['price']+500;}
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetailsq = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' and customer_discount_price between '$pr' AND '$pr1'  ORDER BY id ASC LIMIT 1";
						$getProductsizeDetails1 = $functions->query($getProductsizeDetailsq);
						$getProductsizeDetails = $functions->fetch($getProductsizeDetails1);

						if($functions->num_rows($getProductsizeDetails1)>0)	
						{ 
						?>
							<div class="produc-main">
							<div class="img-prods">
								<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
								<a href="<?php echo $product_link; ?>">
									<?php 
										$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
										$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
									?>
									<img src="<?php echo BASE_URL.'/images/products/'.$file_name.'.'.$ext; ?>"  width="250">
								</a>
							</div>
							<div class="prods-desc">
								<h2>
								<?php echo $productDetails['product_name']; 
								if($getProductsizeDetails['size']){
								echo ' ('.$getProductsizeDetails['size'].')';
								}
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
									<span>
										<a href="<?php echo $product_link; ?>">
											<i class="fa fa-eye"></i>
										</a> 
									</span>
									<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">
										Add to Cart
										<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
										<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
										<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">
									</span>
									<span>
										<?php
											if($loggedInUserDetailsArr = $functions->sessionExists()){
											$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
											if($functions->num_rows($wishlistRS)>0){
											$hearticon = 'fa-heart';
											} else {
											$hearticon = 'fa-heart-o';
											}
										?>
										<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
										<i class="fa <?php echo $hearticon; ?>"></i> </a>
										<?php } else { ?>
											<a  class="wishlistbtnnew" href="">
											<i class="fa fa-heart-o"></i> </a>
										<?php } ?>
									</span>
								</div>
							</div>
						</div>
						<?php
						}
					}
				}
				else
				{
					echo "no";
					exit();
					*/
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetailsq = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' ORDER BY id ASC LIMIT 1";
						$getProductsizeDetails1 = $functions->query($getProductsizeDetailsq);
						$getProductsizeDetails = $functions->fetch($getProductsizeDetails1);

						if($productDetails['active'])
						{ 
						?>
							<div class="produc-main">
							<div class="img-prods">
								<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
								<a href="<?php echo $product_link; ?>">
									<?php 
										$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
										$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
									?>
									<img src="<?php echo BASE_URL.'/images/products/'.$productDetails['main_image']; ?>"  width="250">
								</a>
							</div>
							<div class="prods-desc">
								<h2>
								<?php echo $productDetails['product_name']; 
								if($getProductsizeDetails['size']){
								echo ' ('.$getProductsizeDetails['size'].')';
								}
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
									<span>
										<a href="<?php echo $product_link; ?>">
											<i class="fa fa-eye"></i>
										</a> 
									</span>
									<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">
										Add to Cart
										<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
										<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
										<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">
									</span>
									<span>
										<?php
											if($loggedInUserDetailsArr = $functions->sessionExists()){
											$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
											if($functions->num_rows($wishlistRS)>0){
											$hearticon = 'fa-heart';
											} else {
											$hearticon = 'fa-heart-o';
											}
										?>
										<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
										<i class="fa <?php echo $hearticon; ?>"></i> </a>
										<?php } else { ?>
											<a  class="wishlistbtnnew" href="">
											<i class="fa fa-heart-o"></i> </a>
										<?php } ?>
									</span>
								</div>
							</div>
						</div>
						<?php
						}
					}
				//}
			}
			else if($catId!='')
			{					
				if($_GET['size']!='')
				{
					$sz=$_GET['size']."ML";
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetailsq = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' and size='$sz' ORDER BY id ASC LIMIT 1";
						$getProductsizeDetails1 = $functions->query($getProductsizeDetailsq);
						$getProductsizeDetails = $functions->fetch($getProductsizeDetails1);
						if($functions->num_rows($getProductsizeDetails1)>0)					
						{ ?>

							<div class="produc-main">

							<div class="img-prods">
							<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
							<a href="<?php echo $product_link; ?>">
							<?php 

							$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
							$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
							?>
							<img src="<?php echo BASE_URL.'/images/products/'.$productDetails['main_image']; ?>"  width="250">
							</a>
							</div>

							<div class="prods-desc">

							<h2>
							<?php echo $productDetails['product_name']; 
							if($getProductsizeDetails['size']){
							echo ' ('.$getProductsizeDetails['size'].')';
							}
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

							<span>

							<a href="<?php echo $product_link; ?>">

							<i class="fa fa-eye"></i>

							</a> 

							</span>

							<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">

							Add to Cart
							<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
							<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
							<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">

							</span>

							<span>
							<?php
							if($loggedInUserDetailsArr = $functions->sessionExists()){
							$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
							if($functions->num_rows($wishlistRS)>0){
							$hearticon = 'fa-heart';
							} else {
							$hearticon = 'fa-heart-o';
							}
							?>
							<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
							<i class="fa <?php echo $hearticon; ?>"></i> </a>
							<?php } else { ?>
							<a  class="wishlistbtnnew" href="">
							<i class="fa fa-heart-o"></i> </a>
							<?php } ?>





							</span>

							</div>

							</div>

							</div>

		  <?php 		}
					}
					
				}
				else if($_GET['price']!='')
				{
					//echo "hii";
					$pr=$_GET['price'];
					if($pr=="400"){
					$pr1=$_GET['price']+100;}else if($pr=="2000"){$pr1=2222222222222;}else {
					$pr1=$_GET['price']+500;}
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetailsq = "SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' and customer_discount_price between '$pr' AND '$pr1' ORDER BY id ASC LIMIT 1";
						$getProductsizeDetails1 = $functions->query($getProductsizeDetailsq);
						$getProductsizeDetails = $functions->fetch($getProductsizeDetails1);
						if($functions->num_rows($getProductsizeDetails1)>0)					
						{ ?>

							<div class="produc-main">

							<div class="img-prods">
							<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
							<a href="<?php echo $product_link; ?>">
							<?php 

							$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
							$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
							?>
							<img src="<?php echo BASE_URL.'/images/products/'.$productDetails['main_image']; ?>"  width="250">
							</a>
							</div>

							<div class="prods-desc">

							<h2>
							<?php echo $productDetails['product_name']; 
							if($getProductsizeDetails['size']){
							echo ' ('.$getProductsizeDetails['size'].')';
							}
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

							<span>

							<a href="<?php echo $product_link; ?>">

							<i class="fa fa-eye"></i>

							</a> 

							</span>

							<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">

							Add to Cart
							<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
							<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
							<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">

							</span>

							<span>
							<?php
							if($loggedInUserDetailsArr = $functions->sessionExists()){
							$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
							if($functions->num_rows($wishlistRS)>0){
							$hearticon = 'fa-heart';
							} else {
							$hearticon = 'fa-heart-o';
							}
							?>
							<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
							<i class="fa <?php echo $hearticon; ?>"></i> </a>
							<?php } else { ?>
							<a  class="wishlistbtnnew" href="">
							<i class="fa fa-heart-o"></i> </a>
							<?php } ?>





							</span>

							</div>

							</div>

							</div>

		  <?php 		}
					}
						
				}
				else
				{
						//echo "hii";
					$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' ORDER BY id ASC LIMIT 1"));
						if($productDetails['active'])
						{ ?>

								<div class="produc-main">

								<div class="img-prods">
								<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id']); ?>
								<a href="<?php echo $product_link; ?>">
								<?php 

								$file_name = str_replace('', '-', strtolower( pathinfo($productDetails['main_image'], PATHINFO_FILENAME)));
								$ext = pathinfo($productDetails['main_image'], PATHINFO_EXTENSION);
								?>
								<img src="<?php echo BASE_URL.'/images/products/'.$productDetails['main_image']; ?>"  width="250">
								</a>
								</div>

								<div class="prods-desc">

								<h2>
								<?php echo $productDetails['product_name']; 
								if($getProductsizeDetails['size']){
								echo ' ('.$getProductsizeDetails['size'].')';
								}
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

								<span>

								<a href="<?php echo $product_link; ?>">

								<i class="fa fa-eye"></i>

								</a> 

								</span>

								<span class="price-cart-add-top cartListingBtn" data-id="<?php echo $productDetails['id']; ?>">

								Add to Cart
								<input type="hidden"  name="available_qty" value="<?php echo $getProductsizeDetails['available_qty']; ?>">
								<input type="hidden" name="size" value="<?php echo $getProductsizeDetails['size']; ?>">
								<input type="hidden" name="color" value="<?php echo $productColorArray[0]; ?>">

								</span>

								<span>
								<?php
								if($loggedInUserDetailsArr = $functions->sessionExists()){
								$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
								if($functions->num_rows($wishlistRS)>0){
								$hearticon = 'fa-heart';
								} else {
								$hearticon = 'fa-heart-o';
								}
								?>
								<a href="<?php echo BASE_URL.'/my-wishlist.php'; ?>"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">  
								<i class="fa <?php echo $hearticon; ?>"></i> </a>
								<?php } else { ?>
								<a  class="wishlistbtnnew" href="">
								<i class="fa fa-heart-o"></i> </a>
								<?php } ?>





								</span>

								</div>

								</div>

								</div>

              <?php 	}
					}					
				}					
			}
				
			else if($subCatId!='' && $catId='')
			{}
		
         ?>
		
           


                 

              </div>

           </div>

        </section>

      </main>

      <!--Main End Code Here-->

      <!--footer start menu head-->

      <?php include("include/footer.php");?> 

      <!--footer end menu head-->

      <?php include("include/footer-link.php");?>

      <script type="text/javascript">

         $(".niceselect").niceSelect();



         //  $(".butn-clear").click(function(){

         //   $(".filter-boxs").toggle();                     

         // });

         

         // $(".Sort-By-filter").click(function(){

         //   $(".filter-boxs").toggle();           

         // });

         $('.cartListingBtn').on('click',function(){
         setTimeout(function(){         
             window.location="<?php echo BASE_URL; ?>/cart.php";
         }, 200);

         });
               

      </script>
<script src="<?php echo BASE_URL; ?>/js/ajax-update-cart.js" type="text/javascript"></script>
<script>
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
				}
			});
			//console.log(attrId);
//alert("yyy");
			$.ajax({
				
				url:"<?php echo BASE_URL; ?>/product-filter.inc.php",
				data:{
					sortBy:sortBy,
					permalink:permalink,
					cat_permalink:cat_permalink,
					sub_category_permalink:sub_category_permalink,
					subSub_category_permalink:subSub_category_permalink,
					attrId:attrId,
					priceArr:priceArr
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