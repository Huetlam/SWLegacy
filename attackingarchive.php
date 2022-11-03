<?php
include 'dbconnect.php';

$fleetID = $_GET['fleet'];
$planetID = $_GET['planet'];

$move_stmt = $dbconnect->prepare("UPDATE fleet_location SET planetID = $planetID WHERE fleetID = $fleetID;");
$move_stmt->execute();

$move1_stmt = $dbconnect->prepare(" UPDATE fleet_location SET status = 3 WHERE fleetID = $fleetID;");
$move1_stmt->execute();

$defendingfleets_stmt = $dbconnect->prepare("SELECT fleetID FROM fleet_location WHERE planetID = $planetID AND status = 1");
$defendingfleets_stmt->execute();
$defendingfleets_result = $defendingfleets_stmt->get_result();
$defendingfleets_data = $defendingfleets_result->fetch_all(MYSQLI_ASSOC);

$strength_stmt = $dbconnect->prepare("SELECT SUM(units.unitstrength*fleets_units.amount) AS totalstrength FROM units JOIN fleets_units ON units.unitID = fleets_units.unitID WHERE units.unitID = fleets_units.unitID AND fleets_units.fleetID = $fleetID;");
$strength_stmt->execute();
$strength_result = $strength_stmt->get_result();
$strength_data = $strength_result->fetch_assoc();

$attacking = $strength_data['totalstrength'];
echo "Attacking: $attacking";

$defending_stmt = $dbconnect->prepare("SELECT SUM(units.unitstrength*fleets_units.amount)
AS defending
FROM units
JOIN fleets_units ON units.unitID = fleets_units.unitID
JOIN fleet_location ON fleet_location.fleetID = fleets_units.fleetID
JOIN planets ON planets.planetID=fleet_location.planetID
WHERE fleet_location.status = 1
AND planets.planetID = $planetID;");
$defending_stmt->execute();
$defending_result = $defending_stmt->get_result();
$defending_data = $defending_result->fetch_assoc();

$defending = $defending_data['defending'];

echo " vs Defending: $defending";
echo "<br>";
if ($defending>=$attacking) {
  echo "Defending Wins";
  $defendingattrition = $attacking/$defending;
  // echo "<br>";
  echo "Defending: $defendingattrition";
  $attackingattrition = $defending/$attacking;
  // echo "<br>";
  echo "Attacking: $attackingattrition";
}else {
  echo "Attacking Wins";
  $attackingattrition = $defending/$attacking;
  // echo "<br>";
  echo "Attacking: $attackingattrition";
  $defendingattrition = $attacking/$defending;
  // echo "<br>";
  echo "Defending: $defendingattrition";
}


//Attacking Losses

$amount_stmt = $dbconnect->prepare("SELECT SUM(fleets_units.amount) AS starship FROM fleets_units JOIN units ON fleets_units.unitID = units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleetID = $fleetID AND unittype = 'Starship'");
$amount_stmt->execute();
$amount_result = $amount_stmt->get_result();
$amount_data = $amount_result->fetch_assoc();

$starship = $amount_data['starship'];
echo "<br>";

echo "$starship";
echo "<br>";

$starship_loss = $starship*$attackingattrition;
$starship_loss = number_format($starship_loss);
echo "$starship_loss total";

$losses_stmt = $dbconnect->prepare("SELECT units.unitname, fleets_units.amount FROM units JOIN fleets_units ON units.unitID = fleets_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets_units.fleetID = $fleetID AND unittype = 'Starship'");
$losses_stmt->execute();
$losses_result = $losses_stmt->get_result();
$losses_data = $losses_result->fetch_all(MYSQLI_ASSOC);
  $losses = 0;
  $loss_list[] = array();
  foreach ($losses_data as $units) {
    $unitamount = $units['amount'];
    $unitname = $units['unitname'];
    $unitloss = $unitamount*$attackingattrition;
    echo "<br>";
    $random_num = rand(1, $unitamount);
    $lossamount = $random_num*$attackingattrition;
    $lossamount = number_format($lossamount);

    $attackingloss_list[] = array("name" => $unitname, "amount" => $lossamount);



  }


// Defending Losses

foreach ($defendingfleets_data as $counter) {
  $defendingfleetID = $counter['fleetID'];
  $amount_stmt = $dbconnect->prepare("SELECT SUM(fleets_units.amount) AS starship FROM fleets_units JOIN units ON fleets_units.unitID = units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets_units.fleetID = $defendingfleetID AND unittype = 'Starship'");
  $amount_stmt->execute();
  $amount_result = $amount_stmt->get_result();
  $amount_data = $amount_result->fetch_assoc();

  $starship = $amount_data['starship'];
  echo "<br>";

  $starship_loss = $starship*$defendingattrition;
  $starship_loss = number_format($starship_loss);
  echo "$starship_loss total";

  $losses_stmt = $dbconnect->prepare("SELECT units.unitname, fleets_units.amount FROM units JOIN fleets_units ON units.unitID = fleets_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets_units.fleetID = $defendingfleetID AND unittype = 'Starship'");
  $losses_stmt->execute();
  $losses_result = $losses_stmt->get_result();
  $losses_data = $losses_result->fetch_all(MYSQLI_ASSOC);
    $losses = 0;
    $loss_list[] = array();
    foreach ($losses_data as $units) {
      $unitamount = $units['amount'];
      $unitname = $units['unitname'];
      echo "<br>";
      $random_num = rand(1, $unitamount);
      $lossamount = $random_num*$defendingattrition;
      $lossamount = number_format($lossamount);

      $removeunit_stmt = $dbconnect->prepare("UPDATE fleets_units JOIN units ON fleets_units.unitID = units.unitID SET amount = amount-$lossamount WHERE fleetID = $fleetID AND unitname = '$unitname';");
      $removeunit_stmt->execute();
      $removeunit1_stmt = $dbconnect->prepare("UPDATE unit_user JOIN units ON unit_user.unitID = units.unitID JOIN fleets_units ON unit_user.unitID = fleets_units.unitID SET unit_user.amount = unit_user.amount-$lossamount WHERE fleetID = $fleetID AND unitname = '$unitname';");
      $removeunit1_stmt->execute();




    }
}

echo "Attacking Losses:";
foreach ($attackingloss_list as $loss) {
  $unitname = $loss['name'];
  $amount = $loss['amount'];
  echo "<br>";
  echo "$amount $unitname";
  $removeunit_stmt = $dbconnect->prepare("UPDATE fleets_units JOIN units ON fleets_units.unitID = units.unitID SET amount = amount-$amount WHERE fleetID = $fleetID AND unitname = '$unitname';");
  $removeunit_stmt->execute();
  $removeunit1_stmt = $dbconnect->prepare("UPDATE unit_user JOIN units ON unit_user.unitID = units.unitID JOIN fleets_units ON unit_user.unitID = fleets_units.unitID SET unit_user.amount = unit_user.amount-$amount WHERE fleetID = $fleetID AND unitname = '$unitname';");
  $removeunit1_stmt->execute();
}
echo "Defending Losses:";
foreach ($defendingloss_list as $loss) {
  $unitname = $loss['name'];
  $amount = $loss['amount'];
  echo "<br>";
  echo "$amount $unitname";
  $removeunit_stmt = $dbconnect->prepare("UPDATE fleets_units JOIN units ON fleets_units.unitID = units.unitID SET amount = amount-$amount WHERE fleetID = $fleetID AND unitname = '$unitname';");
  $removeunit_stmt->execute();
  $removeunit1_stmt = $dbconnect->prepare("UPDATE unit_user JOIN units ON unit_user.unitID = units.unitID JOIN fleets_units ON unit_user.unitID = fleets_units.unitID SET unit_user.amount = unit_user.amount-$amount WHERE fleetID = $fleetID AND unitname = '$unitname';");
  $removeunit1_stmt->execute();
}
  ?>
