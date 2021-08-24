<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Product Variant";
	$parentPageURL = 'product-variants.php';
	$pageURL = 'product-variant-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(!isset($_GET['product_id']) || empty($_GET['product_id'])) {
		header("location: index.php");
		exit();
	}
	$product_id = trim($admin->escape_string($admin->strip_all($_GET['product_id'])));

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$product_id = trim($admin->escape_string($admin->strip_all($_POST['product_id'])));
			$result = $admin->addProductVariant($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess&product_id=".$product_id);
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueProductVariantById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$product_id = trim($admin->escape_string($admin->strip_all($_POST['product_id'])));
			$result = $admin->updateProductVariant($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess&edit&id=".$id."&product_id=".$product_id);
			exit();
		}
	}

	$subCat = array();
	$subsql= $admin->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE `product_id`='".$product_id."'");

	while($row = $admin->fetch($subsql)) {
		$subCat[] = $row['subscategory_id'];
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

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="assets/css/line-awesome.min.css">

	<!-- Datatable CSS -->
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/css/select2.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<!-- Crop Image css -->
	<link href="assets/css/crop-image/cropper.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

	<style>
		em{
			color:red;
		}
		.group{
			width:35px!important;
			height: 40px!important;
		}
	</style>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php include("include/header.php"); ?>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php include("include/sidebar.php"); ?>
		<!-- /Sidebar -->
		
		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<!-- Page Content -->
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title"><?php echo $pageName; ?></h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
								<li class="breadcrumb-item"><a href="<?php echo $parentPageURL; ?>"><?php echo $pageName; ?></a></li>
								<li class="breadcrumb-item active">
									<?php if(isset($_GET['edit'])) {
										echo 'Edit '.$pageName;
									} else {
										echo 'Add New '.$pageName;
									}
									?>
								</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<a href="<?php echo $parentPageURL."?product_id=".$product_id; ?>" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to <?php echo $pageName; ?></a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<?php if(isset($_GET['registersuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully added.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['registerfail'])){ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> not added.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['updatesuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully updated.
					</div><br/>
				<?php } ?>

				<?php if(isset($_GET['updatefail'])){ ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-close"></i> <strong><?php echo $pageName; ?> not updated.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-lg-12">
						<form action="" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Variant Details</h4>
								</div>

								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-2">
											<label>Size <em>*</em></label>
											<select name='size' required class="form-control">
												<option value="">Select</option>
												<?php
													$size_m_qry = $admin->query("SELECT * FROM ".PREFIX."size_master where active='1'");
													if(count($subCat)>0) {
														$subcatCond = array();
														foreach($subCat as $oneData) {
															$oneData = $admin->escape_string($admin->strip_all($oneData));

															$subcatCond[] =" FIND_IN_SET('".$oneData."', size_subcategory)";
														}
														if(count($subcatCond)>0) {
															$whereCond .= " and (".implode(' OR ', $subcatCond).")";
														}
														$size_m_qry = $admin->query("SELECT * FROM ".PREFIX."size_master where active='1'".$whereCond);
													}
													while($row_size_m = $admin->fetch($size_m_qry)){													?>
														<option value="<?php echo $row_size_m['size']; ?>" <?php if(isset($_GET['edit']) and $row_size_m['size']==$data['size']) { echo "selected"; } ?>><?php echo $row_size_m['size']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-md-2">
											<label>Price <em>*</em></label>
											<input type="number" min="1" name="customer_price" required class="form-control customer_price" value="<?php echo isset($_GET['edit']) ? $data['customer_price'] : ""; ?>">
										</div>		
										<div class="col-sm-2">
											<label>Discounted Price</label>
											<input type="number" min="0" class="form-control" name="customer_discount_price"  value="<?php if(isset($_GET['edit'])){ echo $data['customer_discount_price']; }else{ echo "0"; }?>" />
										</div>

										<div class="col-sm-2">
											<label>Available Quantity <em>*</em></label>
											<input type="number" min="0" name="available_qty" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['available_qty']; } ?>" required />
										</div>
										<div class="col-sm-3">
											<label>Color <em>*</em></label>
											<select required class="form-control" name="productcolor" id="color">
												<option value="">Select</option>
												<?php
													$query_col = $admin->query("select * from ".PREFIX."color_master where active='1' order by color ASC");
													while($row_col = $admin->fetch($query_col)) {
												?>
														<option value="<?php echo $row_col['color']; ?>" <?php if(isset($_GET['edit']) and $row_col['color']==$data['productcolor']) { echo "selected"; } ?>><?php echo $row_col['color']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-2">
											<label>Weight (in grams)</label>
											<input type="number" min="0" class="form-control" name="weight"  value="<?php if(isset($_GET['edit'])){ echo $data['weight']; }else{ echo "0"; }?>" />
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12"><br>
											<label>Features Description</label>
											<textarea col="5" rows="4"  class="form-control" name="features_color" id="features_color"><?php if(isset($_GET['edit'])){ echo $data['features_color']; }  ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12"><br>
											<label>Other Features</label>
											<select class="form-control select" name="features[]" multiple>
												<?php
													if(isset($_GET['edit'])) {
														$featureArr = explode(',', $data['features']);
													}
													$featureRS = $admin->query("select * from ".PREFIX."features_master");
													while($feature = $admin->fetch($featureRS)) {
												?>
														<option value="<?php echo $feature['id'] ?>" <?php if(isset($_GET['edit']) and in_array($feature['id'], $featureArr)) { echo "selected"; } ?>><?php echo $feature['feature'] ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group col-sm-3 mgbstm"><br>
											<label>Main Image <em>*</em></label>
											<input type="file" class="form-control" name="image1_color" id="" data-image-index="0" <?php if(isset($data['image1_color']) && !empty($data['image1_color'])){ }else{ echo "required"; } ?>>
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php
												if(isset($_GET['edit']) and !empty($data['image1_color'])) {
													$file_name = str_replace('', '-', strtolower( pathinfo($data['image1_color'], PATHINFO_FILENAME)));
													$ext = pathinfo($data['image1_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  />
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 2</label>
											<input type="file" class="form-control" name="image2_color" id="" data-image-index="1" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image2_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image2_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image2_color'], PATHINFO_EXTENSION);
												
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image2_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 3</label>
											<input type="file" class="form-control" name="image3_color" id="" data-image-index="2" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image3_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image3_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image3_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image3_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 4</label>
											<input type="file" class="form-control" name="image4_color" id="" data-image-index="3" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image4_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image4_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image4_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image4_color">Remove Image</a>
											<?php
												}
											?>
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group col-sm-3 mgbstm "><br>
											<label>Image 5 </label>
											<input type="file" class="form-control" name="image5_color" id="" data-image-index="4">
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php
												if(isset($_GET['edit']) and !empty($data['image5_color'])) {
													$file_name = str_replace('', '-', strtolower( pathinfo($data['image5_color'], PATHINFO_FILENAME)));
													$ext = pathinfo($data['image5_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image5_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm "><br>
											<label> Image 6</label>
											<input type="file" class="form-control" name="image6_color" id="" data-image-index="5" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image6_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image6_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image6_color'], PATHINFO_EXTENSION);
												
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image6_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm "><br>
											<label> Image 7</label>
											<input type="file" class="form-control" name="image7_color" id="" data-image-index="6" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image7_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image7_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image7_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image7_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm "><br>
											<label> Image 8</label>
											<input type="file" class="form-control" name="image8_color" id="" data-image-index="7" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($data['image8_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image8_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image8_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100"  /><br>
													<a href="product-image-remove.php?product_id=<?php echo $data['id'] ?>&field=image8_color">Remove Image</a>
											<?php
												}
											?>
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
								<?php if(isset($_GET['edit'])){ ?>
									<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id ?>"/>
									<button type="submit" name="update" value="update" id="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>
								<?php } else { ?>
									<button type="submit" name="register" id="register" class="btn btn-danger"><i class="icon-signup"></i>Add <?php echo $pageName; ?></button>
								<?php } ?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Page Content -->

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js"></script>

	<!-- Select2 JS -->
	<script src="assets/js/select2.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<!-- CK Editor -->
	<script type="text/javascript" src="assets/js/editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="assets/js/editor/ckfinder/ckfinder.js"></script>

	<!-- Crop Image js -->
	<script src="assets/js/crop-image/cropper.min.js"></script>
	<script src="assets/js/crop-image/image-crop-app.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


	<script type="text/javascript">
		$('.selectNon').selectpicker({
			size: '5'
		});

		var editor = CKEDITOR.replace( 'features_color', {
			height: 200,
			filebrowserImageBrowseUrl : 'assets/js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'assets/js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
		CKFinder.setupCKEditor( editor, '../' );

		$(document).ready(function() {
			$('input[name="image1_color"],input[name="image2_color"],input[name="image3_color"],input[name="image4_color"],input[name="image5_color"],input[name="image6_color"],input[name="image7_color"],input[name="image8_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});

			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					main_image: {
						extension: "jpg|jpeg|png"
					},
					image1_color: {
						extension: "jpg|jpeg|png"
					},
					image2_color: {
						extension: "jpg|jpeg|png"
					},
					image3_color: {
						extension: "jpg|jpeg|png"
					},
					image4_color: {
						extension: "jpg|jpeg|png"
					},
					image5_color: {
						extension: "jpg|jpeg|png"
					},
					image6_color: {
						extension: "jpg|jpeg|png"
					},
					image7_color: {
						extension: "jpg|jpeg|png"
					},
					image8_color: {
						extension: "jpg|jpeg|png"
					},
					image_five: {
						extension: "jpg|jpeg|png"
					},
					video_one: {
						extension: "mp4|mov|avi"
					},
				},
				messages: {
					main_image: {
						extension: "Please upload jpg or png image"
					},
					image1_color: {
						extension: "Please upload jpg or png image"
					},
					image2_color: {
						extension: "Please upload jpg or png image"
					},
					image3_color: {
						extension: "Please upload jpg or png image"
					},
					image4_color: {
						extension: "Please upload jpg or png image"
					},
					image5_color: {
						extension: "Please upload jpg or png image"
					},
					image6_color: {
						extension: "Please upload jpg or png image"
					},
					image7_color: {
						extension: "Please upload jpg or png image"
					},
					image8_color: {
						extension: "Please upload jpg or png image"
					},
					image_five: {
						extension: "Please upload jpg or png image"
					},
					video_one: {
						extension: "Please upload mp4, mov or avi video"
					},
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

			$('#sub_category_id').on("change",getSubSubCategory);

			$("#category").on("change", function(){
				var category_id = $(this).val();

				$.ajax({
					url:"ajaxGetSubCategoryByCategoryId.php",
					data:{category_id:category_id},
					type:"POST",
					success: function(response){
						$("#sub_category_id").select2('val', response.selectContent);
						$("#sub_category_level2").select2('val', response.selectContent);
						$("#sub_category_id").html(response);
						//$('#sub_category_id').on("change",getSubSubCategory);

					},
					error: function(){
						alert("Unable to get content, please try again");
					},
					complete: function(response){
						
					}
				});

				$.ajax({
					url:"ajaxGetCategoryFilters.php",
					data:{category_id:category_id},
					type:"POST",
					success: function(response){
						var response = JSON.parse(response);
						$("#product-filter-div").html(response.responseContent);
					},
					error: function(){
						alert("Unable to add to cart, please try again");
					},
					complete: function(response){
						
					}
				});
			});
		});

		function getSubSubCategory() {
			var subcategory = $("#sub_category_id").val();
			$.ajax({
				url:"ajaxGetSubSubCategory.php",
				data:{subcategory:subcategory},
				type:"GET",
				success: function(response){
					var response = JSON.parse(response);
					$("#sub_category_level2").select2('val', response.selectContent);
					$("#sub_category_level2").html(response.selectContent);
				},
				error: function(){
					alert("Unable to add to cart, pleases try again");
				},
				complete: function(response){
					
				}
			}).then(function (response) {
			    // create the option and append to Select2

				$("#sub_category_level2").html(response.selectContent);
			});;
		}
	</script>

	<script src="ajax-script.js" type="text/javascript"></script>
</body>
</html>