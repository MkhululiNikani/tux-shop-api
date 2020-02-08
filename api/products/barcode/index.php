<?php

require_once '../../../models/HttpResponse.php';
require_once '../../../config/Database.php';
require_once '../../../config/PasswordStorage.php';

$http = new HttpResponse();
$database = new Database();
// CHECK USER AUTHENTICATION
Authorize_User();


// Check is the user is authorised to use our API
function Authorize_User()
{
	global $http;
	$data = json_decode(file_get_contents("php://input"));
	if(!isset($data->api_username) || !isset($data->api_password) || $data->api_username == "" || $data->api_password == ""){
		$http->notAuthorized("You need to Authenticate yourself to use our API");
		exit();
	}

	if(!AuthenticateUser($data->api_username, $data->api_password)){
			$http->notAuthorized("username or password incorrect");
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





//  isGET
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$data = json_decode(file_get_contents("php://input"));
		if(isset($data->isGET)){
			$_SERVER['REQUEST_METHOD'] = 'GET';
		}
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
  $http->badRequest("Only GET requests are allowed for barcodes");
}





if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      if (!isset($_GET['id'])) {
          $http->badRequest("You need to provide a barcode as id get product info using barcode");
          exit();
      }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT))
    {
        $http->badRequest("Only a valid integer barcode is allowed to fetch a product");
        exit();
    }

    $resultData = getProductByBarcode($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Product was not found");
        exit();
    }
    $http->OK($resultData);
}


function getProductByBarcode($Barcode)
{
  global $database;
  $sql = "SELECT * FROM products WHERE Barcode = :id ";
  $results = $database->fetchOne($sql, $Barcode);
  return $results;
}

 ?>
