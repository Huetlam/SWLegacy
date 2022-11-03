<?php

$battle_stmt = $dbconnect->prepare("SELECT * FROM battles WHERE battlestatus = 1");
$battle_stmt->execute();
$battle_result = $battle_stmt->get_result();
$battle_data = $battle_result->fetch_all(MYSQLI_ASSOC);

$battle2_stmt = $dbconnect->prepare("SELECT * FROM battles WHERE battlestatus = 2");
$battle2_stmt->execute();
$battle2_result = $battle2_stmt->get_result();
$battle2_data = $battle2_result->fetch_all(MYSQLI_ASSOC);

foreach ($battle2_data as $info) {
    $battleID = $info['battleID'];

    $planetID_stmt = $dbconnect->prepare("SELECT planetID FROM battles WHERE battleID = $battleID");
    $planetID_stmt->execute();
    $planetID_result = $planetID_stmt->get_result();
    $planetID_data = $planetID_result->fetch_assoc();
    $planetID = $planetID_data['planetID'];

    $fleetsdefending_stmt = $dbconnect->prepare("SELECT fleetID FROM fleet_location WHERE planetID = $planetID AND fleetstatus = 2");
    $fleetsdefending_stmt->execute();
    $fleetsdefending_result = $fleetsdefending_stmt->get_result();
    $fleetsdefending_data = $fleetsdefending_result->fetch_all(MYSQLI_ASSOC);

    foreach ($fleetsdefending_data as $fleet) {
        $deffleetID = $fleet['fleetID'];
        
        $checkfleet_stmt = $dbconnect->prepare("SELECT fleetID FROM battles_fleets WHERE battleID = $battleID AND fleetID = $deffleetID");
        $checkfleet_stmt->execute();
        $checkfleet_result = $checkfleet_stmt->get_result();

        if ($checkfleet_result->num_rows == 0) {
            $defending_stmt = $dbconnect->prepare("INSERT INTO battles_fleets (battleID, fleetID, fleetstatus) VALUES ($battleID, $deffleetID, 2)");
            $defending_stmt->execute();
        }    

        $fleetunits_stmt = $dbconnect->prepare("SELECT unitID, amount FROM fleets_units WHERE fleetID = $deffleetID");
        $fleetunits_stmt->execute();
        $fleetunits_result = $fleetunits_stmt->get_result();
        $fleetunits_data = $fleetunits_result->fetch_all(MYSQLI_ASSOC);

        foreach ($fleetunits_data as $unit) {
            $unitID = $unit['unitID'];
            $amount = $unit['amount'];

            $defendingunit_stmt = $dbconnect->prepare("INSERT INTO battles_fleets_units (battleID, fleetID, unitID, amount) VALUES ($battleID, $deffleetID, $unitID, $amount)");
            $defendingunit_stmt->execute();
        }
    }

    $tap_stmt = $dbconnect->prepare("SELECT SUM(units.unitstrength*fleets_units.amount) AS totalstrength, faction.factionID AS attacker FROM units JOIN fleets_units ON units.unitID = fleets_units.unitID JOIN battles_fleets ON fleets_units.fleetID = battles_fleets.fleetID JOIN fleets ON fleets_units.fleetID = fleets.fleetID JOIN user on fleets.userID = user.userID 
    JOIN faction ON user.factionID = faction.factionID WHERE units.unitID = fleets_units.unitID AND battleID = $battleID AND battles_fleets.fleetstatus = 1");
    $tap_stmt->execute();
    $tap_result = $tap_stmt->get_result();
    $tap_data = $tap_result->fetch_assoc();
    $tap = $tap_data['totalstrength'];
    $attacker = $tap_data['attacker'];

    $tdp_stmt = $dbconnect->prepare("SELECT SUM(units.unitstrength*fleets_units.amount) AS totalstrength, faction.factionID AS defender FROM units JOIN fleets_units ON units.unitID = fleets_units.unitID JOIN battles_fleets ON fleets_units.fleetID = battles_fleets.fleetID 
    JOIN fleets ON fleets_units.fleetID = fleets.fleetID JOIN user on fleets.userID = user.userID 
    JOIN faction ON user.factionID = faction.factionID WHERE units.unitID = fleets_units.unitID AND battleID = $battleID AND battles_fleets.fleetstatus = 2");
    $tdp_stmt->execute();
    $tdp_result = $tdp_stmt->get_result();
    $tdp_data = $tdp_result->fetch_assoc();
    $tdp = $tdp_data['totalstrength'];
    $defender = $tdp_data['defender'];

    if ($tdp < $tap) {
        $victor = $attacker;

        $attackingfleetID_stmt = $dbconnect->prepare("SELECT fleetID FROM battles_fleets WHERE battleID = $battleID AND fleetstatus = 1");
        $attackingfleetID_stmt->execute();
        $attackingfleetID_result = $attackingfleetID_stmt->get_result();
        $attackingfleetID_data = $attackingfleetID_result->fetch_all(MYSQLI_ASSOC);

        $defendingfleetID_stmt = $dbconnect->prepare("SELECT fleetID FROM battles_fleets WHERE battleID = $battleID AND fleetstatus = 2");
        $defendingfleetID_stmt->execute();
        $defendingfleetID_result = $defendingfleetID_stmt->get_result();
        $defendingfleetID_data = $defendingfleetID_result->fetch_all(MYSQLI_ASSOC);

        foreach ($attackingfleetID_data as $fleetinfo) {
            $afleetID = $fleetinfo['fleetID'];
            $updateattack_stmt = $dbconnect->prepare("UPDATE fleet_location SET fleetstatus = 2 WHERE fleetID = $afleetID");
            $updateattack_stmt->execute();

        }
        foreach ($defendingfleetID_data as $fleetinfo) {
            $dfleetID = $fleetinfo['fleetID'];

            $defendingplanetID_stmt = $dbconnect->prepare("UPDATE fleet_location SET planetID = (SELECT planets.planetID FROM planets JOIN faction ON planets.factionID = faction.factionID JOIN user ON faction.factionID = user.factionID JOIN fleets ON user.userID = fleets.userID WHERE fleets.fleetID = $dfleetID LIMIT 1) WHERE fleetID = $dfleetID");
            $defendingplanetID_stmt->execute();

        }
    }else{
        $victor = $defender;

        $attackingfleetID_stmt = $dbconnect->prepare("SELECT fleetID FROM battles_fleets WHERE battleID = $battleID AND fleetstatus = 1");
        $attackingfleetID_stmt->execute();
        $attackingfleetID_result = $attackingfleetID_stmt->get_result();
        $attackingfleetID_data = $attackingfleetID_result->fetch_all(MYSQLI_ASSOC);

        foreach ($attackingfleetID_data as $fleetinfo) {
            $afleetID = $fleetinfo['fleetID'];
            $updateattack_stmt = $dbconnect->prepare("UPDATE fleet_location SET planetID = (SELECT planets.planetID FROM planets JOIN faction ON planets.factionID = faction.factionID JOIN user ON faction.factionID = user.factionID JOIN fleets ON user.userID = fleets.userID WHERE fleets.fleetID = $afleetID LIMIT 1) WHERE fleetID = $afleetID");
            $updateattack_stmt->execute();

        }
    }
    if ($tdp == 0){
        $tdp = 1;
    }
    if ($tap == 0){
        $tap = 1;
    }
    // defending attrition
    if ($tap < $tdp) {
        $c = ($tdp/$tap)*(-1);
    }else{
        $c = 0;
    }
    $m = $c +1;
    if ($m < 0) {
        $m = $m*(-1);
    }
    if ($m < 1) {
        $d = $m;
    } else {
        $d = 1/$m;
    }
    $def = (1-($tap/$tdp))*$d;
    echo "Def $def";
    // attacking attrition
    if ($tdp < $tap) {
        $c = ($tap/$tdp)*(-1);
        
    }else{
        $c = 0;
    }
    echo " C: $c";
    $m = $c +1;
    if ($m < 0) {
        $m = $m*(-1);
    }
    echo " M: $m";
    if ($m < 0) {
        $m = $m*(-1);
        echo " M: $m";
    }
    if ($m < 1) {
        $d = $m;
    } else {
        $d = 1/$m;
    }
    echo " D: $d";
    $atc = (1/($tdp/$tap))*$d;
    $atc = 1-$atc;
    echo "Atc $atc";
    $ap = $tap*$atc;
    $dp = $tdp*$def;
    
    $fleetsunits_stmt = $dbconnect->prepare("SELECT fleets_units.fleetID, fleets_units.unitID, fleets_units.amount, battles_fleets.fleetstatus FROM fleets_units JOIN battles_fleets ON fleets_units.fleetID = battles_fleets.fleetID WHERE battles_fleets.battleID = $battleID");
    $fleetsunits_stmt->execute();
    $fleetsunits_result = $fleetsunits_stmt->get_result();
    $fleetsunits_data = $fleetsunits_result->fetch_all(MYSQLI_ASSOC);

    foreach ($fleetsunits_data as $unitinfo) {
        $fleetID = $unitinfo['fleetID'];
        $unitID = $unitinfo['unitID'];
        $fleetstatus = $unitinfo['fleetstatus'];
        $amount = $unitinfo['amount'];

        if ($fleetstatus == 1) {
            $losses = $amount*$atc;
        }else{
            $losses = $amount*$def;
        }
        $newamount = $amount-$losses;
        $insertloss_stmt = $dbconnect->prepare("INSERT INTO battles_losses (battleID, fleetID, unitID, amount) VALUES ($battleID, $fleetID, $unitID, $losses)");
        $insertloss_stmt->execute();

        $fleetloss_stmt = $dbconnect->prepare("UPDATE fleets_units SET amount = $newamount WHERE fleetID = $fleetID AND unitID = $unitID");
        $fleetloss_stmt->execute();

        $totalloss_stmt = $dbconnect->prepare("UPDATE unit_user SET amount = amount-$losses WHERE unitID = $unitID");
        $totalloss_stmt->execute();
    }
    $updatebattle_stmt = $dbconnect->prepare("UPDATE battles SET battlestatus = 1, factionID = $victor WHERE battleID = $battleID");
    $updatebattle_stmt->execute();

    $updateplanet_stmt = $dbconnect->prepare("UPDATE planets SET factionID = $victor WHERE planetID = $planetID");
    $updateplanet_stmt->execute();
}
?>

<div class="container">
    <div class="row">
        <p class="display-4">Battles:</p>
    </div>
    <div class="row">


<?php

foreach ($battle_data as $unit) {
    $id = $unit['battleID'];
    $name = $unit['battlename'];
    $battlenumber = $unit['battlenumber'];

    if ($battlenumber == 1){
        $battlenumber = "1st";
    }elseif ($battlenumber == 2){
        $battlenumber = "2nd";
    }elseif ($battlenumber == 3){
        $battlenumber = "3rd";
    }else{
        $battlenumber .= "th";
    }

    echo '<div class="col-3 p-3">';
        echo '<div class="card" style="width: 18rem; height: 100%;">';
            echo '<div class="card-body">';
                echo "<h5 class='card-title'>$battlenumber $name</h5>";
                echo "<a class='text-light btn btn-success' href='index.php?page=battledetails&gd=$id'>View Details</a>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
}
?>
</div>
</div>
<script src="js/bootstrap.min.js">
</script>
