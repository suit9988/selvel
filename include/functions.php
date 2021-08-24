<?php
	$rootDir = dirname(dirname(__FILE__));

	include_once($rootDir.'/selvel-dashboard/include/config.php');
	include_once($rootDir.'/include/login-functions.php');
	//include_once($rootDir.'/include/helper-functions.php');
	include_once($rootDir.'/include/classes/SaveImage.class.php');
	include_once($rootDir.'/include/classes/CSRF.class.php');
	include_once($rootDir."/include/classes/Otp.class.php");
	include_once($rootDir.'/include/classes/Cart.class.php');

	/*
	 * Functions
	 * v1 - updated loginSession(), logoutSession(), customerLogin()
	 * v2 - added $groupType option
	 * v3 - checks if user(customer) is verified or not while login
	 * v4 - added support for SaveImage.class.php
	 * v5 - added support for AJAX login
	 * v6 - checks if user is active or not while login
	 * v7 - replaced customerLogin() with userLogin(), 
			updated userLogin() to use ajaxCustomerLogin()
			checks if user(wholesale) is verified or not while login
	 * v8 - added userSocialLogin()
	 */
	class Functions extends LoginFunctions {

		/** * Function to get image directory */
		function getImageDir($imageFor){
			switch($imageFor){
				case "banner":
					$fileDir = "images/banner/";
					break;
				case "category":
					$fileDir = "images/category/";
					break;
				case "sub_category":
					$fileDir = "images/sub_category/";
					break;
				case "subsubcategory":
					$fileDir = "images/subsubcategory/";
					break;
				case "sub_subsubcategory":
					$fileDir = "images/sub_subsubcategory/";
					break;
				case "subsub_subsubcategory":
					$fileDir = "images/subsub_subsubcategory/";
					break;
				case "products":
					$fileDir = "images/products/";
					break;
				case "static_banner":
					$fileDir = "images/static_banner/";
					break;
				case "occasion":
					$fileDir = "images/occasion/";
					break;
				case "testimonials":
					$fileDir = "images/testimonials/";
					break;
				case "MainBasket":
					$fileDir = "images/MainBasket/";
					break;
				case "hamper":
					$fileDir = "images/hamper/";
					break;
				case "web_banner":
					$fileDir = "images/web_banner/";
					break;
				case "slider-banner":
					$fileDir = "images/slider-banner/";
					break;
				case "brand":
					$fileDir = "images/brand/";
					break;
				case "home_cms":
					$fileDir = "images/home_cms/";
					break;
				case "category":
					$fileDir = "images/category/";
					break;
				default:
					return false;
					break;
			}
			return $fileDir;
		}

		function getValidatedPermalink($permalink){ // v2
			$permalink = trim($permalink, '()');
			$replace_keywords = array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ", "\r", "\n", 
				"---", "--", " - ", " -", "- ",
				"-#-", "-#", "#-", " # ", " #", "# ", "#",
				"-$-", "-$", "$-", " $ ", " $", "$ ", "$",
				"-%-", "-%", "%-", " % ", " %", "% ", "%",
				"-^-", "-^", "^-", " ^ ", " ^", "^ ", "^",
				"-*-", "-*", "*-", " * ", " *", "* ", "*",
				"-(-", "-(", "(-", " ( ", " (", "( ", "(",
				"-)-", "-)", ")-", " ) ", " )", ") ", ")",
				"-;-", "-;", ";-", " ; ", " ;", "; ", ";",
				"-'-", "-'", "'-", " ' ", " '", "' ", "'",
				'-"-', '-"', '"-', ' " ', ' "', '" ', '"',
				"-?-", "-?", "?-", " ? ", " ?", "? ", "?",
				"-+-", "-+", "+-", " + ", " +", "+ ", "+",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$escapedPermalink = str_replace($replace_keywords, '-', $permalink); 
			return strtolower($escapedPermalink);
		}

		function moneyFormate($amt){
			return number_format($amt,2);
		}

		/** * Function to get image url */
		function getImageUrl($imageFor, $fileName, $imageSuffix, $dirPrefix = ""){
			$fileDir = $this->getImageDir($imageFor, $dirPrefix);
			// var_dump($fileDir);
			if($fileDir === false){ // custom directory not found, error!
				
				$fileDir = "../images/"; // add / at end
				$defaultImageUrl = $fileDir."default.jpg";
				return BASE_URL."/".$defaultImageUrl;
			} else { // process custom directory
				$defaultImageUrl = $fileDir.$fileName;
				//var_dump($fileName);
				if(empty($fileName)){
					return BASE_URL."/".$defaultImageUrl;
				} else {
					$image_name = strtolower(pathinfo($fileName, PATHINFO_FILENAME));
					$image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
					if(!empty($imageSuffix)){
						$imageUrl = $fileDir.$image_name."_".$imageSuffix.".".$image_ext;
					} else {
						$imageUrl = $fileDir.$image_name.".".$image_ext;
					}
					//echo $imageUrl;
					if(file_exists($imageUrl)){
						return BASE_URL."/".$imageUrl;
					} else {
						return BASE_URL."/".$defaultImageUrl;
					}
				}
			}
		}

		/** * Function to delete/unlink image file */
		function unlinkImage($imageFor, $fileName, $imageSuffix, $dirPrefix = ""){
			$fileDir = $this->getImageDir($imageFor, $dirPrefix);
			if($fileDir === false){ // custom directory not found, error!
				return false;
			} else { // process custom directory
				$defaultImageUrl = $fileDir."default.jpg";

				$imagePath = $this->getImageUrl($imageFor, $fileName, $imageSuffix, $dirPrefix);
				if($imagePath != $defaultImageUrl){
					$status = unlink($imagePath);
					return $status;
				} else {
					return false;
				}
			}
		}

		function getAdminDetails(){
			$sql ="SELECT * FROM ".PREFIX."admin WHERE `id`='1'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		function generate_id($prefix, $randomNo, $tableName, $columnName){
			$chkprofile=$this->query("select ".$columnName." from ".PREFIX.$tableName." where ".$columnName." = '".$prefix.$randomNo."'");
			if($this->num_rows($chkprofile)>0) {
				$randomNo = str_shuffle('1234567890123456789012345678901234567890');
				$randomNo = substr($randomNo,0,8);
				$this->generate_id($prefix, $randomNo, $tableName, $columnName);
			} else {
				return  $prefix.$randomNo;
			}
		}

		/* === EXTRA FUNCTION END === */

		/* === CUSTOMER START === */
		function generateCustomerNo($prefix){
			$id = substr(str_shuffle("12345678901234567890"), 0, 8);
			$id = $prefix.'-'.$id;
			$query = "select * from ".PREFIX."customers where customer_no='".$id."'";
			$result = $this->query($query);
			if($result->num_rows>0){ // exists
				return $this->generateCustomerNo($prefix); // get another id
			} else {
				return $id;
			}
		}

		function getUniqueCustomerByEmail($customerEmail) {
			$customerEmail = $this->escape_string($this->strip_all($customerEmail));
			$query = "select * from ".PREFIX."customers where email='".$customerEmail."'";
			$sql = $this->query($query);
			if($sql->num_rows>0){
				return $this->fetch($sql);
			}
		}

		function getCustomerVerificationLinkByCustomerEmail($customerEmail) {
			$customerEmail = $this->escape_string($this->strip_all($customerEmail));
			$query = "select * from ".PREFIX."customers where email='".$customerEmail."'";
			return $sql = $this->query($query);
		}

		function isCustomerEmailUnique($email) {
			$email = $this->escape_string($this->strip_all($email));
			$query = "select * from ".PREFIX."customers where email='".$email."'";
			$result = $this->query($query);
			if($result->num_rows>0){ // at lease one email exists 
				return false;
			} else {
				return true;
			}
		}

		function isCustomerMobileUnique($mobile) {
			$mobile = $this->escape_string($this->strip_all($mobile));
			$query = "select * from ".PREFIX."customers where mobile='".$mobile."'";
			$result = $this->query($query);
			if($result->num_rows>0){ // at lease one email exists 
				return false;
			} else {
				return true;
			}
		}

		function setUserEmailAsVerified($verificationToken) {
			$verificationToken = $this->escape_string($this->strip_all($verificationToken));
			$query = "update ".PREFIX."customers set is_email_verified='1', active='1', user_verified='1' where verification_link='".$verificationToken."'";
			$this->query($query);
			return $this->affected_rows();
		}

		function getUniqueUserByEmailAndPhone($email){
			$email = $this->escape_string($this->strip_all($email));
			return $this->fetch($this->query("select * from ".PREFIX."customers where email='".$email."' or mobile='".$email."'"));
		}

		function setUserPasswordResetCode($email) {
			$email = $this->escape_string($this->strip_all($email));
			$userDetails = $this->getUniqueUserByEmailAndPhone($email);

			$passwordResetToken = md5(time()."Selvel".$email);

			$query = "update ".PREFIX."customers set password_reset_token='".$passwordResetToken."' where id='".$userDetails['id']."'";
			$this->query($query);

			$response = array();
			$response['updateSuccess'] = $this->affected_rows();
			$response['name'] = $userDetails['first_name'];
			$response['email'] = $userDetails['email'];
			$response['mobile'] = $userDetails['mobile'];
			$response['passwordResetToken'] = $passwordResetToken;
			return $response;
		}

		function resetCustomerPassword($passwordResetToken, $newpassword_set) {
			$passwordResetToken = $this->escape_string($this->strip_all($passwordResetToken));
			$newpassword_set = $this->escape_string($this->strip_all($newpassword_set));
			$newPasswordHash = password_hash($newpassword_set, PASSWORD_DEFAULT);

			$customerDetailsRS = $this->query("select * from ".PREFIX."customers where password_reset_token='".$passwordResetToken."'");

			if($customerDetailsRS->num_rows>0){
				$customerDetails = $this->fetch($customerDetailsRS);
				$query = "update ".PREFIX."customers set password='".$newPasswordHash."', password_reset_token='password_was_reset' where id='".$customerDetails['id']."'";
				$this->query($query);
				return $this->affected_rows();
			} else {
				return 0;
			}
		}

		function addUser($data, $user_verified = '0') {
			$first_name = $this->escape_string($this->strip_all($data['name']));
			$mobile = $this->escape_string($this->strip_all($data['mobile']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$password = $this->escape_string($this->strip_all($data['password']));
			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$verification_link = md5(time().'selvel'.$email.time());

			$customerNo = $this->generateCustomerNo('C');
			$created = date('Y-m-d H:i:s');

			$query = "insert into ".PREFIX."customers(customer_no, first_name, mobile, email, password, active, verification_link, user_verified, created) values ('".$customerNo."', '".$first_name."', '".$mobile."', '".$email."', '".$password."', '".$user_verified."', '".$verification_link."', '".$user_verified."', '".$created."')";
			
			$this->query($query);

			$customerId = $this->last_insert_id();

			$responseArr = array();
			$responseArr['id'] = $customerId;
			$responseArr['first_name'] = $first_name;
			$responseArr['email'] = $email;
			$responseArr['verification_link'] = $verification_link;

			return $responseArr;
		}

		function updateRegisteredUser($data, $customerId){
			$id = $this->escape_string($this->strip_all($customerId));
			$name = $this->escape_string($this->strip_all($data['name']));
			$mobile = $this->escape_string($this->strip_all($data['mobile']));

			if(!empty($data['password'])) {
				$password = $this->escape_string($this->strip_all($data['password']));
				$passwordHASH = password_hash($password, PASSWORD_DEFAULT);
				$this->query("update ".PREFIX."customers set password='".$passwordHASH."' where id='".$id."' ");
			}

			$this->query("update ".PREFIX."customers set mobile='".$mobile."', first_name='".$name."' where id='".$id."'");
			return true;
		}

		function getWishlistByUserId($userID){
			$userID = $this->escape_string($this->strip_all($userID));
			$sql = "SELECT * FROM ".PREFIX."customers_wishlist WHERE `customer_id`='".$userID."' order by id DESC";

			return  $this->query($sql);
		}

		function getPrimaryAddress($userId){
			$userId = $this->escape_string($this->strip_all($userId));
			$sql = "SELECT * FROM ".PREFIX."customers_address WHERE `customer_id`='".$userId."' and `setDefault`='1'";
			return $this->query($sql);
		}

		function getAddressById($id){
			$id = $this->escape_string($this->strip_all($id));
			$sql = "SELECT * FROM ".PREFIX."customers_address WHERE `id`='".$id."'";
			return $this->query($sql);
		}

		function getAddressByAddressid($addressID,$logeduser){
			$addressID = $this->escape_string($this->strip_all($addressID));
			$userId = $this->escape_string($this->strip_all($logeduser['id']));
			$sql = "SELECT * FROM ".PREFIX."customers_address WHERE `id`='".$addressID."' and customer_id='".$userId."'";
			return $this->query($sql);
		}

		function getUniqueCustomerAddressById($id, $customerId){
			$id = $this->escape_string($this->strip_all($id));
			$customerId = $this->escape_string($this->strip_all($customerId));
			$query = "select * from ".PREFIX."customers_address where id='".$id."' and customer_id='".$customerId."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addCustomerAddress($data, $customerId){
			$customerId = $this->escape_string($this->strip_all($customerId));
			$customer_fname = $this->escape_string($this->strip_all($data['customer_fname']));
			$customer_contact = $this->escape_string($this->strip_all($data['customer_contact']));
			$customer_email = $this->escape_string($this->strip_all($data['customer_email']));
			$state = $this->escape_string($this->strip_all($data['state']));
			$city = $this->escape_string($this->strip_all($data['city']));
			if(isset($data['address1'])){
				$address1 = $this->escape_string($this->strip_all($data['address1']));
			} else {
				$address1 = '';
			}
			if(isset($data['address2'])){
				$address2 = $this->escape_string($this->strip_all($data['address2']));
			} else {
				$address2 = '';
			}
			if(isset($data['pincode'])){
				$pincode = $this->escape_string($this->strip_all($data['pincode']));
			} else {
				$pincode = 0;
			}
			$query = "INSERT INTO ".PREFIX."customers_address(`customer_id`, `address1`, `address2`, `state`, `city`, `pincode`, `customer_fname`, `customer_contact`, `customer_email`) VALUES ('".$customerId."','".$address1."','".$address2."','".$state."','".$city."','".$pincode."','".$customer_fname."','".$customer_contact."','".$customer_email."')";
			$this->query($query);
			return $this->last_insert_id();
		}

		function updateCustomerAddress($data, $userId){
			$id = $this->escape_string($this->strip_all($data['id']));
			$first_name = $this->escape_string($this->strip_all($data['customer_fname']));
			$customer_email = $this->escape_string($this->strip_all($data['customer_email']));
			$contact = $this->escape_string($this->strip_all($data['customer_contact']));
			if(isset($data['address1'])){
				$address1 = $this->escape_string($this->strip_all($data['address1']));
			} else {
				$address1 = '';
			}
			if(isset($data['address2'])){
				$address2 = $this->escape_string($this->strip_all($data['address2']));
			} else {
				$address2 = '';
			}
		
			$state = $this->escape_string($this->strip_all($data['state']));
			$city = $this->escape_string($this->strip_all($data['city']));
			$pincode = $this->escape_string($this->strip_all($data['pincode']));
			
			$query = "UPDATE ".PREFIX."customers_address SET `address1`='".$address1."',`address2`='".$address2."',`state`='".$state."',`city`='".$city."',`pincode`='".$pincode."',`customer_fname`='".$first_name."',`customer_contact`='".$contact."',`customer_email`='".$customer_email ."'  WHERE id='".$id."'";
			//echo $query; exit;
			$this->query($query);
			// return $this->last_insert_id();
		}

		function setAsDefaultAddress($request,$userlogedDetails){
			$setDetaultAddress = $this->escape_string($this->strip_all($request['setDetaultAddress']));
			$id = $this->escape_string($this->strip_all($request['id']));
			$userId = $this->escape_string($this->strip_all($userlogedDetails['id']));

			$sql = "UPDATE ".PREFIX."customers_address SET setDefault='0' WHERE customer_id='".$userId."'";
			$this->query($sql);
			
			$_SESSION[SITE_NAME]['BILLADDRESS']['Billing'] = $id;
			$sql = "UPDATE ".PREFIX."customers_address SET setDefault='1' WHERE id='".$id."' and customer_id='".$userId."'";
			return $this->query($sql);
		}

		function getAddressByuserId($userid){
			$userid = $this->escape_string($this->strip_all($userid));
			$sql ="SELECT * FROM ".PREFIX."customers_address WHERE `customer_id`='".$userid."'";
			return $this->query($sql);
		}

		function getListOfCities(){
			$query = "select distinct districtname from ".PREFIX."pincode order by districtname asc";
			return $this->query($query);
		}

		function getListOfStates(){
			$query = "select name as statename from ".PREFIX."states order by name asc";
			return $this->query($query);
		}

		function getDisplayAddress($oneAddress, $eol){
			$email='';
			$customer_contact='';
			if(!empty($oneAddress['email'])){
				$email = "Email / Contact : ".$oneAddress['email'].$eol;	
			}
			if(!empty($oneAddress['customer_contact'])){
				$customer_contact = "Contact : ".$oneAddress['customer_contact'].$eol;	
			}
			
			$displayAddress = $oneAddress['address1'].','.$eol;
			if(!empty($oneAddress['address2'])){
				$displayAddress .= $oneAddress['address2'].','.$eol;
			}
			$displayAddress .= $oneAddress['city'].' - '.$oneAddress['pincode'].$eol;
			$displayAddress .= ucfirst($oneAddress['state']).$eol;
			$displayAddress .= $email;
			$displayAddress .= $customer_contact;
			return $displayAddress;
		}

		/* === CUSTOMER ENDS === */

		/* === CATEGORY STARTS === */
		function getMainCategories() {
			$query = "select * from ".PREFIX."category_master where active=1 order by display_order ASC";
			return $this->query($query);
		}

		function getSubCategoryByCategoryId($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."sub_category_master where category_id='".$category_id."' and active=1 order by id ASC";
			return $this->query($query);
		}

		function getSubCategoryLevel2ByCategoryId($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."subsubcategory where category_id='".$category_id."' and active=1 order by id DESC";
			return $this->query($query);
		}

		function getCategorybyPermlink($permalink){
			$permalink = $this->escape_string($this->strip_all($permalink));
			$sql = "SELECT * FROM ".PREFIX."category_master WHERE `active`='1' and `permalink`='".$permalink."'";
			//echo $sql;
			$result = $this->query($sql);
			return $this->fetch($result);
		}


		function getSuBCatByPermalink($permalink, $category_id){
			$permalink = $this->escape_string($this->strip_all($permalink));
			$category_id = $this->escape_string($this->strip_all($category_id));

			$sql = "SELECT * FROM ".PREFIX."sub_category_master WHERE `active`='1' and `permalink`='".$permalink."' and category_id='".$category_id."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		function getSubSubCatByPermalink($permalink, $category_id){
			$permalink = $this->escape_string($this->strip_all($permalink));
			$category_id = $this->escape_string($this->strip_all($category_id));

			$sql = "SELECT * FROM ".PREFIX."subsubcategory WHERE `active`='1' and `permalink`='".$permalink."' and category_id='".$category_id."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		function getAttributeCategory($catId =''){
			$whereClause = '';
			if(!empty($catId)){
				$catId = $this->escape_string($this->strip_all($catId));
				$whereClause = " and id in(".$catId.")";
			}
			$sql = "SELECT * FROM ".PREFIX."category_master where active='1' $whereClause";
			return $result = $this->query($sql);
		}

		function getAttributeByCategoryId($carID){
			$carID = $this->escape_string($this->strip_all($carID));
			$sql = "SELECT * FROM ".PREFIX."attribute_master WHERE active='1' and `id` in( SELECT attribute_id FROM ".PREFIX."category_attribute_list WHERE `category_id`='".$carID."')";
			return $this->query($sql);
		}

		function getAttributeFeaturebyAttrId($attid){
			$attid = $this->escape_string($this->strip_all($attid));
			$sql ="SELECT * FROM ".PREFIX."attribute_features WHERE `attribute_id`='".$attid."'";
			return $this->query($sql);
		}

		/* === CATEGORY ENDS === */

		/* === PRODUCT STARTS === */
		function getBestSellerProduct(){
			$sql = "SELECT * FROM ".PREFIX."product_master where active='1' and best_seller='1' order by id DESC LIMIT 0,8";
			return $this->query($sql);
		}

		function getLatestProduct(){
			$sql = "SELECT * FROM ".PREFIX."product_master where active='1' order by id DESC LIMIT 0,8";
			return $this->query($sql);
		}

		function getUniqueProductSizeById($id) {
			$id = $this->escape_string($this->strip_all($id));

			$sql ="SELECT * FROM ".PREFIX."product_sizes WHERE `id`='".$id."'";
			$productData = $this->query($sql);
			return  $this->fetch($productData);
		}

		function getProductDetailPageURL($product_id, $productSizeId=0){
			$product_id=$this->escape_string($this->strip_all($product_id));

			$productDetails = $this->getUniqueProductById($product_id);
			$product_name = $productDetails['product_name'];
			$namePerma = $this->getValidatedPermalink($product_name);
			$productCodePerma = $this->getValidatedPermalink($productDetails['product_code']);

			$productSize = $this->getUniqueProductSizeById($productSizeId);
			
			//return BASE_URL.'/'.$namePerma.'/'.$productCodePerma.'/'.$productDetails['permalink'];
			return $namePerma.'/'.$productCodePerma.'/'.$productSize['permalink'];
		}

		function getUniqueProductById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_master where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		
		function getUniqueProductBydate($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_master where id = '".$id."' order by id DESC ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function getUniqueProductByname($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_master where id = '".$id."' order by product_name DESC ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		

		function getFilterProductlist($data) {
			$catId = '';
			$subCatid = '';
			$subSubCatId = '';
			$sortBy = '';
			$whereClasue = '';
			//echo $data['sub_category_permalink'];
			//echo $data['cat_permalink'];

			if(isset($data['cat_permalink']) && !empty($data['cat_permalink'])){
				//echo "cat";
				$categoryDetails  = $this->getCategorybyPermlink($data['cat_permalink']);
				$catId   = $categoryDetails['id'];
				$whereClasue .= " and p.id in (SELECT product_id FROM ".PREFIX."product_category_mapping WHERE `category_id` in ($catId))";
			}

			//$subCatid =0;
			if(isset($data['sub_category_permalink']) && !empty($data['sub_category_permalink'])){
				//echo "subcat";
				$subDetails  = $this->getSuBCatByPermalink($data['sub_category_permalink'], $catId);
				$subCatid   = $subDetails['id'];
				$whereClasue .= " and p.id in (SELECT product_id FROM ".PREFIX."product_subcategory_mapping WHERE `subscategory_id` in ($subCatid))";
			}

			if(isset($data['subSub_category_permalink']) && !empty($data['subSub_category_permalink'])){
				$subSubDetails  = $this->getSubSubCatByPermalink($data['subSub_category_permalink'],$subCatid);
				$subSubCatId   = $subSubDetails['id'];
				$whereClasue .= " and p.id in (SELECT product_id FROM ".PREFIX."product_subsubcategory_mapping WHERE `subsubcategory_id` in ($subSubCatId))";
			}
			
			if(isset($data['attrId']) && !empty($data['attrId'])){
				$attrId = implode(",",$data['attrId']);
				$whereClasue .=" and p.id in (select product_id from ".PREFIX."product_attributes where attribute_feature_id in(".$attrId."))";
			}

			$variationFilter = 'false';
			$priceCond = array();
			if(isset($data['priceArr']) && !empty($data['priceArr'])) {
				foreach($data['priceArr'] as $oneData) {
					$oneData = $this->escape_string($this->strip_all($oneData));
					$priceExp = explode('-', $oneData);
					$minPrice = $priceExp[0];
					$maxPrice = $priceExp[1];

					//$priceCond[] ="(customer_price between ".$minPrice." and ".$maxPrice.") and customer_discount_price=0))";
					
					// $priceCond[] =" id in(SELECT product_id FROM slv_product_sizes where customer_discount_price between ".$minPrice." and ".$maxPrice.")";
					// $priceCond[] =" p.id in(SELECT product_id FROM ".PREFIX."product_sizes where (case when customer_discount_price !=0 then customer_discount_price between ".$minPrice." and ".$maxPrice." else customer_price between ".$minPrice." and ".$maxPrice." end))";

					$priceCond[] =" (case when ps.customer_discount_price !=0 then ps.customer_discount_price between ".$minPrice." and ".$maxPrice." else ps.customer_price between ".$minPrice." and ".$maxPrice." end)";

					$variationFilter = 'true';
				}
				if(count($priceCond)>0) {
					$whereClasue .= " and (".implode(' OR ', $priceCond).")";
				}
			}
			
			$sizeCond = array();
			if(isset($data['sizeArr']) && !empty($data['sizeArr'])) {
				foreach($data['sizeArr'] as $twoData) {
					/* $twoData = $this->escape_string($this->strip_all($twoData));
					$sizeExp = explode('-', $twoData);
					$minSize = $sizeExp[0];
					$maxSize = $sizeExp[1];

					$sizeCond[] =" id in (SELECT product_id FROM ".PREFIX."product_sizes where size BETWEEN '".$minSize."' and '".$maxSize."')"; */
					$twoData = $this->escape_string($this->strip_all($twoData));

					// $sizeCond[] =" p.id IN (SELECT product_id FROM ".PREFIX."product_sizes where size='".$twoData."')";
					$sizeCond[] =" ps.size='".$twoData."'";

					$variationFilter = 'true';
				}
				if(count($sizeCond)>0) {
					$whereClasue .= " and (".implode(' OR ', $sizeCond).")";
				}
			}

			$colorCond = array();
			if(isset($data['colorArr']) && !empty($data['colorArr'])) {
				foreach($data['colorArr'] as $oneData) {
					$oneData = $this->escape_string($this->strip_all($oneData));

					// $colorCond[] =" p.id IN (SELECT product_id FROM ".PREFIX."product_sizes where productcolor='".$oneData."')";
					$colorCond[] =" ps.productcolor='".$oneData."'";

					$variationFilter = 'true';
				}
				if(count($colorCond)>0) {
					$whereClasue .= " and (".implode(' OR ', $colorCond).")";
				}
			}

			/* if($variationFilter=='false') {
				$whereClasue .= " and p.id IN (SELECT DISTINCT(product_id) FROM ".PREFIX."product_sizes)";
			} */

			/*$attrCond = array();
			if(isset($data['attrId']) && !empty($data['attrId'])) {
				foreach($data['attrId'] as $threeData) {
					$threeData = $this->escape_string($this->strip_all($threeData));
					//$sizeExp = explode('-', $twoData);
					//$minPrice = $priceExp[0];
					//$maxPrice = $priceExp[1];

					
					//$priceCond[] ="(customer_price between ".$minPrice." and ".$maxPrice.") and customer_discount_price=0))";
					
					$attrCond[] =" id in(SELECT category_id FROM slv_category_attribute_list where attribute_id='$threeData')";
				}
				if(count($attrCond)>0) {
					$whereClasue .= " and (".implode(' OR ', $attrCond).")";
				}
			}*/

			if(isset($data['bestseller']) and $data['bestseller']==1) {
				$whereClasue .=" and p.best_seller=1";
			}

			if(isset($data['sortBy'])){
				$sortBy = $this->escape_string($this->strip_all($data['sortBy']));
			}

			if(isset($data['product_id']) && !empty($data['product_id'])){
				$whereClasue .= " and ( p.product_name like '%".$data['product_id']."%' or p.product_code like '%".$data['product_id']."%' or p.description like '%".$data['product_id']."%') ";
			}

			$orderBy = " order by p.id DESC";
			/* if(isset($sortBy) && !empty($sortBy) && $sortBy=="higher") {
				//$orderBy = " order by customer_price DESC";
				$orderBy = " order by (SELECT product_id FROM slv_product_sizes order by customer_discount_price DESC)";
				
			} else if(isset($sortBy) && !empty($sortBy) && $sortBy=="lower") {
				$orderBy = " order by customer_price";
			} else if(isset($sortBy) && !empty($sortBy) && $sortBy=="popular") {
				$orderBy = " order by p.avg_rating DESC";
			} else if(isset($sortBy) && !empty($sortBy) && $sortBy=="newarri") {
				$orderBy = " order by p.id DESC";
			}
			else if(isset($sortBy) && !empty($sortBy) && $sortBy=="name") {
				$orderBy = " order by p.product_name ASC";
			} */

			if(isset($data['limit']) && !empty($data['limit'])) {
				$limit = $data['limit'];
			}else {
				$limit = 30;
			}

			if($variationFilter=='false') {
				$sql = "SELECT p.* FROM ".PREFIX."product_master p WHERE p.active='1' ".$whereClasue.$orderBy;
			} else {
				$sql = "SELECT p.*, ps.id as productSizeId FROM ".PREFIX."product_master p, ".PREFIX."product_sizes ps WHERE p.active='1' and p.id=ps.product_id ".$whereClasue.$orderBy;
			}
			// echo $sql;

			//exit();
			return $this->query($sql);
		}

		function getProductByproductPermalink($productPermalink) {
			$productPermalink = $this->escape_string($this->strip_all($productPermalink));
			$sql ="SELECT * FROM ".PREFIX."product_master WHERE `permalink`='".$productPermalink."'";
			$productData = $this->query($sql);
			return  $this->fetch($productData);
		}

		function getProductBySizePermalink($sizePermalink) {
			$sizePermalink = $this->escape_string($this->strip_all($sizePermalink));
			$sql ="SELECT * FROM ".PREFIX."product_sizes WHERE `permalink`='".$sizePermalink."'";
			$productData = $this->query($sql);
			return  $this->fetch($productData);
		}

		function getRelatedProduct($productId) {
			$productId = $this->escape_string($this->strip_all($productId));
			$sql = "SELECT * FROM ".PREFIX."products_related_products WHERE `product_id`='".$productId."'";
			return $this->query($sql);
		}

		function getProductReviewPercentagebyProductid($productId) {

			$productId = $this->escape_string($this->strip_all($productId));
			$sql = "SELECT count(id) as starCount, rating FROM ".PREFIX."reviews WHERE `product_id`='".$productId."' and active='1' group by rating";
			/*echo $sql;*/ 
			return $this->query($sql);
		}

		function getRatingByProductId($productId) {
			$productId = $this->escape_string($this->strip_all($productId));
			$sql = "SELECT * FROM ".PREFIX."reviews WHERE `product_id`='".$productId."' and active='1'";
			return $this->query($sql);
		}

		function addReviews($data, $userId, $productId) {
			$customer_id = $this->escape_string($this->strip_all($userId));
			$productId = $this->escape_string($this->strip_all($data['product_id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$review = $this->escape_string($this->strip_all($data['review']));
			if(isset($data['rating']) && !empty($data['rating'])){
				$rating = $this->escape_string($this->strip_all($data['rating']));
			}else{
				$rating = "0";
			}
			$created = date('Y-m-d H:i:s');

			$active = 0;
			$query = "insert into ".PREFIX."reviews(customer_id, product_id, name, email, review, rating, active, created) values ('".$customer_id."', '".$productId."', '".$name."', '".$email."', '".$review."', '".$rating."', '".$active."', '".$created."')";
				$this->query($query);
			
			return $this->last_insert_id();	
		}

		/* === PRODUCT ENDS === */

		/* === CART STARTS === */
		function getCartAmountAndQuantity($cartObj, $loggedInUserDetailsArr){
			$cartArr = $cartObj->getCart();
			if($cartArr){
				$subTotal = 0;
				$finalTotal = 0;
				$tax = 0;
				$taxAdd = 0;
				$totalPrice = 0;
				$totalWeight = 0;

				foreach($cartArr as $oneProduct){
					$cartProductDetail = $this->getUniqueProductById($oneProduct['productId']);
					$getProductsizeDetails = $this->fetch($this->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."'"));

					$price = $getProductsizeDetails['customer_price'];
					if(!empty($getProductsizeDetails['customer_discount_price'])) {
						$price = $getProductsizeDetails['customer_discount_price'];
					}
					$price = $price * $oneProduct['quantity'];
					$tax = $cartProductDetail['tax'];
					$taxAmount = $price * ($tax/100);
					$price = $price + $taxAmount;
					$subTotal += $price;
					$totalWeight = $totalWeight + $getProductsizeDetails['weight'];
				}

				// CHECK IF DISCOUNT COUPON IS VALID FOR THIS USER
				if(isset($loggedInUserDetailsArr) && !empty($loggedInUserDetailsArr)){ // user is logged in, apply discount
					$subTotalArr = $this->getNewSubtotalAfterCouponCode($subTotal, $cartObj, $loggedInUserDetailsArr);
					$couponDiscount = $subTotalArr['couponDiscount'];
					$subTotal = $subTotalArr['subTotal'];
				} else {
					$couponDiscount = 0;
				}
				// CHECK IF DISCOUNT COUPON IS VALID FOR THIS USER

				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL
				// $shippingCharges = $this->getShippingCharge($subTotal);
				$d_pin = $_SESSION[SITE_NAME]['BILLADDRESS']['shippingAddress']['pincode'];
				$shippingURL = "https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?ss=Delivered&pt=Pre-paid&cgm=".$totalWeight."&cl=SELVEL 0064514&md=S&o_pin=400063&d_pin=".$d_pin;

				$headers = array();
				$headers[] = 'Authorization: Token ecb8abc65cb0076e95617e2c67c21c7656fd8a9f';

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => $shippingURL,
					CURLOPT_USERAGENT => '',
				));
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				// Send the request & save response to $resp
				$resp = curl_exec($curl); // Getting jSON result string
				$responseArr = json_decode($resp, true);
				$shippingCharges = $responseArr[0]['total_amount'];

				$finalTotal = $subTotal + $shippingCharges;
				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL

				return array(
					"items" => count($cartArr),
					"couponDiscount" => $couponDiscount,
					"subTotalAfterCouponDiscount" => $subTotal,
					"shippingCharges" => $shippingCharges,
					"finalTotal" => $finalTotal
				);
			} else { 
				return array(
					"items" => 0,
					"couponDiscount" => 0,
					"subTotalAfterCouponDiscount" => 0,
					"shippingCharges" => 0,
					"finalTotal" => 0
				);
			}
		}

		function getShippingCharge($total) {
			$result = $this->fetch($this->query("select * from ".PREFIX."shipping_charge"));
			if($total <= $result['free_shipping_above']){
				//echo $total;
				
				return $result['shipping_charges'];
			} else {
				return 0;
			}
		}

		function getCartTotal(){
			$total = 0;

			if(isset($_SESSION[SITE_NAME]['cart'])) {
				foreach($_SESSION[SITE_NAME]['cart'] as $oneProduct) {
					$productPrice = $this->getUniqueProductById($oneProduct['productId']);
					$getProductsizeDetails = $this->fetch($this->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."'"));
					if(!empty($getProductsizeDetails['customer_discount_price'])) {
						$discountedPrice = $getProductsizeDetails['customer_discount_price'];
						$price = $discountedPrice * $oneProduct['quantity'];
						unset($discountedPrice);
					} else {
						$price = $getProductsizeDetails['customer_price'] * $oneProduct['quantity'];
					}
					$total += $price;
				}
			}
			return $total;
		}

		/* === CART ENDS === */

		/* === ORDER STARTS === */
		function processTransaction($cartObj, $loggedInUserDetailsArr, $data){ /* generate transaction id  */

			if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['shipping']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'])){
				$getAddress = $this->getAddressByAddressid($_SESSION[SITE_NAME]['BILLADDRESS']['shipping'],$loggedInUserDetailsArr);
				if($this->num_rows($getAddress)>0){
					$addressShipDetails = $this->fetch($getAddress);
				}							
			}

			$shippingFName = $this->escape_string($this->strip_all($addressShipDetails["customer_fname"]));
			$shippingLName = "";
			$shipping_email = $this->escape_string($this->strip_all($addressShipDetails["customer_email"]));
			$shipping_contact = $this->escape_string($this->strip_all($addressShipDetails["customer_contact"]));
			$shippingState = $this->escape_string($this->strip_all($addressShipDetails["state"]));
			$shippingCity = $this->escape_string($this->strip_all($addressShipDetails["city"]));
			$shippingAddress1 = $this->escape_string($this->strip_all($addressShipDetails["address1"]));
			$shippingAddress2 = $this->escape_string($this->strip_all($addressShipDetails["address2"]));
			$shippingCompany = "";
			$shippingPincode = $this->escape_string($this->strip_all($addressShipDetails["pincode"]));
			
			if(isset($_SESSION[SITE_NAME]['BILLADDRESS']['Billing']) && !empty($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'])){ 
				$getAddress = $this->getAddressByAddressid($_SESSION[SITE_NAME]['BILLADDRESS']['Billing'],$loggedInUserDetailsArr);
				if($this->num_rows($getAddress)>0){
					$addressBillDetails = $this->fetch($getAddress);
				}
			}

			$billFName 	= $this->escape_string($this->strip_all($addressBillDetails["customer_fname"]));
			$billLName 	= "";
			$billState 	= $this->escape_string($this->strip_all($addressBillDetails["state"]));
			$billContact 	= $this->escape_string($this->strip_all($addressBillDetails["customer_contact"]));
			$billCity 	= $this->escape_string($this->strip_all($addressBillDetails["city"]));
			$billAddress1 = $this->escape_string($this->strip_all($addressBillDetails["address1"]));
			$billAddress2 = $this->escape_string($this->strip_all($addressBillDetails["address2"]));
			$billCompany = "";
			$billPincode = $this->escape_string($this->strip_all($addressBillDetails["pincode"]));
			
			$customer_id = $this->escape_string($this->strip_all($loggedInUserDetailsArr['id']));
			$payment_mode = $this->escape_string($this->strip_all($data['paymentMode']));

			//$txn_id = "HM-".date("YmdHis", time());
			//permaCode
				$prefix	= 'selvel-';
				$permalink 	= str_shuffle('1234567890');
				$permalink 	= substr($permalink,0,8);
				$txn_id 	= $this->generate_id($prefix, $permalink, 'order', 'txn_id');
			//permaCode::end

			$payment_status = 'Payment Pending';
			$order_status = 'In Process';
			$created = date('Y-m-d H:i:s');

			$query = "insert into ".PREFIX."order(
						txn_id, payment_mode, customer_id, billing_email, 
						billing_fname, billing_lname, billing_contact_no, billing_address_line1, billing_address_line2, billing_city, billing_pincode, billing_state,
						shipping_fname, shipping_lname, shipping_email, shipping_address_line1, shipping_address_line2, shipping_city, shipping_pincode, shipping_state,
						payment_status, created, order_status) 
					 values (
						'".$txn_id."', '".$payment_mode."', '".$loggedInUserDetailsArr['id']."', '".$loggedInUserDetailsArr['email']."', 
						'".$billFName."', '".$billLName."', '".$billContact."', '".$billAddress1."', '".$billAddress2."', '".$billCity."', '".$billPincode."', '".$billState."',
						'".$shippingFName."', '".$shippingLName."', '".$shipping_email."', '".$shippingAddress1."', '".$shippingAddress2."', '".$shippingCity."', '".$shippingPincode."', '".$shippingState."',
						'".$payment_status."', '".$created."', '".$order_status."')";

			$this->query($query);

			$orderId = $this->last_insert_id();

			$cartArr = $cartObj->getCart();
			$_SESSION[SITE_NAME]['outOfStock'] = array();
			$processedProduct = 0;
			if($cartArr){
				foreach($cartArr as $oneProduct){
					$cartProductDetail = $this->getUniqueProductById($oneProduct['productId']);
					$getProductsizeDetails = $this->fetch($this->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."'"));
					//print_r($getProductsizeDetails);
					$size = $oneProduct['size'];
					$color = $oneProduct['color'];
					$tax = $cartProductDetail['tax'];
					$taxAdd = $tax/100;
					$taxAdd = $taxAdd + 1;
					$totalPrice = round($getProductsizeDetails['customer_price']);
					$totalDiscountPrice = round($getProductsizeDetails['customer_discount_price']);

					$quantity = $this->escape_string($this->strip_all($oneProduct['quantity']));

					if($getProductsizeDetails['available_qty'] >= $quantity) {
						$query = "insert into ".PREFIX."order_details(size,color,order_id, product_id, customer_id, quantity, customer_price, customer_discount_price, gst_rate) values ('".$size."','".$color."','".$orderId."', '".$cartProductDetail['id']."', '".$loggedInUserDetailsArr['id']."', '".$quantity."', '".$totalPrice."', '".$totalDiscountPrice."', '".$cartProductDetail['tax']."')";
						// echo $query;die();
						$this->query($query);
						$processedProduct = $processedProduct+1;
					} else {
						$productArr = array(
							"productId" => $oneProduct['productId'],
						);
						$_SESSION[SITE_NAME]['outOfStock'][] = $productArr;
						$removeCart = $cartObj->removeProductFromCart($oneProduct['productId']);
					}
				}
				if($processedProduct==0) {
					$this->query("delete from ".PREFIX."order where id='".$orderId."'");
				}
			}

			$amtArr = $this->getCartAmountAndQuantity($cartObj, $loggedInUserDetailsArr);
			$shippingCharges = $amtArr['shippingCharges'];
			$payment_status = 'Payment Pending';

			if($processedProduct>0) {
				$this->query("update ".PREFIX."order set shipping_charges='".$shippingCharges."' where id='".$orderId."'");
			}

			return array(
				"orderId" => $orderId, 
				"txnId" => $txn_id, 
				"cartPriceDetails" => $amtArr, 
				"status" => "success", 
				"processedProduct" => $processedProduct
			);
		}

		function completePurchaseOfProductOrder($loggedInUserDetailsArr, $txnId) {
			$loggedInUserId = $loggedInUserDetailsArr['id'];
			$query = "select * from ".PREFIX."order where txn_id='".$txnId."' and customer_id='".$loggedInUserId."'";
			$orderRS = $this->query($query);
			if($orderRS->num_rows>0) { // order with txn_id for that customer found
				$orderDetails = $this->fetch($orderRS);

				if($orderDetails['payment_mode']=='Online') {
					// update payment status of order
					$query = "update ".PREFIX."order set payment_status='Payment Complete', order_status='In Process' where id='".$orderDetails['id']."'";
					$this->query($query);
				} else if($orderDetails['payment_mode']=='COD') {
					$query = "update ".PREFIX."order set payment_status='Payment Pending', order_status='In Process' where id='".$orderDetails['id']."'";
					$this->query($query);
				}

				$cartObj = new Cart();

				// UPDATE PRODUCT AVAILABLE QUANTITY
				$cartArr = $cartObj->getCart();
				$productCancelled = 0;
				$processedProduct = 0;
				$_SESSION[SITE_NAME]['outOfStock'] = array();
				if($cartArr){
					foreach($cartArr as $oneProduct){
						$cartProductDetail = $this->getUniqueProductById($oneProduct['productId']);
						$quantity = $this->escape_string($this->strip_all($oneProduct['quantity']));
						$getProductsizeDetails = $this->fetch($this->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."'"));

						if($getProductsizeDetails['available_qty'] >= $quantity) {
							$newQuantity = $getProductsizeDetails['available_qty'] - $quantity;

							$query = "update ".PREFIX."product_sizes set available_qty='".$newQuantity."' where product_id='".$oneProduct['productId']."' AND size='".$oneProduct['size']."'";
							$this->query($query);

							$processedProduct = $processedProduct+1;
						} else {
							$previousOrderRS = $this->query("select * from ".PREFIX."order where id IN (select order_id from ".PREFIX."order_details where product_id='".$oneProduct['productId']."' and quantity='".$quantity."') and payment_mode='COD' and order_status='In Process' order by created DESC LIMIT 1,1");

							if($this->num_rows($previousOrderRS)>0) {
								$prevOrder = $this->fetch($previousOrderRS);
								$prevOrderId = $this->escape_string($prevOrder['id']);

								$this->query("delete from ".PREFIX."order_details where product_id='".$oneProduct['productId']."' and quantity='".$quantity."' and order_id='".$prevOrderId."'");

								$customerDetails = $this->getUniqueUserById($prevOrder['customer_id']);

								// EMAIL CODE FOR ORDER CANCELLED
								
								$emailSubject = SITE_NAME." | ORDER CANCELLED - ".$prevOrder['txn_id'];
								
								include_once("include/emailers/order-cancel-email.inc.php"); // $emailMsg
								include_once("include/classes/Email.class.php");
								$emailObj = new Email();
								$emailObj->setEmailBody($emailMsg);
								$emailObj->setSubject($emailSubject);

								$emailObj->setAddress($customerDetails['email']); // send email to registered email
								$emailObj->sendEmail(); // UNCOMMENT
								// EMAIL CODE FOR ORDER CANCELLED

								$checkOrderDetails = $this->query("select COUNT(*) from ".PREFIX."order_details where order_id='".$prevOrderId."'");
								if($this->num_rows($checkOrderDetails)==0) {
									$this->query("delete from ".PREFIX."order where id='".$prevOrderId."'");
								}
							} else {
								$productArr = array(
									"productId" => $oneProduct['productId'],
								);
								$_SESSION[SITE_NAME]['outOfStock'][] = $productArr;
								$productCancelled = $productCancelled+1;
								$removeCart = $cartObj->removeProductFromCart($oneProduct['productId']);
							}
						}
					}
					if($processedProduct==0) {
						$this->query("delete from ".PREFIX."order where id='".$orderDetails['id']."'");
						header("location: payment-error.php?OUTOFSTOCK&payment");
						exit;
					}
					$amtArr = $this->getCartAmountAndQuantity($cartObj, $loggedInUserDetailsArr);

					/* === SHIPPING API === */
					$postShippingData = array();
					$pickupLocation = array();
					$shipment = array();
					$shipmentArr = array();

					$pickupLocation['name'] = "SELVEL 0064514";
					$postShippingData['pickup_location'] = $pickupLocation;

					$shipment['add'] = $orderDetails['shipping_address_line1'].' '.$orderDetails['shipping_address_line2'];
					$shipment['pin'] = $orderDetails['shipping_pincode'];
					$shipment['order'] = $orderDetails['txn_id'];
					// $shipment['phone'] = $loggedInUserDetailsArr['mobile'];
					$shipment['phone'] = $orderDetails['billing_contact_no'];
					$shipment['name'] = $loggedInUserDetailsArr['first_name'];
					$shipment['payment_mode'] = $orderDetails['payment_mode']=='Online' ? "Prepaid" : "COD";

					if($orderDetails['payment_mode']=='COD') {
						$shipment['cod_amount'] = $amtArr['finalTotal'];
					}

					$shipmentArr[] = $shipment;

					$postShippingData['shipments'] = $shipmentArr;

					$postJsonData = json_encode($postShippingData);

					$shippingCreateURL = DELHIVERY_BASE_URL."/api/cmu/create.json";

					$headers = array();
					$headers[] = 'Authorization: Token '.DELHIVERY_API_KEY;

					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => $shippingCreateURL,
						CURLOPT_USERAGENT => '',
						CURLOPT_POST => TRUE,
						CURLOPT_POSTFIELDS => "format=json&data=".$postJsonData
					));
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

					// Send the request & save response to $resp
					$shippingResponse = curl_exec($curl); // Getting jSON result string
					curl_close($curl);

					$shippingResponseArr = json_decode($shippingResponse,true);
					// echo '<pre>';
					// print_r($postJsonData);
					// print_r($shippingResponseArr); exit;
					$err = curl_error($curl);
					// exit;
					$this->query("UPDATE ".PREFIX."order SET delhivery_request='".$this->escape_string($postJsonData)."', `delhivery_response`='".$this->escape_string($shippingResponse)."' WHERE `txn_id`='".$orderDetails['txn_id']."'");

					if($shippingResponseArr){
						if(isset($shippingResponseArr['packages'])){
							foreach($shippingResponseArr['packages'] as $package){
								if(isset($package['status']) && $package['status']=="Success"){
									//echo $package['waybill'];
									$update = "UPDATE ".PREFIX."order SET `waybill`='".$package['waybill']."' WHERE `txn_id`='".$orderDetails['txn_id']."'";
									$this->query($update);
								}
							}
						}
					}

					/* === SHIPPING API === */

				}
				// UPDATE PRODUCT AVAILABLE QUANTITY

				// CHECK IF COUPON CODE USED AND DISCOUNT COUPON IS VALID FOR THIS USER
				if(isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])) {
					foreach($_SESSION[SITE_NAME]['couponCode'] as $oneCoupon) {
						$couponCode = $this->escape_string($this->strip_all($oneCoupon['couponCode']));

						$curCouponCode=$couponCode;

						$couponVerificationResult = $this->verifyCouponCode($couponCode, $loggedInUserId, $cartObj, $orderDetails['id']);

						if($couponVerificationResult['couponStatus']=="success") {
							$couponDetails = $couponVerificationResult['discountCouponDetails'];
							//$couponDiscountAmount = $couponVerificationResult['couponDiscount'];

							$query = "INSERT INTO `".PREFIX."order_discount_coupons` (`order_id`, `discount_coupon_id`, `customer_id`, `coupon_code`, `coupon_type`, `coupon_value`, `valid_from`, `valid_to`, `coupon_usage`) VALUES ('".$orderDetails['id']."', '".$couponDetails['id']."', '".$loggedInUserId."', '".$couponDetails['coupon_code']."', '".$couponDetails['coupon_type']."', '".$couponDetails['coupon_value']."', '".$couponDetails['valid_from']."', '".$couponDetails['valid_to']."', '".$couponDetails['coupon_usage']."');";
							$this->query($query);
						}
					}

					$this->removeAllCouponCodes();
				}
				// CHECK IF COUPON CODE USED AND DISCOUNT COUPON IS VALID FOR THIS USER

				// CLEAR CART SESSION
				$cartObj->clearEntireCart();

				return true;
			} else {
				// ERROR
				return false;
			}
		}

		function getPurchasedProductOrderDetails($loggedInUserId, $txnId){
			$query = "select * from ".PREFIX."order where txn_id='".$txnId."' and customer_id='".$loggedInUserId."'";
			$orderRS = $this->query($query);
			if($orderRS->num_rows>0){ // order with txn_id for that customer found
				$transactionArr = array();
				$orderDetails = $this->fetch($orderRS);

				$transactionArr['order'] = $orderDetails;
				$transactionArr['orderDetails'] = array();

				$query = "select * from ".PREFIX."order_details where order_id='".$orderDetails['id']."' and customer_id='".$loggedInUserId."'";
				$orderDetailsRS = $this->query($query);

				while($row = $this->fetch($orderDetailsRS)){
					$transactionArr['orderDetails'][] = $row;
				}
				return $transactionArr;
			} else {
				// error
				return false;
			}
		}

		function purchaseOfProductOrderFailed($loggedInUserId, $txnId){
			$query = "select * from ".PREFIX."order where txn_id='".$txnId."' and customer_id='".$loggedInUserId."'";
			$orderRS = $this->query($query);
			if($orderRS->num_rows>0){ // order with txn_id for that customer found
				$orderDetails = $this->fetch($orderRS);

				// update payment status of order
				$query = "update ".PREFIX."order set payment_status='Payment Failed' where id='".$orderDetails['id']."'";
				$this->query($query);

				return true;
			} else {
				// error
				return false;
			}
		}

		function getCompletedOrdersByCustomerId($customerId){
			$customerId = $this->escape_string($this->strip_all($customerId));
			$query ="SELECT * FROM ".PREFIX."order WHERE `customer_id`='".$customerId."' and (`payment_status`='Payment Complete' or (`payment_status`='Payment Pending' and payment_mode='COD')) order by id DESC";
			return $this->query($query);
		}

		function getCustomerPurchaseAmount($loggedInUserId, $txn_id){
			$txn_id = $this->escape_string($this->strip_all($txn_id));
			$loggedInUserId = $this->escape_string($this->strip_all($loggedInUserId));
			$purchaseDetails = $this->getPurchasedProductOrderDetails($loggedInUserId, $txn_id);
			if($purchaseDetails){
				$order = $purchaseDetails['order'];
				$orderDetails = $purchaseDetails['orderDetails'];

				$subTotal = 0;
				$finalTotal = 0;
				$gst_amt='0';
				$Taxorder = 0;
				$gstdata = 0;
				$totalPrice = 0;
				foreach($orderDetails as $oneOrder){
					$productDetails = $this->getUniqueProductById($oneOrder['product_id']);
					$quantity = $oneOrder['quantity'];
					$image_name = strtolower(pathinfo($productDetails['main_image'], PATHINFO_FILENAME));
					$image_ext = strtolower(pathinfo($productDetails['main_image'], PATHINFO_EXTENSION));
					$Taxorder = $oneOrder['gst_rate'];
					$imageUrl = BASE_URL."/images/products/".$image_name.'_large.'.$image_ext;
					$gst_tax = $oneOrder['gst_rate'];

					$unitPrice = $oneOrder['customer_price'];
					$unitDiscountedPrice = $oneOrder['customer_discount_price'];

					if(!empty($unitDiscountedPrice)){
						$totalPrice = $quantity * $unitDiscountedPrice;
						$totalPriceMsg = 'Rs. '.$unitDiscountedPrice.' x '.$quantity.' unit';
						$displayPrice = $unitDiscountedPrice;
					} else {
						$totalPrice = $quantity * $unitPrice;
						$totalPriceMsg = 'Rs. '.$unitPrice.' x '.$quantity.' unit';
						$displayPrice = $unitPrice;
					}
					$taxAmount = $totalPrice * ($gst_tax/100);
					$amountWithTax = $totalPrice + $taxAmount;
					$subTotal += $amountWithTax;
				}

				// CHECK IF DISCOUNT COUPON IS USED
				$couponDiscountAmount = $this->getRedeemedCouponAmount($order['customer_id'], $order['id']);
				if(!empty($couponDiscountAmount)){
					//echo "DIS".$couponDiscountAmount;
					$finalTotal = $subTotal - $couponDiscountAmount;
				} else {
					$finalTotal = $subTotal;
				}
				//echo $finalTotal;
				//exit;
				// CHECK IF DISCOUNT COUPON IS USED

				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL
				if(!empty($order['shipping_charges'])){
					$finalTotal += $order['shipping_charges'];
				}
				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL 

				// INCREMENT CUSTOMER PURCHASE AMOUNT
				return $finalTotal;
			} else {
				return -1;
			}
		}

		function getOrderDetailsData($orderDetailsID){
			$orderDetailsID = $this->escape_string($this->strip_all($orderDetailsID));

			$sql = "SELECT * FROM ".PREFIX."refund_request WHERE `order_detail_pal`='".$orderDetailsID."'";
			$result =  $this->query($sql);
			if($this->num_rows($result)>0) {
				return false;
			} else {
				return true;
			}
			//return $this->fetch($result);
		}

		/* === ORDER ENDS === */

		/* === COUPON CODE STARTS === */
		function getCouponDetailsByCouponCode($couponCode){
			$couponCode = $this->escape_string($this->strip_all($couponCode));
			$today = date("Y-m-d");
			$query = "select * from ".PREFIX."discount_coupon_master where coupon_code='".$couponCode."' and active='1' and ('$today' >= valid_from and valid_to >= '$today')";
			// echo $query;
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function applyCouponCode($couponCode, $loggedInUserDetailsArr){

			$errorArr = array();
			if(isset($couponCode) && !empty($couponCode)){
				$couponCode = strip_tags($couponCode);
			} else {
				$errorArr[] = "ENTERCOUPONCODE";
			}

			$statusMessage = '';
			if(count($errorArr)>0){
				$errorStr = implode("|", $errorArr);
				return array(
						"response" => true,
						"responseMsg" => "Please enter coupon code",
						"couponCodeMsg" => "Please enter a coupon code",
						"error" => $errorStr
						);
			} else {
				// get coupon details
				$couponDetails = $this->getCouponDetailsByCouponCode($couponCode);
				if(count($couponDetails)>0){
					/*$productIdsRS = $this->getApplicableProductIdsForCouponByCouponCode($couponCode);
					if($productIdsRS===false){
						return array(
							"response" => true,
							"responseMsg" => "Please enter a valid coupon1",
							"couponCodeMsg" => "Please enter a valid coupon1",
							"error" => "INVALIDCOUPON"
						);
					}*/

					$couponDetails = $this->getCouponDetailsByCouponCode($couponCode);

					$isCouponApplicable = false;
					// $isCouponApplicable = $this->isCouponApplicableForCustomer($couponDetails['id'], $loggedInUserDetailsArr['id']); // DEPRECATED
					$isCouponApplicable = $this->isCouponApplicableForCustomer($couponDetails['id'], $loggedInUserDetailsArr['id'], 0);
					if($isCouponApplicable){ // customer has not used this coupon code yet

						$couponApplied = false;
						$price = $this->getCartTotal();
						// prepare product to add in session
						$couponCodeArr = array(
								"couponCode" => $couponCode,
							);

						if(isset($_SESSION[SITE_NAME]['couponCode'])){ // check if session exists
							$couponCodeInSession = array_column($_SESSION[SITE_NAME]['couponCode'], 'couponCode');
							if(in_array($couponCode, $couponCodeInSession)){ // coupon code already applied
								$statusMessage = "Coupon code already applied";
							} else {
								if($couponDetails['minimum_purchase_amount']>0 && $price < $couponDetails['minimum_purchase_amount']) {
									$statusMessage = "Coupon Code not valid";
								} else {
									$_SESSION[SITE_NAME]['couponCode'][] = $couponCodeArr;
									$statusMessage = "Coupon code applied";
									$couponApplied = true;
								}
							}

						} else { // create session, add coupon code for that product
							if($couponDetails['minimum_purchase_amount']>0 && $price < $couponDetails['minimum_purchase_amount']) {
								$statusMessage = "Minimum order amount should be Rs. ".$couponDetails['minimum_purchase_amount'];
							} else {
								// print_r($couponCodeArr);
								$_SESSION[SITE_NAME]['couponCode'] = array($couponCodeArr);
								$statusMessage = "Coupon code applied";
								$couponApplied = true;
							}
						}
						if($couponApplied){ // coupon applied to at least one product
							return array(
								"response" => true,
								"responseMsg" => $statusMessage,
								"couponCodeMsg" => $statusMessage,
								"couponCodeArr" => $_SESSION[SITE_NAME]['couponCode'],
							);
						} else { // coupon code applied to 0 product, reject coupon code, product not in cart
							return array(
								"response" => true,
								"responseMsg" => $statusMessage,
								"couponCodeMsg" => $statusMessage,
								"error" => "INVALIDCOUPON"
							); 
						}
					} else {
						return array(
							"response" => true,
							"responseMsg" => "You have already used this coupon",
							"couponCodeMsg" => "You have already used this coupon",
							"error" => "COUPONUSED"
						);
					}
				} else {
					return array(
						"response" => true,
						"responseMsg" => "Please enter a valid coupon",
						"couponCodeMsg" => "Please enter a valid coupon",
						"error" => "INVALIDCOUPON"
					);
				}
			}
		}

		function verifyCouponCode($couponCode, $loggedInUserId, $cartObj, $orderId = 0){
			if(isset($_SESSION[SITE_NAME]['couponCode'])){ // check if session exists
				$couponDiscountAmount = 0;

				// check if coupon code is within time range and active
				$couponCode = $this->escape_string($this->strip_all($couponCode));
				$today = date("Y-m-d");
				$query = "select * from ".PREFIX."discount_coupon_master where coupon_code='".$couponCode."' and active='1' and ('$today' >= valid_from and valid_to >= '$today')";
				$couponDetailsRS = $this->query($query);
				if($couponDetailsRS->num_rows>0){ // coupon is valid
					$couponDetails = $this->fetch($couponDetailsRS);

					// check if user has used the coupon code, only for single use coupon, not multiple use coupon
					if($couponDetails['coupon_usage']=="single"){
						// if($this->isCouponApplicableForCustomer($couponDetails['id'], $loggedInUserId)){ // DEPRECATED
						if($this->isCouponApplicableForCustomer($couponDetails['id'], $loggedInUserId, $orderId)){
							// coupon is used in past transaction
							// $couponDiscountAmount = $this->getOneCouponCodeAmount($productId, $cartObj, $couponDetails);
						} else {
							$this->removeAllCouponCodes($couponCode);
							return array(
								"couponStatus" => "coupon_removed"/*,
								"couponDiscount" => 0*/
							);
						}
					} else if($couponDetails['coupon_usage']=="multiple"){
						// $couponDiscountAmount = $this->getOneCouponCodeAmount($productId, $cartObj, $couponDetails);
					}

					return array(
						"couponStatus" => "success",
						"discountCouponDetails" => $couponDetails/*,
						"couponDiscount" => floatval($couponDiscountAmount)*/
					);

				} else { // coupon invalid
					return array(
						"couponStatus" => "invalid_coupon"/*,
						"couponDiscount" => 0*/
					);
				}

			} else { // no coupon code applied
				return array(
					"couponStatus" => "no_coupon_entered"/*,
					"couponDiscount" => 0*/
				);
			}
		}

		function getOneCouponCodeAmount($cartObj, $couponDetails){
			$couponDiscountAmount = 0;

			$price = $this->getCartTotal();
			$discountOnThisPrice = ($price);

			$precision = 2;
			if($couponDetails['coupon_type']=="percent"){
				$couponDiscountAmount = round(( $discountOnThisPrice*($couponDetails['coupon_value']/100)  ) , $precision);
			} else if($couponDetails['coupon_type']=="amount"){
				$couponDiscountAmount = round($couponDetails['coupon_value'], $precision);
			}
			return $couponDiscountAmount;
		}

		function isCouponApplicableForCustomer($couponId, $loggedInUserId, $orderId = 0){
			$today = date("Y-m-d");
			$query = "select * from ".PREFIX."discount_coupon_master where id='".$couponId."' and active='1' and ('$today' >= valid_from and valid_to >= '$today')";
			$masterCouponRS = $this->query($query);
			if($masterCouponRS->num_rows>0){
				$masterCouponDetails = $this->fetch($masterCouponRS);

				if($masterCouponDetails['coupon_usage']=="multiple"){ // anyone can use coupon
					return true;
				} else { // check if coupon is used at least once
					if($loggedInUserId) {
						if(empty($orderId)){ // coupon code is being applied
							$query = "select * from ".PREFIX."order_discount_coupons where discount_coupon_id='".$couponId."' and customer_id='".$loggedInUserId."'";
						} else { // user is at payment gateway, allow single coupon code for same transaction
							$query = "select * from ".PREFIX."order_discount_coupons where discount_coupon_id='".$couponId."' and customer_id='".$loggedInUserId."' and order_id!='".$orderId."'";
						}
						$couponUseRS = $this->query($query);
						if($couponUseRS->num_rows>0){
							return false;
						} else {
							return true;
						}
					} else {
						return true;
					}
				}
			} else {
				return false;
			}
		}

		function getNewSubtotalAfterCouponCode($subTotal, $cartObj, $loggedInUserDetailsArr) {
			if( isset($_SESSION[SITE_NAME]['couponCode']) && !empty($_SESSION[SITE_NAME]['couponCode'])){	
				$couponDiscount = 0;
				foreach($_SESSION[SITE_NAME]['couponCode'] as $oneCoupon){
					$couponCode = $this->escape_string($this->strip_all($oneCoupon['couponCode']));
					$couponVerificationResult = $this->verifyCouponCode($couponCode, $loggedInUserDetailsArr['id'], $cartObj);

					if($couponVerificationResult['couponStatus'] == 'success'){
						$couponDiscountValue = $couponVerificationResult['discountCouponDetails']['coupon_value'];
						$couponDiscountType = $couponVerificationResult['discountCouponDetails']['coupon_type'];
					}
				}

				if(!empty($couponDiscountType) && !empty($couponDiscountValue)){
					if($couponDiscountType == 'percent'){
						$couponDiscountAmount = 0;
						foreach($_SESSION[SITE_NAME]['couponCode'] as $oneCoupon){
							$couponCode = $this->escape_string($this->strip_all($oneCoupon['couponCode']));
							$today = date("Y-m-d");

							$query = "select * from ".PREFIX."discount_coupon_master where coupon_code='".$couponCode."' and active='1' and ('$today' >= valid_from and valid_to >= '$today')";
							$couponDetailsRS = $this->query($query);
							if($couponDetailsRS->num_rows>0){ // coupon is valid
								$couponDetails = $this->fetch($couponDetailsRS);
								if($couponDetails['minimum_purchase_amount'] <= $subTotal){
									// check if user has used the coupon code, only for single use coupon, not multiple use coupon
									if($couponDetails['coupon_usage']=="single"){
										// if($this->isCouponApplicableForUser($couponDetails['id'], $loggedInUserId)){ // DEPRECATED
										if($this->isCouponApplicableForCustomer($couponDetails['id'], $loggedInUserDetailsArr['id'])) {
											// coupon is used in past transaction
											$couponDiscountAmount = $this->getOneCouponCodeAmount($cartObj, $couponDetails, $loggedInUserDetailsArr['id']);
										}
									} else if($couponDetails['coupon_usage']=="multiple"){
										$couponDiscountAmount = $this->getOneCouponCodeAmount($cartObj, $couponDetails, $loggedInUserDetailsArr['id']);
									}
								} else{
									// $this->removeAllCouponCodes();
								}
							}

							$couponDiscount += $couponDiscountAmount;
						}
					} else {
						$couponDiscountAmount = 0;
						foreach($_SESSION[SITE_NAME]['couponCode'] as $oneCoupon){
							$couponCode = $this->escape_string($this->strip_all($oneCoupon['couponCode']));
							$today = date("Y-m-d");

							$query = "select * from ".PREFIX."discount_coupon_master where coupon_code='".$couponCode."' and active='1' and ('$today' >= valid_from and valid_to >= '$today')";
							$couponDetailsRS = $this->query($query);
							if($couponDetailsRS->num_rows>0){ // coupon is valid
								$couponDetails = $this->fetch($couponDetailsRS);
								// echo $subTotal;
								if($couponDetails['minimum_purchase_amount'] > $subTotal){
									// $this->removeAllCouponCodes();
								}else{
									$couponDiscountAmount = $couponDetails['coupon_value'];
								}
							}
						}
						$couponDiscount = $couponDiscountValue;
					}
				}
			} else {
				$couponDiscount = 0;
			}
			$subTotal = $subTotal - $couponDiscount;

			/* if(($subTotal - $couponDiscount)>0){
				$subTotal = $subTotal - $couponDiscount;
			} else {
				$couponDiscount = 0;
				$this->removeCouponCodesForProductId($productId);
			} */
			return array(
				"subTotal" => $subTotal,
				"couponDiscount" => $couponDiscount
			);
		}

		function removeAllCouponCodes(){
			if(isset($_SESSION[SITE_NAME]['couponCode'])){
				unset($_SESSION[SITE_NAME]['couponCode']);
			}
		}

		function getRedeemedCouponAmount($customerId, $orderId){
			$customerId = $this->escape_string($this->strip_all($customerId));
			$orderId = $this->escape_string($this->strip_all($orderId));
			$query = "select * from ".PREFIX."order_discount_coupons where order_id='".$orderId."' and customer_id='".$customerId."'";

			$sql = $this->query($query);
			if($sql->num_rows>0){

				$totalDiscountAmount = 0;
				$discountOnThisPrice = 0;
				$couponDetails = $this->fetch($sql);
				$orderDetailsRS = $this->query("select * from ".PREFIX."order_details where order_id='".$orderId."' and customer_id='".$customerId."'");
				while($orderDetails = $this->fetch($orderDetailsRS)) {
					$quantityPurchased = $orderDetails['quantity'];
					$price = $orderDetails['customer_price'] * $quantityPurchased;
					if(!empty($orderDetails['customer_discount_price'])) {
						$discountedPrice = $orderDetails['customer_discount_price'] * $quantityPurchased;
						$price = $discountedPrice;
					}
					$tax = $orderDetails['gst_rate'];
					$taxAmount = $price * ($tax/100);
					$discountOnThisPrice += $taxAmount + $price;
				}
				$precision = 2;

				if($couponDetails['coupon_type']=="percent") {
					$couponDiscountAmount = round((($couponDetails['coupon_value'] * $discountOnThisPrice) / 100), $precision);
				} else if($couponDetails['coupon_type']=="amount") {
					$couponDiscountAmount = round($couponDetails['coupon_value'], $precision);
				} else {
					$couponDiscountAmount = 0; // invalid values in database
				}
				$totalDiscountAmount = $couponDiscountAmount;

				return $totalDiscountAmount;
			} else {
				return 0;
			}
		}

		/* === COUPON CODE ENDS === */

		/* === CMS STARTS === */
		function getSliderbBanner(){
			$sql = "SELECT * FROM ".PREFIX."slider_banner WHERE `active`='1' order by  display_order";
			return $this->query($sql);
		}

		function getAllTestimonials() {
			$query = "select * from ".PREFIX."testimonials where active=1";
			$sql = $this->query($query);
			return $sql;
		}

		function gerCMSDetails(){
			$sql = "SELECT * FROM ".PREFIX."cms_master order by id DESC";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
	
		function getContactUsCmsMasterDetails(){
			$sql = "SELECT * FROM ".PREFIX."contact_us_cms order by id DESC";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
		
		function getdistributorCmsMasterDetails(){
			$sql = "SELECT * FROM ".PREFIX."distributor order by id DESC";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
		function getcorporateCmsMasterDetails(){
			$sql = "SELECT * FROM ".PREFIX."corporate_gifting order by id DESC";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		function contactUsRequest($data){

			$name = $this->escape_string($this->strip_all($data['name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$mobile = $this->escape_string($this->strip_all($data['contact']));
			$message = $this->escape_string($this->strip_all($data['msg']));
			$purpose = $this->escape_string($this->strip_all($data['purpose']));
			$createDate = date('d-m-Y H:i:s');
			$sql = "INSERT INTO ".PREFIX."contact_us( `name`, `email`, `mobile`, `feedback`,address, created) VALUES ('".$name."','".$email."','".$mobile."','".$message."', '".$purpose."', '".$createDate."')";
			$this->query($sql);
		}
		
		function distributorsRequest($data){

			$name = $this->escape_string($this->strip_all($data['name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$mobile = $this->escape_string($this->strip_all($data['contact']));
			$message = $this->escape_string($this->strip_all($data['msg']));
			$purpose = $this->escape_string($this->strip_all($data['purpose']));
			$createDate = date('d-m-Y H:i:s');
			$sql = "INSERT INTO ".PREFIX."distributor( `name`, `email`, `contact`, `msg`,purpose, created) VALUES ('".$name."','".$email."','".$mobile."','".$message."','".$purpose."', '".$createDate."')";
			$this->query($sql);
		}
		
		function corpgiftingRequest($data){

			$name = $this->escape_string($this->strip_all($data['name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$mobile = $this->escape_string($this->strip_all($data['contact']));
			$message = $this->escape_string($this->strip_all($data['msg']));
			$purpose = $this->escape_string($this->strip_all($data['purpose']));
			$createDate = date('d-m-Y H:i:s');
			$sql = "INSERT INTO ".PREFIX."corporate_gifting( `name`, `email`, `contact`, `msg`,purpose, created) VALUES ('".$name."','".$email."','".$mobile."','".$message."','".$purpose."', '".$createDate."')";
			$this->query($sql);
		}

		/* === CMS ENDS === */

		/* === NEWSLETTER STARTS === */
		function addSubscribeNewsletter($data){
			$email = $this->escape_string($this->strip_all($data['youremail']));
			$name = $this->escape_string($this->strip_all($data['yourname']));
			$createDate = date('d-m-Y H:i:s');
			$query = "insert into ".PREFIX."newsletter_subscription(email, name,created) values ('".$email."', '".$name."', '".$createDate."')";
			return  $this->query($query);
		}

		/* === NEWSLETTER ENDS === */

	}
?>