<?php 
include_once 'include/functions.php';
$functions = new Functions();
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

         <img src="images/details-banner-header.jpg" class="img-full fixedimg">  

         <div class="container breadcum-header">

            <ul>

               <li>

                  <a href="#">Home</a>

                  <i class="fa fa-angle-right"></i>

               </li>

               <li>

                  <a href="#" class="current-page">FAQ's</a>                  

               </li>

            </ul>

         </div>



        <section class="comming-soon">

            <div class="container">

              <div class="faq-list">

                 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<?php  
							$x=1;
							$categoryDetails = $functions->query("SELECT * FROM ".PREFIX."faq_question_answer ORDER BY display_order ASC ");   
							while($row_cat_sne=$functions->fetch($categoryDetails)){
						?>

                     <div class="panel panel-default">

                         <div class="panel-heading" role="tab" id="heading<?php echo $x; ?>">

                             <h4 class="panel-title">

                                 <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $x; ?>" aria-expanded="true" aria-controls="collapse<?php echo $x; ?>">

                                     <i class="more-less glyphicon glyphicon-plus"></i>

                                     <?php echo $row_cat_sne['question']; ?>

                                 </a>

                             </h4>

                         </div>

                         <div id="collapse<?php echo $x; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $x; ?>">

                             <div class="panel-body">

                                   <?php echo $row_cat_sne['answer']; ?>

                             </div>

                         </div>

                     </div>
							<?php $x++;} ?>


                     <!--<div class="panel panel-default">

                         <div class="panel-heading" role="tab" id="headingTwo">

                             <h4 class="panel-title">

                                 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                     <i class="more-less glyphicon glyphicon-plus"></i>

                                      Question 2

                                 </a>

                             </h4>

                         </div>

                         <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">

                             <div class="panel-body">

                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                             </div>

                         </div>

                     </div>



                     <div class="panel panel-default">

                         <div class="panel-heading" role="tab" id="headingThree">

                             <h4 class="panel-title">

                                 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                     <i class="more-less glyphicon glyphicon-plus"></i>

                                      Question 3

                                 </a>

                             </h4>

                         </div>

                         <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">

                             <div class="panel-body">

                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                             </div>

                         </div>

                     </div>



                     <div class="panel panel-default">

                         <div class="panel-heading" role="tab" id="headingfour">

                             <h4 class="panel-title">

                                 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFoure" aria-expanded="false" aria-controls="collapseFoure">

                                     <i class="more-less glyphicon glyphicon-plus"></i>

                                      Question 4

                                 </a>

                             </h4>

                         </div>

                         <div id="collapseFoure" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">

                             <div class="panel-body">

                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                             </div>

                         </div>

                     </div>



                     <div class="panel panel-default">

                         <div class="panel-heading" role="tab" id="headingfive">

                             <h4 class="panel-title">

                                 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">

                                     <i class="more-less glyphicon glyphicon-plus"></i>

                                      Question 5

                                 </a>

                             </h4>

                         </div>

                         <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">

                             <div class="panel-body">

                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                             </div>

                         </div>

                     </div> -->



                 </div><!-- panel-group -->

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

      function toggleIcon(e) {

          $(e.target)

              .prev('.panel-heading')

              .find(".more-less")

              .toggleClass('glyphicon-plus glyphicon-minus');

      }

      $('.panel-group').on('hidden.bs.collapse', toggleIcon);

      $('.panel-group').on('shown.bs.collapse', toggleIcon);

      </script>

   </body>

</html>