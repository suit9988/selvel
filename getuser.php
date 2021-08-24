<?php
	include_once 'include/functions.php';
	$functions = new Functions(); 
	$q = $_GET['q'];
	$catIds = $_GET['catid'];

	if($q=="date")
	{
		$getProductIdDetails = $functions->query("SELECT * FROM slv_product_master order by id DESC"); 
		while($rowProductIdList = $functions->fetch($getProductIdDetails))
		{
			$p_id=$rowProductIdList['id'];
			$productDetails = $functions-> getUniqueProductById($rowProductIdList['id']);               
			$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['id']."' ORDER BY id ASC LIMIT 1"));
			
			$getProductIdDetails1 = "SELECT * FROM slv_product_subcategory_mapping WHERE category_id='".$catIds."'";
			$getProductIdDetails2 = $functions->query($getProductIdDetails1);			
			while($rowProductIdList = $functions->fetch($getProductIdDetails2))
			{
				$p_id1=$rowProductIdList['product_id'];
				if($p_id1==$p_id)
				{?>

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
			}}
		}
	}
	else if($q=="newarri")
	{
		$getProductIdDetails = $functions->query("SELECT * FROM slv_product_master order by id DESC"); 
		while($rowProductIdList = $functions->fetch($getProductIdDetails))
		{
			$p_id=$rowProductIdList['id'];
			$productDetails = $functions-> getUniqueProductById($rowProductIdList['id']);               
			$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['id']."' ORDER BY id ASC LIMIT 1"));
			
			$getProductIdDetails1 = "SELECT * FROM slv_product_subcategory_mapping WHERE category_id='".$catIds."'";
			$getProductIdDetails2 = $functions->query($getProductIdDetails1);			
			while($rowProductIdList = $functions->fetch($getProductIdDetails2))
			{
				$p_id1=$rowProductIdList['product_id'];
				if($p_id1==$p_id)
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
			}	}	
		}	
	}
	else if($q=="name")
	{
		//echo "sneh";
		$getProductIdDetails = $functions->query("SELECT * FROM slv_product_master order by product_name ASC"); 
		while($rowProductIdList = $functions->fetch($getProductIdDetails))
		{
			$p_id=$rowProductIdList['id'];
			$productDetails = $functions-> getUniqueProductById($rowProductIdList['id']);               
			$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['id']."' ORDER BY id ASC LIMIT 1"));
						
			$getProductIdDetails1 = "SELECT * FROM slv_product_subcategory_mapping WHERE category_id='".$catIds."'";
			$getProductIdDetails2 = $functions->query($getProductIdDetails1);			
			while($rowProductIdList = $functions->fetch($getProductIdDetails2))
			{
				$p_id1=$rowProductIdList['product_id'];
				if($p_id1==$p_id)
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
	}

?>


