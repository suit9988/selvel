<?php
	include_once 'include/functions.php';
	$functions = new Functions();
	error_reporting(E_ALL);

	if(isset($_GET['OrderID']) && !empty($_GET['OrderID'])){
		$OrderID = $functions->escape_string($functions->strip_all($_GET['OrderID']));

		$sql = "SELECT * FROM ".PREFIX."order WHERE `txn_id`='".$OrderID."'";
		$result = $functions->query($sql);
	}else{
		header("location:my-order.php?ORDERNOTFOUND");
		exit;
	}
	if(isset($_POST['RequestRefund'])){
		if(isset($_POST['order_id']) && !empty($_POST['order_id']) && isset($_POST['orderDetails']) && !empty($_POST['orderDetails'])){
			$order_id = $functions->escape_string($functions->strip_all($_POST['order_id']));
			$refund_in = $functions->escape_string($functions->strip_all($_POST['refund_in']));
			$date = date('Y-m-d H:i:s');

			foreach($_POST['orderDetails'] as $orderDetailsID){
				$Insrt = "INSERT INTO ".PREFIX."refund_request(`order_detail_pal`, `ordre_id`, refund_in, created) VALUES ('".$orderDetailsID."', '".$order_id."', '".$refund_in."', '".$date."')";
				$functions->query($Insrt);
			}
			$invoiceMsg = "Refund Request: \n";
			$adminInvoiceMsg = "Refund Request By Customer: \n";
			foreach($_POST['orderDetails'] as $orderDetailsID){
				$orderDetailRS = $functions->query("select * from ".PREFIX."order_details where id='".$orderDetailsID."'");
				$orderDetailRow = $functions->fetch($orderDetailRS);
				$refundRS = $functions->query("select * from ".PREFIX."refund_request where order_detail_pal='".$orderDetailsID."'");
				$refundRow = $functions->fetch($refundRS);
				$orderTxnId = $functions->query("SELECT * FROM ".PREFIX."order WHERE id='".$orderDetailRow['order_id']."'");
				$orderTxnIdRow = $functions->fetch($orderTxnId);
				$customerByOrder = $functions->query("SELECT * FROM ".PREFIX."customers WHERE id='".$orderTxnIdRow['customer_id']."'");
				$customerDetails = $functions->fetch($customerByOrder);
				$productDetail = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_master WHERE id='".$orderDetailRow['product_id']."'"));
				
				$sn_order_update = $functions->query("update ".PREFIX."order set refund_status='Refund Requested' WHERE id='".$orderDetailRow['order_id']."'");
				
				
				$invoiceMsg .= "Invoice - ".$orderTxnIdRow['txn_id']." \n You have requested refund for ".$productDetail['product_name'].". \n Because ".$refundRow['refund_in'];
				$adminInvoiceMsg .= "Refund request of Invoice - ".$orderTxnIdRow['txn_id']." \n Refund requested for ".$productDetail['product_name'].", Because of ".$refundRow['refund_in'];
			}
			// send email
			$emailSubject = "Refund request for product - ".SITE_NAME;
			include_once("include/classes/Email.class.php");
			$emailObj = new Email();
			$emailObj->setEmailBody($invoiceMsg);
			$emailObj->setSubject($emailSubject);
			$emailObj->setAddress($customerDetails['email']); // send email to registered email
			$emailObj->sendEmail(); // UNCOMMENT

			// send email to admin
			include_once("include/classes/Email.class.php");
			$emailSubject = "Refund request for product - ".SITE_NAME;
			$adminEmail = $functions->getAdminDetails()['email'];
			$emailObj = new Email();
			$emailObj->setEmailBody($adminInvoiceMsg);
			$emailObj->setSubject($emailSubject);
			$emailObj->setAddress($adminEmail); // send email to registered email
			$emailObj->sendEmail(); // UNCOMMENT
			
			header("location:refund-request.php?success&OrderID=".$_POST['txnId']);
			exit;
		}else{
			header("location:refund-request.php?InvalidDetails&OrderID=".$_POST['txnId']);
			exit;
		}
	}
?>
<!DOCTYPE>
<html>
<head>
	<title>Arvind Sanitary</title>
	<?php include("include/header-link.php");?>
</head>
<body class="refund-request-page">
	<?php
		if(isset($_GET['success'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark3"></i> Refund request successfully sent.
			</div>
	<?php
		}
	?>
	<form action="" method="POST" id="reqRefund">
	<?php 
		if($functions->num_rows($result)>0){
			$order = $functions->fetch($result);
	?>	
				  	<div class="refund-table-repsonsive">
						<table class="table refundtable">
					    	<thead>
					      		<tr>
					        		<th>#</th>
					        		<th>Product thumbnail</th>
					        		<th>Product Name</th>
					        		<th>Price</th>
					      		</tr>
					    	</thead>
					    	<tbody>
					    		<?php 
					    			$sql = "SELECT * FROM ".PREFIX."order_details WHERE `order_id`='".$order['id']."'";
					    			$result = $functions->query($sql);
					    			if($functions->num_rows($result)>0){
					    				while ($orderDetils = $functions->fetch($result)) {

					    					$productDetails = $functions->getUniqueProductById($orderDetils['product_id']);
					    					$productBanner = $functions->getImageUrl('products',$productDetails['main_image'],'crop','');
											$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE size='".$orderDetils['size']."' and product_id='".$productDetails['id']."' and productcolor='".$orderDetils['color']."' ORDER BY id ASC LIMIT 1"));
											$productBanner = $functions->getImageUrl('products',$getProductsizeDetails['image1_color'],'crop','');
					    					
											$unitPrice = $orderDetils['customer_price'];
											$unitDiscountedPrice = $orderDetils['customer_discount_price'];
											$quantity = $orderDetils['quantity'];

											if(!empty($unitDiscountedPrice)){
												$totalPrice = $quantity * $unitDiscountedPrice;
												$totalPriceMsg = 'Rs. '.$unitDiscountedPrice.' x '.$quantity.' unit';
												$displayPrice = $unitDiscountedPrice;
											} else {
												$totalPrice = $quantity * $unitPrice;
												$totalPriceMsg = 'Rs. '.$unitPrice.' x '.$quantity.' unit';
												$displayPrice = $unitPrice;
											}
											if($orderDetils['payment_discount']>0) {
												$paymentDiscountAmount = $totalPrice*($orderDetils['payment_discount']/100);
												$totalPrice = $totalPrice - $paymentDiscountAmount;
											}

											$OrChk = $functions->getOrderDetailsData($orderDetils['id']);
					    		?>
								      		<tr>
								       	 		<td><?php 	
								       	 			if($OrChk){ ?>
								       	 				<input type="checkbox" name="orderDetails[]" value="<?php echo $orderDetils['id']; ?>" class="cance_checkbox">
								       	 			<?php 	
								       	 				}else{ 
							       	 						if(!empty($orderDetils["refund_status"]) && $orderDetils["refund_status"]=="Requested"){
							       	 							echo "<br><span class='label label-primary'>Refund Requested</span>"; 
							       	 						}elseif(!empty($orderDetils["refund_status"]) && $orderDetils["refund_status"]=="Accepted"){
							       	 							echo "<br><span class='label label-success'>Request Accepted</span>"; 
							       	 						}elseif(!empty($orderDetils["refund_status"]) && $orderDetils["refund_status"]=="Rejected"){
							       	 							echo "<br><span class='label label-danger'>Request Rejected</span>"; 
							       	 						}else{
							       	 							echo "<br><span class='label label-primary'>".$orderDetils["refund_status"]."</span>";
							       	 						}
							       	 					}
								       	 			?>
								       	 		</td>
								       	 		<td><img src="<?php echo $productBanner; ?>" style="width:100px;"></td>
								        		<td>
								        			<?php 
														echo "<p>".$productDetails['product_name']."</p>";
													?>
								        		</td>
								        		<td><i class="fa fa-inr"></i> <?php echo $totalPrice; ?></td>
								      		</tr>
						      	<?php
						      			}
						      		}
						      	?>	
					    	</tbody>
					  	</table>
				  	</div>
				  	
					<div class="form-group">
						<div class="row">
							<div class="col-md-4 sksahk">
								<label>Cancel Reason</label>
								<select name="refund_in" class="form-control">
									<?php if($order['order_status']=='Shipped' || $order['order_status']=='Completed') { ?>
										<option value="Product Damaged">Product Damaged</option>
									<?php } ?>
									<option value="Wrong item placed">Wrong item placed</option>
									<option value="Order placed by mistake">Order placed by mistake</option>
									<option value="Got better discounts somewhere else">Got better discounts somewhere else</option>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<small class="makespanaw" style="font-size: 12px; color: #F00">Note : All we ask is that you return the item to us in the same condition that you received it, with the original invoice, any tags attached, without damage and in sealed condition. In case of any discrepancies or damage claims, our decision subject to item/s condition will be final. Opened or used boxes will not be accepted as returns.</small>
					</div>
					<div for="orderDetails[]" class="error"></div><br>
					<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
					<input type="hidden" name="txnId" value="<?php echo $OrderID; ?>">
				  	<button type="submit" name="RequestRefund" id="RequestRefund" class="btn btn-warning">submit</button>
		<?php 
		} ?>
 	  	</form>
         <!--Main End Code Here-->
 
      <!--footer end menu head-->
      <?php include("include/footer-link.php");?>
      	<script>
			$(document).ready(function(){
				$("#reqRefund").validate({
	                ignore: ".ignore",
					rules: {
						"orderDetails[]": {
				           required:true,
						}
					},
					messages: {
						"orderDetails[]": {
							required: "Please select atleast one product"
						},
					}
				});
			});
		</script>
   </body>
</html>