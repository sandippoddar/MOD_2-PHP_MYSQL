<?php
  
session_start();
require '../Database/Query.php';
$obSignup = new Query();
$otp = $_POST['otp'];
$errorArr = [];
if (isset($_POST['submit'])) {
  if ($_SESSION['otp'] == $otp) {
    $obSignup->Insert($_SESSION['userName'], $_SESSION['email'], $_SESSION['password']);
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
  }
  $errorArr[] = 'Enter Valid OTP!! Check Your Mail!!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP VERIFICATION</title>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  <div class="container">
    <h1>Verify Your OTP</h1>
    <form action="otp.php" method="post">
      <div class="form-ele">
        <label for="otp">Enter Your OTP: </label>
        <input type="text" name="otp" id="otp">
      </div>
      <input type="submit" value="Verify" name="submit">
    </form>
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
