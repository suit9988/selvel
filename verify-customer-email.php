<?php
   include_once 'include/functions.php';
   $functions = new Functions();
   
	if($loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: index.php");
		exit;
	}

	$errorArr = array();
	if(isset($_GET['success'])){
		
	} else if(isset($_GET['v']) && !empty($_GET['v'])){
		$v = $functions->escape_string($functions->strip_all($_GET['v']));
		if( (empty($v) || !preg_match("/^[A-z0-9]{1,}$/", $v)) ){
			$errorArr[] = "INVALIDURL";
		}
		if(count($errorArr)>0){
			$errorStr = implode("|", $errorArr);
			header("location: verify-customer-email.php?error=".$errorStr);
			exit;
		} else {
			$updatedRows = $functions->setUserEmailAsVerified($v);
			if($updatedRows>0){ // user was marked as active
				header("location: verify-customer-email.php?success");
				exit;
			} else { // user already marked as active or user does not exists
				header("location: verify-customer-email.php?error=INVALIDURL");
            	exit;
			}
		}
	}
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
		   							<?php 
		   													if(isset($_GET['success'])) { 
		   												?>	
		   														<h2>Thank you!</h2>
		   														<br>		   														
		   														<p class="thankp"><b>Account Verify Successfully.</b></p>
		   														<br>
		   														<div class="thanksbox">
		   															<p class="thankscontent">
		   															</p>
		   															<a href="<?php echo BASE_URL; ?>">LET'S GET STARTED!</a>
		   														</div>
		   												<?php
		   													}
		   													if(isset($_GET['error']) && $_GET['error']=="INVALIDURL"){ ?>
		   														<p class="thankp" style="color:red;"><b>Verification URL No Logner Active.</b></p>
		   												<?php 
		   													}
		   												?>
		  
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