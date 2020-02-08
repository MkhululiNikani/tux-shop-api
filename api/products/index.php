<?php

require_once "../../models/product.php";
require_once '../../config/CheckRequest.php';


$product = new Product();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $product->getAllProducts();
        if($resultData === 0){
            $http->notFound("No Products were found");
            exit();
        }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        $http->badRequest("Only a valid integer is allowed to fetch a product");
        exit();
    }

    $resultData = $product->getProduct($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Product was not found");
        exit();
    }

    $http->OK($resultData);

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // $http->OK("API under development, sorry for the inconvenience: DELETE");
    // exit();


      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $product->deleteProduct($id);
      $http->OK("Product delete Successfuly");
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


      $data = json_decode(file_get_contents("php://input"));
      validateProductInfo($data);


      $results = $product->insertProduct($data->ProductName, $data->SupplierID, $data->CategoryID, $data->QuantityPerUnit,
       $data->UnitPrice, $data->UnitsInStock, $data->ReOrderLevel, $data->Barcode, $data->Discontinued);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {


      $data = json_decode(file_get_contents("php://input"));
      validateFullProductInfo($data);


      $results = $product->updateProduct($data->ProductID, $data->ProductName, $data->SupplierID, $data->CategoryID, $data->QuantityPerUnit,
       $data->UnitPrice, $data->UnitsInStock, $data->ReOrderLevel, $data->Barcode, $data->Discontinued);
      $http->OK($results['message']);
      exit();
}

























function validateProductInfo($data)
{
  global $http;
  if(!isset($data->ProductName) || !isset($data->SupplierID) || !isset($data->CategoryID) || !isset($data->QuantityPerUnit) || !isset($data->UnitPrice) || !isset($data->UnitsInStock) || !isset($data->ReOrderLevel) || !isset($data->Barcode) || !isset($data->Discontinued)){

      $http->badRequest("To insert a new product you need to provide the following values : ProductName, SupplierID, CategoryID, QuantityPerUnit, UnitPrice, UnitsInStock, Barcode, Discontinued");
      exit();
  }

  // VALIDATE ALL THE PRODUCT INFORMATION
}

function validateFullProductInfo($data)
{
  global $http;
  if(!isset($data->ProductID) || !isset($data->ProductName) || !isset($data->SupplierID) || !isset($data->CategoryID) || !isset($data->QuantityPerUnit) || !isset($data->UnitPrice) || !isset($data->UnitsInStock) || !isset($data->ReOrderLevel) || !isset($data->Barcode) || !isset($data->Discontinued)){

      $http->badRequest("To insert a new product you need to provide the following values : ProductName, SupplierID, CategoryID, QuantityPerUnit, UnitPrice, UnitsInStock, ReOrderLevel, Barcode, Discontinued");
      exit();
  }
}
?>
