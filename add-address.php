<?php 
	include_once("include/functions.php");
	$functions = New Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
		exit;
	}

	if(isset($_GET['q']) && !empty($_GET['q'])){
		$id = $functions->escape_string($functions->strip_all($_GET['q']));
		$addressDetails = $functions->getUniqueCustomerAddressById($id, $loggedInUserDetailsArr['id']);
	}
	$billing='';
	if(isset($_POST['Billing']) && !empty($_POST['Billing'])){
		$billing = $_POST['Billing'];
		$billing = "&$billing=$billing";
	}
	$shipping = '';
	if(isset($_POST['shipping']) && !empty($_POST['shipping'])){
		$shipping = $_POST['shipping'];
		$shipping = "&$shipping=$shipping";
	}
	if(isset($_GET['hideBack'])){
		$addAtt = 'hideBack';
	}else{
		$addAtt='';
	}
	if(isset($_POST['addAddress'])){
		if(isset($_POST['pincode']) && !empty($_POST['pincode'])){
			/*$deliveryApplicable =  $functions->isDeliveryAvilabelForthisPincode($_POST['pincode']);
			if($deliveryApplicable){*/
				$functions->addCustomerAddress($_POST, $loggedInUserDetailsArr['id']);
				// echo '<script type="text/javascript">window.parent.location.href="my-addressbook.php?success";parent.jQuery.fancybox.close();</script>';
				header("location: add-address.php?success&$addAtt$billing$shipping");
				exit;
			/* }else{
				
				header("location:add-address.php?NDELIVERY");
				exit;
			}  */
		}else{
			header("location:add-address.php?INVALIDPINCODE");
			exit;
		} 
		
	}  
	if(isset($_POST['id']) && !empty($_POST['id'])){

		if(isset($_POST['pincode']) && !empty($_POST['pincode'])){

			/*$deliveryApplicable =  $functions->isDeliveryAvilabelForthisPincode($_POST['pincode']);   
			if($deliveryApplicable){*/
				$functions->updateCustomerAddress($_POST, $loggedInUserDetailsArr['id']);
				// echo '<script type="text/javascript">window.parent.location.href="my-addressbook.php?success";parent.jQuery.fancybox.close();</script>';
				header("location: add-address.php?$addAtt$billing$shipping&q=".$id."&success");
				exit;
			/*}else{
				header("location:add-address.php?NDELIVERY");
				exit;
			}*/
		}else{
			header("location:add-address.php?INVALIDPINCODE");
			exit;
		}
	}
	$cityRS = $functions->getListOfCities();
	$stateRS = $functions->getListOfStates();
	$addrssType ='';
	if(isset($_GET['Billing'])) {
		$addrssType = 'Billing';
	}
	if(isset($_GET['shipping'])) {
		$addrssType = 'shipping';
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
	   <style>
	   
	   #line{
			border-bottom: 2px #ccc solid;
			overflow:visible;
			height:9px;        
			margin: 5px 0 10px 0;
		}
		#line span{
			background-color: white;        
			padding: 0 5px;
		}
	   </style>

   </head>

   <body class="inner-page dashboard-pages add-address-page" id="add-address">

      <!--Top start menu head-->       

      <!--Main Start Code Here-->

      <main class="main-inner-divs">

         <div class="change-address-div signup">

                <?php
                if(isset($_GET['success'])){ ?>
                <br>
                    <div class="alert alert-success">
                        <p><i class="fa fa-check"></i> Address saved successfully</p>
                    </div>
                <?php   
                } ?>
                        <form class="form" id="addAddress" method="post" novalidate="novalidate">

                    <div class="row">
						<h3 id="line"><span>Contact Information</span></h3><br>
                        <div class="col-md-6 col-sm-6">

                            <div class="form-group">

                                <input type="text" class="form-control" placeholder="First Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; }else{ echo $loggedInUserDetailsArr['first_name']; } ?>">

                            </div>

                        </div>
						<div class="col-md-6 col-sm-6">

                            <div class="form-group">

                                <input type="text" class="form-control" placeholder="Last Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; }else{ echo $loggedInUserDetailsArr['last_name']; } ?>">

                            </div>

                        </div>

                        

                  		<div class="clearfix"></div>

                        <div class="col-md-12 col-sm-12">

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="customer_email" value="<?php if(isset($addressDetails['customer_email'])){ echo $addressDetails['customer_email']; } ?>">

                            </div>

                        </div>
						<div class="clearfix"></div>
						
                        
						<div class="col-md-12 col-sm-12">

                            <div class="form-group">

                                <label>Enter your Contact No.<em>*</em></label>

                                <input type="text" class="form-control" placeholder="Enter your Contact No." name="customer_contact" value="<?php if(isset($addressDetails['customer_contact'])){ echo $addressDetails['customer_contact']; }else{ echo $loggedInUserDetailsArr['mobile']; } ?>">

                            </div>

                  		</div>

						<h3><span>New Address</span></h3><br>
						<div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" required="" placeholder="Address" name="address1"  value="<?php if(isset($addressDetails['address1'])){ echo $addressDetails['address1']; } ?>">
                            </div>
                  		</div>
						<div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Apartment Number, Suite, Etc ( Optional ) " name="address2"  value="<?php if(isset($addressDetails['address2'])){ echo $addressDetails['address2']; } ?>">
                                <span class="bar"></span>
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
								<select name="state" class="form-control" required="required" onchange="getShippingCity(this.value)">
								   <option value="">Please Select State</option>
								   <?php
										$stateRS = $functions->getListOfStates();
										while($stateRow = $functions->fetch($stateRS)) {
									?>
											<option value="<?php echo $stateRow['statename'] ?>" <?php if(isset($addressDetails) and ($stateRow['statename']==$addressDetails['state'] || ucwords($stateRow['statename'])==ucwords($addressDetails['state']))) { echo "selected"; } ?>><?php echo ucwords($stateRow['statename']) ?></option>
									<?php
										}
									?>
                           	 	</select>
                            </div>
                  		</div>
                        <div class="col-md-4 col-sm-4">

                            <div class="form-group">

                        <select required="" class="form-control" name="city">

                           <option value="">Please Select City</option>
                           <?php
								if(isset($addressDetails)) {
									$state = $functions->escape_string($functions->strip_all($addressDetails['state']));
									$sql="select DISTINCT(name),id from ".PREFIX."states where name='".$state."' order by name";
									$result = $functions->query($sql);
									$stateData =$functions->fetch($result);
									$sql = "SELECT * FROM ".PREFIX."cities WHERE `state_id`='".$stateData['id']."'";

									$cityResult = $functions->query($sql);
									$cityStr='<option value="">Please select city</option>';
									while($cityRow = $functions->fetch($cityResult)){
							?>
										<option value="<?php echo $cityRow['name'] ?>" <?php if($cityRow['name']==$addressDetails['city'] || ucwords($cityRow['name']) == ucwords($addressDetails['city'])) { echo "selected"; } ?>><?php echo $cityRow['name'] ?></option>
							<?php
									}
								}
							?>
                            </select>

                            </div>

                        </div>
						<div class="col-md-4 col-sm-4">

                            <div class="form-group">

                                <input name="pincode" class="form-control" required="required" maxlength="6" type="text" value="<?php if(isset($addressDetails['pincode'])){ echo $addressDetails['pincode']; } ?>">

                                <span class="bar"></span>

                            </div>

                        </div>

                    </div>

                    <div class="pull-left">
                    <?php if(isset($_GET['Billing']) && !empty($_GET['Billing'])){ ?>   
                    <input type="hidden" name="Billing" value="<?php echo $_GET['Billing']; ?>">
                <?php }if(isset($_GET['shipping']) && !empty($_GET['shipping'])){ ?>
                    <input type="hidden" name="shipping" value="<?php echo $_GET['shipping']; ?>">
                <?php } ?>  

                <?php if(isset($_GET['Billing']) || isset($_GET['shipping'])){ ?>
                    <div class="pull-left back-btn">
                        <a href="<?php echo BASE_URL."/checkout-summery-popup.php?".$addrssType."=".$addrssType; ?>" class="shop-now-btn black-btn text-center fancybox-button ">Back</a>
                    </div>
                <?php } ?>
                          
                    </div>

                    <div class="pull-right" style="text-align: center;">
                    <?php 
                    if(isset($addressDetails)){  ?> 
                        <input type="hidden" name="id" value="<?php if(isset($addressDetails['id'])){ echo $addressDetails['id']; } ?>">
                        <input type="submit" class="savechanges shop-now-btn black-btn" name="updateAddress" value="Update Address">
                <?php 
                    }else{ ?>    
                        <input type="submit" class="savechanges shop-now-btn black-btn" name="addAddress" value="Add Address">
                <?php 
                    } ?>        
                                

                    </div>

                    <div class="clearfix"></div>

                </form>

            </div>

      </main>    

      <!--Main End Code Here-->

      <!--footer end menu head-->

      <?php include("include/footer-link.php");?>

      <script></script>
      <script>
        $(document).ready(function(){
            $("#addAddress").validate({
                ignore: ".ignore",
                rules: {
                    customer_fname: {
                        required : true,
                    }, 
                    state: {
                        required:true,
                    }, 
                    city: {
                        required:true,
                    },
                    address1: {
                        required:true
                    },
                    customer_email: {
                        required: true,
                        email:true,
                    },
                    customer_contact: {
                        required: true,
                        number:true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    pincode: {
                        required: true,
                        number:true,
                        minlength: 6,
                        maxlength: 6,
                        /*remote:{
                            url:"<?php echo BASE_URL; ?>/ajaxPincodeValidForDelivery.php",
                            type: "post",
                        }*/
                    },
                    
                },
                messages: {
                    customer_fname: {
                        required: "Please enter name",
                    },
                    state: {
                        required: "Please Select state",
                    },
                    city: {
                        required: "Please Select city",
                    }, 
                    address1: {
                        required: "Please add Address",
                    },
                    customer_contact: {
                        required: "please enter contact number",
                        remote:'Sorry, this contact is already registered.'
                    },
                    pincode: {
                        required: "please enter pincode number",
                        minlength: "please enter valid pincode number",
                        maxlength: "please enter valid pincode number",
                        /*remote:'Sorry, currently we do not deliver on this pincode.'*/
                    },
                    customer_email: {
                        required: 'please enter email address',
                    },
                }
            });
        });
		function getShippingCity(state) {
			$.ajax({
				url:"<?php echo BASE_URL."/ajaxGetCityByState.php" ?>",
				data:{state:state},
				type:"post",
				success: function(response){
					var response = JSON.parse(response);
					$("select[name='city']").html(response.cityStr);
				},
				error: function(){
					alert("Something went wrong, please try again");
				},
				complete: function(response){
					
				}
			});
		}
    </script>
   </body>

</html>