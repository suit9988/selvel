<?php
include_once 'include/config.php';
include_once 'include/admin-functions.php';
$admin = new AdminFunctions();

$pageName = "Service";
$parentPageURL = 'service_master.php';
$pageURL = 'service-add.php';

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
		$result = $admin->addService($_POST, $_FILES);
		header("location:".$parentPageURL."?registersuccess");
	}
}

if(isset($_GET['edit'])){
	$id = $admin->escape_string($admin->strip_all($_GET['id']));
	$data = $admin->getServiceById($id);
}

if(isset($_POST['id']) && !empty($_POST['id'])) {
	if($csrf->check_valid('post')) {
		$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
		$result = $admin->updateService($_POST, $_FILES);
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
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

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
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Service Info</h4>
							</div>
							<div class="card-body">
								<form action="" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
									<div class="form-group row">
										<div class="col-md-4">
											<label>Title (Max 60 words) <em>*</em></label>
											<input type="text" name="title" value="<?php if(isset($_GET['edit'])) { echo $data['title']; } ?>" class="form-control">
										</div>
										<div class="col-md-4">
											<label>Icon <em>*</em></label>
											<input type="file" class="form-control" <?php if(isset($_GET['edit'])) { if(empty($data['icon'])){ echo "required"; } } ?> name="icon" data-image-index="0" />
											<span class="help-text">
												<br>Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>60 x 60</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) && !empty($data['icon'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['icon'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['icon'], PATHINFO_EXTENSION);
												?>
												<img src="<?php echo BASE_URL; ?>images/<?php echo $file_name.'_crop.'.$ext ?>" width="60" />
												<?php
											} ?>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<label>Short Description (Max 300 words) <em>*</em></label>
											<textarea name="short_description" id="short_description" class="form-control"><?php if(isset($_GET['edit'])) { echo $data['short_description']; } ?></textarea>
										</div>
									</div>
									<div class="form-group clone_row">
										<div class="row">
											<div class="col-md-3">
												<label>Home Page Service Questions ? <em>*</em></label>
											</div>
										</div>
										
										<?php if(isset($_GET['edit'])) { 
											$service_question = (array) json_decode($data['service_question']);
											$i = 1;
											$count = 0;
											foreach($service_question as $srRow) { ?>
												<div class="row form-group service_row">
													<div class="col-md-6">
														<input type="text" name="service_question[<?php echo $count++; ?>]" required maxlength="70" class="form-control" value="<?php echo $srRow; ?>">
													</div>
													<div class="col-md-1">
														<?php if($i == 1) { ?>
															<button type="button" class="btn btn-transition btn-outline-success add-more" title="Add More Service Questions?"><i class="fa fa-plus"></i></button>
														<?php } else { ?>
															<button type="button" class="btn btn-transition btn-outline-danger remove-row" title="Remove this Service Question?">X</button>
														<?php } $i++; ?>
													</div>
												</div>
											<?php } 
										} else { ?>
											<div class="row form-group service_row">
												<div class="col-md-6">
													<input type="text" name="service_question[0]" required maxlength="70" class="form-control">
												</div>
												<div class="col-md-1">
													<button type="button" class="btn btn-transition btn-outline-success add-more" title="Add More Service Questions?"><i class="fa fa-plus"></i></button>
												</div>
											</div>
										<?php } ?>
									</div>
									<div class="form-group row">
										<div class="col-md-8">
											<label>Banner Image <em>*</em></label>
											<input type="file" class="form-control" <?php if(isset($_GET['edit'])) { if(empty($data['banner_image'])){ echo "required"; } } ?> name="banner_image" data-image-index="2"  />
											<span class="help-text">
												<br>Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>1366 x 397</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) && !empty($data['banner_image'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['banner_image'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['banner_image'], PATHINFO_EXTENSION);
												?>
												<img src="<?php echo BASE_URL; ?>images/<?php echo $file_name.'_crop.'.$ext ?>" width="200" />
												<?php
											} ?>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-8">
											<label>Image <em>*</em></label>
											<input type="file" class="form-control" <?php if(isset($_GET['edit'])) { if(empty($data['image'])){ echo "required"; } } ?> name="image" data-image-index="1"  />
											<span class="help-text">
												<br>Files must be less than <strong>2 MB</strong>.<br>
												Allowed file types: <strong>png jpg jpeg</strong>.<br>
												Images must be exactly <strong>395 x 375</strong> pixels.
											</span>
											<br>
											<?php if(isset($_GET['edit']) && !empty($data['image'])) {
												$file_name = str_replace('', '-', strtolower( pathinfo($data['image'], PATHINFO_FILENAME)));
												$ext = pathinfo($data['image'], PATHINFO_EXTENSION);
												?>
												<img src="<?php echo BASE_URL; ?>images/<?php echo $file_name.'_crop.'.$ext ?>" width="200" />
												<?php
											} ?>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-12">
											<label>Long Description <em>*</em></label>
											<textarea class="form-control" id="long_description" name="long_description"><?php if(isset($_GET['edit'])) { echo $data['long_description']; } ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<label>Active</label>
											<select class="form-control" name="active">
												<option value="1" <?php if(isset($_GET['edit']) and $data['active']=='1') { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if(isset($_GET['edit']) and $data['active']=='0') { echo 'selected'; } ?>>No</option>
											</select>
										</div>
										<div class="col-sm-4">
											<label>Order</label>
											<input type="text" name="orders" value="<?php if(isset($_GET['edit'])) { echo $data['orders']; } ?>" class="form-control">
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

	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				ignore: [],
				debug: false,
				rules: {
					icon: {
						<?php if(isset($_GET['edit'])){if(empty($data['icon'])){	?>
							required: true,
							extension: 'jpg|jpeg|png',
							filesize: 2000000
						<?php }}else{ ?>
							required: true,
							extension: 'jpg|jpeg|png',
							filesize: 2000000
						<?php } ?>
					},
					image: {
						<?php if(isset($_GET['edit'])){if(empty($data['image'])){	?>
							required: true,
							extension: 'jpg|jpeg|png',
							filesize: 2000000
						<?php }}else{ ?>
							required: true,
							extension: 'jpg|jpeg|png',
							filesize: 2000000
						<?php } ?>
					},
					title: {
						required: true,
						maxlength: 60
					},
					answer: {
						required: true,
						maxlength: 100
					},
					short_description: {
						required: function() 
						{
							CKEDITOR.instances.short_description.updateElement();
						},
						minlength:50,
					},
					long_description: {
						required: function() 
						{
							CKEDITOR.instances.long_description.updateElement();
						},
						minlength:50,
					}
				},
				messages: {
					short_description:{
						required:"Please enter Text",
						minlength:"Please enter more than 50 characters",
						maxlength:"Please enter less than 50 characters",
					},
					long_description:{
						required:"Please enter Text",
						minlength:"Please enter more than 50 characters"
					},
				}
			});
			$.validator.addMethod('filesize', function (value, element, param) {
				return this.optional(element) || (element.files[0].size <= param)
			}, 'File size must be less than 2 MB');

		});
	</script>
	<script>

		var editor = CKEDITOR.replace( 'long_description', {
			height: 300,
			filebrowserImageBrowseUrl : 'js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'links', groups: [ 'links' ] },
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
			],
			removeButtons: 'Image,Flash,Table,HorizontalRule,Smiley,Iframe,Save,NewPage,Templates,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,CopyFormatting,Language',
		});
		var editor = CKEDITOR.replace( 'short_description', {
			height: 200,
			filebrowserImageBrowseUrl : 'js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
			{ name: 'forms', groups: [ 'forms' ] },
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'links', groups: [ 'links' ] },
			{ name: 'styles', groups: [ 'styles' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
			{ name: 'insert', groups: [ 'insert' ] },
			{ name: 'colors', groups: [ 'colors' ] },
			{ name: 'tools', groups: [ 'tools' ] },
			{ name: 'others', groups: [ 'others' ] },
			{ name: 'about', groups: [ 'about' ] }
			],
			removeButtons: 'Image,Flash,Table,HorizontalRule,Smiley,Iframe,Save,NewPage,Templates,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,CopyFormatting,Language',
			on: {
				key: function(obj) {
					if (obj.data.keyCode === 8 || obj.data.keyCode === 46) {
						return true;
					}
					if (obj.editor.document.getBody().getText().length >= 300) {
						alert('No more characters possible');
						return false;
					}else { return true; }
				}
			}
		});
	</script>

	<script>
		$(document).ready(function(){
			$(".add-more").on("click", function(){
				var row_count = $(".clone_row").find(".service_row").length;
				if(row_count > 2) {
					alert("Only 3 telephone no can be enter");
					return false;
				}
				var telephone_clone = '<div class="row service_row form-group"> <div class="col-md-6"> <input type="text" required name="service_question['+row_count+']" class="form-control" maxlength="70"> </div> <div class="col-md-1"> <button type="button" class="btn btn-transition btn-outline-danger remove-row" title="Remove this Question?">X</button> </div> </div>';

				$(".clone_row").append(telephone_clone);

				$(".remove-row").on("click", function() {
					$(this).closest(".service_row").remove();
				});
			});

			$(".remove-row").on("click", function() {
				$(this).closest(".service_row").remove();
			});
		})
	</script>
	<script>
		$(document).ready(function() {
			$('input[name="image"]').change(function(){
				loadImagePreview(this, (395 / 375));
			});
			$('input[name="icon"]').change(function(){
				loadImagePreview(this, (60 / 60));
			});
			$('input[name="banner_image"]').change(function(){
				loadImagePreview(this, (1366 / 397));
			});
		});
	</script>
</body>
</html>