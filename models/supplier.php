<?php
/**
 *
 */
 require_once '../../config/Database.php';
class Supplier
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteSupplier($SupplierID)
  {
    $sql = "DELETE FROM suppliers WHERE SupplierID = :id";
    $results = $this->database->delete($sql, $SupplierID);
    return ["message" => "Supplier with id $SupplierID was successfully deleted", ];
  }

  public function insertSupplier($CompanyName, $Address, $City, $Region, $Country, $PostalCode, $Phone, $Email)
  {

    $supplierInfo = array(':CompanyName' => $CompanyName, ':Address' => $Address, ':City' => $City, ':Region' => $Region,
     ':Country' => $Country, ':PostalCode' => $PostalCode, ':Phone' => $Phone, ':Email' => $Email);


    $sql = "INSERT INTO suppliers(CompanyName, Address, City, Region, Country, PostalCode, Phone, Email)
     VALUES (:CompanyName, :Address, :City, :Region, :Country, :PostalCode, :Phone, :Email)";

    $result = $this->database->insert($sql, $supplierInfo);
    return ["message" => "Supplier inserted successfully"];
  }

  public function updateSupplier($SupplierID, $CompanyName, $Address, $City, $Region, $Country, $PostalCode, $Phone, $Email)
  {
    $supplierInfo = array(':SupplierID' => $SupplierID, ':CompanyName' => $CompanyName, ':Address' => $Address, ':City' => $City,
     ':Region' => $Region, ':Country' => $Country, ':PostalCode' => $PostalCode, ':Phone' => $Phone, ':Email' => $Email);

    $sql = "UPDATE suppliers SET SupplierID = :SupplierID, CompanyName = :CompanyName, Address = :Address, City = :City,
            Region = :Region, Country = :Country, PostalCode = :PostalCode, Phone = :Phone, Email = :Email WHERE SupplierID = :SupplierID";

    $results = $this->database->update($sql, $supplierInfo);
    return ["message" => "Supplier with id $SupplierID was successfully updated", ];
  }

  public function getSupplier($SupplierID)
  {
    $sql = "SELECT * FROM suppliers WHERE SupplierID = :id ";
    $results = $this->database->fetchOne($sql, $SupplierID);
    return $results;
  }

  public function getAllSuppliers()
  {
    $sql = "SELECT * FROM suppliers";
    $results = $this->database->fetchAll($sql);
    return $results;
  }
}


 ?>
