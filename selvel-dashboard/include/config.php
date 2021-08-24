<?php

	//DELUXORA DB CRED.
	/* incinson_deluxus	USER
	incinson_deluxora	DB
	auBTfWqxccQM		PASS */

	/*
	* CONFIG
	* - v1 - 
	* - v2 - updated BASE CONFIG, error_reporting based on PROJECTSTATUS
	* - v3 - added staging option
	* - v3.1 - BUGFIX in staging option
	*/

	/* DEVELOPMENT CONFIG */
	DEFINE('PROJECTSTATUS','LIVE');
	 // DEFINE('PROJECTSTATUS','STAGING');
	//DEFINE('PROJECTSTATUS','DEV');
	/* DEVELOPMENT CONFIG */

	/* TIMEZONE CONFIG */
	$timezone = "Asia/Calcutta";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	/* TIMEZONE CONFIG */

	if(PROJECTSTATUS=="LIVE"){
		error_reporting(0);
		//DEFINE('BASE_URL','https://www.selvelglobal.com');
		DEFINE('BASE_URL','https://solvoix.xyz/selvel');
		DEFINE('ADMIN_EMAIL','help@selvelglobal.com');

		// PAYMENT GATEWAY
		DEFINE('RAZORPAY_API_KEY_ID','rzp_live_f6uV65QAUehd7i');
		DEFINE('RAZORPAY_API_KEY_SECRET','TYskaHHhkyp2vqPmyVoUsWm9');
		DEFINE('WEBHOOK_SECRET','');
		// PAYMENT GATEWAY

		DEFINE('DELHIVERY_BASE_URL', 'https://track.delhivery.com');
		DEFINE('DELHIVERY_API_KEY', 'ecb8abc65cb0076e95617e2c67c21c7656fd8a9f');

	} else if(PROJECTSTATUS=="STAGING"){
		error_reporting(0);
		//DEFINE('BASE_URL','https://www.selvelglobal.com');
		DEFINE('BASE_URL','https://mockupbw.com/2021/selvel');
		DEFINE('ADMIN_EMAIL','info@selvel.com');

		// PAYMENT GATEWAY
		DEFINE('RAZORPAY_API_KEY_ID','rzp_test_NcgmZkpI1odSfw');
		DEFINE('RAZORPAY_API_KEY_SECRET','9bLIowAJei9cpPWI55NYYUlq');
		DEFINE('WEBHOOK_SECRET','');
		// PAYMENT GATEWAY

		DEFINE('DELHIVERY_BASE_URL', 'https://staging-express.delhivery.com');
		DEFINE('DELHIVERY_API_KEY', '5fdb69e93564b2e95f29240c21de7470583992f4');

	} else { 
		// DEFAULT TO DEV
		error_reporting(E_ALL);
		//DEFINE('BASE_URL','http://selvel.local');
		DEFINE('BASE_URL','https://mockupbw.com/2021/selvel');
		DEFINE('ADMIN_EMAIL','sameer@innovins.com');

		// PAYMENT GATEWAY
		DEFINE('RAZORPAY_API_KEY_ID','rzp_test_NcgmZkpI1odSfw');
		DEFINE('RAZORPAY_API_KEY_SECRET','9bLIowAJei9cpPWI55NYYUlq');
		DEFINE('WEBHOOK_SECRET','');
		// PAYMENT GATEWAY

		DEFINE('DELHIVERY_BASE_URL', 'https://staging-express.delhivery.com');
		DEFINE('DELHIVERY_API_KEY', '5fdb69e93564b2e95f29240c21de7470583992f4');

	}

	/* BASE CONFIG */
	DEFINE('SITE_NAME','Selvel');
	DEFINE('ADMIN_TITLE','Administrator Panel | '.SITE_NAME);
	DEFINE('TITLE', SITE_NAME);
	DEFINE('PREFIX','slv_');
	DEFINE('COPYRIGHT','2020');
	DEFINE('currentdate',date('Y-m-d H:i:s'));
	DEFINE('CURRENTDATETIME',date('Y-m-d H:i:s'));
	DEFINE('LOGO', BASE_URL.'/images/logo.png');
	DEFINE('FAVICON', BASE_URL.'/images/favicon-32x32.ico');
	DEFINE('CAPTCHA_PUBLIC_KEY','');
	DEFINE('CAPTCHA_PRIVATE_KEY','');


	DEFINE('ADMIN_PANEL', 'selvel-dashboard');
	/* BASE CONFIG */
?>