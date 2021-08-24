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
	</head>	
	<body class="home">      
		<!--Top start menu head-->      
		<?php  include("include/header.php");?>      
		<!--Main Start Code Here-->      
		<main class="main-inner-div">         
		<img src="images/inner-bg.png" class="img-full fixedimg">         
		<!-- <img src="images/banner-header.jpg" class="img-full fixedimg"> -->         
		<section class="home-banenr wow fadeInUp" id="banner-slider">            
			<div class="container plr0">               
				<div class="row">                  
					<div class="col-md-12 banner-home">     
						<?php  
							$x=1;
							$categoryDetails = $functions->query("SELECT * FROM ".PREFIX."slider_banner where active='1' ORDER BY display_order ASC, id");   
							while($row_cat_sne=$functions->fetch($categoryDetails)){
						?>
						<div>                        
							<div class="slider-banenr ">                           
								<div class="text-banenr">   
									
									<h2><?php echo $row_cat_sne['text']; ?></h2> 
									
									
									<div class="list-cat"> 
										
										<a href="#"><?php echo $row_cat_sne['small_text']; ?></a> 
										
									</div> 
																		
								</div>                           
								<div class="banner-img-slide ">                                             
									<img src="images/slider-banner/<?php echo $row_cat_sne['image_name']; ?>" style="height:380px">                           
								</div>                        
							</div>                     
						</div>  
							<?php 
							$x++;
							} ?>						
						<!--<div>                        
							<div class="slider-banenr">                           
								<div class="text-banenr">                              
									                 
									<div class="list-cat">                                 
										<a href="#">Eat</a> - <a href="#">Drink</a> - <a href="#">Serve</a> - <a href="#">Store</a>                              
									</div>                           
								</div>                           
								<div class="banner-img-slide ">                              
									<img src="images/banne2.png">                           
								</div>                        
							</div>                     
						</div>                     
						<div>                        
							<div class="slider-banenr">                           
								<div class="text-banenr">                              
									                         
									<div class="list-cat">                                 
									<a href="#">Eat</a> - <a href="#">Drink</a> - <a href="#">Serve</a> - <a href="#">Store</a>                              
									</div>                           
								</div>                           
								<div class="banner-img-slide ">                              
									<img src="images/banner3.png" class="">                           
								</div>                        
							</div> 		                    
						</div>  -->                
					</div>               
				</div>            
			</div>
		</section>        
		<section class="grid-section wow fadeInUp" id="grdisys">         
			<div class="container plr0">             
				<div class="flex-propers">   
					<?php  
						
						$categoryDetails1 = $functions->query("SELECT * FROM ".PREFIX."category_master where active='1' ORDER BY display_order ASC LIMIT 4");   
						while($row_cat_sne1=$functions->fetch($categoryDetails1)){
					?>
					<div class="flex-itemvala">                  
						<a href="<?php echo $row_cat_sne1['permalink']; ?>">                   
							<h2><?php echo $row_cat_sne1['category_name']; ?></h2>                   
							<img src="images/slider-banner/<?php echo $row_cat_sne1['cat_image']; ?>">                   
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
		<section class="Why-selvel" id="selvel-why">            
			<div class="flexwidop">
				<?php  
					
					$categoryDetails11 = $functions->query("SELECT * FROM ".PREFIX."why_selvel_home");   
					$row_cat_sne11=$functions->fetch($categoryDetails11);
				?>
				<div class="w45 plr0 wow fadeInLeft">                 
					<img src="images/why-selvel/<?php echo $row_cat_sne11['main_image'];  ?>" class="img-full">
				</div>               
				<div class="w55 plr0 selvel-right-why wow fadeInRight">
					<h2 class="why-title"><?php echo $row_cat_sne11['heading'];  ?></h2>                  
					<h3 class="why-italic"><?php echo $row_cat_sne11['tag_line'];  ?></h3>                  
					<div class="reach-text">                     
						<?php echo $row_cat_sne11['description'];  ?> 
						<div class="commonbtn">              
							<a href="why-selvel.php?action=about-section-sub" class="knowmoere">Know more</a>
						</div>             
					</div>                  
					<div class="flex-why">   
						<?php  
					
					$categoryDetails111 = $functions->query("SELECT * FROM ".PREFIX."why_selvel_home");   
					while($row_cat_sne111=$functions->fetch($categoryDetails111)){
				?>
						<div>                        
							<img src="images/why-selvel/<?php echo $row_cat_sne111['image'];  ?>">                        
							<h3><?php echo $row_cat_sne111['text'];  ?></h3>                     
						</div>
					<?php } ?>						
						<!--<div>                        
							<img src="images/global.png">                        
							<h3>Global</h3>                     
						</div>                     
						<div>                        
							<img src="images/product.png">                        
							<h3>Value</h3>                     
						</div>                     
						<div>                        
							<img src="images/laser-cutting-machine.png">                        
							<h3>Precision</h3>                     
						</div>                     
						<div>                        
							<img src="images/reward.png">                        
							<h3>Premium</h3>                     
						</div>                     
						<div>                        
							<img src="images/heart.png">                        
							<h3>Appeal</h3>                     
						</div>-->                  
					</div>               
				</div>            
			</div>         
		</section>        
		<section class="top-sellers wow fadeInUp" id="to-sellers">            
			<div class="container">               
				<div class="row">                  
					<div class="col-md-12">                     
						<h2 class="large-title-text">THE TOP SELLERS</h2>
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
										<img src="<?php echo BASE_URL.'/images/products/'.$file_name.'_crop.'.$ext; ?>"  width="250">

											<div class="prohover">
												<img src="<?php echo BASE_URL?>/images/logo.png">
												<h6>Buy Now</h6>
											</div>                
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
										<div class="product-cat-details">
											<h2>Casserole 1500 | Capacity: 1.5L</h2>
										</div>                 
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
											<i class="fa <?php echo $hearticon; ?>"></i> 
											</a>										
											<?php } else { ?>
											<a  class="wishlistbtnnew" href="<?php echo BASE_URL."/login.php";  ?>">
											<i class="fa fa-heart"></i> </a>
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
							<?php } } ?>                                  
						</div>                     
					</div>                  
				</div>               
			</div>            
			</div>         
		</section>         
		<section class="become-dstri wow fadeIn" id="become-dstri">            
		<div class="become-flex">               
		<div class="w45 become-image">                  
		<img src="images/image-become.png">               
		</div>               
		<div class="w55 become-text">                  
		<div>                     
		<h3>                        write us to                     </h3>                     
		<h2 class="why-title">                        Become a Distributor                     </h2>                     
		<h4>                        Or just to know more                     </h4>                  
		</div>                  
		<div class="form-become">                     
		<form id="become-form" action="<?php echo BASE_URL; ?>/distributor.php" method="POST">                        
			<div class="flexform">                           
				<div class="form-left w50">                              
					<div class="form-group">                                            
						<input type="text" class="form-control" name ="name" id="name" placeholder="Name">                                     
					</div>                              
					<div class="form-group">                                            
						<input type="tel" class="form-control" name ="contact" id="phone" placeholder="Phone">                                     
					</div>                              
					<div class="form-group">                                           
						<input type="url" class="form-control" name ="website" id="website" placeholder="Website">                                    
					</div>                          
				</div>                           
				<div class="form-right w50">                              
					<div class="form-group">                                            
						<input type="email" class="form-control" name="email" id="email" placeholder="Email">                                     
					</div>                              
					<div class="form-group">                                           
						<textarea rows="5" name="msg" placeholder="Your Message"></textarea>
					</div>
				</div>                        
			</div>
			<div class="commonbtn">                            
				<button type="submit" name="send">Submit</button>
			</div>                 
		</form>                
		</div>
		</div>
		</div>       
		</section>
		<?php	
			$q_review = $functions->query("SELECT * FROM ".PREFIX."reviews_master");
			if($functions->num_rows($q_review)>0) {
				$row_review=$functions->fetch($q_review);
		?>
				<section class="review-section wow fadeInUp" id="review-section">           
					<div class="container">    
						
						<h2 class="why-title"> <?php echo $row_review['heading'] ?>  </h2>
						<h3 class="reviwtwst"> <?php echo $row_review['description'] ?>            </h3>
						<div class="flex">
							<div class="w55">                  
								<div class="slider-reviews"> 
									<?php  
							
									$q_review1 = $functions->query("SELECT * FROM ".PREFIX."reviews_master");   
									while($row_review1=$functions->fetch($q_review1)){
									?>
									<div class="revie-slide">                          
										<p><?php echo $row_review1['review'] ?>  </p>                        
										<h3><?php echo $row_review1['name'] ?>  </h3>                          
										<h4><?php echo $row_review1['profile'] ?>  </h4>                       
									</div>
									<?php } ?>
									<!--
									<div class="revie-slide">                          
									<p>Good for.gifting purposes also. The cover is thickly padded and leak proof. It is really a very good product in the said price. Value for money</p>
									<h3>Shweta Kasle</h3>
									<h4>Developer</h4>
									</div>
									<div class="revie-slide">
									<p>
									It is really a very good product in the said price. Value for money. Good for.gifting purposes also. The cover is thickly padded and leak proof.</p>                         
									<h3>Mansi Kasle</h3>
									<h4>Designer</h4>
									</div>
									<div class="revie-slide">
									<p>Good for.gifting purposes also. The cover is thickly padded and leak proof. It is really a very good product in the said price. Value for money</p>                          
									<h3>Deepak Kasle</h3>                          
									<h4>Developer</h4>                       
									</div>  
									-->							
								</div>                  
							</div>                  
							<div class="w45 sldier-esdp">                      
								<div class="slider-reviews-nav">    
									<?php  
							
									$q_review2 = $functions->query("SELECT * FROM ".PREFIX."reviews_master");   
									while($row_review2=$functions->fetch($q_review2)){
									?>
									<div class="reviews-nav-slide">                           
										<img src="images/review/<?php echo $row_review['banner'] ?> ">                        
									</div>
									<?php } ?>
									<!--
									<div class="reviews-nav-slide">                           
										<img src="images/review-img-bg.png">                        
									</div>                       
									<div class="reviews-nav-slide">                           
										<img src="images/review-img-bg.png">                        
									</div>                       
									<div class="reviews-nav-slide">                           
										<img src="images/review-img-bg.png">                        
									</div>  
									-->
								</div>                  
							</div>               
						</div>            
					</div>         
				</section>
		<?php
			}
		?>
		<section class="explore-section wow fadeInUp" id="explore-section">            
		<div class="container">               
		<h2 class="why-title text-center">Explore</h2>               
		<!-- <h3 class="exposp">Tag a photo on Instagram with #SelvelLife for a chance to be featured in our gallery!</h3>                -->
		<?php if(isset($recent_posts) && !empty($recent_posts) && count($recent_posts) > 0){ ?>               
		<div class="flex-expo">                           
		<?php                              
		$x=1;                             
		foreach($recent_posts as $key=>$post){                            
		?>                             
		<?php 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post['ID']), 'single-post-thumbnail' );                              
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post['ID']));                              
		$author_id=$post->post_author;                            
		?>                          
		<div class="img-expo">                             
			<a href="<?php echo get_permalink($post['ID']); ?>">                                
				<div class="explore-text">
					<h4><?php echo $post['post_title']; ?></h4>
				</div>                              
				<img src="<?php echo $feat_image; ?>" class="img-full"> 

			</a>                      
		</div>                          
		<?php 
		$x++; 
		} ?>                        
		</div>                    
		<?php } ?>            
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
		$('.sellers-slider').slick({
		 slidesToShow: 3,
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