<?php
  include('questionDetails.php');
  include('checkLoginStatus.php');
  if(isset($_COOKIE['qid'])){
    $qid = $_COOKIE['qid'];
    $questionObj = new Questions();
    list($qid, $question, $type, $option_array, $answer_array) = $questionObj->getQuestionDetails($qid);

  }else {
    header('location: questionTable.php');
  }
 ?>

 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Update Question Paper</title>
     <!-- Css files -->
     <link rel="stylesheet" href="css/bootstrap.css">
     <link rel="stylesheet" href="css/questionView.css">
   </head>
   <body>
     <!-- Navbar -->
     <div class="container">
       <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
         <a class="navbar-brand" href="questionTable.php">QuestionBank</a>
         <div class="nav navbar-nav navbar-right" style="position: relative; display: block;">
           <a class="navbar-brand" href="#" onclick="logout()" style="text-align: right;"">Logout</a>
         </div>
       </nav>
     </div>

     <div class="container">

       <!-- Heading -->
       <div class="jumbotron">
         <h1 align="center">Update Question</h1>
       </div>

       <!-- FORM   -->
       <form class="form-group" action="updateQuestionInDb.php" id="questionForm"  method="post">
         <label for="question"> <?php echo $qid."."; ?> Enter a question in below text area:</label>
         <textarea class="form-control" id="question" name="question" rows="4" cols="80" placeholder="Your question should not exceed 200 characters..." maxlength="200" required></textarea>
         <p>No of characters: <span id='questionLength'>0</span> </p>
         <br />

         <label for="question_type">Choose the type for question:</label>
         <div class="radio">
             <label><input type="radio" name="question_type" id="s" value="s" checked>Subjective Type Question</label>
         </div>
         <div class="radio">
             <label><input type="radio" name="question_type" id="om" value="om">Objective Type Question with multiple answers</label>
         </div>
         <div class="radio">
             <label><input type="radio" name="question_type" id="os" value="os">Objective Type Question with single answer</label>
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
               <input type="checkbox" id="multiple11" class="form-check-input ObjMultipleCheckOption form-check-inline" name="objective_multiple_answer[]" value="1"/>
               <input type="text" id="firstMultipleOption" class="objective_single_option objMultipleOption form-check-inline" name="objective_multiple_option_values[]" value=""/>
               <a href="javascript:void(0);" class="objective_multiple_add_button" title="Add field">add</i></a>
           </div>
         </div><br />


         <!-- objective single block -->
         <div class="objective_single">
           <label>Enter the options:</label>
           <div class="objective_single_option_wrapper">
               <div class="radio form-check-inline">
                   <input type="radio" id="single11" name="type_option" value="1">
               </div>
                   <input type="text" id="firstSingleOption"  class="objective_single_option objSingleOption" name="objective_single_option_values[]" value=""/>
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
     <script src="js/createQuestionChangeView.js" charset="utf-8"></script>
     <script src="js/createQuestionSubmitAction.js" charset="utf-8"></script>
     <script src="js/createQuestionAddRemoveFields.js" charset="utf-8"></script>

     <script type="text/javascript">
     $(document).ready(function(){
       var question = "<?php echo $question; ?>";
       $('#question').val(question);
       var question_length = $('#question').val().length;
       $('#questionLength').text(question_length);

       var valueChoosen = "<?php echo $type; ?>";
       if (valueChoosen == 's') {
         $('.subjective').show();
         $('.objective_multiple').hide();
         $('.objective_single').hide();
         $('#s').attr('checked', true);
         var answer = "<?php echo $answer_array[0]; ?>";
         $('#subjective_answer').val(answer);
         var answer_length = $('#subjective_answer').val().length;
         $('#answerLength').text(answer_length);

         // add required attribute to input fields
         $("[name='subjective_answer']").attr("required", true);
         $(".objMultipleOption").attr("required", false);
         $(".ObjMultipleCheckOption").attr("required", false);
         $(".objSingleOption").attr("required", false);
         $("[name='type_option']").attr("required", false);
       }else if (valueChoosen == 'om') {
         $('.subjective').hide();
         $('.objective_multiple').show();
         $('.objective_single').hide();
         $('#om').attr('checked', true);
         // add required attribute to input fields
         $("[name='subjective_answer']").attr("required", false);
         $(".objMultipleOption").attr("required", true);
         //$(".ObjMultipleCheckOption").attr("required", true);
         $(".objSingleOption").attr("required", false);
         $("[name='type_option']").attr("required", false);

         var options = new Array();
         <?php foreach ($option_array as $key => $value) { ?>
           options.push("<?php echo $value; ?>");
        <?php } ?>
        var answers = new Array();
        <?php foreach ($answer_array as $key => $value) { ?>
          answers.push("<?php echo $value; ?>");
       <?php } ?>

          $('#firstMultipleOption').val(options[0]);
          var i;
          for(i=1; i<options.length; i++){
            var j = i+1;
            var id = 'multiple'+j;
            var iid = id+j;
            var field = '<div class="form-check"><input type="checkbox" id="'+iid+'" class="form-check-input ObjMultipleCheckOption" name="objective_multiple_answer[]" value="'+j+'"><input type="text" id="'+id+'" class="objective_single_option objMultipleOption" name="objective_multiple_option_values[]" required/><a href="javascript:void(0);" class="objective_multiple_remove_button" title="Add field">-</a></div>';
            $('.objective_multiple_option_wrapper').append(field);
            $('#'+id).val(options[i]);
          }
          for(i=0; i<answers.length; i++){
            var id = '#multiple'+answers[i]+answers[i];
            $(id).attr('checked', true);
          }
       }else {
         $('.subjective').hide();
         $('.objective_multiple').hide();
         $('.objective_single').show();
         $('#os').attr('checked', true);
         // add required attribute to input fields
         $("[name='subjective_answer']").attr("required", false);
         $(".objMultipleOption").attr("required", false);
         $(".ObjMultipleCheckOption").attr("required", false);
         $(".objSingleOption").attr("required", true);
         $("[name='type_option']").attr("required", true);

         var options = new Array();
         <?php foreach ($option_array as $key => $value) { ?>
           options.push("<?php echo $value; ?>");
        <?php } ?>
        var answers = "<?php echo $answer_array[0]; ?>";
         $('#firstSingleOption').val(options[0]);
         var i;
         for(i=1; i<options.length; i++){
           var j = i+1;
           var id = 'single'+j;
           var iid = id+j;
           var field = '<div class="radio"><input type="radio" id="'+iid+'" name="type_option" value="'+j+'"><input type="text" id="'+id+'" class="objective_single_option objSingleOption form-check-inline"  name="objective_single_option_values[]" required/><a href="javascript:void(0);" class="objective_single_remove_button form-check-inline" title="remove fields">-</a></div>';
           $('.objective_single_option_wrapper').append(field);
           $('#'+id).val(options[i]);
         }
         answer--;
         $('#single'+answers+answers).attr('checked', true);
       }
     });

     function logout(){
       if(confirm("Do you want to logout?")){
         window.location = 'index.php';
       }
     }
     </script>
   </body>
 </html>
