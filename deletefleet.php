<?php
include 'dbconnect.php';
if (!isset($_GET['fleet'])) {
  header('Location: index.php');
}
$fleetID = $_GET['fleet'];

$unit_stmt = $dbconnect->prepare("SELECT fleets.*, fleets_units.*, units.* FROM fleets JOIN fleets_units ON fleets_units.fleetID=fleets.fleetID JOIN units ON units.unitID = fleets_units.unitID WHERE fleets.fleetID = $fleetID");
$unit_stmt->execute();
$unit_result = $unit_stmt->get_result();
$unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

foreach ($unit_data as $row) {
  $amount = $row['amount'];
  $unitID = $row['unitID'];

  $addunit_stmt = $dbconnect->prepare("UPDATE `unit_user` SET availableamount = availableamount+'$amount' WHERE unitID = '$unitID'");
  $addunit_stmt->execute();
}

$delete_sql = "DELETE FROM `fleets` WHERE `fleets`.`fleetID` = '$fleetID'";
$delete_qry = mysqli_query($dbconnect, $delete_sql);

header('Location: index.php?page=fleets');

 ?>
