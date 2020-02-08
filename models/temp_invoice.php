<?php
/**
 *
 */
 require_once '../../config/Database.php';
class TempInvoice
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteTempInvoice($InvoiceID)
  {
    $sql = "DELETE FROM temp_invoices WHERE InvoiceID = :id";
    $results = $this->database->delete($sql, $InvoiceID);
    return ["message" => "Temporary Invoice with id $InvoiceID was successfully deleted", ];
  }

  public function insertTempInvoice($InvoiceDate, $InvoiceTime, $CustomerID)
  {

    $temp_invoiceInfo = array(':InvoiceDate' => $InvoiceDate, ':InvoiceTime' => $InvoiceTime, ':CustomerID' => $CustomerID);


    $sql = "INSERT INTO temp_invoices(InvoiceDate, InvoiceTime, CustomerID) VALUES (:InvoiceDate, :InvoiceTime, :CustomerID)";

    $result = $this->database->insert($sql, $temp_invoiceInfo);
    return ["message" => "Temporary Invoice inserted successfully"];
  }

  public function updateTempInvoice($InvoiceID, $InvoiceDate, $InvoiceTime, $CustomerID)
  {
    $invoiceInfo = array(':InvoiceID' => $InvoiceID, ':InvoiceDate' => $InvoiceDate, ':InvoiceTime' => $InvoiceTime, ':CustomerID' => $CustomerID);

    $sql = "UPDATE temp_invoices SET InvoiceDate = :InvoiceDate, InvoiceTime = :InvoiceTime, CustomerID = :CustomerID WHERE InvoiceID = :InvoiceID";

    $results = $this->database->update($sql, $invoiceInfo);
    return ["message" => "Temp Invoice with id $InvoiceID was successfully updated", ];
  }

  public function getTempInvoice($InvoiceID)
  {
    $sql = "SELECT * FROM temp_invoices WHERE InvoiceID = :id ";
    $results = $this->database->fetchOne($sql, $InvoiceID);
    return $results;
  }

  public function getAllTempInvoices()
  {
    $sql = "SELECT * FROM temp_invoices";
    $results = $this->database->fetchAll($sql);
    return $results;
  }
}



 ?>
