<?PHP 
	include_once("include/functions.php");
	$functions = New Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
		exit;
	}

	if(isset($_GET['setDetaultAddress']) && isset($_GET['id']) && !empty($_GET['id'])) {
		$defaultAddress = $functions->setAsDefaultAddress($_GET,$loggedInUserDetailsArr);
		if($defaultAddress) {
			header("location: my-address-book.php?successDefault");
			exit;
		} else {
			header("location: my-address-book.php?failureDefault");
			exit;
		}
	}
	if(isset($_GET['delId']) && !empty($_GET['delId'])) {
		$delId = $functions->escape_string($functions->strip_all($_GET['delId']));
		$sql = "DELETE FROM ".PREFIX."customers_address WHERE id='".$delId."'";
		$functions->query($sql);
		header("location: my-address-book.php?deletSuccess");
		exit;
    }
    
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - My Address Book</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page dashboard-pages" id="address-book">

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

                  <a href="#" class="current-page">Address Book</a>                  

               </li>

            </ul>

         </div>

         <section class="orderreceived myaddressbook">

            <div class="inner-content bt">

               <div class="container">

                  <div class="ac-detail-nav-box">

                     <ul class="ac-detail-nav" id="myaddnav">

                        <li><a href="my-account"><i class="fa fa-user-o" aria-hidden="true"></i>  My Account</a></li>

                        <li><a href="my-order"><i class="fa fa-list-ul" aria-hidden="true"></i>My Orders</a></li>

                        <li><a href="my-wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Wishlist</a></li>

                        <li  class="active"><a href="my-address-book"><i class="fa fa-map-marker" aria-hidden="true"></i> Address Book</a></li>

                        <div class="clearfix"></div>

                     </ul>

                  </div>

                  <div class="row">
                  <?php 
						if(isset($_GET['successDefault'])){
					   ?>
							<div class="alert alert-success">
								<p><i class="fa fa-check"></i>Address successfully marked as default billing address.</p>
							</div>
					   <?php
						} if(isset($_GET['deletSuccess'])) {
				   	?>
							<div class="alert alert-success">
								<p><i class="fa fa-check"></i>Address successfully deleted.</p>
							</div>
					   <?php 	
						} if(isset($_GET['success'])) {
					   ?>
							<br>
							<div class="alert alert-success">
								<p><i class="fa fa-check"></i> Address saved successfully</p>
							</div>
					   <?php   	
						   }
					   ?>
                     <div class="col-md-12  col-sm-12 all-address-here">

                        <div class="row">
                        <?php 
								$userAddressData = $functions->getAddressByuserId($loggedInUserDetailsArr['id']);
								if($functions->num_rows($userAddressData)>0) {
									while($addressDetails = $functions->fetch($userAddressData)) {
							   ?>
                           <div class="col-lg-4 col-md-6 col-sm-6 all-address-sub">

                              <div class="field-box match" style="height: 299px;">

                                 <div class="field">

                                    <h5>Name</h5>

                                    <p><?php echo ucwords($addressDetails['customer_fname']); ?></p>


                                 </div>

                                 <div class="field">

                                    <h5>Contact</h5>

                                    <p><a href="tel:<?php echo $addressDetails['customer_contact']; ?>"><?php echo $addressDetails['customer_contact']; ?></a></p>

                                 </div>

                                 <div class="field">

                                    <h5>Address</h5>

                                    <p> <?php echo $addressDetails['address1'];  ?>, <?php echo $addressDetails['address2'];  ?>, <?php echo $addressDetails['state'];  ?> </p>

                                 </div>

                                 <div class="field edit-field">
                                    <ul class="list-inline field-btn-grp">
                                       <li><a class="change-address address-btn" data-fancybox="" data-type="iframe" data-src="<?php echo BASE_URL; ?>/add-address.php?q=<?php echo $addressDetails['id'] ?>" href="javascript:;">Edit Address</a></li>
                                       <li><a onclick="return confirm('Are you sure you want to delete this address?');" class="change-address" href="<?php echo BASE_URL.'/my-address-book.php?delId='.$addressDetails['id'] ?>"><img src="images/delete-add.png"></a></li>
                                    </ul>
                                 </div>

                                 <div class="field default-field">

                                 <?php 
														if($addressDetails['setDefault']){
													?>
															<a href="javascript:;" class="setadif">Default Address</a>
													<?php 
														} else{ ?>
															<a onclick="return confirm('Are you sure you want set default address?');" href="<?php echo BASE_URL."/my-address-book.php?setDetaultAddress&id=".$addressDetails['id']; ?>" class="seta">Set As Default</a>
													<?php 	
														} ?>
                                 </div>

                              </div>

                           </div>
                           <?php } } ?>
                           
                         

                           <div class="clearfix"></div>

                           <a class="btn address-btn" data-fancybox="" data-type="iframe" data-src="add-address.php" href="javascript:;">Add Address</a>

                        </div>

                     </div>

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

      <script>

         $('.address-btn').fancybox({

                     iframe : {

                        css : {

                           width : '800px',

                        }

                     },

                     buttons : [

                        'close'

                     ],

                     afterClose: function () {

                        parent.location.reload(true);

                     }

                  });

         setTimeout(function() {
             $('.alert').fadeOut('fast');
         }, 4000); 

      </script>

   </body>

</html>