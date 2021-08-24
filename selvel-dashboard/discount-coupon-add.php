<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Discount Coupon";
	$parentPageURL = 'discount-coupon-master.php';
	$pageURL = 'discount-coupon-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$result = $admin->addDiscountCoupon($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess");
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueDiscountCouponById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateDiscountCoupon($_POST, $_FILES);
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
									<h4 class="card-title mb-0"> Details</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-3">
											<label>Coupon Code <em>*</em></label>
											<input type="text" class="form-control" required="required" name="coupon_code" id="" value="<?php if(isset($_GET['edit'])){ echo $data['coupon_code']; }?>"/>
										</div>
										<div class="col-sm-3">
											<label>Coupon Code Type</label>
											<select name="coupon_type" class="form-control" id="coupon_type">
												<option value="amount" <?php if(isset($_GET['edit']) and $data['coupon_type']=='amount') { echo 'selected'; } ?>>Amount Discount</option>
												<option value="percent" <?php if(isset($_GET['edit']) and $data['coupon_type']=='percent') { echo 'selected'; } ?>>Percentage Discount</option>
											</select>
										</div>
										<div class="col-sm-3">
											<label>Coupon Value (<span class="couponlabel">INR</span>)<em>*</em></label>
											<input type="text" class="form-control" required="required" name="coupon_value" id="coupon_value" value="<?php if(isset($_GET['edit'])){ echo $data['coupon_value']; }?>"/>
										</div>
										<div class="col-sm-3">
											<label>Minimum Purchase Amount (INR)<em>*</em></label>
											<input type="text" class="form-control" required="required" name="minimum_purchase_amount" id="minimum_purchase_amount" value="<?php if(isset($_GET['edit'])){ echo $data['minimum_purchase_amount']; }?>"/>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-3">
											<label>Validity From<em>*</em></label>
											<input type="text" class="form-control valid_date" readonly name="valid_from" id="valid_from" value="<?php if(isset($_GET['edit'])){ echo $data['valid_from']; }?>" />
										</div>
										<div class="col-sm-3">
											<label>Validity To<em>*</em></label>
											<input type="text" class="form-control valid_date" readonly name="valid_to" id="valid_to" value="<?php if(isset($_GET['edit'])){ echo $data['valid_to']; }?>" />
										</div>
										<div class="col-sm-3">
											<label>Coupon Usage</label>
											<select name="coupon_usage" class="form-control">
												<option value="single" <?php if(isset($_GET['edit']) and $data['coupon_usage']=='single') { echo 'selected'; } ?>>Single Usage</option>
												<option value="multiple" <?php if(isset($_GET['edit']) and $data['coupon_usage']=='multiple') { echo 'selected'; } ?>>Multiple Usage</option>
											</select>
										</div>
										<div class="col-sm-3">
											<label>Active</label>
											<select class="form-control" name="active">
												<option value="1" <?php if(isset($_GET['edit']) and $data['active']=='1') { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if(isset($_GET['edit']) and $data['active']=='0') { echo 'selected'; } ?>>No</option>
											</select>
										</div>
									</div>
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

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<!-- DatePicker JS -->
	<link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="assets/js/bootstrap-datepicker.min.js"></script>
	<script src="assets/js/Moment.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			var start_date = new Date();
			$('.valid_date').datepicker({
				format: "yyyy-mm-dd",
				startDate: start_date,
				autoclose: true,
			});

			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					coupon_code:{
						required:true,
					},
					valid_from: {
						required: true,
					},
					valid_to: {
						required: true,
						greaterThan: "#valid_from"
					},
					coupon_value: {
						required: true,
						number: true,
						min: 1
					},
					minimum_purchase_amount: {
						number: true,
						min: 0
					}
				},
				messages: {
					
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

			jQuery.validator.addMethod("greaterThan", 
			function(value, element, params) {
				if (!/Invalid|NaN/.test(new Date(value))) {
					return new Date(value) > new Date($(params).val());
				}
				return isNaN(value) && isNaN($(params).val()) 
					|| (Number(value) > Number($(params).val())); 
			},'Must be greater than {0}.');

			$("#coupon_type").change(validateValue);
			validateValue();
		});

		function validateValue() {
			var percentRules = {
				coupon_value: {
					required: true,
					number: true,
					min:1,
					max: 100
				}
			};
			var amountRules = {
				coupon_value: {
					required: true,
					number: true,
					min:1,
				}
			};
			var coupon_type = $("#coupon_type").val();
			console.log(coupon_type);
			if(coupon_type=='percent') {
				removeRules(amountRules);
				addRules(percentRules);
				$(".couponlabel").html('%');
				//$("#coupon_value").val("");
				//coupon_value
			}
			else if(coupon_type=='amount') {
				removeRules(percentRules);
				addRules(amountRules);
				// $("#coupon_value").val("");
				$(".couponlabel").html('INR');
			}
		}
		function addRules(rulesObj){
			for (var item in rulesObj){
			   $('#'+item).rules('add',rulesObj[item]);
			}
		}

		function removeRules(rulesObj){
			for (var item in rulesObj){
			   $('#'+item).rules('remove');
			}
		}
	</script>
</body>
</html>