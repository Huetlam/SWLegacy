<?php
$strategyID = $_GET['id'];

$delete_stmt = $dbconnect->prepare("DELETE FROM strategies WHERE strategyID = $strategyID");
$delete_stmt->execute();

header('Location: index.php?page=strategy');

?>