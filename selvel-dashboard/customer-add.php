<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Customer";
	$parentPageURL = 'customer-master.php';
	$pageURL = 'customer-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(isset($_GET['edit'])) {
		$admin->checkUserPermissions('customer_update',$loggedInUserDetailsArr);
	} else {
		$admin->checkUserPermissions('customer_create',$loggedInUserDetailsArr);
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$result = $admin->addCustomer($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess");
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueCustomerById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateCustomer($_POST, $_FILES);
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
											<input type="text" name="first_name" id="first_name" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['first_name']; } ?>" required/>
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
												<option value="">Active</option>
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
							url:"check-user-email.php",
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
					},
				},
				messages: {
					email: {
						remote: "Email ID already exists"
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

			$('input[name="main_image"],input[name="image_one"],input[name="image_two"],input[name="image_three"],input[name="image_four"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});

			$('#sub_category_id').on("change",getSubSubCategory);

			$("#category").on("change", function(){
				var category_id = $(this).val();

				$.ajax({
					url:"ajaxGetSubCategoryByCategoryId.php",
					data:{category_id:category_id},
					type:"POST",
					success: function(response){
						$("#sub_category_id").select2('val', response.selectContent);
						$("#sub_category_level2").select2('val', response.selectContent);
						$("#sub_category_id").html(response);
						//$('#sub_category_id').on("change",getSubSubCategory);

					},
					error: function(){
						alert("Unable to get content, please try again");
					},
					complete: function(response){
						
					}
				});

				$.ajax({
					url:"ajaxGetCategoryFilters.php",
					data:{category_id:category_id},
					type:"POST",
					success: function(response){
						var response = JSON.parse(response);
						$("#product-filter-div").html(response.responseContent);
					},
					error: function(){
						alert("Unable to add to cart, please try again");
					},
					complete: function(response){
						
					}
				});
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