<?php 
   include_once 'include/functions.php';
   $functions = new Functions(); 
   $redirect = 'chekout-order-page.php';
   /* if(!$loggedInUserDetailsArr = $functions->sessionExists()){
      header("location: ".BASE_URL."/guest-login.php?redirect=".$redirect);
      exit;
   } */
   if(!$_SESSION[SITE_NAME]['cart']) {
      header("location: index.php");
      exit;
   }
   if(isset($_GET['sameASBilling'])){
      $_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $_SESSION[SITE_NAME]['BILLADDRESS']['Billing'];
      header("location:chekout-order-page.php");
      exit;
   }
   if(isset($_GET['sameASBilling'])){
      if($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']){
         unset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
      }
      header("location:chekout-order-page.php");
      exit;
   }
   
   ?>
<!DOCTYPE>
<html>
   <head>
      <title>SELVEL - Checkout</title>
      <?php include("include/header-link.php");?>
   </head>
   <body class="chekout-order-summary-page inner-page" id="checkoout-new">
      <!--Top start menu head-->       
      <?php include("include/header.php");?>
      <main class="main-inner-div">
         <img src="images/details-banner-header.jpg" class="img-full fixedimg">  
         <div class="container breadcum-header">
            <ul>
               <li>
                  <a href="#">Home</a>
                  <i class="fa fa-angle-right"></i>
               </li>
               <li>
                  <a href="#" class="current-page">Checkout</a>                  
               </li>
            </ul>
         </div>
         <section class="position-contact">
            <div class="inner-content bt checkout-section">
               <div class="container">
                  <div class="inner-wrapper">
                     <!-- <h1 class="page-heading">CHECKOUT</h1> -->
                     <div  class="latest-flex">
                        <form action="process-payment.php" class="form latest-flex" id="addAddress" method="post" novalidate="novalidate">
                           <section class="billing-shipping">
                              <?php
                                 if(!$loggedInUserDetailsArr = $functions->sessionExists()){
                                    ?>
                              <div class="flelops">
                                 <div>
                                    <h2>Contact information</h2>
                                 </div>
                                 <div>
                                    <p class="already">Already registered? <a class="green-text" href="login.php?redirect=chekout-order-page.php">Login Here</a></p>
                                 </div>
                              </div>
                              <?php
                                 }
                                 ?>
                              <?php    
                                 if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){
                                    $defaultAddress = $functions->getAddressById($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
                                 }else{
                                    $defaultAddress = $functions->getPrimaryAddress($loggedInUserDetailsArr['id']);  
                                 }
                                 $addressDetails = $functions->fetch($defaultAddress);
                                 ?>
                              <div class="billing-add match">
                                 <div class="box-inner-ctn">
                                    <div class="new-frosm">
                                       <div class="form-group">
                                          <!-- <label>Email<em>*</em></label> -->
                                          <input type="email" class="form-control" placeholder="Enter your Email Id." name="customer_email" value="<?php if(isset($addressDetails['customer_email'])){ echo $addressDetails['customer_email']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['email']; } else { echo ""; } ?>">
                                       </div>
                                    </div>
                                    <h3>Shipping  Address</h3>
                                    <?php if($loggedInUserDetailsArr = $functions->sessionExists()){ ?>
                                    <div class="form-group selctioosn">
                                       <label>Select address from address book</label>
                                       <a class="checkout-summery-pop" data-fancybox="" data-type="iframe" data-src="" href="<?php echo BASE_URL; ?>/checkout-summery-popup.php?shipping=shipping">
                                       Select Address 
                                       <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                       </a>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                             <label>Enter your Name<em>*</em></label>
                                             <input type="text" class="form-control" placeholder="Enter your Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['first_name']; } else { echo ""; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                             <label>Enter your Contact No.<em>*</em></label>
                                             <input type="text" class="form-control" placeholder="Enter your Contact No." name="customer_contact" value="<?php if(isset($addressDetails['customer_contact'])){ echo $addressDetails['customer_contact']; } else if($loggedInUserDetailsArr) { echo $loggedInUserDetailsArr['mobile']; } else { echo ""; } ?>">
                                          </div>
                                       </div>
                                       <div class="clearfix"></div>
                                       <div class="col-md-12 col-sm-12">
                                          <div class="form-group">
                                             <label>State<em>*</em></label>
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
                                       <div class="clearfix"></div>
                                       <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                             <label>City<em>*</em></label>
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
                                       <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                             <label>Enter Pincode<em>*</em></label>
                                             <input name="pincode" class="form-control" required="required" maxlength="6" type="text" value="<?php if(isset($addressDetails['pincode'])){ echo $addressDetails['pincode']; } ?>">
                                             <span class="bar"></span>
                                          </div>
                                       </div>
                                       <div class="col-md-12 col-sm-12">
                                          <div class="form-group">
                                             <label>Address Line 1<em>*</em></label>
                                             <input type="text" class="form-control" required="" name="address1" value="<?php if(isset($addressDetails['address1'])){ echo $addressDetails['address1']; } ?>">
                                          </div>
                                       </div>
                                       <div class="clearfix"></div>
                                       <div class="col-md-12 col-sm-12">
                                          <div class="form-group">
                                             <label>Address Line 2</label>
                                             <input type="text" class="form-control" name="address2" value="<?php if(isset($addressDetails['address2'])){ echo $addressDetails['address2']; } ?>">
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
                                    <div class="pull-right btnsdjs" style="display: none;">
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
                                    <p id="billError" style="color:red;"></p>
                                 </div>
                              </div>
                              <div class="clearfix"></div>
                           </section>
                           <div id="checkout-cart-wrapper">
                              <?php 
                                 include_once"include/cart/checkout-cart-page.inc.php";
                                 
                                 echo $checkoutCartPageHTML;
                                 
                                 ?>
                           </div>
                        </form>
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
         $("[data-fancybox]").fancybox({
         
            iframe : {
         
               css : {
         
                  width : '450px'
         
               }
         
            }
         
         });
         
      </script>
      <script>
         $(document).ready(function(){
         
            $(".fp-btn").click(function(){
         
               $(".login-box").addClass("switch-form");
         
            });
         
         
         
            $(".back-btn").click(function(){
         
               $(".login-box").removeClass("switch-form");
         
            });
         
         
         
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
         
         
         
            /* $(document).on("click", "#proceedCheckout", function(){
         
               var billingAddress = "<?php if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'])){ echo $_SESSION[SITE_NAME]['BILLADDRESS']['Billing']; } ?>"; 
         
               var shippingAddress = "<?php if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){ echo $_SESSION[SITE_NAME]['BILLADDRESS']['shipping']; } ?>";
         
               
         
               if(shippingAddress=="" || shippingAddress=="0" || billingAddress=="" || billingAddress=="0"){
         
                  $("#billError").text('Please choose Billing Address');
         
                  $("#shipError").text('Please choose Shipping Address');
         
                  $("html, body").animate({ scrollTop: 0 }, "slow");
         
                  return false;
         
               }
         
               var paymentMode = $('input[name="payment_method"]:checked').val();
         
               //alert(paymentMode);
         
               //alert(shippingAddress+" "+shippingAddress+" "+billingAddress+" "+billingAddress);
         
               if(shippingAddress !="" && shippingAddress !="0" && billingAddress !="" && billingAddress !="0"){
         
                  window.location.href = "<?php echo BASE_URL; ?>/process-payment.php?paymentMode="+paymentMode;
         
               }
         
            }); */
         
            
         
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
      <script>
         $('input[type=checkbox][name=sameAsBilling]').change(function() {
            //alert(this.value);      
            if(this.value !=''){         
               window.location.href = "<?php echo BASE_URL; ?>/chekout-order-page.php?sameASBilling";         
            }else{         
               window.location.href = "<?php echo BASE_URL; ?>/chekout-order-page.php?shippingdestroy";         
            }                             
         });
         
      </script>
      <script>
         $('.checkout-summery-pop').fancybox({
         
            iframe : {
         
               css : {
         
                  width : '424',
         
                  height : '438'
         
               }
         
            },
         
            buttons : [
         
            
         
               'close'
         
            ],
         
            afterClose: function () {
         
               parent.location.reload(true);
         
            }
         
         });
         
      </script>
   </body>
</html>