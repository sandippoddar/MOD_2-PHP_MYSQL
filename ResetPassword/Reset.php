<?php

require '../Database/Query.php';
require '../SendEmail.php';
if (isset($_POST["submit"])) {
  $userEmail = $_POST['email'];
  $ob = new Query();
  $emailObj = new SendEmail();
  $emailDb = $ob->isEmailInDb($userEmail);
  $token = bin2hex(random_bytes(16));
  $token_hash = hash("sha256", $token);
  $expiry = date("Y-m-d H:i:s", time() + 60 * 6);
  $isToken = $ob->updateToken($userEmail, $token_hash, $expiry);
  $emailCheck = TRUE;
  if ($emailDb && $isToken) {
    $emailCheck = $emailObj->resetMail($userEmail, $token_hash);
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Mail</title>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  <div class="container">
    <h1>Send Mail</h1>
    <form action="" method="post">
      <div class="form-ele">
        <label for="email">Enter Email to Reset Password: </label>
        <input type="email" name="email" id="email">
      </div>
      <input type="submit" value="Send Link" name="submit">
    </form>
    <button>
      <a href="../SignUp/index.php">Go to login</a>
    </button>
    <h1>
      <?php
        if (isset($_POST['submit']) && !$emailDb) {
          echo 'Entered Email is not in the Database.';
        }
        else if (isset($_POST['submit']) && $emailCheck) {
          echo 'Mail Sent!!! please Check your inbox.';
        }
        else if (isset($_POST['submit']) && !$emailCheck) {
          echo 'There is some problem to send Mail.';
        }
      ?>
    </h1>
  </div>
</body>
</html>
