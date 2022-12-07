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
$counter = 0;

$unitstats_stmt = $dbconnect->prepare("SELECT * from unitclass WHERE unitclassID = $unitID");
$unitstats_stmt->execute();
$unitstats_result = $unitstats_stmt->get_result();
if ($unitstats_result->num_rows <= 0){
  header('Location: index.php?page=shop&error=unitnotfound');
}else{
  $unitstats_data = $unitstats_result->fetch_assoc();
}
$health = $unitstats_data['health'];
$power = $unitstats_data['power'];
$shielding = $unitstats_data['shielding'];
$carrycapacity = $unitstats_data['carrycapacity'];

$role_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_users.* FROM roles_units JOIN roles_users ON roles_units.roleID = roles_users.roleID WHERE roles_units.unitclassID = '$unitID' AND roles_users.userID = '$userID'");
$role_stmt->execute();
$role_result = $role_stmt->get_result();

if ($role_result->num_rows == 0) {
  $rolefaction_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_factions.* FROM roles_units JOIN roles_factions ON roles_units.roleID = roles_factions.roleID WHERE roles_units.unitclassID = '$unitID' AND roles_factions.factionID = '$factionID'");
  $rolefaction_stmt->execute();
  $rolefaction_result = $rolefaction_stmt->get_result();

  if ($rolefaction_result->num_rows ==0){
    header("Location: index.php?page=shop&role=$unitID");
  }else{ 
  do {
  
$item_stmt = $dbconnect->prepare("SELECT * FROM unitclass WHERE unitclassID = $unitID");
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

  $unitname_stmt = $dbconnect->prepare("SELECT unitname FROM unitnames ORDER BY RAND() LIMIT 1");
  $unitname_stmt->execute();
  $unitname_result = $unitname_stmt->get_result();
  $unitname_data = $unitname_result->fetch_assoc();

  $unitname = $unitname_data['unitname'];

  $additem_stmt = $dbconnect->prepare("INSERT INTO `units` (`unitname`, `unitclassID`, `health`, `power`, `shielding`, `carrycapacity`, `userID`) 
  VALUES (?,?,?,?,?,?,?)");
  $additem_stmt->bind_param("siiiiii", $unitname, $unitID, $health, $power, $shielding, $carrycapacity, $userID);
  $additem_stmt->execute();

  header("Location: index.php?page=shop&purchase=$unitID");
}else {
  echo "not enough";
  header('Location: index.php?page=shop&error=balance');
}
$counter = $counter+1;
  } while ($counter < $amount);
  }
}else{

do{
  $item_stmt = $dbconnect->prepare("SELECT * FROM unitclass WHERE unitclassID = $unitID");
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

    $unitname_stmt = $dbconnect->prepare("SELECT unitname FROM unitnames ORDER BY RAND() LIMIT 1");
    $unitname_stmt->execute();
    $unitname_result = $unitname_stmt->get_result();
    $unitname_data = $unitname_result->fetch_assoc();

    $unitname = $unitname_data['unitname'];

    $additem_stmt = $dbconnect->prepare("INSERT INTO `units` (unitname, unitclassID, health, 'power', shielding, carrycapacity, userID) 
    VALUES (?,?,?,?,?,?,?)");
    $additem_stmt->bind_param("siiiiiii", $unitname, $unitID, $health, $power, $shielding, $carrycapacity, $userID);
    $additem_stmt->execute();
    
    header("Location: index.php?page=shop&purchase=$unitID");
  }else {
    echo "not enough";
    header('Location: index.php?page=shop&error=balance');
  }
  $counter = $counter +1;
} while ($counter < $amount);
}
 ?>
