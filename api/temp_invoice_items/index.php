<?php

require_once "../../models/temp_invoice_items.php";
require_once '../../config/CheckRequest.php';


$temp_invoice_items = new TempInvoiceItems();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $temp_invoice_items->getAllTempInvoiceItems();
      if($resultData === 0){
          $http->notFound("No Temporary Invoice Items were found");
          exit();
      }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a Temporary Invoice Items");
        exit();
    }

    $resultData = $temp_invoice_items->getTempInvoiceItems($_GET['id']);

    if($resultData === 0){
        $http->notFound("No Temporary Invoice Items were found");
        exit();
    }

    $http->OK($resultData);
    exit();

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $temp_invoice_items->deleteTempInvoiceItems($id);
      $http->OK("Temporary invoice items deleted Successfuly");
      exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateTempInvoiceItemsInfo($data);


      $results = $temp_invoice_items->insertTempInvoiceItems($data->InvoiceID, $data->ProductID, $data->Quantity, $data->Price);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateTempInvoiceItemsInfo($data);

      $results = $temp_invoice_items->updateTempInvoiceItems($data->InvoiceID, $data->ProductID, $data->Quantity, $data->Price);
      $http->OK($results['message']);
      exit();
}



function validateTempInvoiceItemsInfo($data)
{
  global $http;
  if(!isset($data->InvoiceID) || !isset($data->ProductID) || !isset($data->Quantity) || !isset($data->Price)) {
      $http->badRequest("To insert new or update Temporary invoice items you need to provide the following values : InvoiceID, ProductID, Quantity, Price");
      exit();
  }
}

?>
