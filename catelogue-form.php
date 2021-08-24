<div class="review-box-inner"  id="pdfcatelog" style="display: none;"> 		
	<h2> Fill the form</h2>	
	<form  id="contact-osp" action="<?php echo BASE_URL; ?>/pdf_server.php" method="post">
	  <div class="form-group clearfix">
	    <input class="col2 first" type="text" placeholder="Full Name" name="name">                     
	  </div>
	  <div class="form-group clearfix">
	    <input  class="col2 first" type="Email" placeholder="Email" name="email">                     
	  </div>
	  <div class="form-group clearfix">                      
	    <input class="col2 last" type="text" placeholder="Contact Number" name="contact">
	  </div>
	  <button type="submit" class="btn-sbt">
	      <!-- <a href="pdf/dummy.pdf" download style="color: #fff;outline: none;"> submit</a> -->
	      Submit
	    </button>
	</form>
</div>