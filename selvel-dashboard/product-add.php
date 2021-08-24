<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Product";
	$parentPageURL = 'index.php';
	$pageURL = 'product-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(isset($_GET['edit'])) {
		$admin->checkUserPermissions('product_update',$loggedInUserDetailsArr);
	} else {
		$admin->checkUserPermissions('product_create',$loggedInUserDetailsArr);
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$result = $admin->addProduct($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess");
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueProductById($id);
		$productSizeData = $admin->getProductSizeDataById($id);
		$productattributeData = $admin->getProductattributeDataById($id);
		
		$query_att = "select * from ".PREFIX."product_attributes where product_id = '".$id."' ";
			$rr_aa=$admin->query($query_att);
			
			
		
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateProduct($_POST, $_FILES);
			header("location:".$pageURL."?updatesuccess&edit&id=".$id);
			exit();
		}
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
							<a href="<?php echo $parentPageURL; ?>" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to <?php echo $pageName; ?></a>
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
									<h4 class="card-title mb-0"> Product Category</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-4">
											<label>Category <em>*</em></label>
											<select  required class="form-control select" data-live-search="true" multiple name="category[]" id="category">
												<?php
													$query = $admin->query("select * from ".PREFIX."category_master where active='1' order by category_name ASC");
													while($row = $admin->fetch($query)) 
													{
														if(isset($_GET['edit'])){
															$updatequry = $admin->query("SELECT * FROM ".PREFIX."product_category_mapping WHERE product_id='".$id."' and category_id='".$row['id']."'");
															$catDetails = $admin->fetch($updatequry);
															//print_r($catDetails);
														}
												?>
														<option value="<?php echo $row['id']; ?>" <?php if(isset($_GET['edit']) && $row['id']==$catDetails['category_id']){ echo "selected"; } ?> ><?php echo $row['category_name']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-sm-4">
											<label>Sub Category Level 1</label>
											<?php 
												$catArr = array();
											?>
											<select class="form-control select" data-live-search="true" multiple name="sub_cat[]" id="sub_category_id">
												<?php
													if(isset($_GET['edit'])) {
														$subCat = array();
														$subsql= $admin->query("SELECT * FROM ".PREFIX."sub_category_master WHERE `active`='1' order by `category_name` ASC");

														while($row = $admin->fetch($subsql)) {
															$query = $admin->query("SELECT * from ".PREFIX."product_subcategory_mapping WHERE `product_id`='".$id."' and subscategory_id='".$row['id']."'");
															$subscbCat = $admin->fetch($query);
															if($row['id']==$subscbCat['subscategory_id']) {
																$subCat[] = $subscbCat['subscategory_id'];
															}
												?>
															<option value="<?php echo $row['id']; ?>" <?php if(isset($_GET['edit']) && $row['id']==$subscbCat['subscategory_id']){ echo "selected"; } ?> ><?php echo $row['category_name']; ?></option>
												<?php
														}
													}
												?>
											</select>
										</div>
										<div class="col-sm-4">
											<label>Sub Category Level 2</label>
											<select class="form-control select" data-live-search="true" name="sub_category_level2[]" multiple id="sub_category_level2">
												
												<?php
													if(isset($_GET['edit'])) {
														$subsub = $admin->query("SELECT * FROM ".PREFIX."subsubcategory where active='1' order by category_name ASC");

														while($subCategoryDetail = $admin->fetch($subsub)){
															$subCategorySQL = $admin->getAllSubCategoriesLevel2byProductID($id, $subCategoryDetail['id']);
															$subsubCdetail = $admin->fetch($subCategorySQL);
												?>
															<option value="<?php echo $subCategoryDetail['id']; ?>" <?php if(isset($_GET['edit']) and $subsubCdetail['subsubcategory_id']==$subCategoryDetail['id']) { echo 'selected'; } ?>><?php echo $subCategoryDetail['category_name']; ?></option>
												<?php
														}
													}
												?>
											</select>
										</div>
									</div>
								
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Product Details</h4>
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-3">
											<label>Product Name <em>*</em></label>
											<input type="text" name="product_name" id="product_name" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['product_name']; } ?>" required/>
										</div>
										<div class="col-sm-2">
											<label>Product Code <em>*</em></label>
											<input type="text" name="product_code" id="product_code" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['product_code']; } ?>" required/>
										</div>
										<div class="col-sm-2">
											<label>HSN Code <em>*</em></label>
											<input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['hsn_code']; } ?>" required/>
										</div>
										<div class="col-sm-3">
											<label>GST Tax <em>*</em></label>
											<select class="form-control" name="tax" required>
												<option value="">Please Select Tax</option>
												<option <?php if(isset($_GET['edit']) && $data['tax']=="0"){ echo "selected"; } ?> value="0">0 %</option>
												<option <?php if(isset($_GET['edit']) && $data['tax']=="5"){ echo "selected"; } ?> value="5">5 %</option>
												<option <?php if(isset($_GET['edit']) && $data['tax']=="12"){ echo "selected"; } ?> value="12">12 %</option>
												<option <?php if(isset($_GET['edit']) && $data['tax']=="18"){ echo "selected"; } ?> value="18">18 %</option>
												<option <?php if(isset($_GET['edit']) && $data['tax']=="28"){ echo "selected"; } ?> value="28">28 %</option>
											</select>
										</div>
										<div class="col-sm-2">
											<label>Active <em>*</em></label>
											<select class="form-control"  name="active" id="active">
												<option value="">Select</option>
												<option value="1" <?php if(isset($_GET['edit']) and $data['active']=='1') { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if(isset($_GET['edit']) and $data['active']=='0') { echo 'selected'; } ?>>No</option>
											</select>
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-sm-2">
											<label>Is Top sellers</label>
											<select class="form-control"  name="best_seller" id="best_seller">
												<option value="0" <?php if(isset($_GET['edit']) and $data['best_seller']=='0') { echo 'selected'; } ?>>No</option>
												<option value="1" <?php if(isset($_GET['edit']) and $data['best_seller']=='1') { echo 'selected'; } ?>>Yes</option>
											</select>
										</div>

										<div class="col-sm-2">
											<label>Amazon Link</label>
											<input type="text" name="amazon_link" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $data['amazon_link']; } ?>" />
										</div>
										
										<div class="col-sm-6">
											<label>Related Products</label>
											<select class="form-control selectNon" data-live-search="true" name="recommended_product[]" multiple>
												<?php
												$rel_prod_qry = $admin->query("SELECT * FROM ".PREFIX."product_master where active='1'");
												if(isset($_GET['edit'])){
														while($row_rel_prod = $admin->fetch($rel_prod_qry)){
															
															
															if($id!=$row_rel_prod['id']){
												?>

												<option value="<?php echo $row_rel_prod['id']; ?>" <?php if(isset($_GET['edit'])){ if($row_rel_prod['id']==$rel_id){ echo "selected";} }  ?>><?php echo $row_rel_prod['product_name']; ?> - <?php echo $row_rel_prod['product_code']; ?></option>
												<?php }  } } else { 
														while($row_rel_prod = $admin->fetch($rel_prod_qry)){
														?>
														<option value="<?php echo $row_rel_prod['id']; ?>" ><?php echo $row_rel_prod['product_name']; ?>- <?php echo $row_rel_prod['product_code']; ?></option>
														<?php } } ?>
											</select>
											
										</div>
									</div>
									<?php /*
									<div class="form-group row">
										<div class="col-sm-12">
											<label>Features <em>*</em></label>
											<textarea col="5" rows="4"  class="form-control" name="description" id="description" ><?php if(isset($_GET['edit'])){ echo $data['description']; }  ?></textarea>
										</div>
									</div>
									*/ ?>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Pricing</h4>
								</div>

								<div class="card-body">
									<?php
										if(isset($_GET['edit'])) {
											$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where product_id='".$id."' order by id LIMIT 0,1"));
										}
									?>
									<div class="form-group row">
										<div class="col-md-2">
											<label>Size <em>*</em></label>
											<select name='size' required class="form-control">
												<option value="">Select</option>
												<?php
													$size_m_qry = $admin->query("SELECT * FROM ".PREFIX."size_master where active='1'");
													if(isset($_GET['edit']) and count($subCat)>0) {
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
														<option value="<?php echo $row_size_m['size']; ?>" <?php if(isset($_GET['edit']) and $row_size_m['size']==$productSize['size']) { echo "selected"; } ?>><?php echo $row_size_m['size']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-md-2">
											<label>Price <em>*</em></label>
											<input type="number" min="1" name="customer_price" required class="form-control customer_price" value="<?php echo isset($_GET['edit']) ? $productSize['customer_price'] : ""; ?>">
										</div>		
										<div class="col-sm-2">
											<label>Discounted Price</label>
											<input type="number" min="0" class="form-control" name="customer_discount_price"  value="<?php if(isset($_GET['edit'])){ echo $productSize['customer_discount_price']; }else{ echo "0"; }?>" />
										</div>

										<div class="col-sm-2">
											<label>Available Quantity <em>*</em></label>
											<input type="number" min="0" name="available_qty" min="0" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $productSize['available_qty']; } else{ echo "0"; } ?>" required />
										</div>
										<div class="col-sm-3">
											<label>Color <em>*</em></label>
											<select required class="form-control selectpicker" data-live-search="true" name="productcolor" id="color" >
												<option value="">Select</option>
												<?php
													$query_col = $admin->query("select * from ".PREFIX."color_master where active='1' order by color ASC");
													while($row_col = $admin->fetch($query_col)) {
												?>
														<option value="<?php echo $row_col['color']; ?>" <?php if(isset($_GET['edit']) and $row_col['color']==$productSize['productcolor']) { echo "selected"; } ?>><?php echo $row_col['color']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-2">
											<label>Weight (in grams) <em>*</em></label>
											<input type="number" min="0" class="form-control" name="weight" required value="<?php if(isset($_GET['edit'])){ echo $productSize['weight']; }else{ echo "0"; }?>" />
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12"><br>
											<label>Features Description</label>
											<textarea col="5" rows="4"  class="form-control" name="features_color" id="features_color"><?php if(isset($_GET['edit'])){ echo $productSize['features_color']; }  ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12"><br>
											<label>Other Features</label>
											<select class="form-control select" name="features[]" multiple>
												<?php
													if(isset($_GET['edit'])) {
														$featureArr = explode(',', $productSize['features']);
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
									<div class="row">
										<div class="form-group col-sm-3 mgbstm"><br>
											<label>Main Image <em>*</em></label>
											<input type="file" class="form-control" name="image1_color" id="" data-image-index="0" <?php if(isset($productSize['image1_color']) && !empty($productSize['image1_color'])){ }else{ echo "required"; } ?>>
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php
												if(isset($_GET['edit']) and !empty($productSize['image1_color'])) {
													$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image1_color'], PATHINFO_FILENAME)));
													$ext = pathinfo($productSize['image1_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/>
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
											<?php if(isset($_GET['edit']) and !empty($productSize['image2_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image2_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image2_color'], PATHINFO_EXTENSION);
												
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/><br>
													<a href="product-image-remove.php?id=<?php echo $productSize['id'] ?>&field=image2_color">Remove Image</a>
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
											<?php if(isset($_GET['edit']) and !empty($productSize['image3_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image3_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image3_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/><br>
													<a href="product-image-remove.php?id=<?php echo $productSize['id'] ?>&field=image3_color">Remove Image</a>
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
											<?php if(isset($_GET['edit']) and !empty($productSize['image4_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image4_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image4_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/><br>
													<a href="product-image-remove.php?id=<?php echo $productSize['id'] ?>&field=image4_color">Remove Image</a>
											<?php
												}
											?>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-sm-3 mgbstm"><br>
											<label>Image 5 </label>
											<input type="file" class="form-control" name="image5_color" id="" data-image-index="4">
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php
												if(isset($_GET['edit']) and !empty($productSize['image5_color'])) {
													$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image5_color'], PATHINFO_FILENAME)));
													$ext = pathinfo($productSize['image5_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/><br>
													<a href="product-image-remove.php?id=<?php echo $productSize['id'] ?>&field=image5_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 6</label>
											<input type="file" class="form-control" name="image6_color" id="" data-image-index="5" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($productSize['image6_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image6_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image6_color'], PATHINFO_EXTENSION);
												
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/><br>
													<a href="product-image-remove.php?id=<?php echo $productSize['id'] ?>&field=image6_color">Remove Image</a>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 7</label>
											<input type="file" class="form-control" name="image7_color" id="" data-image-index="6" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($productSize['image7_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image7_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image7_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/>
											<?php
												}
											?>
										</div>
										<div class="form-group col-sm-3 mgbstm"><br>
											<label> Image 8</label>
											<input type="file" class="form-control" name="image8_color" id="" data-image-index="7" >
											<span class="help-text">
												Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png </strong>.<br>
												Images must be exactly <strong>1000 X 1000</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) and !empty($productSize['image8_color'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image8_color'], PATHINFO_FILENAME)));
												$ext = pathinfo($productSize['image8_color'], PATHINFO_EXTENSION);
											?>
													<img src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>" width="100" height="100"/>
											<?php
												}
											?>
										</div>
									</div>
								</div>
							</div>

							<div class="card" id="product-filter-div">
								<?php 
									if(isset($_GET['edit'])) {
								?>
										<div class="card-header">
											<h4 class="card-title mb-0"> Product Filters</h4>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<?php
													$catArr = $admin->getProdcutCategoryByProductId($id);
													$cats = implode(",", $catArr);
													$attributeSQL = $admin->getAttributesByCategoryId($cats);
													while($attributes = $admin->fetch($attributeSQL)) {
														$attribute = $admin->getUniqueAttributeById($attributes['attribute_id']);
														if(!empty($attribute['id'])){
												?>
															<div class="col-sm-3">
																<label><?php echo $attribute['attribute_name']; ?></label>
																<select name="filter_value[]" id="filter_value" class="form-control">
																	<option value="">Select <?php echo $attribute['attribute_name']; ?></option>
																	<?php
																		$attributeValueSql = $admin->getAttributeValues($attribute['id']);
																		$productFilterValue = $admin->getProductFilterValueByFilterId($attribute['id'],$id);
																		while($attributeValue = $admin->fetch($attributeValueSql)) {
																	?>
																			<option value="<?php echo $attributeValue['id'] ?>" <?php if(in_array($attributeValue['id'],$productFilterValue)){ echo 'selected'; } ?>><?php echo $attributeValue['feature'] ?></option>
																	<?php
																		}
																	?>
																</select>
																<input type="hidden" name="filter_name[]" value="<?php echo $attribute['id'] ?>">
															</div>
												<?php
														}
													}
												?>
											</div>
										</div>
								<?php
									}
								?>
							</div>

							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> SEO Details</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-4">
											<label>Page Title </label>
											<input type="text" name="page_title" value="<?php if(isset($_GET['edit'])) { echo $data['page_title']; } ?>" class="form-control">
										</div>
										<div class="col-md-4">
											<label>Meta Keywords </label>
											<textarea class="form-control" name="meta_keyword" rows="3"><?php if(isset($_GET['edit'])) { echo $data['meta_keyword']; } ?></textarea>
										</div>
										<div class="col-md-4">
											<label>Meta Description </label>
											<textarea class="form-control" name="meta_description" rows="3"><?php if(isset($_GET['edit'])) { echo $data['meta_description']; } ?></textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions text-right">
								<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
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

			$('input[name="image1_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image2_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image3_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image4_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image5_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image6_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image7_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});
			$('input[name="image8_color"]').change(function(){
				loadImagePreview(this, (1000 / 1000));
			});

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

			var category_id = $(this).val();
			$.ajax({
				url:"ajaxGetSizeByCategoryId.php",
				data:{category_id:category_id, subcategory:subcategory},
				type:"POST",
				success: function(response){
					$("select[name='size']").html(response);
					//$('#sub_category_id').on("change",getSubSubCategory);

				},
				error: function(){
					alert("Unable to get content, please try again");
				},
				complete: function(response){
					
				}
			});
		}
	</script>

	<script src="ajax-script.js" type="text/javascript"></script>
</body>
</html>