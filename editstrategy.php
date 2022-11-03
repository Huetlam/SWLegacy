<?php

include 'dbconnect.php';
$strategyID = $_GET['strategy'];

$strategy_stmt = $dbconnect->prepare("SELECT * FROM strategies WHERE strategyID = $strategyID");
$strategy_stmt->execute();
$strategy_result = $strategy_stmt->get_result();
$strategy_data = $strategy_result->fetch_assoc();


?>
<div class="container">

    <div class="row">
        <div class="col">
            <p class="display-4">Strategy Modifiers</p>
        </div>
    </div>
    <div class="row">

<?php


    $strategyID = $strategy_data['strategyID'];
    $name = $strategy_data['strategyname'];
    $typeID = $strategy_data['strategytype'];
    if ($typeID == 1) {
        $type = "Attacking Only";
    }elseif ($typeID == 2){
        $type = "Defending Only";
    }else{
        $type = "Attacking and Defending";
    }
    echo '<div class="col-3">';
        echo '<div class="card" style="width: 18rem; height: 100%;">';
            echo '<div class="card-body">';
                echo "<h5 class='card-title'>Selected Strategy: $name</h5>";
                echo "<a class='danger' href='index.php?page=deletestrategy&id=$strategyID'>Delete Strategy</a>";
                echo "<p class='card-text'>Type: $type</p>";
                echo "<p class='card-text'>Description: </p>";
            echo "<div class='card-footer'> 
            <p class='card-text' > Edit Details </p>
            <form action='index.php?page=editingstrategy&id=$strategyID' method='POST'>";
                ?>
                <input type="text" class="form-control" name="name" placeholder="Strategy Name">
                <input class="form-control" list="typeOptions" name="type" placeholder="Strategy is for...">
                <datalist id="typeOptions">
                    <option value="Attacking">
                    <option value="Defending">
                    <option value="Both">
                </datalist>
                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
            </form>
            </div>
            <?php
            echo "</div>";
        echo "</div>";
    echo "</div>";


?>
</div>
</div>
