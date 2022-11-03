<?php
if (!isset($_GET['fleet'])) {
  header('Location: index.php');
}
$fleetID = $_GET['fleet'];
$username=$_SESSION['session']['username'];

$userid_stmt = $dbconnect->prepare("SELECT userID FROM user WHERE `username` = '$username'");
$userid_stmt->execute();
$userid_result = $userid_stmt->get_result();
$userid_data = $userid_result->fetch_assoc();

$userID=$userid_data['userID'];

$fleet_stmt = $dbconnect->prepare("SELECT * FROM fleets WHERE fleetID = '$fleetID'");
$fleet_stmt->execute();
$fleet_result = $fleet_stmt->get_result();
$fleet_data = $fleet_result->fetch_assoc();

$fleetID = $fleet_data['fleetID'];
$fleetname = $fleet_data['fleetname'];
$fleetimage = $fleet_data['image'];
 ?>
<div class="container">
  <div class="row">
    <div class="col">
      <p class="display-4">Edit Fleet: <?php echo $fleetname ?></p>
    </div>
  </div>
  <div class="row">

<?php



  $unit_stmt = $dbconnect->prepare("SELECT fleets.*, units.*, fleets_units.amount, unittype.unittype FROM fleets JOIN fleets_units ON fleets_units.fleetID=fleets.fleetID JOIN units ON units.unitID = fleets_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE fleets.fleetID = $fleetID");
  $unit_stmt->execute();
  $unit_result = $unit_stmt->get_result();
  $unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

  echo '<div class="col-3">';
  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$fleetimage class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$fleetname</h5>";
      echo "<h6 class='card-subtitle text-muted text-danger'><a style='text-decoration: none;' href='deletefleet.php?fleet=$fleetID'>Delete</a>
</h6>";
$location_stmt = $dbconnect->prepare("SELECT planets.planetname FROM planets JOIN fleet_location ON fleet_location.planetID = planets.planetID WHERE fleet_location.fleetID = $fleetID");
$location_stmt->execute();
$location_result = $location_stmt->get_result();
$location_data = $location_result->fetch_assoc();
if ($location_result->num_rows==0) {
  echo"<p class='card-text'><a class='' href='index.php?page=movefleet&fleet=$fleetID'>Move Fleet to a Planet</a></p>";
}else{
$location = $location_data['planetname'];
echo"<p class='card-text'>Location: $location</p>";
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

    echo "</div>";
  echo "</div>";
  echo "</div>";


$inv_stmt = $dbconnect->prepare("SELECT units.*, user.*, unit_user.*, unittype.unittype FROM unit_user JOIN units ON unit_user.unitID=units.unitID JOIN user ON unit_user.userID=user.userID JOIN unittype ON units.typeID = unittype.typeID WHERE unit_user.userID=$userID");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);

if (mysqli_num_rows($inv_result)==0) {
echo "<p class='white'> You have no units to add sorry. Try removing units from fleets or buying some more </p>";
}

foreach ($inv_data as $item) {
  $id = $item['unitID'];
  $name = $item['unitname'];
  $amount = $item['availableamount'];
  $strength = $item['unitstrength'];
  $type = $item['unittype'];
  $image = $item['image'];
  if ($amount>=1) {
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'>Strength: $strength x </p> <p class='card-text'> Type: $type</p> <p class='card-text'> You Can Add: $amount</p>";
      echo "<form class='buyunit' action='addunit.php?item=$id&fleet=$fleetID' method='post'>";
      ?>
      <p></p>
      <div class="input-group mb-3">
        <input placeholder='Amount' class="form-control" required type='number' name='amount' min='0'
        <?php echo " max='$amount'" ?> style="width: 75%;">


        <input type="submit" class="btn btn-success" style="width: 25%;" name="submit" value="Add">
      </div>
    </form>
  <?php
  if (isset($_GET['error'])) {
    if ($_GET['error']=="amount") {
      echo "You don't have that many";
    }
  }
    echo "</div>";
  echo "</div>";
  echo "</div>";
}
}
 ?>

</div>
</div>
