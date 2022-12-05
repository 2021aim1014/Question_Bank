<?php
include('userDetails.php');

if(isset($_POST['submit'])){
  $user = $_POST['user'];
  $password = md5($_POST['password']);
  $obj = new UserDetails($user, $password);
  $obj->validateUserCredential();
}else{
  header('location: index.php');
}
?>
