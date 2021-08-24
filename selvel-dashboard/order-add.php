<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Order";
	$parentPageURL = 'order.php';
	$pageURL = 'order-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(isset($_GET['edit'])) {
		$admin->checkUserPermissions('order_update',$loggedInUserDetailsArr);
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_GET['edit'])){
		$txnId = $admin->escape_string($admin->strip_all($_GET['txnId']));
		$purchaseDetails = $admin->getProductOrderDetails($txnId);
		$order = $purchaseDetails['order'];
		$orderDetails = $purchaseDetails['orderDetails'];
		$customerDetails = $admin->getUniqueCustomerById($order['customer_id']);
	}

	if(isset($_POST['update']) ) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$txnId = trim($admin->escape_string($admin->strip_all($_POST['txnId'])));
			$result = $admin->updateProductOrderDetails($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess&edit&txnId=".$txnId);
			exit();
		}
	}

	$trackURL = DELHIVERY_BASE_URL."/api/v1/packages/json/?token=".DELHIVERY_API_KEY."&waybill=".$order['waybill'];

	$headers = array();
	$headers[] = 'Authorization: Token '.DELHIVERY_API_KEY;

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $trackURL,
		CURLOPT_USERAGENT => '',
	));
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	// Send the request & save response to $resp
	$resp = curl_exec($curl); // Getting jSON result string
	curl_close($curl);

	// Close request to clear up some resources
	$responseArr = json_decode($resp, true);
	// print_r($responseArr);
	if(!empty($responseArr['Error'])) {
		$orderStatus = '';
	}
	$orderStatus = $responseArr['ShipmentData'][0]['Shipment']['Status']['Status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo ADMIN_TITLE ?></title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="assets/css/line-awesome.min.css">

	<!-- Datatable CSS -->
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/css/select2.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<!-- Crop Image css -->
	<link href="assets/css/crop-image/cropper.min.css" rel="stylesheet">

	<style>
		em{
			color:red;
		}
		.group{
			width:35px!important;
			height: 40px!important;
		}
		.form-group.row.col-sm-12 {
		    padding: 10px 0px;
		}
		.form-group.row.col-sm-12 .col-sm-1 {
		    padding: 0;
		}
	</style>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php include("include/header.php"); ?>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php include("include/sidebar.php"); ?>
		<!-- /Sidebar -->
		
		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<!-- Page Content -->
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title"><?php echo $pageName; ?></h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
								<li class="breadcrumb-item"><a href="<?php echo $parentPageURL; ?>"><?php echo $pageName; ?></a></li>
								<li class="breadcrumb-item active">
									<?php if(isset($_GET['edit'])) {
										echo 'Edit '.$pageName;
									} else {
										echo 'Add New '.$pageName;
									}
									?>
								</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<a href="<?php echo $parentPageURL; ?>" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to <?php echo $pageName; ?></a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<?php if(isset($_GET['registersuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully added.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['registerfail'])){ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> not added.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['updatesuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully updated.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['updatefail'])){ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-close"></i> <strong><?php echo $pageName; ?> not updated.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-lg-12">
						<form action="" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Order Info</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-sm-2">
											<label>Order No.</label>
											<input type="text" class="form-control" disabled="disabled" required="required" name="" value="<?php if(isset($_GET['edit'])){ echo $order['txn_id']; }?>"/>
										</div>
										<div class="col-sm-2">
											<label>Order Date</label>
											<input type="text" class="form-control" disabled="disabled" required="required" name="" value="<?php if(isset($_GET['edit'])){ echo date('d F, Y', strtotime($order['created'])); }?>"/>
										</div>
										<div class="col-sm-2">
											<label>Order Time</label>
											<input type="text" class="form-control" disabled="disabled" required="required" name="" value="<?php if(isset($_GET['edit'])){ echo date('h:i A', strtotime($order['created'])); }?>"/>
										</div>
										<div class="col-sm-3">
											<label>Payment Status</label>
											<input type="text" class="form-control" disabled="disabled" required="required" name="" value="<?php if(isset($_GET['edit'])){ echo $order['payment_status']; }?>"/>
										</div>
										<div class="col-sm-3">
											<label>Invoice No.</label>
											<input type="text" class="form-control" disabled="disabled" required="required" name="" value="<?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Complete"){ echo $order['txn_id']; } else { echo '-'; }?>"/>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<label>Billing Address</label>
											<textarea required="required" name="" class="form-control" disabled="disabled" rows="5"><?php if(isset($_GET['edit'])){
											$eol = '';
											echo 
											$order['billing_fname'].' '.$eol.
											$order['billing_address_line1'].', '.$eol;
											if(!empty($order['billing_address_line2'])){
												echo $order['billing_address_line2'].', '.$eol;
											}
											echo $order['billing_city'].' - '.$order['billing_pincode'].', '.$eol.
											$order['billing_state'];
											} ?></textarea>
										</div>
										<div class="col-sm-6">
											<label>Shipping Address</label>
											<textarea required="required" name="" class="form-control" disabled="disabled" rows="5"><?php if(isset($_GET['edit'])){
											echo 
											$order['shipping_fname'].' '.$eol.
											$order['shipping_address_line1'].', '.$eol;
											if(!empty($order['shipping_address_line2'])){
												echo $order['shipping_address_line2'].', '.$eol;
											}
											echo $order['shipping_city'].' - '.$order['shipping_pincode'].', '.$eol.
											$order['shipping_state'];
											} ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-3">
											<label>Payment Status</label>
											<select class="form-control" name="paymentStatus" id="paymentStatus">
												<?php
												if(isset($_GET['edit'])){ 
													if($order['payment_status']=="Payment Pending"){ ?>
														<option value="Payment Pending" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Pending"){ echo 'selected="selected"'; } ?>>Payment Pending</option>
														<option value="Payment Complete" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Complete"){ echo 'selected="selected"'; } ?>>Payment Complete</option>
														<option value="Payment Failed" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Failed"){ echo 'selected="selected"'; } ?>>Payment Failed</option>
														<option value="Payment Refunded" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Refunded"){ echo 'selected="selected"'; } ?>>Payment Refunded</option>
														<?php 								
													} else if($order['payment_status']=="Payment Complete"){ ?>
														<option value="Payment Complete" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Complete"){ echo 'selected="selected"'; } ?>>Payment Complete</option>
														<option value="Payment Refunded" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Refunded"){ echo 'selected="selected"'; } ?>>Payment Refunded</option>
														<?php 								
													} else if($order['payment_status']=="Payment Failed"){ ?>
														<option value="Payment Failed" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Failed"){ echo 'selected="selected"'; } ?>>Payment Failed</option>
														<?php 								
													} else if($order['payment_status']=="Payment Refunded"){ ?>
														<option value="Payment Refunded" <?php if(isset($_GET['edit']) && $order['payment_status']=="Payment Refunded"){ echo 'selected="selected"'; } ?>>Payment Refunded</option>
														<?php 								
													}
												} ?>
											</select>
										</div>
										<div class="col-sm-3">
											<label>Order Status</label>
											<input type="text" class="form-control" name="orderStatus" readonly value="<?php echo $orderStatus; ?>" />
											<?php /* <select class="form-control" name="orderStatus">
												<option value="">Select Order Status</option>
												<option value="In Process" <?php if(isset($_GET['edit']) && $order['order_status']=="In Process"){ echo 'selected="selected"'; } ?>>In Process</option>
												<option value="Shipped" <?php if(isset($_GET['edit']) && $order['order_status']=="Shipped"){ echo 'selected="selected"'; } ?>>Shipped</option>
												<option value="Completed" <?php if(isset($_GET['edit']) && $order['order_status']=="Completed"){ echo 'selected="selected"'; } ?>>Delivered</option>
												
												<option value="Cancelled" <?php if(isset($_GET['edit']) && $order['order_status']=="Cancelled"){ echo 'selected="selected"'; } ?>>Cancelled</option>
												<?php
												$sql_sne1 = "select * from slv_order where txn_id='$txnId'";
												$results_sne1 = $admin->query($sql_sne1);
												$row_sne1 = $admin->fetch($results_sne1);
												$id_sne1=$row_sne1['id'];
													
												$sql_sne = "select * from slv_order_details where order_id = '$id_sne1'";
												$results_sne = $admin->query($sql_sne);
												while($row_sne1 = $admin->fetch($results_sne)){
													$p_id_sne1=$row_sne1['product_id'];
													
													$sql_sne2 = "select * from slv_product_master where id='$p_id_sne1'";
												$results_sne2 = $admin->query($sql_sne2);
												$row_sne2 = $admin->fetch($results_sne2);
												$id_sne2=$row_sne2['product_name'];
												
												?>
												<option value="Cancelled" <?php if(isset($_GET['edit']) && $order['order_status']=="Cancelled"){ echo 'selected="selected"'; } ?>>Refund - <?php echo $id_sne2; ?></option>
												<?php } ?>
											</select> */ ?>
										</div>
										<div class="col-sm-6">
											<label>Order Remarks</label>
											<textarea name="orderRemark" class="form-control" rows="5"><?php if(isset($_GET['edit'])){ echo $order['order_remark']; } ?></textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<input type="hidden" class="form-control" name="txnId" id="txnId" value="<?php echo $txnId ?>"/>
								<a href="<?php echo BASE_URL; ?>/order-details-pdf.php?adminTxnId=<?php echo $order['txn_id']; ?>" class="btn btn-primary" title="Download Invoice PDF" target="_blank">
									<i class="fa fa-file-pdf-o"></i> Download Invoice
								</a>
								<button type="submit" name="update" value="update" id="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>
							</div>
						</form>

						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0"> Order Details</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-striped custom-table mb-0 datatable datatable-selectable-data">
											<thead>
												<tr>
													<th>#</th>
													<th>Product Thumbnail</th>
													<th>Refund Request</th>
													<th>Product Name</th>
													<th>Product Price</th>
													<th>Quantity</th>
													<th>Tax</th>
													<th>Total Price</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$x = 1;
													$subTotal = 0;
													$finalTotal = 0;
													foreach($orderDetails as $oneOrder) {
														$productDetails = $admin->getUniqueProductById($oneOrder['product_id']);
														$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where product_id='".$oneOrder['product_id']."' and size='".$oneOrder['size']."' and productcolor='".$oneOrder['color']."' order by id LIMIT 0,1"));
														$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image1_color'], PATHINFO_FILENAME)));
														$ext = pathinfo($productSize['image1_color'], PATHINFO_EXTENSION);

														$quantity = $oneOrder['quantity'];

														$unitPrice = $oneOrder['customer_price'];
														$unitDiscountedPrice = $oneOrder['customer_discount_price'];

														if(!empty($unitDiscountedPrice)){
															$totalPrice = $quantity * $unitDiscountedPrice;
															$totalPriceMsg = 'Rs. '.$unitDiscountedPrice.' x '.$quantity.' unit';
															$displayPrice = $unitDiscountedPrice;
														} else {
															$totalPrice = $quantity * $unitPrice;
															$totalPriceMsg = 'Rs. '.$unitPrice.' x '.$quantity.' unit';
															$displayPrice = $unitPrice;
														}
														$tax = $oneOrder['gst_rate'];
														$taxAmount = $totalPrice * ($tax/100);
														$totalPrice = $totalPrice + $taxAmount;
														$subTotal += $totalPrice;
												?>
														<tr>
															<td><?php echo $x++ ?></td>
															<td><img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="50" /></td>
															<td><?php 
																$sql = "SELECT * FROM ".PREFIX."refund_request WHERE order_detail_pal='".$oneOrder['id']."'";
																$result = $admin->query($sql);
																if($admin->num_rows($result)>0) {
																	echo $oneOrder['refund_status']; 
																} else {
																	echo "-";
																}
															?></td>
															<td><?php echo $productDetails['product_name']; ?> (<?php echo $oneOrder['size'] ?>)
																<br>Color: <?php echo $oneOrder['color'] ?>
															</td>
															<td><i class="fa fa-inr"></i> <?php echo $displayPrice; ?></td>
															<td><?php echo $quantity; ?></td>
															<td><?php echo $tax; ?> %</td>
															<td><?php echo $totalPrice; ?></td>
														</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="form-group row col-sm-12">
									<div class="col-sm-11 text-right">
										Subtotal:<br/>
										<?php
										// CHECK IF DISCOUNT COUPON IS USED
											$couponDiscountAmount = $admin->getRedeemedCouponAmount($order['customer_id'], $order['id']);
											
											if(!empty($couponDiscountAmount)){ ?>
												Coupon Discount:<br/>
												<?php 					
											}
											// CHECK IF DISCOUNT COUPON IS USED
											if(!empty($order['shipping_charges'])){ ?>
												Shipping Charges:<br/>
										<?php					
											}
										?>
										Final Total:
									</div>

									<div class="col-sm-1">
										<i class="fa fa-inr"></i> <?php echo $subTotal; ?><br/>
										<?php 					
											// CHECK IF DISCOUNT COUPON IS USED
											if(!empty($couponDiscountAmount)) {
												$finalTotal = $subTotal - $couponDiscountAmount;
										?>
												<i class="fa fa-inr"></i> <?php echo $couponDiscountAmount; ?><br/>
										<?php					
											} else {
												$finalTotal = $subTotal;
											}

											if(!empty($order['loyalty_points'])){
												$finalTotal = $finalTotal - $order['loyalty_points'];
										?>		
												<i class="fa fa-inr"></i> <?php echo $order['loyalty_points']; ?><br/>
										<?php					
											} else {
												$finalTotal = $finalTotal;
											}

											// CHECK IF DISCOUNT COUPON IS USED

											// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL 
											// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL
											if(!empty($order['shipping_charges'])){
												$finalTotal += $order['shipping_charges'];
										?>
												<i class="fa fa-inr"></i> <?php echo $order['shipping_charges']; ?><br/>
										<?php					
											}
											// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL 
										?>
										<i class="fa fa-inr"></i> <?php echo $finalTotal; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Page Content -->

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js"></script>

	<!-- Select2 JS -->
	<script src="assets/js/select2.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<!-- CK Editor -->
	<script type="text/javascript" src="assets/js/editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckfinder/ckfinder.js"></script>

	<!-- Crop Image js -->
	<script src="assets/js/crop-image/cropper.min.js"></script>
	<script src="assets/js/crop-image/image-crop-app.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					main_image: {
						extension: "jpg|jpeg|png"
					},
					image_one: {
						extension: "jpg|jpeg|png"
					},
					image_two: {
						extension: "jpg|jpeg|png"
					},
					image_three: {
						extension: "jpg|jpeg|png"
					},
					image_four: {
						extension: "jpg|jpeg|png"
					},
				},
				messages: {
					main_image: {
						extension: "Please upload jpg or png image"
					},
					image_one: {
						extension: "Please upload jpg or png image"
					},
					image_two: {
						extension: "Please upload jpg or png image"
					},
					image_three: {
						extension: "Please upload jpg or png image"
					},
					image_four: {
						extension: "Please upload jpg or png image"
					},
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

		});
	</script>
</body>
</html>