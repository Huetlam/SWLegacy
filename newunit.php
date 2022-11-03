<?php
session_start();
include 'dbconnect.php';
$unitname = $_POST['name'];
$unitprice = $_POST['price'];
$unitstrength = $_POST['strength'];
$unittype = $_POST['type'];
$typelist = explode(":", $unittype);
$unittype = $typelist[0];
$unitupkeep = $_POST['upkeep'];
$photo = $_FILES["fileToUpload"]["name"];
if ($unittype==0) {
  header('Location: admin.php?error=type');
}
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
    $unit_stmt = $dbconnect->prepare("SELECT unitname FROM units WHERE unitname = '$unitname'");
    $unit_stmt->execute();
    $unit_result = $unit_stmt->get_result();
    
    if ($unit_result->num_rows>0) {
      header('Location: index.php?error=name');
    }else {
      $newunit_sql = "INSERT INTO units (unitname, unitprice, unitstrength, typeID, unitupkeep, image) VALUES ('$unitname','$unitprice', '$unitstrength', '$unittype', '$unitupkeep', '$photo')";
      $newunit_qry = mysqli_query($dbconnect, $newunit_sql);

      header('Location: index.php');

    }
    echo "Success";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}


?>
