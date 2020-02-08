<?php

require_once "../../models/supplier.php";
require_once '../../config/CheckRequest.php';


$supplier = new Supplier();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $supplier->getAllSuppliers();
        if($resultData === 0){
            $http->notFound("No Suppliers were found");
            exit();
        }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a supplier");
        exit();
    }

    $resultData = $supplier->getSupplier($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Supplier was not found");
        exit();
    }

    $http->OK($resultData);
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $supplier->deleteSupplier($id);
      $http->OK("Supplier deleted Successfuly");
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateSupplierInfo($data);


      $results = $supplier->insertSupplier($data->CompanyName, $data->Address, $data->City, $data->Region, $data->Country, $data->PostalCode, $data->Phone, $data->Email);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateFullSupplierInfo($data);

      $results = $supplier->updateSupplier($data->SupplierID, $data->CompanyName, $data->Address, $data->City, $data->Region, $data->Country, $data->PostalCode, $data->Phone, $data->Email);
      $http->OK($results['message']);
      exit();
}



function validateSupplierInfo($data)
{
  global $http;
  if(!isset($data->CompanyName) || !isset($data->Address) || !isset($data->City) || !isset($data->Region) || !isset($data->Country) || !isset($data->PostalCode) || !isset($data->Phone) || !isset($data->Email)){
      $http->badRequest("To insert a new supplier you need to provide the following values : CompanyName, Address, City, Region, Country, PostalCode, Phone, Email");
      exit();
  }
}
function validateFullSupplierInfo($data)
{
  global $http;
  if(!isset($data->SupplierID) || !isset($data->CompanyName) || !isset($data->Address) || !isset($data->City) || !isset($data->Region) || !isset($data->Country) || !isset($data->PostalCode) || !isset($data->Phone) || !isset($data->Email)){
      $http->badRequest("To update an supplier you need to provide the following values : SupplierID, CompanyName, Address, City, Region, Country, PostalCode, Phone, Email");
      exit();
  }
}
?>

?>
