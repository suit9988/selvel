<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	
	// ini_set('display_errors', 'On');
	// error_reporting(E_ALL);

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('notify_view', $loggedInUserDetailsArr);

	$pageName = "Notify Product";
	$pageURL = 'notify-products.php';
	$addURL = 'review-add.php';
	$deleteURL = 'notify-products.php';
	$tableName = 'subscription';

	$whereCond = '';
	$whereArray = array();
	if(isset($_GET['search'])) {
		if(isset($_GET['productid']) and !empty($_GET['productid'])) {
			$productid = $admin->escape_string($admin->strip_all($_GET['productid']));

			$cond = "(product_id='".$productid."')";
			$whereArray[] = $cond;
		}
	}

	if(count($whereArray)>0) {
		$whereCond = " AND ".implode(' AND ', $whereArray);
	}

	$sql = "select * from ".PREFIX.$tableName." where product_id<>'' and product_id IN (select id from ".PREFIX."product_master) ".$whereCond." order by id DESC";
	$results = $admin->query($sql);

	if(isset($_GET['delId']) && !empty($_GET['delId']) ){
		$delId = trim($admin->strip_all($_GET['delId']));

		$admin->query("delete from ".PREFIX.$tableName." where id='".$delId."'");

		header('location: '.$pageURL.'?deletesuccess');
		exit;
	}

	if(isset($_GET['id']) && !empty($_GET['id']) ){
		$id = trim($admin->strip_all($_GET['id']));

		$notify = $admin->fetch($admin->query("select * from ".PREFIX.$tableName." where id='".$id."'"));
		$admin->query("update ".PREFIX.$tableName." set is_notified=1 where id='".$id."'");

		// include_once("../include/classes/Email.class.php");
		$emailObj = new Email();
		$mailBody = "
		<p>
		Dear Customer
		<br>
		Product ".$admin->getUniqueProductById($notify['product_id'])['product_name']." is back in stock.
		<br>
		Visit <a href='".BASE_URL."'>site</a> now to shop.
		</p>";

		$emailObj->setEmailBody($mailBody);
		$emailObj->setSubject(SITE_NAME." | Product Back in stock");
		$emailObj->setAddress($notify['email']);
		//$adminemail = $functions->getAdminEmail();
		//$emailObj->setAdminAddress($adminemail);
		$res = $emailObj->sendEmail();

		header('location: '.$pageURL.'?notifysuccess');
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
								<li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item active"><?php echo $pageName; ?></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<?php if(isset($_GET['notifysuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> Notified Successfully.
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
				<div class="row" id="postiontable">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable-selectable-data">
							<thead>
								<tr>
									<th>Sr.no</th>
									<th>Email</th>
									<th>Product</th>
									<th>Notified</th>
									<!--<th>Product Name</th>
									<th>Size</th>
									<th>Color</th>-->
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$x = 1;
									while($row = $admin->fetch($results)){
								?>
										<tr>
											<td><?php echo $x++ ?></td>
											<td><?php echo $row['email']; ?></td>
											<td><?php
												echo 'Product Name : '.$admin->getUniqueProductById($row['product_id'])['product_name'];
												$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where id='".$row['size_id']."'"));
												echo '     <br>Size: '. $productSize['size']. '<br>';
												echo '     Color: '. $productSize['productcolor'];
											?></td>
											<?php /* <td><?php
												
												echo $productSize['size'];
												
											?></td>
											<td><?php
												
												echo $productSize['productcolor'];
											?></td> */ ?>
											<td><?php echo $row['is_notified']==0 ? "No" : "Yes"; ?></td>
											<td>
												<a class="btn-transition btn" href="<?php echo $pageURL; ?>?id=<?php echo $row['id']; ?>" title="Notify User"> <i class="fa fa-envelope"></i> </a>
												<?php
													if(in_array('notify_delete',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<a class="btn-transition btn" href="<?php echo $deleteURL; ?>?delId=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a>
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
					title: 'Notify Customer List',
					exportOptions: {
						//columns: [ 0, 1, 2,3,4 ]
						columns: [ 0, 1, 2 ]
					}
				}
			]
		});
	</script>

</body>
</html>