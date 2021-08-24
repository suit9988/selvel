<?php 
	include_once 'include/functions.php';
	$functions = new Functions();
	include_once('blog/wp-load.php');
	$recent_posts = wp_get_recent_posts(array('post_status' =>'publish','numberposts' =>4));
?>
<!DOCTYPE>
	<html>	
	<head>		
		<title>SELVEL - HOME </title>		
		<meta name="description" content="SELVEL">		
		<meta name="keywords" content="SELVEL">		
		<meta name="author" content="SELVEL">		
		<?php include("include/header-link.php");?>	
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style type="text/css">
			.banner-home {
			    padding: 0px;
			}
			.banner-img-slide-new img {
			    width: 100%;
			}
			section#banner-slider {
			    margin-top: 2.5%;
			}
			@media screen and (min-width:1800px) {
				section#banner-slider {
				    margin-top: 13%;
				}

			}
			@media screen and (max-width: 600px){
								.slick-slider .slick-track {
					top: 20px;
					height: auto !important;
				}
			}
			.slick-slider .slick-track{
				top: 20px;
				    height: 429px;
			}
		</style>
	</head>	
	<body class="home">      
		<!--Top sta{rt menu head-->      
		<?php  include("include/header.php");?>      
		<!--Main Start Code Here-->      
		<main class="main-inner-div">                  
		<!-- <img src="images/banner-header.jpg" class="img-full fixedimg"> -->         
		<section class="home-banenr wow fadeInUp" id="banner-slider">            
			<div class="container-fluid" style="overflow-x:hidden">               
				<div class="row"  id="bannerSliderForDSesk">                  
					<div class="col-md-12 banner-home"> 
					<?php  
						$x=1;
						$categoryDetails = $functions->query("SELECT * FROM ".PREFIX."slider_banner where active='1' ORDER BY display_order ASC, id");   
						while($row_cat_sne=$functions->fetch($categoryDetails)){
					?>    
						<div>                        
							<div class="slider-banenr-full">                           						               
								<div class="banner-img-slide-new">                              									
									<a href="<?php echo $row_cat_sne['link']; ?>">
										<img src="images/slider-banner/<?php echo $row_cat_sne['image_name']; ?>">           
									</a>                
								</div>                        
							</div>                     
						</div>  
						<?php 
						$x++;
						} ?>            						
						         
					</div>               
				</div>       
				<div class="row"  id="bannerSliderForMobile">                  
					<div class="col-md-12 banner-home-mob"> 
						<div class="slider-banenr-full">                           						               
							<div class="banner-img-slide-new">                              									
								<a href="https://www.selvelglobal.com/serve">
									<img src="images/mobbanner1.png">           
								</a>                
							</div>                        
						</div>
						<div class="slider-banenr-full">                           						               
							<div class="banner-img-slide-new">                              									
								<a href="https://www.selvelglobal.com/eat">
									<img src="images/mobbanner2.png">           
								</a>                
							</div>                        
						</div>
						<div class="slider-banenr-full">                           						               
							<div class="banner-img-slide-new">                              									
								<a href="https://www.selvelglobal.com/drink">
									<img src="images/mobbanner3.png">           
								</a>                
							</div>                        
						</div>                     						            												        
					</div>               
				</div>            
			</div>
		</section>        
		<section class="grid-section wow fadeInUp" style="overflow-x: hidden;" id="grdisys">         
			<div class="container plr0"> 
				<h2 style="font-family: 'Gotham-Font'; color:#5C5C5C; font-size:35px;" class="large-title-text text-bw left-bw"><span>Categories</span></h2><br>

				<div class="flex-propers">   
					<?php  
						
						$categoryDetails1 = $functions->query("SELECT * FROM ".PREFIX."category_master where active='1' ORDER BY display_order ASC LIMIT 4");   
						while($row_cat_sne1=$functions->fetch($categoryDetails1)){
					?>
					<div class="flex-itemvala" style="background-image: url('images/slider-banner/<?php echo $row_cat_sne1['banner']; ?>')">                  
						<a href="<?php echo $row_cat_sne1['permalink']; ?>">                   
							<!--<h2><?php echo $row_cat_sne1['category_name']; ?></h2>                   -->
							<!--<img src="images/slider-banner/<?php echo $row_cat_sne1['cat_image']; ?>">                   -->
						</a>                
					</div>      
					<?php } ?>					
					<!--
					<div class="flex-itemvala">                  
					<a href="listing.php">                   
					<h2>Drink</h2>                   
					<img src="images/pros2.png">                   
					</a>                
					</div>                
					<div class="flex-itemvala">                  
					<a href="listing.php">                   
					<h2>Serve</h2>                   
					<img src="images/pros3.png">                   
					</a>                
					</div>                
					<div class="flex-itemvala">                 
					<a href="listing.php">                   
					<h2>store</h2>                   
					<img src="images/pros4.png">                   
					</a>                
					</div> -->             
				</div>           
			</div>        
		</section>  
		<section class="top-sellers wow fadeInUp" id="to-sellers">            
			<div class="container">               
				<div class="row">                  
					<div class="col-md-12">                     
						<h2 style="font-family: 'Gotham-Font'; color:#5C5C5C; font-size:35px;" class="large-title-text"><span>Top Sellers</span></h2>
						<div class="sellers-slider">                     
							<?php           
							// $categoryDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE product_id='".$productDetails['id']."' ORDER BY id DESC LIMIT 1"));    
							$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_master WHERE best_seller=1 limit 4");            
							while($rowProductIdList = $functions->fetch($getProductIdDetails)){               
							$productDetails = $functions-> getUniqueProductById($rowProductIdList['id']);               
							$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['id']."' ORDER BY id ASC LIMIT 1"));               
							if($productDetails['active'])
							{ ?>                      
								<div class="produc-main match">
									<div class="img-prods">                        
										<?php $product_link = $functions-> getProductDetailPageURL($productDetails['id'], $getProductsizeDetails['id']); ?>                       
										<a href="<?php echo $product_link; ?>">                       
										<?php
										$file_name = str_replace('', '-', strtolower( pathinfo($getProductsizeDetails['image1_color'], PATHINFO_FILENAME)));								   
										$ext = pathinfo($getProductsizeDetails['image1_color'], PATHINFO_EXTENSION);                       
										?>                       
										<img src="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.jpg'; ?>"  width="250">

											<div class="prohover">
											</div>                
										</a> 
										<div class="pric-cart-add heart_bw " style="top:10px ; z-index: 99;align-items:baseline">                          
											<!-- <span>                          
												<a href="<?php echo $product_link; ?>">                          
												<i class="fa fa-eye"></i>                          
												</a>                           
											</span> -->                                           
											<span class="homewish">                              
											<?php											
											if($loggedInUserDetailsArr = $functions->sessionExists()){                                    
											$wishlistRS = $functions->query("select * from ".PREFIX."customers_wishlist where product_id='".$productDetails['id']."' and customer_id='".$loggedInUserDetailsArr['id']."'");
											if($functions->num_rows($wishlistRS)>0){													
											$hearticon = 'fa-heart-o';												
											} else {													
											$hearticon = 'fa-heart-o';
											}										
											?>                                    
											<a href="javascript: void(0)"  class="clsWishlist" data-id="<?php echo $productDetails['id']; ?>" data-color="<?php echo $productColorArray[0]; ?>" data-size="<?php echo $getProductsizeDetails['size']; ?>" onclick="addToWishList()">                                      
											<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_red.png"> 
											</a>										
											<?php } else { ?>
											<a  class="wishlistbtnnew" href="<?php echo BASE_URL."/login.php";  ?>">
											<img style="width:20px; height:20px" src="https://solvoix.xyz/selvel/include/like_black.png"> </a>	
											<?php } ?>
											</span>                    
										</div>
									</div>	
									<div class="prods-desc">                       
										<h2>                        
										<?php echo $productDetails['product_name'];                         
										// if($getProductsizeDetails['size']){                          
										// echo ' ('.$getProductsizeDetails['size'].')';                        
										// }                        
										$productColorArray = explode(",", $getProductsizeDetails['productcolor']);                        
										?>                        
										</h2>      
										<div class="product-cat-details">
											<h2>Casserole 1500 | Capacity: 1.5L</h2>
										</div>                 
										<div class="prods-price">                        
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
										<div class="pric-cart-add" style="text-align: left; justify-content: flex-start; top:80px;left: 0px">                          
											 <span>                          
												<a href="">                          
												<i class="fa fa-circle" style="color: red"></i>                          
												</a> 
												 <a href="">                          
												<i class="fa fa-circle" style="color: blue"></i>                          
												</a> 
												 <a href="">                          
												<i class="fa fa-circle" style="color: green"></i>                          
												</a> 
											</span>                                            
											                
										</div>                    
									</div>                 
								</div>              
							<?php } } ?>                                  
						</div>                     
					</div>                  
				</div>               
			</div>            
			</div>         
		</section>   
		<?php	
			$q_review = $functions->query("SELECT * FROM ".PREFIX."reviews_master");
			//if($functions->num_rows($q_review)>0) {
				$row_review=$functions->fetch($q_review);
		?>
				<section class="review-section wow fadeInUp" id="review-section">           
					<div class="container">    
						
						
						<div class="flex">
							<div class="w25 sldier-esdp">                      
								<h2 class="why-title">Reviews </h2>
								<h3 class="reviwtwst"> <?php echo $row_review['description'] ?>            </h3>              
							</div>
							<div class="w75 sldier-esdp">                  
								<div class="slider-reviews"> 
									<?php  
							/*
									$q_review1 = $functions->query("SELECT * FROM ".PREFIX."reviews_master");   
									while($row_review1=$functions->fetch($q_review1)){
									?>
									<div class="revie-slide">                          
										<p><?php echo $row_review1['review'] ?>  </p>                        
										<h3><?php echo $row_review1['name'] ?>  </h3>                          
										<h4><?php echo $row_review1['profile'] ?>  </h4>                       
									</div>
									<?php }*/ ?>
									
									<div style="border-radius: 4px;" class="revie-slide"> 
										<img src="https://solvoix.xyz/selvel/include/quatepng.png">
										<p style="color:color: #5C5C5C;">It’s very nice and good product love it. </p>
										<span>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>
										<hr style="margin:0">
										<h3><strong>Naseem Motiwala</strong></h3>
										<h4>Verified Buyer</h4>
										<h4>Product : Keeper Basket</h4>
									</div>
									<div  style="border-radius: 4px;" class="revie-slide">
										<img src="https://solvoix.xyz/selvel/include/quatepng.png">
										<p style="color:color: #5C5C5C;">It’s very nice and good product love it. It’s very nice and good product love it. It’s very nice and good product love it.</p>
										<span>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>
										<hr style="margin:0">
										<h3><strong>Naseem Motiwala</strong></h3>
										<h4>Verified Buyer</h4>
										<h4>Product : Keeper Basket</h4>
									</div>
									<div  style="border-radius: 4px;" class="revie-slide"> 
										<img src="https://solvoix.xyz/selvel/include/quatepng.png">
										<p style="color:color: #5C5C5C;">It’s very nice and good product love it. </p>
										<span>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>
										<hr style="margin:0">
										<h3><strong>Naseem Motiwala</strong></h3>
										<h4>Verified Buyer</h4>
										<h4>Product : Keeper Basket</h4>
									</div>
																
								</div>                  
							</div>                  
							               
						</div>            
					</div>         
				</section>
		<?php
			//}
		?>
		<section class="Why-selvel" id="selvel-why">            
			<div class="flexwidop container">
				<?php  
					
					$categoryDetails11 = $functions->query("SELECT * FROM ".PREFIX."why_selvel_home");   
					$row_cat_sne11=$functions->fetch($categoryDetails11);
				?>
				<div class="w45 plr0 wow fadeInLeft">                 
					<img src="images/why-selvel/<?php echo $row_cat_sne11['main_image'];  ?>" class="img-full desk-only">
				</div>               
				<div class="w55 plr0 selvel-right-why wow fadeInRight">
					<h2 class="why-title"><?php echo $row_cat_sne11['heading'];  ?>?</h2>   
					<img src="images/why-selvel/<?php echo $row_cat_sne11['main_image'];  ?>" class="img-full mobile-only">
					<h3 class="why-italic" style="font-size: 22px;
    color: #5C5C5C;">AFFORDABLE, QUALITY HOMEWARE YOU CAN RELY ON TO OUT-PERFORM AND OUT-LAST THE COMPETITION. </h3>
					<div class="line_bw"></div>
					<div class="reach-text">                     
						<?php //echo $row_cat_sne11['description'];  ?>
						<p style="font-size: 18px;
    color: #5C5C5C;">Selvel has always deliberated on providing the highest quality of products to its users.It is done with a sense of morality and conscientiousness towards its customers,employees and the  environment. The business has been built on strong pillars of care, integrity and transparency. It has adapted to cater the needs of the market with a strong customer centric focus for houseware products.</p>
						             
					</div>                  
					               
				</div>            
			</div>         
		</section>        
	    <section class="about-section wow fadeInUp" id="about-section-sub" style="">

            <div class="container">
               <div class="about-flex-s wow fadeInUp">
					
                  <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						<center><img src="images/142058.jpg"></center>
                        <p style="font-weight: 400;text-align: center; font-size: 22px;
    margin-top: 41px;
    color: #5C5C5C;
    font-family: Gotham Pro;">It’s a Potpourri of Life</p>                     

                     </div>

                  </div>
				   <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						 <center><img src="images/142115.jpg"></center>
                        <p style="font-weight: 400;text-align: center; font-size: 22px;
    margin-top: 41px;
    color: #5C5C5C;
    font-family: Gotham Pro;">Moulded with Love and Crafted with Care</p>                      

                     </div>

                  </div>
				   <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						 <center><img src="images/142126.jpg"></center>
                        <p style="font-family: 'Gotham-Font'; color:#5C5C5C; font-weight: 400;text-align: center; font-size: 22px;
    margin-top: 41px;
    color: #5C5C5C;
    font-family: Gotham Pro;">Environmentally act in an ethical manner</p>                     

                     </div>

                  </div>
					
               </div>

               <div class="w100 commonbtn">              
					<a href="why-selvel" style="font-family: 'Gotham-Font';" class="knowmoere">Know More &nbsp;<img style="transform: translateY(2px);"  src="https://solvoix.xyz/selvel/include/right-arrow.png"></a>
				</div>

            </div>

         </section>
		
		
		<section class="explore-section wow fadeInUp" id="explore-section">            
		<div class="container">               
		<h2 style="font-family: 'Gotham-Font'; font-size:35px; color:#5C5C5C" class="why-title text-center"><span>Articles</span></h2>               
		<!-- <h3 class="exposp">Tag a photo on Instagram with #SelvelLife for a chance to be featured in our gallery!</h3>                -->
		<?php if(isset($recent_posts) && !empty($recent_posts) && count($recent_posts) > 0){ ?>               
		<div class="flex-expo">                           
		<?php                              
		$x=1;                             
		foreach($recent_posts as $key=>$post){  
			if($x>2){
				
			} else {
		?>                             
		<?php 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post['ID']), 'single-post-thumbnail' );                              
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post['ID']));                              
		$author_id=$post->post_author;                            
		?> 
<?php 
		$x++; 
			}
		} ?> 		
		
<div class="img-expo">                             
			<a href="">                                
				                            
				<img style="height:500px"  src="https://solvoix.xyz/selvel/diet.png" class="img-full"> <br><br>
				
			</a>  
			<h3 align="center" style="font-size: 20px; margin-bottom: 13px"><?php echo $post['post_title']; ?></h3>
			<a style="text-align: center; font-size: 15px; color:#5C5C5C" class="article_bw"><u>Read more</u>&nbsp;<img style="transform: translateY(0px);"  src="https://solvoix.xyz/selvel/include/right-arrow.png"></i></a>
		</div> 		
		    <div class="img-expo">                             
			<a href="">                                
				                            
				<img style="height:500px" src="https://solvoix.xyz/selvel/family.png" class="img-full"> <br><br>
				
			</a>   
			<h3 align="center" style="font-size: 20px; margin-bottom: 13px"><?php echo $post['post_title']; ?></h3>
			<a style="text-align: center; font-size: 15px; color:#5C5C5C" class="article_bw"><u>Read more</u> &nbsp;&nbsp;<img style="transform: translateY(0px);"  src="https://solvoix.xyz/selvel/include/right-arrow.png"></i></a>
		</div>                     
		</div>                    
		<?php } ?>
			<div class="w100 commonbtn">              
				<a href="why-selvel; color:#5C5C5C" class="knowmoere">Read All &nbsp;&nbsp;<img src="https://solvoix.xyz/selvel/include/right-arrow.png"></i></a>
			</div>
		</div>         
		</section>      
		</main>      <!--Main End Code Here-->      
		<!--footer start menu head-->      
		<?php include("include/footer.php");?>       
		<!--footer end menu head-->      
		<?php include("include/footer-link.php");?>      
		<!-- <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script> -->     
		<!-- <script>$('.grid').masonry({itemSelector: '.grid-item', percentPosition: true});</script> -->   
	</body>   

	<script>
		$(".banner-home-mob").slick({
		    slidesToShow: 1,
		    slidesToScroll: 1,
		    autoplay: !0,
		    autoplaySpeed: 2000,
		    speed: 800,
		    dots: !1,
		    arrows: !1,
		    infinite: !0,
		    fade: !0,
		    cssEase: "linear"
		}),
		$('.sellers-slider').slick({
		 slidesToShow: 4,
		   slidesToScroll: 1,
		   autoplay: true,
		   infinite: false,
		   autoplaySpeed: 2000,
		   responsive: [
			   {
			   	breakpoint: 991,
			   	settings: {
			   		slidesToShow: 2,
			   		slidesToScroll: 1
			   	}
			   },
			   {
			   	breakpoint: 600,
			   	settings: {
			   		slidesToShow: 1,
			   		slidesToScroll: 1,
			   		infinite:true,
			   		arrows:false
			   	}
			   },
		   ]
		});
	$('.cartListingBtn').on('click',function(){         
		/* setTimeout(function(){
		window.location="<?php echo BASE_URL; ?>/cart.php";
		}, 200);       */
	});            
	
	$("#become-form").validate({rules: {    
	name: {required: true},    
	email: {required: true,email: true},  
	phone: {required: true,number: true},    
	message: {required: true },
	}
	,messages: {
	name: { required: "Please enter your Name",},    
	email: { required: "Please enter your Email ID", email: "Please enter valid email id" },    
	phone: { required: "Please enter your Contact Number",number: "Please enter valid Contact Number",},    
	message: {required: "Please enter your message",    },
	},});
	
	</script>
	</html>