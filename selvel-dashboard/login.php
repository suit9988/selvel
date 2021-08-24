<?php
	include 'include/admin-functions.php';

	$admin = new AdminFunctions();
	if($admin->sessionExists()){
		header("location: index.php");
		exit();
	}

	include 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['signin'])){
		if($csrf->check_valid('post')) {
			$admin->adminlogin($_POST, "index.php");
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
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo FAVICON; ?>">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="account-page">
	<div class="gif-loader">
		<img src="https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif" />
	</div>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="account-content">
			<div class="container">
				<!-- Account Logo -->
				<div class="account-logo">
					<img src="<?php echo LOGO ?>" alt="<?php echo SITE_NAME ?>" style="width: 200px;">
				</div>
				<!-- /Account Logo -->

				<div class="account-box">
					<div class="account-wrapper">
						<h3 class="account-title">Login</h3>
						<p class="account-subtitle">Access to our dashboard</p>

						<?php if(isset($_GET['failed'])){ ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<i class="fa fa-times"></i> Invalid Login Details.
							</div><br/>
						<?php } ?>

						<!-- Account Form -->
						<form action="" method="post" id="form">
							<div class="form-group">
								<label>Username</label>
								<input class="form-control" type="text" name="username" autofocus required>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input class="form-control" type="password" name="password" required>
							</div>
							<div class="form-group text-center">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<button class="btn btn-primary account-btn" type="submit" name="signin">Login</button>
							</div>
						</form>
						<!-- /Account Form -->

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>
	<script>
		$(document).ready(function() {
			$("#form").validate({
				ignore: ".ignore",
				rules: {
                    username: {
                        required: true
                    },
					password: {
						required: true,

					},
				},
				messages: {

					password: {
						required: 'Please enter your password',
					},
				},
				submitHandler: function(){
					$(".account-btn").hide();
					$(".gif-loader").show();
					form.submit();
				}, 
				invalidHandler: function(){
					$(".account-btn").show();
					$(".gif-loader").hide();
				}
			});
		});
	</script>

</body>
</html>