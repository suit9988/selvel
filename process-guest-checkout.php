<?php 
	include_once 'include/functions.php';
	$functions = new Functions();

	if(!$_SESSION[SITE_NAME]['cart']) {
		header("location: index.php");
		exit;
	}

	// $addressId = $functions->addCustomerAddress($_POST, $loggedInUserDetailsArr['id']);
	$_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress'] = $_POST;
	$_SESSION[SITE_NAME]['BILLADDRESS']['email'] = $_POST['customer_email'];

	header("location: checkout-preview.php");
	exit;
?>