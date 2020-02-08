<?php
/**
 *
 */
 require_once '../../config/Database.php';
class Category
{
  private $database;
  function __construct()
  {
    $this->database = new Database();
  }

  public function deleteCategory($CategoryID)
  {
    $sql = "DELETE FROM categories WHERE CategoryID = :id";
    $results = $this->database->delete($sql, $CategoryID);
    return ["message" => "Category with id $CategoryID was successfully deleted", ];
  }

  public function insertCategory($CategoryName, $Description)
  {

    $categoryInfo = array(':CategoryName' => $CategoryName, ':Decription' => $Description);


    $sql = "INSERT INTO categories (CategoryName, Description) VALUES(:CategoryName, :Decription)";

    $result = $this->database->insert($sql, $categoryInfo);
    return ["message" => "Category inserted successfully"];
  }

  public function updateCategory($CategoryID, $CategoryName, $Description)
  {
    $categoryInfo = array(':CategoryID' => $CategoryID,':CategoryName' => $CategoryName, ':Description' => $Description);

    $sql = "UPDATE categories SET CategoryName = :CategoryName, Description = :Description WHERE CategoryID = :CategoryID";

    $results = $this->database->update($sql, $categoryInfo);
    return ["message" => "Category with id $CategoryID was successfully updated", ];
  }

  public function getCategory($CategoryID)
  {
    $sql = "SELECT * FROM categories WHERE CategoryID = :id ";
    $results = $this->database->fetchOne($sql, $CategoryID);
    return $results;
  }

  public function getAllCategories()
  {
    $sql = "SELECT * FROM categories";
    $results = $this->database->fetchAll($sql);
    return $results;
  }
}



 ?>
