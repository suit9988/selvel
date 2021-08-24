<?php 
include_once 'include/functions.php';
$functions = new Functions();
?>
<!DOCTYPE>

<html>

   <head>

      <title>SELVEL - SHIPPING, CANCELLATION & REFUND</title>

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

         <img src="images/details-banner-header.jpg" class="img-full fixedimg">  

         <div class="container breadcum-header">

            <ul>

               <li>

                  <a href="#">Home</a>

                  <i class="fa fa-angle-right"></i>

               </li>

               <li>

                  <a href="#" class="current-page">SHIPPING, CANCELLATION & REFUND</a>                  

               </li>

            </ul>

         </div>



		<section class="comming-soon">
			<?php  
				$x=1;
				$categoryDetails = $functions->query("SELECT * FROM ".PREFIX."cms_master ORDER BY id ");   
				$row_cat_sne=$functions->fetch($categoryDetails);
			?>
			<h2>
				<?php echo $row_cat_sne['return_policy']; ?>
			</h2>
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