<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('cancel_view', $loggedInUserDetailsArr);

	$pageName = "Cancel Requests";
	$pageURL = 'cancel-requests.php';
	$addURL = 'cancel-requests.php';
	$deleteURL = 'cancel-requests.php';
	$tableName = 'refund_request';

	$sql = "select * from ".PREFIX.$tableName." order by id DESC";
	$results = $admin->query($sql);

	if(isset($_GET['OrderDetailId']) && !empty($_GET['OrderDetailId']) && isset($_GET['paymentStatus']) && !empty($_GET['paymentStatus'])){
		
		$OrderDetailId = trim($admin->strip_all($_GET['OrderDetailId']));
		$paymentStatus = trim($admin->strip_all($_GET['paymentStatus']));
		$price = trim($admin->strip_all($_GET['price']));
		
		$sql = "UPDATE ".PREFIX."order_details SET refund_status='".$paymentStatus."' WHERE `id`='".$OrderDetailId."'";
		$admin->query($sql);
		
		
	
		
		$orderDetailRSq = "select * from ".PREFIX."order_details where id='$OrderDetailId'";
		$orderDetailRS = $admin->query($orderDetailRSq);
		$orderDetailRow = $admin->fetch($orderDetailRS);
	
	 $refundRSq = "select * from ".PREFIX."refund_request where order_detail_pal='".$OrderDetailId."'";
		$refundRS = $admin->query($refundRSq);
		$refundRow = $admin->fetch($refundRS);


		$orderTxnIdq = "SELECT * FROM ".PREFIX."order WHERE id='".$orderDetailRow['order_id']."'";
		$orderTxnId = $admin->query($orderTxnIdq);
		$orderTxnIdRow = $admin->fetch($orderTxnId);

		$customerByOrderq = "SELECT * FROM ".PREFIX."customers WHERE id='".$orderTxnIdRow['customer_id']."'";
		$customerByOrder = $admin->query($customerByOrderq);
		$customerDetails = $admin->fetch($customerByOrder);
		
		$sql_sn = "UPDATE ".PREFIX."order SET refund_status='".$paymentStatus."' WHERE `id`='".$orderDetailRow['order_id']."'";
		$admin->query($sql_sn);
//echo "hii";

		/*
		$emailSubject = "Refund request - ".SITE_NAME;
		$invoiceMsg = "Invoice - ".$orderTxnIdRow['txn_id']." \n Your refund request has been ".$orderDetailRow['refund_status'];
		include_once("../include/classes/Email.class.php");
		$emailObj = new Email();
		$emailObj->setEmailBody($invoiceMsg);
		$emailObj->setSubject($emailSubject);
		$emailObj->setAddress($customerDetails['email']); // send email to registered email
		$emailObj->sendEmail(); // UNCOMMENT*/

		header("location: cancel-requests.php?statusSuccess");
		exit;
	}
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

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]
	-->
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
								<li class="breadcrumb-item active"><?php echo $pageName; ?></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<?php if(isset($_GET['statusSuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> Status successfully updated.
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

				<?php if(isset($_GET['deletesuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
					</div><br/>
				<?php } ?>
				<div class="row"  id="postiontable">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable-selectable-data">
							<thead>
								<tr>
									<th>Sr.no</th>
									<th>OrderNo</th>
									<th>Image</th>
									<th>Product Name</th>
									<th>Price</th>
									<th>Cancel Reason</th>
									<th>Request Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$x = 1;
									while($row = $admin->fetch($results)) {
										//echo $row['ordre_id'];
										$order = $admin->getOrderbyId($row['ordre_id']);
										$orderDetils = $admin->getOrderDetailsbyId($row['order_detail_pal']);
										$productDetails = $admin->getUniqueProductById($orderDetils['product_id']);
										$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where product_id='".$productDetails['id']."' and size='".$orderDetils['size']."' and productcolor='".$orderDetils['color']."' order by id LIMIT 0,1"));

										$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image1_color'], PATHINFO_FILENAME)));
										$ext = pathinfo($productSize['image1_color'], PATHINFO_EXTENSION);
										
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
										$tax = $orderDetils['gst_rate'];
										$taxAmount = $totalPrice * ($tax/100);
										$totalPrice = $totalPrice + $taxAmount;
								?>
										<tr>
											<td><?php echo $x++ ?></td>
											<td><a href="order-add.php?edit&txnId=<?php echo $order['txn_id'];?>"><?php echo $order['txn_id']; ?></a></td>
											<td><img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" style="width:100px;"></td>
											<td><?php echo $productDetails['product_name']; ?> (<?php echo $orderDetils['size'] ?>)<br>Color: <?php echo $orderDetils['color'] ?></td>
											<td><i class="fa fa-rupee"></i> <?php echo $totalPrice;?></td>
											<td><?php echo $row['refund_in'];?></td>
											<td><?php echo date('d/m/Y H:i',strtotime($row['created']));?></td>
											<td>
												<?php
													if(in_array('cancel_update',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<select class="form-control refundStatus" name="refundStatus" id="RefundStatusval">
															<!-- <option value="">Select Refund Status</option> -->
															<option value="Accepted" <?php if($orderDetils['refund_status']=="Requested"){ echo 'selected="selected"'; } ?>>Requested</option>
															<option value="Accepted" <?php if($orderDetils['refund_status']=="Accepted"){ echo 'selected="selected"'; } ?>>Accepted</option>
															<option value="Rejected" <?php if($orderDetils['refund_status']=="Rejected"){ echo 'selected="selected"'; } ?>>Rejected</option>
														</select>
														<input type="hidden" name="orderDetilss" id="orderDetilss" value="<?php echo $orderDetils['id']; ?>">
														<input type="hidden" name="prices" id="prices" value="<?php echo $displayPrice; ?>">
												<?php
													}
												?>
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
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

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Datatable JS -->
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/js/datatable/buttons.print.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>
	<script>
		$('.datatable-selectable-data').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'excel',
					title: 'Cancel Requests',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6 ]
					}
				}
			]
		});

		$(document).ready(function() {
			$(".refundStatus").change(function() {
				
		        var paymentStatus = $('option:selected', this).text();
		     //   var id = $(this).closest('.OrderDetails').find("input[name='orderDetilss']").val();
		      //  var price = $(this).closest('.OrderDetails').find("input[name='prices']").val();
				 var id = document.getElementById("orderDetilss").value;
				  var price = document.getElementById("prices").value;
		       // alert(id);
				// alert(price);
		        
		        var result = confirm("Are you sure you want to update refund status?");
				if(result){
				  	window.location = "cancel-requests.php?OrderDetailId="+id+"&paymentStatus="+paymentStatus+"&price="+price;
					//exit();
				}
		        
		    });
		});
	</script>

</body>
</html>