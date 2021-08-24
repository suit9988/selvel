<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('order_view', $loggedInUserDetailsArr);

	$pageName = "Order";
	$pageURL = 'order.php';
	$addURL = 'order-add.php';
	$deleteURL = 'order.php';
	$tableName = 'order';

	$whereCond = '';
	$whereArray = array();
	if(isset($_GET['search'])) {
		if(isset($_GET['from_date']) and !empty($_GET['from_date'])) {
			$from_date = $admin->escape_string($admin->strip_all($_GET['from_date']));
			$to_date = $admin->escape_string($admin->strip_all($_GET['to_date']));
			$search_from = $from_date.' 00:00:00';
			$search_to = $to_date.' 23:59:59';

			$cond = "(created BETWEEN '".$search_from."' and '".$search_to."')";
			$whereArray[] = $cond;
		}

		if(isset($_GET['status']) and !empty($_GET['status'])) {
			$status = $admin->escape_string($admin->strip_all($_GET['status']));

			$cond = "(order_status='".$status."')";
			$whereArray[] = $cond;
		}

		if(isset($_GET['customer_id']) and !empty($_GET['customer_id'])) {
			$customer_id = $admin->escape_string($admin->strip_all($_GET['customer_id']));

			$cond = "(customer_id='".$customer_id."')";
			$whereArray[] = $cond;
		}
	}

	if(count($whereArray)>0) {
		$whereCond = " where ".implode(' AND ', $whereArray);
	}

	$sql = "select * from ".PREFIX.$tableName." ".$whereCond." order by id DESC";
	$results = $admin->query($sql);
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

				<?php if(isset($_GET['deletesuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
					</div><br/>
				<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<form action="" id="form" method="get" enctype="multipart/form-data" autocomplete="off">
							<div class="card mgbtm10">
								<!-- <div class="card-header">
									<h4 class="card-title mb-0"> Search</h4>
								</div> -->
								<div class="card-body removebottom10">
									<div class="form-group row">
										<div class="col-sm-1"><h4 class="card-title-csusiom"> Search</h4></div>
										<div class="col-sm-2">
											<!-- <label>From Date</label> -->
											<input placeholder="From Date" type="text" class="form-control valid_date" readonly name="from_date" id="from_date" value="<?php if(isset($_GET['from_date']) and !empty($_GET['from_date'])){ echo $from_date; }?>" />
										</div>
										<div class="col-sm-2">
											<!-- <label>Search To</label> -->
											<input placeholder="To Date" type="text" class="form-control valid_date" readonly name="to_date" id="to_date" value="<?php if(isset($_GET['to_date']) and !empty($_GET['to_date'])){ echo $to_date; }?>" />
										</div>
										<div class="col-sm-2">
											<!-- <label>Status</label> -->
											<select name="status" class="form-control">
												<option value="" selected="" disabled="">Select Status</option>
												<option value="">All</option>
												<option value="In Process" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $status=='In Process') { echo 'selected'; } ?>>In Process</option>
												<option value="Shipped" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $status=='Shipped') { echo 'selected'; } ?>>Shipped</option>
												<option value="Completed" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $status=='Completed') { echo 'selected'; } ?>>Completed</option>
												<option value="Cancelled" <?php if(isset($_GET['status']) and !empty($_GET['status']) and $status=='Cancelled') { echo 'selected'; } ?>>Cancelled</option>
											</select>
										</div>
										<div class="col-sm-3">
											<!-- <label>Customer</label> -->
											<select name="customer_id" class="form-control">
												<option value="" selected="" disabled="">Select Customer</option>
												<option value="">All</option>
												<?php
													$customerRS = $admin->query("select * from ".PREFIX."customers order by first_name");
													while($customerDetails = $admin->fetch($customerRS)) {
												?>
														<option value="<?php echo $customerDetails['id'] ?>" <?php if(isset($_GET['customer_id']) and !empty($_GET['customer_id']) and $customer_id==$customerDetails['id']) { echo 'selected'; } ?>><?php echo $customerDetails['first_name'] ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-sm-1">
											<!-- <label></label><br> -->
											<button type="submit" name="search" class="btn btn-warning">Search</button>
										</div>
										<div class="col-sm-1">
											<!-- <label></label><br> -->
											<a href="<?php echo $pageURL ?>" name="reset" class="btn btn-primary">Reset</a>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable-selectable-data">
							<thead>
								<tr>
									<th>Sr.no</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Order No</th>
									<th>Order Date</th>
									<th>Amount</th>
									<th>Payment Mode</th>
									<th>Payment Status</th>
									<th>Order Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$x = 1;
									while($row = $admin->fetch($results)) {
										$customerDetails = $admin->getUniqueCustomerById($row['customer_id']);
								?>
										<tr>
											<td><?php echo $x++ ?></td>
											<td><?php echo $row['billing_fname']; ?></td>
											<td><?php echo $customerDetails['email']; ?></td>
											<td><?php echo $customerDetails['mobile']; ?></td>
											<td><?php echo $row['txn_id']; ?></td>
											<td><?php echo date('d-m-Y h:i A', strtotime($row['created'])); ?></td>
											<td><i class="fa fa-rupee"></i> <?php echo round($admin->getCustomerPurchaseAmount($row['txn_id'])); ?></td>
											<td><?php echo $row['payment_mode']; ?></td>
											<td><?php echo $row['payment_status']; ?></td>
											<td><?php echo $row['order_status']; ?></td>
											<td>
												<?php
													if(in_array('order_update',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<a class="btn-transition btn" href="<?php echo $addURL; ?>?edit&txnId=<?php echo $row['txn_id'] ?>" title="Edit"> <i class="fa fa-pencil"></i> </a>
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

	<!-- DatePicker JS -->
	<link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="assets/js/bootstrap-datepicker.min.js"></script>
	<script src="assets/js/Moment.js"></script>

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
		$(document).ready(function() {
			var start_date = new Date();
			$('.valid_date').datepicker({
				format: "yyyy-mm-dd",
				endDate: start_date,
				autoclose: true,
			});
		});
		$('.datatable-selectable-data').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'excel',
					title: 'Order Details'
				}
			]
		});
	</script>

</body>
</html>