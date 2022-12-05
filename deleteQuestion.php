<?php
include("questionDetails.php");
//Validate whether user has loged in or not
 include("checkLoginStatus.php");

if(isset($_COOKIE['qid'])){
  $qid = $_COOKIE['qid'];
  $questionObj = new Questions();
  $questionObj->deleteQuestion($qid);
  include('unsetCookies.php')
  return;
}else{
  header('location: questionTable.php');
}

 ?>
