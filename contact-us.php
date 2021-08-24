<?php 
include_once 'include/functions.php';


    $functions = new Functions();
    $loggedInUserDetailsArr = $functions->sessionExists();
    if(isset($_POST['submit'])){
        $functions->contactUsRequest($_POST);
        $name='';
        $h4heading ='';
        $content='';
        $adminDetails = $functions->getAdminDetails();    
        
        include_once("include/classes/Email.class.php");
    
        $name ='Following User Details As Are Follow';

        $content    .= "<p>Name : ".$_POST['name']."</p>";
        $content    .= "<p>Email ".$_POST['email'];
        $content    .= "<p>Contact : ".$_POST['contact']."</p>";
        $content    .= "<p>Message : ".$_POST['msg']."</p>";
             
        // include_once("thank-you.php");
    
        $subject = SITE_NAME." | New Contact us Request";
        $emailObj = new Email();

        $emailObj->setAddress("sneha@innovins.com");
        //$emailObj->setAddress($adminDetails['email']);
        $emailObj->setSubject($subject);
        $emailObj->setEmailBody($emailMsg);
        $emailObj->sendEmail();   
        
        header("location:contact-us.php?success");
        exit;
    }
	$contactUsCMSDetails = $functions->getContactUsCmsMasterDetails();

?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - Contact Selvel</title>

      <meta name="description" content="SELVEL">

      <meta name="keywords" content="SELVEL">

      <meta name="author" content="SELVEL">

      <?php include("include/header-link.php");?>

   </head>

   <body class="inner-page" id="contact-page">

      <!--Top start menu head-->       

      <?php include("include/header.php");?>

      <!--Main Start Code Here-->

      <main class="main-inner-div">

         <div class="breadcum-header">
				<ul>
					<li>
						<a href="#">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#" class="current-page">About Selvel</a>                  
					</li>
				</ul>
			</div>
			<section class="about-section wow fadeInUp" >
               		<h2 class="about-toel"><em>Giving shape to life!</em></h2>
				</div>
			</section>
		 <div class="tab-header">
			<div class="row">
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="about-us.php" style="text-align: center; color: #fff;">Why Selvel?</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 align="center"><a href="why-selvel.php" style="text-align: center; color: #fff">Our Story</a></h3></div>
				<div class="col-md-4 col-xs-4"><h3 style="text-align: center; color: #fff"><a href="contact-us.php" style="text-align: center; color: #fff;  padding-bottom: 5px;
    border-bottom: 1px solid #CADB2A;">Reach Us</a></h3></div>
			 </div>
         </div>
<?php if(isset($_GET['success'])){ ?>
  <div class="alert alert-success thank-you-css" role="alert" style="    text-align: center;">
     Thank you for contacting us....Our team shall contact you shortly.
  </div>
<?php } ?>

        <section class="position-contact">

          <div class="innerwrap container">        

          

            <section class="section2 clearfix" style="align-items: inherit;-webkit-box-align: inherit;-ms-flex-align: inherit;">

              <div class="w45 column1 first">
				  <span class="cghend"></span>
				<?php  
					
				$q_about = $functions->query("SELECT * FROM ".PREFIX."contact_cms");   
				$row_about=$functions->fetch($q_about);
				?>
				<div class="abot-reach-text-sels why_bw">
					<h3>Contact</h3>
					<h4>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>                       
				</div>			
               

              </div>

              <div class="w50 column2 last">
				  <span class="cghend"></span>
				  <div class="abot-reach-text-sels why_bw"><h3 style="color: #341a72; margin-bottom: 3%;">Contact</h3></div>

                <div class="sec2innercont">

                  <div class="sec2addr">                 

                    <div class="fleslp">

                      <p><span class="collig">Phone :</span> <?php echo $row_about['phone'] ?></p>

                      <p><span class="collig">Email :</span> <?php echo $row_about['email'] ?></p>

                    </div>

                    <!-- <p><span class="collig">Web :</span> <a href="www.selvel.com" target="_blank">www.selvel.com</a></p> -->

                  </div>

                </div>

                <div class="sec2contactform">

                  <h3 class="sec2frmtitle">Want to Know More?? Drop Us a Mail</h3>

                  <form action="" id="contact-osp" method="post" >

                    <div class="form-group clearfix">

                      <input class="col2 first" type="text" name="name" placeholder="Full Name">                     

                    </div>

                    <div class="form-group clearfix">                     

                       <select name="purpose">

                          <option selected disabled>Select Purpose</option> 

                          <option>general enquiry</option>  

                          <option>job application</option>  

                          <option>Corporate gifting enquiry</option>  

                          <option>Distributor Info Required</option>  

                         </select>

                    </div>

                    <div class="form-group clearfix">

                      <input  class="col2 first" type="Email" name="email" placeholder="Email">                     

                    </div>

                    <div class="form-group clearfix">                      

                      <input class="col2 last" type="text" name="contact" placeholder="Contact Number">

                    </div>

                    <div class="form-group clearfix wi9s0">

                      <textarea  id="" cols="30" name="msg" rows="7">Your message here...</textarea>

                    </div>

                    <!--<div class="form-group clearfix wi9s0 filsdp">

                      <input type="file" name="broucher_names">

                    </div> -->

                     <button type="submit" class="btn-sbt" name="submit">

                        Send

                      </button>

                  </form>

                </div>



              </div>

            </section>

          

          </div>

        </section>



           

      </main>

      <!--Main End Code Here-->

      <!--footer start menu head-->

      <?php include("include/footer.php");?> 

      <!--footer end menu head-->

      <?php include("include/footer-link.php");?>

      <script type="text/javascript">

         $(".scroll").mCustomScrollbar()

      </script>

   </body>

</html>