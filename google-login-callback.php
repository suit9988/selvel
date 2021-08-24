<?php
	include_once 'include/functions.php';
	$functions = new Functions();

	
	$failedURL = BASE_URL."/login.php";

	// == GOOGLE PLUS LOGIN ==
	$google_client_id 		= '764398092262-26fv9jpj8t7ufaaebi9dho66letsfltg.apps.googleusercontent.com';
	$google_client_secret 	= 'IlHOw21vBzF8tUAGIXFXTasH';
	$google_developer_key 	= 'AIzaSyA3zWihY_YHygTkf_5Ehkae-n6wK5HVWkg';

	require_once 'google/Google_Client.php';
	require_once 'google/contrib/Google_Oauth2Service.php';

	$gClient = new Google_Client();
	$gClient->setApplicationName('Login to '.SITE_NAME);
	$gClient->setClientId($google_client_id);
	$gClient->setClientSecret($google_client_secret);
	// $gClient->setRedirectUri($google_redirect_url);
	$gClient->setDeveloperKey($google_developer_key);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
	if(isset($_REQUEST['redirect'])){
		$redirect = $functions->strip_all($_GET['redirect']);
		$google_redirect_url 	= BASE_URL.'/google-login-callback.php?redirect='.$redirect; //path to your script
		$gClient->setRedirectUri($google_redirect_url);
	} else {
		header("location: ".$failedURL."?error=LOGINREDIRECTFALIED");
		exit;
	}
	/* if(isset($_REQUEST['reset'])){
		// log put user
		unset($_SESSION[SITE_NAME.'googlePlusToken']);
		$gClient->revokeToken();
		header('location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
		exit;
	} */

	if(isset($_GET['code'])){
		$code = $functions->strip_all($_GET['code']);
		try{
			$loginResult = $gClient->authenticate($code);
		} catch(Exception $e){
			echo $e;
			exit;
			header("location: ".$failedURL."?error=LOGINFALIED");
			exit;
		}
	} else if(isset($_SESSION[SITE_NAME.'googlePlusToken'])){
		$gClient->setAccessToken($_SESSION[SITE_NAME.'googlePlusToken']);
	} else {
		header("location: ".$failedURL."?error=LOGINFAILED");
		exit;
	}

	if($_SESSION[SITE_NAME.'googlePlusToken'] = $gClient->getAccessToken()){ // USER LOGGED IN IN GOOGLE
		//For logged in user, get details from Google using access token
		// $google_oauthV2 = new Google_Oauth2Service($gClient);
		$googleuser 		= $google_oauthV2->userinfo->get();
		// == TEST ==
			// echo '<pre>';
			// print_r($googleuser);
			// echo '</pre>';
			// exit;
		// == TEST ==
		$user_id 			= $googleuser['id'];
		$user_name 			= filter_var($googleuser['name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$email 				= filter_var($googleuser['email'], FILTER_SANITIZE_EMAIL);
		$gender 			= filter_var($googleuser['gender'], FILTER_SANITIZE_SPECIAL_CHARS);
		// $profile_url 			= filter_var($googleuser['link'], FILTER_VALIDATE_URL);
		// $profile_image_url 	= filter_var($googleuser['picture'], FILTER_VALIDATE_URL);
		// $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
		// $_SESSION[SITE_NAME.'googlePlusToken'] 	= $gClient->getAccessToken(); // DEPRECATED

		$name = explode(' ', $user_name);
		$fname = $name[0];
		$lname = $name[1];

		// REGISTER NEW USER
		if($functions->isCustomerEmailUnique($email)){ // REGISTER USER

			$newUserData = array();
			$newUserData['name'] = $fname;
			$newUserData['mobile'] = '';
			$newUserData['email'] = $email;
			$newUserData['password'] = md5(time().'sv_password'.$email.time());
			$active = '1';

			$registerResponse = $functions->addUser($newUserData, $active);

			$functions->userSocialLogin($email, "index.php", "login.php?failed", '', '');
			header("location: index.php");
			exit;

		} else { // LOGIN USER
			if(isset($_GET['redirect']) && !empty($_GET['redirect'])){
				$redirect = $functions->escape_string($functions->strip_all($_GET['redirect']));
				$functions->userSocialLogin($email, $redirect, "login.php?failed&redirect=".$redirect, '', '');
				header("location: ".$redirect);
				exit;
			} else {
				$functions->userSocialLogin($email, "index.php", "login.php?failed", '', '');
				header("location: index.php");
				exit;
			}
		}

	} else { // LOGIN FALIED
		header("location: ".$failedURL."?error=GOOGLELOGINFALIED");
		exit;
		// $authUrl = $gClient->createAuthUrl(); // DEPRECATED
	}
	// == GOOGLE PLUS LOGIN ==
?>