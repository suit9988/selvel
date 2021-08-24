<?php
	/* 
	 * IMPORTANT - IMPORTANT - IMPORTANT
	 * ALSO UPDATE social-login-callback.php - FACEBOOK
	 * ALSO UPDATE google-login-callback.php - GOOGLE
	 * IMPORTANT - IMPORTANT - IMPORTANT
	 */

	// ======================================================= FACEBOOK LOGIN =================================================

		require_once "Facebook/autoload.php";
		// 1553874728254870	
		// c1008d3583aa16b4542a7bcf4c307bee
		// v2.6

		// 100012722559556
		// fourwall_dlvqkcd_testuser@tfbnw.net
		// abc12345

		$fb = new Facebook\Facebook([
			'app_id' => '249221810031783',
			'app_secret' => '48690456ccfdd5cfb7c7ebe0e955d38c',
			'default_graph_version' => 'v2.6',
			'persistent_data_handler'=>'session'
		]);
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email']; // optional
		// $loginUrl = $helper->getLoginUrl(BASE_URL.'/social-login-callback.php', $permissions);

	// ======================================================== FACEBOOK LOGIN ===============================================

	// =================================================== GOOGLE PLUS LOGIN ==================================================

		$google_client_id 		= '764398092262-26fv9jpj8t7ufaaebi9dho66letsfltg.apps.googleusercontent.com';
		$google_client_secret 	= 'IlHOw21vBzF8tUAGIXFXTasH';
		// $google_redirect_url 	= 'index.php'; //path to your script
		$google_developer_key 	= 'AIzaSyA3zWihY_YHygTkf_5Ehkae-n6wK5HVWkg';
		require_once 'google/Google_Client.php';
		require_once 'google/contrib/Google_Oauth2Service.php';

		$gClient = new Google_Client();
		$gClient->setApplicationName('Login to '.SITE_NAME);
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);

		$google_oauthV2 = new Google_Oauth2Service($gClient); // DEPRECATED

	// =================================================== GOOGLE PLUS LOGIN ===================================================
?>