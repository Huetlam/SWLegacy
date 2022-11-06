
<?php
include 'dbconnect.php';
$unit_stmt = $dbconnect->prepare("SELECT unitclass.*, unittype.unittype FROM unitclass JOIN unittype ON unitclass.unittypeID = unittype.typeID");
$unit_stmt->execute();
$unit_result = $unit_stmt->get_result();
$unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

$userID = $_SESSION['session']['userID'];
$user_stmt = $dbconnect->prepare("SELECT * FROM user WHERE userID = $userID");
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
$balance = $user_data['credits'];
$factionID = $user_data['factionID'];

 ?>
<div class="container">
  <div class="row">
    <p class="display-4">Shop</p>
  </div>
  <div class="row">


<?php


foreach ($unit_data as $unit) {
  $id = $unit['unitclassID'];
  $name = $unit['unitname'];
  $price = $unit['unitprice'];
  $upkeep = $unit['unitupkeep'];
  $power = $unit['power'];
  $health = $unit['health'];
  $shielding = $unit['shielding'];
  $type = $unit['unittype'];
  $image = $unit['image'];
  $amount = $balance/$price;
  $amount = number_format($amount);
  $price = number_format($price);
  // $price = sprintf("%.3e", $price);
  $upkeep = number_format($upkeep);
  // $price = 

  $role_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_users.* FROM roles_units JOIN roles_users ON roles_units.roleID = roles_users.roleID WHERE roles_units.unitclassID = '$id' AND roles_users.userID = '$userID'");
  $role_stmt->execute();
  $role_result = $role_stmt->get_result();

  if ($role_result->num_rows == 0) {
    $rolefaction_stmt = $dbconnect->prepare("SELECT roles_units.*, roles_factions.* FROM roles_units JOIN roles_factions ON roles_units.roleID = roles_factions.roleID WHERE roles_units.unitclassID = '$id' AND roles_factions.factionID = '$factionID'");
    $rolefaction_stmt->execute();
    $rolefaction_result = $rolefaction_stmt->get_result();

    if ($rolefaction_result->num_rows ==0){
      $buyability = "No";
    }else {
      $buyability = "Yes";

    }
  }else {
    $buyability = "Yes";
  }

  echo '<div class="col-3 p-3">';
  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' style='height: 100%;' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      echo "<p class='card-text'>Power: $power </p>  <p class='card-text'>Health: $health</p><p class='card-text'>Shielding: $shielding </p> <p class='card-text'>Price: $price </p> <p class='card-text'>Upkeep: $upkeep</p> <p class='card-text'> Type: $type</p> <p class='card-text'> You Can Afford: $amount</p> <p class='card-text'> Can you buy it: $buyability</p>";
      echo "<form class='buyunit' action='buy.php?item=$id' method='post'>";
      ?>
      <p></p>
      <div class="input-group mb-3">

      <input placeholder='Amount' class="form-control" required type='number' name='amount' min='0'
      <?php echo " max='$amount'" ?> >

      <?php
      if ($buyability == "Yes"){
      ?>
      <input type="submit" class="btn btn-success" name="submit" value="Buy">
      <?php

      }else{
      ?>
      <input type="submit" class="btn btn-danger" name="submit" value="Buy">
      <?php
      }
      ?>
    </div>
    </form>
  <?php
    if (isset($_GET['purchase'])) {
      if ($_GET['purchase']==$id) {
        echo "Item Added to Inv!";
      }
    }
    if (isset($_GET['role'])) {
      if ($_GET['role']==$id) {
        echo "Sorry you can't buy that";
      }
    }
    echo "</div>";
  echo "</div>";
  echo "</div>";

}
?>
</div>
</div>
