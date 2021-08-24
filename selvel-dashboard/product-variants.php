<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(!isset($_GET['product_id']) || empty($_GET['product_id'])) {
		header("location: index.php");
		exit();
	}
	$product_id = trim($admin->escape_string($admin->strip_all($_GET['product_id'])));
	$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where product_id='".$product_id."' order by id LIMIT 0,1"));

	$pageName = "Product Variants";
	$pageURL = 'product-variants.php';
	$addURL = 'product-variant-add.php';
	$deleteURL = 'product-variants.php';
	$tableName = 'product_sizes';

	$sql = "select * from ".PREFIX.$tableName." where product_id='".$product_id."' and id<>'".$productSize['id']."' order by id DESC";
	$results = $admin->query($sql);

	if(isset($_GET['delId']) && !empty($_GET['delId']) ){
		$delId = trim($admin->strip_all($_GET['delId']));
		$product_id = trim($admin->strip_all($_GET['product_id']));

		$admin->deleteProductVariant($delId);

		header('location: '.$pageURL.'?deletesuccess&product_id='.$product_id);
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
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo FAVICON; ?>">

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
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]
	-->
	<style type="text/css">
		div#centerpositon.shottube div#DataTables_Table_0_wrapper > .row:nth-child(1) {
		    position: relative;
		    top: 0px;
		    left: 16px;
		    transform: translate(0%);
		    background: #ffffff8a;
		    /* padding-right: 40px; */
		    padding-top: 7px;
		    border: 1px solid #ddd;
		    width: 100%;
		    margin-bottom: 10px;
		}
		.table.custom-table > tbody > tr > td, .table.custom-table > tbody > tr > th, .table.custom-table > tfoot > tr > td, .table.custom-table > tfoot > tr > th, .table.custom-table > thead > tr > td, .table.custom-table > thead > tr > th {
		    padding: 10px 2px !important;
		    vertical-align: middle;
		    font-size: 13px;
		}
		table.dataTable thead > tr > th.sorting {
		    text-align: center;
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
								<li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item active"><?php echo $pageName; ?></li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<a href="<?php echo $addURL."?product_id=".$product_id; ?>" class="btn add-btn"><i class="fa fa-plus"></i> Add <?php echo $pageName; ?></a>
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

				<div class="row shottube" id="centerpositon">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable datatable-selectable-data" style="text-align: center;">
							<thead>
								<tr>
									<th>#</th>
									<th>Product Image</th>
									<th>Size </th>
									<th>Color</th>
									<th>MRP </th>
									<th>Discounted Price </th>
									<th>Available Qty </th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$x = 1;
									while($row = $admin->fetch($results)) {
										$file_name = str_replace('', '-', strtolower( pathinfo($row['image1_color'], PATHINFO_FILENAME)));
										$ext = pathinfo($row['image1_color'], PATHINFO_EXTENSION);
								?>
										<tr>
											<td><?php echo $x++ ?></td>
											<td><img width="100" src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>"  /></td>
											<td><?php echo $row['size']; ?></td>
											<td><?php echo $row['productcolor']; ?></td>
											<td><i class="fa fa-inr"></i> <?php echo $row['customer_price']; ?></td>
											<td><i class="fa fa-inr"></i> <?php echo $row['customer_discount_price']; ?></td>
											<td><?php echo $row['available_qty']; ?></td>
											<td>
												<a class="btn-transition btn" href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id']; ?>&product_id=<?php echo $row['product_id']; ?>" title="Edit">   <i class="fa fa-pencil"></i> </a>
												<a class="btn-transition btn" href="<?php echo $deleteURL; ?>?delId=<?php echo $row['id']; ?>&product_id=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a>
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

	<!-- for button js-->
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<script>
		$(document).ready(function() {
			$(".openbtnblick").click(function(){
				$("#openblocks").slideToggle();;
			});

			$("#form").validate({
				rules: {
					upload_csv: {
						required: true,
						extension: "csv"
					}
				},
				messages: {
					upload_csv: {
						extension: "Please upload csv file"
					}
				}
			});
		});
	</script>
	
</body>
</html>