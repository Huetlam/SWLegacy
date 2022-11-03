<?php
session_start();
include 'dbconnect.php';
$unitID = $_GET['id'];
if (isset($_GET['edit'])) {
  $editunit_sql = "DELETE FROM `units` WHERE `units`.`unitID` = '$unitID'";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);
  header('Location: editshop.php');
}


if ($_FILES["fileToUpload"]["name"]=="") {
}else{
$photo = $_FILES["fileToUpload"]["name"];

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


        $editunit_sql = "UPDATE units SET `image` = '$photo' WHERE unitID = $unitID";
        $editunit_qry = mysqli_query($dbconnect, $editunit_sql);



      echo "Success";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
if ($_POST['name'] != "") {
  $unitname = $_POST['name'];
  $editunit_sql = "UPDATE units SET `unitname` = '$unitname' WHERE unitID = $unitID";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);

}
if ($_POST['strength'] != "") {
  $unitstrength = $_POST['strength'];
  $editunit_sql = "UPDATE units SET `unitstrength` = '$unitstrength' WHERE unitID = $unitID";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);

}
if ($_POST['price'] != "") {
  $unitprice = $_POST['price'];
  $editunit_sql = "UPDATE units SET `unitprice` = '$unitprice' WHERE unitID = $unitID";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);

}
if ($_POST['type'] != 0) {
  $unittype = $_POST['type'];
  $editunit_sql = "UPDATE units SET `unittype` = '$unittype' WHERE unitID = $unitID";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);

}
if ($_POST['upkeep'] != "") {
  $unitupkeep = $_POST['upkeep'];
  $editunit_sql = "UPDATE units SET `unitupkeep` = '$unitupkeep' WHERE unitID = $unitID";
  $editunit_qry = mysqli_query($dbconnect, $editunit_sql);

}
header('Location: index.php?page=editshop');

 ?>
