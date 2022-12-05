<?php
include('questionDetails.php');
if (isset($_POST['submit'])){
  $qid = $_COOKIE['qid'];
  $question = $_POST['question'];
  $question_type = $_POST['question_type'];

  $questionObj = new Questions();

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

  $questionObj->updateQuestion($qid, $question, $question_type, $options, $answers);
} else{
  header('Location: questionTable.php');
}

 ?>
