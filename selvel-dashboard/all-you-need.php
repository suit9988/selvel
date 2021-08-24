<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	$pageName = "All You Need";
	$pageURL = 'all-you-need.php';
	$tableName = 'all_need';

	$sql = "SELECT * FROM ".PREFIX.$tableName." ";
	$results = $admin->query($sql);
	$data = $admin->fetch($results);

	if(isset($_POST['update'])) {
		if($csrf->check_valid('post')) {
			//update to database
			$result = $admin->updateAllYouNeed($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess");
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

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]
	-->

	<!-- Crop Image css -->
	<link href="assets/css/crop-image/cropper.min.css" rel="stylesheet">

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
						<form action="" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Details</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-3">
											<label>Image 1</label>
											<input type="file" class="form-control file"  name="image_name" data-image-index="0" />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>400 x 400</strong> pixels.
											</span>
											<?php 
												if(!empty($data['image_name'])){
													$file_name = str_replace('', '-', strtolower( pathinfo($data['image_name'], PATHINFO_FILENAME)));
													$ext = pathinfo($data['image_name'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  />
											<?php
												}
											?>
										</div>
										<div class="col-sm-3">
											<label>Title</label>
											<input type="text" class="form-control" required name="title1" id="title1" value="<?php  echo $data['title1']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Description</label>
											<input type="text" class="form-control" required name="description1" id="description1" value="<?php  echo $data['description1']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Link</label>
											<input type="text" class="form-control" required name="link1" id="link1" value="<?php  echo $data['link1']; ?>"/>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-3">
											<label>Image 2</label>
											<input type="file" class="form-control file"  name="image_name2" data-image-index="1" />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>400 x 400</strong> pixels.
											</span>
											<?php 
												if(!empty($data['image_name2'])){
													$file_name = str_replace('', '-', strtolower( pathinfo($data['image_name2'], PATHINFO_FILENAME)));
													$ext = pathinfo($data['image_name2'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  />
											<?php
												}
											?>
										</div>
										<div class="col-sm-3">
											<label>Title</label>
											<input type="text" class="form-control" required name="title2" id="title2" value="<?php  echo $data['title2']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Description</label>
											<input type="text" class="form-control" required name="description2" id="description2" value="<?php  echo $data['description2']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Link</label>
											<input type="text" class="form-control" required name="link2" id="link2" value="<?php  echo $data['link2']; ?>"/>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-3">
											<label>Image 3</label>
											<input type="file" class="form-control file"  name="image_name3" data-image-index="2" />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>400 x 400</strong> pixels.
											</span>
											<?php 
												if(!empty($data['image_name3'])){
													$file_name = str_replace('', '-', strtolower( pathinfo($data['image_name3'], PATHINFO_FILENAME)));
													$ext = pathinfo($data['image_name3'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  />
											<?php
												}
											?>
										</div>
										<div class="col-sm-3">
											<label>Title</label>
											<input type="text" class="form-control" required name="title3" id="title3" value="<?php  echo $data['title3']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Description</label>
											<input type="text" class="form-control" required name="description3" id="description3" value="<?php  echo $data['description3']; ?>"/>
										</div>
										<div class="col-sm-3">
											<label>Link</label>
											<input type="text" class="form-control" required name="link3" id="link3" value="<?php  echo $data['link3']; ?>"/>
										</div>
									</div>

								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<input type="hidden" class="form-control" name="id" id="" value="<?php echo $data['id'] ?>"/>
								<button type="submit" name="update" value="update" id="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>
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

	<!-- Crop Image js -->
	<script src="assets/js/crop-image/cropper.min.js"></script>
	<script src="assets/js/crop-image/image-crop-app.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					image_name: {
						extension: "jpg|jpeg|png"
					},
					image_name2: {
						extension: "jpg|jpeg|png"
					},
					image_name3: {
						extension: "jpg|jpeg|png"
					},
					link1: {
						url: true
					},
					link2: {
						url: true
					},
					link3: {
						url: true
					}
				},
				messages: {
					image_name: {
						extension: "Please upload jpg or png image"
					},
					image_name2: {
						extension: "Please upload jpg or png image"
					},
					image_name3: {
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

			$('.file').change(function(){
				loadImagePreview(this, (400 / 400));
			});

		});
	</script>
</body>
</html>