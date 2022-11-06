<?php
$unitclassID = $_GET['u'];
$userID = $_SESSION['session']['userID'];

$unitstats_stmt = $dbconnect->prepare("SELECT units.unitID, units.unitname AS name, units.health, units.power, 
units.shielding, units.carrycapacity, unitclass.image, unittype.unittype, unitclass.unitname 
FROM units JOIN unitclass ON units.unitclassID = unitclass.unitclassID 
JOIN unittype ON unitclass.unittypeID = unittype.typeID 
WHERE units.userID = $userID AND units.unitclassID = $unitclassID");

$unitstats_stmt->execute();
$unitstats_result = $unitstats_stmt->get_result();
$unitstats_data = $unitstats_result->fetch_all(MYSQLI_ASSOC);
?>


<div class="container">
    <div class="row">
        <p class="display-4 title">Inventory</p>
    </div>
    <div class="row">
        <?php

        foreach ($unitstats_data as $unit) {
            $id = $unit['unitID'];
            $name = $unit['name'];
            $unitname = $unit['unitname'];
            $health = $unit['health'];
            $power = $unit['power'];
            $shielding = $unit['shielding'];
            $carrycapacity = $unit['carrycapacity'];
            $unittype = $unit['unittype'];
            $image = $unit['image'];
            echo '<div class="col-3">';

            echo '<div class="card" style="width: 18rem; height: 100%;">';
                echo "<img src=uploads/$image class='card-img-top' alt='...'>";
                echo '<div class="card-body">';
                    echo "<h5 class='card-title'>$name</h5>";
                    echo "<p class='card-text'> Class: $unitname</p>";
                    echo "<p class='card-text'> Health: $health</p>";
                    echo "<p class='card-text'> Power: $power</p>";
                    echo "<p class='card-text'> Shielding: $shielding</p>";
                    echo "<p class='card-text'> Carry Capacity: $carrycapacity</p>";
                    echo "<p class='card-text'> Type: $unittype</p>";

                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>