<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
<?php
include 'dbconnect.php';

$username=$_SESSION['session']['username'];

$userid_stmt = $dbconnect->prepare("SELECT userID FROM user WHERE `username` = '$username'");
$userid_stmt->execute();
$userid_result = $userid_stmt->get_result();
$userid_data = $userid_result->fetch_assoc();

$userID=$userid_data['userID'];

$inv_stmt = $dbconnect->prepare("SELECT units.*, user.*, unit_user.*, unittype.unittype FROM unit_user JOIN units ON unit_user.unitID=units.unitID JOIN user ON unit_user.userID=user.userID JOIN unittype ON units.typeID = unittype.typeID WHERE unit_user.userID=$userID");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
  <div class="row">
    <p class="display-4 title">Inventory</p>
  </div>
  <div class="row">


<?php

foreach ($inv_data as $unit) {
  $id = $unit['unitID'];
  $name = $unit['unitname'];
  $amount = $unit['amount'];
  $strength = $unit['unitstrength'];
  $type = $unit['unittype'];
  $image = $unit['image'];
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'>Strength: $strength x </p> <p class='card-text'> Type: $type</p> <p class='card-text'> You Have: $amount</p>";

    echo "</div>";
  echo "</div>";
  echo "</div>";
}
 ?>
</div>
</div>
