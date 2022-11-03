<?php
if (!isset($_GET['role'])) {
  header('Location: index.php');
}
$roleID = $_GET['role'];
$username=$_SESSION['session']['username'];
$userID = $_SESSION['session']['userID'];

$role_stmt = $dbconnect->prepare("SELECT * FROM roles WHERE roleID = '$roleID'");
$role_stmt->execute();
$role_result = $role_stmt->get_result();
$role_data = $role_result->fetch_assoc();

$rolename = $role_data['rolename'];
 ?>
<div class="container">

  <div class="row">
    <div class="col">
      <p class="display-4">Edit Role: <?php echo $rolename ?></p>
    </div>
  </div>
  <div class="row">
<?php


  $unit_stmt = $dbconnect->prepare("SELECT roles.*, roles_units.*, units.unitname FROM roles JOIN roles_units ON roles_units.roleID=roles.roleID JOIN units ON units.unitID = roles_units.unitID WHERE roles.roleID = $roleID");
  $unit_stmt->execute();
  $unit_result = $unit_stmt->get_result();
  $unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

  echo '<div class="col-3">';
  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$rolename</h5>";
      echo "<p class='card-text'>Units:</p>";
      if (mysqli_num_rows($unit_result)==0) {
        echo "<p class='card-text'> None </p>";
      }else {

      foreach ($unit_data as $unit) {
        $id = $unit['unitID'];
        $unitname = $unit['unitname'];
        echo "<p class='card-text'>$unitname <a href='removeroleitem.php?role=$roleID&item=$id'>Remove from Role</a>
</p>";

      }
    }

    echo "</div>";
  echo "</div>";
  echo "</div>";


$inv_stmt = $dbconnect->prepare("SELECT units.* FROM units");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);

if (mysqli_num_rows($inv_result)==0) {
echo "You have no units to add sorry. Try removing units from fleets or buying some more";
}

foreach ($inv_data as $item) {
  $id = $item['unitID'];
  $name = $item['unitname'];
  $image = $item['image'];
  echo '<div class="col-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo "<img src=uploads/$image class='card-img-top' alt='...'>";
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";

      echo "<form action='addroleitem.php?role=$roleID&item=$id' method='post'>";
      ?>
        <button type="submit" class="btn btn-success" name="button">Add to Role</button>
      </form>
      <?php
    echo "</div>";
  echo "</div>";
  echo "</div>";

}
 ?>

</div>
</div>
