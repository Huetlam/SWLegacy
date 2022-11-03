<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="customform.css">
  </head>
<?php
if ($_SESSION['session']['level'] !=2){
  header('Location: index.php?error=permss');
}

include 'dbconnect.php';
$unit_stmt = $dbconnect->prepare("SELECT units.*, unittype.unittype FROM units JOIN unittype ON units.typeID = unittype.typeID");
$unit_stmt->execute();
$unit_result = $unit_stmt->get_result();
$unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

$userID = $_SESSION['session']['userID'];
$user_stmt = $dbconnect->prepare("SELECT * FROM user WHERE userID = $userID");
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
$balance = $user_data['credits'];

?>

<div class="container">
  <div class="row">
    <p class="display-4">Edit Shop</p>
    <form  action="index.php?page=createunit" method="post">
        <button type="submit" name="submit">Create Unit</button>
      </form>
  </div>
  <div class="row">


<?php

foreach ($unit_data as $unit) {
  $id = $unit['unitID'];
  $name = $unit['unitname'];
  $price = $unit['unitprice'];
  $strength = $unit['unitstrength'];
  $type = $unit['unittype'];
  $image = $unit['image'];
  $upkeep = $unit['unitupkeep'];



  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name <a href='edititem.php?edit=delete&id=$id'>Delete</a></h5>";
      echo "<p class='card-text'>Strength: $strength x </p> <p class='card-text'>Price: $price </p> <p class='card-text'>Upkeep: $upkeep </p> <p class='card-text'> Type: $type</p>";

      echo "<form action='edititem.php?id=$id' method='post' enctype='multipart/form-data'>";
      ?>
        <input type="text" name="name" placeholder="Unit Name">
        <input type="number" name="strength" placeholder="Unit Strength">
        <input type="number" name="price" placeholder="Unit Price">
        <input type="number" name="upkeep" placeholder="Upkeep">
        <p></p><select name="type">
          <option value="0">Type</option>
          <option value="Space">Space</option>
          <option value="Ground">Ground</option>

        </select>
        <?php
        if (isset($_GET['error'])) {
          if ($_GET['error']=="type") {
            echo "Please enter a valid type";
          }
        }

        ?>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" name="submit" value="Update">
      </form>
  <?php
    echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>
</div>
</div>
