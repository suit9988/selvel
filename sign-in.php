<?php
   include_once 'include/functions.php';
   $functions = new Functions();
   
   if(isset($_POST['register']) ) {
      $first_name = $functions->escape_string($functions->strip_all($_POST['name']));
      $email = $functions->escape_string($functions->strip_all($_POST['email']));
      $mobile = $functions->escape_string($functions->strip_all($_POST['mobile']));
   
      if(!empty($email) && $functions->isCustomerEmailUnique($email)){
         $newCustomerDetails = $functions->addUser($_POST);
   
         //verify-email mail from Main page
         if(isset($newCustomerDetails['id'])){ // registration success
          //  == SEND EMAIL ==
           include_once("include/emailers/registration-email-verify.inc.php"); // $emailMsg
   
            //SMTP
            include_once("include/classes/Email.class.php");
            // echo $emailMsg;
            // exit;
            $to = $email;
            $subject = SITE_NAME." | Verify your Email ID";
   
            $emailObj = new Email();
            $emailObj->setAddress($to);
            $emailObj->setSubject($subject);
            $emailObj->setEmailBody($emailMsg);
            $emailObj->sendEmail();
            //SMTP END
         }
         //verify-email mail::end
   
         $encoded_email =  base64_encode($email);
       echo '<script> window.open("'.BASE_URL.'/index.php?registersuccess&thankyou='.$encoded_email.'","_self");  </script>';
         $message_register=true;
      } else {
         $message_register=false;
         echo '<script>           
         window.open("'.BASE_URL.'/index.php?registerfailed&email_addr_not_found","_self");   </script>';
      }
   }
   
   if(isset($_POST['login_btn'])){
      $email = $functions->escape_string($functions->strip_all($_POST['email']));
      $password = $functions->escape_string($functions->strip_all($_POST['password']));
      $successURL = BASE_URL.'/index.php';
      
      $functions->userLogin($_POST, $successURL, "index.php?failed");
      exit;
   }
   
   if(isset($_POST['forgot_btn'])) {
      $email  = $functions->escape_string($functions->strip_all($_POST['email']));
   
     if(empty($email)){
        echo '<script> window.open("'.BASE_URL.'/index.php?fp&loginfail&forgot_email","_self");  </script>';
   
        
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
        echo '<script> window.open("'.BASE_URL.'/index.php?fp&resetsuccess","_self");  </script>';
   
             header("location: ".BASE_URL."/login.php?fp&resetsuccess");
             exit;
           } else {
             // customer does not exists
             echo '<script> window.open("'.BASE_URL.'/index.php?fp&user-does-not-exists","_self");  </script>';
   
           }
      }
    }

	include_once "include/social-login-config.inc.php";

	$loginUrl = $helper->getLoginUrl(BASE_URL.'/social-login-callback.php?redirect='.BASE_URL.'/index.php', $permissions);

	$google_redirect_url 	= BASE_URL.'/google-login-callback.php?redirect='.BASE_URL.'/index.php'; 
	$gClient->setRedirectUri($google_redirect_url);
	$authUrl = $gClient->createAuthUrl();
?>
<div id="sign-in-pop"  style="display: none;">

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
					</div><br/>
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
              
               <h1 class="page-heading">Welcome Back,</h1>

               <form class="login-form" id="login-form" method="post" novalidate="novalidate">

                  <div class="form-group">

                     <label>Email :</label>

                     <input type="text" name="email" class="form-control" placeholder="Enter Email ID" required="" autofocus="">

                  </div>

                  <div class="form-group passord-toogle">

                     <label>Password :</label>

                     <!--<i class="fa fa-eye passwordtoggle"></i>-->

                     <input type="password" name="password" class="password-show form-control" placeholder="Enter Password" required="">

                  </div>

                  <div class="form-group">

                     <input type="hidden" placeholder="" name="redirect_url" id="redirect_url" value="">

                     <input type="hidden" placeholder="" name="productredirect" id="productredirect" value="">

                     <input type="hidden" name="user_type" value="Customer" data-id="customer">

                  </div>

                  <div style="text-align: center;">

                     <button class="btn red-btn btn-animation" name="login_btn">Log in</button>

                     <p class="fp-btn" style="font-family: 'Gotham-Font'"><u>Forgot Your Password?</u></p>

                  </div>

               </form>

               <form class="fp-forms" style="display:none;" id="forgot-form" method="post" novalidate="novalidate">

                  <input type="text" name="email" class="form-control" placeholder="Email ID" required="">

                  <div class="logpsds" style="margin-top: 31px; text-align: center;">

                     <button type="submit" name="forgot_btn" class="btn red-btn btn-animation">Reset</button>

                     <p class="back-btn" style="font-family: 'Gotham-Font'">Back to Login</p>

                  </div>

               </form>
               <div class="login-with-other">
                  <p>OR Log in with </p>
                  <div class="" style="margin: 0 auto; width: fit-content;">
                    <a class="facbook-login" href="<?php echo $loginUrl; ?>">
                      <i class="fa fa-facebook"></i> Facebook
                    </a>
                    <a class="google-login" href="<?php echo $authUrl; ?>">
                      <img src="images/gm.png"> Google
                    </a>
                  </div>
                </div>
               <p class="already">Don't have an account? <a class="green-text" id="open-register" href="javascript:;"><strong>Sign up Here</strong></a></p>

            </div>

         </div>

      </div>

   </section>

	
   <section class="login-form" id="register123-page" style="display: none;">

      <div class="login-section">

         <div class="regiscontainer" style="width:100%">

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

                           <i class="fa fa-eye passwordtoggle"></i>

                           <input type="password" name="password" id="password-1" class="form-control password-show" placeholder="Password" required="">

                        </div>

                        <div class="form-group passord-toogle">

                           <label>Confirm Password <em>*</em></label>

                           <i class="fa fa-eye passwordtoggles"></i>

                           <input type="password" name="repassword" class="form-control password-shows" placeholder="Confirm Password" required="">

                        </div>

                        <button class="btn reg-btn btn-animation" type="submit" name="register"> Register</button>

                        <p class="already">Already registered? <a class="green-text" id="open-login-here" href="javascript:;"><strong>Login Here</strong></a></p>

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </section>

</div>
<script src="<?php echo BASE_URL; ?>/js/jquery-3.3.1.min.js" type="text/javascript"></script> 
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/jquery.validate.js"></script>      

<script>
$(document).ready(function(){
         $("#registration-form").validate({
               ignore: ".ignore",
               rules: {
                  name: {
                     required:true
                  }, 
                   
                  mobile: {
                     required:true
                  },
                  email: {
                     required: true,
                     email:true,
                     remote:{
                        url:"ajaxCheckEmailExists.php",
                        type: "post",
                     }
                  },
                  password: {
                     required: true,
                     //pwcheck: true,
                     minlength: 8,
                     maxlength: 12,
                  },
                  repassword: {
                     required: true,             
                     equalTo: "#password-1"
                  },
               },
               messages: {
                  name: {
                     required: "Please enter name"
                  },
                  
                  city: {
                     required: "Please enter city"
                  },
                  email: {
                     required: 'please enter your email address',
                     remote:'Sorry, an account is already registered with that E-mail ID.'
                  },
               }
            });
            
         <?php 
         if(isset($_GET['registersuccess'])){ ?>
            $('.before-login').click();
         <?php } ?>   

         <?php 
         if(isset($_GET['resetsuccess'])){ ?>
            $('.before-login').click();
         <?php } ?>

         <?php 
         if(isset($_GET['user-does-not-exists'])){ ?>
            $('.before-login').click();
         <?php } ?>

         <?php 
         if(isset($_GET['failed'])){ ?>
            $('.before-login').click();
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
         
         });

      

</script>