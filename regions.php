<?php

$inv_stmt = $dbconnect->prepare("SELECT * FROM regions");
$inv_stmt->execute();
$inv_result = $inv_stmt->get_result();
$inv_data = $inv_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
  <div class="row">
    <p class="display-4">Regions:</p>
  </div>
  <div class="row">


<?php

foreach ($inv_data as $unit) {
  $id = $unit['regionID'];
  $name = $unit['regionname'];

  echo '<div class="col-3 p-3">';

  echo '<div class="card" style="width: 18rem; height: 100%;">';
    echo '<div class="card-body">';
      echo "<h5 class='card-title'>$name</h5>";
      // echo " <h6 class='card-subtitle mb-2 text-muted'>$name</h6>";
      echo "<a class='text-light btn btn-success' href='index.php?page=sectors&region=$id&name=$name'>View Sectors</a>";
    echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>
</div>
</div>
<script src="js/bootstrap.min.js">
</script>
