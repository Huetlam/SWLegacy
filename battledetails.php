<?php
$battleID = $_GET['gd'];

$battlename_stmt = $dbconnect->prepare("SELECT battles.battlename, faction.factionname2, planets.planetimg FROM battles JOIN planets ON battles.planetID = planets.planetID JOIN faction on battles.factionID = faction.factionID WHERE battles.battleID = $battleID");
$battlename_stmt->execute();
$battlename_result = $battlename_stmt->get_result();
$battlename_data = $battlename_result->fetch_assoc();
$battlename = $battlename_data['battlename'];
$planetimg = $battlename_data['planetimg'];
$victor = $battlename_data['factionname2'];

$fleets_stmt = $dbconnect->prepare("SELECT fleetname, fleets.fleetID FROM fleets JOIN battles_fleets ON fleets.fleetID = battles_fleets.fleetID WHERE battleID = $battleID");
$fleets_stmt->execute();
$fleets_result = $fleets_stmt->get_result();
$fleets_data = $fleets_result->fetch_all(MYSQLI_ASSOC);

if($fleets_result->num_rows == 0){
    header('Location: index.php?page=battles');
}else{

    ?>

    <div class="container">

        <!-- Battle details and image row -->
        <div class="row mt-3">

            <!-- battle name and text column -->
            <div class="col-9">

                <!-- battle name row -->
                <div class="row">
                    <?php
                    echo "<p class='display-3'> $battlename </p>";
                    echo "<p class='h4'> $victor Victory </p>";
                    ?>
                </div>

                <!-- battle text row -->
                <div class="row">
                    <?php
                    echo "<p> Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean erat diam, tristique feugiat pulvinar eu, pharetra nec ante. Phasellus molestie, eros quis efficitur commodo, erat est rhoncus tortor, in mattis nulla nibh sit amet tellus. Duis condimentum dui id mattis maximus. Curabitur et nisl a ligula dapibus semper id id tortor. Aenean pharetra elit quis est elementum pellentesque. Donec mi dui, eleifend ac porttitor vel, tempus in quam. Nunc sed auctor massa. Donec ornare eu elit eu dignissim. Aliquam consectetur egestas tempor. Suspendisse mollis nunc consectetur blandit ullamcorper. Nullam quis sem id mauris egestas pellentesque at vitae ligula. Nulla quam leo, sodales eget egestas in, fringilla sed massa. Integer bibendum risus eu justo efficitur, nec dignissim nisl placerat.
                    </p>"
                    ?>
                </div>
            </div>

            <!-- planet Image row -->
            <div class="col-3">
                <?php
                echo "<img src='uploads/$planetimg' class='max-width: 100%; img-fluid height: auto; customrounded' alt='Planet Image'>";
                ?>
            </div>
        </div>
        <!-- fleets title row -->
        <div class="row">
            <p class="display-6">Fleets:</p>
        </div>

        <!-- fleets tables row -->
        <div class="row p-3">
            <?php
            foreach($fleets_data as $fleet){
                $fleetname = $fleet['fleetname'];
                $fleetID = $fleet['fleetID'];
                $fleetlosses_stmt = $dbconnect->prepare("SELECT battles_fleets_units.amount, units.unitname 
                FROM battles_fleets_units JOIN units ON battles_fleets_units.unitID = units.unitID 
                WHERE battles_fleets_units.battleID = $battleID AND battles_fleets_units.fleetID = $fleetID;
                ");
                $fleetlosses_stmt->execute();
                $fleetlosses_result = $fleetlosses_stmt->get_result();
                $fleetlosses_data = $fleetlosses_result->fetch_all(MYSQLI_ASSOC);
            ?>
                <!-- fleets table column -->
                <div class="col-5 mx-4">

                    <!-- fleet name row-->
                    <div class="row">
                        <?php
                        echo "<h3 class='fs-4'>$fleetname</h3>";
                        ?>
                    </div>

                    <!-- fleet units row -->
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Unit Name</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $c=0;
                                foreach ($fleetlosses_data as $unit) {
                                    $name = $unit['unitname'];
                                    $amount = $unit['amount'];
                                    $c = $c+1;
                                ?>
                                <tr>
                                    <?php
                                    echo "<th scope='row'>$c</th>";
                                    echo "<td>$name</td>";
                                    echo "<td>$amount</td>";

                                    ?>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- losses title row -->
        <div class="row">
            <p class="display-6">Losses:</p>
        </div>

        <!-- losses tables row -->
        <div class="row p-3">
            <?php
            foreach($fleets_data as $fleet){
                $fleetname = $fleet['fleetname'];
                $fleetID = $fleet['fleetID'];
                $fleetlosses_stmt = $dbconnect->prepare("SELECT battles_losses.amount, units.unitname, units.image
                                                FROM battles
                                                JOIN battles_losses ON battles.battleID=battles_losses.battleID
                                                JOIN planets ON battles.planetID=planets.planetID
                                                JOIN units ON battles_losses.unitID=units.unitID
                                                WHERE battles.battleID = $battleID AND battles_losses.fleetID = $fleetID;
                                                ");
                $fleetlosses_stmt->execute();
                $fleetlosses_result = $fleetlosses_stmt->get_result();
                $fleetlosses_data = $fleetlosses_result->fetch_all(MYSQLI_ASSOC);
            ?>
                <!-- losses table column -->
                <div class="col-5 mx-4">

                    <!-- fleet name row-->
                    <div class="row">
                        <?php
                        echo "<h3 class='fs-4'>$fleetname</h3>";
                        ?>
                    </div>

                    <!-- fleet losses row -->
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Unit Name</th>
                                    <th scope="col">Amount Lost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $c=0;
                                foreach ($fleetlosses_data as $unit) {
                                    $name = $unit['unitname'];
                                    $amount = $unit['amount'];
                                    $c = $c+1;
                                ?>
                                <tr>
                                    <?php
                                    echo "<th scope='row'>$c</th>";
                                    echo "<td>$name</td>";
                                    echo "<td>$amount</td>";

                                    ?>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

    </div>

<?php 
}
?>
