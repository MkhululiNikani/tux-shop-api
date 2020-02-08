<?php
/**
 *
 */
 require_once '../../config/Database.php';
class Invoice
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteInvoice($InvoiceID)
  {
    $sql = "DELETE FROM invoices WHERE InvoiceID = :id";
    $results = $this->database->delete($sql, $InvoiceID);
    return ["message" => "Invoice with id $InvoiceID was successfully deleted", ];
  }

  public function insertInvoice($InvoiceDate, $InvoiceTime, $EmployeeID, $CustomerID)
  {

    $invoiceInfo = array(':InvoiceDate' => $InvoiceDate, ':InvoiceTime' => $InvoiceTime, ':EmployeeID' => $EmployeeID, ':CustomerID' => $CustomerID);


    $sql = "INSERT INTO invoices(InvoiceDate, InvoiceTime, EmployeeID, CustomerID) VALUES (:InvoiceDate, :InvoiceTime, :EmployeeID, :CustomerID)";

    $result = $this->database->insert($sql, $invoiceInfo);
    return ["message" => "Invoice inserted successfully"];
  }

  public function updateInvoice($InvoiceID, $InvoiceDate, $InvoiceTime, $EmployeeID, $CustomerID)
  {
      $invoiceInfo = array(':InvoiceID' => $InvoiceID, ':InvoiceDate' => $InvoiceDate, ':InvoiceTime' => $InvoiceTime, ':EmployeeID' => $EmployeeID, ':CustomerID' => $CustomerID);

    $sql = "UPDATE invoices SET InvoiceDate = :InvoiceDate, InvoiceTime = :InvoiceTime, EmployeeID = :EmployeeID, CustomerID = :CustomerID WHERE InvoiceID = :InvoiceID";

    $results = $this->database->update($sql, $invoiceInfo);
    return ["message" => "Invoice with id $InvoiceID was successfully updated", ];
  }

  public function getInvoice($InvoiceID)
  {
    $sql = "SELECT * FROM invoices WHERE InvoiceID = :id ";
    $results = $this->database->fetchOne($sql, $InvoiceID);
    return $results;
  }

  public function getAllInvoices()
  {
    $sql = "SELECT * FROM invoices";
    $results = $this->database->fetchAll($sql);
    return $results;
  }

  public function getLastUserInvoice($CustomerID)
  {
    $sql = "SELECT InvoiceID FROM invoices WHERE CustomerID = :id ORDER BY InvoiceID DESC LIMIT 1";
    $results = $this->database->fetchOne($sql, $CustomerID);
    return $results;
  }
}



 ?>
