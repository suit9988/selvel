<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	$admin->checkUserPermissions('product_view', $loggedInUserDetailsArr);

	$pageName = "Products";
	$pageURL = 'index.php';
	$addURL = 'product-add.php';
	$deleteURL = 'index.php';
	$tableName = 'product_master';

	$sql = "select * from ".PREFIX.$tableName." order by id DESC";
	$results = $admin->query($sql);

	if(isset($_GET['status']) && isset($_GET['status']) && !empty($_GET['active_id']) && !empty($_GET['active_id'])){
		$status = trim($admin->strip_all($_GET['status']));
		$active_id = trim($admin->strip_all($_GET['active_id']));

		if($status=="1"){
			$updatestatus = '0';
		}elseif($status=="0"){
			$updatestatus = '1';
		}

		$sql="UPDATE ".PREFIX.$tableName." SET `active`='".$updatestatus."'  WHERE id='".$active_id."'";
		$admin->query($sql);

		header('location: '.$pageURL.'?updated');
		exit;
	}

	if(isset($_GET['delId']) && !empty($_GET['delId']) ){
		$delId = trim($admin->strip_all($_GET['delId']));

		$admin->deleteProduct($delId);

		header('location: '.$pageURL.'?deletesuccess');
		exit;
	}

	if(isset($_POST['upload'])) {
		
		$file = $_FILES['upload_csv']['name'];
		$tempname = $_FILES["upload_csv"]["tmp_name"]; 
		$folder = "csv/$file"; 
		move_uploaded_file($tempname,$folder);
		$handle = fopen('csv/'.$file,"r");
		$i=0;
		$j=1;
		//echo "hii";
		//exit();
		while(($fileop = fgetcsv($handle,1000,",")) != false) {
			if($j++!=1) {
				$category = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$sub_cat = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$sub_category_level2 = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$product_name = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$product_code = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$hsn_code = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$tax = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$active = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$page_title = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$meta_keyword = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$meta_description = $admin->escape_string($admin->strip_all($fileop[$i++]));

				$size = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$productcolor = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$customer_price = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$customer_discount_price = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$available_qty = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$weight = $admin->escape_string($admin->strip_all($fileop[$i++]));
				$features_color = $admin->escape_string($admin->strip_all($fileop[$i++]));

				//permaCode
					$prefix	= '';
					$permalink 	= str_shuffle('1234567890');
					$permalink 	= substr($permalink,0,8);
					$permalink 	= $admin->generate_id($prefix, $permalink, 'product_master', 'permalink');
				//permaCode::end
				
				$createdDate = date('Y-m-d H:i:s');

				$checkRS = $admin->query("select * from ".PREFIX."product_master where product_code LIKE '".$product_code."'");
				if($admin->num_rows($checkRS)>0) {
					$productDetails = $admin->fetch($checkRS);

					$admin->query("update ".PREFIX."product_master set product_name='".$product_name."', hsn_code='".$hsn_code."', tax='".$tax."', active='".$active."', page_title='".$page_title."', meta_keyword='".$meta_keyword."', meta_description='".$meta_description."' where id='".$productDetails['id']."'");

					$product_id = $productDetails['id'];

					$admin->query("delete from ".PREFIX."product_sizes where product_id='".$product_id."'");
					$admin->deleCategoryByProductId($product_id);
					$admin->deleSubCategoryByProductId($product_id);
					$admin->deleSubSubCategoryByProductId($product_id);
				} else {
					$sql = "INSERT INTO ".PREFIX."product_master(`product_name`, `product_code`, `hsn_code`, `tax`, `active`, page_title, meta_keyword, meta_description, `permalink`) VALUES ('".$product_name."', '".$product_code."', '".$hsn_code."', '".$tax."', '".$active."', '".$page_title."', '".$meta_keyword."', '".$meta_description."', '".$permalink."')";
					$admin->query($sql);
					$product_id = $admin->last_insert_id();
				}
				
				//exit();
				$sizeArr = explode('|', $size);
				$colorArr = explode('|', $productcolor);
				$mrpArr = explode('|', $customer_price);
				$discountArr = explode('|', $customer_discount_price);
				$qtyArr = explode('|', $available_qty);
				$weightArr = explode('|', $weight);
				$descriptionArr = explode('|', $features_color);

				if(isset($sizeArr) && sizeof($sizeArr)>0){
					foreach($sizeArr as $key=>$value) {
						$size = $sizeArr[$key];
						$productcolor = $colorArr[$key];
						$customer_price = $mrpArr[$key];
						$customer_discount_price = $discountArr[$key];
						$available_qty = $qtyArr[$key];
						$weight = $weightArr[$key];
						$features_color = $descriptionArr[$key];

						//permaCode
							$prefix	= '';
							$permalink 	= str_shuffle('1234567890');
							$permalink 	= substr($permalink,0,8);
							$permalink 	= $admin->generate_id($prefix, $permalink, 'product_sizes', 'permalink');
						//permaCode::end

						$admin->query("INSERT INTO ".PREFIX."product_sizes(`product_id`, `permalink`, `size`, `customer_price`, `customer_discount_price`, `available_qty`, `productcolor`, weight, features_color) VALUES ('".$product_id."', '".$permalink."', '".$size."', '".$customer_price."','".$customer_discount_price."','".$available_qty."', '".$productcolor."', '".$weight."', '".$features_color."')");
					}
				}

				$catArray = explode('|', $category);
				$subCatArray = explode('|', $sub_cat);
				$subCatLevel2Array = explode('|', $sub_category_level2);
				// $attributeArray = explode('|', $attribute);

				if(isset($catArray) && sizeof($catArray)>0){
					foreach($catArray as $oneData) {
						$sql = $admin->query("select * from ".PREFIX."category_master where category_name LIKE '".$oneData."'");
						if($admin->num_rows($sql)>0) {
							$data = $admin->fetch($sql);
							$category_id = $admin->escape_string($admin->strip_all($data['id']));
							$addCat = "INSERT INTO ".PREFIX."product_category_mapping(`category_id`, `product_id`) VALUES ('".$category_id."','".$product_id."')";
							//exit();
							$admin->query($addCat);
						}
					}
				}

				if(isset($subCatArray) && sizeof($subCatArray)>0){
					foreach($subCatArray as $oneData) {
						$sql = $admin->query("select * from ".PREFIX."sub_category_master where category_name LIKE '".$oneData."'");
						if($admin->num_rows($sql)>0) {
							$data = $admin->fetch($sql);
							$subcategory_id = $admin->escape_string($admin->strip_all($data['id']));
							$category_id = $admin->escape_string($admin->strip_all($data['category_id']));
							$addSubCat = "INSERT INTO ".PREFIX."product_subcategory_mapping(`category_id`,`subscategory_id`, `product_id`) VALUES ('".$category_id."','".$subcategory_id."','".$product_id."')";
							$admin->query($addSubCat);
						}
					}
				}

				if(isset($subCatLevel2Array) && sizeof($subCatLevel2Array)>0){
					foreach ($subCatLevel2Array as $oneData) {
						$sql = $admin->query("select * from ".PREFIX."subsubcategory where category_name LIKE '".$oneData."'");
						if($admin->num_rows($sql)>0) {
							$data = $admin->fetch($sql);
							$subsubcategory_id = $admin->escape_string($admin->strip_all($data['id']));
							$addSubCat = "INSERT INTO ".PREFIX."product_subsubcategory_mapping(`subsubcategory_id`, `product_id`) VALUES ('".$subsubcategory_id ."','".$product_id."')";
							$admin->query($addSubCat);
						}
					}
				}
				
				/* if(isset($attributeArray) && sizeof($attributeArray)>0){
					foreach ($attributeArray as $oneData) {
						$sql = $admin->query("select * from ".PREFIX."attribute_features where feature LIKE '".$oneData."'");
						if($admin->num_rows($sql)>0) {
							$data = $admin->fetch($sql);
							$attribute_feature_id = $admin->escape_string($admin->strip_all($data['id']));
							$addAttFeat = "INSERT INTO ".PREFIX."product_attributes(`attribute_feature_id`, `product_id`) VALUES ('".$attribute_feature_id ."','".$product_id."')";
							$admin->query($addAttFeat);
						}
					}
				} */

			}
			$i=0;
		}
		header("location: ".$pageURL."?success");
		exit;
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
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]
	-->
	<style type="text/css">
		div#centerpositon.shottube div#DataTables_Table_0_wrapper > .row:nth-child(1) {
		    position: relative;
		    top: 0px;
		    left: 16px;
		    transform: translate(0%);
		    background: #ffffff8a;
		    /* padding-right: 40px; */
		    padding-top: 7px;
		    border: 1px solid #ddd;
		    width: 100%;
		    margin-bottom: 10px;
		}
		.table.custom-table > tbody > tr > td, .table.custom-table > tbody > tr > th, .table.custom-table > tfoot > tr > td, .table.custom-table > tfoot > tr > th, .table.custom-table > thead > tr > td, .table.custom-table > thead > tr > th {
		    padding: 10px 2px !important;
		    vertical-align: middle;
		    font-size: 13px;
		}
		table.dataTable thead > tr > th.sorting {
		    text-align: center;
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
								<li class="breadcrumb-item active"><?php echo $pageName; ?></li>
							</ul>
						</div>
						<?php if(in_array('product_create',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') { ?>
							<div class="col-auto float-right ml-auto">
								<a href="<?php echo $addURL; ?>" class="btn add-btn"><i class="fa fa-plus"></i> Add <?php echo $pageName; ?></a>
								<a href="javascript:void(0);" class="btn add-btn openbtnblick"><i class="fa fa-file"></i> CSV Option</a>
							</div>
						<?php } ?>
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

				<?php if(isset($_GET['deletesuccess'])){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
					</div><br/>
				<?php } ?>

				<div class="row" id="openblocks">
					<div class="col-md-12">
						<form action="" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="card">
								<!-- <div class="card-header">
									<h4 class="card-title mb-0"> Upload CSV</h4>
								</div> -->
								<div class="card-body removebottom10">
									<div class="form-group row">
										<div class="col-md-2 flexcentr">											
											<h4 class="card-title-csusiom"> Upload CSV</h4>
										</div>
										<div class="col-sm-6 flexclumns">
											<label>Upload CSV File</label>
											<input type="file" class="form-control" name="upload_csv" id="upload_csv" />
											<button type="submit" name="upload" class="btn btn-warning">Upload</button>
										</div>
										<div class="col-md-4 flexcentr">
											<a href="export-products.php" download> <i class="fa fa-download"></i> Export Product CSV</a> | <a  download> 
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="row shottube" id="centerpositon">
					<div class="col-md-12">
						<table class="table table-striped custom-table mb-0 datatable2 datatable-selectable-data responsives nowraps">
							<thead>
								<tr>
									<th>Sr.no</th>
									<th>Product Image</th>
									<th>Product Name</th>
									<th>Category</th>
									<th>Sub-Category</th>
									<th>Product Code</th>
									<th class="semos">Size </th>
									<th class="semos">Color</th>
									
									<th class="semos">MRP </th>
									<th class="semos">Discounted Price </th>
									<th>Available Count </th>
								
									<th class="semos">Active</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$x = 1;
									while($row = $admin->fetch($results)) {
										$productSize = $admin->fetch($admin->query("select * from ".PREFIX."product_sizes where product_id='".$row['id']."' order by id LIMIT 0,1"));
										$file_name = str_replace('', '-', strtolower( pathinfo($productSize['image1_color'], PATHINFO_FILENAME)));
										$ext = pathinfo($productSize['image1_color'], PATHINFO_EXTENSION);
								?>
										<tr>
											<td><?php echo $x++ ?></td>
											<td><img width="60" src="../images/products/<?php echo $file_name.'_crop.'.$ext ?>"  /></td>
											<td><?php echo $row['product_name']; ?></td>
											<td>
												<?php
													$p_id=$row['id'];
													$sql_cat = "select * from ".PREFIX."product_subcategory_mapping where product_id='$p_id'";
													$results_cat = $admin->query($sql_cat);
													$row_cat = $admin->fetch($results_cat);
													$cc_id=$row_cat['category_id'];
													$ss_id=$row_cat['subscategory_id'];

													$sql_cat1 = "select * from ".PREFIX."product_category_mapping where product_id='$p_id'";
													$results_cat1 = $admin->query($sql_cat1);
													$row_cat1 = $admin->fetch($results_cat1);
													echo $admin->getUniqueCategoryById($row_cat1['category_id'])['category_name'];

													$sql_cat2 = "select * from ".PREFIX."sub_category_master where id='$ss_id'";
													$results_cat2 = $admin->query($sql_cat2);
													$row_cat2 = $admin->fetch($results_cat2);
												?>
											</td>
											<td>
												<?php
													echo $row_cat2['category_name'];
												?>
											</td>
											<td><?php echo $row['product_code']; ?></td>
											<td class="semos">
											<div class="ovrflowsa">
												<?php
													$sql_size = "select * from ".PREFIX."product_sizes where product_id='$p_id' order by id DESC";
													$results_size = $admin->query($sql_size);
													while($row_size = $admin->fetch($results_size)){
														echo $row_size['size']."<br>";
													}
												?>
											</div>
											</td>
											<td class="semos">
												<div class="ovrflowsa">
													<?php
														$p_id=$row['id'];
														$results_size->data_seek(0);
														while($row_color = $admin->fetch($results_size)){
															echo $row_color['productcolor']."<br>";
														}
													?>
												</div>
											</td>
											<td class="semos">
											<div class="ovrflowsa">
												<?php
													$results_size->data_seek(0);
													while($row_mrp = $admin->fetch($results_size)){
												?>
														<i class="fa fa-rupee"></i> <?php echo $row_mrp['customer_price']."<br>";
													}
												?>
											</div>
											</td>
											<td class="semos">
											<div class="ovrflowsa">
												<?php
													$results_size->data_seek(0);
													while($row_discount = $admin->fetch($results_size)){
												?>
														<i class="fa fa-rupee"></i> <?php echo $row_discount['customer_discount_price']."<br>";
													}
												?>
											</div>
											</td>
											
												<td class="semos">
											<div class="ovrflowsa">
												<?php
													$results_size->data_seek(0);
													while($row_qty = $admin->fetch($results_size)){
														echo $row_qty['available_qty']."<br>";
													}
												?>
											</div>
											</td>
											<td>
												<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Click to Change Product Status" ><?php echo (($row['active']==1) ? "Yes" : "No"); ?></a>
											</td>
											<td>
												<?php
													if(in_array('product_update',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<?php if($row['active']==1) { ?>
															<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Mark as Inactive" class="btn-transition btn"><i class="fa fa-close"></i></a>
														<?php } else if($row['active']==0) { ?>
															<a href="<?php echo $pageURL ?>?status=<?php echo $row['active'];?>&active_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to update status?');" title="Mark as Active" class="btn-transition btn"><i class="fa fa-check"></i></a>
														<?php } ?>
														<a class="btn-transition btn" href="product-variants.php?&product_id=<?php echo $row['id']; ?>" title="Product Variants"> <i class="fa fa-list-alt"></i> </a>
														<a class="btn-transition btn" href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id']; ?>" title="Edit">   <i class="fa fa-pencil"></i> </a>
												<?php
													}
												?>
												<?php
													if(in_array('product_delete',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<a class="btn-transition btn" href="<?php echo $deleteURL; ?>?delId=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"> <i class="fa fa-trash-o"></i> </a> 
												<?php
													}
												?>
												<?php
													if(in_array('notify_view',$userPermissionsArray) or $loggedInUserDetailsArr['role']=='super') {
												?>
														<a class="btn-transition btn" href="notify-products.php?search&productid=<?php echo $row['id']; ?>" title="Notify Customer List">   <i class="fa fa-envelope"></i> </a>
												<?php
													}
												?>
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
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

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Datatable JS -->
	<script src="assets/js/jquery.dataTables.min.js"></script>

	<!-- for button js-->
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

	<!-- Validate JS -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/additional-methods.js"></script>

	<script>
		$(document).ready(function() {
			$(".openbtnblick").click(function(){
				$("#openblocks").slideToggle();;
			});
			$(".datatable2").DataTable( {
				/* dom: 'Bfrtip',
				buttons: [
			            { extend: 'excel', text: 'Export to excel' }
			        ] */
			  });
			$("#form").validate({
				rules: {
					upload_csv: {
						required: true,
						extension: "csv"
					}
				},
				messages: {
					upload_csv: {
						extension: "Please upload csv file"
					}
				}
			});
		});
	</script>
	
</body>
</html>