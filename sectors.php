<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="css/bootrap.min.css">
<link rel="stylesheet" href="custom.css">
  </head>
<?php
include 'dbconnect.php';

$regionID = $_GET['region'];
$region = $_GET['name'];

$inv_stmt = $dbconnect->prepare("SELECT * FROM sectors WHERE regionID = $regionID");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
  <div class="row">
    <p class="display-4"><?php echo $region; ?> Sectors:</p>
  </div>
  <div class="row">


<?php

foreach ($inv_data as $unit) {
  $id = $unit['sectorID'];
  $name = $unit['sectorname'];

  echo '<div class="col-3 p-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      // echo " <h6 class='card-subtitle mb-2 text-muted'>$name</h6>";
      echo "<a class='text-light btn btn-success' href='index.php?page=planets&sector=$id&name=$name'>View Planets</a>";
    echo "</div>";
  echo "</div>";
  echo "</div>";
}

 ?>
</div>
</div>
<script src="js/bootstrap.min.js">
</script>
