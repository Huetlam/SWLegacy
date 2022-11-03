<?php
$userID = $_SESSION['session']['userID'];
$name = $_POST['name'];
$type = $_POST['typelist'];
echo $type;
if ($type == "Attacking") {
    $typeID = 1;
}elseif ($type == "Defending"){
    $typeID = 2;
}else{
    $typeID = 3;
}

$newstrategy_sql = "INSERT INTO strategies (strategyname, strategytype) VALUES ('$name', '$typeID')";
$newstrategy_qry = mysqli_query($dbconnect, $newstrategy_sql);


$strategyid_stmt = $dbconnect->prepare("SELECT strategyID FROM strategies WHERE `strategyname` = '$name'");
$strategyid_stmt->execute();
$strategyid_result = $strategyid_stmt->get_result();
$strategyid_data = $strategyid_result->fetch_assoc();
$strategyID = $strategyid_data['strategyID'];

header("Location: index.php?page=editstrategy&strategy=$strategyID");
?>
