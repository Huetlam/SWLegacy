<?php
session_start();
include 'dbconnect.php';
$strategyID = $_GET['id'];

if ($_POST['name'] != "") {
  $strategyname = $_POST['name'];
  $editstrategy_sql = "UPDATE strategies SET `strategyname` = '$strategyname' WHERE strategyID = $strategyID";
  $editstrategy_qry = mysqli_query($dbconnect, $editstrategy_sql);

}
if ($_POST['type'] != 0) {
  $type = $_POST['type'];
  if ($type == "Attacking") {
    $type = 1;
}elseif ($type == "Defending"){
    $type = 2;
}else{
    $type = 3;
}
  $editstrategy_sql = "UPDATE strategies SET `strategytype` = '$type' WHERE strategyID = $strategyID";
  $editstrategy_qry = mysqli_query($dbconnect, $editstrategy_sql);

}
header("Location: index.php?page=editstrategy&strategy=$strategyID");

 ?>
