<?php 
   include_once 'include/functions.php';
   $functions = new Functions();
   
   if($loggedInUserDetailsArr = $functions->sessionExists()) {
   	header("location: index.php");
   	exit;
   }
   
   if(isset($_GET['redirect']) and !empty($_GET['redirect'])) {
   	$redirect = $functions->escape_string($functions->strip_all($_GET['redirect']));
   } else {
   	$redirect = "";
   }
   
   if(isset($_GET['productredirect']) and !empty($_GET['productredirect'])) {
   	$productredirect = $functions->escape_string($functions->strip_all($_GET['productredirect']));
   } else {
   	$productredirect = "";
   }
   
   if(isset($_POST['login_btn'])){
   	$email = $functions->escape_string($functions->strip_all($_POST['email']));
   	$password = $functions->escape_string($functions->strip_all($_POST['password']));
   	$redirect_url = $functions->escape_string($functions->strip_all($_POST['redirect_url']));
   	$productredirect = $functions->escape_string($functions->strip_all($_POST['productredirect']));
   
   	$successURL = 'index.php';
   	if(!empty($redirect_url)) {
   		$successURL = $redirect_url;
   	}
   
   	if(!empty($productredirect)) {
   		$productDetails = $functions->getProductByproductPermalink($productredirect);
   		$productPerma = $functions->getProductDetailPageURL($productDetails['id']);
   		$successURL = BASE_URL.'/'.$productPerma;
   		//exit();
   	}
   
   	$functions->userLogin($_POST, $successURL, "login.php?failed");
   	exit;
   }
   
	if(isset($_POST['forgot_btn'])) {
		$email  = $functions->escape_string($functions->strip_all($_POST['email']));

		if(empty($email)){
			header("Location: ".BASE_URL."/login.php?fp&loginfail&forgot_email");
			exit;
		} else {
			$passwordResetResponse = $functions->setUserPasswordResetCode($email);
			if($passwordResetResponse['updateSuccess']>0) { // new password was updated in database
				if(!empty($passwordResetResponse['email'])){
					include_once("include/emailers/forgot-pwd-email.inc.php");
	   
					//SMTP
					include_once("include/classes/Email.class.php");
	   
					$to = $passwordResetResponse['email'];
					$subject = SITE_NAME." | Reset your Password";
	   
					$emailObj = new Email();
					$emailObj->setAddress($to);
					$emailObj->setSubject($subject);
					$emailObj->setEmailBody($emailMsg);
					$emailObj->sendEmail();
					//SMTP END
				}
	   
				header("location: ".BASE_URL."/login.php?fp&resetsuccess");
				exit;
			} else {
				// customer does not exists
				header("location: ".BASE_URL."/login.php?fp&user-does-not-exists");
				exit;
			}
		}
	}

	include_once "include/social-login-config.inc.php";

	$loginUrl = $helper->getLoginUrl(BASE_URL.'/social-login-callback.php?redirect='.BASE_URL.'/index.php', $permissions);

	$google_redirect_url 	= BASE_URL.'/google-login-callback.php?redirect='.BASE_URL.'/index.php'; 
	$gClient->setRedirectUri($google_redirect_url);
	$authUrl = $gClient->createAuthUrl();
?>
<!DOCTYPE>
<html>
   <head>
      <title>SELVEL - HOME</title>
      <meta name="description" content="SELVEL">
      <meta name="keywords" content="SELVEL">
      <meta name="author" content="SELVEL">
      <?php include("include/header-link.php");?>
   </head>
   <body class="inner-page">
      <!--Top start menu head-->       
      <?php include("include/header.php");?>
      <!--Main Start Code Here-->
      <main class="main-inner-div">
      <img src="images/details-banner-header.jpg" class="img-full fixedimg">  
      <div class="container breadcum-header">
         <ul>
            <li>
               <a href="#">Home</a>
               <i class="fa fa-angle-right"></i>
            </li>
            <li>
               <a href="#" class="current-page">Login</a>                  
            </li>
         </ul>
      </div>
      <div id="sign-in-pop-Page" >
         <section class="login-form" id="login-page">
            <div class="login-section">
               <div class="logmain-in">
                  <div class="login-box">
                     <?php
                        if(isset($_GET['failed'])){
                        	if(isset($_GET['account-not-active'])){
                        		$errMsg = "Your Account is Inactive. Please kindly contact Administrator or support.";
                        	} else if(isset($_GET['email-not-verified'])){
                        		$errMsg = "Your Account is Inactive. Please kindly verify your email by clicking on the link that has been sent to your registered email account.";
                        	} else if(isset($_GET['wrong-password'])) {
                                                  $errMsg = "Invalid Login ID or password, please try again.";
                                              } else {
                                                  $errMsg = "Invalid Login ID or password, please try again.";
                                              } ?>
                     <br>
                     <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong><?php echo $errMsg; ?></strong>
                     </div>
                     <br/>
                     <?php
                        }
                        ?>
                     <?php
                        if(isset($_GET['resetsuccess'])){
                        ?>
                     <div class="alert alert-success hideOnback">
                        <p><em class="fa fa-check"></em> We have sent an email to your registered email address with the steps to reset your password, please follow the steps in the email to reset your account password.</p>
                     </div>
                     <?php
                        } else {
                        	if(isset($_GET['user-does-not-exists'])){
                        ?>
                     <div class="alert alert-danger hideOnback">
                        <p><em class="fa fa-warning"></em> This mail id is not registered with us.</p>
                     </div>
                     <?php
                        }
                        }
                        ?>
                     <?php 
                        if(isset($_GET['registersuccess'])){
                                       $mail = $functions->escape_string($functions->strip_all($_GET['thankyou']));
                                          $de_Email = base64_decode($mail);
                        ?>
                     <div class="alert alert-success">
                        Thank you for registering with <?php echo SITE_NAME ?>, we have sent you an email <?php echo "(".$de_Email.")"; ?> with the steps to activate your account, please follow the steps in the email to activate your account.<br><br>
                     </div>
                     <?php	} ?>
                     <h1 class="page-heading">log in</h1>
                     <form class="login-form" id="login-form" method="post" novalidate="novalidate">
                        <div class="form-group">
                           <label>Email Address</label>
                           <input type="text" name="email" class="form-control" placeholder="Email ID" required="" autofocus="">
                        </div>
                        <div class="form-group passord-toogle">
                           <label>Password</label>
                           <i class="fa fa-eye pasaoepsoeps"></i>
                           <input type="password" name="password" class="passwopsoes form-control" placeholder="Password" required="">
                        </div>
                        <div class="form-group">
                           <input type="hidden" placeholder="" name="redirect_url" id="redirect_url" value="<?php echo $redirect; ?>">
                           <input type="hidden" placeholder="" name="productredirect" id="productredirect" value="<?php echo $productredirect; ?>">
                           <input type="hidden" name="user_type" value="Customer" data-id="customer">
                        </div>
                        <div class="flex-pos">
                           <button class="btn red-btn btn-animation" name="login_btn">Log in</button>
                           <p class="fp-btn">Forgot Your Password?</p>
                        </div>
                     </form>
                     <div class="login-with-other">
                        <p>OR Log in with </p>
                        <div class="flex-login">
                         <a class="facbook-login" href="<?php echo $loginUrl; ?>">
                            <i class="fa fa-facebook"></i> Facebook
                          </a>
                          <a class="google-login" href="<?php echo $authUrl; ?>">
                            <i class="fa fa-google"></i> Google
                          </a>
                        </div>
                     </div>
                     <form class="fp-forms" style="display:none;" id="forgot-form" method="post" novalidate="novalidate">
                        <input type="text" name="email" class="form-control" placeholder="Email ID" required="">
                        <div class="flex-pos logpsds">
                           <button type="submit" name="forgot_btn" class="btn red-btn btn-animation">Reset</button>
                           <p class="back-btn">Back to Login</p>
                        </div>
                     </form>
                     <p class="already">Don't have an account? <a class="green-text" id="open-register" href="javascript:;">Sign up Here</a></p>
                  </div>
               </div>
            </div>
         </section>
         <section class="login-form" id="register-page" style="display: none;">
            <div class="login-section">
               <div class="regiscontainer">
                  <div class="formbox">
                     <form action="" method="POST" id="registration-form" novalidate="novalidate">
                        <h1>Register</h1>
                        <div id="vender" class="">
                           <div class="venderform">
                              <div class="form-group">
                                 <label>Name <em>*</em></label>
                                 <input type="text" name="name" class="form-control" placeholder="Name" required="">
                              </div>
                              <div class="form-group">
                                 <label>Email ID <em>*</em></label>
                                 <input type="text" name="email" class="form-control" placeholder="Email ID">
                              </div>
                              <div class="form-group">
                                 <label>Mobile No. <em>*</em></label>
                                 <input type="text" name="mobile" class="form-control" placeholder="Mobile" required="">
                              </div>
                              <div class="form-group passord-toogle">
                                 <label>Password <em>*</em></label>
                                 <i class="fa fa-eye pasaoepsoeps"></i>
                                 <input type="password" name="password" id="password-1" class="form-control passwopsoes" placeholder="Password" required="">
                              </div>
                              <div class="form-group passord-toogle">
                                 <label>Confirm Password <em>*</em></label>
                                 <i class="fa fa-eye psdstofles"></i>
                                 <input type="password" name="repassword" class="form-control passnesowds" placeholder="Confirm Password" required="">
                              </div>
                              <button class="btn reg-btn btn-animation" type="submit" name="register"> Register</button>
                              <p class="already">Already registered? <a class="green-text" id="open-login-here" href="javascript:;">Login Here</a></p>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <!--Main End Code Here-->
      <!--footer start menu head-->
      <?php include("include/footer.php");?> 
      <!--footer end menu head-->
      <?php include("include/footer-link.php");?>
      <script>
         $(".pasaoepsoeps").click(function(){
            $(this).toggleClass("fa-eye-slash");
            if ($('.passwopsoes').attr('type') == 'password') {
               $('.passwopsoes').attr('type', 'text');
            } else {
               $('.passwopsoes').attr('type', 'password');
            }
         });
         $(".psdstofles").click(function(){
            $(this).toggleClass("fa-eye-slash");
            if ($('.passnesowds').attr('type') == 'text') {
               $('.passnesowds').attr('type', 'password');
            } else {
               $('.passnesowds').attr('type', 'text');
            }
         });
         $(document).ready(function(){
         	<?php 
         	if(isset($_GET['registersuccess'])){ ?>
         	   // $.fancybox.close(); 
         	   $.fancybox.destroy();

         	<?php } ?>   

         	<?php 
         	if(isset($_GET['resetsuccess'])){ ?>
         	   // $.fancybox.close(); 
         	   $.fancybox.destroy();

         	<?php } ?>

         	<?php 
         	if(isset($_GET['user-does-not-exists'])){ ?>
         	   // $.fancybox.close(); 
         	   $.fancybox.destroy();

         	<?php } ?>

         	<?php 
         	if(isset($_GET['failed'])){ ?>
         	   // $.fancybox.close(); 
         	   $.fancybox.destroy();

         	<?php } ?>
         	
         	<?php if(isset($_GET['user-does-not-exists']) || isset($_GET['resetsuccess'])){ ?>
         		$(".fp-btn").trigger("click");
         		$('.page-heading').text("Forgot Password");
         	<?php } ?>
         
         	$(".fp-btn").click(function(){
         		$('.page-heading').text("Forgot Password");
         		$(".login-box").addClass("switch-form");
         	});
         	$(".back-btn").click(function(){
         		$('.page-heading').text("Login");
         		$(".login-box").removeClass("switch-form");
         		$(".hideOnback").hide();
         	});
         
         	<?php if(isset($_GET['fp'])) { ?>
         		$('.for_pass').click();
         	<?php } ?>
         
         	$("#login-form").validate({
         		ignore: ".ignore",
         		rules: {
         			email: {
         				required: true,
         				email:true,
         			},
         			password: {
         				required: true,
         			},
         		},
         		messages: {
         			email: {
         				required: 'Please enter your email address',
         			},
         			password: {
         				required: 'Please enter your password',
         			},
         		}
         	});
         	$("#forgot-form").validate({
         		ignore: ".ignore",
         		rules: {
         			email: {
         				required: true,
         				email:true,
         			},  
         		},
         		messages: {
         			email: {
         				required: 'Please enter your email address',
         			},
         		}
         	});
         });
      </script>
   </body>
</html>