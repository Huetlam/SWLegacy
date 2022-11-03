<?php
$userID = $_SESSION['session']['userID'];
$name = $_POST['name'];
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


      $newunit_sql = "INSERT INTO fleets (fleetname, image, userID) VALUES ('$name', '$photo', '$userID')";
      $newunit_qry = mysqli_query($dbconnect, $newunit_sql);

      // header('Location: index.php');
      $fleetid_stmt = $dbconnect->prepare("SELECT fleetID FROM fleets WHERE `fleetname` = '$name' ORDER BY fleetID DESC");
      $fleetid_stmt->execute();
      $fleetid_result = $fleetid_stmt->get_result();
      $fleetid_data = $fleetid_result->fetch_assoc();
      $fleetID = $fleetid_data['fleetID'];

    echo "Success";
    header("Location: index.php?page=editfleet&fleet=$fleetID");
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
