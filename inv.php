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

$inv_stmt = $dbconnect->prepare("SELECT unitclass.unitname, unitclass.image, units.unitID, COUNT(units.unitclassID) 'amount'
FROM Units
JOIN unitclass ON units.unitclassID = unitclass.unitclassID WHERE units.userID = $userID
GROUP BY units.unitclassID");
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
  $image = $unit['image'];
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'> Amount: $amount</p>  <a href='index.php?page=detailedinv&u=$id'>View All $name</a>";

    echo "</div>";
  echo "</div>";
  echo "</div>";
}
 ?>
</div>
</div>
