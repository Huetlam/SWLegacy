<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="customform.css">
  </head>
<?php
if ($_SESSION['session']['level'] !=2){
  header('Location: index.php?error=permss');
}

include 'dbconnect.php';
$unit_stmt = $dbconnect->prepare("SELECT unitclass.*, unittype.unittype FROM unitclass JOIN unittype ON unitclass.unittypeID = unittype.typeID");
$unit_stmt->execute();
$unit_result = $unit_stmt->get_result();
$unit_data = $unit_result->fetch_all(MYSQLI_ASSOC);

$userID = $_SESSION['session']['userID'];
$user_stmt = $dbconnect->prepare("SELECT * FROM user WHERE userID = $userID");
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
$balance = $user_data['credits'];

?>

<div class="container">
  <div class="row">
    <p class="display-4">Edit Shop</p>
    <form  action="index.php?page=createunit" method="post">
        <button type="submit" name="submit">Create Unit</button>
      </form>
  </div>
  <div class="row gap-5">


  <?php

foreach ($unit_data as $unit) {
    $id = $unit['unitclassID'];
    $unitname = $unit['unitname'];
    $price = $unit['unitprice'];
    $upkeep = $unit['unitupkeep'];
    $health = $unit['health'];
    $power = $unit['power'];
    $shielding = $unit['shielding'];
    $carrycapacity = $unit['carrycapacity'];
    $unittype = $unit['unittype'];
    $image = $unit['image'];
    echo '<div class="col-3 p-3">';
                echo '<div class="card" style="width: 18rem; height: 100%;">';
                ?>
                <div class="card-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <?php
                        echo "<button class='nav-link active' id='home-tab' data-bs-toggle='tab' data-bs-target='#home$id' type='button' role='tab' aria-controls='home' aria-selected='true'>Stats</button>";
                        ?>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?php
                        echo "<button class='nav-link' id='profile-tab' data-bs-toggle='tab' data-bs-target='#profile$id' type='button' role='tab' aria-controls='profile' aria-selected='false'>Edit</button>";
                        ?>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?php
                        echo "<button class='nav-link' id='delete-tab' data-bs-toggle='tab' data-bs-target='#delete$id' type='button' role='tab' aria-controls='delete' aria-selected='false'>Delete Unit</button>";
                        ?>
                    </li>
                </ul>
                </div>
                <?php
                echo "<img src=uploads/$image class='card-img-top' alt='...'>";
                    echo '<div class="card-body">';
                        echo '<div class="tab-content" id="myTabContent">';
                            echo "<div class='tab-pane fade show active text-light' id='home$id' role='tabpanel' aria-labelledby='home-tab'>";
                                echo "<h5 class='card-title'>$unitname</h5>";
                                echo "<p class='card-text'> Price: $price</p>";
                                echo "<p class='card-text'> Health: $upkeep</p>";
                                echo "<p class='card-text'> Health: $health</p>";
                                echo "<p class='card-text'> Power: $power</p>";
                                echo "<p class='card-text'> Shielding: $shielding</p>";
                                echo "<p class='card-text'> Carry Capacity: $carrycapacity</p>";
                                echo "<p class='card-text'> Type: $unittype</p>";
                            echo '</div>';
                            echo "<div class='tab-pane fade show text-light' id='profile$id' role='tabpanel' aria-labelledby='profile-tab'>";
                                echo "<h5 class='card-title'>$unitname</h5>";
                                
                                echo "<form action='index.php?page=changeunitname&id=$id&u=$unitclassID' method='post'>";
                                    echo '<input type="text" name ="name" placeholder="New Unit Name" maxlength="50" required>';
                                    echo '<input type="submit" class="btn btn-success" name="submit" value="Change Name">';
                                echo "</form>";
                                
                                
                                
                            echo '</div>';
                            echo "<div class='tab-pane fade show text-light' id='delete$id' role='tabpanel' aria-labelledby='delete-tab'>";
                                echo "<h5 class='card-title'>$unitname</h5>";
                                ?>
                                <p class="text-danger">Are you sure you want to delete this unit? (This cannot be undone and will remove the unit from everyones inventory)</p>
                                <?php
                                echo "<a href='index.php?page=deleteunit&u=$id' class='btn btn-danger'>Yes (Delete the Unit)</a>";

                            echo '</div>';
                        echo '</div>';
                    echo "</div>";
                echo "</div>";
    echo "</div>";
}
?>
</div>
</div>
