<?php

require_once "../../models/invoice.php";
require_once '../../config/CheckRequest.php';


$invoice = new Invoice();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $invoice->getAllInvoices();
        if($resultData === 0){
            $http->notFound("No Invoices were found");
            exit();
        }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch an invoice");
        exit();
    }

    $resultData = $invoice->getInvoice($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Invoice was not found");
        exit();
    }

    $http->OK($resultData);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $invoice->deleteInvoice($id);
      $http->OK("Invoice deleted Successfuly");
      exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateInvoiceInfo($data);


      $results = $invoice->insertInvoice($data->InvoiceDate, $data->InvoiceTime, $data->EmployeeID, $data->CustomerID);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateFullInvoiceInfo($data);

      $results = $invoice->updateInvoice($data->InvoiceID, $data->InvoiceDate, $data->InvoiceTime, $data->EmployeeID, $data->CustomerID);
      $http->OK($results['message']);
      exit();
}



function validateInvoiceInfo($data)
{
  global $http;
  if(!isset($data->InvoiceDate) || !isset($data->InvoiceTime) || !isset($data->EmployeeID) || !isset($data->CustomerID)){
      $http->badRequest("To insert a new invoice you need to provide the following values : InvoiceDate, InvoiceTime, EmployeeID, CustomerID");
      exit();
  }
}
function validateFullInvoiceInfo($data)
{
  global $http;
  if(!isset($data->InvoiceID) || !isset($data->InvoiceDate) || !isset($data->InvoiceTime) || !isset($data->EmployeeID) || !isset($data->CustomerID)){
      $http->badRequest("To update an invoice you need to provide the following values : InvoiceID, InvoiceDate, InvoiceTime, EmployeeID, CustomerID");
      exit();
  }
}
?>
