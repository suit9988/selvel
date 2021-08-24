<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('category_view', $loggedInUserDetailsArr);

	$pageName = "Category";
	$pageURL = 'category-master.php';
	$addURL = 'category-add.php';
	$deleteURL = 'category-master.php';
	$tableName = 'category_master';

	$sql = "select * from ".PREFIX.$tableName." order by id DESC";
	$results = $admin->query($sql);

	if(isset($_GET['status']) && isset($_GET['status']) && !empty($_GET['active_id']) && !empty($_GET['active_id'])){
		$status = trim($admin->strip_all($_GET['status']));
		$active_id = trim($admin->strip_all($_GET['active_id']));

		if($status=="1"){
			$updatestatus = '0';
		}elseif($status=="0"){
			$updatestatus = '1';
		}

		$sql="UPDATE ".PREFIX.$tableName." SET `active`='".$updatestatus."'  WHERE id='".$active_id."'";
		$admin->query($sql);

		header('location: '.$pageURL.'?updated');
		exit;
	}

	if(isset($_GET['delId']) && !empty($_GET['delId']) ){
		$delId = trim($admin->strip_all($_GET['delId']));

		$admin->deleteCategory($delId);

		header('location: '.$pageURL.'?deletesuccess');
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
						<div class="col-auto float-right ml-auto">
							<?php /*<a href="<?php echo $addURL; ?>" class="btn add-btn"><i class="fa fa-plus"></i> Add <?php echo $pageName; ?></a>*/ ?>
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
				<div class="row" id="centerpositon">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable datatable-selectable-data">
							<thead>
								<tr>
									<th>Sr.no</th>
									<th>Category Name</th>
									<th>Active</th>
									<?php
										if(in_array('sub_category_view',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
									?>
											<th>Sub Categories</th>
									<?php
										}
									?>
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
											<td><?php echo $row['category_name']; ?></td>
											<td>
												<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Click to Change Product Status" ><?php echo (($row['active']==1) ? "Yes" : "No"); ?></a>
											</td>
											<?php
												if(in_array('sub_category_view',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
											?>
													<td>
														<a href="sub-category-master.php?cat_id=<?php echo $row['id'] ?>" name="edit" class="">View Sub Categories</a>
													</td>
											<?php
												}
											?>
											<td>
												<?php
													if(in_array('category_update',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<?php if($row['active']==1) { ?>
															<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Mark as Inactive" class="btn-transition btn"><i class="fa fa-close"></i></a>
														<?php } else if($row['active']==0) { ?>
															<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Mark as Active" class="btn-transition btn"><i class="fa fa-check"></i></a>
														<?php } ?>
														<a class="btn-transition btn" href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id']; ?>" title="Edit">   <i class="fa fa-pencil"></i> </a>
												<?php
													}
												?>
												<?php /*<a class="btn-transition btn" href="<?php echo $deleteURL; ?>?delId=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a> */ ?>
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

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

</body>
</html>