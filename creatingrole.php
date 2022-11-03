<?php
$userID = $_SESSION['session']['userID'];
$name = $_POST['name'];

$newrole_sql = "INSERT INTO roles (rolename) VALUES ('$name')";
$newrole_qry = mysqli_query($dbconnect, $newrole_sql);


$roleid_stmt = $dbconnect->prepare("SELECT roleID FROM roles WHERE `rolename` = '$name'");
$roleid_stmt->execute();
$roleid_result = $roleid_stmt->get_result();
$roleid_data = $roleid_result->fetch_assoc();
$roleID = $roleid_data['roleID'];

header("Location: index.php?page=editrole&role=$roleID");
?>
