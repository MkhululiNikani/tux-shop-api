<?php
/**
 *
 */
 require_once '../../config/Database.php';
class TempInvoiceItems
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteTempInvoiceItems($InvoiceID)
  {
    $sql = "DELETE FROM temp_invoiceitems WHERE InvoiceID = :id";
    $results = $this->database->delete($sql, $InvoiceID);
    return ["message" => "All Temp Invoice items with invoice id $InvoiceID were successfully deleted", ];
  }

  public function insertTempInvoiceItems($InvoiceID, $ProductID, $Quantity, $Price)
  {

    $invoiceItemsInfo = array(':InvoiceID' => $InvoiceID, ':ProductID' => $ProductID, ':Quantity' => $Quantity, ':Price' => $Price);


    $sql = "INSERT INTO temp_invoiceitems (InvoiceID, ProductID, Quantity, Price) VALUES (:InvoiceID, :ProductID, :Quantity, :Price)";

    $result = $this->database->insert($sql, $invoiceItemsInfo);
    return ["message" => "Temp Invoice Items inserted successfully"];
  }

  public function updateTempInvoiceItems($InvoiceID, $ProductID, $Quantity, $Price)
  {
    $invoiceItemsInfo = array(':InvoiceID' => $InvoiceID, ':ProductID' => $ProductID, ':Quantity' => $Quantity, ':Price' => $Price);

    $sql = "UPDATE temp_invoiceitems SET Quantity = :Quantity, Price = :Price WHERE InvoiceID = :InvoiceID AND ProductID = :ProductID";

    $results = $this->database->update($sql, $invoiceItemsInfo);
    return ["message" => "Temp Product with id $ProductID was successfully updated on Invoice Number : $InvoiceID", ];
  }

  public function getTempInvoiceItems($InvoiceID)
  {
    $sql = "SELECT * FROM temp_invoiceitems WHERE InvoiceID = :id ";
    $results = $this->database->fetchAllByID($sql, $InvoiceID);
    return $results;
  }

  public function getAllTempInvoiceItems()
  {
    $sql = "SELECT * FROM temp_invoiceitems";
    $results = $this->database->fetchAll($sql);
    return $results;
  }

}



 ?>
