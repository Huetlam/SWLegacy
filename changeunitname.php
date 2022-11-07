<?php
$unitID = $_GET['id'];
$newname = $_POST['name'];
$unitclassID = $_GET['u'];

$newname_stmt = $dbconnect->prepare("UPDATE units SET unitname = '$newname' WHERE unitID = $unitID");
$newname_stmt->execute();
header("Location: index.php?page=detailedinv&u=$unitclassID");

?>