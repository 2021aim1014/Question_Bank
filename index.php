<?php
// When user navigates to login page, logout
  session_start();
  unset($_SESSION['LogedIn']);
  include('unsetCookies.php')
 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Stylesheet links -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/login.css" />
    <style media="screen">
      body {
        background-image: url('images/man.jpg');
        background-repeat: no-repeat;
        height: 100%;
        background-position: center;
        background-size: cover;
      }
    </style>

    <title>Login</title>
  </head>
<!-- background='images/bg1.jpg' -->
  <body >

    <div class="container">
      <!-- Navbar content -->
      <nav class="navbar navbar-light justify-content-center" style="background-color: white;">
        <a class="navbar-brand" href="#">QuestionBank</a>
      </nav>

      <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <br />
          <h1>Login</h1><br/><br/><br/>

          <!-- Login Form  -->
          <form id="login_form" action="validateUser.php" method="post" autocomplete="off">
            <input type="text" id="login" class="fadeIn second" name="user"  placeholder="Username" readonly onfocus="this.removeAttribute('readonly');" required /><br/><br/>
            <input type="password" id="password" class="fadeIn third" name="password"  placeholder="Password" readonly onfocus="this.removeAttribute('readonly');" required />
            <br/><br/>
            <br />
            <input type="submit" class="fadeIn fourth" value="Login" name="submit" />

            <!-- Username info hidden by default -->
            <div id="usr_info">
                <h6>Username must meet the following requirements:</h6>
                <ul>
                    <li id="user_length" class="invalid">Be at least <strong>5 characters</li>
                </ul>
            </div>

            <!-- Password info hidden by default -->
            <div id="pswd_info">
                <h6>Password must meet the following requirements:</h6>
                <ul>
                    <li id="pswd_letter" class="invalid">At least <strong>one letter</strong></li>
                    <li id="pswd_capital" class="invalid">At least <strong>one capital letter</strong></li>
                    <li id="pswd_number" class="invalid">At least <strong>one number</strong></li>
                    <li id="pswd_length" class="invalid">Be at least <strong>8 characters</strong></li>
                </ul>
            </div>
          </form>
        </div>
      </div>
    </div>

    <footer id='formFooter'>
      <p>&copy; 2019 </p>
    </footer>
    <!-- JS files -->
    <script src="js/jquery.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>
