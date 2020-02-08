<?php
/**
 *
 */
require_once '../../config/Database.php';
class Product{
  private $database;

  function __construct()
    {
      $this->database = new Database();
    }

  public function deleteProduct($productID)
  {
    $sql = "DELETE FROM products WHERE ProductID = :id";
    $results = $this->database->delete($sql, $productID);
    return ["message" => "Product with id $productID was successfully deleted", ];
  }

  public function insertProduct($ProductName, $SupplierID, $CategoryID, $QuantityPerUnit, $UnitPrice, $UnitsInStock, $ReOrderLevel, $Barcode, $Discontinued)
  {

    $productInfo = array(':ProductName' => $ProductName, ':SupplierID' => $SupplierID, ':CategoryID' => $CategoryID,
                         ':QuantityPerUnit' => $QuantityPerUnit, ':UnitPrice' => $UnitPrice,
                         ':UnitsInStock' => $UnitsInStock, ':ReOrderLevel' => $ReOrderLevel, ':Barcode' => $Barcode, ':Discontinued' => $Discontinued );


    $sql = "INSERT INTO products (ProductName, SupplierID, CategoryID, QuantityPerUnit,
                UnitPrice, UnitsInStock, ReOrderLevel, Barcode, Discontinued)
              VALUES (:ProductName, :SupplierID, :CategoryID, :QuantityPerUnit,
                :UnitPrice, :UnitsInStock, :ReOrderLevel, :Barcode, :Discontinued)";

    $result = $this->database->insert($sql, $productInfo);
    return ["message" => "Product inserted successfully"];
  }

  public function updateProduct($ProductID, $ProductName, $SupplierID, $CategoryID, $QuantityPerUnit, $UnitPrice, $UnitsInStock,
   $ReOrderLevel, $Barcode, $Discontinued)
  {
    $productInfo = array(':ProductID' => $ProductID,':ProductName' => $ProductName, ':SupplierID' => $SupplierID,
    					 ':CategoryID' => $CategoryID,':QuantityPerUnit' => $QuantityPerUnit, ':UnitPrice' => $UnitPrice,
                         ':UnitsInStock' => $UnitsInStock, ':ReOrderLevel' => $ReOrderLevel, ':Barcode' => $Barcode,
                         ':Discontinued' => $Discontinued );

    $sql = "UPDATE products SET ProductName=:ProductName, SupplierID=:SupplierID,
                    CategoryID=:CategoryID, QuantityPerUnit=:QuantityPerUnit, UnitPrice=:UnitPrice,
                    UnitsInStock=:UnitsInStock, ReOrderLevel=:ReOrderLevel, Barcode=:Barcode, Discontinued=:Discontinued WHERE ProductID = :ProductID";

    $results = $this->database->update($sql, $productInfo);
    return ["message" => "Product with id $ProductID was successfully updated", ];
  }

  public function getProduct($ProductID)
  {
    $sql = "SELECT * FROM products WHERE ProductID = :id ";
    $results = $this->database->fetchOne($sql, $ProductID);
    return $results;
  }

  public function getProductByBarcode($Barcode)
  {
    $sql = "SELECT * FROM products WHERE Barcode = :id ";
    $results = $this->database->fetchOne($sql, $Barcode);
    return $results;
  }

  public function getAllProducts()
  {
    $sql = "SELECT * FROM products";
    $results = $this->database->fetchAll($sql);
    return $results;
  }

}

 ?>
