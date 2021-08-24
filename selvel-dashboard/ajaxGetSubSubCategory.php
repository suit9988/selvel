<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(isset($_GET['subcategory']) && !empty($_GET['subcategory'])) {
		if(is_array($_GET['subcategory'])) {
			$subcategory = implode(",", $_GET['subcategory']);
		} else {
			$subcategory = $admin->escape_string($admin->strip_all($_GET['subcategory']));
		}
		$subCategorySQL = $admin->getAllSubCategoriesLevel2($subcategory);
		$selectContent = '';
	
		while($subCategory = $admin->fetch($subCategorySQL)) {
			$selectContent .= '<option value="'.$subCategory['id'].'">'.$subCategory['category_name'].'</option>';
		}

		$ajaxResponse = array();
		$ajaxResponse['status'] = 1;
		$ajaxResponse['selectContent'] = $selectContent;
		echo json_encode($ajaxResponse);
	} else {
		$ajaxResponse = array();
		$ajaxResponse['status'] = 1;
		$ajaxResponse['selectContent'] = "";
		echo json_encode($ajaxResponse);
	}
?>