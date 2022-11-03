<?php

include 'dbconnect.php';

$userID = $_GET['userID'];

$approve_stmt = $dbconnect->prepare("UPDATE user SET level = 1 WHERE userID = $userID");
$approve_stmt->execute();

header('Location: index.php?page=adminapprove');

?>