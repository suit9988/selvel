<?php 
include_once 'include/functions.php';
$functions = new Functions();
?>
<!DOCTYPE>

<html>
	<head>
		<title>SELVEL - Why Selvel</title>
		<meta name="description" content="SELVEL">
		<meta name="keywords" content="SELVEL">
		<meta name="author" content="SELVEL">
		<?php include("include/header-link.php");?>
	</head>
   	<body class="inner-page" id="abouts-page">
		<!--Top start menu head-->       
		<?php include("include/header.php");?>
		<!--Main Start Code Here-->
		<main class="main-inner-div">
		<?php  					
		$q_about = $functions->query("SELECT * FROM ".PREFIX."about_us");   
		$row_about=$functions->fetch($q_about);
		?>
			<div class="breadcum-header">
				<ul>
					<li>
						<a href="#">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#" class="current-page">About Selvel</a>                  
					</li>
				</ul>
			</div>
			<section class="about-section wow fadeInUp" >
				<div class="">
               		<h2 class="about-toel"><em>Giving shape to life!</em></h2>
				</div>
			</section>
			<!--<div class="breadcum-header" style="background-color: #453194;padding: 22px 37px;">-->
			<!--	<div class="row">-->
			<!--		<div class="col-md-4 col-xs-4"><h3 align="center"><a href="about-us.php" style="text-align: center; color: #fff">Why Selvel?</a></h3></div>-->
			<!--		<div class="col-md-4 col-xs-4"><h3 align="center"><a href="why-selvel.php" style="text-align: center; color: #fff; padding-bottom: 5px;-->
   <!-- border-bottom: 1px solid #CADB2A;">Our Story</a></h3></div>-->
			<!--		<div class="col-md-4 col-xs-4"><h3 style="text-align: center; color: #fff"><a href="contact-us.php" style="text-align: center; color: #fff">Reach Us</a></h3></div>-->
			<!--	</div>-->
			<!--</div>-->
			<div class="tab-header">
			<div class="row">
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="about-us.php" style="text-align: center; color: #fff;">Why Selvel?</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="why-selvel.php" style="text-align: center; color: #fff; padding-bottom: 5px;
    border-bottom: 1px solid #CADB2A;">Our Story</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 style="text-align: center; color: #fff"><a href="contact-us.php" style="text-align: center; color: #fff">Reach Us</a></h3></div>
			 </div>
         </div>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">
						<div style="width:50%" class=" abts-img">
							<img src="images/why1.jpg" class="img-full">
							<h1 class="floating_year_bw">1992</h1>
						</div>
						<div style="width:50%" class=" abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3 style="font-s">Mr. C.K. Jain laid the foundation of SELVEL at the age of 52</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">						
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>The sons of Mr. C. K. Jain joined the organization</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
						<div style="width:50%" class="abts-img">
							<img src="images/why1.jpg" class="img-full">
							<h1 class="floating_year_bw_right">1997</h1>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">
						<div style="width:50%" class=" abts-img">
							<img src="images/why2.png" class="img-full">
							<h1 class="floating_year_bw">2002</h1>
						</div>
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>Expanded the brand Globally by establishing strong market presence</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">						
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>Created break-through innovative designed products and developed a niche in the market for quality designs</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</h4>                       
							</div>
						</div>
						<div style="width:50%" class="abts-img">
							<img src="images/why3.png" class="img-full">
							<h1 class="floating_year_bw_right">2005</h1>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">
						<div style="width:50%" class="abts-img">
							<img src="images/why2.png" class="img-full">
							<h1 class="floating_year_bw">2008</h1>
						</div>
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>Setup a manufacturing plants in Daman</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">						
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>Nominated for one of the best suppliers in Bharti - Walmart Pvt Ltd</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate</h4>                       
							</div>
						</div>
						<div style="width:50%" class="abts-img">
							<img src="images/why3.png" class="img-full">
							<h1 class="floating_year_bw_right">2011</h1>
						</div>
					</div>
				</div>
			</section>
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">
						<div style="width:50%" class="abts-img">
							<img src="images/why4.png" class="img-full">
							<h1 class="floating_year_bw">2015</h1>
						</div>
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>Launched a new range of products and expanded the portfolio</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
					</div>
				</div>
			</section>
			
			<section class="about-section wow fadeInUp" id="about-section-sub">
				<div class="container">
					<div class="about-flex-s wow fadeInUp">						
						<div style="width:50%" class="abtdesd">
							<div class="abot-reach-text-sels why_bw">
								<h3>One of the leading exporters in the Middle East and Africa</h3>
								<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
							</div>
						</div>
						<div style="width:50%" class="abts-img">
							<img src="images/why5.png" class="img-full">
							<h1 class="floating_year_bw_right">2017</h1>
						</div>
					</div>
				</div>
			</section>
			
			<br><br>   
		</main>
		<?php include("include/footer.php");?> 
		<?php include("include/footer-link.php");?>
	</body>
</html>