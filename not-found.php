<?php 
   include_once 'include/functions.php';
   $functions = new Functions();
?>
<!DOCTYPE>
<html>
   <head>
      <title>SELVEL - Not Foun</title>
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
		           <a href="#" class="current-page">Not Found</a>                  
		        </li>
		     </ul>
		  </div>

		 <section class="position-contact">
		   <div class="innerwrap container">        
		   <div class="row">
		   
		   		<div class="thankyoubox" style="text-align: center;">
   							<h1>Oops! Page Not Found!</h1>
   									<a class="backtohoem" href="index.php">Back to home</a>
   		                  	<img src="<?php echo BASE_URL; ?>/images/empty.png" class="thanksimg" style="text-align: center;">   		
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