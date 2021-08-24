<?php 
	$basename = basename($_SERVER['REQUEST_URI']);	
	$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
	$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
?>
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<?php
					$customerPages = array(
						'customer-master.php',
						'customer-add.php',
						'order.php',
						'order-add.php',
						'cancel-requests.php',
						'testimonials.php',
						'testimonial-add.php',
						'newsletter.php',
						'notify-products.php',
					);
				?>
				<?php if(in_array('order_view', $userPermissionsArray) or in_array('cancel_view', $userPermissionsArray) or in_array('notify_view', $userPermissionsArray) or in_array('customer_view', $userPermissionsArray) or in_array('newsletter_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
					<li class="has-ul class <?php if(in_array($currentPage, $customerPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $customerPages)){ echo 'subdrop'; } ?>"><i class="fa fa-users"></i><span>Customers</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $customerPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('order_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="order.php" class="<?php if($currentPage == 'order-add.php' || $currentPage=='banner.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Customer Orders</a>
								</li>
							<?php } ?>

							<?php if(in_array('cancel_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="cancel-requests.php" class="<?php if($currentPage == 'cancel-requests.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Cancel Requests</a>
								</li>
							<?php } ?>

							<?php if(in_array('notify_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
							<li><a href="notify-products.php" class="<?php if($currentPage == 'notify-products.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
								Notify Products</a>
							</li>
							<?php } ?>

							<?php if(in_array('customer_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="customer-master.php" class="<?php if($currentPage == 'customer-master.php' || $currentPage=='customer-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Customer Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('newsletter_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li ><a href="newsletter.php" class="<?php if($currentPage == 'newsletter.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Newsletter Subscription</a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php
					$productPages = array(
						'index.php',
						'product-add.php',
						'reviews.php',
						'review-add.php',
					);
				?>
				<?php if(in_array('product_view', $userPermissionsArray) or in_array('review_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
					<li class="has-ul class <?php if(in_array($currentPage, $productPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $productPages)){ echo 'subdrop'; } ?>"><i class="fa fa-list-alt"></i><span>Products</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $productPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('product_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="index.php" class="<?php if($currentPage == 'product-add.php' || $currentPage=='index.php') { echo 'active'; } ?>">						
									<i class="fa fa-angle-right" aria-hidden="true"></i>Product Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('review_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="reviews.php" class="<?php if($currentPage == 'reviews.php') { echo 'active'; } ?>">
									<i class="fa fa-angle-right" aria-hidden="true"></i>
									Reviews</a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php
					$reportPages = array(
						'most-sold-product.php',
						'least-sold-product.php',
						'sales-report.php',
						'most-viewed-product.php'
					);
				?>
				<?php if(in_array('most_viewed_product', $userPermissionsArray) or in_array('most_sold_product', $userPermissionsArray) or in_array('least_sold_product', $userPermissionsArray) or in_array('sales_product', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
					<li class="has-ul class <?php if(in_array($currentPage, $reportPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $reportPages)){ echo 'subdrop'; } ?>"><i class="fa fa-file-text"></i><span>Reports</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $reportPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('most_viewed_product', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li ><a href="most-viewed-product.php" class="<?php if($currentPage == 'most-viewed-product.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>Most Viewed Product</a></li>
							<?php } ?>

							<?php if(in_array('most_sold_product', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="most-sold-product.php" class="<?php if($currentPage == 'most-sold-product.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Most Sold Products</a>
								</li>
							<?php } ?>

							<?php if(in_array('least_sold_product', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
								<li><a href="least-sold-product.php" class="<?php if($currentPage == 'least-sold-product.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Least Sold Products</a>
								</li>
							<?php } ?>

							<?php if(in_array('sales_product', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="sales-report.php" class="<?php if($currentPage == 'sales-report.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Sales Report</a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php
					$masterPages = array(
						'banner-master.php',
						'category-master.php',
						'category-add.php',
						'sub-category-master.php',
						'sub-category-add.php',
						'sub-category-level2.php',
						'sub-category-level2-add.php',
						'attribute-master.php',
						'attribute-add.php',
						'discount-coupon-master.php',
						'discount-coupon-add.php',
						'shipping-charges.php',
						'banner-master.php',
						'banner-add.php',
						'delivery-pincode.php',
						'delivery-pincode-add.php',
						'feature-master.php',
						'size-master.php',
						'color-master.php',
						'shipping-charges.php'

					);
				?>
				<?php if(in_array('category_view', $userPermissionsArray) or in_array('attribute_view', $userPermissionsArray) or in_array('size_view', $userPermissionsArray) or in_array('color_view', $userPermissionsArray) or in_array('coupon_view', $userPermissionsArray) or in_array('shipping_view', $userPermissionsArray) or in_array('delivery_view', $userPermissionsArray) or in_array('banner_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {	?>
					<li class="has-ul class <?php if(in_array($currentPage, $masterPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $masterPages)){ echo 'subdrop'; } ?>"><i class="fa fa-user-plus"></i><span>Masters</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $masterPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('category_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="category-master.php" class="<?php if($currentPage == 'category-add.php' || $currentPage=='category-master.php' || $currentPage=='sub-category-master.php' || $currentPage=='sub-category-add.php' || $currentPage=='sub-category-level2.php' || $currentPage=='sub-category-level2-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Category Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('attribute_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="attribute-master.php" class="<?php if($currentPage == 'attribute-master.php' || $currentPage=='attribute-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Attribute Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('feature_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="feature-master.php" class="<?php if($currentPage == 'feature-master.php' || $currentPage=='feature-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Features Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('size_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="size-master.php" class="<?php if($currentPage == 'size-master.php' || $currentPage=='size-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Size Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('color_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="color-master.php" class="<?php if($currentPage == 'color-master.php' || $currentPage=='color-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Color Master</a>
								</li>
							<?php } ?>

							<?php if(in_array('coupon_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li ><a href="discount-coupon-master.php" class="<?php if($currentPage == 'discount-coupon-master.php' || $currentPage=='discount-coupon-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Discount Coupon Master</a>
								</li>
							<?php } ?>

							<!-- <?php if(in_array('shipping_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="shipping-charges.php" class="<?php if($currentPage == 'shipping-charges.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Shipping Charges</a>
								</li>
							<?php } ?> -->

							<?php /* if(in_array('delivery_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li ><a href="delivery-pincode.php" class="<?php if($currentPage == 'delivery-pincode.php' || $currentPage=='delivery-pincode-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Delivery Pincodes</a>
								</li>
							<?php } */ ?>

							<?php if(in_array('banner_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li ><a href="banner-master.php" class="<?php if($currentPage == 'banner-master.php' || $currentPage=='banner-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Banner Master</a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php
					$cmsPages = array(                 
						'contact-us.php',
						'distributor.php',
						'corporate.php',
						'catelogue_enquiry.php',
					);
				?>
				<?php if(in_array('contact_enquiry_view', $userPermissionsArray) or in_array('distributor_enquiry_view', $userPermissionsArray) or in_array('gifting_enquiry_view', $userPermissionsArray) or in_array('catalog_enquiry_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
					<li class="has-ul class <?php if(in_array($currentPage, $cmsPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $cmsPages)){ echo 'subdrop'; } ?>"><i class="fa fa-info"></i><span>Enquiries</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $cmsPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('contact_enquiry_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="contact-us.php" class="<?php if($currentPage == 'contact-us.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Contact</a>
								</li>
							<?php } ?>

							<?php if(in_array('distributor_enquiry_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="distributor.php" class="<?php if($currentPage == 'distributor.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Distributors</a>
								</li>
							<?php } ?>

							<?php if(in_array('gifting_enquiry_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="corporate.php" class="<?php if($currentPage == 'corporate.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Corporate Gifting</a>
								</li>
							<?php } ?>

							<?php if(in_array('catalog_enquiry_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="catelogue_enquiry.php" class="<?php if($currentPage == 'catelogue_enquiry.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									E-Catelogue </a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php
					$cmsPages = array(
						'about-us.php',
						'faq-add.php',
						'terms.php',
						'privacy-policy.php',
						'return-policy.php',
						'disclaimer.php',
						'all-you-need.php',
						'home-why-selvel.php',
						'why_selvel.php',
						'faq-add.php',
						'reviews_master.php',
						'contact.php',	
					);
				?>
				<?php if(in_array('home_cms', $userPermissionsArray) or in_array('about_cms', $userPermissionsArray) or in_array('home_reviews_view', $userPermissionsArray) or in_array('why_selvel_cms', $userPermissionsArray) or in_array('milestones_view', $userPermissionsArray) or in_array('contact_cms', $userPermissionsArray) or in_array('terms_cms', $userPermissionsArray) or in_array('refund_cms', $userPermissionsArray) or in_array('faq_view', $userPermissionsArray) or in_array('disclaimer_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
					<li class="has-ul class <?php if(in_array($currentPage, $cmsPages)){ echo 'active'; } ?>">
						<a href="#" class="<?php if(in_array($currentPage, $cmsPages)){ echo 'subdrop'; } ?>"><i class="fa fa-database"></i><span>CMS Pages</span></a>
						<ul class="hidden-ul" style="<?php if(in_array($currentPage, $cmsPages)){ echo 'display:block;'; } ?>">
							<?php if(in_array('home_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="home-why-selvel.php" class="<?php if($currentPage == 'home-why-selvel.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Home</a></li>
							<?php } ?>

							<?php if(in_array('home_reviews_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="reviews_master.php" class="<?php if($currentPage == 'reviews_master.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Home Page Reviews </a></li>
							<?php } ?>

							<?php if(in_array('about_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="about-us.php" class="<?php if($currentPage == 'about-us.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> About Us</a></li>
							<?php } ?>

							<?php if(in_array('why_selvel_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="why_selvel.php" class="<?php if($currentPage == 'why_selvel.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Why Selvel</a></li>
							<?php } ?>

							<?php if(in_array('contact_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="contact.php" class="<?php if($currentPage == 'contact.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> Contact Us</a></li>
							<?php } ?>

							<?php if(in_array('terms_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="terms.php" class="<?php if($currentPage == 'terms.php' || $currentPage=='attribute-add.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Terms and Privacy Policy</a>
								</li>
							<?php } ?>

							<?php if(in_array('refund_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="return-policy.php" class="<?php if($currentPage == 'return-policy.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Return Policy</a>
								</li>
							<?php } ?>

							<?php if(in_array('faq_view', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="faq-add.php" class="<?php if($currentPage == 'faq-add.php') { echo 'active'; } ?>"> <i class="fa fa-angle-right" aria-hidden="true"></i>
									FAQ</a>
								</li>
							<?php } ?>

							<?php if(in_array('disclaimer_cms', $userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<li><a href="disclaimer.php" class="<?php if($currentPage == 'disclaimer.php') { echo 'active'; } ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
									Disclaimer</a>
								</li>
							<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php if($loggedInUserDetailsArr['role']=='super') { ?>
					<li class="<?php if($currentPage == 'user-management.php' || $currentPage=='user-management-add.php') { echo 'active'; } ?>"><a href="user-management.php">
						<i class="fa fa-users"></i> <span>User Access Management</span>
					</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>