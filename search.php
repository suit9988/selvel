<?php 
   Include_once("include/functions.php");
   $functions = New Functions();
   if(isset($_GET['product_id']) && !empty($_GET['product_id'])){
	   //echo "hiii";
     // $sql = $functions->getProductByfilterdata($_GET['product_id']);

   }else{
      header("location:".BASE_URL."?INVALISEARCH");
   }
?>
<!DOCTYPE>
<html>
   <head>
      <title>Selvel</title>
      <?php include("include/header-link.php");?>
     
   </head>
	<body class="inner-page" id="listing-page">
		<!--Top start menu head-->       
		<?php include("include/header.php");?>

		<main class="main-inner-div listingbgchange">
		   <img src="<?php echo BASE_URL; ?>/images/inner-bg.png" class="img-full fixedimg listingsa">   
		  	<div class="banner-inner container plr0">
			   <img src="<?php echo BASE_URL; ?>/images/listing-imgs.png" class="various-img-listing">         
			   <h2>Search Results </h2> 
			</div>         

			<div class="container breadcum-header">
				<div class="container">
					<ul class="breadcrumbs">
						<li><a href="<?php echo BASE_URL; ?>">Home</a><i class='fa fa-angle-right'></i></li>
						<li><a href="javascript:void(0);">Search</a></li>
					</ul>
				</div>
			</div>
			<section class="listing-pages">
					<?php
					$permalink ='search.php';
					Include_once "include/product-listing.inc.php";
					?>
			</section>
		</main>
		<!--Main End Code Here-->
		<!--footer start menu head-->
		<?php include("include/footer.php");?> 
		<!--footer end menu head-->
		<?php include("include/footer-link.php");?>
		<script type="text/javascript">

         $(".niceselect").niceSelect();


         $('.cartListingBtn').on('click',function(){
         setTimeout(function(){         
             window.location="<?php echo BASE_URL; ?>/cart.php";
         }, 200);

         });
               

      </script>
		<script src="<?php echo BASE_URL; ?>/js/ajax-update-cart.js" type="text/javascript"></script>
	</body>
</html>