<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$category_name = trim($admin->escape_string($admin->strip_all($_REQUEST['category_name'])));
	if(isset($_REQUEST['id'])) {
		$id = $admin->escape_string($admin->strip_all($_REQUEST['id']));
		$result=$admin->query("select * from ".PREFIX."size_master where size='$category_name' and id<>'$id'");
	} else {
		$result=$admin->query("select * from ".PREFIX."size_master where size='$category_name'");
	}
	if($admin->num_rows($result)>0){
		echo 'false';
		exit;
	} else{
		echo 'true';
		exit;
	}
?>