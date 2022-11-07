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
            echo '<div class="col-3 p-3">';
            ?>
            
                    <?php
                        echo '<div class="card" style="width: 18rem; height: 100%;">';
                        ?>
                        <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <?php
                                echo "<button class='nav-link active' id='home-tab' data-bs-toggle='tab' data-bs-target='#home$id' type='button' role='tab' aria-controls='home' aria-selected='true'>Stats</button>";
                                ?>
                            </li>
                            <li class="nav-item" role="presentation">
                                <?php
                                echo "<button class='nav-link' id='profile-tab' data-bs-toggle='tab' data-bs-target='#profile$id' type='button' role='tab' aria-controls='profile' aria-selected='false'>Edit</button>";
                                ?>
                            </li>
                        </ul>
                        </div>
                        <?php
                        echo "<img src=uploads/$image class='card-img-top' alt='...'>";
                            echo '<div class="card-body">';
                                echo '<div class="tab-content" id="myTabContent">';
                                    echo "<div class='tab-pane fade show active text-light' id='home$id' role='tabpanel' aria-labelledby='home-tab'>";
                                        echo "<h5 class='card-title'>$name</h5>";
                                        echo "<p class='card-text'> Class: $unitname</p>";
                                        echo "<p class='card-text'> Health: $health</p>";
                                        echo "<p class='card-text'> Power: $power</p>";
                                        echo "<p class='card-text'> Shielding: $shielding</p>";
                                        echo "<p class='card-text'> Carry Capacity: $carrycapacity</p>";
                                        echo "<p class='card-text'> Type: $unittype</p>";
                                    echo '</div>';
                                    echo "<div class='tab-pane fade show text-light' id='profile$id' role='tabpanel' aria-labelledby='profile-tab'>";
                                        echo "<h5 class='card-title'>$name</h5>";
                                        
                                        echo "<form action='index.php?page=changeunitname&id=$id&u=$unitclassID' method='post'>";
                                            echo '<input type="text" name ="name" placeholder="New Unit Name" maxlength="50" required>';
                                            echo '<input type="submit" class="btn btn-success" name="submit" value="Change Name">';
                                        echo "</form>";
                                        echo "<form action='index.php?page=deleteunit&id=$id&u=$unitclassID' method='post'>";
                                            echo '<input type="submit" class="btn btn-danger" name="submit" value="Disband Unit">';
                                        echo "</form>";
                                    echo '</div>';
                                echo '</div>';
                            echo "</div>";
                        echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>