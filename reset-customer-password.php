<?php
	include_once 'include/functions.php';
	$functions = new Functions();
	if($loggedInUserDetailsArr = $functions->sessionExists()){
	//	header("location: index.php");
	//	exit;
	}
	$errorArr = array();
	if(isset($_GET['success'])){
		
	} else if(isset($_GET['v']) && !empty($_GET['v'])) {
		$v = $functions->escape_string($functions->strip_all($_GET['v']));
		//echo $v; exit;
		if( (empty($v) || !preg_match("/^[A-z0-9]{1,}$/", $v)) ){
			$errorArr[] = "INVALIDURL";
		}
		if(count($errorArr)>0){
			$errorStr = implode("|", $errorArr);
			header("location: ".BASE_URL."/reset-customer-password.php?error=".$errorStr);
			exit;
		} else {
			if(isset($_POST['reseturl']) && isset($_POST['password']) && !empty($_POST['password'])  ){
				$passwordResetToken = $functions->escape_string($functions->strip_all($_POST['reseturl']));
				$newPassword = $functions->escape_string($functions->strip_all($_POST['password']));

				$updatedRows = $functions->resetCustomerPassword($passwordResetToken, $newPassword);
				if($updatedRows>0){ // new password was set
					header("location: ".BASE_URL."/reset-customer-password.php?success");
					exit;
				} else { // user already reset the password or user does not exists
					header("location: ".BASE_URL."/reset-customer-password.php?error=INVALIDURL");
					exit;
				}
			}
		}
	} else if(!isset($_GET['error']) || empty($_GET['error'])){
		header("location: ".BASE_URL."/reset-customer-password.php?error=INVALIDURL");
		exit;
	}
?>
<!DOCTYPE>
<html>
   <head>
     <title>SELVEL - Listing Page</title>
      <meta name="description" content="SELVEL">
      <meta name="keywords" content="SELVEL">
      <meta name="author" content="SELVEL">
      <?php include("include/header-link.php");?>
   </head>
   <body class="inner-page">
      <!--Top start menu head-->       
      <?php include("include/header.php");?>
      <main class="main-inner-div">
         <img src="images/details-banner-header.jpg" class="img-full fixedimg">  
      <!--Main Start Code Here-->
      	<section id="aboutpage" align="center" class="section about-us-section">
            <div class="container-fluid">
			   <div class="login-box" id="reset-forgot-password">
                <h1 class="page-heading">Reset Password</h1>
                    <?php
						if(isset($_GET['error']) && !empty($_GET['error'])){
					?>
							<div class="alert alert-danger">
								<ul>
									<?php
										$errorArr = explode("|", $_GET['error']);
										foreach($errorArr as $oneError){
											switch($oneError){
												case "INVALIDURL":
													echo "<li><i class=\"fa fa-warning\"></i> This link is no longer active</li>";
													break;
												default:
													break;
											}
										}
									?>
								</ul>
							</div>

							<div class="row center">
								<div class="col-sm-4">
									<a id="login-pg" data-fancybox data-type="iframe" data-src="<?php echo BASE_URL; ?>/index.php?loginwithnewpwd" href="javascript:;" class="email_sbt_btn red_btn login-btn1">Login Now <i class="fa fa-chevron-right"></i></a>
								</div>
							</div>
							<br>
                	<?php
						}
						if(isset($_GET['success'])){
					?>
							<div class="alert alert-success">
								<i class="fa fa-check"></i> You have successfully reset your <?php echo SITE_NAME; ?> account password. You can now <a href="<?php echo BASE_URL; ?>/login.php">login</a> to your <?php echo SITE_NAME; ?> account.
							</div>
							<a href="<?php echo BASE_URL; ?>/login.php" class="btn red-btn">Login Now <i class="fa fa-chevron-right"></i></a>
							<br>
							<br>
                    <?php
						} else if(isset($_GET['v']) && !empty($_GET['v'])) {
					?>
                            <form id="register-form" method="post">
								<ul class="reset">
									<li class="passord-toogle form-group minsisd">
										<input type="text" class="form-control password-show" placeholder="Enter New Password" name="password" id="password" />
                                  		<i class="fa fa-eye passwordtoggle"></i>													
									<br>
									</li>
									<li class="passord-toogle form-group minsisd">
										<input type="text" class="form-control password-shows" placeholder="Re-enter New Password" name="cnfpassword" id="cnfpassword" />
                                  		<i class="fa fa-eye passwordtoggles"></i>													
									</li>
									<li>
										<input name="reseturl" type="hidden" id="reseturl" value="<?php echo $v; ?>">
										<button type="submit" class="btn red-btn btn-animation" name="register">Submit</button>
									</li>
								</ul>
							</form>
				<?php 
						} ?>
                </div>
            </div>
        </section>
    </main>          
      <!--Main End Code Here-->
      <!--footer start menu head-->
      <?php include("include/footer.php");?>
      <!--footer end menu head-->
      <?php include("include/footer-link.php");?>
      <script type="text/javascript">
         $(".niceselect").niceSelect();
      </script>
	   <script>
		$(document).ready(function(){
			$("#register-form").validate({
                ignore: ".ignore",
				rules: {
					password:{
						required:true,
						// pwcheck:true
						minlength: 8,
						maxlength: 12,
					},
					cnfpassword:{
						required:true,
						equalTo: '#password'
					}
				},
				messages: {
					fname: {
						required: "First name is required"
					},
					lname: {
						required: "Last name is required"
					},
					email: {
						required: 'please enter your email address',
						remote:'Sorry, an account is already registered with that E-mail ID.'
					},
				}
			});

			jQuery.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
			}, "Only letters are allowed");
			jQuery.validator.addMethod("pwcheck", function(value) {
				if(value!=''){
					return /^[A-Za-z0-9@!#]{8,}$/.test(value) // consists of only these
						&& /[a-zA-Z ]/.test(value) // has a lowercase letter
						&& /\d/.test(value) // has a digit
				} else {
					return true;
				}
			}," Password should be minimum 8 characters, alpha numeric & atleast 1 special character");
		});
	</script>
   </body>
</html>