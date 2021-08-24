<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('about_cms', $loggedInUserDetailsArr);

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	$pageName = "About Us";
	$pageURL = 'about-us.php';
	$tableName = 'about_us';

	$sql = "SELECT * FROM ".PREFIX.$tableName." ";
	$results = $admin->query($sql);
	$data = $admin->fetch($results);

	if(isset($_POST['update'])) {
		if($csrf->check_valid('post')) {
			//update to database
			$result = $admin->updateaboutus($_POST, 'heading');
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
								<div class="card-body">	
									<div class="form-group row">
										<div class="col-md-6">
											<label>Heading <em>*</em></label>
											<input type="text" name="heading" value="<?php echo $data['heading'];  ?>" class="form-control" required />
										</div>
										<div class="col-sm-6">
											<label>Banner Image <em>*</em></label>
											<input type="file" class="form-control" name="banner" id="main_image" accept="image/png, image/jpg, image/jpeg" id="" data-image-index="0"  />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>614 X 380</strong> pixels.
											</span>
											<br>
											<?php 
												$file_name = str_replace('', '-', strtolower( pathinfo($data['banner'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['banner'], PATHINFO_EXTENSION);
											?>
													<img src="../images/about_us/<?php echo $file_name.'.'.$ext ?>" width="100"  />
										
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-md-4">
											<label>Sub Heading <em>*</em></label>
											<input type="text" name="sub_heading" value="<?php echo $data['sub_heading'];  ?>" class="form-control" required />
										</div>
										<div class="col-md-4">
											<label>Bullet Line <em>*</em></label>
											<input type="text" name="bullet_line" value="<?php echo $data['bullet_line'];  ?>" class="form-control" required />
										</div>
										<div class="col-sm-4">
											<label>Image <em>*</em></label>
											<input type="file" class="form-control" name="image1" id="image1" accept="image/png, image/jpg, image/jpeg" id="" data-image-index="0"  />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>614 X 380</strong> pixels.
											</span>
											<br>
											<?php 
												$file_name1 = str_replace('', '-', strtolower( pathinfo($data['image1'], PATHINFO_FILENAME)));
												$ext1 = pathinfo($data['image1'], PATHINFO_EXTENSION);
											?>
													<img src="../images/about_us/<?php echo $file_name1.'.'.$ext1 ?>" width="100"  />
										
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<label>Paragraph 1</label>
											<textarea name="para1" rows="7" id="content"><?php echo $data['para1']; ?></textarea>
										</div>
										<div class="col-sm-4">
											<label>Paragraph 2</label>
											<textarea name="para2" rows="7" id="content2"><?php echo $data['para2']; ?></textarea>
										</div>
										<div class="col-sm-4">
											<label>Paragraph 3</label>
											<textarea name="para3" rows="7" id="content3"><?php echo $data['para3']; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label>Content <em>*</em></label>
											<input type="text" name="content" value="<?php echo $data['content'];  ?>" class="form-control" required />
										</div>
										<div class="col-sm-6">
											<label>Image <em>*</em></label>
											<input type="file" class="form-control" name="image2" id="image2" accept="image/png, image/jpg, image/jpeg" id="" data-image-index="0"  />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>614 X 380</strong> pixels.
											</span>
											<br>
											<?php 
												$file_name2 = str_replace('', '-', strtolower( pathinfo($data['image2'], PATHINFO_FILENAME)));
												$ext2 = pathinfo($data['image2'], PATHINFO_EXTENSION);
											?>
													<img src="../images/about_us/<?php echo $file_name2.'.'.$ext2 ?>" width="100"  />
										
										</div>
										
									</div>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<input type="hidden" class="form-control" name="id" id="" required="required" value="<?php echo $data['id'] ?>"/>
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

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Datatable JS -->
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- CK Editor -->
	<script type="text/javascript" src="assets/js/editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckfinder/ckfinder.js"></script>

	<script type="text/javascript">
		var editor = CKEDITOR.replace( 'content', {
			height: 300,
			filebrowserImageBrowseUrl : 'assets/js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'assets/js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
		CKFinder.setupCKEditor( editor, '../' );
		
		var editor = CKEDITOR.replace( 'content2', {
			height: 300,
			filebrowserImageBrowseUrl : 'assets/js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'assets/js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
		CKFinder.setupCKEditor( editor, '../' );
		
		var editor = CKEDITOR.replace( 'content3', {
			height: 300,
			filebrowserImageBrowseUrl : 'assets/js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'assets/js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
		CKFinder.setupCKEditor( editor, '../' );

	</script>
</body>
</html>