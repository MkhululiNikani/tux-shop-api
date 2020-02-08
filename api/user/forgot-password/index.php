<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
date_default_timezone_set('Africa/Johannesburg');

require_once '../../../models/HttpResponse.php';
require_once '../../../models/user.php';

require '../../../config/PHPMailer/Exception.php';
require '../../../config/PHPMailer/PHPMailer.php';
require '../../../config/PHPMailer/SMTP.php';

$http = new HttpResponse();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
	$http->badRequest("Invalid request method, please use POST to reset a user password");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateUserInfo($data);
      $Token = bin2hex(random_bytes(12));

      $ExpireDateFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
      $ExpireDate = date("Y-m-d H:i:s",$ExpireDateFormat);

      $results = $user->forgotPassword($data->Email, $Token, $ExpireDate);

			$Body = "Password Reset \n
			 				click the link to reset your password http://mkhululi.net/picknscan/api/user/reset-password/?token=$Token&email=$data->Email";

			$Subject = 'Forgot Password ';
			sendEmail($data->Email, $Body, $Body, $Subject);
      $http->OK("An email to reset your password was sent to $data->Email");
      exit();
}


function validateUserInfo($data)
{
  global $http;
  if(!isset($data->Email) || $data->Email == ""){
      $http->badRequest("You need to provide an Email to reset password");
      exit();
  }

}

function sendEmail($Email, $Body, $AltBody, $Subject)
{
  require("../../../config/PHPMailer/PHPMailerAutoload.php");

  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);



	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Set mailer to use SMTP
	    $mail->Host       = 'mail.mkhululi.net';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'noreply.picknscan@mkhululi.net';                     // SMTP username
	    $mail->Password   = 'galaxy.tech.pick.n.scan';                               // SMTP password
	    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
	    $mail->Port       = 587;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('noreply.picknscan@mkhululi.net', 'PicknScan');
	    $mail->addAddress($Email);     // Add a recipient
	    //$mail->AddReplyTo('noreply.picknscan@mkhululi.net', "No Reply");
	    // Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);
	    $mail->Subject = $Subject;
	    $mail->Body    = $Body;
	    $mail->AltBody = $AltBody;

	    $mail->send();
	} catch (Exception $e) {
	    echo "Mailer Error: {$mail->ErrorInfo}";
			exit();
	}
}

?>
