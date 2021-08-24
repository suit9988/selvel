<?php
	/*
	 * v1 - basic email class
	 * v1.1 - removed support for ADMIN email
	 *
	 * TEMPLATE CODE TO IMPLEMENT CLASS
		$newCustomerDetails = $user->addSomething($_POST);
		include_once("member-register-email.inc.php");
		include_once("Email.class.php");
		$emailObj = new Email();
		$emailObj->setAddress($email);
		$emailObj->setSubject("Welcome to example.com");
		$emailObj->setEmailBody($emailMsg);
		$emailObj->sendEmail();
	 *
	 */
	require("smtp/class.phpmailer.php");
	class Email{
		private $to;
		// private $admin = ADMIN_EMAIL; // DEPRECATED
		private $admin = '';
		private $from = "selvel@shareittofriends.com";
		private $subject;
		private $path;
		private $filename;
		private $encodedData;
		private $type;
		function setAddress($to){
			$this->to = $to;
		}
		function setAdminAddress($to){
			$this->admin = $to;
		}
		function setFromAddress($from){
			$this->from = $from;
		}
		function setSubject($subject){
			$this->subject = $subject;
		}
		function setEmailBody($msg){
			$this->msg = $msg;
		}
		function attachment($path,$filename,$encodedData,$type){
			$this->path = $path;
			$this->filename = $filename;
			$this->encodedData = $encodedData;
			$this->type = $type;
		}
		function sendEmail($BCC=false){
			// if(PROJECTSTATUS!="LIVE"){ // DO NOT WASTE EMAIL
			if(PROJECTSTATUS=="DEV"){ // DO NOT WASTE EMAIL
				// return true;
			}

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$this->from."\r\n";
			if(isset($this->admin) && !empty($this->admin)){
				$headers .= 'Bcc: '.$this->admin."\r\n";
				// $headers .= 'CC: '.$this->admin."\r\n";
			}

			if(!isset($this->to) || empty($this->to)){
				return false;
			}
			if(!isset($this->subject) || empty($this->subject)){
				return false;
			}
			if(!isset($this->msg) || empty($this->msg)){
				return false;
			}

			$mail = new PHPMailer();

			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			//$mail->SMTPSecure = "ssl";
			$mail->Host = "shareittofriends.com";
			$mail->Port = 587;
			
			$mail->Username = "selvel@shareittofriends.com";
			$mail->Password = "admin@1234";
			// $mail->SMTPDebug = 2;
			$mail->From = $this->from;
			$mail->FromName = SITE_NAME;
			$to = $this->to;
			$toArr = explode(',',$to);
			foreach($toArr as $oneAddress) {
				$mail->AddAddress($oneAddress);
			}
			
			if(isset($this->admin) && !empty($this->admin)){
				$mail->AddBCC($this->admin);
			}
			if(!empty($this->path)){
				$mail->addAttachment($this->path);
			}
			//$mail->AddReplyTo("mail@mail.com");
			$mail->IsHTML(true);

			$mail->Subject = $this->subject;
			$mail->Body = $this->msg;
			//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

			// if( mail($this->to, $this->subject, $this->msg, $headers) ){
			if($mail->Send()){
				return true;
			} else {
				return $mail->ErrorInfo;
			}
		}
	}
?>