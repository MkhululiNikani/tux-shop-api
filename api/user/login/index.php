<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
date_default_timezone_set('Africa/Johannesburg');

require_once '../../../models/HttpResponse.php';
require_once '../../../models/user.php';

$http = new HttpResponse();
$user = new User();



//  isGET
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$data = json_decode(file_get_contents("php://input"));
		if(isset($data->isGET)){
			$_SERVER['REQUEST_METHOD'] = 'GET';
		}
}




if ($_SERVER['REQUEST_METHOD'] !== 'GET')
{
	$http->badRequest("Invalid request method, please use GET to login a user");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $data = json_decode(file_get_contents("php://input"));
      validateUserInfo($data);
      if(!AuthenticateUser($data->api_username, $data->api_password)){
    			$http->notAuthorized("username or password incorrect");
    			exit();
    	}

      $results = $user->getUser($data->api_username);
      $http->OK($results);
      exit();
}


function AuthenticateUser($username, $password){
  require_once '../../../config/Database.php';
  require_once '../../../config/PasswordStorage.php';
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

function validateUserInfo($data)
{
  global $http;
  if(!isset($data->api_username) || !isset($data->api_password) || $data->api_username == "" || $data->api_password == ""){

			$http->badRequest("You need to provide an api_password, and api_username to login a new user");
      exit();
  }

}

?>
