<?php
	include('database.php');
	include('SaveImage.class.php');
	include('Email.class.php');
	
	include_once("../../include/classes/Email.class.php");


	class AdminFunctions extends Database {
		private $userType = 'admin';
		private $allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

		function getAdminEmail() {
			$query = $this->query("SELECT * FROM ".PREFIX."admin");
			return $this->fetch($query)['username'];
		}

		/* Check login session */
		function loginSession($userId, $userName, $userType,$role) {
			$_SESSION[SITE_NAME][$this->userType."UserId"] = $userId;
			$_SESSION[SITE_NAME][$this->userType."UserName"] = $userName;
			$_SESSION[SITE_NAME][$this->userType."UserType"] = $this->userType;
			$_SESSION[SITE_NAME][$this->userType."role"] = $role;
		}

		/* Logout Function session */
		function logoutSession() {
			if(isset($_SESSION[SITE_NAME])){
				if(isset($_SESSION[SITE_NAME][$this->userType."UserId"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserId"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserName"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserType"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserType"]);
				}
				return true;
			} else {
				return false;
			}
		}

		/* Admin login function */
		function adminLogin($data, $successURL, $failURL = "admin-login.php?failed") {
			$username = $this->escape_string($this->strip_all($data['username']));
			$password = $this->escape_string($this->strip_all($data['password']));
			$query = "select * from ".PREFIX."admin where username='".$username."'";
			$result = $this->query($query);
			if($this->num_rows($result) == 1) { 
				$row = $this->fetch($result);
				if(password_verify($password, $row['password'])) {
					$this->loginSession($row['id'], $row['full_name'], $this->userType,$row['role']);
					$this->close_connection();
					header("location: ".$successURL);
					exit;
				} else {
					$this->close_connection();
					header("location: ".$failURL);
					exit;
				}
			} else {
				$this->close_connection();
				header("location: ".$failURL);
				exit;
			}
		}

		function sessionExists(){
			if($this->isUserLoggedIn()){
				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
			} else {
				return false;
			}
		}

		function isUserLoggedIn(){
			if( isset($_SESSION[SITE_NAME]) && isset($_SESSION[SITE_NAME][$this->userType.'UserId']) && isset($_SESSION[SITE_NAME][$this->userType.'UserType']) && !empty($_SESSION[SITE_NAME][$this->userType.'UserId']) && $_SESSION[SITE_NAME][$this->userType.'UserType']==$this->userType){
				return true;
			} else {
				return false;
			}
		}

		function getLoggedInUserDetails(){
			$loggedInID = $this->escape_string($this->strip_all($_SESSION[SITE_NAME][$this->userType.'UserId']));
			$loggedInUserDetailsArr = $this->getUniqueUserById($loggedInID);
			return $loggedInUserDetailsArr;
		}

		function getUniqueUserById($userId) {
			$userId = $this->escape_string($this->strip_all($userId));
			$query = "select * from ".PREFIX."admin where id='".$userId."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function getDateFromDay($year, $month, $day) {
			/*
			0 for tuesday
			1 for monday
			2 for sunday
			3 for saturday
			4 for friday
			5 for thursday
			6 for wednesday
			*/
			$mondays = array();
			$firstDay = date('N', mktime(0, 0, 0, $month, $day, $year));
			/* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
			to get the first monday in month */
			$addDays = (8 - $firstDay);
			$mondays[] = date('Y-m-d', mktime(0, 0, 0, $month, 1 + $addDays, $year));

			$nextMonth = mktime(0, 0, 0, $month + 1, 1, $year);

			# Just add 7 days per iteration to get the date of the subsequent week
			for ($week = 1, $time = mktime(0, 0, 0, $month, 1 + $addDays + $week * 7, $year);
				$time < $nextMonth;
				++$week, $time = mktime(0, 0, 0, $month, 1 + $addDays + $week * 7, $year))
			{
				$mondays[] = date('Y-m-d', $time);
			}
			return $mondays;
		} 

		// === LOGIN ENDS ====

		// == EXTRA FUNCTIONS STARTS ==
		function getValidatedPermalink($permalink){ 
			$permalink = trim($permalink, '()');
			$replace_keywords = array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ",
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
				"-?-", "-?", "?-", " ? ", " ?", "? ", "?",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$escapedPermalink = str_replace($replace_keywords, '-', $permalink); 
			return strtolower($escapedPermalink);
		}

		function getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink='',$num=1) {
			if($newPermalink=='') {
				$checkPerma = $permalink;
			} else {
				$checkPerma = $newPermalink;
			}
			$sql = $this->query("select * from ".PREFIX.$tableName." where permalink='$checkPerma' and main_menu='$main_menu'");
			if($this->num_rows($sql)>0) {
				$count = $num+1;
				$newPermalink = $permalink.$count;
				return $this->getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink,$count);
			} else {
				return $checkPerma;
			}
		}

		function getActiveLabel($isActive){
			if($isActive){
				return 'Yes';
			} else {
				return 'No';
			}
		}

		function getImageUrl($imageFor, $fileName, $imageSuffix){
			$image = strtolower(pathinfo($fileName, PATHINFO_FILENAME));
			$image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			switch($imageFor){
				case "home-banner":
				$fileDir = "../images/home-banner/";
				break;
				
				default:
				return false;
				break;
			}
			$imageUrl = $fileDir.$image."_".$imageSuffix.".".$image_ext;
			if(file_exists($imageUrl)){
				return $imageUrl;
			} else {
				return false;
			}
		}

		function unlinkImage($imageFor, $fileName, $imageSuffix){
			$imagePath = $this->getImageUrl($imageFor, $fileName, $imageSuffix);
			$status = false;
			if($imagePath!==false){
				$status = unlink($imagePath);
			}
			return $status;
		}

		function checkUserPermissions($permission,$loggedInUserDetailsArr) {
			$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
			if(!in_array($permission,$userPermissionsArray) and $loggedInUserDetailsArr['role']!='super') {
				header("location: dashboard.php");
				exit;
			}
		}

		function generate_id($prefix, $randomNo, $tableName, $columnName){
			$chkprofile=$this->query("select ".$columnName." from ".PREFIX.$tableName." where ".$columnName." = '".$prefix.$randomNo."'");
			if($this->num_rows($chkprofile)>0){
				$randomNo = str_shuffle('1234567890123456789012345678901234567890');
				$randomNo = substr($randomNo,0,8);
				$this->generate_id($prefix, $randomNo, $tableName, $columnName);
			}else{
				return  $prefix.$randomNo;
			}
		}

		function getIndianCurrency($number) {
			$decimal = round($number - ($no = floor($number)), 2) * 100;
			$hundred = null;
			$digits_length = strlen($no);
			$i = 0;
			$str = array();
			$words = array(0 => '', 1 => 'one', 2 => 'two',
				3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
				7 => 'seven', 8 => 'eight', 9 => 'nine',
				10 => 'ten', 11 => 'eleven', 12 => 'twelve',
				13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
				16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
				19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
				40 => 'forty', 50 => 'fifty', 60 => 'sixty',
				70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
			$digits = array('', 'hundred','thousand','lakh', 'crore');
			while( $i < $digits_length ) {
				$divider = ($i == 2) ? 10 : 100;
				$number = floor($no % $divider);
				$no = floor($no / $divider);
				$i += $divider == 10 ? 1 : 2;
				if ($number) {
					$plural = (($counter = count($str)) && $number > 9) ? '' : null;
					//$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
					$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
					$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
				} else $str[] = null;
			}
			$Rupees = implode('', array_reverse($str));
			$paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
			//return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
			return ucfirst(($Rupees ? $Rupees . 'rupees ' : '') . $paise);
		}

		function ckeditorRefresh($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		} 

		function insertData($data, $table) {
			$columns = implode(", ",array_keys($data));
			$values  = "'".implode("', '", array_values($data))."'";
			$this->query("INSERT INTO ".PREFIX.$table." ($columns) VALUES ($values)");
			
			return $this->last_insert_id();
		}

		
		function deleteData($table, $column = '', $val = '') {
			if(!empty($column) && !empty($val)) {
				$whereCond = " where ".$column." = '".$val."'";
			} else {
				$whereCond = "";
			}
			$this->query("DELETE FROM ".PREFIX.$table." $whereCond ");
			return $val;
		}

		// == EXTRA FUNCTIONS ENDS ==

		/* === CATEGORY STARTS === */
		function getUniqueCategoryById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."category_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function getUniquesizeById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."size_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function getUniquecolorById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."color_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function getAllCategories() {
			$query = "select * from ".PREFIX."category_master";
			$sql = $this->query($query);
			return $sql;
		}

		function addCategory($data,$file){
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$catPermalink = $this->getValidatedPermalink($category_name);

			// SEO details
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));
			
			
				$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/slider-banner/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
				$filename1 = $_FILES["small_image"]["name"]; 
				$tempname1 = $_FILES["small_image"]["tmp_name"];  
				$folder1 = "../images/slider-banner/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  { 
				$msg = "Image uploaded successfully"; 
				}
			

			$query = "insert into ".PREFIX."category_master(category_name, active, permalink, page_title, meta_keyword, meta_description,banner,cat_image) values ('".$category_name."', '".$active."', '".$catPermalink."', '".$page_title."', '".$meta_keyword."', '".$meta_description."','".$filename."','".$filename1."')";

			return $this->query($query);
		}
		function addsize($data){
			
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$size_category = '';
			if(isset($data['size_category']) and count($data['size_category'])>0) {
				$size_category = implode(',', $data['size_category']);
			}

			$size_subcategory = '';
			if(isset($data['size_subcategory']) and count($data['size_subcategory'])>0) {
				$size_subcategory = implode(',', $data['size_subcategory']);
			}
			//$catPermalink = $this->getValidatedPermalink($category_name);
			$query = "insert into ".PREFIX."size_master(size, size_category, size_subcategory, active) values ('".$category_name."', '".$size_category."', '".$size_subcategory."', '".$active."')";
			return $this->query($query);
		}
		function addcolor($data,$file){
			
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			//$catPermalink = $this->getValidatedPermalink($category_name);
			$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/color/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
			$query = "insert into ".PREFIX."color_master(color, active,image) values ('".$category_name."', '".$active."', '".$filename."')";
			return $this->query($query);
		}
		function faq_question_answers($data,$question,$answer) {
		
			$top_bold_head_content = $this->escape_string($this->strip_selected($data['question'], $this->allowTags));
			$bottom_text_content = $this->escape_string($this->strip_selected($data['answer'], $this->allowTags));
			$top_bold_head_content1 = $this->escape_string($this->strip_selected($data['display_order'], $this->allowTags));
			
				$query = "insert into slv_faq_question_answer (".$question.",".$answer.",display_order) values ('".$top_bold_head_content."','".$bottom_text_content."','$top_bold_head_content1')";
		
			return $this->query($query);
			
		}
		function updatefaq_question_answers($data,$question) {
		
			$top_bold_head_content1 = $this->escape_string($this->strip_selected($data['display_order'], $this->allowTags));	
			$top_bold_head_content = $this->escape_string($this->strip_selected($data['question'], $this->allowTags));
			$bottom_text_content = $this->escape_string($this->strip_selected($data['answer'], $this->allowTags));
			$idd = $this->escape_string($this->strip_selected($data['id'], $this->allowTags));

			$query = "update slv_faq_question_answer set question='".$top_bold_head_content."',answer='".$bottom_text_content."',display_order='".$top_bold_head_content1."' where id='$idd' ";
		
			return $this->query($query);
			
		}
		function delfaq_question_answers($id) {
			$top_bold_head_content =  $this->escape_string($this->strip_all($id));
			$query = "DELETE FROM slv_faq_question_answer WHERE id='$top_bold_head_content'";

			return $this->query($query);
		}
		function delreviews($id) {
			$top_bold_head_content =  $this->escape_string($this->strip_all($id));
			$query = "DELETE FROM slv_reviews_master WHERE id='$top_bold_head_content'";

			return $this->query($query);
		}
		
		function delmilestone($id) {
		
			$top_bold_head_content =  $this->escape_string($this->strip_all($id));
			$query = "DELETE FROM slv_milestone WHERE id='$top_bold_head_content'";
			
			return $this->query($query);
			
			
		}
		function updateCategory($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			$catPermalink = $this->getValidatedPermalink($category_name);
			
			if(isset($file['main_image']['name']) && !empty($file['main_image']['name'])) {
				$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/slider-banner/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
				$this->query("update ".PREFIX."category_master set banner='".$filename."' where id='".$id."'");	
				
			}
			if(isset($file['small_image']['name']) && !empty($file['small_image']['name'])) {
				$filename1 = $_FILES["small_image"]["name"]; 
				$tempname1 = $_FILES["small_image"]["tmp_name"];  
				$folder1 = "../images/slider-banner/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  
				{ 
				$msg = "Image uploaded successfully"; 
				}
				$this->query("update ".PREFIX."category_master set cat_image='".$filename1."' where id='".$id."'");	
				
			}

			$query = "update ".PREFIX."category_master set permalink='".$catPermalink."', category_name='".$category_name."', active='".$active."', page_title='".$page_title."', meta_keyword='".$meta_keyword."', meta_description='".$meta_description."'  where id='".$id."'";
			$this->query($query);

			return true;
		}
		function updatesize($data) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));

			$size_category = '';
			if(isset($data['size_category']) and count($data['size_category'])>0) {
				$size_category = implode(',', $data['size_category']);
			}

			$size_subcategory = '';
			if(isset($data['size_subcategory']) and count($data['size_subcategory'])>0) {
				$size_subcategory = implode(',', $data['size_subcategory']);
			}

			$active = $this->escape_string($this->strip_all($data['active']));
			//$catPermalink = $this->getValidatedPermalink($category_name);	
			$query = "update ".PREFIX."size_master set size='".$category_name."', size_category='".$size_category."', size_subcategory='".$size_subcategory."', active='".$active."'  where id='".$id."'";
			$this->query($query);
			return true;
		}
		function updatecolor($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			//$catPermalink = $this->getValidatedPermalink($category_name);	
			if(isset($file['main_image']['name']) && !empty($file['main_image']['name'])) {
				$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/color/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
				$this->query("update ".PREFIX."color_master set image='".$filename."' where id='".$id."'");	
				
			}
			$query = "update ".PREFIX."color_master set color='".$category_name."', active='".$active."'  where id='".$id."'";
			$this->query($query);
			return true;
		}
		function updatecontactmap($data,$map) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$maps = $this->escape_string($this->strip_all($data['map']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$phone = $this->escape_string($this->strip_all($data['phone']));
			$address = $this->escape_string($this->strip_all($data['address']));
			
			$fb = $this->escape_string($this->strip_all($data['fb']));
			$twit = $this->escape_string($this->strip_all($data['twit']));
			$link = $this->escape_string($this->strip_all($data['link']));
			$insta = $this->escape_string($this->strip_all($data['insta']));
			
			$sql = $this->query("select * from ".PREFIX."contact_cms");
			if($this->num_rows($sql)>0) 
			{
				$query = "update ".PREFIX."contact_cms set map='".$maps."',email='".$email."',phone='".$phone."',address='".$address."',fb='".$fb."',twit='".$twit."',link='".$link."',instagram='".$insta."' where id='".$id."'";
			} 
			else 
			{
				$query = "insert into ".PREFIX."contact_cms(map,email,phone,fb,twit,link,address,instagram) values ('".$maps."','".$email."','".$phone."','".$fb."','".$twit."','".$link."','".$address."','".$insta."')";
			}
			
			
			$this->query($query);
			return true;
		}
		

		function deleteCategory($id) {
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."category_master where id='".$id."'";
			$this->query($query);

			$subCategoryRS = $this->query("SELECT id FROM ".PREFIX."sub_category_master WHERE `category_id`='".$id."'");
			if($this->num_rows($subCategoryRS)>0){
				while($result = $this->fetch($subCategoryRS)) {
					$this->deleteSubcategory($result['id']);
				}
			}

			return true;
		}
		function deletesize($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."size_master where id='".$id."'";
			$this->query($query);			
			return true;
		}
		function deletecolor($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."color_master where id='".$id."'";
			$this->query($query);			
			return true;
		}

		/* === CATEGORY ENDS === */

		/* === SUB CATEGORY LEVEL 1 BEGINS === */

		function getAllSubCategories() {
			$query = "select * from ".PREFIX."sub_category_master";
			$sql = $this->query($query);
			return $sql;
		}

		function getAllSubCategoriesByCategoryId($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."sub_category_master where category_id in (".$category_id.")";
			$sql = $this->query($query);
			return $sql;
		}

		function getUniqueSubCategoryById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."sub_category_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addSubCategory($data) {
			$category_id = $this->escape_string($this->strip_all($data['category_id']));
			$category_name 	= $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$permalink	= $this->getValidatedPermalink($category_name);
			
			
				$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/slider-banner/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
				
				
			
			
				$filename1 = $_FILES["small_image"]["name"]; 
				$tempname1 = $_FILES["small_image"]["tmp_name"];  
				$folder1 = "../images/slider-banner/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  
				{ 
				$msg = "Image uploaded successfully"; 
				}
			
				
			

			// SEO details
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			$date = date("Y-m-d h:i:s");
			$query = "insert into ".PREFIX."sub_category_master(category_id, category_name, permalink, active, page_title, meta_keyword, meta_description,banner,subcat_image) values ('".$category_id."', '".$category_name."', '".$permalink."', '".$active."', '".$page_title."', '".$meta_keyword."', '".$meta_description."', '".$filename."', '".$filename1."')";
			return $this->query($query);
		}

		function updateSubCategory($data,$file){
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$permalink	= $this->getValidatedPermalink($category_name);

			// SEO details
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));
			
			if(isset($file['main_image']['name']) && !empty($file['main_image']['name'])) {
				$filename = $_FILES["main_image"]["name"]; 
				$tempname = $_FILES["main_image"]["tmp_name"];  
				$folder = "../images/slider-banner/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
				$this->query("update ".PREFIX."sub_category_master set banner='".$filename."' where id='".$id."'");	
				
			}
			if(isset($file['small_image']['name']) && !empty($file['small_image']['name'])) {
				$filename1 = $_FILES["small_image"]["name"]; 
				$tempname1 = $_FILES["small_image"]["tmp_name"];  
				$folder1 = "../images/slider-banner/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  
				{ 
				$msg = "Image uploaded successfully"; 
				}
				$this->query("update ".PREFIX."sub_category_master set subcat_image='".$filename1."' where id='".$id."'");	
				
			}

			$query = "update ".PREFIX."sub_category_master set category_name='".$category_name."', permalink='".$permalink."', active='".$active."', page_title='".$page_title."', meta_keyword='".$meta_keyword."', meta_description='".$meta_description."' where id='".$id."'";
			return $this->query($query);
		}

		function deleteSubcategory($id) {
			$id = $this->escape_string($this->strip_all($id));

			$this->query("DELETE FROM ".PREFIX."sub_category_master WHERE `id`='".$id."'");

			/*$subCategoryRS = $this->query("SELECT id FROM ".PREFIX."subsubCategory WHERE `category_id`='".$id."'");
			if($this->num_rows($subCategoryRS)>0){
				while($result = $this->fetch($subCategoryRS)) {
					$this->deleteSubCategoryLevel2($result['id']);
				}
			}*/
			return true;
		}

		/* === SUB CATEGORY LEVEL 1 ENDS === */

		/* === SUB CATEGORY LEVEL 2 STARTS === */
		function getAllSubCategoriesLevel2($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."subsubcategory where category_id in ($category_id)";
			//echo $query;
			$sql = $this->query($query);
			return $sql;
		}

		function getUniqueSubCategoryLevel2ById($id){
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."subsubcategory where id='".$id."'"));	
		}

		function addSubCategoryLevel2($data, $file) {
			$category_id = $this->escape_string($this->strip_all($data['category_id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$permalink	= $this->getValidatedPermalink($category_name);

			// SEO details
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			$date = date("Y-m-d h:i:s");
			$query = "insert into ".PREFIX."subsubcategory(category_id, category_name, permalink, active, page_title, meta_keyword, meta_description) values ('".$category_id."', '".$category_name."', '".$permalink."', '".$active."', '".$page_title."', '".$meta_keyword."', '".$meta_description."')";

			return $this->query($query);
		}

		function updateSubCategoryLevel2($data,$file){
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$permalink	= $this->getValidatedPermalink($category_name);

			// SEO details
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			$query = "update ".PREFIX."subsubcategory set category_name='".$category_name."', permalink='".$permalink."', active='".$active."', page_title='".$page_title."', meta_keyword='".$meta_keyword."', meta_description='".$meta_description."' where id='".$id."'";
			return $this->query($query);
		}

		function deleteSubcategoryLevel2($id) {
			$id = $this->escape_string($this->strip_all($id));

			$this->query("DELETE FROM ".PREFIX."subsubcategory WHERE `id`='".$id."'");

			return true;
		}

		/* === SUB CATEGORY LEVEL 2 ENDS === */

		/* === ATTRIBUTE START === */
		function addAttribute($data) {
			$attribute_name = $this->escape_string($this->strip_all($data['attribute_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			
			$attribute_permalink = $this->getValidatedPermalink($attribute_name);
			
			$query = "insert into ".PREFIX."attribute_master(attribute_name, attribute_permalink, active) values ('".$attribute_name."', '".$attribute_permalink."', '".$active."')";
			$this->query($query);

			$id = $this->last_insert_id();

			if(isset($data['category_ids']) && count($data['category_ids']) > 0){
				foreach($data['category_ids'] as $key => $category_id){
					$category_id 	= $this->escape_string($this->strip_all($category_id));
					$query = "insert into ".PREFIX."category_attribute_list(category_id, attribute_id) values ('".$category_id."', '".$id."')";
					$this->query($query);
				}
			}

			if(isset($data['features']) && count($data['features']) > 0){
				foreach($data['features'] as $index => $feature){
					$feature_permalink	= $this->getValidatedPermalink($feature);
					$query = "insert into ".PREFIX."attribute_features(attribute_id, feature, feature_permalink) values ('".$id."', '".$feature."', '".$feature_permalink."')";
					$this->query($query);
				}
			}

			return $id;
		}

		/** * Function to update attribute details */
		function updateAttribute($data){
			$id 				= $this->escape_string($this->strip_all($data['id']));
			$attribute_name 	= $this->escape_string($this->strip_all($data['attribute_name']));
			$active 			= $this->escape_string($this->strip_all($data['active']));
			
			$attribute_permalink	= $this->getValidatedPermalink($attribute_name);
			
			$query = "update ".PREFIX."attribute_master set attribute_name = '".$attribute_name."', attribute_permalink = '".$attribute_permalink."', active = '".$active."' where id='".$id."'";
			$result = $this->query($query);

			if(isset($data['category_ids']) && count($data['category_ids']) > 0){
				$this->deleteCategoryAttributeListByAttributeId($id);
				foreach($data['category_ids'] as $key => $category_id){
					$category_id 	= $this->escape_string($this->strip_all($category_id));
					$query = "insert into ".PREFIX."category_attribute_list(category_id, attribute_id) values ('".$category_id."', '".$id."')";
					$this->query($query);
				}
			}

			$allAttributeFeatureDetails = $this->getAllAttributeFeaturesByAttributeId($id);
			while($attributeFeatures = $this->fetch($allAttributeFeatureDetails)){
				if(!in_array($attributeFeatures['id'], $data['attribute_feature_id'])){
					$this->deleteAttributeFeatureById($attributeFeatures['id']);
				}
			}

			if(isset($data['features']) && count($data['features']) > 0){
				// $this->deleteAllAttributeFeatureByAttributeId($id);
				foreach($data['features'] as $index => $feature){
					if(!empty($feature)){
						if(isset($data['attribute_feature_id'][$index]) && !empty($data['attribute_feature_id'][$index])){
							$feature_permalink	= $this->getValidatedPermalink($feature);
							$query = "update ".PREFIX."attribute_features set feature = '".$feature."', feature_permalink = '".$feature_permalink."' where id = '".$data['attribute_feature_id'][$index]."'";
						}else{
							$feature_permalink	= $this->getValidatedPermalink($feature);
							$query = "insert into ".PREFIX."attribute_features(attribute_id, feature, feature_permalink) values ('".$id."', '".$feature."', '".$feature_permalink."')";
						}
						$this->query($query);
					}
				}
			}

			return $result;
		}

		/** * Function to delete attribute by id */
		function deleteAttributeById($id){
			$id  	= $this->escape_string($this->strip_all($id));
			
			$query = "DELETE FROM ".PREFIX."attribute_master where id = '".$id."'";
			$this->query($query);
			
			$attrFeat = $this->query("select * from ".PREFIX."attribute_features where `attribute_id`='".$id."'");
			if($this->num_rows($attrFeat)>0){
				while($result = $this->fetch($attrFeat)){
					$deleProeductAttr = "DELETE FROM ".PREFIX."product_attributes WHERE `attribute_feature_id`='".$result['id']."'";
					$this->query($deleProeductAttr);

					$deleteAttrFeature = "DELETE FROM ".PREFIX."attribute_features WHERE `id`='".$result['id']."'";
					$this->query($deleteAttrFeature);
				}
			}

			$deleteAttrCategory = "DELETE FROM ".PREFIX."category_attribute_list WHERE `attribute_id`='".$id."'";
			$this->query($deleteAttrCategory);

		}

		/** * Function to get details of all attribute features by attribute id */
		function getAllAttributeFeaturesByAttributeId($attribute_id) {
			$attribute_id = $this->escape_string($this->strip_all($attribute_id));
			$query = "select * from ".PREFIX."attribute_features where attribute_id = '".$attribute_id."' and is_deleted <>1";
			$sql = $this->query($query);
			return $sql;
		}

		/** * Function to delete attribute feature by id */
		function deleteAttributeFeatureById($id){
			$id  	= $this->escape_string($this->strip_all($id));
			$query 	= "DELETE FROM ".PREFIX."attribute_features WHERE `id`='".$id."'";
			return $this->query($query);
		}

		/** * Function to delete attribute feature by id */
		function deleteAllAttributeFeatureByAttributeId($attribute_id){
			$attribute_id  	= $this->escape_string($this->strip_all($attribute_id));
			$query 	= "delete from ".PREFIX."attribute_features where attribute_id = '".$attribute_id."'";

			return $this->query($query);
		}

		/** * Function to delete category attribute link by attribute id */
		function deleteCategoryAttributeListByAttributeId($attribute_id){
			$attribute_id  	= $this->escape_string($this->strip_all($attribute_id));
			$query 	= "delete from ".PREFIX."category_attribute_list where attribute_id = '".$attribute_id."'";

			return $this->query($query);
		}

		function getUniqueAttributeById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."attribute_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function getAttributesByCategoryId($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."category_attribute_list where category_id IN ($category_id)";
			//echo $query; exit;
			$sql = $this->query($query);
			return $sql;
		}
		function getAttributeValues($attribute_id) {
			$attribute_id = $this->escape_string($this->strip_all($attribute_id));
			$query = "select * from ".PREFIX."attribute_features where attribute_id='$attribute_id'";
			return $this->query($query);
		}

		/* === Attribute ENDS === */

		/* === DISCOUNT COUPON STARTS === */
		function getAllDiscountCoupons() {
			$query = "select * from ".PREFIX."discount_coupon_master";
			$sql = $this->query($query);
			return $sql;
		}

		function getUniqueDiscountCouponById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."discount_coupon_master where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addDiscountCoupon($data) {
			$coupon_code = trim($this->escape_string($this->strip_all($data['coupon_code'])));
			$coupon_type = $this->escape_string($this->strip_all($data['coupon_type']));
			$coupon_value = $this->escape_string($this->strip_all($data['coupon_value']));
			$minimum_purchase_amount = $this->escape_string($this->strip_all($data['minimum_purchase_amount']));
			$valid_from = $this->escape_string($this->strip_all($data['valid_from']));
			$valid_to = $this->escape_string($this->strip_all($data['valid_to']));
			$coupon_usage = $this->escape_string($this->strip_all($data['coupon_usage']));
			$active = $this->escape_string($this->strip_all($data['active']));
			
			$query = "insert into ".PREFIX."discount_coupon_master (coupon_code, coupon_type, coupon_value, valid_from, valid_to, coupon_usage, minimum_purchase_amount, active) values ('$coupon_code', '$coupon_type', '$coupon_value', '$valid_from', '$valid_to', '$coupon_usage', '$minimum_purchase_amount', '$active')";
			$this->query($query); 
			$couponId = $this->last_insert_id();

			return true;
		}

		function chkcouponAlreadyExists($product_id,$coupon_id){
			$product_id = $this->escape_string($this->strip_all($product_id));
			$coupon_id = $this->escape_string($this->strip_all($coupon_id));
			$chk= "SELECT * FROM ".PREFIX."products_discount_coupons WHERE product_id='".$product_id."' and coupon_id='".$coupon_id."'";
			//echo $chk."<br>"; 
			$result = $this->query($chk);
			return $this->num_rows($result); 
		}

		function updateDiscountCoupon($data) {
			$coupon_code = trim($this->escape_string($this->strip_all($data['coupon_code'])));
			$coupon_type = $this->escape_string($this->strip_all($data['coupon_type']));
			$coupon_value = $this->escape_string($this->strip_all($data['coupon_value']));
			$valid_from = $this->escape_string($this->strip_all($data['valid_from']));
			$valid_to = $this->escape_string($this->strip_all($data['valid_to']));
			$coupon_usage = $this->escape_string($this->strip_all($data['coupon_usage']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$id = $this->escape_string($this->strip_all($data['id']));
			$minimum_purchase_amount = $this->escape_string($this->strip_all($data['minimum_purchase_amount']));

			$query = "update ".PREFIX."discount_coupon_master set coupon_code='$coupon_code', coupon_type='$coupon_type', coupon_value='$coupon_value', valid_from='$valid_from', valid_to='$valid_to', coupon_usage='$coupon_usage', minimum_purchase_amount='$minimum_purchase_amount', active='$active' where id='$id'";

			$this->query($query);
		}

		function deleteDiscountCoupon($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."discount_coupon_master where id='$id'";
			$this->query($query);
			return true;
		}

		/* === DISCOUNT COUPON ENDS === */

		/* === SHIPPING CHARGES START === */
		function updateShippingChargesDetails($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$gift_card = $this->escape_string($this->strip_all($data['gift_card']));
			if(isset($data['free_shipping_above']) && !empty($data['free_shipping_above'])){
				$free_shipping_above = $this->escape_string($this->strip_all($data['free_shipping_above']));
			}else{
				$free_shipping_above = '0';
			}
			if(isset($data['shipping_charges']) && !empty($data['shipping_charges'])){
				$shipping_charges = $this->escape_string($this->strip_all($data['shipping_charges']));
			}else{
				$shipping_charges = '0';
			}

			$query = "update ".PREFIX."shipping_charge set free_shipping_above=".$free_shipping_above.", shipping_charges='".$shipping_charges."' where id='".$id."'";
			return $this->query($query);
		}
		/* === SHIPPING CHARGES END === */

		/* === BANNER START === */
		function getUniqueSliderBannerById($staticBannerId) {
			$staticBannerId = $this->escape_string($this->strip_all($staticBannerId));
			$query = "select * from ".PREFIX."slider_banner where id='".$staticBannerId."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addSliderBanner($data,$file){
			$link 			= $this->escape_string($this->strip_all($data['link']));
			$active 		= $this->escape_string($this->strip_all($data['active']));
			$display_order 		= $this->escape_string($this->strip_all($data['display_order']));
$text 			= $this->escape_string($this->strip_all($data['text']));
$small_text 			= $this->escape_string($this->strip_all($data['small_text']));
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$SaveImage = new SaveImage();
				$imgDir = '../images/slider-banner/';
				if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
					$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
					$cropData = $this->strip_all($data['cropData1']);
					$image_name=$file['image_name']['name'];
					//$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				} else {
					$image_name = '';
				}
			}

			$query = "insert into ".PREFIX."slider_banner(image_name, link, active, display_order,text,small_text) values ('".$image_name."', '".$link."', '".$active."', '".$display_order."','".$text."','".$small_text."')";
			return $this->query($query);
		}

		function updateSliderBanner($data,$file) 
		{
			$link 			= $this->escape_string($this->strip_all($data['link']));
			$active 		= $this->escape_string($this->strip_all($data['active']));
			$display_order 		= $this->escape_string($this->strip_all($data['display_order']));
			$id 			= $this->escape_string($this->strip_all($data['id']));	
			$text 			= $this->escape_string($this->strip_all($data['text']));
			$small_text 			= $this->escape_string($this->strip_all($data['small_text']));			
			$filename = $_FILES["image_name"]["name"];
			
			if($filename!='')
			{
				$filename = $_FILES["image_name"]["name"]; 
				$tempname = $_FILES["image_name"]["tmp_name"];  
				$folder = "../images/slider-banner/$filename"; 

				if (move_uploaded_file($tempname, $folder))  
				{ 
				$msg = "Image uploaded successfully"; 
				}
				$sql1="update ".PREFIX."slider_banner set image_name='$filename' where id='$id'";
				$this->query($sql1);
			}			
			$sql="update ".PREFIX."slider_banner set active='".$active."', link='".$link."', display_order='".$display_order."', text='".$text."', small_text='".$small_text."' where id='$id'";
			return $this->query($sql);
		}

		function deleteSliderBanner($id) {
			$id = $this->escape_string($this->strip_all($id));

			$Detail = $this->getUniqueSliderBannerById($id);
			$this->unlinkImage("slider-banner", $Detail['image_name'], "large");
			$this->unlinkImage("slider-banner", $Detail['image_name'], "crop");

			$query = "delete from ".PREFIX."slider_banner where id='$id'";
			$this->query($query);
			return true;
		}

		/* === BANNER END === */

		/* === PRODUCT STARTS === */
		function getAllSubCategoriesLevel2byProductID($productId,$suCatId) {
			$productId = $this->escape_string($this->strip_all($productId));
			$suCatId = $this->escape_string($this->strip_all($suCatId));
			$query = "SELECT * FROM ".PREFIX."product_subsubcategory_mapping WHERE `product_id`='".$productId."' and subsubcategory_id='".$suCatId."'";
			//echo $query;
			$sql = $this->query($query);
			return $sql;
		}

		function getProdcutCategoryByProductId($productID){
			$categoryArr = array();
			$productID = $this->escape_string($this->strip_all($productID));
			$sql="SELECT * FROM ".PREFIX."product_category_mapping WHERE `product_id`='".$productID."'";
			//echo $sql;
			$result = $this->query($sql);
			if($this->num_rows($result)>0){
				while($categories = $this->fetch($result)){
					$categoryArr[] = $categories['category_id'];
				}
			}
			return $categoryArr; 
		}

		function getAllProducts(){
			$sql = "SELECT * FROM ".PREFIX."product_master";
			return $this->query($sql);
		}

		function getUniqueProductById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_master where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addProduct($data, $file) {
			$allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$product_name = $this->escape_string($this->strip_all($data['product_name']));
			$product_code = $this->escape_string($this->strip_all($data['product_code']));
			$hsn_code = $this->escape_string($this->strip_all($data['hsn_code']));
			$tax = $this->escape_string($this->strip_all($data['tax']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$best_seller = $this->escape_string($this->strip_all($data['best_seller']));
			$amazon_link = $this->escape_string($this->strip_all($data['amazon_link']));

			$description = $this->escape_string($this->strip_selected($data['description'], $allowTags));
			
			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			/*$filename = $_FILES["main_image"]["name"]; 
			$tempname = $_FILES["main_image"]["tmp_name"];  
			$folder = "../images/products/$filename"; 
			if (move_uploaded_file($tempname, $folder))  { 
			$msg = "Image uploaded successfully"; 
			}
			
			$filename1 = $_FILES["image_one"]["name"]; 
			$tempname1 = $_FILES["image_one"]["tmp_name"];  
			$folder1 = "../images/products/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			
			$filename2 = $_FILES["image_two"]["name"]; 
			$tempname2 = $_FILES["image_two"]["tmp_name"];  
			$folder2 = "../images/products/$filename2"; 
			if (move_uploaded_file($tempname2, $folder2))  { 
			$msg = "Image uploaded successfully"; 
			}
			
			$filename3 = $_FILES["image_three"]["name"]; 
			$tempname3 = $_FILES["image_three"]["tmp_name"];  
			$folder3 = "../images/products/$filename3"; 
			if (move_uploaded_file($tempname3, $folder3))  { 
			$msg = "Image uploaded successfully"; 
			}
			
			$filename4 = $_FILES["image_four"]["name"]; 
			$tempname4 = $_FILES["image_four"]["tmp_name"];  
			$folder4 = "../images/products/$filename4"; 
			if (move_uploaded_file($tempname4, $folder))  { 
			$msg = "Image uploaded successfully"; 
			}
			
			$filename5 = $_FILES["image_five"]["name"]; 
			$tempname5 = $_FILES["image_five"]["tmp_name"];  
			$folder5 = "../images/products/$filename5"; 
			if (move_uploaded_file($tempname5, $folder5))  { 
			$msg = "Image uploaded successfully"; 
			} */

			//permaCode
				$prefix	= '';
				$permalink 	= str_shuffle('1234567890');
				$permalink 	= substr($permalink,0,8);
				$permalink 	= $this->generate_id($prefix, $permalink, 'product_master', 'permalink');
			//permaCode::end

			$createdDate = date('Y-m-d H:i:s');
			$sql = "INSERT INTO ".PREFIX."product_master(`amazon_link`,`best_seller`,`product_name`, `product_code`, `hsn_code`, `tax`, `description`,`active`, page_title, meta_keyword, meta_description, `permalink`) VALUES ('".$amazon_link."','".$best_seller."','".$product_name."', '".$product_code."', '".$hsn_code."', '".$tax."','".$description."', '".$active."', '".$page_title."', '".$meta_keyword."', '".$meta_description."', '".$permalink."')";
			$this->query($sql);

			$product_id = $this->last_insert_id();

			$size = $this->escape_string($this->strip_all($data['size']));
			$customer_price = $this->escape_string($this->strip_all($data['customer_price']));
			$customer_discount_price = $this->escape_string($this->strip_all($data['customer_discount_price']));
			$available_qty = $this->escape_string($this->strip_all($data['available_qty']));
			$productcolor = $this->escape_string($this->strip_all($data['productcolor']));
			$weight = $this->escape_string($this->strip_all($data['weight']));
			$features_color = $this->escape_string($this->strip_selected($data['features_color'], $allowTags));

			$features = '';
			if(isset($data['features']) and count($data['features'])>0) {
				$features = implode(',', $data['features']);
			}

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			if(isset($file['image1_color']['name']) && !empty($file['image1_color']['name'])){
				$file_name = strtolower( pathinfo($file['image1_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image1_color = $SaveImage->uploadCroppedImageFileFromForm($file['image1_color'], 1000, $cropData, $imgDir, time().'-1');
			} else {
				$image1_color = '';
			}

			if(isset($file['image2_color']['name']) && !empty($file['image2_color']['name'])){
				$file_name = strtolower( pathinfo($file['image2_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData2']);
				$image2_color = $SaveImage->uploadCroppedImageFileFromForm($file['image2_color'], 1000, $cropData, $imgDir, time().'-2');
			} else {
				$image2_color = '';
			}

			if(isset($file['image3_color']['name']) && !empty($file['image3_color']['name'])){
				$file_name = strtolower( pathinfo($file['image3_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData3']);
				$image3_color = $SaveImage->uploadCroppedImageFileFromForm($file['image3_color'], 1000, $cropData, $imgDir, time().'-3');
			} else {
				$image3_color = '';
			}

			if(isset($file['image4_color']['name']) && !empty($file['image4_color']['name'])){
				$file_name = strtolower( pathinfo($file['image4_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData4']);
				$image4_color = $SaveImage->uploadCroppedImageFileFromForm($file['image4_color'], 1000, $cropData, $imgDir, time().'-4');
			} else {
				$image4_color = '';
			}

			if(isset($file['image5_color']['name']) && !empty($file['image5_color']['name'])){
				$file_name = strtolower( pathinfo($file['image5_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData5']);
				$image5_color = $SaveImage->uploadCroppedImageFileFromForm($file['image5_color'], 1000, $cropData, $imgDir, time().'-5');
			} else {
				$image5_color = '';
			}

			if(isset($file['image6_color']['name']) && !empty($file['image6_color']['name'])){
				$file_name = strtolower( pathinfo($file['image6_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData6']);
				$image6_color = $SaveImage->uploadCroppedImageFileFromForm($file['image6_color'], 1000, $cropData, $imgDir, time().'-6');
			} else {
				$image6_color = '';
			}

			if(isset($file['image7_color']['name']) && !empty($file['image7_color']['name'])){
				$file_name = strtolower( pathinfo($file['image7_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData7']);
				$image7_color = $SaveImage->uploadCroppedImageFileFromForm($file['image7_color'], 1000, $cropData, $imgDir, time().'-7');
			} else {
				$image7_color = '';
			}

			if(isset($file['image8_color']['name']) && !empty($file['image8_color']['name'])){
				$file_name = strtolower( pathinfo($file['image8_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData8']);
				$image8_color = $SaveImage->uploadCroppedImageFileFromForm($file['image8_color'], 1000, $cropData, $imgDir, time().'-8');
			} else {
				$image8_color = '';
			}

			//permaCode
				$prefix	= '';
				$permalink 	= str_shuffle('1234567890');
				$permalink 	= substr($permalink,0,8);
				$permalink 	= $this->generate_id($prefix, $permalink, 'product_sizes', 'permalink');
			//permaCode::end

			$this->query("insert into ".PREFIX."product_sizes(product_id, permalink, size, customer_price, customer_discount_price, available_qty, productcolor, weight, features_color, features, image1_color, image2_color, image3_color, image4_color, image5_color, image6_color, image7_color, image8_color) values ('".$product_id."', '".$permalink."', '".$size."', '".$customer_price."', '".$customer_discount_price."', '".$available_qty."', '".$productcolor."', '".$weight."', '".$features_color."', '".$features."', '".$image1_color."', '".$image2_color."', '".$image3_color."', '".$image4_color."', '".$image5_color."', '".$image6_color."', '".$image7_color."', '".$image8_color."')");
			
			$category_id=0;
			if(isset($data['category']) && sizeof($data['category'])>0){
				foreach ($data['category'] as $category_id) {
					$category_id = $this->escape_string($this->strip_all($category_id));

					$addCat = "INSERT INTO ".PREFIX."product_category_mapping(`category_id`, `product_id`) VALUES ('".$category_id."','".$product_id."')";
					$this->query($addCat);
				}
			}

			if(isset($data['sub_cat']) && sizeof($data['sub_cat'])>0){
				foreach ($data['sub_cat'] as $subcategory_id) {
					$subcategory_id = $this->escape_string($this->strip_all($subcategory_id));
					$addSubCat = "INSERT INTO ".PREFIX."product_subcategory_mapping(`category_id`,`subscategory_id`, `product_id`) VALUES ('".$category_id."','".$subcategory_id."','".$product_id."')";
					$this->query($addSubCat);
				}
			}

			if(isset($data['sub_category_level2']) && sizeof($data['sub_category_level2'])>0){
				foreach ($data['sub_category_level2'] as $subsubcategory_id) {
					$subsubcategory_id = $this->escape_string($this->strip_all($subsubcategory_id));
					$addSubCat = "INSERT INTO ".PREFIX."product_subsubcategory_mapping(`subsubcategory_id`, `product_id`) VALUES ('".$subsubcategory_id ."','".$product_id."')";
					$this->query($addSubCat);
				}
			}

			if(sizeof($data['recommended_product'])>0) {
				foreach($data['recommended_product'] as $key=>$value) {
					$related_products = $this->escape_string($this->strip_all($data['recommended_product'][$key]));
					$this->query("insert into ".PREFIX."products_related_products(product_id, related_product_id) values ('$product_id', '$related_products')");
				}
			}

			foreach($data['filter_name'] as $key=>$value) {
				$filter_name = $this->escape_string($this->strip_all($data['filter_name'][$key]));
				$filter_value = $this->escape_string($this->strip_all($data['filter_value'][$key]));
				$this->query("insert into ".PREFIX."product_attributes (product_id, attribute_feature_id) values ('$product_id', '$filter_value')");
			}
			
			return true;
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

		function updateProduct($data, $file){
			$allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$id = $this->escape_string($this->strip_all($data['id']));

			$product_name = $this->escape_string($this->strip_all($data['product_name']));
			$product_code = $this->escape_string($this->strip_all($data['product_code']));
			$hsn_code = $this->escape_string($this->strip_all($data['hsn_code']));
			$tax = $this->escape_string($this->strip_all($data['tax']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$best_seller = $this->escape_string($this->strip_all($data['best_seller']));
			$amazon_link = $this->escape_string($this->strip_all($data['amazon_link']));
			$description = $this->escape_string($this->strip_selected($data['description'], $allowTags));

			$page_title = $this->escape_string($this->strip_all($data['page_title']));
			$meta_keyword = $this->escape_string($this->strip_all($data['meta_keyword']));
			$meta_description = $this->escape_string($this->strip_all($data['meta_description']));

			$sql = "UPDATE ".PREFIX."product_master SET `amazon_link`='".$amazon_link."',`best_seller`='".$best_seller."',`product_name`='".$product_name."', `product_code`='".$product_code."', `hsn_code`='".$hsn_code."', `tax`='".$tax."', `description`='".$description."', page_title='".$page_title."', meta_keyword='".$meta_keyword."', meta_description='".$meta_description."', `active`='".$active."' WHERE id='".$id."'";
			$this->query($sql);

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';

			$size = $this->escape_string($this->strip_all($data['size']));
			$customer_price = $this->escape_string($this->strip_all($data['customer_price']));
			$customer_discount_price = $this->escape_string($this->strip_all($data['customer_discount_price']));
			$available_qty = $this->escape_string($this->strip_all($data['available_qty']));
			$productcolor = $this->escape_string($this->strip_all($data['productcolor']));
			$weight = $this->escape_string($this->strip_all($data['weight']));
			$features_color = $this->escape_string($this->strip_selected($data['features_color'], $allowTags));

			$productSize = $this->fetch($this->query("select * from ".PREFIX."product_sizes where product_id='".$id."' order by id LIMIT 0,1"));

			if($productSize['available_qty']==0 and $available_qty>0) {
				$sqlnf = "select * from slv_subscription where product_id='$id' and size_id='".$productSize['id']."' order by id DESC";
				$resultsnf = $this->query($sqlnf);
				while($row = $this->fetch($resultsnf)){
					$this->query("update ".PREFIX."subscription set is_notified=1 where id='".$row['id']."'");

					$email = $row['email'];
					$sql_catsm = "select * from slv_product_master where id='$id'";
					$productPermalink = $this->getProductDetailPageURL($id, $productSize['id']);
					$results_catsm = $this->query($sql_catsm);
					$row_catsm = $this->fetch($results_catsm);
					$cc_id=$row_catsm['product_name'];
					$cc_id1=$row_catsm['permalink'];

					$emailObj = new Email();
					$mailBody = "
						<p>
							Dear Valuable Customer
							<br>
							We are happy to notify you that, now <b>".$cc_id." (".$productSize['size']."-".$productSize['productcolor'].")</b> is available in stock
							<br>
							<br>To go to the product click<a href='".BASE_URL."/".$productPermalink."'> here</a>.
						</p>";

					$emailObj->setEmailBody($mailBody);
					$emailObj->setSubject("SELVEL | Product availability notification");
					$emailObj->setAddress($email);
					$res = $emailObj->sendEmail();							
				}
			}

			if(isset($file['image1_color']['name']) && !empty($file['image1_color']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$file_name = strtolower( pathinfo($file['image1_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image1_color'], "large");
				$this->unlinkImage("products", $productSize['image1_color'], "crop");
				$image1_color = $SaveImage->uploadCroppedImageFileFromForm($file['image1_color'], 1000, $cropData, $imgDir, time().'-1');
				$this->query("update ".PREFIX."product_sizes set image1_color='".$image1_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image2_color']['name']) && !empty($file['image2_color']['name'])) {
				$cropData = $this->strip_all($data['cropData2']);
				$file_name = strtolower( pathinfo($file['image2_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image2_color'], "large");
				$this->unlinkImage("products", $productSize['image2_color'], "crop");
				$image2_color = $SaveImage->uploadCroppedImageFileFromForm($file['image2_color'], 1000, $cropData, $imgDir, time().'-2');
				$this->query("update ".PREFIX."product_sizes set image2_color='".$image2_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image3_color']['name']) && !empty($file['image3_color']['name'])) {
				$cropData = $this->strip_all($data['cropData3']);
				$file_name = strtolower( pathinfo($file['image3_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image3_color'], "large");
				$this->unlinkImage("products", $productSize['image3_color'], "crop");
				$image3_color = $SaveImage->uploadCroppedImageFileFromForm($file['image3_color'], 1000, $cropData, $imgDir, time().'-3');
				$this->query("update ".PREFIX."product_sizes set image3_color='".$image3_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image4_color']['name']) && !empty($file['image4_color']['name'])) {
				$cropData = $this->strip_all($data['cropData4']);
				$file_name = strtolower( pathinfo($file['image4_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image4_color'], "large");
				$this->unlinkImage("products", $productSize['image4_color'], "crop");
				$image4_color = $SaveImage->uploadCroppedImageFileFromForm($file['image4_color'], 1000, $cropData, $imgDir, time().'-4');
				$this->query("update ".PREFIX."product_sizes set image4_color='".$image4_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image5_color']['name']) && !empty($file['image5_color']['name'])) {
				$cropData = $this->strip_all($data['cropData5']);
				$file_name = strtolower( pathinfo($file['image5_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image5_color'], "large");
				$this->unlinkImage("products", $productSize['image5_color'], "crop");
				$image5_color = $SaveImage->uploadCroppedImageFileFromForm($file['image5_color'], 1000, $cropData, $imgDir, time().'-5');
				$this->query("update ".PREFIX."product_sizes set image5_color='".$image5_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image6_color']['name']) && !empty($file['image6_color']['name'])) {
				$cropData = $this->strip_all($data['cropData6']);
				$file_name = strtolower( pathinfo($file['image6_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image6_color'], "large");
				$this->unlinkImage("products", $productSize['image6_color'], "crop");
				$image6_color = $SaveImage->uploadCroppedImageFileFromForm($file['image6_color'], 1000, $cropData, $imgDir, time().'-6');
				$this->query("update ".PREFIX."product_sizes set image6_color='".$image6_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image7_color']['name']) && !empty($file['image7_color']['name'])) {
				$cropData = $this->strip_all($data['cropData7']);
				$file_name = strtolower( pathinfo($file['image7_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image7_color'], "large");
				$this->unlinkImage("products", $productSize['image7_color'], "crop");
				$image7_color = $SaveImage->uploadCroppedImageFileFromForm($file['image7_color'], 1000, $cropData, $imgDir, time().'-7');
				$this->query("update ".PREFIX."product_sizes set image7_color='".$image7_color."' where id='".$productSize['id']."'");
			}

			if(isset($file['image8_color']['name']) && !empty($file['image8_color']['name'])) {
				$cropData = $this->strip_all($data['cropData8']);
				$file_name = strtolower( pathinfo($file['image8_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image8_color'], "large");
				$this->unlinkImage("products", $productSize['image8_color'], "crop");
				$image8_color = $SaveImage->uploadCroppedImageFileFromForm($file['image8_color'], 1000, $cropData, $imgDir, time().'-8');
				$this->query("update ".PREFIX."product_sizes set image8_color='".$image8_color."' where id='".$productSize['id']."'");
			}

			$features = '';
			if(isset($data['features']) and count($data['features'])>0) {
				$features = implode(',', $data['features']);
			}

			$this->query("update ".PREFIX."product_sizes set size='".$size."', customer_price='".$customer_price."', customer_discount_price='".$customer_discount_price."', available_qty='".$available_qty."', productcolor='".$productcolor."', weight='".$weight."', features_color='".$features_color."', features='".$features."' where id='".$productSize['id']."'");

			$this->deletefiltersProductId($id);
			if(isset($data['filter_name'])){
				foreach($data['filter_name'] as $key=>$value) {
					$filter_name = $this->escape_string($this->strip_all($data['filter_name'][$key]));
					$filter_value = $this->escape_string($this->strip_all($data['filter_value'][$key]));
					$this->query("insert into ".PREFIX."product_attributes (product_id, attribute_feature_id) values ('".$id."', '".$filter_value."')");
				}
			}

			$this->deleteRelatedProductsByProductId($id);
			if(!empty($data['recommended_product'])){
				foreach($data['recommended_product'] as $key=>$value) {
					$related_products = $this->escape_string($this->strip_all($data['recommended_product'][$key]));
					$this->query("insert into ".PREFIX."products_related_products(product_id, related_product_id) values ('".$id."', '".$related_products."')");
				}
			}
			$category_id=0;
			$this->deleCategoryByProductId($id);			
			if(isset($data['category']) && sizeof($data['category'])>0){
				foreach ($data['category'] as $category_id) {
					$category_id = $this->escape_string($this->strip_all($category_id));
					$addCat = "INSERT INTO ".PREFIX."product_category_mapping(`category_id`, `product_id`) VALUES ('".$category_id."', '".$id."')";
					$this->query($addCat);
				}
			}

			$this->deleSubCategoryByProductId($id);
			if(isset($data['sub_cat']) && sizeof($data['sub_cat'])>0){
				foreach ($data['sub_cat'] as $subcategory_id) {
					$subcategory_id = $this->escape_string($this->strip_all($subcategory_id));

					$addSubCat = "INSERT INTO ".PREFIX."product_subcategory_mapping(`category_id`,`subscategory_id`, `product_id`) VALUES ('".$category_id."','".$subcategory_id."', '".$id."')";
					$this->query($addSubCat);
				}
			}

			$this->deleSubSubCategoryByProductId($id);
			if(isset($data['sub_category_level2']) && sizeof($data['sub_category_level2'])>0){
				foreach ($data['sub_category_level2'] as $subsubcategory_id) {
					$subsubcategory_id = $this->escape_string($this->strip_all($subsubcategory_id));
					$addSubsubCat = "INSERT INTO ".PREFIX."product_subsubcategory_mapping(`subsubcategory_id`, `product_id`) VALUES ('".$subsubcategory_id ."', '".$id."')";
					$this->query($addSubsubCat);
				}
			}

			return true;
		}

		function getProductRelatedProductsInArray($product_id) {
			$product_id = $this->escape_string($this->strip_all($product_id));
			$query = "select * from ".PREFIX."products_related_products where product_id='$product_id'";
			$sql = $this->query($query);
			$recommended_array = array();
			while($result = $this->fetch($sql)) {
				array_push($recommended_array,$result['related_product_id']);
			}
			return $recommended_array;
		}

		function getProductFilterValueByFilterId($attribute_id,$productID){
			//echo $attribute_id." ".$productID;
			$attributeArr = array();
			$sql = "SELECT * FROM ".PREFIX."product_attributes WHERE `product_id`='".$productID."'";
			$result = $this->query($sql);
			while($productAttr = $this->fetch($result)){
				$attributeArr[] = $productAttr['attribute_feature_id'] ;
			}
			return $attributeArr;

		}

		function deleteProduct($id) {
			$id = $this->escape_string($this->strip_all($id));

			$Detail = $this->getUniqueProductById($id);
			$this->unlinkImage("products", $Detail['main_image'], "large");
			$this->unlinkImage("products", $Detail['main_image'], "crop");
			$this->unlinkImage("products", $Detail['image_one'], "large");
			$this->unlinkImage("products", $Detail['image_one'], "crop");
			$this->unlinkImage("products", $Detail['image_two'], "large");
			$this->unlinkImage("products", $Detail['image_two'], "crop");
			$this->unlinkImage("products", $Detail['image_three'], "large");
			$this->unlinkImage("products", $Detail['image_three'], "crop");
			$this->unlinkImage("products", $Detail['image_four'], "large");
			$this->unlinkImage("products", $Detail['image_four'], "crop");

			$query = "delete from ".PREFIX."product_master WHERE id='".$id."'";
			$this->query($query);

			$this->deletefiltersProductId($id);
			$this->deleteRelatedProductsByProductId($id);
			$this->deleCategoryByProductId($id);
			$this->deleSubCategoryByProductId($id);
			$this->deleSubSubCategoryByProductId($id);

			return true;
		}

		function deleCategoryByProductId($product_id){
			$product_id = $this->escape_string($this->strip_all($product_id));
			$sql = "DELETE FROM ".PREFIX."product_category_mapping WHERE `product_id`='".$product_id."'";
			$this->query($sql);
		}

		function deleSubCategoryByProductId($product_id){
			$product_id = $this->escape_string($this->strip_all($product_id));
			$sql = "DELETE FROM ".PREFIX."product_subcategory_mapping WHERE `product_id`='".$product_id."'";
			$this->query($sql);
		}

		function deleSubSubCategoryByProductId($product_id){
			$product_id = $this->escape_string($this->strip_all($product_id));
			$sql = "DELETE FROM ".PREFIX."product_subsubcategory_mapping WHERE `product_id`='".$product_id."'";
			$this->query($sql);
		}

		function deleteRelatedProductsByProductId($product_id) {
			$product_id = $this->escape_string($this->strip_all($product_id));
			$this->query("delete from ".PREFIX."products_related_products where product_id='$product_id'");
		}

		function deletefiltersProductId($productId){
			$productId = $this->escape_string($this->strip_all($productId));
			$sql = "DELETE FROM ".PREFIX."product_attributes WHERE `product_id`='".$productId."'";
			//echo $sql;
			$this->query($sql);
		}

		
		function getProductSizeDataById($id) {
			$query = "select * from ".PREFIX."product_sizes where product_id = '".$id."' ";
			return $this->query($query);
		}
		
		function getProductattributeDataById($id) {
			$query = "select * from ".PREFIX."product_attributes where product_id = '".$id."' ";
			return $this->query($query);
		}
		
		/* === PRODUCT END === */

		/* === PRODUCT VARIANT STARTS === */
		
		function getUniqueProductVariantById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."product_sizes where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addProductVariant($data, $file) {
			$allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$product_id = $this->escape_string($this->strip_all($data['product_id']));

			$size = $this->escape_string($this->strip_all($data['size']));
			$customer_price = $this->escape_string($this->strip_all($data['customer_price']));
			$customer_discount_price = $this->escape_string($this->strip_all($data['customer_discount_price']));
			$available_qty = $this->escape_string($this->strip_all($data['available_qty']));
			$productcolor = $this->escape_string($this->strip_all($data['productcolor']));
			$weight = $this->escape_string($this->strip_all($data['weight']));
			$features_color = $this->escape_string($this->strip_selected($data['features_color'], $allowTags));

			$features = '';
			if(isset($data['features']) and count($data['features'])>0) {
				$features = implode(',', $data['features']);
			}

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			if(isset($file['image1_color']['name']) && !empty($file['image1_color']['name'])){
				$file_name = strtolower( pathinfo($file['image1_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image1_color = $SaveImage->uploadCroppedImageFileFromForm($file['image1_color'], 1000, $cropData, $imgDir, time().'-1');
			} else {
				$image1_color = '';
			}

			if(isset($file['image2_color']['name']) && !empty($file['image2_color']['name'])){
				$file_name = strtolower( pathinfo($file['image2_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData2']);
				$image2_color = $SaveImage->uploadCroppedImageFileFromForm($file['image2_color'], 1000, $cropData, $imgDir, time().'-2');
			} else {
				$image2_color = '';
			}

			if(isset($file['image3_color']['name']) && !empty($file['image3_color']['name'])){
				$file_name = strtolower( pathinfo($file['image3_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData3']);
				$image3_color = $SaveImage->uploadCroppedImageFileFromForm($file['image3_color'], 1000, $cropData, $imgDir, time().'-3');
			} else {
				$image3_color = '';
			}

			if(isset($file['image4_color']['name']) && !empty($file['image4_color']['name'])){
				$file_name = strtolower( pathinfo($file['image4_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData4']);
				$image4_color = $SaveImage->uploadCroppedImageFileFromForm($file['image4_color'], 1000, $cropData, $imgDir, time().'-4');
			} else {
				$image4_color = '';
			}

			if(isset($file['image5_color']['name']) && !empty($file['image5_color']['name'])){
				$file_name = strtolower( pathinfo($file['image5_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData5']);
				$image5_color = $SaveImage->uploadCroppedImageFileFromForm($file['image5_color'], 1000, $cropData, $imgDir, time().'-5');
			} else {
				$image5_color = '';
			}

			if(isset($file['image6_color']['name']) && !empty($file['image6_color']['name'])){
				$file_name = strtolower( pathinfo($file['image6_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData6']);
				$image6_color = $SaveImage->uploadCroppedImageFileFromForm($file['image6_color'], 1000, $cropData, $imgDir, time().'-6');
			} else {
				$image6_color = '';
			}

			if(isset($file['image7_color']['name']) && !empty($file['image7_color']['name'])){
				$file_name = strtolower( pathinfo($file['image7_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData7']);
				$image7_color = $SaveImage->uploadCroppedImageFileFromForm($file['image7_color'], 1000, $cropData, $imgDir, time().'-7');
			} else {
				$image7_color = '';
			}

			if(isset($file['image8_color']['name']) && !empty($file['image8_color']['name'])){
				$file_name = strtolower( pathinfo($file['image8_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData8']);
				$image8_color = $SaveImage->uploadCroppedImageFileFromForm($file['image8_color'], 1000, $cropData, $imgDir, time().'-8');
			} else {
				$image8_color = '';
			}

			//permaCode
				$prefix	= '';
				$permalink 	= str_shuffle('1234567890');
				$permalink 	= substr($permalink,0,8);
				$permalink 	= $this->generate_id($prefix, $permalink, 'product_sizes', 'permalink');
			//permaCode::end

			$this->query("insert into ".PREFIX."product_sizes(product_id, permalink, size, customer_price, customer_discount_price, available_qty, productcolor, weight, features_color, features, image1_color, image2_color, image3_color, image4_color, image5_color, image6_color, image7_color, image8_color) values ('".$product_id."', '".$permalink."', '".$size."', '".$customer_price."', '".$customer_discount_price."', '".$available_qty."', '".$productcolor."', '".$weight."', '".$features_color."', '".$features."', '".$image1_color."', '".$image2_color."', '".$image3_color."', '".$image4_color."', '".$image5_color."', '".$image6_color."', '".$image7_color."', '".$image8_color."')");

			return true;
		}

		function updateProductVariant($data, $file) {
			$allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$product_id = $this->escape_string($this->strip_all($data['product_id']));

			$size = $this->escape_string($this->strip_all($data['size']));
			$customer_price = $this->escape_string($this->strip_all($data['customer_price']));
			$customer_discount_price = $this->escape_string($this->strip_all($data['customer_discount_price']));
			$available_qty = $this->escape_string($this->strip_all($data['available_qty']));
			$productcolor = $this->escape_string($this->strip_all($data['productcolor']));
			$weight = $this->escape_string($this->strip_all($data['weight']));
			$features_color = $this->escape_string($this->strip_selected($data['features_color'], $allowTags));

			$features = '';
			if(isset($data['features']) and count($data['features'])>0) {
				$features = implode(',', $data['features']);
			}

			$id = $this->escape_string($this->strip_all($data['id']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			
			$productSize = $this->getUniqueProductVariantById($id);
			if($productSize['available_qty']==0 and $available_qty>0) {
				$sqlnf = "select * from slv_subscription where product_id='".$productSize['product_id']."' and size_id='".$productSize['id']."' order by id DESC";
				$resultsnf = $this->query($sqlnf);
				while($row = $this->fetch($resultsnf)){
					$this->query("update ".PREFIX."subscription set is_notified=1 where id='".$row['id']."'");

					$email = $row['email'];
					$sql_catsm = "select * from slv_product_master where id='".$productSize['product_id']."'";
					$productPermalink = $this->getProductDetailPageURL($id, $productSize['id']);
					$results_catsm = $this->query($sql_catsm);
					$row_catsm = $this->fetch($results_catsm);
					$cc_id=$row_catsm['product_name'];
					$cc_id1=$row_catsm['permalink'];

					$emailObj = new Email();
					$mailBody = "
						<p>
							Dear Valuable Customer
							<br>
							We are happy to notify you that, now <b>".$cc_id."</b> is available in stock
							<br>
							<br>To go to the product click<a href='".BASE_URL."/".$productPermalink."'> here</a>.
						</p>";

					$emailObj->setEmailBody($mailBody);
					$emailObj->setSubject("SELVEL | Product availability notification");
					$emailObj->setAddress($email);
					$res = $emailObj->sendEmail();							
				}
			}

			if(isset($file['image1_color']['name']) && !empty($file['image1_color']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$file_name = strtolower( pathinfo($file['image1_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image1_color'], "large");
				$this->unlinkImage("products", $productSize['image1_color'], "crop");
				$image1_color = $SaveImage->uploadCroppedImageFileFromForm($file['image1_color'], 1000, $cropData, $imgDir, time().'-1');
				$this->query("update ".PREFIX."product_sizes set image1_color='".$image1_color."' where id='".$id."'");
			}

			if(isset($file['image2_color']['name']) && !empty($file['image2_color']['name'])) {
				$cropData = $this->strip_all($data['cropData2']);
				$file_name = strtolower( pathinfo($file['image2_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image2_color'], "large");
				$this->unlinkImage("products", $productSize['image2_color'], "crop");
				$image2_color = $SaveImage->uploadCroppedImageFileFromForm($file['image2_color'], 1000, $cropData, $imgDir, time().'-2');
				$this->query("update ".PREFIX."product_sizes set image2_color='".$image2_color."' where id='".$id."'");
			}

			if(isset($file['image3_color']['name']) && !empty($file['image3_color']['name'])) {
				$cropData = $this->strip_all($data['cropData3']);
				$file_name = strtolower( pathinfo($file['image3_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image3_color'], "large");
				$this->unlinkImage("products", $productSize['image3_color'], "crop");
				$image3_color = $SaveImage->uploadCroppedImageFileFromForm($file['image3_color'], 1000, $cropData, $imgDir, time().'-3');
				$this->query("update ".PREFIX."product_sizes set image3_color='".$image3_color."' where id='".$id."'");
			}

			if(isset($file['image4_color']['name']) && !empty($file['image4_color']['name'])) {
				$cropData = $this->strip_all($data['cropData4']);
				$file_name = strtolower( pathinfo($file['image4_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image4_color'], "large");
				$this->unlinkImage("products", $productSize['image4_color'], "crop");
				$image4_color = $SaveImage->uploadCroppedImageFileFromForm($file['image4_color'], 1000, $cropData, $imgDir, time().'-4');
				$this->query("update ".PREFIX."product_sizes set image4_color='".$image4_color."' where id='".$id."'");
			}

			if(isset($file['image5_color']['name']) && !empty($file['image5_color']['name'])) {
				$cropData = $this->strip_all($data['cropData5']);
				$file_name = strtolower( pathinfo($file['image5_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image5_color'], "large");
				$this->unlinkImage("products", $productSize['image5_color'], "crop");
				$image5_color = $SaveImage->uploadCroppedImageFileFromForm($file['image5_color'], 1000, $cropData, $imgDir, time().'-5');
				$this->query("update ".PREFIX."product_sizes set image5_color='".$image5_color."' where id='".$id."'");
			}

			if(isset($file['image6_color']['name']) && !empty($file['image6_color']['name'])) {
				$cropData = $this->strip_all($data['cropData6']);
				$file_name = strtolower( pathinfo($file['image6_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image6_color'], "large");
				$this->unlinkImage("products", $productSize['image6_color'], "crop");
				$image6_color = $SaveImage->uploadCroppedImageFileFromForm($file['image6_color'], 1000, $cropData, $imgDir, time().'-6');
				$this->query("update ".PREFIX."product_sizes set image6_color='".$image6_color."' where id='".$id."'");
			}

			if(isset($file['image7_color']['name']) && !empty($file['image7_color']['name'])) {
				$cropData = $this->strip_all($data['cropData7']);
				$file_name = strtolower( pathinfo($file['image7_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image7_color'], "large");
				$this->unlinkImage("products", $productSize['image7_color'], "crop");
				$image7_color = $SaveImage->uploadCroppedImageFileFromForm($file['image7_color'], 1000, $cropData, $imgDir, time().'-7');
				$this->query("update ".PREFIX."product_sizes set image7_color='".$image7_color."' where id='".$id."'");
			}

			if(isset($file['image8_color']['name']) && !empty($file['image8_color']['name'])) {
				$cropData = $this->strip_all($data['cropData8']);
				$file_name = strtolower( pathinfo($file['image8_color']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $productSize['image8_color'], "large");
				$this->unlinkImage("products", $productSize['image8_color'], "crop");
				$image8_color = $SaveImage->uploadCroppedImageFileFromForm($file['image8_color'], 1000, $cropData, $imgDir, time().'-8');
				$this->query("update ".PREFIX."product_sizes set image8_color='".$image8_color."' where id='".$id."'");
			}

			$this->query("update ".PREFIX."product_sizes set size='".$size."', customer_price='".$customer_price."', customer_discount_price='".$customer_discount_price."', available_qty='".$available_qty."', productcolor='".$productcolor."', weight='".$weight."', features_color='".$features_color."', features='".$features."' where id='".$id."'");

			return true;
		}

		function deleteProductVariant($id) {
			$id = $this->escape_string($this->strip_all($id));

			$productSize = $this->getUniqueProductVariantById($id);

			$this->unlinkImage("products", $productSize['image1_color'], "large");
			$this->unlinkImage("products", $productSize['image1_color'], "crop");
			$this->unlinkImage("products", $productSize['image2_color'], "large");
			$this->unlinkImage("products", $productSize['image2_color'], "crop");
			$this->unlinkImage("products", $productSize['image3_color'], "large");
			$this->unlinkImage("products", $productSize['image3_color'], "crop");
			$this->unlinkImage("products", $productSize['image4_color'], "large");
			$this->unlinkImage("products", $productSize['image4_color'], "crop");
			$this->unlinkImage("products", $productSize['image5_color'], "large");
			$this->unlinkImage("products", $productSize['image5_color'], "crop");
			$this->unlinkImage("products", $productSize['image6_color'], "large");
			$this->unlinkImage("products", $productSize['image6_color'], "crop");
			$this->unlinkImage("products", $productSize['image7_color'], "large");
			$this->unlinkImage("products", $productSize['image7_color'], "crop");
			$this->unlinkImage("products", $productSize['image8_color'], "large");
			$this->unlinkImage("products", $productSize['image8_color'], "crop");

			$query = "delete from ".PREFIX."product_sizes WHERE id='".$id."'";
			$this->query($query);

			
			return true;
		}

		/* === PRODUCT VARIANT END === */

		/* === FEATURE STARTS === */
		
		function getUniqueFeatureById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."features_master where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addFeature($data, $file) {
			$feature = $this->escape_string($this->strip_all($data['feature']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 100, $cropData, $imgDir, time().'-1');
			} else {
				$image_name = '';
			}

			$this->query("insert into ".PREFIX."features_master(image_name, feature) values ('".$image_name."', '".$feature."')");

			return true;
		}

		function updateFeature($data, $file) {
			$allowTags = "<strong><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$feature = $this->escape_string($this->strip_all($data['feature']));

			$id = $this->escape_string($this->strip_all($data['id']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';

			$Detail = $this->getUniqueFeatureById($id);
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("products", $Detail['image_name'], "large");
				$this->unlinkImage("products", $Detail['image_name'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 100, $cropData, $imgDir, time().'-1');

				$this->query("update ".PREFIX."features_master set image_name='".$image_name."' where id='".$id."'");
			}

			$this->query("update ".PREFIX."features_master set feature='".$feature."' where id='".$id."'");

			return true;
		}

		function deleteFeature($id) {
			$id = $this->escape_string($this->strip_all($id));

			$Detail = $this->getUniqueFeatureById($id);

			$this->unlinkImage("products", $Detail['image_name'], "large");
			$this->unlinkImage("products", $Detail['image_name'], "crop");

			$query = "delete from ".PREFIX."features_master WHERE id='".$id."'";
			$this->query($query);

			
			return true;
		}

		/* === PRODUCT VARIANT END === */

		/* === CUSTOMER STARTS === */
		function addCustomer($data, $file) {
			$first_name = $this->escape_string($this->strip_all($data['first_name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$mobile = $this->escape_string($this->strip_all($data['mobile']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$password = $this->escape_string($this->strip_all($data['password']));
			$user_verified = 1;
			$is_email_verified = 1;

			$passwordHash = password_hash($password, PASSWORD_DEFAULT);

			$query = "insert into ".PREFIX."customers(first_name, mobile, email, password, active, is_email_verified, user_verified) values ('".$first_name."', '".$mobile."', '".$email."', '".$passwordHash."', '".$is_email_verified."', '".$user_verified."')";

			$this->query($query);
		}

		function getUniqueCustomerById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."customers where id = '".$id."' ";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateCustomer($data, $file) {
			$first_name = $this->escape_string($this->strip_all($data['first_name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$mobile = $this->escape_string($this->strip_all($data['mobile']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$password = $this->escape_string($this->strip_all($data['password']));

			$id = $this->escape_string($this->strip_all($data['id']));

			if(!empty($password)) {
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);

				$this->query("update ".PREFIX."customers set password='".$passwordHash."' where id='".$id."'");
			}

			$this->query("update ".PREFIX."customers set first_name='".$first_name."', email='".$email."', mobile='".$mobile."', active='".$active."' where id='".$id."'");

			return true;
		}

		function deleteCustomer($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."customers where id='".$id."'";
			$this->query($query);
		}

		function getListOfStates(){
			$query = "select name as statename from ".PREFIX."states order by name asc";
			return $this->query($query);
		}

		function getUniqueCustomerAddressById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."customers_address where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addCustomerAddress($data, $file){
			$customerId = $this->escape_string($this->strip_all($data['customer_id']));
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

		function updateCustomerAddress($data, $file){
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
			$this->query($query);

			return true;
		}

		function deleteCustomerAddress($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."customers_address where id='".$id."'";
			$this->query($query);
		}

		/* === CUSTOMER ENDS === */

		/* === ORDER STARTS === */
		function getProductOrderDetails($txnId){
			$query = "select * from ".PREFIX."order where txn_id='".$txnId."'";
			$orderRS = $this->query($query);
			if($orderRS->num_rows>0){ // order with txn_id found
				$transactionArr = array();
				$orderDetails = $this->fetch($orderRS);

				$transactionArr['order'] = $orderDetails;
				$transactionArr['orderDetails'] = array();

				$query = "select * from ".PREFIX."order_details where order_id='".$orderDetails['id']."' and customer_id='".$orderDetails['customer_id']."'";
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

		function getCustomerPurchaseAmount($txn_id){
			$txn_id = $this->escape_string($this->strip_all($txn_id));
			$purchaseDetails = $this->getProductOrderDetails($txn_id);
			if($purchaseDetails){
				$order = $purchaseDetails['order'];
				$orderDetails = $purchaseDetails['orderDetails'];
				$subTotal = 0;
				$finalTotal = 0;

				foreach($orderDetails as $oneOrder){
					$productDetails = $this->getUniqueProductById($oneOrder['product_id']);
					$quantity = $oneOrder['quantity'];

					$unitPrice = $oneOrder['customer_price'];
					$unitDiscountedPrice = $oneOrder['customer_discount_price'];

					if(!empty($unitDiscountedPrice)){
						$totalPrice = $quantity * $unitDiscountedPrice;
					} else {
						$totalPrice = $quantity * $unitPrice;
					}
					$tax = $oneOrder['gst_rate'];
					$taxAmount = $totalPrice * ($tax/100);
					$totalPrice = $totalPrice + $taxAmount;
					$subTotal += $totalPrice;
				}

				// CHECK IF DISCOUNT COUPON IS USED
				$couponDiscountAmount = $this->getRedeemedCouponAmount($order['customer_id'], $order['id']);
				if(!empty($couponDiscountAmount)){
					$finalTotal = $subTotal - $couponDiscountAmount;
				} else {
					$finalTotal = $subTotal;
				}
				// CHECK IF DISCOUNT COUPON IS USED

				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL
				if(!empty($order['shipping_charges'])){
					$finalTotal += $order['shipping_charges'];
				}
				// APPLY SHIPPING CHARGE ON UPDATED SUBTOTAL 

				// INCREMENT CUSTOMER PURCHASE AMOUNT
				return $finalTotal;
			}else{
				return -1;
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

		function updateProductOrderDetails($data){
			$txnId = $this->escape_string($this->strip_all($data['txnId']));
			$orderStatus = $this->escape_string($this->strip_all($data['orderStatus']));
			$paymentStatus = $this->escape_string($this->strip_all($data['paymentStatus']));
			
			if(empty($orderStatus)){
				$orderStatus = 'NULL';
			} else {
				$orderStatus = "'".$orderStatus."'";
			}
			$orderRemark = $this->escape_string($this->strip_all($data['orderRemark']));

			$query = "update ".PREFIX."order set payment_status='".$paymentStatus."', order_status=".$orderStatus.", order_remark='".$orderRemark."' where txn_id='".$txnId."'";
			$this->query($query);
		}

		function getOrderbyId($orderId){
			$orderId = $this->escape_string($this->strip_all($orderId));
			$sql = "SELECT * FROM ".PREFIX."order WHERE `id`='".$orderId."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		function getOrderDetailsbyId($orderId){
			$orderId = $this->escape_string($this->strip_all($orderId));
			$sql = "SELECT * FROM ".PREFIX."order_details WHERE `id`='".$orderId."'";
			$result = $this->query($sql);
			return $this->fetch($result);
		}

		/* === ORDER ENDS === */

		/* === TESTIMONIAL STARTS === */
		function getUniqueTestimonialById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."testimonials where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function getAllTestimonials() {
			$query = "select * from ".PREFIX."testimonials";
			$sql = $this->query($query);
			return $sql;
		}

		function addTestimonial($data,$file){
			$name = $this->escape_string($this->strip_all($data['name']));
			$testimonial = $this->escape_string($this->strip_all($data['testimonial']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$query = "insert into ".PREFIX."testimonials(name, testimonial, active) values ('".$name."', '".$testimonial."', '".$active."')";
			return $this->query($query);
		}

		function updateTestimonial($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$location = $this->escape_string($this->strip_all($data['location']));
			$testimonial = $this->escape_string($this->strip_all($data['testimonial']));
			$active = $this->escape_string($this->strip_all($data['active']));
			
			$query = "update ".PREFIX."testimonials set name='".$name."', testimonial='".$testimonial."', active='".$active."',location='".$location."' where id='".$id."'";
			return $this->query($query);
		}

		function deleteTestimonial($id) {
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."testimonials where id='".$id."'";
			$this->query($query);
		}

		/* === TESTIMONIAL ENDS === */

		/* === DELIVERY PINCODE STARTS === */
		function getUniqueDeliveryPincodeById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."pincode where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addDeliveryPincode($data,$file){
			$pincode = $this->escape_string($this->strip_all($data['pincode']));

			$query = "insert into ".PREFIX."pincode(pincode) values ('".$pincode."')";
			return $this->query($query);
		}

		function updateDeliveryPincode($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$pincode = $this->escape_string($this->strip_all($data['pincode']));
			
			$query = "update ".PREFIX."pincode set pincode='".$pincode."' where id='".$id."'";
			return $this->query($query);
		}

		function deleteDeliveryPincode($id) {
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."pincode where id='".$id."'";
			$this->query($query);
		}

		/* === DELIVERY PINCODE ENDS === */

		/* === REVIEW STARTS === */
		function getUniqueReviewById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."reviews where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateReviews($data,$files) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$product_id = $this->escape_string($this->strip_all($data['product_id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$rating = $this->escape_string($this->strip_all($data['rating']));
			$review = $this->escape_string($this->strip_all($data['review']));

			$active = $this->escape_string($this->strip_all($data['active']));

			$query = "update ".PREFIX."reviews set name='".$name."', email='".$email."', review='".$review."', rating='".$rating."', active='".$active."' where id='".$id."'";
			$result = $this->query($query);

			$query = "select AVG(rating) as all_rating  from ".PREFIX."reviews where product_id='".$product_id."' and active='1'";
			$sql = $this->query($query);
			$results =$this->fetch($sql);
			
			$query_avg = "update ".PREFIX."product_master set avg_rating='".$results['all_rating']."' where id='".$product_id."'";
			$this->query($query_avg);

			return $result;
			
		}

		function deleteReview($id){
			$id = $this->escape_string($this->strip_all($id));

			$details = $this->getUniqueReviewById($id);
			$sql = "DELETE FROM ".PREFIX."reviews WHERE id = '".$id."'";
			$this->query($sql);

			$query = "select AVG(rating) as all_rating  from ".PREFIX."reviews where product_id='".$details['product_id']."' and active='1'";
			$sql = $this->query($query);
			$results =$this->fetch($sql);
			
			$query_avg = "update ".PREFIX."product_master set avg_rating='".$results['all_rating']."' where id='".$details['product_id']."'";
			$this->query($query_avg);

		}
		/* === REVIEW ENDS === */

		/* === CMS START === */
		function updateCMS($data, $fieldName) {
			$content = $this->escape_string($this->strip_selected($data['content'], $this->allowTags));

			$sql = $this->query("select * from ".PREFIX."cms_master");
			if($this->num_rows($sql)>0) {
				$query = "update ".PREFIX."cms_master set ".$fieldName."='".$content."'";
			} else {
				$query = "insert into ".PREFIX."cms_master (".$fieldName.") values ('".$content."')";
			}
			return $this->query($query);
		}
		
		function updatewhyselvel($data, $description1) 
		{
			
			$heading = $this->escape_string($this->strip_selected($data['heading'], $this->allowTags));
			$tag_line = $this->escape_string($this->strip_selected($data['tag_line'], $this->allowTags));
			$description = $this->escape_string($this->strip_selected($data['description'], $this->allowTags));
			
			$filename = $_FILES["main_image"]["name"]; 
			if($filename!=''){
			$filename = $_FILES["main_image"]["name"]; 
			$tempname = $_FILES["main_image"]["tmp_name"];  
			$folder = "../images/why-selvel/$filename"; 
			if (move_uploaded_file($tempname, $folder))  { 
			$msg = "Image uploaded successfully"; 
			}
			$queryss = "update ".PREFIX."why_selvel_home set main_image='".$filename."'";
			$this->query($queryss);
			//exit();
			}
			

			$sql = $this->query("select * from ".PREFIX."why_selvel_home");
			if($this->num_rows($sql)>0) 
			{
				$query = "update ".PREFIX."why_selvel_home set heading='".$heading."',tag_line='".$tag_line."',description='".$description."'";
			} 
			else 
			{
				$query = "insert into ".PREFIX."why_selvel_home (heading,tag_line,description,main_image) values ('".$heading."','".$tag_line."','".$description."','".$filename."')";
			}
			return $this->query($query);
		}
		function updatereviewsmaster($data, $description1) 
		{
			$heading = $this->escape_string($this->strip_selected($data['heading'], $this->allowTags));
			$description = $this->escape_string($this->strip_selected($data['description'], $this->allowTags));
			$name = $this->escape_string($this->strip_selected($data['name'], $this->allowTags));
			
			$review  = $this->escape_string($this->strip_selected($data['review'], $this->allowTags));
			$profile = $this->escape_string($this->strip_selected($data['profile'], $this->allowTags));
			
			
			$filename = $_FILES["banner"]["name"]; 
			if($filename!=''){
			$filename = $_FILES["banner"]["name"]; 
			$tempname = $_FILES["banner"]["tmp_name"];  
			$folder = "../images/review/$filename"; 
			if (move_uploaded_file($tempname, $folder))  { 
			$msg = "Image uploaded successfully"; 
			}
			$query1 = "update ".PREFIX."reviews_master set banner='".$filename."'";
			$this->query($query1);
			}
			//exit();
			
			

			$sql = $this->query("select * from ".PREFIX."reviews_master");
			if($this->num_rows($sql)>0) 
			{
				$query = "update ".PREFIX."reviews_master set heading='".$heading."',description='".$description."'";
			} 
			else 
			{
				$query = "insert into ".PREFIX."reviews_master (heading,description) values ('".$heading."','".$description."')";
			}
			return $this->query($query);
		}
		function updatewhyselvelmain($data, $heading1) 
		{
			$heading = $this->escape_string($this->strip_selected($data['heading'], $this->allowTags));
			$para1 = $this->escape_string($this->strip_selected($data['para1'], $this->allowTags));
			$para2 = $this->escape_string($this->strip_selected($data['para2'], $this->allowTags));
			$para3 = $this->escape_string($this->strip_selected($data['para3'], $this->allowTags));
			
			$heading2 = $this->escape_string($this->strip_selected($data['heading2'], $this->allowTags));
			$strongest1 = $this->escape_string($this->strip_selected($data['strongest1'], $this->allowTags));
			$strongest2 = $this->escape_string($this->strip_selected($data['strongest2'], $this->allowTags));
			$strongest3 = $this->escape_string($this->strip_selected($data['strongest3'], $this->allowTags));
			$strongest4 = $this->escape_string($this->strip_selected($data['strongest4'], $this->allowTags));
			
			$heading3 = $this->escape_string($this->strip_selected($data['heading3'], $this->allowTags));		
			$choose1 = $this->escape_string($this->strip_selected($data['choose1'], $this->allowTags));		
			$choose2 = $this->escape_string($this->strip_selected($data['choose2'], $this->allowTags));		
			$choose3 = $this->escape_string($this->strip_selected($data['choose3'], $this->allowTags));	

			$history_heading = $this->escape_string($this->strip_selected($data['history_heading'], $this->allowTags));	
			
			$history_para = $this->escape_string($this->strip_selected($data['history_para'], $this->allowTags));	
			
			$filename = $_FILES["image"]["name"]; 
			$filename1 = $_FILES["image1"]["name"]; 
			$filename2 = $_FILES["image2"]["name"]; 
			$filename3 = $_FILES["image3"]["name"]; 
			$filename4 = $_FILES["image4"]["name"]; 
			$filename5 = $_FILES["image5"]["name"]; 
			$filename6 = $_FILES["image6"]["name"]; 
			$filename7 = $_FILES["image7"]["name"]; 
			$filename8 = $_FILES["history_image"]["name"]; 
			
			if($filename!='')
			{
				//echo "sneha";	
				$filename = $_FILES["image"]["name"]; 
				$tempname = $_FILES["image"]["tmp_name"];  
				$folder = "../images/why-selvel/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
					$query1 = "update ".PREFIX."why_selvel set image='".$filename."'";
					$this->query($query1);
			}
			//exit();
			if($filename1!='')
			{
				$filename1 = $_FILES["image1"]["name"]; 
				$tempname1 = $_FILES["image1"]["tmp_name"];  
				$folder1 = "../images/why-selvel/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query2 = "update ".PREFIX."why_selvel set image1='".$filename1."'";
				$this->query($query2);
			}
			if($filename2!='')
			{
				$filename2 = $_FILES["image2"]["name"]; 
				$tempname2 = $_FILES["image2"]["tmp_name"];  
				$folder2 = "../images/why-selvel/$filename2"; 
				if (move_uploaded_file($tempname2, $folder2))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query3 = "update ".PREFIX."why_selvel set image2='".$filename2."'";
				$this->query($query3);			
			}
			if($filename3!='')
			{
				$filename3 = $_FILES["image3"]["name"]; 
				$tempname3 = $_FILES["image3"]["tmp_name"];  
				$folder3 = "../images/why-selvel/$filename3"; 
				if (move_uploaded_file($tempname3, $folder3))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query4 = "update ".PREFIX."why_selvel set image3='".$filename3."'";
				$this->query($query4);			
			}
			if($filename4!='')
			{
				$filename4 = $_FILES["image4"]["name"]; 
				$tempname4 = $_FILES["image4"]["tmp_name"];  
				$folder4 = "../images/why-selvel/$filename4"; 
				if (move_uploaded_file($tempname4, $folder4))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query5 = "update ".PREFIX."why_selvel set image4='".$filename4."'";
				$this->query($query5);			
			}
			if($filename5!='')
			{
				$filename5 = $_FILES["image5"]["name"]; 
				$tempname5 = $_FILES["image5"]["tmp_name"];  
				$folder5 = "../images/why-selvel/$filename5"; 
				if (move_uploaded_file($tempname5, $folder5))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query6 = "update ".PREFIX."why_selvel set image5='".$filename5."'";
				$this->query($query6);			
			}
			if($filename6!='')
			{
				$filename6 = $_FILES["image6"]["name"]; 
				$tempname6 = $_FILES["image6"]["tmp_name"];  
				$folder6 = "../images/why-selvel/$filename6"; 
				if (move_uploaded_file($tempname6, $folder6))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query7 = "update ".PREFIX."why_selvel set image6='".$filename6."'";
				$this->query($query7);			
			}
			if($filename7!='')
			{
				$filename7 = $_FILES["image7"]["name"]; 
				$tempname7= $_FILES["image7"]["tmp_name"];  
				$folder7 = "../images/why-selvel/$filename7"; 
				if (move_uploaded_file($tempname7, $folder7))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query8 = "update ".PREFIX."why_selvel set image7='".$filename7."'";
				$this->query($query8);			
			}
			if($filename8!='')
			{
				$filename8 = $_FILES["history_image"]["name"]; 
				$tempname8= $_FILES["history_image"]["tmp_name"];  
				$folder8 = "../images/why-selvel/$filename8"; 
				if (move_uploaded_file($tempname8, $folder8))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query9 = "update ".PREFIX."why_selvel set history_image='".$filename8."'";
				$this->query($query9);			
			}
			$sql = $this->query("select * from ".PREFIX."why_selvel");
			if($this->num_rows($sql)>0) 
			{
				$query = "update ".PREFIX."why_selvel set heading='".$heading."',para1='".$para1."',para2='".$para2."',para3='".$para3."',heading2='".$heading2."',strongest1='".$strongest1."',strongest2='".$strongest2."',strongest3='".$strongest3."',strongest4='".$strongest4."',heading3='".$heading3."',choose1='".$choose1."',choose2='".$choose2."',choose3='".$choose3."',history_heading='".$history_heading."',history_para='".$history_para."'";
			} 
			else 
			{
				$query = "insert into ".PREFIX."why_selvel (heading,para1,para2,para3,heading2,strongest1,strongest2,strongest3,strongest4,heading3,choose1,choose2,choose3,history_heading,history_para) values ('".$heading."','".$para1."','".$para2."','".$para3."','".$heading2."','".$strongest1."','".$strongest2."','".$strongest3."','".$strongest4."','".$heading3."','".$choose1."','".$choose2."','".$choose3."','".$history_heading."','".$history_para."')";
			}
			return $this->query($query);
		}
		function updateaboutus($data, $heading1) 
		{
			$heading = $this->escape_string($this->strip_selected($data['heading'], $this->allowTags));
			$sub_heading = $this->escape_string($this->strip_selected($data['sub_heading'], $this->allowTags));
			$bullet_line = $this->escape_string($this->strip_selected($data['bullet_line'], $this->allowTags));
			$para1 = $this->escape_string($this->strip_selected($data['para1'], $this->allowTags));
			$para2 = $this->escape_string($this->strip_selected($data['para2'], $this->allowTags));
			$para3 = $this->escape_string($this->strip_selected($data['para3'], $this->allowTags));
			$content = $this->escape_string($this->strip_selected($data['content'], $this->allowTags));		
			$filename = $_FILES["banner"]["name"]; 
			$filename1 = $_FILES["image1"]["name"]; 
			$filename2 = $_FILES["image2"]["name"]; 
			
			if($filename!='')
			{
				//echo "sneha";	
				$filename = $_FILES["banner"]["name"]; 
				$tempname = $_FILES["banner"]["tmp_name"];  
				$folder = "../images/about_us/$filename"; 
				if (move_uploaded_file($tempname, $folder))  { 
				$msg = "Image uploaded successfully"; 
				}
					$query1 = "update ".PREFIX."about_us set banner='".$filename."'";
					$this->query($query1);
			}
			//exit();
			if($filename1!='')
			{
				$filename1 = $_FILES["image1"]["name"]; 
				$tempname1 = $_FILES["image1"]["tmp_name"];  
				$folder1 = "../images/about_us/$filename1"; 
				if (move_uploaded_file($tempname1, $folder1))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query2 = "update ".PREFIX."about_us set image1='".$filename1."'";
				$this->query($query2);
			}
			if($filename2!='')
			{
				$filename2 = $_FILES["image2"]["name"]; 
				$tempname2 = $_FILES["image2"]["tmp_name"];  
				$folder2 = "../images/about_us/$filename2"; 
				if (move_uploaded_file($tempname2, $folder2))  { 
				$msg = "Image uploaded successfully"; 
				}
				$query3 = "update ".PREFIX."about_us set image2='".$filename2."'";
				$this->query($query3);			
			}
			
			$sql = $this->query("select * from ".PREFIX."about_us");
			if($this->num_rows($sql)>0) 
			{
				$query = "update ".PREFIX."about_us set heading='".$heading."',sub_heading='".$sub_heading."',bullet_line='".$bullet_line."',para1='".$para1."',para2='".$para2."',para3='".$para3."',content='".$content."'";
			} 
			else 
			{
				$query = "insert into ".PREFIX."about_us (heading,banner,sub_heading,bullet_line,para1,para2,para3,content,image1,image2) values ('".$heading."','".$filename."','".$sub_heading."','".$bullet_line."','".$para1."','".$para2."','".$para3."','".$content."','".$filename1."','".$filename2."')";
			}
			return $this->query($query);
		}
		
		function add_milestone($data,$description) {
		
			$descriptions = $this->escape_string($this->strip_selected($data['description'], $this->allowTags));
			$year = $this->escape_string($this->strip_selected($data['year'], $this->allowTags));
			$filename1 = $_FILES["milestone_image"]["name"]; 
			$tempname1 = $_FILES["milestone_image"]["tmp_name"];  
			$folder1 = "../images/why-selvel/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			

			
			
				$query = "insert into ".PREFIX."milestone (milestone_image,description,year) values ('".$filename1."','".$descriptions."','".$year."')";
			
			return $this->query($query);
		}
		function update_milestone($data,$description) {
		
			$descriptions = $this->escape_string($this->strip_selected($data['description'], $this->allowTags));
			$year = $this->escape_string($this->strip_selected($data['year'], $this->allowTags));
			$id = $this->escape_string($this->strip_selected($data['id'], $this->allowTags));
			echo $filename1 = $_FILES["milestone_image"]["name"]; 
			
			
			if($filename1!=''){
			//	echo "hii";
			//	exit();
			$filename1 = $_FILES["milestone_image"]["name"]; 
			$tempname1 = $_FILES["milestone_image"]["tmp_name"];  
			$folder1 = "../images/why-selvel/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			$query_i = "update ".PREFIX."milestone set milestone_image='".$filename1."' where id='$id'";
			$this->query($query_i);
			}
//exit();
			
			
				$query = "update ".PREFIX."milestone set description='".$descriptions."',year='".$year."' where id='$id'";
			
			return $this->query($query);
		}
		
		function addwhyselvel($data,$text) {
		
			$content = $this->escape_string($this->strip_selected($data['text'], $this->allowTags));
			$filename1 = $_FILES["image"]["name"]; 
			$tempname1 = $_FILES["image"]["tmp_name"];  
			$folder1 = "../images/why-selvel/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			

			
			
				$query = "insert into ".PREFIX."why_selvel_home (image,text) values ('".$filename1."','".$content."')";
			
			return $this->query($query);
		}
		function upwhyselvel($data,$text) {
			
		$idd = $this->escape_string($this->strip_selected($data['idd'], $this->allowTags));
			$content = $this->escape_string($this->strip_selected($data['text'], $this->allowTags));
			$filename1 = $_FILES["image"]["name"]; 
			
			if($filename1!=''){
			$filename1 = $_FILES["image"]["name"]; 
			$tempname1 = $_FILES["image"]["tmp_name"];  
			$folder1 = "../images/why-selvel/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			$query1 = "update ".PREFIX."why_selvel_home set image='".$filename1." where id='$idd'";
			$this->query($query1);
			}
			
			
				$query = "update ".PREFIX."why_selvel_home set text='".$content."' where id='$idd'";
			
			return $this->query($query);
		}
		function addreviewsmaster($data,$name1) {
		
			$name = $this->escape_string($this->strip_selected($data['name'], $this->allowTags));
			$review = $this->escape_string($this->strip_selected($data['review'], $this->allowTags));
			$profile = $this->escape_string($this->strip_selected($data['profile'], $this->allowTags));
			
			

			
			
				$query = "insert into ".PREFIX."reviews_master (name,review,profile) values ('".$name."','".$review."','".$profile."')";
			
			return $this->query($query);
		}
		/*function editwhyselvel($data, $text,$image) {
			$content = $this->escape_string($this->strip_selected($data['text'], $this->allowTags));
			$filename1 = $_FILES["image"]["name"]; 
			$tempname1 = $_FILES["image"]["tmp_name"];  
			$folder1 = "../images/why-selvel/$filename1"; 
			if (move_uploaded_file($tempname1, $folder1))  { 
			$msg = "Image uploaded successfully"; 
			}
			

			$sql = $this->query("select * from ".PREFIX."why_selvel_home");
			
				$query = "insert into ".PREFIX."why_selvel_home (image,text) values ('".$content."','".$filename1."')";
			
			return $this->query($query);
		}*/

		function updateAllYouNeed($data, $file) {
			$title1 = $this->escape_string($this->strip_all($data['title1']));
			$description1 = $this->escape_string($this->strip_all($data['description1']));
			$link1 = $this->escape_string($this->strip_all($data['link1']));
			$title2 = $this->escape_string($this->strip_all($data['title2']));
			$description2 = $this->escape_string($this->strip_all($data['description2']));
			$link2 = $this->escape_string($this->strip_all($data['link2']));
			$title3 = $this->escape_string($this->strip_all($data['title3']));
			$description3 = $this->escape_string($this->strip_all($data['description3']));
			$link3 = $this->escape_string($this->strip_all($data['link3']));

			$SaveImage = new SaveImage();
			$imgDir = '../images/products/';

			$sql = $this->query("select * from ".PREFIX."all_need");
			if($this->num_rows($sql)>0) {
				$Detail = $this->fetch($sql);

				if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
					$cropData = $this->strip_all($data['cropData1']);
					$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$this->unlinkImage("products", $Detail['image_name'], "large");
					$this->unlinkImage("products", $Detail['image_name'], "crop");
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 400, $cropData, $imgDir, time().'-1');
					$this->query("update ".PREFIX."all_need set image_name='".$image_name."'");
				}

				if(isset($file['image_name2']['name']) && !empty($file['image_name2']['name'])) {
					$cropData = $this->strip_all($data['cropData2']);
					$file_name = strtolower( pathinfo($file['image_name2']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$this->unlinkImage("products", $Detail['image_name2'], "large");
					$this->unlinkImage("products", $Detail['image_name2'], "crop");
					$image_name2 = $SaveImage->uploadCroppedImageFileFromForm($file['image_name2'], 400, $cropData, $imgDir, time().'-2');
					$this->query("update ".PREFIX."all_need set image_name2='".$image_name2."'");
				}

				if(isset($file['image_name3']['name']) && !empty($file['image_name3']['name'])) {
					$cropData = $this->strip_all($data['cropData3']);
					$file_name = strtolower( pathinfo($file['image_name3']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$this->unlinkImage("products", $Detail['image_name3'], "large");
					$this->unlinkImage("products", $Detail['image_name3'], "crop");
					$image_name3 = $SaveImage->uploadCroppedImageFileFromForm($file['image_name3'], 400, $cropData, $imgDir, time().'-3');
					$this->query("update ".PREFIX."all_need set image_name3='".$image_name3."'");
				}

				$this->query("update ".PREFIX."all_need set title1='".$title1."', description1='".$description1."', link1='".$link1."', title2='".$title2."', description2='".$description2."', link2='".$link2."', title3='".$title3."', description3='".$description3."', link3='".$link3."'");
			} else {
				if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
					$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData1']);
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 400, $cropData, $imgDir, time().'-1');
				} else {
					$image_name = '';
				}

				if(isset($file['image_name2']['name']) && !empty($file['image_name2']['name'])){
					$file_name = strtolower( pathinfo($file['image_name2']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData2']);
					$image_name2 = $SaveImage->uploadCroppedImageFileFromForm($file['image_name2'], 400, $cropData, $imgDir, time().'-2');
				} else {
					$image_name2 = '';
				}

				if(isset($file['image_name3']['name']) && !empty($file['image_name3']['name'])){
					$file_name = strtolower( pathinfo($file['image_name3']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData3']);
					$image_name3 = $SaveImage->uploadCroppedImageFileFromForm($file['image_name3'], 400, $cropData, $imgDir, time().'-3');
				} else {
					$image_name3 = '';
				}

				$this->query("insert into ".PREFIX."all_need(image_name, title1, description1, link1, image_name2, title2, description2, link2, image_name3, title3, description3, link3) values ('".$image_name."', '".$title1."', '".$description1."', '".$link1."', '".$image_name2."', '".$title2."', '".$description2."', '".$link2."', '".$image_name3."', '".$title3."', '".$description3."', '".$link3."')");
			}

			return true;
		}

		/* === CMS END === */

		/*===================== USER MANAGEMENT BEGINS =====================*/

		/** * Function to get unique user of management by id */
		function getUniqueUserManagementById($id) {
		    $id = $this->escape_string($this->strip_all($id));
			$sql = $this->query("select * from ".PREFIX."admin where id='".$id."'");
			return $this->fetch($sql);
		}

		/** * Function to add user in user management */
		function addUserManagement($data) {
			$fname 					= $this->escape_string($this->strip_all($data['name']));
			$username 				= $this->escape_string($this->strip_all($data['email']));
			$email 					= $this->escape_string($this->strip_all($data['email']));
			$mobile				= $this->escape_string($this->strip_all($data['mobile']));
			$password 				= $this->escape_string($this->strip_all($data['password']));
			$role 				= $this->escape_string($this->strip_all($data['role']));
			$active 				= $this->escape_string($this->strip_all($data['active']));
			$password 				= password_hash($password, PASSWORD_DEFAULT);

			$permissionArray = array();
			$permissions = '';
			if(isset($data['permissions'])) {
				foreach($data['permissions'] as $permission) {
					$permission = $this->escape_string($this->strip_all($permission));
					if(!empty($permission)){
						$permissionArray[] = $permission;
					}
				}
			}
			if(count($permissionArray)>0){
				$permissions = implode(",", $permissionArray);
			}

			$query = "insert into ".PREFIX."admin(fname, username, email, mobile, password, role, permissions, active) values ('".$fname."', '".$username."', '".$email."', '".$mobile."', '".$password."', '".$role."', '".$permissions."', '".$active."')";
			$this->query($query);
			$emp_id = $this->last_insert_id();

			return true;
		}

		/** * Function to update user in user management */
		function updateUserManagement($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$fname 					= $this->escape_string($this->strip_all($data['name']));
			$username 				= $this->escape_string($this->strip_all($data['email']));
			$email 					= $this->escape_string($this->strip_all($data['email']));
			$mobile				= $this->escape_string($this->strip_all($data['mobile']));
			$password 				= $this->escape_string($this->strip_all($data['password']));
			$role 				= $this->escape_string($this->strip_all($data['role']));
			$active 				= $this->escape_string($this->strip_all($data['active']));

			if(!empty($password)) {
				$password = password_hash($password, PASSWORD_DEFAULT);
				$this->query("update ".PREFIX."admin set password = '".$password."' where id='$id'");
			}

			$permissionArray = array();
			$permissions = '';
			if(isset($data['permissions'])) {
				foreach($data['permissions'] as $permission) {
					$permission = $this->escape_string($this->strip_all($permission));
					if(!empty($permission)){
						$permissionArray[] = $permission;
					}
				}
			}
			if(count($permissionArray)>0){
				$permissions = implode(",", $permissionArray);
			}

			$query = "update ".PREFIX."admin set fname='".$fname."', username='".$username."', email='".$email."', mobile='".$mobile."', role = '".$role."', permissions = '".$permissions."', active = '".$active."' where id='$id'";
			$this->query($query);

			return true;
		}

		/** * Function to delete user from user management */
		function deleteUserManagementById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "update ".PREFIX."admin set is_deleted = '1' where id = '$id'";
			$this->query($query);
			return true;
		}

		/*===================== USER MANAGEMENT ENDS =====================*/

	} 
?>