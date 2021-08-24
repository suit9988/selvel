<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$email = $admin->escape_string($admin->strip_all($_REQUEST['email']));
	if(isset($_REQUEST['id'])) {
		$id = $admin->escape_string($admin->strip_all($_REQUEST['id']));
		$result=$admin->query("select id from ".PREFIX."admin where email='".$email."' and id<>'$id' and is_deleted = '0'");
	} else {
		$result=$admin->query("select id from ".PREFIX."admin where email='".$email."' and is_deleted = '0'");
	}
	if($admin->num_rows($result)>0){
		echo 'false';
		exit;
	} else{
		echo 'true';
		exit;
	}
?>