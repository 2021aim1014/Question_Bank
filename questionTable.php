<?php
  include('questionDetails.php');
  include('checkLoginStatus.php');
  include('unsetCookies.php')
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Question Table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- stylesheet -->
    <link rel="stylesheet" href="css/bootstrap.css" />

  </head>
  <body>

    <div class="container">
      <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <!-- Navbar content -->
        <a class="navbar-brand" href="questionTable.php">QuestionBank</a>
        <div class="nav navbar-nav navbar-right" style="position: relative; display: block;">
          <a class="navbar-brand" href="createQuestion.php" >Insert new data</a>
          <a class="navbar-brand" href='#' onclick="logout()">Logout</a>
        </div>
      </nav>

      <!-- Objective with multiple answer option block -->
    <div class="jumbotron">
      <h2 align="center">Question Table</h2>
    </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>QID</th>
            <th>Question</th>
            <th>Question Type</th>
            <th>Options</th>
            <th>Answers</th>
            <th>Edit</th>
            <th>Delete</th>
            <!-- <th>Delete</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          $obj = new Questions();
          $obj->displayQuestions();
           ?>
        </tbody>
      </table><br /><br /><br />

      <div class="" style="text-align:center;">

      </div>
    </div>

    <!-- JS files -->
    <script type="text/javascript">
    function logout(){
      if(confirm("Do you want to logout?")){
        window.location = 'index.php';
      }
    }
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/questionTable.js" charset="utf-8"></script>
    <script type="text/javascript">
    function logout(){
      if(confirm("Do you want to logout?")){
        window.location = 'index.php';
      }
    }
    </script>
  </body>
</html>
