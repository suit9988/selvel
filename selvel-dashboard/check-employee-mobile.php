<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$mobile = $admin->escape_string($admin->strip_all($_REQUEST['mobile']));
	if(isset($_REQUEST['id'])) {
		$id = $admin->escape_string($admin->strip_all($_REQUEST['id']));
		$result=$admin->query("select id from ".PREFIX."admin where mobile='".$mobile."' and id != '".$id."' and is_deleted = '0'");
	} else {
		$result=$admin->query("select id from ".PREFIX."admin where mobile='".$mobile."' and is_deleted = '0'");
	}
	if($admin->num_rows($result)>0){
		echo 'false';
		exit;
	} else{
		echo 'true';
		exit;
	}
?>