
<!DOCTYPE>
<html>
<head>
	<title></title>
	<meta name="title" content="">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="SELVEL">
	<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="icon" type="image/ico" sizes="32x32" href="http://15.207.231.89/images/favicon-32x32.ico">

<!-- <meta name="msapplication-TileColor" content="#ffffff"> -->

<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">


<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

<!-- <meta name="theme-color" content="#ffffff"> -->

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/bootstrap-theme.min.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/style.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/reset.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/slick/slick-theme.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/animate.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/slick/slick.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/nice-select.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/fancy.css">

<link rel="stylesheet" type="text/css" href="http://15.207.231.89/css/responsive.css">

<link rel="stylesheet" href="http://15.207.231.89/css/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

	<!-- <script src="http://15.207.231.89js/jquery-1.10.2.min.js"></script> -->
</head>
<body class="inner-page" id="listing-page">
	<!--Top start menu head-->       
	 
  <style>
  .typeahead li{}
  .typeahead{display:block !important}
  
  .cart-notification {
      width: auto;
      padding: 0 30px;
      left: 80%;
      top: 0;
      margin: 77px 0;
      text-align: center;
      transition: all .5s ease-in-out;
      -webkit-transition: all .5s ease-in-out;
      -moz-transition: all .5s ease-in-out;
      -o-transition: all .5s ease-in-out;
      position: fixed;
      z-index: 99999997;
      background: #fff;
      border-radius: 0;
      border: 0;
      color: #431a92;
      box-shadow: 0px 3px 7px #c9c9c9, -11px -11px 14px #7269880d;
  }
  .cart-notification-container.alert {
    margin: 0px;
    font-weight: bold;
    padding: 10px 30px;
}
.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
.fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
}
  </style>
<!-- Loader start -->
<div id="loader-wrapper">
	<div class="loader">            
		<img src="http://15.207.231.89/images/logo.png">
		<h2>Please Wait</h2>
	</div>
</div>
<!-- Loader end -->
<div class="wrapper">	
	<header class="">
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
		 					<a href="http://15.207.231.89/contact-us.php">Contact</a>
		 				</li>
		 				<li>
															<a class="before-login" data-fancybox data-src="#sign-in-pop" href="javascript:;">join/login</a>
									 				</li>
						 						 <li>
		 					<a href="http://15.207.231.89/cart.php"><span class="clickCartHere">
		 						<i class="fa fa-shopping-cart"></i> (<span class="cart-quantity-count">0</span>)
		 					</span></a>
		 				</li>
		 				<li>
		 					<a href="http://15.207.231.89/my-wishlist.php"><span class="clickCartHere">
		 						<i class="fa fa-heart"></i>
		 					</span></a>
		 				</li>
		 			</ul>
		 		</div>
		 	</div>
		 </div>
		 <div class="logo-menu">
		 	<div class="logo flex-center">
		 		<a href="http://15.207.231.89/index.php">
		 			<img src="http://15.207.231.89/images/logo.png">
		 		</a>
		 	</div>
		 	<div class="mobilesearch">
		 		<form autocomplete="off" action="http://15.207.231.89/search"  method="GET" id="searchFrm">
		 			<div class="form-group">
		 				<input type="text" name="product_id" placeholder="Search for Product" id="search_text" value="" required>
	 					<button class="search-icons"  type="submit">
							<i class="fa fa-search"></i>
		 				</button>
		 			</div>
		 		</form>
		 	</div>
		 	<div class="togglemenus">
		 		<span></span>
		 		<span></span>
		 		<span></span>
		 	</div>
		 </div>
		 <div class="cart-notification fadeInDown animated" style="display: none;">
			<div class="cart-notification-container alert"></div>
		</div>
		 <div class="menu-section">
		 	<ul>
		 		<li  >
		 			<a href="http://15.207.231.89/index.php">Home</a>
		 		</li>
		 		<li class="dropdown-menu-click  ">
		 			<a href="javascript:void(0)">Shop Now</a> <i class="fa fa-angle-down clickmenu"></i>
		 			<div class="dropdon-click site-nav__dropdown meganav shospdsas">
		 				<div class="mega-menu-flex">
							 								 <div class="scrollbarhai">
									<A href="http://15.207.231.89/eat"><h2>Eat</h2></a>
									<a href="http://15.207.231.89/eat/casseroles">Casseroles</a><a href="http://15.207.231.89/eat/lunch-box">Lunch Box</a>								</div>								
														 <div class="scrollbarhai">
									<A href="http://15.207.231.89/drink"><h2>Drink</h2></a>
									<a href="http://15.207.231.89/drink/non-insulated-bottles">Non Insulated Bottles</a><a href="http://15.207.231.89/drink/insulated-bottles">Insulated Bottles</a><a href="http://15.207.231.89/drink/glasses">Glasses</a><a href="http://15.207.231.89/drink/jugs">Jugs</a><a href="http://15.207.231.89/drink/sipper">Sipper</a><a href="http://15.207.231.89/drink/mugs">Mugs</a>								</div>								
														 <div class="scrollbarhai">
									<A href="http://15.207.231.89/serve"><h2>Serve</h2></a>
									<a href="http://15.207.231.89/serve/trays-bowl-set">Trays & Bowl Set</a><a href="http://15.207.231.89/serve/coaster">Coaster</a><a href="http://15.207.231.89/serve/multipurpose-boxes">Multipurpose Boxes</a><a href="http://15.207.231.89/serve/bowls">Bowls</a><a href="http://15.207.231.89/serve/lemon-set">Lemon Set</a>								</div>								
														 <div class="scrollbarhai">
									<A href="http://15.207.231.89/store"><h2>Store</h2></a>
									<a href="http://15.207.231.89/store/racks-trolleys">Racks & Trolleys</a><a href="http://15.207.231.89/store/containers">Containers</a><a href="http://15.207.231.89/store/baskets">Baskets</a><a href="http://15.207.231.89/store/trays">Trays</a><a href="http://15.207.231.89/store/ice-trays">Ice Trays</a><a href="http://15.207.231.89/store/stands">Stands</a>								</div>								
													
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
		 		<li class="dropdown-menu-click " >
		 			<a href="javascript:void(0);">About</a>  <i class="fa fa-angle-down clickmenu"></i>
		 			<div class="dropdon-click site-nav__dropdown meganav abt-mgeas">
		 				<div class="mega-menu-flex about-mega">
		 					<!-- <div class="abt-sbt">
		 						<a href="/about-us.php">
		 							<img src="/images/about-img1.jpg" class="img-full">
		 							<h2>About Selvel</h2>
		 						</a>
		 					</div>
		 					<div class="abt-sbt">
		 						<a href="/why-selvel.php?action=about-section-sub">
		 							<img src="/images/about-img1.jpg" class="img-full">
		 							<h2>Why Selvel</h2>
		 						</a>
		 					</div>
		 					<div class="abt-sbt">
		 						<a href="/why-selvel.php?action=selvel-history">
		 							<img src="/images/about-img1.jpg" class="img-full">
		 							<h2>History of Selvel</h2>
		 						</a>
		 					</div> -->
		 					<ul>
		 						<li><a href="http://15.207.231.89/about-us.php">About</a></li>
		 						<li><a href="http://15.207.231.89/why-selvel.php?action=selvel-history">History</a></li>
		 						<li><a href="http://15.207.231.89/why-selvel.php?action=about-section-sub">Why Selvel?</a></li>
		 					</ul>
		 				</div>
		 			</div>
		 		</li>
		 		<li class="explip">
		 			<a href="http://15.207.231.89/blog" target="_blank">Explore</a>
		 		</li>
		 		<li class="no-hover">
					
						
		 			<form autocomplete="off" action="http://15.207.231.89/search"  method="GET" id="searchFrm">
		 				<div class="form-group">
		 					<input type="text" name="product_id" placeholder="Search for Product" id="search_text" value="" required>
		 					<button class="search-icons"  type="submit">
		 						<i class="fa fa-search"></i>
		 					</button>
		 				</div>
		 			</form>
		 		</li>
		 		
		 	</ul>
		 </div>
	</header>
	 
		<!--Main Start Code Here-->
	<main class="main-inner-div listingbgchange">
		<img src="http://15.207.231.89/images/inner-bg.png" class="img-full fixedimg listingsa jasatasims"> 		       
		<div class="banner-inner container plr0 imagesdemos">
			<img src="http://15.207.231.89/images/prodfullimga.jpg" class="various-img-listing"> 
			<h2>Lunch Box</h2>
		</div>

		<div class="container breadcum-header">
			<ul>
				<li><a href=http://15.207.231.89>Home</a><i class='fa fa-angle-right'></i></li><li><a href='http://15.207.231.89/eat'>Eat</a><i class='fa fa-angle-right'></i></li><li><a href='http://15.207.231.89/eat/lunch-box'>Lunch Box</a></li>			</ul>
		</div>
		<section class="listing-pages">
			<div class="container plr0" id="mobilefilters">
				<div class="filter-sorting">
					<div class="Sort-By">
						<select name="sortByMob" id="sortByMob" class="Sort-By-filter sortselect niceSelect" style="z-index:1111">
							<option selected >Sort By</option>
							<option value="pricelow">Price: Low to High</option>
							<option value="pricehigh">Price: High to low</option>
							<option value="latest">Newest First</option>
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
														<h2>Handle</h2>
														<div class="price-filp">
																																	<div class="form-group">
																			<input type="checkbox" id="action17" class="common_selector attrFeatureMob" value="17"  > 
																			<label for="action17"> Metal Handle</label>
																		</div>
																																	<div class="form-group">
																			<input type="checkbox" id="action18" class="common_selector attrFeatureMob" value="18"  > 
																			<label for="action18"> Plastic Handle</label>
																		</div>
																													</div>
													</div>
																						<div class="flex-filtes">
														<h2>Set</h2>
														<div class="price-filp">
																																	<div class="form-group">
																			<input type="checkbox" id="action27" class="common_selector attrFeatureMob" value="27"  > 
																			<label for="action27"> </label>
																		</div>
																													</div>
													</div>
																		<div class="flex-filtes">
										<h2>Price</h2>
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
										<h2>Size</h2>
										<div class="price-filp">
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="0-500" id="mobilebar1"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar1">0ml - 500ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="501-1000" id="mobilebar2">
												<span class="check-mark"></span> 
												<label class="custcheck" for="mobilebar2">500ml - 1000ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="1001-2000" id="mobilebar3"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar3">1000ml - 2000ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="2001-3000" id="mobilebar4"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar4">2000ml - 3000ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="3001-4000" id="mobilebar5"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar5">3000ml - 4000ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="4001-5000" id="mobilebar6"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar6">4000ml - 5000ml</label>
											</div>
											<div class="form-group">
												<input type="checkbox" class="common_selector size_bar_mobile" value="5001-50000" id="mobilebar7"> 
												<span class="check-mark"></span>
												<label class="custcheck" for="mobilebar7">Above 5000 ml</label>
											</div>
										</div>
									</div>
									<div class="flex-filtes">
										<h2>Colours</h2>
										<div class="filtercolourformflexx">
											<span class="color-box-input" data-toggle="buttons">
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/download.png')">
															<input type="radio" name="color[]" class="colorArrMob" id="color1" value="Red" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/1FBED6.png.png')">
															<input type="radio" name="color[]" class="colorArrMob" id="color2" value="Blue" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/black.jpg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color3" value="Black" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/download.png')">
															<input type="radio" name="color[]" class="colorArrMob" id="color4" value="Brown" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/green.png')">
															<input type="radio" name="color[]" class="colorArrMob" id="color5" value="Green" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/purple.jpg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color6" value="Purple" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/silver.jpg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color7" value="Silver" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/yellow.jpg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color8" value="yellow" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/131273-dark-red-polygonal-background-design.jpg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color10" value="tester color" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color11" value="White-Pink" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color12" value="Light Brown" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color13" value="Ivory Red" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color14" value="Sky Blue-Dark Blue" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color15" value="Orchid White" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color16" value="Dark Brown" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color17" value="White" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color18" value="Gold" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color19" value="Mulberry" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
															<input type="radio" name="color[]" class="colorArrMob" id="color20" value="Copper" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/orange color.png')">
															<input type="radio" name="color[]" class="colorArrMob" id="color21" value="Orange" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Lilac.jpeg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color22" value="Lilac" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Mint.jpeg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color23" value="Mint" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
																										<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Pink.jpeg')">
															<input type="radio" name="color[]" class="colorArrMob" id="color24" value="Pink" autocomplete="off" >
															<span class="fa fa-check"></span>
														</label>
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
			<div class="filterandproflex">
				<div class="filteraccbox">
					<div class="panel-group desktopfilterpanel" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false">Sort By</a>
							</div>
							<div id="collapse1" class="panel-collapse collapse">
								<div class="panel-body">
									<form class="sortinform">
										<label for="popular">
											<input type="radio" name="sortBy" value="pricelow" id="popular">
											<span>Price: Low to High</span>
										</label>
										<label for="highlow">
											<input type="radio" name="sortBy" id="highlow" value="pricehigh">
											<span>Price: High to low</span>
										</label>
										<label >
											<input type="radio" name="sortBy" value="latest">
											<span>Newest First</span>
										</label>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false">Filter By</a>
							</div>
							<div id="collapse2" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="panel-group filterpanelss" id="accordion1">
										<div class="panel panel-default">
											<div class="panel-heading panelclickbtn">
												<a class="panel-title"  data-parent="#accordion1" aria-expanded="false">Type</a>
											</div>
											<div id="handle" class="panel-collapse collapse">
																												<div class="flex-filtes">
																	<h2>Handle</h2>
																	<div class="price-filp">
																																							<div class="form-group">
																						<input type="checkbox" id="action17" class="common_selector attrFeature" value="17"  > 
																						<label for="action17"> Metal Handle</label>
																					</div>
																																							<div class="form-group">
																						<input type="checkbox" id="action18" class="common_selector attrFeature" value="18"  > 
																						<label for="action18"> Plastic Handle</label>
																					</div>
																																			</div>
																</div>
																												<div class="flex-filtes">
																	<h2>Set</h2>
																	<div class="price-filp">
																																							<div class="form-group">
																						<input type="checkbox" id="action27" class="common_selector attrFeature" value="27"  > 
																						<label for="action27"> </label>
																					</div>
																																			</div>
																</div>
																							</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading panelclickbtn">
												<a class="panel-title"  data-parent="#accordion1" aria-expanded="false">Price</a>
											</div>
											<div id="price" class="panel-collapse collapse">
												<form>
													<div class="price-filp">
														<div class="form-group">
															<input type="checkbox" class="priceFilter" id="value1" value="0-500">
															<span class="check-mark"></span>
															<label class="custcheck" for="value1">Less than Rs. 500</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="priceFilter" id="value2" value="500-1000">
															<span class="check-mark"></span>
															<label class="custcheck" for="value2">
																<!-- <i class="fa fa-rupee"></i> -->
																Rs 500 to Rs. 1000
															</label>
														</div>
														<div class="form-group">
															<input type="checkbox" id="value3" class="priceFilter" value="1001-5000" >
															<span class="check-mark"></span>
															<label class="custcheck" for="value3">
																<!-- <i class="fa fa-rupee"></i> -->
																Rs. 1000 to Rs. 2000
															</label>
														</div>
														<div class="form-group">
															<input type="checkbox" id="value4" class="priceFilter" value="5001-10000" >
															<span class="check-mark"></span>
															<label class="custcheck"for="value4" >
																<!-- <i class="fa fa-rupee"></i> -->
																Rs. 2000 to Rs. 3000
															</label>
														</div>
														<div class="form-group">
															<input type="checkbox" id="value5" class="priceFilter" value="10000-1000000" >
															<span class="check-mark"></span>
															<label class="custcheck" for="value5">
																<!-- <i class="fa fa-rupee"></i> -->
																Above Rs. 3000
															</label>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading panelclickbtn">
												<a class="panel-title"  data-parent="#accordion1"  aria-expanded="false">Size</a>
											</div>
											<div id="size" class="panel-collapse collapse filterscroll">
												<form>
													<div class="price-filp">
														<!-- <div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value=""  > 
															<label for=""> </label>
														</div> -->
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="0-500" id="sizebar1"> 
															<label class="custcheck" for="sizebar1">0ml - 500ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="501-1000" id="sizebar2"> 
															<label class="custcheck" for="sizebar2">500ml - 1000ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="1001-2000" id="sizebar3"> 
															<label class="custcheck" for="sizebar3">1000ml - 2000ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="2001-3000" id="sizebar4"> 
															<label class="custcheck" for="sizebar4">2000ml - 3000ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="3001-4000" id="sizebar5"> 
															<label class="custcheck" for="sizebar5">3000ml - 4000ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="4001-5000" id="sizebar6"> 
															<label class="custcheck" for="sizebar6">4000ml - 5000ml</label>
														</div>
														<div class="form-group">
															<input type="checkbox" class="common_selector size_bar" value="5001-50000" id="sizebar7"> 
															<label class="custcheck" for="sizebar7">Above 5000 ml</label>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading panelclickbtn">
												<a class="panel-title"  data-parent="#accordion1"  aria-expanded="false">Colours</a>
											</div>
											<div id="colours" class="panel-collapse collapse">
												<div class="filtercolourformflexx">
													<span class="color-box-input" data-toggle="buttons">
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/download.png')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color1" value="Red" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/1FBED6.png.png')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color2" value="Blue" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/black.jpg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color3" value="Black" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/download.png')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color4" value="Brown" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/green.png')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color5" value="Green" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/purple.jpg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color6" value="Purple" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/silver.jpg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color7" value="Silver" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/yellow.jpg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color8" value="yellow" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/131273-dark-red-polygonal-background-design.jpg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color10" value="tester color" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color11" value="White-Pink" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color12" value="Light Brown" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color13" value="Ivory Red" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color14" value="Sky Blue-Dark Blue" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color15" value="Orchid White" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color16" value="Dark Brown" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color17" value="White" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color18" value="Gold" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color19" value="Mulberry" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color20" value="Copper" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/orange color.png')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color21" value="Orange" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Lilac.jpeg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color22" value="Lilac" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Mint.jpeg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color23" value="Mint" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																														<label class="btn colo-btn" style="background-image: url('http://15.207.231.89/images/color/Pink.jpeg')">
																	<input type="checkbox" name="colorFilter[]" class="colorFilter" id="color24" value="Pink" autocomplete="off" >
																	<span class="fa fa-check"></span>
																</label>
																											</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="productlist-grid">
					<div class="AjaxFilters">
						<div class="listing-modules wow fadeInUp" >
	<div class="sellers-slider">
							<div class="produc-main Jprice" data-price="20" data-id="89">
						<div class="img-prods">					
							<a href="http://15.207.231.89/selvel-box-test/rgtdr/25138740"> 
								<img src="http://15.207.231.89/images/products/1604907505-1_crop.png" alt="selvel box test" class="img-responsive">
								<div class="prohover">
									<img src="http://15.207.231.89/images/logo.png">
									<h6>Buy Now</h6>
								</div>
							</a>
						</div>
						<div class="prods-desc">							
							<a href="http://15.207.231.89/selvel-box-test/rgtdr/25138740">
								<h2>
									selvel box test								</h2>
								<input type="hidden" name="id" class="id" value="89">
								<div class="product-cat-details">
									<h2>rgtdr | Capacity: 100MLML</h2>
								</div>
								<div class="prods-price">
																			<span class="text-drop">
											<i class="fa fa-rupee"></i> 250										</span>
										<span class="text-price-og">
											<i class="fa fa-rupee"></i> 20										</span>
																	</div>
								<div class="pric-cart-add">
																		<span class="listingWish">
																						<a  class="wishlistbtnnew" href="http://15.207.231.89/login.php?redirect=http://15.207.231.89/eat/lunch-box">
												<i class="fa fa-heart"></i> </a>
																			</span>
									<span class="price-cart-add-top cartListingBtn" data-id="89"><i class="fa fa-shopping-cart"></i>
										<input type="hidden"  name="available_qty" value="10">
										<input type="hidden" name="size" value="100ML">
										<input type="hidden" name="color" value="Green">
									</span>
								</div>
							</a>
						</div>
					</div>
							<div class="produc-main Jprice" data-price="650" data-id="95">
						<div class="img-prods">					
							<a href="http://15.207.231.89/tiffin-box/tfnbox/25140637"> 
								<img src="http://15.207.231.89/images/products/1604301193-1_crop.jpg" alt="Tiffin box" class="img-responsive">
								<div class="prohover">
									<img src="http://15.207.231.89/images/logo.png">
									<h6>Buy Now</h6>
								</div>
							</a>
						</div>
						<div class="prods-desc">							
							<a href="http://15.207.231.89/tiffin-box/tfnbox/25140637">
								<h2>
									Tiffin box								</h2>
								<input type="hidden" name="id" class="id" value="95">
								<div class="product-cat-details">
									<h2>tfnbox | Capacity: 1000MLML</h2>
								</div>
								<div class="prods-price">
																			<span class="text-drop">
											<i class="fa fa-rupee"></i> 750										</span>
										<span class="text-price-og">
											<i class="fa fa-rupee"></i> 650										</span>
																	</div>
								<div class="pric-cart-add">
																		<span class="listingWish">
																						<a  class="wishlistbtnnew" href="http://15.207.231.89/login.php?redirect=http://15.207.231.89/eat/lunch-box">
												<i class="fa fa-heart"></i> </a>
																			</span>
									<span class="price-cart-add-top cartListingBtn" data-id="95"><i class="fa fa-shopping-cart"></i>
										<input type="hidden"  name="available_qty" value="10">
										<input type="hidden" name="size" value="1000ML">
										<input type="hidden" name="color" value="Red">
									</span>
								</div>
							</a>
						</div>
					</div>
			</div>
</div>					</div>
					<div class="showLoader" style="display: none;">
						<center>
							<img src="http://15.207.231.89/images/ajax-loader.gif" style="width: 6%;"><br><br>
							<h3 style="color:#fa283896;">Loading Please Wait......</h3>
						</center>
					</div>
					<input type="hidden" name="permalink" id="permalink" value="http://15.207.231.89/eat/lunch-box">
					<input type="hidden" name="cat_permalink" id="cat_permalink" value="eat">
					<input type="hidden" name="sub_category_permalink" id="sub_category_permalink" value="lunch-box">
					<input type="hidden" name="sub_category_id" id="sub_category_id" value="">
					<input type="hidden" name="subSub_category_id" id="subSub_category_id" value="">
					<input type="hidden" name="limitCount" class="limitCount" value="30">
				</div>
			</div>
		</section>
	</main>
	<!--Main End Code Here-->
	<!--footer start menu head-->
	  <footer id="footer" class="wow fadeInUp">
    <div class="container">
    	<div class="newsletter-div">
    		<h2 class="why-title">Newsletter</h2>
    		<h3 class="newsletter-subtetx">You can subscribe to our newsletter to get to know about our latest products and exciting offers.</h3>
    		<div class="newsletter-form">
    			<form class="news-form" method="post" action="http://15.207.231.89/process-newsletter.php">
    				<div class="form-group">
    					<input type="text" name="yourname" placeholder="Your Name">
    				</div>
    				<div class="form-group">
    					<input type="email" name="youremail" placeholder="Your Email ID">
    				</div>
    				<div class="form-group">
    					<button type="submit" name="newsletter_submit" class="btn-subscribe">Subscribe</button>
    				</div>
    			</form>
    		</div>
    	</div>
    	<div class="row footer-address">
    		<div class="col-md-6 logoaddrs">
    			<a href="http://15.207.231.89/index.php"><img src="http://15.207.231.89/images/logo.png"></a>
				    			<p>
    				3, Vakil Industrial Estate, Goregaon East, Mumbai - 400063    			</p>
				
    			<div class="social-item">
				    				<a href="https://www.facebook.com/selvelglobal" target="_blank">
    					<img src="http://15.207.231.89/images/facebook.png">
    				</a>
				    				<a href="https://www.twitter.com/selvelglobal" target="_blank">
    					<img src="http://15.207.231.89/images/twitter.png">
    				</a>
									<a href="https://www.instagram.com/selvelglobal" target="_blank">
    					<img src="http://15.207.231.89/images/instagram-color.png" style="height:20px">
    				</a>
				    			</div>
				
    		</div>
    		<div class="col-md-6 footer-links">
    			<h2>
    				Quick Links
    			</h2>
    			<ul>
    				<li><a href="http://15.207.231.89/about-us.php">- About Selvel</a></li>
    				<li><a href="http://15.207.231.89/contact-us.php">- Contact / Support Page</a></li>
    				<li><a  data-fancybox data-src="#corporateform" href="javascript:;">- Corporate Gifting</a></li>
    				<li><a href="http://15.207.231.89/why-selvel.php?action=about-section-sub">- Why Selvel</a></li>
    				<li><a data-fancybox data-src="#distriform" href="javascript:;">- Distributors Form</a></li>
    				<li><a href="http://15.207.231.89/privacy-policy.php">- Terms & Privacy Policy</a></li>
    				<li><a href="http://15.207.231.89/refund.php">- Shipping, Cancellation & Refund</a></li>
    				<li><a href="http://15.207.231.89/faqs.php">- FAQs</a></li>
    			</ul>
    			<span class="download-broucher">
    				<a data-fancybox data-src="#pdfcatelog" href="javascript:;">
    					E-Catelogue <span class="listopo">|</span> <i class="fa fa-download"></i>
    				</a> 
    			</span>
    		</div>    		
    	</div>
    </div>
    <div class="copyrights">
    	<p>Copyright ©  <script>var currentYear = new Date().getFullYear();document.write(currentYear);</script> Selvel Domestoware All rights reserved.</p>
    </div>
  </footer>
</div>
<div id="sign-in-pop"  style="display: none;">

   <section class="login-form" id="login-page">

      <div class="login-section">

         <div class="logmain-in">

            <div class="login-box">
               
                                            
               <h1 class="page-heading">log in</h1>

               <form class="login-form" id="login-form" method="post" novalidate="novalidate">

                  <div class="form-group">

                     <label>Email Address</label>

                     <input type="text" name="email" class="form-control" placeholder="Email ID" required="" autofocus="">

                  </div>

                  <div class="form-group passord-toogle">

                     <label>Password</label>

                     <i class="fa fa-eye passwordtoggle"></i>

                     <input type="password" name="password" class="password-show form-control" placeholder="Password" required="">

                  </div>

                  <div class="form-group">

                     <input type="hidden" placeholder="" name="redirect_url" id="redirect_url" value="">

                     <input type="hidden" placeholder="" name="productredirect" id="productredirect" value="">

                     <input type="hidden" name="user_type" value="Customer" data-id="customer">

                  </div>

                  <div class="flex-pos">

                     <button class="btn red-btn btn-animation" name="login_btn">Log in</button>

                     <p class="fp-btn">Forgot Your Password?</p>

                  </div>

               </form>

               <form class="fp-forms" style="display:none;" id="forgot-form" method="post" novalidate="novalidate">

                  <input type="text" name="email" class="form-control" placeholder="Email ID" required="">

                  <div class="flex-pos logpsds">

                     <button type="submit" name="forgot_btn" class="btn red-btn btn-animation">Reset</button>

                     <p class="back-btn">Back to Login</p>

                  </div>

               </form>

               <p class="already">Don't have an account? <a class="green-text" id="open-register" href="javascript:;">Sign up Here</a></p>

            </div>

         </div>

      </div>

   </section>

   <section class="login-form" id="register-page" style="display: none;">

      <div class="login-section">

         <div class="regiscontainer">

            <div class="formbox">

               <form action="" method="POST" id="registration-form" novalidate="novalidate">

                  <h1>Register</h1>

                  <div id="vender" class="">

                     <div class="venderform">

                        <div class="form-group">

                           <label>Name <em>*</em></label>

                           <input type="text" name="name" class="form-control" placeholder="Name" required="">

                        </div>

                        <div class="form-group">

                           <label>Email ID <em>*</em></label>

                           <input type="text" name="email" class="form-control" placeholder="Email ID">

                        </div>

                        <div class="form-group">

                           <label>Mobile No. <em>*</em></label>

                           <input type="text" name="mobile" class="form-control" placeholder="Mobile" required="">

                        </div>

                        <div class="form-group passord-toogle">

                           <label>Password <em>*</em></label>

                           <i class="fa fa-eye passwordtoggle"></i>

                           <input type="password" name="password" id="password-1" class="form-control password-show" placeholder="Password" required="">

                        </div>

                        <div class="form-group passord-toogle">

                           <label>Confirm Password <em>*</em></label>

                           <i class="fa fa-eye passwordtoggles"></i>

                           <input type="password" name="repassword" class="form-control password-shows" placeholder="Confirm Password" required="">

                        </div>

                        <button class="btn reg-btn btn-animation" type="submit" name="register"> Register</button>

                        <p class="already">Already registered? <a class="green-text" id="open-login-here" href="javascript:;">Login Here</a></p>

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </section>

</div>
<script src="http://15.207.231.89/js/jquery-3.3.1.min.js" type="text/javascript"></script> 
  <script type="text/javascript" src="http://15.207.231.89/js/jquery.validate.js"></script>      

<script>
$(document).ready(function(){
         $("#registration-form").validate({
               ignore: ".ignore",
               rules: {
                  name: {
                     required:true
                  }, 
                   
                  mobile: {
                     required:true
                  },
                  email: {
                     required: true,
                     email:true,
                     remote:{
                        url:"ajaxCheckEmailExists.php",
                        type: "post",
                     }
                  },
                  password: {
                     required: true,
                     //pwcheck: true,
                     minlength: 8,
                     maxlength: 12,
                  },
                  repassword: {
                     required: true,             
                     equalTo: "#password-1"
                  },
               },
               messages: {
                  name: {
                     required: "Please enter name"
                  },
                  
                  city: {
                     required: "Please enter city"
                  },
                  email: {
                     required: 'please enter your email address',
                     remote:'Sorry, an account is already registered with that E-mail ID.'
                  },
               }
            });
            
            

         
         
         
         

         $("#login-form").validate({
				ignore: ".ignore",
				rules: {
					email: {
						required: true,
						email:true,
					},
					password: {
						required: true,
					},
				},
				messages: {
					email: {
						required: 'Please enter your email address',
					},
					password: {
						required: 'Please enter your password',
					},
				}
         });
         
         });

      

</script><div class="review-box-inner" id="distriform" style="display: none;"> 		
			<h2> Fill the form as your requirment</h2>	
			<form action="http://15.207.231.89/distributor.php" id="contact-osp" method="post">
			  <div class="form-group clearfix">
			    <input class="col2 first" type="text" placeholder="Full Name" name="name">                     
			  </div>
			  <div class="form-group clearfix">
			    <input  class="col2 first" type="Email" placeholder="Email" name="email">                     
			  </div>
			  <div class="form-group clearfix">                      
			    <input class="col2 last" type="text" placeholder="Contact Number" name="contact">
			  </div>
			  <div class="form-group clearfix">                      
			   <select name="purpose">
			   	<option selected disabled>Select Purpose</option>	
			   	<option>general enquiry</option>	
			   	<option>job application</option>	
			   	<option>Corporate gifting enquiry</option>	
			   	<option>Distributor Info Required</option>	
			   </select>
			  </div>
			  <div class="form-group clearfix wi9s0">
			    <textarea name="msg" id="" cols="30" rows="7" >Add Detail</textarea>
			  </div>
			  <!--<div class="form-group clearfix wi9s0 filsdp">
			    <input type="file" name="broucher_names">
			  </div>-->
			   <button type="submit" class="btn-sbt" name="send">
			      Send
			    </button>
			</form>
			
		</div><div class="review-box-inner" id="corporateform" style="display: none;"> 		
			<h2 style="text-align:center"> Fill the form as your requirment<br><br></h2>	
			<form action="http://15.207.231.89/corporate.php" id="contact-osp" method="post">
			  <div class="form-group clearfix">
			    <input class="col2 first" type="text" placeholder="Full Name" name="name">                     
			  </div>
			  <div class="form-group clearfix">
			    <input  class="col2 first" type="Email" placeholder="Email" name="email">                     
			  </div>
			  <div class="form-group clearfix">                      
			    <input class="col2 last" type="text" placeholder="Contact Number" name="contact">
			  </div>
			  <div class="form-group clearfix">                      
			   <select name="purpose">
			   	<option selected disabled>Select Purpose</option>	
			   	<option>general enquiry</option>	
			   	<option>job application</option>	
			   	<option selected>Corporate gifting enquiry</option>	
			   	<option>Distributor Info Required</option>	
			   </select>
			  </div>
			  <div class="form-group clearfix wi9s0">
			    <textarea name="msg" id="" cols="30" rows="7" >Add Detail</textarea>
			  </div>
			  <!--<div class="form-group clearfix wi9s0 filsdp">
			    <input type="file" name="broucher_names">
			  </div>-->
			   <button type="submit" class="btn-sbt" name="send">
			      Send
			    </button>
			</form>
			
		</div><div class="review-box-inner"  id="pdfcatelog" style="display: none;"> 		
	<h2> Fill the form</h2>	
	<form  id="contact-osp" action="http://15.207.231.89/pdf_server.php" method="post">
	  <div class="form-group clearfix">
	    <input class="col2 first" type="text" placeholder="Full Name" name="name">                     
	  </div>
	  <div class="form-group clearfix">
	    <input  class="col2 first" type="Email" placeholder="Email" name="email">                     
	  </div>
	  <div class="form-group clearfix">                      
	    <input class="col2 last" type="text" placeholder="Contact Number" name="contact">
	  </div>
	  <button type="submit" class="btn-sbt">
	      <!-- <a href="pdf/dummy.pdf" download style="color: #fff;outline: none;"> submit</a> -->
	      Submit
	    </button>
	</form>
</div>

	<!--footer end menu head-->
	<script>
	var BASE_URL = "http://15.207.231.89";
</script>
<script src="http://15.207.231.89/js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/bootstrap.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/slick/slick.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery-ui.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery.matchHeight.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/fancy.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/api.js" type="text/javascript"></script>  
<script src="http://15.207.231.89/js/jquery.validate.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/wow.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/additional-methods.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/jquery.cookie.min.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/index.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(".scrollbarhai").mCustomScrollbar({
		axis:"y"
	});
		new WOW().init();

	// $("[data-fancybox='login-pop']").fancybox({
	//     iframe : {
	//         css : {
	//             width : '650px',
	//             height :'650px'
	//         }
	//     }
	// });
	$('[data-fancybox]').fancybox({
	  closeExisting: true,
	  loop: true
	});
</script>
<script src="http://15.207.231.89/js/bootstrap3-typeahead.min.js"></script>
<script src="http://15.207.231.89/js/bootstrap-select.min.js"></script>
<script>
	$(document).ready(function() {
		incrementSpinner();
	});

	function incrementSpinner(){
		$('.btn-number').off("click");
		$('.input-number').off("click");
		$('.input-number').off("change");
		$('.input-number').off("keydown");

		$('.btn-number').click(function(e){
			// alert('click');
			e.preventDefault();

			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='"+fieldName+"']");
			var currentVal = parseInt(input.val());
			//alert(currentVal);
			if (!isNaN(currentVal)) {
				if(type == 'minus') {
					if(currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					} 
					/* if(parseInt(input.val()) == input.attr('min')) {
						$(this).attr('disabled', true);
					} */

				} else if(type == 'plus') {

					if(currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}

				}
			} else {
				input.val(0);
			}
		});
		$('.input-number').focusin(function(){
			$(this).data('oldValue', $(this).val());
		});
		$('.input-number').change(function() {
			minValue =  parseInt($(this).attr('min'));
			maxValue =  parseInt($(this).attr('max'));
			valueCurrent = parseInt($(this).val());
			
			name = $(this).attr('name');
			if(valueCurrent >= minValue) {
				$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the minimum value was reached');
				$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
				$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the maximum value was reached');
				$(this).val($(this).data('oldValue'));
			}
		});
		$(".input-number").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 17, 13, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;	
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	}
</script>

<script src="http://15.207.231.89/js/ajaxWishlist.js" type="text/javascript"></script>
<script>
	var search_texts = '';
	var qField = $('#search_text, #mini_search_text, #mobile-search');
	var qFieldTypeBox = qField.typeahead({
		source: function(query, getData){
			setTimeout(function(){ // for fast typing, delay
				var categoty = $('select[name="categories"]').val();
				search_texts = $('input#search_text').val();
				var aTest = $.ajax({
					url:"http://15.207.231.89/search_product.php?cat="+categoty,
					type:"get",
					data:{q:query},
					success: function(response){
						console.log(response);
						// alert(response); // TEST
						var response = response.split("D#K");
						getData(response);
					},
					error: function(response){
						getData(["Unable to get results please try again"]);
					},
					complete: function(){
					}
				});
			}, 1000);
		},
		showHintOnFocus:false,
		// delay:100,
		autoSelect:false,
		afterSelect: function(e, f, g) {
			qField.val(e);
			setTimeout(function() {
				$("#searchFrm").submit();
				//alert(search_texts);
				//window.location.href = "http://15.207.231.89/listing-search?product_id="+search_text;
			}, 10);
		}
	});
</script>
<script src="http://15.207.231.89/js/ajax-update-cart.js" type="text/javascript"></script>
<script src="http://15.207.231.89/js/ajaxWishlist.js" type="text/javascript"></script>	<script>
		/*  $('.cartListingBtn').on('click',function(){
			setTimeout(function(){
				window.location="http://15.207.231.89/cart.php";
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
         		url:"http://15.207.231.89/product-filter.inc.php",
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
         		url:"http://15.207.231.89/product-filter.inc.php",
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