<form class="form-custom" action="newsector.php" method="post">
  <h1>Create Sector</h1>
  <input type="text" class="form-control" name="name" placeholder="Sector Name" required>
  <input list="region" required id="regionDataList" name="region" placeholder="Region">
  <datalist id="region">
    <?php
      $region_stmt = $dbconnect->prepare("SELECT * FROM regions");
      $region_stmt -> execute();
      $region_result = $region_stmt->get_result();
      $region_data = $region_result->fetch_all(MYSQLI_ASSOC);

      if ($region_result->num_rows > 0) {
        foreach ($region_data as $row) {
          $regionID = $row['regionID'];
          $regionname = $row['regionname'];

          echo "<option value='$regionname'>";
        }
      }
      ?>

  </datalist>

  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
