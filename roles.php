<?php

include 'dbconnect.php';

$role_stmt = $dbconnect->prepare("SELECT * FROM roles");
$role_stmt->execute();
$role_result = $role_stmt->get_result();
$role_data = $role_result->fetch_all(MYSQLI_ASSOC);


?>
<div class="container">

  <div class="row">
    <div class="col">
      <p class="display-4">Roles</p>
      <form  action="index.php?page=createrole" method="post">
        <button type="submit" name="submit">Create role</button>
      </form>
      <form action="index.php?page=addrole" method="post">
        <button type="submit" name="submit">Add roles to users</button>
      </form>
    </div>
  </div>
  <div class="row">


<?php


foreach ($role_data as $role) {
  $roleID = $role['roleID'];
  $name = $role['rolename'];

  $unit_stmt = $dbconnect->prepare("SELECT roles.*, roles_units.*, units.*, unittype.unittype FROM roles JOIN roles_units ON roles_units.roleID=roles.roleID JOIN units ON units.unitID = roles_units.unitID JOIN unittype ON units.typeID = unittype.typeID WHERE roles.roleID = $roleID");
  $unit_stmt->execute();
  $unit_result = $unit_stmt->get_result();
  $unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);



  echo '<div class="col-3">';
  echo '<div class="card" style="width: 18rem; height: 100%;">';
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
        echo "<p class='card-text'>$unitname | Strength: $unitstrength | Type: $unittype</p>";

      }
    }
    echo "<div class='card-footer text-muted'> <a href=index.php?page=editrole&role=$roleID>Edit role</a> </div>";
    echo "</div>";
  echo "</div>";
  echo "</div>";

}
?>
</div>
</div>
