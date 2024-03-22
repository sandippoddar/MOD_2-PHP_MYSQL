<?php

session_start();
if (!isset($_SESSION["flag"])) {
  header("location: index.php");
}
$_SESSION = array();
session_destroy();
header("location: index.php");
exit();
