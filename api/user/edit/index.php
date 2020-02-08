<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
date_default_timezone_set('Africa/Johannesburg');

require_once '../../../models/HttpResponse.php';
require_once '../../../models/user.php';
require_once '../../../config/PasswordStorage.php';
$http = new HttpResponse();
$user = new User();

// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] !== 'PUT')
{
	$http->badRequest("Invalid request method, please use PUT to register a user");
	exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateUserInfo($data);
      if(!AuthenticateUser($data->api_username, $data->api_password)){
    			$http->notAuthorized("username or password incorrect");
    			exit();
    	}
      if ($data->api_username != $data->Email) {
        $http->notAuthorized("A user is only allowed to update thier own information");
        exit();
      }


			$data->Password = PasswordStorage::create_hash($data->Password);
      $results = $user->updateUser($data->Firstname, $data->Lastname, $data->Cellphone, $data->Email, $data->Password);
      $http->OK($results['message']);
      exit();
}


function validateUserInfo($data)
{
  global $http;
  if(!isset($data->Firstname) || !isset($data->Lastname) || !isset($data->Cellphone) || !isset($data->Email) || !isset($data->Password)){
			$http->badRequest("You need to provide a Firstname, Lastname, Cellphone, Email, and Password to update a user");
      exit();
  }

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

?>
