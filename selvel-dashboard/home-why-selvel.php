<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('home_cms', $loggedInUserDetailsArr);

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	$pageName = "Why Selvel(Home Page)";
	$pageURL = 'home-why-selvel.php';
	$tableName = 'why_selvel_home';

	$sql = "SELECT * FROM ".PREFIX.$tableName." ";
	$results = $admin->query($sql);
	$data = $admin->fetch($results);

	if(isset($_POST['update'])) {
		if($csrf->check_valid('post')) {
			//update to database
			$result = $admin->updatewhyselvel($_POST,'description');
			header("location:".$pageURL."?updatesuccess");
			exit;
		}
	}
	if(isset($_POST['add_why'])) 
	{		


				
			//update to database
			$result = $admin->upwhyselvel($_POST,$_FILES);
			header("location:".$pageURL."?updatesuccess");
			exit;
				
	}
	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['editId']));
		$sqlq = "SELECT * FROM ".PREFIX.$tableName." where id='$id'";
	$resultsq = $admin->query($sqlq);
	$dataq = $admin->fetch($resultsq);
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
										<div class="col-md-6">
											<label>Tag Line <em>*</em></label>
											<input type="text" name="tag_line" value="<?php echo $data['tag_line'];  ?>" class="form-control" required />
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<label>Banner Image <em>*</em></label>
											<input type="file" class="form-control" name="main_image" id="main_image" accept="image/png, image/jpg, image/jpeg" id="" data-image-index="0"  />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>614 X 380</strong> pixels.
											</span>
											<br>
											<?php 
												$file_name = str_replace('', '-', strtolower( pathinfo($data['main_image'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['main_image'], PATHINFO_EXTENSION);
											?>
													<img src="../images/why-selvel/<?php echo $file_name.'.'.$ext ?>" width="100"  />
										
										</div>
										
									
										<div class="col-sm-6">
											<label>Description</label>
											<textarea name="description" rows="7" id="content"><?php echo $data['description']; ?></textarea>
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
							<?php
								if(isset($_GET['edit'])){
							?>
							<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="card">
								
								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-4">
											<label>Text <em>*</em></label>
											<input type="text" name="text" value="<?php echo $dataq['text']; ?>" class="form-control" required />
										</div>
										
										<div class="col-sm-4">
											<label>Image <em>*</em></label>
											<input type="file" class="form-control" name="image" id="image" accept="image/png" id="" data-image-index="0"  />
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>32 X 32</strong> pixels.
											</span>
											<br>
											<?php 
												$file_name = str_replace('', '-', strtolower( pathinfo($dataq['image'], PATHINFO_FILENAME)));
												$ext = pathinfo($dataq['image'], PATHINFO_EXTENSION);
											?>
													<img src="../images/why-selvel/<?php echo $dataq['image']; ?>" width="30" style="background:#442e8c "  />
											<?php
												
											?>
										</div>
									
										
									</div>
									
								</div>
							</div>
							<div class="form-actions text-right">
										
										<input type="hidden" name="idd" value="<?php echo $dataq['id']; ?>" class="form-control" required />
										<button type="submit" name="add_why" value="add" id="add" class="btn btn-warning">Update </button>
										</div>
							</form>	
								<?php } ?>
							<div class="row">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable-selectable-data">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Text</th>
									
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
											<td><img src="../images/why-selvel/<?php echo $row['image']; ?>" style="background:#442e8c" /></td>
											<td><?php echo $row['text']; ?></td>
											
											<td>
												<a class="btn-transition btn" href="home-why-selvel.php?edit&editId=<?php echo $row['id']; ?>"  title="Delete"> <i class="fa fa-pencil"></i> </a>
												<a class="btn-transition btn" href="<?php echo $deleteURL; ?>?delId=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a>
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
			height: 150,
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