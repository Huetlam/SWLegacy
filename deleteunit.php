<?php
$unitclassID = $_GET['u'];

$deleteunit_stmt = $dbconnect->prepare("DELETE FROM unitclass WHERE unitclass.unitclassID = '$unitclassID'");
$deleteunit_stmt->execute();

$deleteunit_stmt = $dbconnect->prepare("DELETE FROM units WHERE units.unitclassID = '$unitclassID'");
$deleteunit_stmt->execute();

header("Location: index.php?page=editshop");

?>