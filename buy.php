<?php
include 'dbconnect.php';
session_start();
$userID = $_SESSION['session']['userID'];
$faction_stmt = $dbconnect->prepare("SELECT factionID FROM user WHERE userID = $userID");
$faction_stmt->execute();
$faction_result = $faction_stmt->get_result();
$faction_data = $faction_result->fetch_assoc();
$factionID = $faction_data['factionID'];

$unitID=$_GET['item'];
$amount = $_POST['amount'];

$role_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_users.* FROM roles_units JOIN roles_users ON roles_units.roleID = roles_users.roleID WHERE roles_units.unitID = '$unitID' AND roles_users.userID = '$userID'");
$role_stmt->execute();
$role_result = $role_stmt->get_result();

if ($role_result->num_rows == 0) {
  $rolefaction_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_factions.* FROM roles_units JOIN roles_factions ON roles_units.roleID = roles_factions.roleID WHERE roles_units.unitID = '$unitID' AND roles_factions.factionID = '$factionID'");
  $rolefaction_stmt->execute();
  $rolefaction_result = $rolefaction_stmt->get_result();

  if ($rolefaction_result->num_rows ==0){
    header("Location: index.php?page=shop&role=$unitID");
  }else{ 
    
$item_stmt = $dbconnect->prepare("SELECT * FROM units WHERE unitID = $unitID");
$item_stmt->execute();
$item_result = $item_stmt->get_result();
$item_data = $item_result->fetch_assoc();

$price=$item_data['unitprice'];
$price=$price*$amount;
$upkeep=$item_data['unitupkeep'];
$upkeep=$upkeep*$amount;

echo "$price";

$credits_stmt = $dbconnect->prepare("SELECT credits, upkeep FROM user WHERE userID = '$userID'");
$credits_stmt->execute();
$credits_result = $credits_stmt->get_result();
$credits_data = $credits_result->fetch_assoc();

$credits=$credits_data['credits'];
$oldupkeep=$credits_data['upkeep'];
echo "- $credits";


if ($price<=$credits) {
  $newvalue = $credits-$price;
  echo "= $newvalue";
  $buy_stmt = $dbconnect->prepare("UPDATE user SET `credits` = '$newvalue' WHERE `userID` = '$userID'");
  $buy_stmt->execute();

  $newupkeep = $oldupkeep+$upkeep;
  $upkeep_stmt = $dbconnect->prepare("UPDATE user SET `upkeep` = '$newupkeep' WHERE `userID` = '$userID'");
  $upkeep_stmt->execute();

  $invcheck_stmt = $dbconnect->prepare("SELECT * FROM unit_user WHERE unitID = $unitID AND userID = $userID");
  $invcheck_stmt->execute();
  $invcheck_result = $invcheck_stmt->get_result();
  $invcheck_data = $invcheck_result->fetch_all(MYSQLI_ASSOC);

  if ($invcheck_result->num_rows == 0) {
    $additem_stmt = $dbconnect->prepare("INSERT INTO `unit_user` (userID, unitID, amount, availableamount) VALUES (?,?,?,?)");
    $additem_stmt->bind_param("iiii", $userID, $unitID, $amount, $amount);
    $additem_stmt->execute();
  }else {
    foreach ($invcheck_data as $units) {
      $invunitID = $units['unitID'];
      if ($invunitID == $unitID) {
        $unitamount = $units['amount'];
        $unitavailableamount = $units['availableamount'];
        $newamount = $unitamount+$amount;
        $newavailableamount = $unitavailableamount+$amount;
        $amount_stmt = $dbconnect->prepare("UPDATE unit_user SET `amount` = '$newamount', `availableamount` = $newavailableamount WHERE unitID = $invunitID");
        $amount_stmt->execute();
      }
    }
  }
  header("Location: index.php?page=shop&purchase=$unitID");
}else {
  echo "not enough";
  header('Location: index.php?page=shop&error=balance');
}

  }
}else{

$item_stmt = $dbconnect->prepare("SELECT * FROM units WHERE unitID = $unitID");
$item_stmt->execute();
$item_result = $item_stmt->get_result();
$item_data = $item_result->fetch_assoc();

$price=$item_data['unitprice'];
$price=$price*$amount;
$upkeep=$item_data['unitupkeep'];
$upkeep=$upkeep*$amount;

echo "$price";

$credits_stmt = $dbconnect->prepare("SELECT credits, upkeep FROM user WHERE userID = '$userID'");
$credits_stmt->execute();
$credits_result = $credits_stmt->get_result();
$credits_data = $credits_result->fetch_assoc();

$credits=$credits_data['credits'];
$oldupkeep=$credits_data['upkeep'];
echo "- $credits";


if ($price<=$credits) {
  $newvalue = $credits-$price;
  echo "= $newvalue";
  $buy_stmt = $dbconnect->prepare("UPDATE user SET `credits` = '$newvalue' WHERE `userID` = '$userID'");
  $buy_stmt->execute();

  $newupkeep = $oldupkeep+$upkeep;
  $upkeep_stmt = $dbconnect->prepare("UPDATE user SET `upkeep` = '$newupkeep' WHERE `userID` = '$userID'");
  $upkeep_stmt->execute();

  $invcheck_stmt = $dbconnect->prepare("SELECT * FROM unit_user WHERE unitID = $unitID AND userID = $userID");
  $invcheck_stmt->execute();
  $invcheck_result = $invcheck_stmt->get_result();
  $invcheck_data = $invcheck_result->fetch_all(MYSQLI_ASSOC);

  if ($invcheck_result->num_rows == 0) {
    $additem_stmt = $dbconnect->prepare("INSERT INTO `unit_user` (userID, unitID, amount, availableamount) VALUES (?,?,?,?)");
    $additem_stmt->bind_param("iiii", $userID, $unitID, $amount, $amount);
    $additem_stmt->execute();
  }else {
    foreach ($invcheck_data as $units) {
      $invunitID = $units['unitID'];
      if ($invunitID == $unitID) {
        $unitamount = $units['amount'];
        $unitavailableamount = $units['availableamount'];
        $newamount = $unitamount+$amount;
        $newavailableamount = $unitavailableamount+$amount;
        $amount_stmt = $dbconnect->prepare("UPDATE unit_user SET `amount` = '$newamount', `availableamount` = $newavailableamount WHERE unitID = $invunitID");
        $amount_stmt->execute();
      }
    }
  }
  header("Location: index.php?page=shop&purchase=$unitID");
}else {
  echo "not enough";
  header('Location: index.php?page=shop&error=balance');
}
}
 ?>
