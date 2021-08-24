<?php 
include_once 'include/functions.php';


    $functions = new Functions();
    $loggedInUserDetailsArr = $functions->sessionExists();
    if(isset($_POST['send'])){
        $functions->distributorsRequest($_POST);
        $name='';
        $h4heading ='';
        $content='';
        $adminDetails = $functions->getAdminDetails();    
        
        include_once("include/classes/Email.class.php");
    
        $name ='Following User Details As Are Follow';

        $content    .= "<p>Name : ".$_POST['name']."</p>";
        $content    .= "<p>Email ".$_POST['email'];
        $content    .= "<p>Contact : ".$_POST['contact']."</p>";
        $content    .= "<p>Message : ".$_POST['msg']."</p>";
             
        // include_once("thank-you.php");
    
        $subject = SITE_NAME." | New Contact us Request";
        $emailObj = new Email();

        $emailObj->setAddress("sneha@innovins.com");
        //$emailObj->setAddress($adminDetails['email']);
        $emailObj->setSubject($subject);
        $emailObj->setEmailBody($emailMsg);
        $emailObj->sendEmail();   
        
        header("location: thank-you-distributor.php");
        exit;
    }
	$contactUsCMSDetails = $functions->getdistributorCmsMasterDetails();

?>