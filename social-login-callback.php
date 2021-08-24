<?php
	include_once 'include/functions.php';
	$functions = new Functions();

	$failedURL = BASE_URL."/login.php";

	require_once "Facebook/autoload.php";

	$fb = new Facebook\Facebook([
		'app_id' 				  => '249221810031783',
		'app_secret' 			  => '48690456ccfdd5cfb7c7ebe0e955d38c',
		'default_graph_version'   => 'v2.6',
		'persistent_data_handler' =>'session'
	]);
	$helper = $fb->getRedirectLoginHelper();

	try {
		$accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		// echo 'Graph returned an error: ' . $e->getMessage();
		// echo 'Unable to login using Facebook - ERROR 1';
	 	echo $e->getMessage(). "\n";
	 	if ($helper->getError()) {
		   // header('HTTP/1.0 401 Unauthorized');
		    echo "Error: " . $helper->getError() . "\n";
		    echo "Error Code: " . $helper->getErrorCode() . "\n";
		    echo "Error Reason: " . $helper->getErrorReason() . "\n";
		    echo "Error Description: " . $helper->getErrorDescription() . "\n";
		}
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
	 	
	 	//echo 'Facebook SDK returned an error: ' . $e->getMessage();
	 	echo $e->getMessage();

	 	if ($helper->getError()) {
		   // header('HTTP/1.0 401 Unauthorized');
		    echo "Error: " . $helper->getError() . "\n";
		    echo "Error Code: " . $helper->getErrorCode() . "\n";
		    echo "Error Reason: " . $helper->getErrorReason() . "\n";
		    echo "Error Description: " . $helper->getErrorDescription() . "\n";
		}

		//echo 'Unable to login using Facebook - ERROR 2';
		exit;
	}

	if(isset($accessToken)) { // USER LOGGEDIN IN FACEBOOK

		$_SESSION[SITE_NAME.'_facebook_access_token'] = (string) $accessToken;
		$fb->setDefaultAccessToken($_SESSION[SITE_NAME.'_facebook_access_token']);
		$response = $fb->get('/me?fields=id,name,email,first_name,last_name');
		$userNode = $response->getGraphUser();
		$me_array = $userNode->asArray();
		
		// == TEST ==
			// echo '<pre>';
			// print_r($me_array);
			// echo '</pre>';
			// exit;
		// == TEST ==

		$email = $me_array['email'];
		$first_name = $me_array['first_name'];
		$last_name = $me_array['last_name'];
		$profile_pic = $me_array['profile_pic'];
		$fb_userId = $me_array['id'];

		if($functions->isCustomerEmailUnique($email)){ // REGISTER USER

			$newUserData = array();
			$newUserData['name'] = $first_name;
			$newUserData['mobile'] = "";
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
		// Now you can redirect to another page and use the
		// access token from $_SESSION[SITE_NAME.'_facebook_access_token']
	} else {
		header("location: ".$failedURL."?error=FACEBOOKLOGINFALIED");
		exit;
	}
?>