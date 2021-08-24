<?php
	Include_once("include/functions.php");
	$functions = New Functions();
	//print_r($_GET);
	if(!$loggedInUserDetailsArr = $functions->sessionExists()){
		header("location: login.php");
		exit;
	}
	else{
		if(isset($_GET['product_id']) && !empty($_GET['product_id']) && isset($_GET['size']) && !empty($_GET['size'])){
			$product_id = $functions->escape_string($functions->strip_all($_GET['product_id']));
			$size = $functions->escape_string($functions->strip_all($_GET['size']));
			$color = $functions->escape_string($functions->strip_all($_GET['color']));

			$prodType = '';
			if(isset($_GET['prodType']) && !empty($_GET['prodType'])){
				$prodType = $functions->escape_string($functions->strip_all($_GET['prodType']));
			}

			

			$query = "select * from ".PREFIX."customers_wishlist where product_id='".$product_id."' AND size='".$size."' and customer_id='".$loggedInUserDetailsArr['id']."'";
			$result = $functions->query($query);
			$str = "";
			if($functions->num_rows($result)>0){
				$str .= "Product Already Added to Wishlist";
				//$str .= "";
			}else{
				$query = "insert into ".PREFIX."customers_wishlist(color,customer_id, product_id ,size, product_type) values ('".$color."','".$loggedInUserDetailsArr['id']."', '".$product_id."','".$size."', '".$prodType."')";
				$functions->query($query);
				//$str .= "<i class='fa fa-heart-o'></i> Added to wishlist";
				$str .= "Added to wishlist";
			}
			$query = "select * from ".PREFIX."customers_wishlist where customer_id='".$loggedInUserDetailsArr['id']."'";
			$result = $functions->query($query);
			
			$response['message'] = $str;
			$response['wishlistCount'] = $functions->num_rows($result);
			//echo $response;
			echo json_encode($response);
		}
	}

?>