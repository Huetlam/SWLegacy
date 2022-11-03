<?php
include 'dbconnect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$faction = $_POST['faction'];
if ($faction == "Galactic Empire") {
    $faction = 1;
}elseif ($faction == "Rebel Alliance") {
    $faction = 4;
}
$email_stmt = $dbconnect->prepare("SELECT email FROM user WHERE email = '$email'");
$email_stmt->execute();
$email_result = $email_stmt->get_result();

if ($email_result->num_rows != 0){
    header('Location: signup.php?error=email');
}else{

    $user_stmt = $dbconnect->prepare("SELECT username FROM user WHERE username = '$username'");
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    if ($user_result->num_rows != 0) {
        header('Location: signup.php?error=user');
    }else{
        $signup_stmt = $dbconnect->prepare("INSERT INTO user (username, password, email, level, factionID, credits) VALUES (?,?,?,0,?, 500000000)");
        $signup_stmt->bind_param("sssi", $username, $password, $email, $faction);
        $signup_stmt->execute();
        
        header('Location: index.php');
    }
    
}

?>
