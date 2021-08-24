<div class="review-box-inner" id="distriform" style="display: none;"> 		
			<h2> Fill the form as your requirment</h2>	
			<form action="<?php echo BASE_URL; ?>/distributor.php" id="contact-osp" method="post">
			  <div class="form-group clearfix">
			    <input class="col2 first" type="text" placeholder="Full Name" name="name">                     
			  </div>
			  <div class="form-group clearfix">
			    <input  class="col2 first" type="Email" placeholder="Email" name="email">                     
			  </div>
			  <div class="form-group clearfix">                      
			    <input class="col2 last" type="text" placeholder="Contact Number" name="contact">
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
			  <div class="form-group clearfix wi9s0">
			    <textarea name="msg" id="" cols="30" rows="7" >Add Detail</textarea>
			  </div>
			  <!--<div class="form-group clearfix wi9s0 filsdp">
			    <input type="file" name="broucher_names">
			  </div>-->
			   <button type="submit" class="btn-sbt" name="send">
			      Send
			    </button>
			</form>
			
		</div>