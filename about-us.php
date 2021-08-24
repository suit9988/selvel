<?php 
include_once 'include/functions.php';
$functions = new Functions();
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - About Selvel</title>

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
<style>
    .abts-img:after {
    content: "";
    top: -12%;
	display:none;
    width: 200px;
    background: #cadb2a;
    height: 125%;
    position: absolute;
    left: 8%;
    z-index: -1;
}
</style>

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
		 <div class="tab-header">
			<div class="row">
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="about-us.php" style="text-align: center; color: #fff; padding-bottom: 5px;
    border-bottom: 1px solid #CADB2A;">Why Selvel?</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="why-selvel.php" style="text-align: center; color: #fff">Our Story</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 style="text-align: center; color: #fff"><a href="contact-us.php" style="text-align: center; color: #fff">Reach Us</a></h3></div>
			 </div>
         </div>
		 <section iud="text-reach-text-sels" class="about-section wow fadeInUp" id="about-section-sub">

            <div class="container">
					<div class="w100 abtdesd">
						<div class="abot-reach-text-sels"><h3 style="font-size: 50px; line-height:70px; margin-top:10px; margin-bottom:10px; " align="center">We Strongly Believe</h3></div><br>
				   </div>
               <div class="about-flex-s wow fadeInUp">
					
                  <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						<center><img height="100px" src="images/081531.jpg"></center>
                        <p class="about-content">The relationship with food is complicated at best, as the key is to understand to both emotions and mental state.</p>                     

                     </div>

                  </div>
				   <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						 <center><img height="100px" src="images/081608.jpg"></center>
                        <p class="about-content">Creating exquisite products and solutions that make home life more enjoyable, harmonious and fulfilling  </p>                      

                     </div>

                  </div>
				   <div class="w30 abtdesd">

                     <div class="abot-reach-text-sels">
						 <center><img height="100px" src="images/081627.jpg"></center>
                        <p class="about-content">Improving the quality of life with easy-to-use products.</p>                     

                     </div>

                  </div>

               </div>

               

            </div>

         </section>
		  <br><br>
		   <div id="breadcum-headeridd" class="breadcum-header">
			<div class="row">
				<div id="breadcum-header-text" class="col-md-12"><h1>We have the courage to care. </h1></div>
			 </div>
         </div>
		  <br>
		  <br>
          <section class="about-section wow fadeInUp" id="about-section-sub">

            <div class="container">

               <div class="about-flex-s wow fadeInUp">

                  <div style="    width: 50%;" class="abts-img">

                     <img src="about_us_mans_iamge.png" class="img-full">

                  </div>

                  <div style="    width: 50%;" class="abtdesd">

                     <div class="abot-reach-text-sels">

                        <h3>EACH PRODUCT OF SELVEL CONTAINS MUCH MORE THAN JUST YOUR FAVORITE FOOD. THEY CONNECT WITH YOUR EMOTIONS WHICH SHAPE YOUR LIFE</h3>
                        <div class="line_bw" style="margin: 36px 0px;"></div>

                        <h4>Selvel has always deliberated on providing the highest quality of products to its users. It is done with a sense of morality and conscientiousness towards its customers, employees and the environment. The business has been built on strong pillars of care, integrity and transparency. It has adapted to cater the needs of the market with a strong customer centric focus for houseware products.</h4>                       

                     </div>

                  </div>

               </div>

               <div class="ex-flex wow fadeInUp">

                  <div class="w45 sames-opint">

                     <span class="cghend"></span>

                      <p>We believe in creating products and services that go beyond user expectations to enrich the quality of their lives. The products and solutions we design touch the lives of millions every day. The team at Selvel is persistently working to shape the customer experiences to improve lives.</p>

                     </p>

                  </div>
				<div class="w10 sames-opint"></div>
				 	<div class="w45 sames-opint">

                     <span class="cghend"></span>

                      <p>At Selvel, products comply with stringent test standards and are manufactured under quality systems. The stringent quality testing norms makes us accomplish the best in class material and product designs. Design, quality and innovation have always been the hallmark of SELVEL ever since its inception. </p>

                     </p>

                  </div>

               </div>

            </div>

         </section>

<br>
		  <br>

           

      </main>

      <!--Main End Code Here-->

      <!--footer start menu head-->

      <?php include("include/footer.php");?> 

      <!--footer end menu head-->

      <?php include("include/footer-link.php");?>



   </body>

</html>