<?php
include 'dbconnect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$login_stmt = $dbconnect->prepare("SELECT * FROM user WHERE username = '$username'");
$login_stmt->execute();
$login_result = $login_stmt->get_result();
if ($login_result->num_rows==1) {

  $login_data = $login_result->fetch_assoc();

  $datapassword = $login_data['password'];
  $level = $login_data['level'];
  $userID = $login_data['userID'];

  if ($password==$datapassword) {
    session_start();
    $_SESSION['session']['username'] = "$username";
    $_SESSION['session']['level'] = $level;
    $_SESSION['session']['userID'] = $userID;



    if ($level==2 OR $level ==1 OR $level == 0) {
      echo "success";
      header('Location: index.php');

  }else {
    echo "huh";
    header('Location: login.php?error=huh');

  }
}else {
  echo "password";
  header('Location: login.php?error=password');
}
}else {
  echo "row";
  header("Location: login.php?error=rows");

}
 ?>
