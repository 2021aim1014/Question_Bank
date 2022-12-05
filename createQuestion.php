<?php
//Validate whether user has loged in or not
include('checkLoginStatus.php');
include('unsetCookies.php')

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question Paper</title>
    <!-- Css files -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/questionView.css">
  </head>
  <body>
    <!-- Navbar -->
    <div class="container">
      <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="questionTable.php">QuestionBank</a>
        <div class="nav navbar-nav navbar-right">
          <a class="navbar-brand" href='#' onclick="logout()" style="text-align: right;">Logout</a>
        </div>
      </nav>
    </div>

    <div class="container">

      <!-- Heading -->
      <div class="jumbotron">
        <h1 align="center">Create New Questions</h1>
      </div>

      <!-- FORM   -->
      <form class="form-group" action="saveQuestionsIntoDb.php" id="questionForm"  method="post">
        <label for="question">Enter a question in below text area:</label>
        <textarea class="form-control" id="question" name="question" rows="4" cols="80" placeholder="Your question should not exceed 200 characters..." maxlength="200" required></textarea>
        <p>No of characters: <span id='questionLength'>0</span> </p>
        <br />

        <label for="question_type">Choose the type for question:</label>
        <div class="radio">
            <label><input type="radio" name="question_type" value="s" checked>Subjective Type Question</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="question_type" value="om">Objective Type Question with multiple answers</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="question_type" value="os">Objective Type Question with single answer</label>
        </div><br />

        <!--Subjective block -->
        <div class="subjective">
          <label for="subjective_answer">Enter the answer in below text area:</label>
          <textarea class="form-control" id="subjective_answer" name="subjective_answer" rows="4" cols="80" placeholder="Your answer should not exceed 200 characters..." maxlength="200"></textarea><br />
          <p>No of characters: <span id='answerLength'>0</span> </p>
        </div>


        <!-- Objective multiple block -->
        <div class="objective_multiple">
          <label>Enter the options:</label>
          <div class="objective_multiple_option_wrapper">
              <input type="checkbox" class="form-check-input ObjMultipleCheckOption form-check-inline" name="objective_multiple_answer[]" value="1"/>
              <input type="text" class="objective_single_option objMultipleOption form-check-inline" name="objective_multiple_option_values[]" value=""/>
              <a href="javascript:void(0);" class="objective_multiple_add_button" title="Add field">add</i></a>
          </div>
        </div><br />


        <!-- objective single block -->
        <div class="objective_single">
          <label>Enter the options:</label>
          <div class="objective_single_option_wrapper">
              <div class="radio form-check-inline">
                  <input type="radio" name="type_option" value="1">
              </div>
                  <input type="text" class="objective_single_option objSingleOption" name="objective_single_option_values[]" value=""/>
                  <a href="javascript:void(0);" class="objective_single_add_button" title="Add field">add</i></a>
          </div>
        </div><br />

        <div style="text-align:center;">
          <button type="submit" id="myform" name="submit" value="submit">Submit</button>
        </div>
      </form>

    </div>

    <!-- jQuery and JS files -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/defaultCreateQuestionView.js" charset="utf-8"></script>
    <script src="js/createQuestionChangeView.js" charset="utf-8"></script>
    <script src="js/createQuestionSubmitAction.js" charset="utf-8"></script>
    <script src="js/createQuestionAddRemoveFields.js" charset="utf-8"></script>
    <script type="text/javascript">
    function logout(){
      if(confirm("Do you want to logout?")){
        window.location = 'index.php';
      }
    }
    </script>
  </body>
</html>
