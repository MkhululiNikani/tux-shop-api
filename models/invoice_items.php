<?php
/**
 *
 */
 require_once '../../config/Database.php';
class InvoiceItems
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteInvoiceItems($InvoiceID)
  {
    $sql = "DELETE FROM invoiceitems WHERE InvoiceID = :id";
    $results = $this->database->delete($sql, $InvoiceID);
    return ["message" => "All Invoice items with invoice id $InvoiceID were successfully deleted", ];
  }

  public function insertInvoiceItems($InvoiceID, $ProductID, $Quantity, $Price)
  {

    $invoiceItemsInfo = array(':InvoiceID' => $InvoiceID, ':ProductID' => $ProductID, ':Quantity' => $Quantity, ':Price' => $Price);


    $sql = "INSERT INTO invoiceitems(InvoiceID, ProductID, Quantity, Price) VALUES (:InvoiceID, :ProductID, :Quantity, :Price)";

    $result = $this->database->insert($sql, $invoiceItemsInfo);
    return ["message" => "Invoice Items inserted successfully"];
  }

  public function updateInvoiceItems($InvoiceID, $ProductID, $Quantity, $Price)
  {
    $invoiceItemsInfo = array(':InvoiceID' => $InvoiceID, ':ProductID' => $ProductID, ':Quantity' => $Quantity, ':Price' => $Price);

    $sql = "UPDATE invoiceitems SET Quantity = :Quantity, Price = :Price WHERE InvoiceID = :InvoiceID AND ProductID = :ProductID";

    $results = $this->database->update($sql, $invoiceItemsInfo);
    return ["message" => "Product with id $ProductID was successfully updated on Invoice Number : $InvoiceID", ];
  }

  public function getInvoiceItems($InvoiceID)
  {
    $sql = "SELECT * FROM invoiceitems WHERE InvoiceID = :id ";
    $results = $this->database->fetchAllByID($sql, $InvoiceID);
    return $results;
  }


  public function getAllInvoiceItems()
  {
    $sql = "SELECT * FROM invoiceitems";
    $results = $this->database->fetchAll($sql);
    return $results;
  }

}



 ?>
