<?php

  $basename = basename($_SERVER['REQUEST_URI']);

  $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
  


	include_once("include/classes/Cart.class.php");
	$cartObj = new Cart;
	$amtArr = $functions->getCartAmountAndQuantity($cartObj, null);

?> 

<!-- Loader start -->

<div id="loader-wrapper">

	<div class="loader">            

		<img src="<?php echo BASE_URL; ?>/images/logo.png">

		<h2>Please Wait</h2>

	</div>

</div>

<!-- Loader end -->



<div class="wrapper">	

	<header>



		 <div id="top-bar">

		 	<div class="flex">

		 		<div class="left-top align-right w55">

		 			<p>

		 				<strong>FREE SHIPPING</strong> FOR ORDERS OVER<i class="fa fa-rupee"></i><span class="pprice">2,000</span>/-</p>

		 		</div>

		 		<div class="right-top w45">

		 			<ul class="flex">

		 				<li>

		 					<a data-fancybox data-src="#pdfcatelog" href="javascript:;">E-Catelogue <i class="fa fa-download"></i></a>

		 				</li>

		 				<li>

		 					<a href="<?php echo BASE_URL; ?>/contact-us.php">Contact</a>

		 				</li>

		 				<li>
							<?php if($loggedInUserDetailsArr = $functions->sessionExists()){ ?>
								<a class ="after-login"  href="<?php echo BASE_URL; ?>/my-account.php">My Account</a>		 					
							<?php }else{ ?>
								<a class="before-login" data-fancybox data-src="#sign-in-pop" href="javascript:;">join/login</a>
							<?php } ?>
		 				</li>
						 <?php if($loggedInUserDetailsArr = $functions->sessionExists()){ ?>
						 <li>
		 					<a href="<?php echo BASE_URL; ?>/logout.php">Logout</a>
		 				</li>
						 <?php } ?>
						<li>
							<img src="<?php echo BASE_URL;?>/images/cart.png" alt=""> (<span class="cart-quantity-count"><?php echo $amtArr['items']; ?></span>)
						</li>
		 			</ul>

		 		</div>

		 	</div>

		 </div>

		 <div class="logo-menu">

		 	<div class="logo flex-center">

		 		<a href="<?php echo BASE_URL; ?>/index.php">

		 			<img src="<?php echo BASE_URL; ?>/images/logo.png">

		 		</a>

		 	</div>

		 </div>

		 <div class="menu-section">

		 	<ul>

		 		<li  <?php if($currentPage=='index.php') { echo 'class="active"'; }?>>

		 			<a href="<?php echo BASE_URL; ?>/index.php">Home</a>

		 		</li>

		 		<li class="dropdown-menu-click  <?php if($currentPage=='listing.php' || $currentPage=='details.php') { echo "active"; }?>">

		 			<a href="javascript:void(0)">Shop Now</a>

		 			<div class="dropdon-click site-nav__dropdown meganav shospdsas">

		 				<div class="mega-menu-flex">

							 <?php 
							$getMainCategoryList = $functions-> getMainCategories();
							$getProductCategoryMapping = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_category_mapping"));

							while($rowCategoryList = $functions->fetch($getMainCategoryList)){
								$categotyIdHeader = $rowCategoryList['id'];
								$getSubCategoryList = $functions->getSubCategoryByCategoryId($categotyIdHeader);
								?>
								 <div>
									<h2><?php echo $rowCategoryList['category_name']; ?></h2>
									<?php
										while($rowSubCategoryList = $functions->fetch($getSubCategoryList)){
											echo '<a href="'.BASE_URL.'/'.$rowCategoryList['permalink'].'/'.$rowSubCategoryList['permalink'].'">'.$rowSubCategoryList['category_name'].'</a>';
										}
									?>
								</div>								
						<?php	} ?>
							
		 					<!-- <div>

		 						<h2>Drink</h2>		 						

		 						<a href="details.php">Mugs & Tumblers</a>

		 						<a href="details.php">Water bottles</a>

		 						<a href="details.php">Beverage bottles</a>

		 						 <a href="details.php">Seasonal bottles</a> 

		 						<a href="details.php" class="shopbtn">Etc...</a>

		 					</div>

		 					<div>

		 						<h2>serve</h2>

		 						<a href="details.php">Bowl</a>

		 						<a href="details.php">Dummy text</a>

		 						<a href="details.php">Product name</a>

		 						<a href="details.php" class="shopbtn">Etc...</a>

		 					</div>

		 					<div>

		 						<h2>store</h2>

		 						<a href="details.php">Bowl</a>

		 						<a href="details.php">Dummy text</a>

		 						<a href="details.php">Product name</a>

		 						<a href="details.php" class="shopbtn">Etc...</a>

		 					</div> -->

		 				</div>

		 			</div>

		 		</li>

		 		<li class="dropdown-menu-click <?php if($currentPage=='about-us.php' || $currentPage=='why-selvel.php') { echo "active"; }?>" >

		 			<a href="#">About</a>

		 			<div class="dropdon-click site-nav__dropdown meganav abt-mgeas">

		 				<div class="mega-menu-flex about-mega">

		 					<div class="abt-sbt">

		 						<a href="<?php echo BASE_URL; ?>/about-us.php">

		 							<img src="<?php echo BASE_URL; ?>/images/about-img1.jpg" class="img-full">

		 							<h2>About Selvel</h2>

		 						</a>

		 					</div>

		 					<div class="abt-sbt">

		 						<a href="<?php echo BASE_URL; ?>/why-selvel.php?action=about-section-sub">

		 							<img src="<?php echo BASE_URL; ?>/images/about-img1.jpg" class="img-full">

		 							<h2>Why Selvel</h2>

		 						</a>

		 					</div>

		 					<div class="abt-sbt">

		 						<a href="<?php echo BASE_URL; ?>/why-selvel.php?action=selvel-history">

		 							<img src="<?php echo BASE_URL; ?>/images/about-img1.jpg" class="img-full">

		 							<h2>History of Selvel</h2>

		 						</a>

		 					</div>

		 				</div>

		 			</div>

		 		</li>

		 		<li class="explip">

		 			<a href="<?php echo BASE_URL; ?>/blog" target="_blank">Explore</a>

		 		</li>

		 		<li class="no-hover">

		 			<form autocomplete="off">

		 				<div class="form-group">

		 					<input type="text" name="search" placeholder="Search">

		 					<button class="search-icons">

		 						<i class="fa fa-search"></i>

		 					</button>

		 				</div>

		 			</form>

		 		</li>

		 		

		 	</ul>

		 </div>

	</header>

	 

