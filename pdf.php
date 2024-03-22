<?php

session_start();
if (!isset($_SESSION["flag"])) {
  header("location: ./SignUp/index.php");
}
require 'vendor/autoload.php';
use Fpdf\Fpdf;
$fullName = "";
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
  if (isset($_POST['submit'])) {
      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $fullName = $firstName . ' ' . $lastName;
  }
}

$targetFile = "";
if (isset($_POST["submit"])) {
  $file = $_FILES['image'];
  $targetDir = "img/";
  $targetFile = $targetDir . basename($_FILES["image"]["name"]);
  $tmpName = $_FILES['image']['tmp_name'];
  $fileExt = explode('.', $targetFile);
  $fileType = strtolower($fileExt[1]);
  if ($fileType == "jpg" || $fileType == "png") {
    move_uploaded_file($tmpName, $targetFile);
  }
}

$phFlag=0;
$phNumber = $_POST['phone'];
if (isset($_POST['submit'])) {
  $phFlag = 0;
  $regex = '/^\+91[0-9]{10}$/';
  if (preg_match($regex, $phNumber)) {
    $phFlag = 1;
  }
}
$marksArray = explode("\n", $_POST['table']);
$email = $_POST['email'];

$pdf = new Fpdf();
$pdf -> AddPage();
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(0, 20, "PHP Basic Assignment", 1, 1, 'C');
$pdf -> Cell(20, 20, "NAME: ", 0, 0, 'L');
$pdf -> Cell(0, 20, strtoupper($fullName), 0, 1, 'L');
$pdf -> Cell(50, 20, "PHONE NUMBER: ", 0, 0, 'L');
$pdf -> Cell(0, 20, $phNumber, 0, 1, 'L');
$pdf -> Cell(40, 20, "USER EMAIL: ", 0, 0, 'L');
$pdf -> Cell(0, 20, $email, 0, 1, 'L');
$pdf -> cell(0, 20, "STUDENT TABLE", 1, 1, 'C');
$pdf -> Cell(100,15,"Subject",1,0, "C");
$pdf -> Cell(0,15,"Marks",1,1, "C");
foreach ($marksArray as $mark) {
  $marks = explode("|", $mark);
  $pdf -> Cell(100,10,strtoupper($marks[0]),1,0, "C");
  $pdf -> Cell(0,10,$marks[1],1,1, "C");
}
$pdf-> Image($targetFile,150,35,50,50);
$pdf->Output();

?>
