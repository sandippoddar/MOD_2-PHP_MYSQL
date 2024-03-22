<?php

require '../Database/Query.php';
require '../Validation.php';
require '../SendEmail.php';
if (isset($_POST["signup"])) {
  $otpmail = new SendEmail();
  $obSignup = new Query();
  $obValid = new Validation();
  $userName = $_POST['userName'];
  $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
  $email = $_POST['email'];
  $isExist = $obSignup->Duplicate($userName, $email);
  $errorArr = [];
  if (!$isExist) {
    $emailCheck = $obValid->isValidMail($email);
    $passCheck = $obValid->isPassword($_POST['password']);
    if (is_string($emailCheck)) {
      $errorArr[] = $emailCheck;
    }
    if (is_string($passCheck)) {
      $errorArr[] = $passCheck;
    }
  }
  if (is_string($isExist)) {
    $errorArr[] = $isExist;
  } 
  if (strlen($userName) == 0 || strlen($email) == 0 || strlen($_POST['password']) == 0) {
    $errorArr = [];
    $errorArr[] = 'Please Fill All the Fields!!!';
  }
  if (empty($errorArr)) {
    session_start();
    $otp = rand(10000,99999);
    $otpm = $otpmail->sendOtp($_POST['email'], $otp);
    $_SESSION['otp'] = $otp;
    $_SESSION['userName'] = $userName;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    header("location: otp.php");
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  <div class="container">
    <h1>Registration Page</h1>
    <form action="Registration.php" method="post">
      <div class="form-ele">
        <label for="userName">Enter User-Name:</label>
        <input type="text" name="userName" id="userName" value = "<?php echo isset($_POST['signup']) ? htmlspecialchars($_POST['userName'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="form-ele">
        <label for="email">Enter Email:</label>
        <input type="text" name="email" id="email" value = "<?php echo isset($_POST['signup']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="form-ele">
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password" value = "<?php echo isset($_POST['signup']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>">
      </div>
      <input type="submit" value="signup" name="signup">
    </form>
    <button>
      <a href="index.php">Go to login</a>
    </button>
    <div class="error">
      <?php if (isset($_POST['signup']) && count($errorArr)) : ?>
        <?php foreach( $errorArr as $error) : ?>
          <h1><?php echo $error; ?></h1>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
