<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
date_default_timezone_set('Africa/Johannesburg');

require_once '../../../models/user.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once '../../../config/PasswordStorage.php';

	if (!isset($_POST['submit'])) {
		notFound();
	};

	if (isset($_POST['password1'])) {
		$email = $_GET['email'];
		$date = date("Y-m-d H:i:s");

		$results = $user->resetPassword($email);
		if($results['ExpireDate'] < $date){
			linkExpired();
		 }
		$password = PasswordStorage::create_hash($_POST['password1']);

		$user->changePassword($_GET['email'], $password);
		$user->killResetPasswordLink($_GET['email'], $_GET['token']);
		passwordReseted();
	}

	exit();
}
//
// if ($_SERVER['REQUEST_METHOD'] !== 'GET')
// {
// 	$http->badRequest("Invalid request method, please use GET to reset a user password");
// 	exit();
// }

//Start HERE
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			if (!isset($_GET['token']) || !isset($_GET['email'])) {
				notFound();
			}

      $token = $_GET['token'];
			$email = $_GET['email'];
      $date = date("Y-m-d H:i:s");

      $results = $user->resetPassword($email);
			if ($results === 0) {
				notFound();
			}

			if($results['ExpireDate'] < $date){
				linkExpired();
			 }

			if ($results['Token'] != $token) {
				notFound();
			}

			changePassword();



}


function notFound()
{
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>404 | PicknScan</title>

	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

	<style media="screen">
	    * {
	    -webkit-box-sizing: border-box;
	            box-sizing: border-box;
	    }

	    body {
	    padding: 0;
	    margin: 0;
	    }

	    #notfound {
	    position: relative;
	    height: 100vh;
	    }

	    #notfound .notfound {
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    -webkit-transform: translate(-50%, -50%);
	        -ms-transform: translate(-50%, -50%);
	            transform: translate(-50%, -50%);
	    }

	    .notfound {
	    max-width: 520px;
	    width: 100%;
	    line-height: 1.4;
	    text-align: center;
	    }

	    .notfound .notfound-404 {
	    position: relative;
	    height: 240px;
	    }

	    .notfound .notfound-404 h1 {
	    font-family: \'Montserrat\', sans-serif;
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    -webkit-transform: translate(-50%, -50%);
	        -ms-transform: translate(-50%, -50%);
	            transform: translate(-50%, -50%);
	    font-size: 252px;
	    font-weight: 900;
	    margin: 0px;
	    color: #262626;
	    text-transform: uppercase;
	    letter-spacing: -40px;
	    margin-left: -20px;
	    }

	    .notfound .notfound-404 h1>span {
	    text-shadow: -8px 0px 0px #fff;
	    }

	    .notfound .notfound-404 h3 {
	    font-family: \'Cabin\', sans-serif;
	    position: relative;
	    font-size: 16px;
	    font-weight: 700;
	    text-transform: uppercase;
	    color: #262626;
	    margin: 0px;
	    letter-spacing: 3px;
	    padding-left: 6px;
	    }

	    .notfound h2 {
	    font-family: \'Cabin\', sans-serif;
	    font-size: 20px;
	    font-weight: 400;
	    text-transform: uppercase;
	    color: #000;
	    margin-top: 0px;
	    margin-bottom: 25px;
	    }

	    @media only screen and (max-width: 767px) {
	    .notfound .notfound-404 {
	      height: 200px;
	    }
	    .notfound .notfound-404 h1 {
	      font-size: 200px;
	    }
	    }

	    @media only screen and (max-width: 480px) {
	    .notfound .notfound-404 {
	      height: 162px;
	    }
	    .notfound .notfound-404 h1 {
	      font-size: 162px;
	      height: 150px;
	      line-height: 162px;
	    }
	    .notfound h2 {
	      font-size: 16px;
	    }
	    }

	</style>
	</head>
	<body>
	<div id="notfound">
	<div class="notfound">
	<div class="notfound-404">
	<h3>Oops! Page not found</h3>
	<h1><span>4</span><span>0</span><span>4</span></h1>
	</div>
	<h2>we are sorry, but the page you requested was not found</h2>
	</div>
	</div></body>
	</html>';
	exit();
}

function passwordReseted()
{
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Password-Reseted | PicknScan</title>

		<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

	<style media="screen">
	  #main{
	    height: 65vh;
	    weight: 100vw;
	    font-size: 30px;
	    font-family: \'Cabin\', sans-serif;
	    font-weight: bold;
	    color: seagreen;
	    display: flex;
	    text-transform: uppercase;
	    justify-content: center;
	    align-items: center;
	  }
	</style>
	</head>
	<body>
	  <div id="main">
	  <h2>Password Changed Successfully</h2>
	  </div>
	</body>
	</html>
 	';
	exit();
}

function linkExpired()
{
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Link Expired | PicknScan</title>

	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

	<style media="screen">
	    * {
	    -webkit-box-sizing: border-box;
	            box-sizing: border-box;
	    }

	    body {
	    padding: 0;
	    margin: 0;
	    }

	    #notfound {
	    position: relative;
	    height: 100vh;
	    }

	    #notfound .notfound {
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    -webkit-transform: translate(-50%, -50%);
	        -ms-transform: translate(-50%, -50%);
	            transform: translate(-50%, -50%);
	    }

	    .notfound {
	    max-width: 520px;
	    width: 100%;
	    line-height: 1.4;
	    text-align: center;
	    }

	    .notfound .notfound-404 {
	    position: relative;
	    height: 240px;
	    }

	    .notfound .notfound-404 h1 {
	    font-family: \'Montserrat\', sans-serif;
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    -webkit-transform: translate(-50%, -50%);
	        -ms-transform: translate(-50%, -50%);
	            transform: translate(-50%, -50%);
	    font-size: 252px;
	    font-weight: 900;
	    margin: 0px;
	    color: #262626;
	    text-transform: uppercase;
	    letter-spacing: -40px;
	    margin-left: -20px;
	    }

	    .notfound .notfound-404 h1>span {
	    text-shadow: -8px 0px 0px #fff;
	    }

	    .notfound .notfound-404 h3 {
	    font-family: \'Cabin\', sans-serif;
	    position: relative;
	    font-size: 16px;
	    font-weight: 700;
	    text-transform: uppercase;
	    color: #262626;
	    margin: 0px;
	    letter-spacing: 3px;
	    padding-left: 6px;
	    }

	    .notfound h2 {
	    font-family: \'Cabin\', sans-serif;
	    font-size: 20px;
	    font-weight: 400;
	    text-transform: uppercase;
	    color: #000;
	    margin-top: 0px;
	    margin-bottom: 25px;
	    }

	    @media only screen and (max-width: 767px) {
	    .notfound .notfound-404 {
	      height: 200px;
	    }
	    .notfound .notfound-404 h1 {
	      font-size: 200px;
	    }
	    }

	    @media only screen and (max-width: 480px) {
	    .notfound .notfound-404 {
	      height: 162px;
	    }
	    .notfound .notfound-404 h1 {
	      font-size: 162px;
	      height: 150px;
	      line-height: 162px;
	    }
	    .notfound h2 {
	      font-size: 16px;
	    }
	    }

	</style>
	</head>
	<body>
	<div id="notfound">
	<div class="notfound">
	<div class="notfound-404">
	<h3>The link has Expired</h3>
	<h1><span>O</span><span>o</span><span>p</span><span>s</span></h1>
	</div>
	<h2>we are sorry, but the link you used has expired</h2>
	</div>
	</div>
	</body>
	</html>
';
	exit();
}

function changePassword()
{

		echo '<!DOCTYPE html>
	<html lang="en" dir="ltr">
	  <head>
	    <meta charset="utf-8">
	    <title>PicknScan</title>
	    <style>
	    .form{
	        height: 50vh;
	        margin-top: 10vh;
	        display: flex;
	        flex-direction: column;
	        justify-content: space-around;
	        align-items: center;
	      }
	      .form input{
	        width: 30vw;
	        height: 40px;
	      }
	      .pair{
	        display: flex;
	        flex-direction: column;
	      }
	      span{
	        padding-bottom: 12px;
	        color: #168e88;
	      }
	      #button{
	        background-color: #168e88;
	        border: 1px solid #008080;
	        color: whitesmoke;
	      }

	      .title{
	        font-size: 40px;
	        padding-bottom: 20px;
	      }

	    </style>
	  </head>
	  <body>
	    <form class="form" method="post">
	      <div class="title">
	        Reset Password
	      </div>

	      <div class="pair">
	        <span>Enter New Password</span>
	        <input type="password" id="password" name="password1" required="true" pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,40}$" title="Password not strong enough" />
	      </div>
	      <div class="pair">
	        <span>Confirm New Password</span>
	        <input type="password" id="confirm_password" name="password2" required="true" pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,40}$" title="Password not strong enough" />
	      </div>
	      <input id="button" type="submit" name="submit" value="Change Password" onclick="alertPass()">
	    </form>

	    <script type="text/javascript">

				var password = document.getElementById("password")
				  , confirm_password = document.getElementById("confirm_password");

				function validatePassword(){
				  if(password.value != confirm_password.value) {
				    confirm_password.setCustomValidity("Passwords Do not Match");
				  } else {
				    confirm_password.setCustomValidity("");
				  }
				}

				password.onchange = validatePassword;
				confirm_password.onkeyup = validatePassword;

	    </script>
	  </body>
	</html>';
}

?>
