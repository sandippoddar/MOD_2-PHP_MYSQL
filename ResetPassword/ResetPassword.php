<?php

require '../Database/Query.php';
require '../Validation.php';
$token = $_GET['token'];
$queryob = new Query();
$validOb = new Validation();
$userId = 0;
$tokenArray = $queryob->checkToken($token);
if ($tokenArray) {
  $userId = $tokenArray['UserId'];
  $tokenExpire = $tokenArray['tokenExpire'];
}
$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
$passCheck = $validOb->isPassword($_POST['password']);
$isTokenExpire = $validOb->isTokenExpire($tokenArray['tokenExpire']);
$errorArr = [];
if (is_string($passCheck)) {
  $errorArr[] = $passCheck;
}
if (is_string($isTokenExpire)) {
  $errorArr[] = $isTokenExpire;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && !is_string($isTokenExpire) && !is_string($passCheck)) {
  $update = $queryob->updateUser($userId, $password);
  if ($update) {
    header("location: ../SignUp/index.php");
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  <div class="container">
    <h1>Set New Password</h1>
    <form action=<?php echo "ResetPassword.php?token="."$token"; ?> method="post">
      <div class="form-ele">
        <label for="password">Enter New Password: </label>
        <input type="text" name="password" id="password">
      </div>
      <input type="submit" value="Reset" name="submit">
    </form>
    <h1>
      <?php
        if (isset($_POST["submit"]) && $update) {
          echo "updated Sucessfuly!!";
        }
      ?>
    </h1>
    <div class="error">
      <?php if (isset($_POST['submit']) && count($errorArr)) : ?>
        <?php foreach( $errorArr as $error) : ?>
          <h1><?php echo $error; ?></h1>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
