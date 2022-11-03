<?php
$fleetID = $_GET['fleet'];
$planetID = $_GET['planet'];

$fleetname_stmt = $dbconnect->prepare("SELECT fleetname FROM fleets WHERE fleetID = $fleetID");
$fleetname_stmt->execute();
$fleetname_result = $fleetname_stmt->get_result();
$fleetname_data = $fleetname_result->fetch_assoc();
$fleetname = $fleetname_data['fleetname'];

$fleet_stmt = $dbconnect->prepare("SELECT * FROM fleet_location WHERE fleetID = $fleetID");
$fleet_stmt->execute();
$fleet_result = $fleet_stmt->get_result();
if ($fleet_result->num_rows==1) {
  $fleet_stmt = $dbconnect->prepare("UPDATE `fleet_location` SET `planetID` = '$planetID', `fleetstatus` = 3 WHERE `fleet_location`.`fleetID` = $fleetID;");
  $fleet_stmt->execute();
}else {
  $fleet_stmt = $dbconnect->prepare("INSERT INTO fleet_location (fleetID, planetID, fleetstatus) VALUES ($fleetID, $planetID, 3)");
  $fleet_stmt->execute();

}

$movefleet_sql = "CREATE EVENT `moving$fleetID` ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 5 MINUTE ENABLE DO UPDATE fleet_location SET fleetstatus = 2 WHERE fleetID = $fleetID";
$movefleet_qry = mysqli_query($dbconnect, $movefleet_sql);


header('Location: index.php?page=fleets');
 ?>
