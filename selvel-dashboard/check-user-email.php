<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$email = trim($admin->escape_string($admin->strip_all($_REQUEST['email'])));
	if(isset($_REQUEST['id'])) {
		$id = $admin->escape_string($admin->strip_all($_REQUEST['id']));
		$result=$admin->query("select * from ".PREFIX."customers where email='$email' and id<>'$id'");
	} else {
		$result=$admin->query("select * from ".PREFIX."customers where email='$email'");
	}
	if($admin->num_rows($result)>0){
		echo 'false';
		exit;
	} else{
		echo 'true';
		exit;
	}
?>