<?php
session_start();
include 'dbconnect.php';
$username = $_SESSION['session']['username'];
$login_stmt = $dbconnect->prepare("SELECT * FROM user WHERE username = '$username' ORDER BY userID DESC LIMIT 1");
$login_stmt->execute();
$login_result = $login_stmt->get_result();
if ($login_result->num_rows==1) {

    $login_data = $login_result->fetch_assoc();

    $level = $login_data['level'];
    $userID = $login_data['userID'];

    unset($_SESSION['session']);
    $_SESSION['session']['username'] = "$username";
    $_SESSION['session']['level'] = $level;
    $_SESSION['session']['userID'] = $userID;
    echo $level;
    echo $username;
    if ($level==2 OR $level ==1 OR $level == 0) {
        echo "success";
        header('Location: index.php');

    }else {
        echo "huh";
        header('Location: login.php?error=huh');

    }
}else {
    echo "row";
    header("Location: login.php?error=rows");

}
?>
