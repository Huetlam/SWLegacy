<form class="form-custom"  action="planetupload.php" required method="post" enctype="multipart/form-data">
  <h1>Create Planet</h1>
  <input type="text" name="name" required placeholder="Planet Name" required>
  <input type="number" name="income" required placeholder="Planet Income">
  <input type="file" class="form-control" name="fileToUpload" required id="fileToUpload">
  <input list="faction" required id="factionDataList" name="faction" placeholder="Owning Faction">
  <datalist id="faction" >
    <?php
      $faction_stmt = $dbconnect->prepare("SELECT * FROM faction");
      $faction_stmt -> execute();
      $faction_result = $faction_stmt->get_result();
      $faction_data = $faction_result->fetch_all(MYSQLI_ASSOC);

      if ($faction_result->num_rows > 0) {
        foreach ($faction_data as $row) {
          $ID = $row['factionID'];
          $name = $row['factionname'];

          echo "<option value='$name'>";
        }
      }
      ?>

  </datalist>
  <input list="sector" required id="sectorDataList" name="sector" placeholder="Sector">
  <datalist id="sector">
    <?php
      $sector_stmt = $dbconnect->prepare("SELECT * FROM sectors");
      $sector_stmt -> execute();
      $sector_result = $sector_stmt->get_result();
      $sector_data = $sector_result->fetch_all(MYSQLI_ASSOC);

      if ($sector_result->num_rows > 0) {
        foreach ($sector_data as $row) {
          $sectorID = $row['sectorID'];
          $sectorname = $row['sectorname'];

          echo "<option value='$sectorname'>";
        }
      }
      ?>

  </datalist>

  <input type="submit" class="btn btn-primary" value="Upload Image" name="submit">

</form>
