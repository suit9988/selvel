<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';

	$admin = new AdminFunctions();
	$output = '';
	if(isset($_POST['subcategory'])) {
		$whereCond = '';

		if(isset($_POST['subcategory']) and count($_POST['subcategory'])>0) {
			$subcatCond = array();
			foreach($_POST['subcategory'] as $oneData) {
				$oneData = $admin->escape_string($admin->strip_all($oneData));

				$subcatCond[] =" FIND_IN_SET('".$oneData."', size_subcategory)";
			}
			if(count($subcatCond)>0) {
				$whereCond .= " and (".implode(' OR ', $subcatCond).")";
			}
		}

		$sizeRS = $admin->query("select * from ".PREFIX."size_master where id<>'' ".$whereCond);
		if($admin->num_rows($sizeRS) > 0) {
			while($sizeDetails = $admin->fetch($sizeRS)) {
				$output	.= '<option value="'.$sizeDetails['size'].'">'.$sizeDetails['size'].'</option>';
			}
		}
	}
	echo $output;
	exit;
?>