<?php 
	include_once("include/functions.php");
	$functions = New Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
		exit;
	}

	if(isset($_GET['delid']) && !empty($_GET['delid'])){
		$delid = $functions->escape_string($functions->strip_all($_GET['delid']));
		$sql = "DELETE FROM ".PREFIX."customers_wishlist WHERE `id`='".$delid."'";
		//echo $sql; exit; 
		$functions->query($sql);
		header("location: my-wishlist.php?delesuccess");
		exit;
	}
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - Wishlist</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page dashboard-pages" id="my-wishlist">

      <!--Top start menu head-->       

      <?php include("include/header.php");?>

      <!--Main Start Code Here-->

      <main class="main-inner-div">   

         <div class="container breadcum-header">

            <ul>

               <li>

                  <a href="#">Home</a>

                  <i class="fa fa-angle-right"></i>

               </li>

               <li>

                  <a href="#" class="current-page">My Wishlist</a>                  
               </li>

            </ul>

         </div>

         <section class="orderreceived">

            <div class="inner-content bt">

               <div class="container">

                  <div class="ac-detail-nav-box">

                     <ul class="ac-detail-nav" id="mywishnav">

					  <li class=""><a href="my-account.php"> My Account</a></li>

					  <li><a href="my-order.php">My Orders</a></li>

					  <li class="active"><a href="my-wishlist.php"> Wishlist</a></li>

                        <div class="clearfix"></div>

                     </ul>

                  </div>

                  <div class="row">
                  <?php 
						if(isset($_GET['delesuccess'])){ ?>
							<div class="alert alert-success alert-dismissible" role="alert" style="padding-bottom:18px; font-size:18px">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">X</span><span class="sr-only">Close</span></button>
								<i class="icon-checkmark3"></i> Product successfully removed from wishlist.
							</div><br/>
					<?php 
						}

						$wishlist = $functions->getWishlistByUserId($loggedInUserDetailsArr['id']);	 
					?>
                     <div class="col-md-12">

                        <div class="field-box ">

                           <div class="table-responsive">
                           <?php 
						  // $functions->num_rows($wishlist)=0;
								         if($functions->num_rows($wishlist)>0){
							      ?>
                              
                                 <?php } else { ?> <h2 style="font-size:20px;text-align:center;font-weight:bold">  No Products Wishlisted Yet </h2> <?php } ?>

                           </div>

                        </div>

                     </div>
					  <?
					  if($functions->num_rows($wishlist)>0){
					  while($whishlistDetails = $functions->fetch($wishlist)) {
					$productDetails = $functions->getUniqueProductById($whishlistDetails['product_id']);
					$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$productDetails['id']."' AND size='".$whishlistDetails['size']."' "));
					$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');

					if(!empty($getProductsizeDetails['customer_discount_price'])) {
						$price = $getProductsizeDetails['customer_discount_price'];
					} else {
						$price = $getProductsizeDetails['customer_price'];
					}
					$productPerma = $functions->getProductDetailPageURL($productDetails['id']);
					  ?>
					  <div class="col-md-4 col-sm-4">
					  	<div class="produc-main match">
							<div class="img-prods">                                             
								<a href="">                        
									<img src="<?php echo $productBanner; ?>"  width="250">

									<div class="prohover">
									</div>                
								</a>
							</div>	
							<div class="prods-desc">                       
								<h2>                        
								<?php echo $productDetails["product_name"].' '.$whishlistDetails['color'].' '.$whishlistDetails['size']; ?>                         
								                       
								</h2> 
								<div class="prods-price" style="margin-bottom: 20px;">                        
									<?php if($getProductsizeDetails['customer_discount_price']){  ?>                          

									<span class="text-price-og">                          
									<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_discount_price'] ?>                          
									</span>  
									<span class="text-drop">                          
									<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>                          
									</span> 
									<span style="font-size: 12px;color: red;"><font>(10% Discount)</font></span>
									<?php }else{ ?>                           
									<span class="text-price-og">                             
									<i class="fa fa-rupee"></i> <?php echo $getProductsizeDetails['customer_price'] ?>                           
									</span>                           
									<?php } ?>                       
								</div>                                      
								<?php if($getProductsizeDetails['available_qty']>0){ ?>
								<a onclick="return confirm('Are you sure you want to delete this product from wishlist?');" style="padding: 7px;
    border: 1px solid;"  href="<?php echo BASE_URL."/my-wishlist.php?delid=".$whishlistDetails['id']; ?>" class="delete-btn wishlistdeletebtn"><img style="width:17px;padding: 11px 0;" src="<?php echo BASE_URL; ?>/images/delete-add.png"/></a>
									<a type="button" href="<?php echo $productPerma; ?>" class="movetocart">Add to Cart <i class="fa fa-arrow-right" style="color:#CADB2A"></i></a>
								<?php } else { ?>
									<span class="wishoutofstock" style="color:red;">Out of Stock</span>
								<?php } ?>                
							</div>                 
						</div>
					  </div>
					<?php }} else { ?> <h2 style="font-size:20px;text-align:center;font-weight:bold">  No Products Wishlisted Yet </h2> <?php } ?>
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

      <script></script>

   </body>

</html>