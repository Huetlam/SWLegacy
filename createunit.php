
<form class="form-custom" action="newunit.php" method="post" enctype="multipart/form-data">
  <h1>Create Unit</h1>
  <input type="text" class="form-control" name="name" placeholder="Unit Name" required>
  <input type="number" class="form-control" name="price" placeholder="Unit Price" required>
  <input type="number" class="form-control" name="strength" placeholder="Unit Strength" required>
  <input type="number" class="form-control" name="upkeep" placeholder="Upkeep" required>
  <input class="form-control" list="type" id="typeDataList" name="type" placeholder="Unit Type">
  <datalist id="type" name="type">
    <?php
      $type_stmt = $dbconnect->prepare("SELECT * FROM unittype");
      $type_stmt -> execute();
      $type_result = $type_stmt->get_result();
      $type_data = $type_result->fetch_all(MYSQLI_ASSOC);

      if ($type_result->num_rows > 0) {
            $type_stmt = $dbconnect->prepare("SELECT * FROM unittype");
            $type_stmt -> execute();
            $type_result = $type_stmt->get_result();
            $type_data = $type_result->fetch_all(MYSQLI_ASSOC);

            if ($type_result->num_rows > 0) {
              foreach ($type_data as $row) {
                $ID = $row['typeID'];
                $name = $row['unittype'];

                echo "<option value='$ID:$name'>";
              }
            }
            ?>

        <?php

      }
      ?>

  </datalist>
  <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
