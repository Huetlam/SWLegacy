<?php
include 'dbconnect.php';
session_start();
$userID = $_SESSION['session']['userID'];
$unitID=$_GET['item'];
$roleID = $_GET['role'];


  $roleID_stmt = $dbconnect->prepare("SELECT * FROM roles_units WHERE `roleID` = '$roleID' AND `unitID` = '$unitID'");
  $roleID_stmt->execute();
  $roleID_result = $roleID_stmt->get_result();
  $roleID_data = $roleID_result->fetch_all(MYSQLI_ASSOC);

  if (mysqli_num_rows($roleID_result) == 0) {

    $additem_stmt = $dbconnect->prepare("INSERT INTO roles_units (`roleID`, `unitID`) VALUES ('$roleID', '$unitID')");
    $additem_stmt->execute();


  }else {
    header("Location: index.php?page=editrole&role=$roleID&error=exist");

  }


header("Location: index.php?page=editrole&role=$roleID&success=success");
 ?>
