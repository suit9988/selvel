<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$filename = "PRODUCT-EXPORT-".date('Y-m-d-his').".csv";
	header("Content-Type: text/csv"); 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename"); 
	header("Pragma: no-cache"); 
	header("Expires: 0");

	$header = array();
	$header[] = 'Category';
	$header[] = 'Sub Category';
	$header[] = 'Sub Category Level 2';
	$header[] = 'Product Name';
	$header[] = 'Product Code';
	$header[] = 'HSN Code';
	$header[] = 'Tax';
	$header[] = 'Active';
	$header[] = 'Page Title';
	$header[] = 'Meta Keywords';
	$header[] = 'Meta Description';
	$header[] = 'Size';
	$header[] = 'Color';
	$header[] = 'MRP';
	$header[] = 'Discounted Price';
	$header[] = 'Availability';
	$header[] = 'Weight';
	$header[] = 'Description';

	echo implode(',', $header);
	echo "\n";

	$sql = "select * FROM ".PREFIX."product_master order by id DESC";
	$result = $admin->query($sql);

	$replace_keywords = array('"', ",", "\r", "\n", "\t");

	while($row = $admin->fetch($result)) {
		$outputArr = array();

		$catRS = $admin->query("select * from ".PREFIX."product_category_mapping where product_id='".$row['id']."'");
		$catArr = array();
		while($catDetails = $admin->fetch($catRS)) {
			$catArr[] = $admin->getUniqueCategoryById($catDetails['category_id'])['category_name'];
		}
		$outputArr[] = implode('|', $catArr);

		$subCatRS = $admin->query("select * from ".PREFIX."product_subcategory_mapping where product_id='".$row['id']."'");
		$subcatArr = array();
		while($subcatDetails = $admin->fetch($subCatRS)) {
			$subcatArr[] = $admin->getUniqueSubCategoryById($subcatDetails['subscategory_id'])['category_name'];
		}
		$outputArr[] = implode('|', $subcatArr);

		$subsubCatRS = $admin->query("select * from ".PREFIX."product_subsubcategory_mapping where product_id='".$row['id']."'");
		$subsubcatArr = array();
		while($subsubcatDetails = $admin->fetch($subsubCatRS)) {
			$subsubcatArr[] = $admin->getUniqueSubCategoryLevel2ById($subsubcatDetails['subsubcategory_id'])['category_name'];
		}
		$outputArr[] = implode('|', $subsubcatArr);

		$outputArr[] = $row['product_name'];
		$outputArr[] = $row['product_code'];
		$outputArr[] = $row['hsn_code'];
		$outputArr[] = $row['tax'];
		$outputArr[] = $row['active'];
		$outputArr[] = $row['page_title'];
		$outputArr[] = $row['meta_keyword'];
		$outputArr[] = $row['meta_description'];

		$sizeRS = $admin->query("select * from ".PREFIX."product_sizes where product_id='".$row['id']."' order by id");

		$sizeArr = array();
		$colorArr = array();
		$mrpArr = array();
		$discountArr = array();
		$qtyArr = array();
		$weightArr = array();
		$descriptionArr = array();

		while($sizeDetails = $admin->fetch($sizeRS)) {
			$sizeArr[] = str_replace($replace_keywords, " - ", $sizeDetails['size']);
			$colorArr[] = str_replace($replace_keywords, " - ", $sizeDetails['productcolor']);
			$mrpArr[] = $sizeDetails['customer_price'];
			$discountArr[] = $sizeDetails['customer_discount_price'];
			$qtyArr[] = $sizeDetails['available_qty'];
			$weightArr[] = $sizeDetails['weight'];
			$descriptionArr[] = str_replace($replace_keywords, " - ", $sizeDetails['features_color']);
		}

		$outputArr[] = implode('|', $sizeArr);
		$outputArr[] = implode('|', $colorArr);
		$outputArr[] = implode('|', $mrpArr);
		$outputArr[] = implode('|', $discountArr);
		$outputArr[] = implode('|', $qtyArr);
		$outputArr[] = implode('|', $weightArr);
		$outputArr[] = implode('|', $descriptionArr);

		echo implode(',', $outputArr);
		echo "\n";

	}
?>