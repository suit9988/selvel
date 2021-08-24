<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	if(isset($_GET['id'])) {
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
	}
	if(isset($_GET['product_id'])) {
		$id = $admin->escape_string($admin->strip_all($_GET['product_id']));
	}

	//$id = $admin->escape_string($admin->strip_all($_GET['id']));
	$field = $admin->escape_string($admin->strip_all($_GET['field']));

	$admin->query("update ".PREFIX."product_sizes set ".$field."='' where id='".$id."'");
	//exit();
	header("location: index.php");
	exit;
?>