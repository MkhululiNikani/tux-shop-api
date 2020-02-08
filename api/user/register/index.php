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
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
	$http->badRequest("Invalid request method, please use POST to register a user : ".$_SERVER['REQUEST_METHOD']);
	exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateUserInfo($data);

			$data->Password = PasswordStorage::create_hash($data->Password);
      $results = $user->insertUser($data->Firstname, $data->Lastname, $data->Cellphone, $data->Email, $data->Password);
      $http->OK($results['message']);
      exit();
}











function validateUserInfo($data)
{
  global $http;
  if(!isset($data->Firstname) || !isset($data->Lastname) || !isset($data->Cellphone) || !isset($data->Email) || !isset($data->Password) ||
			$data->Firstname == "" || $data->Lastname == "" || $data->Cellphone == "" || $data->Email == "" || $data->Password == ""){
			$http->badRequest("You need to provide a Firstname, Lastname, Cellphone, Email, and Password to register a new user");
      exit();
  }

}


?>
