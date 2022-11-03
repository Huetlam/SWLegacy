

<?php
include 'dbconnect.php';

$planetID = $_GET['planet'];

$name_stmt = $dbconnect->prepare("SELECT planetname FROM planets WHERE planetID = $planetID");
$name_stmt->execute();
$name_result = $name_stmt->get_result();
$name_data = $name_result->fetch_assoc();
$planetname = $name_data['planetname'];


$userID = $_SESSION['session']['userID'];

$fleet_stmt = $dbconnect->prepare("SELECT * FROM fleets WHERE userID = $userID");
$fleet_stmt->execute();
$fleet_result = $fleet_stmt->get_result();
$fleet_data = $fleet_result->fetch_all(MYSQLI_ASSOC);

$inv_stmt = $dbconnect->prepare("SELECT planets.*, faction.factionname, user.username FROM planets JOIN faction ON faction.factionID = planets.factionID JOIN user ON user.userID = planets.userID WHERE planets.planetID = $planetID ");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">
  <div class="row">
    <p class="display-4 text-white">Attack: <?php echo "$planetname"; ?></p>
  </div>
  <div class="row">
<?php
foreach ($inv_data as $unit) {
  $id = $unit['planetID'];
  $name = $unit['planetname'];
  $amount = $unit['planetincome'];
  $amount = number_format($amount);
  $morale = $unit['morale'];
  $faction =$unit['factionname'];
  $factionID = $unit['factionID'];
  if ($unit['userID']=="0") {
    $governor = "None";
  }else {
    $governor = $unit['username'];
  }

  $image = $unit['planetimg'];
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'> Income: $amount</p> <p class='card-text'> Faction: $faction</p> <p class='card-text'> Morale: $morale</p> <p class='card-text'> Governor: $governor</p>";
    echo "</div>";
  echo "</div>";
  echo "</div>";
}

foreach ($fleet_data as $fleet) {
  $fleetID = $fleet['fleetID'];
  $name = $fleet['fleetname'];
  $image = $fleet['image'];

  $unit_stmt = $dbconnect->prepare("SELECT fleets.*, fleets_units.*, units.*, unittype.unittype FROM fleets JOIN fleets_units ON fleets_units.fleetID=fleets.fleetID JOIN units ON units.unitID = fleets_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets.fleetID = $fleetID");
  $unit_stmt->execute();
  $unit_result = $unit_stmt->get_result();
  $unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);



  echo '<div class="col-3">';
  echo '<div class="card h-100">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'>Units:</p>";
      if (mysqli_num_rows($unit_result)==0) {
        echo "<p class='card-text'> None </p>";
      }else {

      foreach ($unit_data as $unit) {
        $unitname = $unit['unitname'];
        $unittype = $unit['unittype'];
        $unitstrength = $unit['unitstrength'];
        $amount = $unit['amount'];
        echo "<p class='card-text'>$unitname | Strength: $unitstrength | Type: $unittype | Amount: $amount</p>";

      }
    }
    echo "<a href='index.php?page=updatebattles&planet=$planetID&fleet=$fleetID' class='card-text btn btn-danger'>Attack</a>";
    echo "<div class='card-footer text-muted'> <a href='index.php?page=editfleet&fleet=$fleetID'>Edit Fleet</a> </div>";

    echo "</div>";
  echo "</div>";
  echo "</div>";

}

?>

</div>
</div>

<script src="js/bootstrap.min.js">
</script>
