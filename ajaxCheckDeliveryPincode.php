<?php
    include_once 'include/functions.php';
    $functions = new Functions();
    // echo"<pre>";print_r($_POST);die();
    $response = 'true';
    $id = "";
	if(isset($_POST['pincode']) && !empty($_POST['pincode'])){
		$pincode = $functions->escape_string($functions->strip_all($_POST['pincode']));

		$pincodeURL = DELHIVERY_BASE_URL."/c/api/pin-codes/json/?token=".DELHIVERY_API_KEY."&filter_codes=".$pincode;

		$headers = array();
		$headers[] = 'Authorization: Token '.DELHIVERY_API_KEY;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $pincodeURL,
			CURLOPT_USERAGENT => '',
		));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		// Send the request & save response to $resp
		$resp = curl_exec($curl); // Getting jSON result string
		curl_close($curl);

		// Close request to clear up some resources
		$responseArr = json_decode($resp, true);
		if(count($responseArr['delivery_codes'])>0) {
			$response="true";
		} else {
			$response="false";
		}

		// $("input[name=user_type]").val();
		/* $sql = $functions->query("select * from ".PREFIX."pincode where pincode='".$pincode."'");

		if($functions->num_rows($sql)>0){
			$response="true";
		} else{
			$response="false";
		} */
	}
	echo $response;
?>