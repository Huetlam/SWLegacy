<?php

include 'dbconnect.php';

$users_stmt = $dbconnect->prepare("SELECT user.*, faction.factionname FROM user JOIN faction ON user.factionID = faction.factionID WHERE level = 0");
$users_stmt->execute();
$users_result = $users_stmt->get_result();
$users_data = $users_result->fetch_all(MYSQLI_ASSOC);


?>
<div class="container">
    <div class="row">
        <div class="col">
            <p class="display-4">Users</p>
        </div>
    </div>
    <div class="row">


<?php


foreach ($users_data as $users) {
    $usersID = $users['userID'];
    $name = $users['username'];
    $faction = $users['factionname'];

    echo '<div class="col-3">';
        echo '<div class="card" style="width: 18rem; height: 100%;">';
            echo '<div class="card-body">';
            echo "<h5 class='card-title'>$name</h5>";
            echo "<p class='card-text'>Faction: $faction</p>";
            echo "<div class='card-footer text-muted button'> <a href=index.php?page=approveuser&userID=$usersID>Approve User</a> </div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";

}
?>
</div>
</div>
