<?php
include 'dbconnect.php';
session_start();
$userID = $_SESSION['session']['userID'];
$unitID=$_GET['item'];
$fleetID = $_GET['fleet'];
$amount = $_POST['amount'];


$item_stmt = $dbconnect->prepare("SELECT * FROM unit_user WHERE unitID = '$unitID' AND userID = '$userID'");
$item_stmt->execute();
$item_result = $item_stmt->get_result();
$item_data = $item_result->fetch_assoc();

$oldamount = $item_data['availableamount'];

if ($item_data['availableamount']<$amount) {
  header('Location: index.php?page=editfleet&error=amount');
}else {

  $fleetID_stmt = $dbconnect->prepare("SELECT * FROM fleets_units WHERE `fleetID` = '$fleetID' AND `unitID` = '$unitID'");
  $fleetID_stmt->execute();
  $fleetID_result = $fleetID_stmt->get_result();
  $fleetID_data = $fleetID_result->fetch_all(MYSQLI_ASSOC);

  if (mysqli_num_rows($fleetID_result) == 0) {

    $additem_stmt = $dbconnect->prepare("INSERT INTO fleets_units (`fleetID`, `unitID`, `amount`) VALUES ('$fleetID', '$unitID', '$amount')");
    $additem_stmt->execute();

    $newamount = $oldamount-$amount;

    $takeitem2_stmt = $dbconnect->prepare("UPDATE unit_user SET `availableamount` = '$newamount' WHERE `unitID` = '$unitID'");
    $takeitem2_stmt->execute();

  }else {
    echo "Already there";
    foreach ($fleetID_data as $key) {
      $keyunitID = $key['unitID'];
      if ($keyunitID==$unitID) {
        echo "found it";
        $fleets_unitsID = $key['fleets_unitsID'];

        $takeitem_stmt = $dbconnect->prepare("UPDATE fleets_units SET `unitID` = '$unitID', `fleetID` = '$fleetID', `amount` = fleets_units.amount+$amount  WHERE `fleets_unitsID` = '$fleets_unitsID'");
        $takeitem_stmt->execute();


        $newamount = $oldamount-$amount;
        echo "$newamount";

        $takeitem2_stmt = $dbconnect->prepare("UPDATE unit_user SET `availableamount` = '$newamount' WHERE `unitID` = '$unitID'");
        $takeitem2_stmt->execute();

      }
    }

  }
}

header("Location: index.php?page=editfleet&fleet=$fleetID&success=success");
 ?>
