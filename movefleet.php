<?php

if (!isset($_GET['fleet'])) {
  ?>

  <div class="container">
    <div class="row">
      <p class="display-4">Move Fleet To:</p>
    </div>
    <div class="row">
      <div class="col-12">
        <h3>Sorry no Fleet has been selected</h3>
      </div>
    </div>
  </div>
  <?php
}else{
$fleetID = $_GET['fleet'];
$userID = $_SESSION['session']['userID'];

$faction_stmt = $dbconnect->prepare("SELECT factionID FROM user WHERE userID = $userID");
$faction_stmt->execute();
$faction_result = $faction_stmt->get_result();
$faction_data = $faction_result->fetch_assoc();
$factionID = $faction_data['factionID'];

$inv_stmt = $dbconnect->prepare("SELECT planets.*, faction.factionname, user.username FROM planets JOIN faction ON faction.factionID = planets.factionID JOIN user ON user.userID = planets.userID WHERE planets.factionID = $factionID");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
  <div class="row">
    <p class="display-4">Your Planets:</p>
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
  if ($unit['userID']=="0") {
    $governor = "None";
  }else {
    $governor = $unit['username'];
  }

  $image = $unit['planetimg'];
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' style='height: 100%;' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo " <h6 class='card-subtitle mb-2 text-muted aurebesh'>$name</h6>";
      echo "<p class='card-text'> Income: $amount</p> <p class='card-text'> Faction: $faction</p> <p class='card-text'> Morale: $morale</p> <p class='card-text'> Governor: $governor</p>";
      echo "<a class='text-light btn btn-success' href='index.php?page=move&planet=$id&fleet=$fleetID'>Move</a>";
    echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>
</div>
</div>
<script src="js/bootstrap.min.js">
</script>
<?php }
?>
