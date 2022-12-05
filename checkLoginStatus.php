<?php
//Validate whether user has loged in or not
  session_start();
  if(!isset($_SESSION['LogedIn'])){
    $message = 'Sorry! Login first.';
    $redirect = 'index.php';
    echo ' <script type="text/javascript">
      alert("'.$message.'");
      window.location = "'.$redirect.'";
      </script>';
  }
