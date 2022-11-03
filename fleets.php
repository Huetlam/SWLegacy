<?php

include 'dbconnect.php';
$userID = $_SESSION['session']['userID'];

$fleet_stmt = $dbconnect->prepare("SELECT * FROM fleets WHERE userID = $userID");
$fleet_stmt->execute();
$fleet_result = $fleet_stmt->get_result();
$fleet_data = $fleet_result->fetch_all(MYSQLI_ASSOC);


 ?>
<div class="container">

  <div class="row">
    <div class="col">
      <p class="display-4">Fleets</p>
      <form  action="index.php?page=createfleet" method="post">
        <button type="submit" name="submit">Create Fleet</button>
      </form>
    </div>
  </div>
  <div class="row">


  
<?php


foreach ($fleet_data as $fleet) {
  $fleetID = $fleet['fleetID'];
  $name = $fleet['fleetname'];
  $image = $fleet['image'];

  $unit_stmt = $dbconnect->prepare("SELECT fleets.*, fleets_units.*, units.*, unittype.unittype FROM fleets JOIN fleets_units ON fleets_units.fleetID=fleets.fleetID JOIN units ON units.unitID = fleets_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets.fleetID = $fleetID");
  $unit_stmt->execute();
  $unit_result = $unit_stmt->get_result();
  $unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);



  echo '<div class="col-3">';
  echo '<div class="card" style="width: 18rem; height: 100%; background-color: #96939B; color: #000000;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      $location_stmt = $dbconnect->prepare("SELECT planets.planetname, fleet_location.fleetstatus FROM planets JOIN fleet_location ON fleet_location.planetID = planets.planetID WHERE fleet_location.fleetID = $fleetID");
      $location_stmt->execute();
      $location_result = $location_stmt->get_result();
      $location_data = $location_result->fetch_assoc();
      if ($location_result->num_rows!=1) {
        echo "<p class='card-text'><a class='move' href='index.php?page=movefleet&fleet=$fleetID'>Location: N/A </a></p>";
      }else{
        if ($location_data['fleetstatus'] == 3) {
          $location = $location_data['planetname'];
          echo"<p class='card-text'><a class='move' href='index.php?page=movefleet&fleet=$fleetID'>Location: Travelling to $location </a></p>";
        }else{
          $location = $location_data['planetname'];
          echo"<p class='card-text'><a class='move' href='index.php?page=movefleet&fleet=$fleetID'>Location: $location </a></p>";
        }
    }
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
    echo "<div class='card-footer text-muted'> <a href=index.php?page=editfleet&fleet=$fleetID>Edit Fleet</a> </div>";
    echo "</div>";
  echo "</div>";
  echo "</div>";

}
?>
</div>
</div>
