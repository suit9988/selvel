<?php
	header("location: checkout.php");
	exit;
	include_once 'include/functions.php';
	$functions = new Functions(); 
	$redirect = 'chekout-order-summary.php';
	$perm=$_GET['perm'];
	//exit();
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		//header("location: ".BASE_URL."/index.php?redirect=".$redirect);
		//header("location: ".BASE_URL."/index.php?registersuccess");
		header("location: ".BASE_URL."/login.php?redirect=chekout-order-summary.php");
		exit;
	}
	

	if(isset($_GET['sameASBilling'])){
		$_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $_SESSION[SITE_NAME]['BILLADDRESS']['Billing'];
		header("location:chekout-order-summary.php");
		exit;
	}
	if(isset($_GET['sameASBilling'])){
		if($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']){
			unset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
		}
		header("location:chekout-order-summary.php");
		exit;
	}
	if($loggedInUserDetailsArr = $functions->sessionExists()){
		
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - Checkout</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page dashboard-pages chekout-order-summary-page" id="address-book">

      <!--Top start menu head-->       

      <?php include("include/header.php");?>

      <!--Main Start Code Here-->

      <main class="main-inner-div">

         <img src="images/details-banner-header.jpg" class="img-full fixedimg">        

         <div class="container breadcum-header">

            <ul>

               <li>

                  <a href="<?php echo BASE_URL; ?>">Home</a>

                  <i class="fa fa-angle-right"></i>

               </li>

               <li>

                  <a href="#" class="current-page">Checkout</a>                  

               </li>

            </ul>

         </div>

         <div class="container cart-container">

           <div class="inner-wrapper paddbothzero">

              <!-- <h1 class="page-heading">CHECKOUT</h1> -->

              <section class="billing-shipping">
              <?php 	
  						if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'])){
  							$defaultAddress = $functions->getAddressById($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']);
  						}else{
  							$defaultAddress = $functions->getPrimaryAddress($loggedInUserDetailsArr['id']);	
  						}		
  					 ?>
                 <div class="billing-add match">

                    <div class="box-inner-ctn">

                       <h3>Billing Address</h3>
                       <?php
  									if($functions->num_rows($defaultAddress)>0){
  							    		$defaultAddress = $functions->fetch($defaultAddress);
  							    		$_SESSION[SITE_NAME]['BILLADDRESS']['Billing'] = $defaultAddress['id'];
  								?>
                       <div class="show-here-add">

                          <div class="show-here-sub">

                             <div class="show-here-head">

                                Name

                             </div>

                             <div class="show-here-data">

                             <?php echo $defaultAddress['customer_fname']; ?>

                             </div>

                          </div>

                          <div class="show-here-sub">

                             <div class="show-here-head">

                                Address

                             </div>

                             <div class="show-here-data">

                             <?php echo $functions->getDisplayAddress($defaultAddress," "); ?>

                             </div>

                          </div>

                       </div>
                       <?php 
  									} 	
  								?>	
                      <a class="checkout-summery-pop" data-fancybox="" data-type="iframe" data-src="" href="<?php echo BASE_URL; ?>/checkout-summery-popup.php?Billing=Billing">
  									Change Address 
  								<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
  								</a>
                       <p id="billError" style="color:red;"></p>

                    </div>

                 </div>

                 <div class="shipping-add match">

                    <div class="box-inner-ctn">

                       <h3>Shipping Address</h3>
                       <?php 
  								if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){
  									$defaultAddress = $functions->getAddressById($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']);
  									if($functions->num_rows($defaultAddress)>0){
  							    		$defaultAddress = $functions->fetch($defaultAddress);
  							    		$_SESSION[SITE_NAME]['BILLADDRESS']['shipping'] = $defaultAddress['id'];
  								?>
                          <div class="show-here-add">
  										<div class="show-here-sub">
  											<div class="show-here-head">
  												Name
  											</div>
  											<div class="show-here-data">
  												<?php echo $defaultAddress['customer_fname']; ?>
  											</div>
  										</div>
  										<div class="show-here-sub">
  											<div class="show-here-head">
  												Address
  											</div>
  											<div class="show-here-data">
  												<?php echo $functions->getDisplayAddress($defaultAddress," "); ?>
  											</div>
  										</div>
  									</div>
  								<?php 
  									}	
  								}	?>
                     <a class="checkout-summery-pop" data-fancybox="" data-type="iframe" data-src="" href="<?php echo BASE_URL; ?>/checkout-summery-popup.php?shipping=shipping">
  									Select Address 
  								<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
  								</a>
                       <p id="shipError" style="color:red;"></p>

                       <div class="same-as-billing">



                          <label class="container-cks">

                          <input type="checkbox" value="<?php if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'])){ echo $_SESSION[SITE_NAME]['BILLADDRESS']['Billing']; } ?>" name="sameAsBilling" <?php if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']) && $_SESSION[SITE_NAME]['BILLADDRESS']['shipping']==$_SESSION[SITE_NAME]['BILLADDRESS']['Billing']){ echo "checked"; } ?>> Same as Billing Address

                          <span class="checkmark-cks"></span>

                          </label>

                       </div>

                    </div>

                 </div>

                 <div class="clearfix"></div>

              </section>

              <div id="checkout-cart-wrapper">
                 <?php 
  						include_once "include/cart/checkout-cart-page.inc.php";
  						echo $checkoutCartPageHTML;
  					?>
  				</div>
        </div>

           
         </div>

      </main>

      <!--Main End Code Here-->

      <!--footer start menu head-->

      <?php include("include/footer.php");?> 

      <!--footer end menu head-->
      
      <?php include("include/footer-link.php");?>

      <script type="text/javascript">

         $(document).ready(function() {

          incrementSpinner();

         });

         function incrementSpinner(){

          $('.btn-number').off("click");

          $('.input-number').off("click");

          $('.input-number').off("change");

          $('.input-number').off("keydown");

         

          $('.btn-number').click(function(e){

            // alert('click');

            e.preventDefault();

         

            fieldName = $(this).attr('data-field');

            type = $(this).attr('data-type');

            var input = $("input[name='"+fieldName+"']");

            var currentVal = parseInt(input.val());

            //alert(currentVal);

            if (!isNaN(currentVal)) {

              if(type == 'minus') {

                if(currentVal > input.attr('min')) {

                  input.val(currentVal - 1).change();

                } 

                /* if(parseInt(input.val()) == input.attr('min')) {

                  $(this).attr('disabled', true);

                } */

         

              } else if(type == 'plus') {

         

                if(currentVal < input.attr('max')) {

                  input.val(currentVal + 1).change();

                }

         

              }

            } else {

              input.val(0);

            }

          });

          $('.input-number').focusin(function(){

            $(this).data('oldValue', $(this).val());

          });

          $('.input-number').change(function() {

            minValue =  parseInt($(this).attr('min'));

            maxValue =  parseInt($(this).attr('max'));

            valueCurrent = parseInt($(this).val());

            

            name = $(this).attr('name');

            if(valueCurrent >= minValue) {

              $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')

            } else {

              alert('Sorry, the minimum value was reached');

              $(this).val($(this).data('oldValue'));

            }

            if(valueCurrent <= maxValue) {

              $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')

            } else {

              alert('Sorry, the maximum value was reached');

              $(this).val($(this).data('oldValue'));

            }

          });

          $(".input-number").keydown(function (e) {

              // Allow: backspace, delete, tab, escape, enter and .

            if ($.inArray(e.keyCode, [46, 8, 9, 17, 13, 190]) !== -1 ||

               // Allow: Ctrl+A

              (e.keyCode == 65 && e.ctrlKey === true) || 

               // Allow: home, end, left, right

              (e.keyCode >= 35 && e.keyCode <= 39)) {

                 // let it happen, don't do anything

                 return;  

            }

            // Ensure that it is a number and stop the keypress

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

              e.preventDefault();

            }

          });

         }

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


      	<script>
		$(document).ready(function(){
			$(".fp-btn").click(function(){
				$(".login-box").addClass("switch-form");
			});
		
			$(".back-btn").click(function(){
				$(".login-box").removeClass("switch-form");
			});

			$(document).on("click", "#proceedCheckout", function(){
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
			});
		});
	</script>
	<script>
		$('input[type=checkbox][name=sameAsBilling]').change(function() {
			//alert(this.value);
			if(this.value !=''){
				window.location.href = "<?php echo BASE_URL; ?>/chekout-order-summary.php?sameASBilling";
			}else{
				window.location.href = "<?php echo BASE_URL; ?>/chekout-order-summary.php?shippingdestroy";
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
    //  console.log();
	</script>

   </body>

</html>
	<?php } 
	include_once "include/ajax-update-cart.php";
	?>