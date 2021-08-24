<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Employee";
	$parentPageURL = 'user-management.php';
	$pageURL = 'user-management-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if($loggedInUserDetailsArr['role']!='super') {
		header("location: index.php");
		exit();
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(!isset($_POST['id']) && isset($_POST['email'])){
		if($csrf->check_valid('post')) {
			$result = $admin->addUserManagement($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess");
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueUserManagementById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateUserManagement($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess&edit&id=".$id);
			exit();
		}
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
									<h4 class="card-title mb-0"> Customer Details</h4>
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-3">
											<label>Name <em>*</em></label>
											<input type="text" name="name" id="name" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['fname']; } ?>" required/>
										</div>
										<div class="col-sm-3">
											<label>Email <em>*</em></label>
											<input type="text" class="form-control" required="required" name="email" id="email" value="<?php if(isset($_GET['edit'])){ echo $data['email']; }?>" />
										</div>
										<div class="col-sm-3">
											<label>Mobile<em style="color:red;">*</em></label>
											<input type="text" class="form-control" required="required" name="mobile" id="mobile" value="<?php if(isset($_GET['edit'])){ echo $data['mobile']; }?>" />
										</div>
										<div class="col-sm-3">
											<label>Active <em>*</em></label>
											<select class="form-control"  name="active" id="active">
												<option value="1" <?php if(isset($_GET['edit']) and $data['active']=='1') { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if(isset($_GET['edit']) and $data['active']=='0') { echo 'selected'; } ?>>No</option>
											</select>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-3">
											<label>Password <em>*</em></label>
											<input type="password" class="form-control" name="password" id="password" />
											<?php if(isset($_GET['edit'])){	?><span class="help-block">(Leave blank if dont want to change.)</span><?php } ?>
										</div>
										<div class="col-sm-3">
											<label>Designation<em style="color:red;">*</em></label>
											<input type="text" class="form-control" required="required" name="role" id="role" value="<?php if(isset($_GET['edit'])){ echo $data['role']; }?>" />
										</div>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Permissions</h4>
								</div>
								<?php
									if(isset($_GET['edit'])) {
										$existingPermissionsArray = explode(',',$data['permissions']);
									}
								?>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-4">
											&nbsp;
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view_all action_check" id="view_all" value="view_all" <?php if(isset($_GET['edit']) && in_array("view_all", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="view_all" class="css-label">View All</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create_all action_check" id="create_all" value="create_all" <?php if(isset($_GET['edit']) && in_array("create_all", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="create_all" class="css-label">Create All</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update_all action_check" id="update_all" value="update_all" <?php if(isset($_GET['edit']) && in_array("update_all", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="update_all" class="css-label">Edit All</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete_all action_check" id="delete_all" value="delete_all" <?php if(isset($_GET['edit']) && in_array("delete_all", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="delete_all" class="css-label">Delete All</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Customer Orders</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="order_view" value="order_view" <?php if(isset($_GET['edit']) && in_array("order_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="order_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="order_update" value="order_update" <?php if(isset($_GET['edit']) && in_array("order_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="order_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Cancel Requests</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="cancel_view" value="cancel_view" <?php if(isset($_GET['edit']) && in_array("cancel_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="cancel_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="cancel_update" value="cancel_update" <?php if(isset($_GET['edit']) && in_array("cancel_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="cancel_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Notify Products</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="notify_view" value="notify_view" <?php if(isset($_GET['edit']) && in_array("notify_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="notify_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="notify_delete" value="notify_delete" <?php if(isset($_GET['edit']) && in_array("notify_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="notify_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Customer Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="customer_view" value="customer_view" <?php if(isset($_GET['edit']) && in_array("customer_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="customer_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="customer_create" value="customer_create" <?php if(isset($_GET['edit']) && in_array("customer_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="customer_create" class="css-label">Create</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Newsletter</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="newsletter_view" value="newsletter_view" <?php if(isset($_GET['edit']) && in_array("newsletter_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="newsletter_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="newsletter_delete" value="newsletter_delete" <?php if(isset($_GET['edit']) && in_array("newsletter_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="newsletter_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Product Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="product_view" value="product_view" <?php if(isset($_GET['edit']) && in_array("product_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="product_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="product_create" value="product_create" <?php if(isset($_GET['edit']) && in_array("product_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="product_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="product_update" value="product_update" <?php if(isset($_GET['edit']) && in_array("product_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="product_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="product_delete" value="product_delete" <?php if(isset($_GET['edit']) && in_array("product_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="product_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Product Reviews</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="review_view" value="review_view" <?php if(isset($_GET['edit']) && in_array("review_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="review_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="review_update" value="review_update" <?php if(isset($_GET['edit']) && in_array("review_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="review_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="review_delete" value="review_delete" <?php if(isset($_GET['edit']) && in_array("review_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="review_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Category Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="category_view" value="category_view" <?php if(isset($_GET['edit']) && in_array("category_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="category_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="category_update" value="category_update" <?php if(isset($_GET['edit']) && in_array("category_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="category_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="category_delete" value="category_delete" <?php if(isset($_GET['edit']) && in_array("category_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="category_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Sub Category Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="sub_category_view" value="sub_category_view" <?php if(isset($_GET['edit']) && in_array("sub_category_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_category_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="sub_category_create" value="sub_category_create" <?php if(isset($_GET['edit']) && in_array("sub_category_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_category_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="sub_category_update" value="sub_category_update" <?php if(isset($_GET['edit']) && in_array("sub_category_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_category_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="sub_category_delete" value="sub_category_delete" <?php if(isset($_GET['edit']) && in_array("sub_category_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_category_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Sub Category Level 2 Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="sub_sub_category_view" value="sub_sub_category_view" <?php if(isset($_GET['edit']) && in_array("sub_sub_category_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_sub_category_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="sub_sub_category_create" value="sub_sub_category_create" <?php if(isset($_GET['edit']) && in_array("sub_sub_category_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_sub_category_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="sub_sub_category_update" value="sub_sub_category_update" <?php if(isset($_GET['edit']) && in_array("sub_sub_category_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_sub_category_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="sub_sub_category_delete" value="sub_sub_category_delete" <?php if(isset($_GET['edit']) && in_array("sub_sub_category_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sub_sub_category_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Attribute Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="attribute_view" value="attribute_view" <?php if(isset($_GET['edit']) && in_array("attribute_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="attribute_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="attribute_create" value="attribute_create" <?php if(isset($_GET['edit']) && in_array("attribute_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="attribute_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="attribute_update" value="attribute_update" <?php if(isset($_GET['edit']) && in_array("attribute_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="attribute_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="attribute_delete" value="attribute_delete" <?php if(isset($_GET['edit']) && in_array("attribute_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="attribute_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Features Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="feature_view" value="feature_view" <?php if(isset($_GET['edit']) && in_array("feature_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="feature_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="feature_create" value="feature_create" <?php if(isset($_GET['edit']) && in_array("feature_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="feature_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="feature_update" value="feature_update" <?php if(isset($_GET['edit']) && in_array("feature_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="feature_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="feature_delete" value="feature_delete" <?php if(isset($_GET['edit']) && in_array("feature_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="feature_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Size Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="size_view" value="size_view" <?php if(isset($_GET['edit']) && in_array("size_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="size_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="size_create" value="size_create" <?php if(isset($_GET['edit']) && in_array("size_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="size_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="size_update" value="size_update" <?php if(isset($_GET['edit']) && in_array("size_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="size_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="size_delete" value="size_delete" <?php if(isset($_GET['edit']) && in_array("size_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="size_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Color Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="color_view" value="color_view" <?php if(isset($_GET['edit']) && in_array("color_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="color_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="color_create" value="color_create" <?php if(isset($_GET['edit']) && in_array("color_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="color_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="color_update" value="color_update" <?php if(isset($_GET['edit']) && in_array("color_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="color_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="color_delete" value="color_delete" <?php if(isset($_GET['edit']) && in_array("color_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="color_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Discount Coupon Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="coupon_view" value="coupon_view" <?php if(isset($_GET['edit']) && in_array("coupon_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="coupon_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="coupon_create" value="coupon_create" <?php if(isset($_GET['edit']) && in_array("coupon_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="coupon_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="coupon_update" value="coupon_update" <?php if(isset($_GET['edit']) && in_array("coupon_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="coupon_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="coupon_delete" value="coupon_delete" <?php if(isset($_GET['edit']) && in_array("coupon_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="coupon_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Shipping Charges</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="shipping_view" value="shipping_view" <?php if(isset($_GET['edit']) && in_array("shipping_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="shipping_view" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Delivery Pincodes</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="delivery_view" value="delivery_view" <?php if(isset($_GET['edit']) && in_array("delivery_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="delivery_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="delivery_create" value="delivery_create" <?php if(isset($_GET['edit']) && in_array("delivery_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="delivery_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="delivery_update" value="delivery_update" <?php if(isset($_GET['edit']) && in_array("delivery_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="delivery_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="delivery_delete" value="delivery_delete" <?php if(isset($_GET['edit']) && in_array("delivery_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="delivery_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Banner Master</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="banner_view" value="banner_view" <?php if(isset($_GET['edit']) && in_array("banner_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="banner_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="banner_create" value="banner_create" <?php if(isset($_GET['edit']) && in_array("banner_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="banner_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="banner_update" value="banner_update" <?php if(isset($_GET['edit']) && in_array("banner_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="banner_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="banner_delete" value="banner_delete" <?php if(isset($_GET['edit']) && in_array("banner_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="banner_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Home Page Reviews</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="home_reviews_view" value="home_reviews_view" <?php if(isset($_GET['edit']) && in_array("home_reviews_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="home_reviews_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="home_reviews_create" value="home_reviews_create" <?php if(isset($_GET['edit']) && in_array("home_reviews_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="home_reviews_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="home_reviews_update" value="home_reviews_update" <?php if(isset($_GET['edit']) && in_array("home_reviews_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="home_reviews_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="home_reviews_delete" value="home_reviews_delete" <?php if(isset($_GET['edit']) && in_array("home_reviews_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="home_reviews_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Home CMS</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="home_cms" value="home_cms" <?php if(isset($_GET['edit']) && in_array("home_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="home_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>About Us CMS</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="about_cms" value="about_cms" <?php if(isset($_GET['edit']) && in_array("about_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="about_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Why Selvel CMS</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="why_selvel_cms" value="why_selvel_cms" <?php if(isset($_GET['edit']) && in_array("why_selvel_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="why_selvel_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Selvel Milestones</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="milestones_view" value="milestones_view" <?php if(isset($_GET['edit']) && in_array("milestones_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="milestones_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="milestones_create" value="milestones_create" <?php if(isset($_GET['edit']) && in_array("milestones_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="milestones_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="milestones_update" value="milestones_update" <?php if(isset($_GET['edit']) && in_array("milestones_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="milestones_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="milestones_delete" value="milestones_delete" <?php if(isset($_GET['edit']) && in_array("milestones_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="milestones_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Contact Us CMS</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="contact_cms" value="contact_cms" <?php if(isset($_GET['edit']) && in_array("contact_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="contact_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Terms and Conditions</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="terms_cms" value="terms_cms" <?php if(isset($_GET['edit']) && in_array("terms_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="terms_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Return Policy</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="refund_cms" value="refund_cms" <?php if(isset($_GET['edit']) && in_array("refund_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="refund_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>FAQ</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="faq_view" value="faq_view" <?php if(isset($_GET['edit']) && in_array("faq_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="faq_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox create action_check" id="faq_create" value="faq_create" <?php if(isset($_GET['edit']) && in_array("faq_create", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="faq_create" class="css-label">Create</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox update action_check" id="faq_update" value="faq_update" <?php if(isset($_GET['edit']) && in_array("faq_update", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="faq_update" class="css-label">Edit</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="faq_delete" value="faq_delete" <?php if(isset($_GET['edit']) && in_array("faq_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="faq_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Disclaimer</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="disclaimer_cms" value="disclaimer_cms" <?php if(isset($_GET['edit']) && in_array("disclaimer_cms", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="disclaimer_cms" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Contact Enquiries</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="contact_enquiry_view" value="contact_enquiry_view" <?php if(isset($_GET['edit']) && in_array("contact_enquiry_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="contact_enquiry_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="contact_enquiry_delete" value="contact_enquiry_delete" <?php if(isset($_GET['edit']) && in_array("contact_enquiry_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="contact_enquiry_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Distributor Enquiries</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="distributor_enquiry_view" value="distributor_enquiry_view" <?php if(isset($_GET['edit']) && in_array("distributor_enquiry_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="distributor_enquiry_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="distributor_enquiry_delete" value="distributor_enquiry_delete" <?php if(isset($_GET['edit']) && in_array("distributor_enquiry_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="distributor_enquiry_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Corporate Gifting Enquiries</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="gifting_enquiry_view" value="gifting_enquiry_view" <?php if(isset($_GET['edit']) && in_array("gifting_enquiry_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="gifting_enquiry_view" class="css-label">View</label>
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox delete action_check" id="gifting_enquiry_delete" value="gifting_enquiry_delete" <?php if(isset($_GET['edit']) && in_array("gifting_enquiry_delete", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="gifting_enquiry_delete" class="css-label">Delete</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>E-Catalog Enquiries</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="catalog_enquiry_view" value="catalog_enquiry_view" <?php if(isset($_GET['edit']) && in_array("catalog_enquiry_view", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="catalog_enquiry_view" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Most Viewed Product Report</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="most_viewed_product" value="most_viewed_product" <?php if(isset($_GET['edit']) && in_array("most_viewed_product", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="most_viewed_product" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Most Sold Product Report</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="most_sold_product" value="most_sold_product" <?php if(isset($_GET['edit']) && in_array("most_sold_product", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="most_sold_product" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Least Sold Product Report</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="least_sold_product" value="least_sold_product" <?php if(isset($_GET['edit']) && in_array("least_sold_product", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="least_sold_product" class="css-label">View</label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-4">
											<label>Sales Report</label>
										</div>
										<div class="col-sm-2">
											<input type="checkbox" name="permissions[]" class="css-checkbox view view_check" id="sales_product" value="sales_product" <?php if(isset($_GET['edit']) && in_array("sales_product", $existingPermissionsArray)) { ?> checked <?php } ?> />
											<label for="sales_product" class="css-label">View</label>
										</div>
									</div>

									<label class="error" for="permissions[]" style="display: none"></label>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<?php if(isset($_GET['edit'])){ ?>
									<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id ?>"/>
									<button type="submit" name="update" value="update" id="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>
								<?php } else { ?>
									<button type="submit" name="register" id="register" class="btn btn-danger"><i class="icon-signup"></i>Add <?php echo $pageName; ?></button>
								<?php } ?>
							</div>
						</form>
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
					email: {
						required: true,
						remote:{
							url: "check-employee-email.php",
							type: "post",
							<?php if(isset($_GET['edit'])){ ?>
							data: {
								id: function() {
									return $( "#id" ).val();
								}
							}
							<?php } ?>
						},
						email: true,
					},
					mobile: {
						required: true,
						number:true,
						minlength: 10,
						maxlength: 10,
						remote:{
							url: "check-employee-mobile.php",
							type: "post",
							<?php if(isset($_GET['edit'])){ ?>
							data: {
								id: function() {
									return $( "#id" ).val();
								}
							}
							<?php } ?>
						},
					},
				},
				messages: {
					email: {
						required:"Please enter Employee Email",
						remote:"Employee Email already exists."
					},
					mobile:{
						required: "Please enter Mobile",
						remote:"Sorry, employee already exists with this mobile.",
						mobilevalidity: "Please enter valid mobile number",
						minlength: "Please enter minimum 10 digits for mobile number",
						maxlength: "Please enter maximum 10 digits for mobile number"
					},
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

			$(".action_check").change(function() {
				if($(this).is(":checked")) {
					$(this).closest('.row').find('.view_check').prop('checked',true);
					if($(this).hasClass("create")){
						if($(this).prop("checked") == false){
							$(".create_all").prop("checked", false);
						}else if($(this).prop("checked") == true){
							var total_creates 	= 0;
							var checked_creates = 0;
							$(".create").each(function(){
								total_creates++;
								if($(this).prop("checked") == true) {
									checked_creates++;
								}
							});
							if(total_creates == checked_creates){
								$(".create_all").prop("checked", true);
							}
						}
					}
					if($(this).hasClass("update")){
						if($(this).prop("checked") == false){
							$(".update_all").prop("checked", false);
						}else{
							var total_updates 	= 0;
							var checked_updates = 0;
							$(".update").each(function(){
								total_updates++;
								if($(this).prop("checked") == true) {
									checked_updates++;
								}
							});

							if(total_updates == checked_updates){
								$(".update_all").prop("checked", true);
							}
						}
					}
					if($(this).hasClass("delete")){
						if($(this).prop("checked") == false){
							$(".delete_all").prop("checked", false);
						}else{
							var total_deletes 	= 0;
							var checked_deletes = 0;
							$(".delete").each(function(){
								total_deletes++;
								if($(this).prop("checked") == true) {
									checked_deletes++;
								}
							});

							if(total_deletes == checked_deletes){
								$(".delete_all").prop("checked", true);
							}
						}
					}
				}else{
					if($(this).hasClass("create")){
						$(".create_all").prop("checked",false);
					}
					if($(this).hasClass("update")){
						$(".update_all").prop("checked",false);
					}
					if($(this).hasClass("delete")){
						$(".delete_all").prop("checked",false);
					}
				}
			});

			$(".view_check").change(function() {
				if($(this).closest('.row').find('.create').is(":checked")) {
					$(this).prop('checked',true);
				}
				else if($(this).closest('.row').find('.update').is(":checked")) {
					$(this).prop('checked',true);
				}
				else if($(this).closest('.row').find('.delete').is(":checked")) {
					$(this).prop('checked',true);
				}

				if($(this).prop("checked") == false){
					$(".view_all").prop("checked", false);
				}else{
					var total_views 	= 0;
					var checked_views 	= 0;
					$(".view").each(function(){
						total_views++;
						if($(this).prop("checked") == true) {
							checked_views++;
						}
					});

					if(total_views == checked_views){
						$(".view_all").prop("checked", true);
					}
				}
			});

			$(".view_all").on("click", function(){
				if($(this).is(":checked")) {
					$(".view").prop("checked", true);
				}else{
					if($(".create_all").prop("checked") || $(".update_all").prop("checked") || $(".delete_all").prop("checked")) {
						$(".view_all").prop("checked", true);
					}else{
						$(".view").each(function(){
							if($(this).closest('.row').find('.create').is(":checked")) {
								$(this).prop('checked',true);
							} else if($(this).closest('.row').find('.update').is(":checked")) {
								$(this).prop('checked',true);
							} else if($(this).closest('.row').find('.delete').is(":checked")) {
								$(this).prop('checked',true);
							} else{
								$(this).prop("checked", false);
							}
						});
					}
				}
			});

			$(".create_all").on("click", function(){
				if($(this).is(":checked")) {
					$(".create").prop("checked", true);
					$(".view").prop("checked", true);
					$(".view_all").prop("checked", true);
				}else{
					$(".create").prop("checked", false);
				}
			});

			$(".update_all").on("click", function(){
				if($(this).is(":checked")) {
					$(".update").prop("checked", true);
					$(".view").prop("checked", true);
					$(".view_all").prop("checked", true);
				}else{
					$(".update").prop("checked", false);
				}
			});

			$(".delete_all").on("click", function(){
				if($(this).is(":checked")) {
					$(".delete").prop("checked", true);
					$(".view").prop("checked", true);
					$(".view_all").prop("checked", true);
				}else{
					$(".delete").prop("checked", false);
				}
			});

		});

		function getSubSubCategory() {
			var subcategory = $("#sub_category_id").val();
			$.ajax({
				url:"ajaxGetSubSubCategory.php",
				data:{subcategory:subcategory},
				type:"GET",
				success: function(response){
					var response = JSON.parse(response);
					$("#sub_category_level2").select2('val', response.selectContent);
					$("#sub_category_level2").html(response.selectContent);
				},
				error: function(){
					alert("Unable to add to cart, pleases try again");
				},
				complete: function(response){
					
				}
			}).then(function (response) {
			    // create the option and append to Select2

				$("#sub_category_level2").html(response.selectContent);
			});;
		}
	</script>
</body>
</html>