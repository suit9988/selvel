<?php 
	include_once 'include/functions.php';
   	$functions = new Functions();
	include_once('include/classes/Cart.class.php');

	$loggedInUserDetailsArr = $functions->sessionExists();
	$errorArr = array();

	if(isset($_POST['productId']) && !empty($_POST['productId'])){
		$productId = $functions->escape_string($functions->strip_all($_POST['productId']));
	} else {
		$errorArr[] = "ENTERPRODUCTID";
	}
	if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
		$quantity = $functions->escape_string($functions->strip_all($_POST['quantity']));
	} else {
		$errorArr[] = "ENTERQUANTITY";
	}
	if(isset($_POST['size']) && !empty($_POST['size'])){
		$size = $functions->escape_string($functions->strip_all($_POST['size']));
	} else {
		$errorArr[] = "SIZE";
	}

	if(isset($_POST['color']) && !empty($_POST['color'])){
		$color = $functions->escape_string($functions->strip_all($_POST['color']));
	} else {
		$errorArr[] = "COLOR";
	}

	if(isset($_POST['action']) && !empty($_POST['action'])){
		$action = $functions->escape_string($functions->strip_all($_POST['action']));
	} else {
		$errorArr[] = "SELECTACTION";
	}
	if(isset($_POST['isCartPage'])){
		$isCartPage = $functions->escape_string($functions->strip_all($_POST['isCartPage']));
	} else {
		$errorArr[] = "ENTERISCARTPAGE";
	}


	$responseArr = array();
	if(count($errorArr)>0){
		$errorStr = implode("|", $errorArr);
		$responseArr = array(
			"response" => false,
			"responseMsg" => "An error occurred while updating cart",
			"error" => $errorStr
		);
	} else {
		$cartObj = new Cart();
		if($action == "updateCart"){
			$cartResponse = $cartObj->setProductQuantityInCart($productId, $quantity, $size, $color);
			// /$cartObj->getCart();
			if(isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])){
				$couponCode = $functions->escape_string($functions->strip_all($_SESSION[SITE_NAME]['couponCode'][0]['couponCode']));
				if($loggedInUserDetailsArr = $functions->sessionExists()){
					$functions->applyCouponCode($couponCode, $loggedInUserDetailsArr);
				}
			}
		} else if($action == "updateCartDesc"){
			$cartResponse = $cartObj->setProductQuantityInCartDesc($productId, $quantity, $size, $color);
			// /$cartObj->getCart();
			if(isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])){
				$couponCode = $functions->escape_string($functions->strip_all($_SESSION[SITE_NAME]['couponCode'][0]['couponCode']));
				if($loggedInUserDetailsArr = $functions->sessionExists()){
					$functions->applyCouponCode($couponCode, $loggedInUserDetailsArr);
				}
			}
		} else if($action == "removeFromCart"){
			//$cartResponse = $cartObj->removeProductFromCart($productId,$price_id);
			$cartResponse = $cartObj->removeProductFromCart($productId,$size,$color);

			// == IF PRODUCT HAS DISCOUNT COUPON APPLIED REMOVE DISCOUNT COUPON ==
			if($functions->removeAllCouponCodes()){
				// coupon code removed
				// $cartResponse['responseMsg']
			}
			// == IF PRODUCT HAS DISCOUNT COUPON APPLIED REMOVE DISCOUNT COUPON ==

		} else if($action == "incrementInCart"){
			$cartResponse = $cartObj->addProductToCart($productId, $quantity,$size,$color);
		} else if($action == "decrementFromCart"){
			// $cartResponse = $cartObj->decrementProductFromCart($productId, $quantity); // NOT TESTED
		} else if($action == "applyCouponCode"){
			if(isset($_POST['couponCode']) && !empty($_POST['couponCode'])){
				/* if($loggedInUserDetailsArr = $functions->sessionExists()){
					$couponCode = $functions->escape_string($functions->strip_all($_POST['couponCode']));
					$cartResponse = $functions->applyCouponCode($couponCode, $loggedInUserDetailsArr);
					//print_r($cartResponse);exit;
				} else {
					$cartResponse = array(
						"response" => true,
						"responseMsg" => "Please login to apply this coupon code",
						"couponCodeMsg" => "Please login to apply this coupon code",
						"error" => "ENTERCOUPONCODE"
						);
				} */
				$couponCode = $functions->escape_string($functions->strip_all($_POST['couponCode']));
				$cartResponse = $functions->applyCouponCode($couponCode, $loggedInUserDetailsArr);
			} else {
				$cartResponse = array(
					"response" => true,
					"responseMsg" => "Please enter coupon code",
					"couponCodeMsg" => "Please enter a coupon code",
					"error" => "ENTERCOUPONCODE"
					);
			}
		} else if($action == "removeCouponCode"){
			$functions->removeAllCouponCodes();
			$cartResponse = array(
				"response" => true,
				"responseMsg" => "Coupon code removed",
				"couponCodeMsg" => "Coupon code removed",
				"error" => ""
				);
		}
		// print_r($cartResponse); // TEST

		if(!$cartResponse['response']){ // error
			$errorMsg = $cartResponse['error'];
		} else {
			$errorMsg = '';
		}

		$cartCount = $cartObj->getCartProductCount();
		// PREPARE HTML FOR CART POPUP
		include_once "include/cart/cart-inc.php"; // will create variable $cartHTML with cart HTML
		//include_once "include/cart/cart.inc.php"; // will create variable $cartHTML with cart HTML

		if($loggedInUserDetailsArr = $functions->sessionExists()){
			$amtArr = $functions->getCartAmountAndQuantity($cartObj, $loggedInUserDetailsArr);
		} else {
			$amtArr = $functions->getCartAmountAndQuantity($cartObj, null);
		}
		// $cartNotificationHTML = $amtArr['items'].' ITEM (S) <i class="fa fa-inr"></i> '.$amtArr['finalTotal']; // DEPRECATED
		$cartNotificationHTML = $amtArr['items'].' ITEM (S) <i class="fa fa-inr"></i> '.$amtArr['subTotalAfterCouponDiscount'];

		$cartPageHTML = "";
		$checkoutCartPageHTML = "";
		if($isCartPage=="1"){ // cart page HTML requested

			// == REMOVED ==
			// PREPARE HTML FOR CART PAGE
			include_once "include/cart/cart-inc.php"; // will create variable $cartPageHTML with cart HTML
			//include_once "include/cart/cart-page.inc.php"; // will create variable $cartPageHTML with cart HTML
			// == REMOVED ==

		} else if($isCartPage=="2"){ // checkout page cart HTML requested
			// PREPARE HTML FOR CHECKOUT CART PAGE
			include_once "include/cart/checkout-cart-page.inc.php"; // will create variable $checkoutCartPageHTML with cart HTML
			//include_once "include/cart/checkout-cart-page.inc.php"; // will create variable $checkoutCartPageHTML with cart HTML
		} else {
			$cartPageHTML = "";
			$checkoutCartPageHTML = "";
		}

		$responseArr = array(
			"response" => $cartResponse['response'],
			"responseMsg" => $cartResponse['responseMsg'],
			"errorMsg" => $errorMsg,
			"cartCount" => $cartCount,
			"cartHTML" => $cartHTML,
			"cartNotificationHTML" => $cartNotificationHTML,
			"cartPageHTML" => $cartPageHTML,
			"checkoutCartPageHTML" => $checkoutCartPageHTML
			);

		if(isset($cartResponse['couponCodeMsg'])){
			$responseArr['couponCodeMsg'] = $cartResponse['couponCodeMsg'];
		}

	}
	echo json_encode($responseArr);
?>