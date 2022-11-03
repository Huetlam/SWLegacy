<?php
include 'dbconnect.php';
$name = $_POST['name'];
$region = $_POST['region'];

$region_stmt = $dbconnect->prepare("SELECT * FROM regions WHERE regionname = '$region'");
$region_stmt -> execute();
$region_result = $region_stmt->get_result();
$region_data = $region_result->fetch_assoc();
$regionID = $region_data['regionID'];

$newsector_sql = "INSERT INTO sectors (sectorname, regionID) VALUES ('$name', '$regionID')";
$newsector_qry = mysqli_query($dbconnect, $newsector_sql);


header("Location: index.php?page=createsector&success=success");
?>
