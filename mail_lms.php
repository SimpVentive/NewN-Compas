<?php
echo "<pre>";
date_default_timezone_set('Asia/Calcutta');
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
include_once("dbconnect.php");
include_once('includes/PHPMailerAutoload.php');
$date=date("Y-m-d");  //and date(`created_date`)='$date'
echo $query1="select * from uls_notification_history where mail_status='' and `to` != ''  limit 4";
$result1=mysqli_query($con,$query1) or die("invalid query");
$num=mysqli_num_rows($result1);
while($rows1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
	$empid=$rows1['employee_id'];
	$event_id=$rows1['event_id'];
	$attach_flag=$rows1['attachment_flag'];
	$attachment=trim($rows1['attachment']);
	$id=$rows1['notification_history_id'];
	$recipient=trim($rows1['to']);
	$recipient1=trim($rows1['cc']);
	$subject=$rows1['subject']; 
	$body=$rows1['mail_content'];	
	
	
	$username="";		
	$from_name = "";	
	$from_mail="";
	$smtp_server="";
	$smtp_user="";
	$smtp_password="";
	$smtp_port=587;
	$smtp_encrypt="tls";
	$client_name="";
	$path="'public'.DS.'uploads'";
	$target_path="";
	if(!empty($attachment)){
		$target_path="/var/www/public_html/public/".$attachment;
	}
	else{
		$target_path="";
	}
	
	$mail = new PHPMailer;
	$mail->SMTPDebug = 4;							// Enable verbose debug output
	$mail->isSMTP();								// Set mailer to use SMTP
	$mail->Host = $smtp_server;				// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;							// Enable SMTP authentication
	$mail->Username = $username;					// SMTP username
	$mail->Password = $smtp_password;				// SMTP password
	$mail->SMTPSecure = $smtp_encrypt;				// Enable TLS encryption, `ssl` also accepted
	$mail->Port = $smtp_port;						// TCP port to connect to
	
	$mail->From = $from_mail;
	$mail->FromName = $client_name;
	$mail->addAddress($recipient);
	$mail->isHTML(true);							// Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body= $body;
	
	$mail->addAttachment($target_path);
	
	if(!$mail->send()) {
		$update1="UPDATE uls_notification_history set mail_status='R',mail_delivey_time='".date('Y-m-d H:i:s')."' where notification_history_id=".$id;
		$result=mysqli_query($con,$update1) or die("invalid query");	
	} else {
		$update1="UPDATE uls_notification_history set mail_status='A',mail_delivey_time='".date('Y-m-d H:i:s')."' where notification_history_id=".$id;
		$result=mysqli_query($con,$update1) or die("invalid query");
		
	} 	 
	
}

?>