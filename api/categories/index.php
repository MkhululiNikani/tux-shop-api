<?php

require_once "../../models/category.php";
require_once '../../config/CheckRequest.php';


$category = new Category();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $category->getAllCategories();
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a category");
        exit();
    }

    $resultData = $category->getCategory($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Category was not found");
        exit();
    }

    $http->OK($resultData);

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $category->deleteCategory($id);
      $http->OK("Category deleted Successfuly");
      exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateCategoryInfo($data);


      $results = $category->insertCategory($data->CategoryName, $data->Description);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateFullCategoryInfo($data);

      $results = $category->updateCategory($data->CategoryID, $data->CategoryName, $data->Description);
      $http->OK($results['message']);
      exit();
}







function validateCategoryInfo($data)
{
  if(!isset($data->CategoryName) || !isset($data->Description)){
      $http->badRequest("To insert a new category you need to provide the following values : CategoryName, Description");
      exit();
  }
}
function validateFullCategoryInfo($data)
{
  if(!isset($data->CategoryID) || !isset($data->CategoryName) || !isset($data->Description)){
      $http->badRequest("To update a category you need to provide the following values : CategoryID, CategoryName, Description");
      exit();
  }
}

?>
