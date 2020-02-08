<?php
/**
 *
 */
 require_once '../../config/Database.php';
class Employee
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteEmployee($EmployeeID)
  {
    $sql = "DELETE FROM employees WHERE EmployeeID = :id";
    $results = $this->database->delete($sql, $EmployeeID);
    return ["message" => "Employee with id $EmployeeID was successfully deleted", ];
  }

  public function insertEmployee($Firstname, $Lastname, $IDNumber, $HomeAddress, $EmailAddress, $ReportsTo, $PositionID, $Title, $Username, $Password)
  {

    $employeeInfo = array(':Firstname' => $Firstname, ':Lastname' => $Lastname, ':IDNumber' => $IDNumber, ':HomeAddress' => $HomeAddress, ':EmailAddress' => $EmailAddress,
                          ':ReportsTo' => $ReportsTo, ':PositionID' => $PositionID, ':Title' => $Title, ':Username' => $Username, ':Password' => $Password);


    $sql = "INSERT INTO employees(Firstname, Lastname, IDNumber, HomeAddress, EmailAddress, ReportsTo, PositionID, Title, Username, Password)
            VALUES (:Firstname, :Lastname, :IDNumber, :HomeAddress, :EmailAddress, :ReportsTo, :PositionID, :Title, :Username, :Password)";

    $result = $this->database->insert($sql, $employeeInfo);
    return ["message" => "Employee inserted successfully"];
  }

  public function updateEmployee($EmployeeID, $Firstname, $Lastname, $IDNumber, $HomeAddress, $EmailAddress, $ReportsTo, $PositionID, $Title, $Username, $Password)
  {
    $employeeInfo = array(':EmployeeID' => $EmployeeID, ':Firstname' => $Firstname, ':Lastname' => $Lastname, ':IDNumber' => $IDNumber, ':HomeAddress' => $HomeAddress, ':EmailAddress' => $EmailAddress,
                          ':ReportsTo' => $ReportsTo, ':PositionID' => $PositionID, ':Title' => $Title, ':Username' => $Username, ':Password' => $Password);

    $sql = "UPDATE employees SET Firstname = :Firstname, Lastname = :Lastname, IDNumber = :IDNumber, HomeAddress = :HomeAddress, EmailAddress = :EmailAddress,
    ReportsTo = :ReportsTo, PositionID = :PositionID, Title = :Title, Username = :Username, Password = :Password WHERE EmployeeID = :EmployeeID";

    $results = $this->database->update($sql, $employeeInfo);
    return ["message" => "Employee with id $EmployeeID was successfully updated", ];
  }

  public function getEmployee($EmployeeID)
  {
    $sql = "SELECT * FROM employees WHERE EmployeeID = :id ";
    $results = $this->database->fetchOne($sql, $EmployeeID);
    return $results;
  }

  public function getAllEmployees()
  {
    $sql = "SELECT * FROM employees";
    $results = $this->database->fetchAll($sql);
    return $results;
  }
}



 ?>
