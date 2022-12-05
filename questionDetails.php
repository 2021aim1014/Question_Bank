<?php
 include('DatabaseConnection.php');

 class Questions{
   private $question;
   private $question_type;
   private $answers;
   private $options;
   private $connObj;

   function __construct($question = '', $question_type = '', $answers = '', $options = '' ){
      $this->question = $question;
      $this->question_type = $question_type;
      $this->answers = $answers;
      $this->options = $options;
      $this->connObj = new DatabaseConnection();
   }

   public function setAnswersAndOptions($answers, $options){
     if($this->question_type == 's'){
       $this->options = $options;
       $this->answers = $answers;
     }elseif ($this->question_type == 'om') {
       $this->options = implode("/0xC/",$options);
       $this->answers = implode("/0xC/",$answers);
     }else {
       $this->options = implode("/0xC/", $options);
       $this->answers =  $answers;
     }
   }

   private function alert($message, $redirect){
     echo ' <script type="text/javascript">
       alert("'.$message.'");
       window.location = "'.$redirect.'";
       </script>';
   }

   private function navigateTo($location){
     echo ' <script type="text/javascript">
       window.location = "'.$location.'";
       </script>';
   }

   private function successAlert(){
     $message = 'Data is successfully saved!';
     $redirect = 'questionTable.php';
     $this->alert($message, $redirect);
     return;
   }

   private function failureAlert(){
     $message = 'Unable to save the data! Try again after some time.';
     $redirect = 'questionTable.php';
     $this->alert($message, $redirect);
     return;
   }

   public function insertQuestionIntoDb(){
     $conn = $this->connObj->createConnection();
     $sql_query = "Insert into questions (question, type, options, answers) values (?, ?, ?, ?)";
     if($stmt = $conn->prepare($sql_query)){
       $stmt->bind_param("ssss", $this->question, $this->question_type, $this->options, $this->answers);
       if($stmt->execute()){
         $this->successAlert();
       }else{
         $this->failureAlert();
       }
       $stmt->close();
    }
    $conn->close();
  }

  public function displayQuestions(){
    $conn = $this->connObj->createConnection();
    $sql_query = "SELECT qid, question, type, options, answers FROM `QUESTIONS`";
    if($stmt = $conn->prepare($sql_query)){
     $stmt->execute();
     $stmt->bind_result($qid, $question, $type, $options, $answers);

     while($stmt->fetch()){
      echo "<tr>";
      echo "<td>$qid</td>";
      echo "<td>$question</td>";
      if($type == 's'){
        echo "<td>Subjective <br />Question</td>";
      }
      if ($type == 'om') {
        echo "<td>Multiple <br />Objective <br />Question</td>";
      }
      if ($type == 'os') {
         echo "<td>Single<br /> Objective <br />Question</td>";
       }
      $option_array = explode("/0xC/", $options);
      echo "<td>";
      foreach ($option_array as $key => $value) {
        if ($type == 's') {
          echo "NA";
        }else{
          echo ($key+1).". ".$value."<br />";
        }

      }
      echo"</td>";

      $answer_array = explode("/0xC/", $answers);
      echo "<td>";
      foreach ($answer_array as $value) {
        if ($type == 's') {
          echo $value;
        }else{
          echo $value.". ".$option_array[$value-1]."<br />";
        }
      }
      echo"</td>";
      // href="updateQuestion.php" href="deleteQuestion.php"
      echo '<td><a href="#" onclick="editQuestion('.$qid.')">Edit</a></td>';
      echo '<td><a href="#" onclick="deleteQuestion('.$qid.')">Delete</a></td>';
      echo "</tr>";
     }
     $stmt->close();
    }
    $conn->close();
  }

  function deleteQuestion($qid){
    if(!is_numeric($qid)){
      $this->navigateTo('questionTable.php');
    }
    $conn = $this->connObj->createConnection();
    $sql_query = "delete from questions where qid = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $qid);
    if($stmt->execute()){
      if(mysqli_affected_rows($conn) > 0){
        $this->successfulDeleteAlert();
      } else{
          $this->navigateTo('questionTable.php');
        }
    }else{
      $this->unsuccessfullDeleteAlert();
    }
  }

  private function successfulDeleteAlert(){
    $message = 'Data is successfully deleted!';
    $redirect = 'questionTable.php';
    $this->alert($message, $redirect);
    return;
  }

  private function unsuccessfullDeleteAlert(){
    $message = 'Unable to delete data! Try after some time.';
    $redirect = 'questionTable.php';
    $this->alert($message, $redirect);
    return;
  }

  public function getQuestionDetails($qid){
    if(!is_numeric($qid)){
      $this->navigateTo('questionTable.php');
    }
    $conn = $this->connObj->createConnection();
    $sql_query = "SELECT qid, question, type, options, answers FROM `QUESTIONS` where qid=?";
    if($stmt = $conn->prepare($sql_query)){
      $stmt->bind_param("i", $qid);
      if($stmt->execute()){
        $stmt->bind_result($qid, $question, $type, $options, $answers);
        $stmt->fetch();
        $option_array = explode("/0xC/", $options);
        $answer_array = explode("/0xC/", $answers);
        return [$qid, $question, $type, $option_array, $answer_array];
      }
       $this->navigateTo('questionTable.php');
  }
  return;
}

  public function updateQuestion($qid, $question, $question_type, $options, $answers){
    $this->question = $question;
    $this->question_type = $question_type;
    $this->setAnswersAndOptions($answers, $options);

    $conn = $this->connObj->createConnection();
    $sql_query = "update questions set question = ?, type = ?, options = ?, answers = ? where qid = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("ssssi", $this->question, $this->question_type, $this->options, $this->answers, $qid);
    if($stmt->execute()){
        if(mysqli_affected_rows($conn) > 0){
          $this->successfulUpdateAlert();
        } else{
          $this->unavailableDataAlert();
        }
    } else{
      $this->unsuccessfullUpdateAlert();
    }
    $stmt->close();
    $conn->close();
  }

  private function successfulUpdateAlert(){
    $message = 'Data is successfully updated!';
    $redirect = 'questionTable.php';
    $this->alert($message, $redirect);
    return;
  }

  private function unavailableDataAlert(){
    $message = 'No changes made!';
    $redirect = 'questionTable.php';
    $this->alert($message, $redirect);
    return;
  }

  private function unsuccessfullUpdateAlert(){
    $message = 'Unable to update data! Try after some time.';
    $redirect = 'questionTable.php';
    $this->alert($message, $redirect);
    return;
  }

}
 ?>
