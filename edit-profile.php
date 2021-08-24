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

?>
<div id="edit-in-pop"  style="display: none;     width: 713px;" >

   <section class="login-form" id="register-page" >

      <div class="login-section">

         <div class="regiscontainer">

            <div class="formbox">

               <form action="" method="POST" id="registration-form" novalidate="novalidate">


                     <div class="change-address-div signup" style="padding: 10px;">
						<div class="row">
							<h3 id="line"><span> Edit Contact Information</span></h3><br>
							<div class="col-md-6 col-sm-6">

								<div class="form-group" style="    display: flex;">
									<label>First Name:&nbsp;</label>
									<input type="text" class="form-control" placeholder="First Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; }else{ echo $loggedInUserDetailsArr['first_name']; } ?>">

								</div>

							</div>
							<div class="col-md-6 col-sm-6">

								<div class="form-group" style="    display: flex;">
									<label>Last Name:&nbsp;</label>
									<input type="text" class="form-control" placeholder="Last Name" name="customer_fname" value="<?php if(isset($addressDetails['customer_fname'])){ echo $addressDetails['customer_fname']; }else{ echo $loggedInUserDetailsArr['last_name']; } ?>">

								</div>

							</div>



							<div class="clearfix"></div>

							<div class="col-md-6 col-sm-6">

								<div class="form-group" style="display: flex;">
									<label>Email:&nbsp;</label>
									<input type="text" class="form-control" placeholder="Email" name="customer_email" value="<?php if(isset($addressDetails['customer_email'])){ echo $addressDetails['customer_email']; } ?>">

								</div>

							</div>

							<div class="col-md-6 col-sm-6">

								<div class="form-group"  style="display: flex;">
									<label>Phone Number:&nbsp;</label>
									<input type="text" class="form-control" placeholder="Enter your Contact No." name="customer_contact" value="<?php if(isset($addressDetails['customer_contact'])){ echo $addressDetails['customer_contact']; }else{ echo $loggedInUserDetailsArr['mobile']; } ?>">

								</div>

							</div>
							<div class="clearfix"></div>

							<p align="center">Please enter your password to save the changes</p><br>
							<div class="col-md-12 col-sm-12">

								<div class="form-group" style="display: flex;">
									<label>Password:&nbsp;</label>
									<input type="text" class="form-control" placeholder="" name="customer_contact" >
								</div>

							</div>

							<button class="btn reg-btn btn-animation" type="submit" name="register"> Save Changes</button>

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