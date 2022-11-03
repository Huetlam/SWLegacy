<?php
include 'dbconnect.php';
session_start();
$planetname = $_POST['name'];
$income = $_POST['income'];
$faction = $_POST['faction'];
$sector = $_POST['sector'];
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
if ($_FILES["fileToUpload"]["size"] > 1000000) {
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
    $faction_stmt = $dbconnect->prepare("SELECT * FROM faction WHERE factionname = '$faction'");
    $faction_stmt -> execute();
    $faction_result = $faction_stmt->get_result();
    $faction_data = $faction_result->fetch_assoc();
    $factionID = $faction_data['factionID'];

    $sector_stmt = $dbconnect->prepare("SELECT * FROM sectors WHERE sectorname = '$sector'");
    $sector_stmt -> execute();
    $sector_result = $sector_stmt->get_result();
    $sector_data = $sector_result->fetch_assoc();
    $sectorID = $sector_data['sectorID'];

    $add_sql = "INSERT INTO planets (planetname, planetincome, planetimg, sectorID, factionID) VALUES ('$planetname','$income', '$photo', '$sectorID', '$factionID')";
    $add_qry = mysqli_query($dbconnect, $add_sql);
    echo "Success";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

 ?>
