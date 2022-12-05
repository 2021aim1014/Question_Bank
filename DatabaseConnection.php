<?php

class DatabaseConnection{
  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $conn = null;

  function __construct($servername = "localhost", $username = "root", $password = "", $dbname = "question_bank"){
  $this->servername = $servername;
  $this->username = $username;
  $this->password = $password;
  $this->dbname = $dbname;
  }

  public function createConnection(){
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_error) {
      die("Unable to connect to server! Please try again after some time.");
    }
    if(!is_null($this->conn)){
      return $this->conn;
    }
  }

}
