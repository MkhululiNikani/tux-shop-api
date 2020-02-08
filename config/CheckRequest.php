<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
date_default_timezone_set('Africa/Johannesburg');

require_once '../../models/HttpResponse.php';
require_once '../../config/Database.php';
require_once 'PasswordStorage.php';
$http = new HttpResponse();




// CHECK REQUEST METHOD (GET, POST, PUT, DELETE)
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'DELETE' )
{
	$http->badRequest("Invalid request method, please use GET, POST, PUT or DELETE");
	exit();
}


//  isGET
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$data = json_decode(file_get_contents("php://input"));
		if(isset($data->isGET)){
			$_SERVER['REQUEST_METHOD'] = 'GET';
		}
}


// CHECK USER AUTHENTICATION
Authorize_User();


// Check is the user is authorised to use our API
function Authorize_User()
{
	return;
	global $http;
	$data = json_decode(file_get_contents("php://input"));
	if(!isset($data->api_username) || !isset($data->api_password) || $data->api_username == "" || $data->api_password == ""){
		$http->unauthorized("You need to Authenticate yourself to use our API");
		exit();
	}

	if(!AuthenticateUser($data->api_username, $data->api_password)){
			$http->unauthorized("username or password incorrect");
			exit();
	}
}
//Check is the user exists in the database
function AuthenticateUser($username, $password){
	$database = new Database();
	$sql = "SELECT Password FROM users WHERE Email = :id ";
	$hash = $database->fetchOne($sql, $username);

	try {
			$result = PasswordStorage::verify_password($password, $hash['Password']);
			if ($result === TRUE)
		  {
		      return TRUE;
		  }
		  else
		  {
		      return FALSE;
		  }
		} catch (\Exception $e) {
			return FALSE;
		}
}

?>
