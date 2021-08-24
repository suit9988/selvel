<?php 
   include_once 'include/functions.php';
   $functions = new Functions();
?>
<!DOCTYPE>
<html>
   <head>
      <title>SELVEL - HOME</title>
      <meta name="description" content="SELVEL">
      <meta name="keywords" content="SELVEL">
      <meta name="author" content="SELVEL">
      <?php include("include/header-link.php");?>
   </head>
   <body class="inner-page">
      <!--Top start menu head-->       
      <?php include("include/header.php");?>
      <!--Main Start Code Here-->
      <main class="main-inner-div">
		  <img src="images/details-banner-header.jpg" class="img-full fixedimg">  
		  <div class="container breadcum-header">
		     <ul>
		        <li>
		           <a href="#">Home</a>
		           <i class="fa fa-angle-right"></i>
		        </li>
		        <li>
		           <a href="#" class="current-page">Thank you</a>                  
		        </li>
		     </ul>
		  </div>

		 <section class="position-contact">
		   <div class="innerwrap container">        
		   <div class="row">
		   	<div class="thankyoubox">
		   		<h1>Thank you!</h1>
		   		<p class="thankp"><b>Thank you for contacting us....Our team shall contact you shortly.</b></p>
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
   </body>
</html>