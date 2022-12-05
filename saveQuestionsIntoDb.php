<?php
  include('questionDetails.php');
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
     <title>Save into Database</title>

     <!-- Css files -->
     <link rel="stylesheet" href="css/bootstrap.css">
   </head>
   <body>
     <div class="container">
       <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
         <!-- Navbar content -->
         <a class="navbar-brand" href="questionTable.php">QuestionBank</a>
         <div class="nav navbar-nav navbar-right" style="position: relative; display: block;">
           <a class="navbar-brand" href="#" onclick="logout()" style="text-align: right;"">Logout</a>
         </div>
       </nav>
     </div>
     <script src="js/loginUser.js" charset="utf-8"></script>
     <script>
       function logout(){
         if(confirm("Do you want to logout?")){
           window.location = 'index.php';
         }
       }
     </script>
   </body>
 </html>

<?php

  if (isset($_POST['submit'])){
    $questionObj = new Questions($_POST['question'], $_POST['question_type']);
    $question_type = $_POST['question_type'];

    if($question_type == 's'){
      $options = 'NA';
      $answers = $_POST['subjective_answer'];
    } elseif ($question_type == 'om') {
      $answers = $_POST['objective_multiple_answer'];
      $options = $_POST['objective_multiple_option_values'];

    } else {
      $options = $_POST['objective_single_option_values'];
      $answers = $_POST['type_option'];
    }

    $questionObj->setAnswersAndOptions($answers, $options);
    $questionObj->insertQuestionIntoDb();
    echo "<div class='container center' style='text-align:center;'><a href='createQuestion.php'><button type='button' align='center'>Insert more data?</button></a></div>";
  } else{
    header('location: createQuestion.php');

  }
 ?>
