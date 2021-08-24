<?php
	/*
	 * LoginFunctions
	 * v1.1.0
	 */
	$rootDir = dirname(dirname(__FILE__));
	include_once $rootDir.'/selvel-dashboard/include/database.php';
	class LoginFunctions extends Database {
		private $groupType = 'user';
		// static $USERTYPE_SELLER = "seller"; // DEFAULT
		// static $USERTYPE_PRODUCER = "producer";
		private $userTypeAvailable = array("customer");

		// === LOGIN BEGINS ===
		function loginSession($userId, $userFirstName, $userLastName='', $userType) {
			$_SESSION[SITE_NAME][$this->groupType."UserId"] = $userId;
			$_SESSION[SITE_NAME][$this->groupType."UserFirstName"] = $userFirstName;
			$_SESSION[SITE_NAME][$this->groupType."UserLastName"] = $userLastName;
			$_SESSION[SITE_NAME][$this->groupType."UserGroupType"] = $this->groupType;
			//$_SESSION[SITE_NAME][$this->groupType."UserType"] = $userType;
		}
		function logoutSession() {
			if(isset($_SESSION[SITE_NAME])){
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserId"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserId"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserFirstName"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserFirstName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserLastName"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserLastName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserGroupType"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserGroupType"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->groupType."UserType"])){
					unset($_SESSION[SITE_NAME][$this->groupType."UserType"]);
				}
				
				unset($_SESSION[SITE_NAME]);
				return true;
			} else {
				return false;
			}
		}
		function sessionExists(){
			if($this->isUserLoggedIn()){
				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		}
		function isUserLoggedIn(){

			if(isset($_SESSION[SITE_NAME]) && isset($_SESSION[SITE_NAME][$this->groupType.'UserId'])  && 
				!empty($_SESSION[SITE_NAME][$this->groupType.'UserId']) ){
				return true;
			} else {
				return false;
			}
		}
		function getSystemUserType() {
			return $_SESSION[SITE_NAME][$this->groupType.'UserType'];
		}
		function getLoggedInUserDetails(){
			$loggedInID = $this->escape_string($this->strip_all($_SESSION[SITE_NAME][$this->groupType.'UserId']));
			$loggedInUserDetailsArr = $this->getUniqueUserById($loggedInID);
			return $loggedInUserDetailsArr;
		}
		function getUniqueUserById($id) {
			$id = $this->escape_string($this->strip_all($id));
			return $this->fetch($this->query("select * from ".PREFIX."customers where id = '".$id."'"));
		}
		function userLogin($data, $successURL, $failURL = "sign-in.php?failed"){
			$email = $this->escape_string($this->strip_all($data['email']));
			$password = $this->escape_string($this->strip_all($data['password']));

			$result = $this->query("select * from ".PREFIX."customers where email='".$email."'");
			if($this->num_rows($result) == 1) {
				$row = $this->fetch($result);
				$passwordVerifyStatus = password_verify($password, $row['password']);
				if($passwordVerifyStatus) {

					if($row['active']=='1') {
						$this->loginSession($row['id'], $row['first_name'], "", $this->userTypeAvailable[0]);
						//header("location: ".$successURL." ");
						// echo '<script> window.open("'.BASE_URL.'/'.$successURL.'","_self");  </script>';
						echo '<script> window.open("'.$successURL.'","_self");  </script>';

					//	exit;
					} else {
						if($row['is_email_verified']=='0') {
							$this->close_connection();
							//header("location: ".BASE_URL."/".$failURL."&email-not-verified");
							echo '<script> window.open("'.BASE_URL.'/'.$failURL.'&email-not-verified","_self");  </script>';

							//exit;
						} else {
							$this->close_connection();
							//header("location: ".BASE_URL."/".$failURL."&account-not-active");
							echo '<script> window.open("'.BASE_URL.'/'.$failURL.'&account-not-active","_self");  </script>';

							//exit;
						}
					}
				} else {
					$this->close_connection();
					//header("location: ".BASE_URL."/".$failURL."&wrong-password");
					echo '<script> window.open("'.BASE_URL.'/'.$failURL.'&wrong-password","_self");  </script>';
					//exit;
				}

			} else {
				$this->close_connection();
				echo '<script> window.open("'.BASE_URL.'/'.$failURL.'&wrong-password","_self");  </script>';
				// header("location: ".BASE_URL."/".$failURL);
				exit;
			}

		}

		function userSocialLogin($email, $successURL, $failURL = "login.php?failed", $userType = '', $loginType = ''){
			$query = "select * from ".PREFIX."customers where email='".$email."'";
			$result = $this->query($query);

			if($this->num_rows($result) == 1){ // only one unique user should be present in the system
				$row = $this->fetch($result);

				if($row['active']=="1"){
					// $this->loginSession($row['id'], $row['first_name'], $row['last_name'], $userType); // DEPRECATED
					$this->loginSession($row['id'], $row['first_name'], "", $this->userTypeAvailable[0]);
					// $this->close_connection(); // DO NOT UNCOMMENT IN 4 WALLS

					// header("location: ".$successURL);
					// echo '<script>parent.jQuery.fancybox.close();</script>';
					// exit;
					return 1; // login success
					exit;
				} else {
					if($row['active']=="0"){
						$this->close_connection();
						header("location: ".$failURL."&account-not-active");
						exit;
						return -1; // account-not-active
						exit;
					} else {
						$this->close_connection();
						header("location: ".$failURL);
						exit;
						return 0; // login failed
						exit;
					}
				}
			} else {
				$this->close_connection();
				header("location: ".$failURL);
				exit;
				return 0; // login failed
				exit;
			}
		}

		// === LOGIN ENDS ====
	}
?>