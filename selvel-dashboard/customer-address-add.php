<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Customer Address";
	$parentPageURL = 'customer-address.php';
	$pageURL = 'customer-address-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(isset($_GET['customer_id']) && !empty($_GET['customer_id'])){
		$customer_id = trim($admin->escape_string($admin->strip_all($_GET['customer_id'])));
	} else {
		header("location:customer-master.php?INVALIDCAT");
		exit;
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$customer_id = trim($admin->escape_string($admin->strip_all($_POST['customer_id'])));

			$result = $admin->addCustomerAddress($_POST, $_FILES);
			header("location:".$pageURL."?registersuccess&customer_id=".$customer_id);
			exit;
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueCustomerAddressById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$customer_id = trim($admin->escape_string($admin->strip_all($_POST['customer_id'])));

			$result = $admin->updateCustomerAddress($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess&edit&id=".$id."&customer_id=".$customer_id);
			exit;
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
								<li class="breadcrumb-item"><a href="<?php echo $parentPageURL.'?cat_id='.$category_id; ?>"><?php echo $pageName; ?></a></li>
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
							<a href="<?php echo $parentPageURL.'?customer_id='.$customer_id; ?>" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to <?php echo $pageName; ?></a>
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
									<h4 class="card-title mb-0"> Details</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-4">
											<label>Name <em>*</em></label>
											<input type="text" name="customer_fname" value="<?php if(isset($_GET['edit'])) { echo $data['customer_fname']; } ?>" class="form-control" required />
										</div>
										<div class="col-md-4">
											<label>Contact <em>*</em></label>
											<input type="text" name="customer_contact" value="<?php if(isset($_GET['edit'])) { echo $data['customer_contact']; } ?>" class="form-control" required />
										</div>
										<div class="col-md-4">
											<label>Email <em>*</em></label>
											<input type="text" name="customer_email" value="<?php if(isset($_GET['edit'])) { echo $data['customer_email']; } ?>" class="form-control" required />
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label>Address1 <em>*</em></label>
											<textarea class="form-control" name="address1" rows="3" required><?php if(isset($_GET['edit'])) { echo $data['address1']; } ?></textarea>
										</div>
										<div class="col-md-6">
											<label>Address2 </label>
											<textarea class="form-control" name="address2" rows="3"><?php if(isset($_GET['edit'])) { echo $data['address2']; } ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
											<label>State <em>*</em></label>
											<select name="state" class="form-control" required="required" onchange="getShippingCity(this.value)">
												<option value="">Please Select State</option>
												<?php
													$stateRS = $admin->getListOfStates();
													while($stateRow = $admin->fetch($stateRS)) {
												?>
														<option value="<?php echo $stateRow['statename'] ?>" <?php if(isset($_GET['edit']) and ($stateRow['statename']==$data['state'] || ucwords($stateRow['statename'])==ucwords($data['state']))) { echo "selected"; } ?>><?php echo ucwords($stateRow['statename']) ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label>City <em>*</em></label>
											<select required="" class="form-control" name="city">
												<option value="">Please Select City</option>
												<?php
													if(isset($_GET['edit'])) {
														$state = $admin->escape_string($admin->strip_all($data['state']));
														$sql="select DISTINCT(name),id from ".PREFIX."states where name='".$state."' order by name";
														$result = $admin->query($sql);
														$stateData =$admin->fetch($result);
														$sql = "SELECT * FROM ".PREFIX."cities WHERE `state_id`='".$stateData['id']."'";

														$cityResult = $admin->query($sql);
														$cityStr='<option value="">Please select city</option>';
														while($cityRow = $admin->fetch($cityResult)){
												?>
															<option value="<?php echo $cityRow['name'] ?>" <?php if($cityRow['name']==$data['city'] || ucwords($cityRow['name']) == ucwords($data['city'])) { echo "selected"; } ?>><?php echo $cityRow['name'] ?></option>
												<?php
														}
													}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label>Pincode <em>*</em></label>
											<input type="text" name="pincode" value="<?php if(isset($_GET['edit'])) { echo $data['pincode']; } ?>" class="form-control" required />
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
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

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					
				},
				messages: {
					
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

		});

		function getShippingCity(state) {
			$.ajax({
				url:"<?php echo BASE_URL."/ajaxGetCityByState.php" ?>",
				data:{state:state},
				type:"post",
				success: function(response){
					var response = JSON.parse(response);
					$("select[name='city']").html(response.cityStr);
				},
				error: function(){
					alert("Something went wrong, please try again");
				},
				complete: function(response){
					
				}
			});
		}
	</script>
</body>
</html>