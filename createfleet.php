
<?php
include 'dbconnect.php';


$userID = $_SESSION['session']['userID'];
$user_stmt = $dbconnect->prepare("SELECT unit_user.*, units.* FROM unit_user JOIN units ON unit_user.unitID=units.unitID WHERE userID = $userID");
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_all(MYSQLI_ASSOC);


?>

  <form class="form-custom" action="index.php?page=creatingfleet" method="post" enctype="multipart/form-data">
    <h1>Create Fleet</h1>
    <input type="text" name="name" required placeholder="Fleet Name">
    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
    <input type="submit" name="submit" value="Submit">
    </form>
