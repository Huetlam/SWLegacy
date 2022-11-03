<?php

$planetID = $_GET['planet'];
$fleetID = $_GET['fleet'];
$userID = $_SESSION['session']['userID'];

$planetcheck_stmt = $dbconnect->prepare("SELECT planetname FROM planets WHERE planetID = $planetID");
$planetcheck_stmt->execute();
$planetcheck_result = $planetcheck_stmt->get_result();
$planetcheck_data = $planetcheck_result->fetch_assoc();

if ($planetcheck_result->num_rows != 1){
    echo "Slight problem";
}else{
    $planetname = $planetcheck_data['planetname'];

    $errorcatch_stmt = $dbconnect->prepare("SELECT * FROM fleets WHERE fleetID = $fleetID AND userID = $userID");
    $errorcatch_stmt->execute();
    $errorcatch_result = $errorcatch_stmt->get_result();
    $errorcatch_data = $errorcatch_result->fetch_assoc();

    if ($errorcatch_result->num_rows == 0){
        header("Location: index.php?page=attack&planet=$planetID&error=lol");
    }else{

        $fleetname = $errorcatch_data['fleetname'];

        $battlecheck_stmt = $dbconnect->prepare("SELECT * FROM battles WHERE planetID = $planetID AND battlestatus = 3");
        $battlecheck_stmt->execute();
        $battlecheck_result = $battlecheck_stmt->get_result();

        if ($battlecheck_result->num_rows == 0){
            echo "New Battle";

            $battlenumber_stmt = $dbconnect->prepare("SELECT battlenumber FROM battles WHERE planetID = $planetID ORDER BY `battleID` DESC LIMIT 1");
            $battlenumber_stmt->execute();
            $battlenumber_result = $battlenumber_stmt->get_result();
            if ($battlenumber_result->num_rows == 0){
                $battlemake_stmt = $dbconnect->prepare("INSERT INTO battles (battlename, battlestatus, planetID, battlenumber) VALUES ('Battle of $planetname', 3, $planetID, 1)");
                $battlemake_stmt->execute();

                $battleID_stmt = $dbconnect->prepare("SELECT battleID FROM battles ORDER BY `battleID` DESC LIMIT 1");
                $battleID_stmt->execute();
                $battleID_result = $battleID_stmt->get_result();
                $battleID_data = $battleID_result->fetch_assoc();
                $battleID = $battleID_data['battleID'];

                $startbattle_sql = "CREATE EVENT `battleof$planetname` ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE ON COMPLETION NOT PRESERVE ENABLE DO UPDATE battles SET battlestatus = 2 WHERE battleID = $battleID";
                $startbattle_qry = mysqli_query($dbconnect, $startbattle_sql);
            }else{
                $battlenumber_data = $battlenumber_result->fetch_assoc();
                $battlenumber = $battlenumber_data['battlenumber'];
                $battlenumber = $battlenumber+1;
                $battlemake_stmt = $dbconnect->prepare("INSERT INTO battles (battlename, battlestatus, planetID, battlenumber) VALUES ('Battle of $planetname', 3, $planetID, $battlenumber)");
                $battlemake_stmt->execute();

                $battleID_stmt = $dbconnect->prepare("SELECT battleID FROM battles ORDER BY `battleID` DESC LIMIT 1");
                $battleID_stmt->execute();
                $battleID_result = $battleID_stmt->get_result();
                $battleID_data = $battleID_result->fetch_assoc();
                $battleID = $battleID_data['battleID'];

                $startbattle_sql = "CREATE EVENT `battleof$planetname$battlenumber` ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE ON COMPLETION NOT PRESERVE ENABLE DO UPDATE battles SET battlestatus = 2 WHERE battleID = $battleID";
                $startbattle_qry = mysqli_query($dbconnect, $startbattle_sql);

            }

        }
        $getbattleID_stmt = $dbconnect->prepare("SELECT battleID FROM battles WHERE planetID = $planetID AND battlestatus = 3 ORDER BY `battleID` LIMIT 1");
        $getbattleID_stmt->execute();
        $getbattleID_result = $getbattleID_stmt->get_result();
        $getbattleID_data = $getbattleID_result->fetch_assoc();
        $getbattleID = $getbattleID_data['battleID'];

        $movefleet_stmt = $dbconnect->prepare("INSERT INTO battles_fleets (battleID, fleetID, fleetstatus) VALUES ($getbattleID, $fleetID, 1)");
        $movefleet_stmt->execute();
        
        $fleetlocation_stmt = $dbconnect->prepare("SELECT fleetID FROM fleet_location WHERE fleetID = $fleetID");
        $fleetlocation_stmt->execute();
        $fleetlocation_result = $fleetlocation_stmt->get_result();
        
        if ($fleetlocation_result->num_rows == 0) {
            $fleetstatus_stmt = $dbconnect->prepare("INSERT INTO fleet_location (fleetID, planetID, fleetstatus) VALUES ($fleetID, $planetID, 3)");
            $fleetstatus_stmt->execute();
        }else{
            $fleetstatus_stmt = $dbconnect->prepare("UPDATE fleet_location SET fleetstatus = 3, planetID = $planetID WHERE fleetID = $fleetID");
            $fleetstatus_stmt->execute();
        }
        
        $fleetsunits_stmt = $dbconnect->prepare("SELECT unitID, amount FROM fleets_units WHERE fleetID = $fleetID");
        $fleetsunits_stmt->execute();
        $fleetsunits_result = $fleetsunits_stmt->get_result();
        $fleetsunits_data = $fleetsunits_result->fetch_all(MYSQLI_ASSOC);
        
        foreach ($fleetsunits_data as $unit) {
            $unitID = $unit['unitID'];
            $amount = $unit['amount'];

            $attackingunit_stmt = $dbconnect->prepare("INSERT INTO battles_fleets_units (battleID, fleetID, unitID, amount) VALUES ($getbattleID, $fleetID, $unitID, $amount)");
            $attackingunit_stmt->execute();
        }

        $movefleet_sql = "CREATE EVENT `moving$fleetID` ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 30 SECOND ON COMPLETION NOT PRESERVE ENABLE DO UPDATE fleet_location SET fleetstatus = 1 WHERE fleetID = $fleetID";
        $movefleet_qry = mysqli_query($dbconnect, $movefleet_sql);


        

    }
}

?>