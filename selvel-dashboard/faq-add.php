<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('faq_view', $loggedInUserDetailsArr);

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	$pageName = "FAQs";
	$pageURL = 'faq-add.php';
	//$tableName = 'urine_discription';

	$sql = "SELECT * FROM slv_faq_question_answer";
	$results = $admin->query($sql);
	$data = $admin->fetch($results);

	if(isset($_GET['delId']) && !empty($_GET['delId']) ){
		$delId = trim($admin->strip_all($_GET['delId']));

		$admin->delfaq_question_answers($delId);

		header('location: '.$pageURL.'?deletesuccess');
		exit;
	}
	
	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$sql_m = "SELECT * FROM slv_faq_question_answer where id='$id'";
	$results_m = $admin->query($sql_m);
	$data_m = $admin->fetch($results_m);
		
	}
	
	if(isset($_POST['update'])) {
		if($csrf->check_valid('post')) {
			//update to database
			$result = $admin->updatefaq_question_answers($_POST, 'question');
			header("location:".$pageURL."?updatesuccess");
			exit;
		}
	}
	
	if(isset($_POST['add'])) {
		if($csrf->check_valid('post')) {
			//update to database
			$result = $admin->faq_question_answers($_POST,'question','answer');
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
							<?php if(in_array('faq_create',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
								<div class="card">
									<div class="card-header">
										<h4 class="card-title mb-0">Add FAQs Question Answer :</h4>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<div class='col-md-12'>
												<label> Question </label>
												<input type="text" value="<?php if(isset($_GET['edit'])) { echo $data_m['question']; } ?>" name="question" class="form-control" >
											</div>
											
											<div class="col-md-12">
												<label> Answer </label>
												<textarea name="answer" id='content' rows="2"><?php if(isset($_GET['edit'])) { echo $data_m['answer']; } ?></textarea>
											</div>
											<div class="col-md-12">
												<label> Display Order </label>
												<input type="text" name="display_order" id='content' class="form-control"  rows="2" value="<?php if(isset($_GET['edit'])) { echo $data_m['display_order']; } ?>" />
											</div>
										</div>
									</div>
								</div>

								<div class="form-actions text-right">
									<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
									<input type="hidden" class="form-control" name="id" id="" required="required" value="<?php echo $data['id'] ?>"/>

									<?php if(isset($_GET['edit'])) { ?>
										<input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) { echo $data_m['id']; } ?>" class="form-control"  />
											<button type="submit" name="update" value="add" id="add" class="btn btn-warning" style="float:right">Update  </button>
									<?php
										}
										else { ?>
										<button type="submit" name="add" value="add" id="add" class="btn btn-warning" style="float:right">Add  <?php echo $pageName; ?></button>
									<?php } ?>
									<br><br>
								</div>
							<?php } ?>
							</div>
							</div>
							<div class="row">
					<div class="col-md-12">
					   	<table class="table table-striped custom-table mb-0 data-table1">
						<thead>
							<tr>
							    <th>#</th>
							
							 
							    <th>Question</th>
							    <th>Answer</th>
								 <th>Display Order</th>
							    <th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$x = 1;
								$sql_mm = "SELECT * FROM slv_faq_question_answer";
								$results_mm = $admin->query($sql_mm);
								while($row_mm = $admin->fetch($results_mm)){
							?>
									<tr>
										<td><?php echo $x++ ?></td>
										<td><?php echo $row_mm['question']; ?></td>
										
										<td><?php echo $row_mm['answer']; ?></td>
											<td><?php echo $row_mm['display_order']; ?></td>
										
										<td>
										<div class="flexbox">
											<?php
												if(in_array('faq_update',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
											?>
													<a class="btn-transition btn" href="faq-add.php?edit&id=<?php echo $row_mm['id']; ?>" title="Edit">   <i class="fa fa-pencil"></i> </a>
											<?php
												}
												if(in_array('faq_delete',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
											?>
													<a class="btn-transition btn" href="faq-add.php?delId=<?php echo $row_mm['id']; ?>&tp=<?php echo $tp; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a>
											<?php
												}
											?>
										</div>
										</td>
									</tr>
							<?php
								}
							?>
							</tbody>
							</table>
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
			height: 100,
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
	<script>

	    

	     $(".data-table1").dataTable( {

  "lengthMenu": [ 50, 75, 100 ]

} );

	</script>
</body>
</html>