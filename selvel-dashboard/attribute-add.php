<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$pageName = "Attribute";
	$parentPageURL = 'attribute-master.php';
	$pageURL = 'attribute-add.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['register'])){
		if($csrf->check_valid('post')) {
			$result = $admin->addAttribute($_POST, $_FILES);
			header("location:".$parentPageURL."?registersuccess");
		}
	}

	if(isset($_GET['edit'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		$data = $admin->getUniqueAttributeById($id);
	}

	if(isset($_POST['id']) && !empty($_POST['id'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateAttribute($_POST, $_FILES);
			header("location:".$parentPageURL."?updatesuccess&edit&id=".$id);
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
									<h4 class="card-title mb-0"> Details</h4>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<div class="col-md-4">
											<label>Category <em>*</em></label>
											<select class="form-control select" name="category_ids[]" id="category_ids" multiple placeholder="Select Cateogry">
												<?php
													$category_ids_arr = array();
													if(isset($_GET['edit'])){
														$sqlQry = $admin->query("select * from ".PREFIX."category_attribute_list where attribute_id = '".$id."'");
														while($rowCats = $admin->fetch($sqlQry)){
															$category_ids_arr[] = $rowCats['category_id'];
														}
													}

													$categoriesList = $admin->getAllCategories();
													while($categories = $admin->fetch($categoriesList)){
												?>
														<option value="<?php echo $categories['id']; ?>" <?php if(isset($_GET['edit']) && count($category_ids_arr) > 0 && in_array($categories['id'],$category_ids_arr)) { echo "selected"; } ?>><?php echo $categories['category_name']; ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label>Attribute Name <em>*</em></label>
											<input type="text" name="attribute_name" value="<?php if(isset($_GET['edit'])) { echo $data['attribute_name']; } ?>" class="form-control" required />
										</div>
										<div class="col-sm-4">
											<label>Active</label>
											<select class="form-control" name="active">
												<option value="1" <?php if(isset($_GET['edit']) and $data['active']=='1') { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if(isset($_GET['edit']) and $data['active']=='0') { echo 'selected'; } ?>>No</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h4 class="card-title mb-0"> Attribute Features</h4>
								</div>
								<div class="card-body">
									<div id="clone-house">
										<?php
											if(isset($_GET['edit'])){
												$featuresResult=$admin->getAllAttributeFeaturesByAttributeId($data['id']);
												$featureCounter=1;
												if($admin->num_rows($featuresResult)>0){
													while($featuresRow=$admin->fetch($featuresResult)){
										?>
														<div <?php if($featureCounter==1){ ?>id="clone-me" <?php } ?> class="clone-row">
															<div class="form-group" >
																<div class="row">
																	<div class="col-sm-3">
																		<label>Feature</label>
																		<input type="text" class="form-control" name="features[]" value="<?php echo $featuresRow['feature'] ?>" id="" />
																		<input type="hidden" class="form-control" name="attribute_feature_id[]" value="<?php echo $featuresRow['id'] ?>" id="" />
																		<span class="help-block"></span>
																	</div>
																	<div class="remove-row-wrapper">
																		<?php if($featureCounter!=1){ 
																		?>
																			<div class="col-sm-1">
																				<label>Remove</label>
																				<button type="button" class="btn btn-default form-control fa fa-close remove-row" ></button>
																			</div>
																	<?php } ?>
																	</div>
																</div>
															</div>
															
														</div>
										<?php
														$featureCounter++;
													}
												} else{
										?>
													<div id="clone-me" class="clone-row">
														<hr>
														<div class="form-group" >
															<div class="row">
																<div class="col-sm-3">
																	<label>Feature</label>
																	<input type="text" class="form-control" name="features[]" id="" />
																	<input type="hidden" class="form-control" name="attribute_feature_id[]" value="" id="" />
																	<span class="help-block"></span>
																</div>
																<div class="remove-row-wrapper"></div>
															</div>
														</div>
														
													</div>	
										<?php   }
											} else {
										?>
												<div id="clone-me" class="clone-row">
													<hr>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>Feature</label>
																<input type="text" class="form-control" name="features[]" id="" />
																<input type="hidden" class="form-control" name="attribute_feature_id[]" value="" id="" />
																<span class="help-block"></span>
															</div>
															<div class="remove-row-wrapper"></div>
														</div>
													</div>									
												</div>
										<?php
											}
										?>
									</div>
									<button type="button" class="btn btn-secondary" id="add-a-clone"><i class="icon-bubble-plus"></i> Add More</button>
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

	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					
				},
				messages: {
					
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');


			$("#add-a-clone").on("click", function(){
				// part 1: get the target
				var target = $("#clone-me");
				// part 2: copy the target
				var newNode = target.clone(); // clone a node
				newNode.attr("id",""); // remove id from the cloned node
				newNode.find("input").val(""); // clear all fields
				newNode.find("textarea").val(""); // clear all fields
				newNode.find(".memimg").html(""); // clear all fields
				newNode.find(".showCharCnt").html("120");
				// part 3: add a remove button
				var closeBtnNode = $('<div class="col-sm-1"><label>Remove</label><button type="button" class="btn btn-default form-control fa fa-close remove-row" ></button></div>');
				newNode.find(".remove-row-wrapper").html(closeBtnNode);
				// part 4: append the copy
				$("#clone-house").append(newNode); // append the node to dom
				$(".remove-row").on("click", removeRow);
			});

			$(document).on("click", ".remove-row", removeRow);

			function removeRow(){
				$(this).closest(".clone-row").remove();
			}
		});
	</script>
</body>
</html>