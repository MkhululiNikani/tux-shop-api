<?php
require_once '../../../config/Database.php';
date_default_timezone_set('Africa/Johannesburg');
class User{
  private $database;

  function __construct()
    {
      $this->database = new Database();
    }

  public function deleteUser($UserID)
  {
    $sql = "DELETE FROM users WHERE UserID = :id";
    $results = $this->database->delete($sql, $UserID);
    return ["message" => "User with id $UserID was successfully deleted", ];
  }

  public function insertUser($Firstname, $Lastname, $Cellphone, $Email, $Password)
  {

    $userInfo = array(':Firstname' => $Firstname, ':Lastname' => $Lastname, ':Cellphone' => $Cellphone,
                         ':Email' => $Email, ':Password' => $Password);


    $sql = "INSERT INTO users (Firstname, Lastname, Cellphone, Email, Password)
              VALUES (:Firstname, :Lastname, :Cellphone, :Email, :Password)";

    $result = $this->database->insert($sql, $userInfo);
    return ["message" => "User registered successfully"];
  }

  public function updateUser($Firstname, $Lastname, $Cellphone, $Email, $Password)
  {
    $userInfo = array(':Firstname' => $Firstname, ':Lastname' => $Lastname, ':Cellphone' => $Cellphone,
                         ':Email' => $Email, ':Password' => $Password);

    $sql = "UPDATE users SET Firstname=:Firstname, Lastname=:Lastname,
                    Cellphone=:Cellphone, Email=:Email, Password=:Password WHERE Email = :Email";

    $results = $this->database->update($sql, $userInfo);
    return ["message" => "User with email: $Email was successfully updated", ];
  }

  public function getUser($Email)
  {
    $sql = "SELECT UserID, Firstname, Lastname, Cellphone, Email FROM users WHERE Email = :id";
    $results = $this->database->fetchOne($sql, $Email);
    return $results;
  }

  public function forgotPassword($Email, $Token, $ExpireDate)
  {
    $Info = array(':Email' => $Email, ':Token' => $Token, ':ExpireDate' => $ExpireDate);

    $sql = "INSERT INTO password_reset (Email, Token, ExpireDate) VALUES (:Email, :Token, :ExpireDate)";
    $results = $this->database->update($sql, $Info);
    return ["message" => "Token generated", ];
  }
  public function resetPassword($Email)
  {
    $sql = "SELECT Token, ExpireDate FROM password_reset WHERE Email = :id";
    $results = $this->database->fetchOne($sql, $Email);
    return $results;
  }

  public function changePassword($Email, $Password)
  {
    $userInfo = array(':Email' => $Email, ':Password' => $Password);

    $sql = "UPDATE users SET Password=:Password WHERE Email = :Email";
    $results = $this->database->update($sql, $userInfo);
    return ["message" => "Password for email: $Email was successfully changed"];
  }

  public function killResetPasswordLink($Email, $token)
  {
    // $ExpireDateFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")-1, date("Y"));
    // $date = date("Y-m-d H:i:s",$ExpireDateFormat);
    // $userInfo = array(':Email' => $Email, ':Token' => $token, ':ExpDate' => $date);

    $sql = "DELETE FROM password_reset WHERE Email = :id";
    $results = $this->database->delete($sql, $Email);

    return ["message" => "Reset link for email: $Email was successfully killed"];
  }


}

?>
