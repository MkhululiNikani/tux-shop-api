<?php

require_once "../../models/temp_invoice.php";
require_once '../../config/CheckRequest.php';


$temp_invoice = new TempInvoice();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $temp_invoice->getAllTempInvoices();
        if($resultData === 0){
            $http->notFound("No temporary invoices were found");
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

    $resultData = $temp_invoice->getTempInvoice($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Temporary Invoice was not found");
        exit();
    }

    $http->OK($resultData);

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $temp_invoice->deleteTempInvoice($id);
      $http->OK("Temporary invoice deleted Successfuly");
      exit();
}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateTempInvoiceInfo($data);


      $results = $temp_invoice->insertTempInvoice($data->InvoiceDate, $data->InvoiceTime, $data->CustomerID);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateFullTempInvoiceInfo($data);

      $results = $temp_invoice->updateTempInvoice($data->InvoiceID, $data->InvoiceDate, $data->InvoiceTime, $data->CustomerID);
      $http->OK($results['message']);
      exit();
}



function validateTempInvoiceInfo($data)
{
  global $http;
  if(!isset($data->InvoiceDate) || !isset($data->InvoiceTime) || !isset($data->CustomerID)){
      $http->badRequest("To insert a new temporary invoice you need to provide the following values : InvoiceDate, InvoiceTime,  CustomerID");
      exit();
  }
}
function validateFullTempInvoiceInfo($data)
{
  global $http;
  if(!isset($data->InvoiceID) || !isset($data->InvoiceDate) || !isset($data->InvoiceTime) || !isset($data->CustomerID)){
      $http->badRequest("To update an temporary invoice you need to provide the following values : InvoiceID, InvoiceDate, InvoiceTime, CustomerID");
      exit();
  }
}
?>
