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
		   
		   		<div class="thankyoubox" style="text-align: center;">
		   							<h1>Thank you!</h1>
		   							<?php 
		   								if(isset($_GET['registersuccess'])){
		   							?>
		   									<p class="thankp"><b>Successfully Registred with us.</b></p>
		   							<?php
		   								} else {
		   							?>
		   									
		   		                  			<img src="<?php echo BASE_URL; ?>/images/logo.png" class="thanksimg" style="text-align: center;">
		   		                  			<div class="thanksbox">
		   		                     			<p class="thankscontent">
		   											<?php if(isset($_GET['txnId']) && !empty($_GET['txnId'])){ ?>
		   												<div class="alert alert-success paymentmessages" role="alert">
		   													Your order with order no "<?php echo $_GET['txnId']; ?>", is placed successfully.
		   												</div>
		   												<p><strong>Note:</strong> Please Check Your Spam Mail if you didn't receive Your Order Email. </p>
		   											<?php } if(isset($_GET['codTxnId']) && !empty($_GET['codTxnId'])){ ?>
		   												<div class="alert alert-success" role="alert">
		   													Your order with order no "<?php echo $_GET['codTxnId']; ?>", is confirmed successfully.
		   												</div>
		   												<p><strong>Note:</strong> Please Check Your Spam Mail if you didn't receive Your Order Email. </p>
		   											<?php } ?>
		   										</p><br><br>
		   										<a href="<?php echo BASE_URL; ?>">Back to Home</a> |   <a href="my-order.php">Go Back to My Orders </a>
		   									</div>
		   							<?php
		   								}
		   							?>
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