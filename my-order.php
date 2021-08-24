<?php
	include_once("include/functions.php");
	$functions = New Functions();

	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: ".BASE_URL."/login.php");
		exit;
	}
$sne=$loggedInUserDetailsArr['id'];
	$customerOrders = $functions->getCompletedOrdersByCustomerId($loggedInUserDetailsArr['id']);
	
	$querys =$functions->query("SELECT * FROM ".PREFIX."order WHERE `customer_id`='".$sne."' and (`payment_status`='Payment Complete' or (`payment_status`='Payment Pending' and payment_mode='COD')) order by id DESC");
	
			$r=$functions->fetch($querys);
		$coun= $functions->num_rows($querys);
		//$coun= "0";
			
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - My Orders</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page dashboard-pages" id="my-Orders">

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

                  <a href="#" class="current-page">My Orders</a>                  

               </li>

            </ul>

         </div>

         <section class="orderreceived">

            <div class="inner-content bt">

               <div class="container">

                  <div class="ac-detail-nav-box">

                     <ul class="ac-detail-nav" id="myordernav">

                        <li class=""><a href="my-account.php"> My Account</a></li>

					  <li><a href="my-order.php">My Orders</a></li>

					  <li class="active"><a href="my-wishlist.php"> Wishlist</a></li>

                        <div class="clearfix"></div>

                     </ul>

                  </div>

                  <div class="row">

                     <!-- <div class="col-sm-10 col-sm-pull-1 col-sm-push-1"> -->

                     <div class="col-sm-12">

                        <div class="field-box noshadow">

                           <div class="table-responsive">
<?php
								 if($coun>0){ ?>
                              <table class=" table ordertable">

                                 <thead>

                                    <tr>

                                       <th>Sr.No.</th>

                                       <th>Order Date</th>

                                       <th>Order ID</th>

                                       <th>Total Amount</th>

                                       <th>Order Status</th>

                                       <th>Invoice</th>
                                       

                                    </tr>

                                 </thead>

                                 <tbody>
                                 <?php
								
													$i=1;
													while($order = $functions->fetch($customerOrders)) {
												?>
														<tr>
															<td><?php echo $i++ ?></td>
															<td><?php echo date('d/m/Y', strtotime($order['created'])); ?></td>
															<td><?php echo $order['txn_id']; ?></td>
															<td><i class="fa fa-inr"></i> <?php echo $functions->getCustomerPurchaseAmount($loggedInUserDetailsArr['id'], $order['txn_id']); ?></td>
															<td><?php echo $order['order_status']; ?></td>
															<td style="text-align: right;">
																<a href="<?php echo BASE_URL; ?>/order-details-pdf.php?txnId=<?php echo $order['txn_id']; ?>" class="details_view" target="_blank">
																	<i class="fa fa-file-text-o" aria-hidden="true"></i> View Invoice
																</a>
																<a style="min-width: 205px; display: inline-block;text-align: left;" href="javascript:;" data-type="iframe" data-src="<?php echo BASE_URL; ?>/refund-request.php?OrderID=<?php echo $order['txn_id']; ?>" class="trackord refundBtn"><i class="fa fa-comment-o" aria-hidden="true"></i>
																<?php 
																if($order['refund_status']==''){ ?>
																 Refund Request
																<?php } 
																else if($order['refund_status']=="Accepted"){ ?>
																Refund Request Accepted
																<?php } 
																else if($order['refund_status']=="Rejected"){ ?>
																Refund Request Rejected
																<?php }
																else { ?>
																<?php 
																Echo $order['refund_status']; ?>
																<?php } ?>
																</a>

															</td>
														</tr>
													<?php } ?>
                                    
                                    
                                 </tbody>

                              </table>
<?php
								 }else { ?> <h2 style="    font-size: 30px;
    font-weight: bold;
    text-align: center;">No Orders Yet</h2> <?php }
												?>
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
		$('.refundBtn').fancybox({
			closeExisting: true,
			loop: true,
			afterClose: function () {
				location.reload();
			}
		});
	  </script>

   </body>

</html>