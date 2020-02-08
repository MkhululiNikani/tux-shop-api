<?php
require_once "../../models/employee.php";
require_once '../../config/CheckRequest.php';
$employee = new Employee();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
      $resultData = $employee->getAllEmployees();
        if($resultData === 0){
            $http->notFound("No Employees were found");
            exit();
        }
      $http->OK($resultData);
      exit();
    }

    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    {
        //ONLY INTEGERS ARE ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch an employee");
        exit();
    }

    $resultData = $employee->getEmployee($_GET['id']);

    if($resultData === 0){
        $http->notFound("The Employee was not found");
        exit();
    }

    $http->OK($resultData);

}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $received_data = json_decode(file_get_contents("php://input"));
      $id = $received_data->id;

      $employee->deleteEmployee($id);
      $http->OK("Employee deleted Successfuly");
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = json_decode(file_get_contents("php://input"));
      validateEmployeeInfo($data);


      $results = $employee->insertEmployee($data->Firstname, $data->Lastname, $data->IDNumber, $data->HomeAddress, $data->EmailAddress, $data->ReportsTo, $data->PositionID, $data->Title, $data->Username, $data->Password);
      $http->OK($results['message']);
      exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      $data = json_decode(file_get_contents("php://input"));
      validateFullEmployeeInfo($data);

      $results = $employee->updateEmployee($data->EmployeeID, $data->Firstname, $data->Lastname, $data->IDNumber, $data->HomeAddress, $data->EmailAddress, $data->ReportsTo, $data->PositionID, $data->Title, $data->Username, $data->Password);
      $http->OK($results['message']);
      exit();
}



function validateEmployeeInfo($data)
{
  global $http;
  if(!isset($data->Firstname) || !isset($data->Lastname) || !isset($data->IDNumber) || !isset($data->HomeAddress) ||
   !isset($data->EmailAddress) || !isset($data->ReportsTo) || !isset($data->PositionID) || !isset($data->Title) || !isset($data->Username) || !isset($data->Password)){
      $http->badRequest("To insert a new emplyee you need to provide the following values : Firstname, Lastname, IDNumber, HomeAddress, EmailAddress, ReportsTo, PositionID, Title, Username, Password");
      exit();
  }
}
function validateFullEmployeeInfo($data)
{
  global $http;
  if(!isset($data->EmployeeID) || !isset($data->Firstname) || !isset($data->Lastname) || !isset($data->IDNumber) || !isset($data->HomeAddress) || !isset($data->EmailAddress) || !isset($data->ReportsTo) ||
  !isset($data->PositionID) || !isset($data->Title) || !isset($data->Username) || !isset($data->Password)){
      $http->badRequest("To update an emplyee you need to provide the following values : EmployeeID, Firstname, Lastname, IDNumber, HomeAddress, EmailAddress, ReportsTo, PositionID, Title, Username, Password");
      exit();
  }
}
?>
