<?php
include 'dbconnect.php';
$unitID = $_GET['item'];
$roleID = $_GET['role'];

$remove_stmt = $dbconnect->prepare("DELETE FROM `roles_units` WHERE `roles_units`.`roleID` = '$roleID' AND `roles_units`.`unitID` = '$unitID'");
$remove_stmt->execute();

header("Location: index.php?page=editrole&role=$roleID");
 ?>
