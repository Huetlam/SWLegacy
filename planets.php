<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="css/bootrap.min.css">
<link rel="stylesheet" href="custom.css">
  </head>
<?php
if (!isset($_GET['sector'])) {
  ?>

  <div class="container">
    <div class="row">
      <p class="display-4">Planets:</p>
    </div>
    <div class="row">
      <div class="col-12">
        <h3>Sorry no Sector has been selected</h3>
      </div>
    </div>
  </div>
  <?php
}else{
$sectorID = $_GET['sector'];
$sector = $_GET['name'];

$inv_stmt = $dbconnect->prepare("SELECT planets.*, faction.factionname, user.username FROM planets JOIN faction ON faction.factionID = planets.factionID JOIN user ON user.userID = planets.userID WHERE planets.sectorID = $sectorID");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);

$userID = $_SESSION['session']['userID'];
$user_stmt = $dbconnect->prepare("SELECT factionID FROM user WHERE userID = $userID");
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
$factionID = $user_data['factionID'];
?>


<div class="container">
  <div class="row">
    <p class="display-4"><?php echo "$sector"; ?> Planets:</p>
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
  $planetfactionID = $unit['factionID'];
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
      // echo " <h6 class='card-subtitle mb-2 text-muted'>$name</h6>";
      echo "<p class='card-text'> Income: $amount</p> <p class='card-text'> Faction: $faction</p> <p class='card-text'> Morale: $morale</p> <p class='card-text'> Governor: $governor</p>";
      if ($factionID != $planetfactionID) {
        echo "<a class='text-light btn btn-danger' href='index.php?page=attack&planet=$id'>Attack</a>";
      }
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
