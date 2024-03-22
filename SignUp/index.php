<?php

session_start();
require '../Database/Query.php';
if (isset($_SESSION['flag'])) {
  header('location: ../Pager.php');
}
if (isset($_POST['login'])) {
  $emailUser = $_POST['emailUser'];
  $password = $_POST['password'];
  $obLogin = new Query();
  $isSignUp = $obLogin->LoginSelect($emailUser);

  if (password_verify($password, $isSignUp) && $isSignUp) {
    $_SESSION['flag'] = 1;
    header("location: ../Pager.php");
    exit;
  }
  else {
    session_destroy();
    $isSignUp = FALSE;
  }
}
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LogIn</title>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  <div class="container">
    <h1>LogIn Page</h1>
    <form action="index.php" method="post">
      <div class="form-ele">
        <label for="emailUser">Enter Email Or Username here:</label>
        <input type="text" name="emailUser" id="emailUser">
      </div>
      <div class="form-ele">
        <label for="password">Enter Password here:</label>
        <input type="password" name="password" id="password">
      </div>
      <p class="Reset">Forget Password? No worry <a href="../ResetPassword/Reset.php">Click Here</a></p>
      <p class="SignIn">Dont Have account? <a href="Registration.php">Create Account</a> Here</p>
      <input type="submit" value="Login" name="login">
    </form>
    <h1>
      <?php
        if (isset($_POST["login"]) && !$isSignup) {
          echo "Wrong Username or Password";
        }
      ?>
    </h1>
  </div>
</body>
</html>
