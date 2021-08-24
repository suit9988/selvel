<?php
	/*
	 * v1.0.0 - OTP class for RouteSms (SmsPlus - Bulk Http API Specification)
	 *          based on (Document Version 1.0.0)
	 *
	 * TEMPLATE CODE TO IMPLEMENT CLASS
		include_once("OtpRouteSMS.class.php");
		$otpObj = new OTP();
		$otpObj->setSMPPServerAddress("server_name_here");
		$otpObj->setSMPPServerPort("port_number_here");
		$otpObj->setSMSAPIUserName(SMS_API_USERNAME);
		$otpObj->setSMSAPIPassword(SMS_API_PASSWORD);
		$otpObj->setFromAddress(SMS_API_SENDER_ID);

		$newOTP = $otpObj->generateOTP(4);
		$otpObj->setAddress($contact);
		$msg = "OTP: ".$newOTP."\nPlease enter the OTP to verify your ".SITE_NAME." account";
		$otpObj->setOTPMessage($msg);
		boolean $status = $otpObj->sendOTP();
	 *
	 */
	class SMS{
		private $smppServerAddress = "sms.businesskarma.in"; // domestic carrier
		private $smppServerPort = "8080"; // domestic carrier 8080
		private $userName = "f55065b0da74d939292e58e1ede75d5c"; //test
		// private $userName = "2bb02d3223f91802a5974ee056e5b997"; //live
		private $password = "";
		private $admin = "";
		private $to;
		private $from = "TXTSMS";
		private $msg = "";

		// == CONFIG METHODS ==
		function setSMPPServerAddress($smppServerAddress){
			$this->smppServerAddress = $smppServerAddress;
		}
		function setSMPPServerPort($smppServerPort){
			$this->smppServerPort = $smppServerPort;
		}
		function setSMSAPIUserName($userName){
			$this->userName = $userName;
		}
		function setSMSAPIPassword($password){
			$this->password = $password;
		}
		// == CONFIG METHODS ==

		function setAdminAddress($admin){
			$this->admin = $admin;
		}
		function setAddress($to){
			$this->to = $to;
		}
		function setFromAddress($from){
			$this->from = $from;
		}
		function setMessage($msg){
			$this->msg = $msg;
		}
		function sendSMS(){
			if(PROJECTSTATUS!="LIVE" && PROJECTSTATUS!="STAGING"){ // DO NOT WASTE SMS
				return true;
			}

			// == VALIDATION ==
			if(!isset($this->smppServerAddress) || empty($this->smppServerAddress)){
				return false;
			}
			if(!isset($this->to) || empty($this->to)){
				return false;
			}
			if(!isset($this->msg) || empty($this->msg)){
				return false;
			}
			// == VALIDATION ==

			$encodedMessage = urlencode($this->msg);
			$url = 'http://'.$this->smppServerAddress.'/api?method=sms.normal&api_key='.$this->userName.'&to='.$this->to.'&sender='.$this->from.'&message='.$encodedMessage;

			$responseStr = file_get_contents($url);
			$smsResponse = json_decode($responseStr);
			return $smsResponse;
		}
	}
	
?>