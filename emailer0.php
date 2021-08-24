<?php
include_once 'selvel-dashboard/include/config.php';
include_once 'selvel-dashboard/include/admin-functions.php';
$admin = new AdminFunctions();

$name = '';
$email = '';
$phone = '';
$message = '';
$website = '';

if(isset($_POST['name'])) { $name=$_POST['name']; }
if(isset($_POST['email'])) { $email=$_POST['email']; }
if(isset($_POST['phone'])) { $phone=$_POST['phone']; }
if(isset($_POST['message'])) { $message=$_POST['message']; }
if(isset($_POST['website'])) { $website=$_POST['website']; }
// $captcha; 
// if(isset($_POST['g-recaptcha-response'])){
//   $captcha=$_POST['g-recaptcha-response'];
// }      
// $secretKey = "6Lec6KQZAAAAAD_jF_bSL0Pqi8Ksi0zFqm1lhk7F";
// $ip = $_SERVER['REMOTE_ADDR'];
// // post request to server
// $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
// $response = file_get_contents($url);
// $responseKeys = json_decode($response,true);
// $status = $responseKeys['success'];
$status=true;
if($status){

	$admin->query("INSERT INTO ".PREFIX."distributor (website,name, email, contact, msg, created) values ('".$website."','".$name."', '".$email."', '".$phone."', '".$message."', '".CURRENTDATETIME."')");

	if(isset($_POST['email'])) {

		//include_once ("include/classes/smtp/class.phpmailer.php");

		$mail = new PHPMailer();
		error_reporting(0);



		$table_cellpadding = "5";

		$table_cellspacing = "1";

		$table_background_color = "#000000";

		$table_left_column_color = "#ececec";

		$table_left_column_font = "Roboto";

		$table_left_column_font_size = "2";

		$table_left_column_font_color = "#000000";

		$table_right_column_color = "#ffffff";

		$table_right_column_font = "Roboto";

		$table_right_column_font_size = "2";

		$table_right_column_font_color = "#000000";

		 

		$mybody = "

		

		<style>

		@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');



		*{

			font-family: 'Roboto', sans-serif!important;

		}

		</style>



		<table cellpadding=\"".$table_cellpadding."\" cellspacing=\"".$table_cellspacing."\" bgcolor=\"".$table_background_color."\">



			<tr>

				<td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>Name: </b></font></td>

				<td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".$_REQUEST['name']."</font></td>

			</tr>



			<tr>

				<td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>Email: </b></font></td>

				<td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".$_REQUEST['email']."</font></td>

			</tr>

			       

            <tr>

				<td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>Phone: </b></font></td>

				<td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".$_REQUEST['phone']."</font></td>

			</tr>

 

			<tr>

				<td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>Website: </b></font></td>

				<td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".$_REQUEST['website']."</font></td>

			</tr>



  

			<tr>

				<td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>Comments: </b></font></td>

				<td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".$_REQUEST['message']."</font></td>

			</tr>

		

		</table>";



		$mail->IsSMTP();

		$mail->Host = "shareittofriends.com";

		$mail->SMTPAuth = true;

		$mail->Port = 587;

		$mail->Username = "selvel@shareittofriends.com";

		$mail->Password = "admin@1234";

		// $mail->SMTPDebug = 2;

		$mail->From = "selvel@shareittofriends.com";	

	//	$mail->AddAddress("deepak.v@innovins.com");

		

		$mail->AddAddress("sameer@innovins.com");


		$mail->IsHTML(true);

		$mail->Subject = "Enquiry - BECOME A DISTRIBUTOR";

		$mail->Body = $mybody;

		$mail->Send();


		$mail->ClearAllRecipients();



		$mail->AddAddress($_POST['email']);

		$mail->Subject = "Thank You For Contacting Us";

		$mail->Body = "

		

		<style>

		@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');



		*{

			font-family: 'Roboto', sans-serif!important;

			color:#000!important;

		}

		</style>



		<font face=\"".$table_right_column_font."\">

		<p> Dear ".$_POST['name'].",</p>

		<p>Hope your day is going well.</p> 

		 

		<p>Thank you for raising the query, someone from our team will contact you within the next 48 hours and share with you the program details addressing all your queries.</p>

		

		<p>In the meantime, you can browse through Our Website:<a href='https://www.selvel.com/'> WebsiteLink</a></p>

		

		<br>

		<p>Wishing you a great day ahead.</p>

		<p>Regards,</p>

		<p>Team Selvel</p>

		</font>

		";

		$mail->Send();



		echo "<script>window.location.href='index.php';</script>";

		exit;

	}
}else{
	echo "<script>window.location.href='index.php?failed';</script>";
	exit;

}
?> 

