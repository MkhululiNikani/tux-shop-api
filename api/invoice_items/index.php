<?php

require_once "../../models/invoice_items.php";
require_once '../../config/CheckRequest.php';


$invoice_items = new InvoiceItems();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $invoice_items->getAllInvoiceItems();
      if($resultData === 0){
          $http->notFound("No invoice items were found");
          exit();
      }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a Invoice Items");
        exit();
    }

    $resultData = $invoice_items->getInvoiceItems($_GET['id']);

    if($resultData === 0){
        $http->notFound("No Invoice Items were found");
        exit();
    }

    $http->OK($resultData);

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $invoice_items->deleteInvoiceItems($id);
      $http->OK("Invoice items deleted Successfuly");
      exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateInvoiceItemsInfo($data);


      $results = $invoice_items->insertInvoiceItems($data->InvoiceID, $data->ProductID, $data->Quantity, $data->Price);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateInvoiceItemsInfo($data);

      $results = $invoice_items->updateInvoiceItems($data->InvoiceID, $data->ProductID, $data->Quantity, $data->Price);
      $http->OK($results['message']);
      exit();
}



function validateInvoiceItemsInfo($data)
{
  global $http;
  if(!isset($data->InvoiceID) || !isset($data->ProductID) || !isset($data->Quantity) || !isset($data->Price)) {
      $http->badRequest("To insert new or update invoice items you need to provide the following values : InvoiceID, ProductID, Quantity, Price");
      exit();
  }
}

?>
