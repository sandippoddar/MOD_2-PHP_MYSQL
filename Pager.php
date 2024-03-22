<?php
session_start();
if (!isset($_SESSION["flag"])) {
  header("location: ./SignUp/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pager Page</title>
  <link rel="stylesheet" href="./CSS/pager.css">
</head>
<body>
  <div class = "container">
    <form method = "post" action = "pdf.php" enctype = "multipart/form-data">
      <h1>PHP BASIC</h1>
      
      <div class = "form-ele">
          <label for = "firstName">First Name:*</label>
          <input type = "text" name = "firstName" id = "firstName" maxlength = "20" pattern = "[A-Za-z]+" required>
          <p class = "wrongFname"></p>
      </div>
      <div class = "form-ele">
          <label for = "lastName">Last name:*</label>
          <input type = "text" name = "lastName" id = "lastName" maxlength = "20" pattern = "[A-Za-z]+" required>
          <p class = "wrongLname"></p>
      </div>
      <div class = "form-ele">
          <label for = "fullName"> Full Name: </label>
          <input type = "text" name = "fullName" id = "fullName" value = "" disabled>
      </div>
      <div class = "form-ele">
          <label for = "image">Enter Image</label>
          <input type = "file" name = "image" id = "image">
      </div>
      <div class = "form-ele">
          <label for = "phone">Enter Phone No. (+91)</label>
            <input type = "text" name = "phone" id="phone" maxlength="13">
      </div>
      <div class = "form-ele">
          <label for = "email">Enter User Email:</label>
          <input type = "text" name = "email" id="email">
      </div>
      <div class = "form-ele">
          <label for = "table">Enter Marks (Subject|Marks):</label>
          <textarea name = "table" id = "table" cols = "30" rows = "5"></textarea>
      </div>
      
      <div class = "form-ele btn">
          <input type = "submit" name = "submit" value = "Submit">
      </div>
    </form>
    <button><a href="./SignUp/Logout.php">Logout</a></button>
  </div>
  <script src = "./JS/pager.js"></script>
</body>
</html>