<?php
include('DatabaseConnection.php');
session_start();

class UserDetails{
  private $userValue;
  private $passwordValue;
  private $connObj;

  function __construct($userValue, $passwordValue){
    $this->userValue = $userValue;
    $this->passwordValue = $passwordValue;
    $this->connObj = new DatabaseConnection();
  }

  function validateUserCredential(){
    $conn = $this->connObj->createConnection();
    if(is_null($conn)){
      $message = 'Unable to connect to server! Try again after sometime';
      $redirect = 'index.php';
      $this->alert($message, $redirect);
      return;
    }
    $sql_query = "SELECT user, password FROM `Login`where user=? and password=?";

    if($stmt = $conn->prepare($sql_query)){
      $stmt->bind_param("ss", $this->userValue, $this->passwordValue);
      $stmt->execute();
      $stmt->store_result();

      if($stmt->num_rows){
        $_SESSION['LogedIn'] = $this->userValue;
        header('Location: questionTable.php');
      }

      //create new admin
      $sql_query = "SELECT USER FROM `Login`";
      $stmt = $conn->prepare($sql_query);
      $stmt->execute();
      $stmt->store_result();

      if($stmt->num_rows == 0){
        $sql_query = "Insert into login (user, password) values (?, ?)";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("ss", $this->userValue, $this->passwordValue);
        $stmt->execute();
        $this->newAdminAlert();
      }
    }
    $this->invalidLoginAlert();
  }

  private function invalidLoginAlert(){
    $message = 'Invalid username or password! Try with valid credentials';
    $redirect = 'index.php';
    $this->alert($message, $redirect);
    return;
  }

  private function newAdminAlert(){
    $message = 'Welcome! You are the new admin. Login again.';
    $redirect = 'index.php';
    $this->alert($message, $redirect);
    return;
  }

  private function alert($message, $redirect){
    echo ' <script type="text/javascript">
      alert("'.$message.'");
      window.location = "'.$redirect.'";
      </script>';
  }
 }
