<?php
include 'include/config.php';
include 'include/admin-functions.php';
$admin = new AdminFunctions();
if(!$loggedInUserDetailsArr = $admin->sessionExists()){
	header("location: admin-login.php");
	exit();
}
$pageName ="Profile";
include_once 'csrf.class.php';
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

$invalid_user_name = false;
$invalid_username = false;
$email_invalid = false;
$old_password_invalid = false;
$password_mismatch = false;
$password_not_strong = false;
$password_update=0;
$update_success=0;

if(isset($_POST['update'])) {
	if($csrf->check_valid('post')) {
		$name = $admin->escape_string($admin->strip_all($_POST['name']));
		$username = trim($admin->escape_string($_POST['username']));
		if(isset($_POST['old-password']) && !empty($_POST['old-password'])){
			$old_password = trim($admin->escape_string($_POST['old-password']));
			$password = trim($admin->escape_string($_POST['password']));
			$password2 = trim($admin->escape_string($_POST['password2']));
			if($password!=$password2){
				$password_mismatch = true;
				header("location:profile.php?updatefail&msg=Password mismatch, please re-type the new password correctly");
				exit;
			}

			if(!password_verify($old_password, $loggedInUserDetailsArr['password'])) {
				$old_password_invalid = true;
				header("location:profile.php?updatefail&msg=Old password does not match");
				exit;
			}
			if( $password_not_strong==true || $password_mismatch==true || $old_password_invalid==true ){
				//do nothing
			}else{
				// $pass_hash = md5($password); // DEPRECATED
				$pass_hash = password_hash($password, PASSWORD_DEFAULT);
				$id=$loggedInUserDetailsArr['id'];
				$admin->query("update ".PREFIX."admin set password='$pass_hash', last_modified=now() where id='$id'");
				$password_update=1;
			}
		}

		$id=$loggedInUserDetailsArr['id'];

		$admin->query("update ".PREFIX."admin set full_name='$name', username='$username', last_modified=now() where id='$id'");
		$update_success=1;

		header("location:profile.php?updatesuccess=$update_success&passsuccess=$password_update");
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
	<style>
		em{
			color:red;
		}
	</style>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
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
									<!--<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>-->
									<li class="breadcrumb-item active"><?php
									if(isset($_GET['edit'])) {
										echo 'Edit '.$pageName;
									} else {
										echo 'Update '.$pageName;
									}
									?></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0">Admin Info</h4>
								</div>
								<div class="card-body">
									<?php if(isset($_GET['updatesuccess']) && $_GET['updatesuccess']>0){ ?>
										<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<i class="icon-checkmark"></i> Profile successfully updated.
										</div><br/>
									<?php } ?>

									<?php if(isset($_GET['passsuccess']) && $_GET['passsuccess']>0){ ?>
										<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<i class="icon-key"></i> Password successfully updated.
										</div><br/>
									<?php } if(isset($_GET['updatefail'])){
										$msg=$_GET['msg'];	?>
										<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<i class="icon-close"></i> <strong>Profile not updated.</strong> <?php echo $msg; ?>.
										</div><br/>
									<?php } ?>

									<!-- Animated graphs -->
									<form role="form" action="" name="account" id="account" method="post">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h6 class="panel-title"><i class="icon-office"></i> Admin Details</h6>
											</div>
											<div class="panel-body">
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label>Name <em>*</em></label>
															<input type="text" class="form-control" name="name" id="name" value="<?php echo $loggedInUserDetailsArr['full_name']; ?>"/>

														</div>
													</div>
												</div>
											</div>
										</div>      
										<div class="panel panel-default">
											<div class="panel-heading">
												<h6 class="panel-title"><i class="icon-office"></i>Change Password</h6>
											</div>
											<div class="panel-body">
												<div class="form-group">
													<div class="row">
														<div class="col-sm-3">
															<label>User Name <em>*</em></label>
															<input type="text" class="form-control" name="username" id="username" value="<?php  echo $loggedInUserDetailsArr['username']; ?>" >
														</div>
														<div class="col-sm-3">
															<label>Old Password </label>
															<input type="password" class="form-control" name="old-password" id="old-password">
															<span class="help-block">Leave blank if you don't want to change password</span>
														</div>
														<div class="col-sm-3">
															<label>New Password </label>
															<input type="password" class="form-control" name="password" id="password">
															
														</div>
														<div class="col-sm-3">
															<label>Retype New Password </label>
															<input type="password" class="form-control" name="password2" id="password2">
														</div>
													</div>
												</div>
											</div>
										</div><!--/panel-default-->

										<div class="form-actions text-right">
											<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
											<button type="submit" name="update" id="update" class="btn btn-danger"><i class="icon-signup"></i>Update Profile</button>
										</div>
									</form>
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

		<!-- Validate JS -->
		<script src="assets/js/jquery.validate.js"></script>
		<script src="assets/js/additional-methods.js"></script>
		<script>
			$(document).ready(function() {
				$("#account").validate({
					rules: {
						name : {
							required: true,
						},
						email_id: {
							required: true,
							email: true,
						},
						password2 : {
							equalTo : "#password"
						}
					},
					messages: {
						password2 : {
							equalTo : "Re password doesn't match with new password"
						}
					}
				});

				jQuery.validator.addMethod("validateGST", function(value, element) {
					return this.optional(element) || /^\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/g.test(value);
				}, "Please enter valid GST Number");
			});
		//	}
	</script>

</body>
</html>