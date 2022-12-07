<?php
$unitID = $_GET['id'];
$unitclassID = $_GET['u'];
$userID = $_SESSION['session']['userID'];

$deleteunit_stmt = $dbconnect->prepare("DELETE FROM units WHERE unitID = '$unitID' AND userID = '$userID'");
$deleteunit_stmt->execute();
header("Location: index.php?page=detailedinv&u=$unitclassID");

?>