<?php 	
include_once("include/functions.php");
	$functions = New Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
		exit;
	}

	if(isset($_POST['id']) && !empty($_POST['id'])){
		$functions->updateRegisteredUser($_POST, $loggedInUserDetailsArr['id']);
		header("location: my-account.php?success");
		exit;
    }
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - My Account</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page dashboard-pages" id="my-account">

      <!--Top start menu head-->       

      <?php include("include/header.php");?>

      <!--Main Start Code Here-->

      <main class="main-inner-div">     

         <div class="container breadcum-header">

            <ul>

               <li>

                  <a href="#">Home</a>

                  <i class="fa fa-angle-right"></i>

               </li>

                <li>

                  <a href="#" class="current-page">My Account</a>                  

               </li>

            </ul>

         </div>

        <section class="dasboard-inner orderreceived">

            <div class="container">

              <div class="ac-detail-nav-box">

                <ul class="ac-detail-nav" id="myacnav">

                  <li class="active"><a href="my-account.php"> My Account</a></li>

                  <li><a href="my-order.php">My Orders</a></li>

                  <li><a href="my-wishlist.php"> Wishlist</a></li>

                  <div class="clearfix"></div>

                </ul>

              </div>

              <div class="row">

                <div class="inner-content bt my-ac-block">

                  <div class="container">

                    <div class="row flex-col">

                      <div class="col-md-8 logmain-in login-div">
                      		<?php 
						     if(isset($_GET['success'])){ ?>
							<div class="alert alert-success">
                            	Thank You. Your Information is Updated.
                          	</div>
				      	   	<?php	} ?>
                        <div class="login-box-account">

                          <h2>Contact Information <span style="float: right;font-size: 12px;" id="btyyu"><a data-fancybox data-src="#edit-in-pop" href="javascript:;">Edit</a></span></h2>
							
							<div style="block"  id="edt_byt">
							<p style="margin-top: 10px;"><strong>Name</strong> : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loggedInUserDetailsArr['first_name']; ?></p>
							<p style="margin-top: 10px;"><strong>Email</strong> : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loggedInUserDetailsArr['email']; ?></p>
							<p style="margin-top: 10px;"><strong>Contact Number</strong> : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loggedInUserDetailsArr['mobile']; ?></p>
							</div>

                          

                        </div>
						  <br>
						  <div class="login-box-account"><h2>Address Book <span style="float: right;font-size: 12px;" > <a class="btn address-btn" data-fancybox="" data-type="iframe" data-src="add-address.php" href="javascript:;">+&nbsp;&nbsp;Add Address</a></span></h2></div>
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
						  <div class="col-md-12  col-sm-12 all-address-here" >
							
                        <div class="row">
                        <?php 
								$userAddressData = $functions->getAddressByuserId($loggedInUserDetailsArr['id']);
								if($functions->num_rows($userAddressData)>0) {
									while($addressDetails = $functions->fetch($userAddressData)) {
							   ?>
                           <div class="col-lg-4 col-md-6 col-sm-6 all-address-sub" style="">

                              <div class="field-box match" style="height: 210px;border: 1px solid #453194;padding: 10px; border-radius: 5px">

                                 <div class="field">
                                    <h3 style="font-size: 26px;"><?php echo ucwords($addressDetails['customer_fname']); ?></h3>
                                </div><br>
                                 <div class="field">

                                    <h5><strong>Phone Number</strong></h5>

                                    <p><a href="tel:<?php echo $addressDetails['customer_contact']; ?>"><?php echo $addressDetails['customer_contact']; ?></a></p>

                                 </div><br>
                                 <div class="field">

                                    <h5><strong>Address</strong></h5>

                                    <p> <?php echo $addressDetails['address1'];  ?>, <?php echo $addressDetails['address2'];  ?>, <?php echo $addressDetails['state'];  ?> </p>

                                 </div><br>

                                 <!--<div class="field edit-field">
                                    <ul class="list-inline field-btn-grp">
                                       <li><a class="change-address address-btn" data-fancybox="" data-type="iframe" data-src="<?php echo BASE_URL; ?>/add-address.php?q=<?php echo $addressDetails['id'] ?>" href="javascript:;">Edit Address</a></li>
                                       <li><a onclick="return confirm('Are you sure you want to delete this address?');" class="change-address" href="<?php echo BASE_URL.'/my-address-book.php?delId='.$addressDetails['id'] ?>"></a></li>
                                    </ul>
                                 </div>-->

                                 <div class="field default-field">

                                 <?php 
									if($addressDetails['setDefault']){
								?>
										<a href="javascript:;" class="setadif">Default Address</a>
								<?php 
									} else{ ?>
										<a onclick="return confirm('Are you sure you want set default address?');" href="<?php echo BASE_URL."/my-address-book.php?setDetaultAddress&id=".$addressDetails['id']; ?>" class="seta" style="color:#453194"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;&nbsp;<strong>Set As Default</strong></a>
								<?php 	
									} ?>
                                 </div>

                              </div>
								<center><img src="images/delete-add.png" style="border: 1px solid;padding: 7px;border-radius: 50%;"></center>
                           </div>
							
                           <?php } } ?>
                           
                         

                           <div class="clearfix"></div>
                        </div>

                     </div>
						  <br>
						  <div class="login-box-account">
							  <h2>Privacy</h2>
							  <p style="margin-bottom: 8px;"><a data-fancybox data-src="#change-in-pop" href="javascript:;">Change Password</a></p>
							  <p style="margin-bottom: 8px;"><a data-fancybox data-src="" href="javascript:;">Unsubscribe Newsletter</a></p>
							  <p style="margin-bottom: 8px;"><a data-fancybox data-src="" href="javascript:;">Delete Account</a></p>
							</div>
                      </div>

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