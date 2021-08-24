<?php 
	include_once 'include/functions.php';
	$functions = new Functions(); 
	$redirect = 'chekout-order-summary.php';
	$perm=$_GET['productredirect'];
	/* if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		//header("location: ".BASE_URL."/login.php?redirect=".$redirect);
		header("location: chekout-order-summary.php?perm=".$perm);
		exit;
	} */

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
			
      <main class="main-inner-div cart-page-detail" id = "cart-page">    
		  <div class="container back-btn"><a href="https://solvoix.xyz/selvel/store">Back to Shop</a></div>
		 

         <div class="container breadcum-header" style="border: none;">

            <h2 style="text-align: center; font-size: 40px">Your Cart</h2>

         </div>

         <div class="container cart-container">

	         <div class="cartinner">

	            <!-- <h1 class="page-heading">CHECKOUT</h1> -->

	            <div id="cart-wrapper">
	               <?php 
							include_once "include/cart/cart-inc.php";
							echo $cartHTML;
						?>
					</div>

	           
	         </div>
	     </div>

      </main>

      <!--Main End Code Here-->

      <!--footer start menu head-->

      <?php include("include/footer.php");?> 

      <!--footer end menu head-->

      <?php include("include/footer-link.php");
	  	// include_once "include/ajax-update-cart.php";
	  ?>

      <script type="text/javascript">

         

        

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
	</script>

   </body>

</html>