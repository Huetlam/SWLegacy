<?php

include 'dbconnect.php';

$strategy_stmt = $dbconnect->prepare("SELECT * FROM strategies");
$strategy_stmt->execute();
$strategy_result = $strategy_stmt->get_result();
$strategy_data = $strategy_result->fetch_all(MYSQLI_ASSOC);


?>
<div class="container">

    <div class="row">
        <div class="col">
            <p class="display-4">Strategies</p>
            <form  action="index.php?page=createstrategy" method="post">
            <button type="submit" name="submit">Create Strategy</button>
        </form>
        </div>
    </div>
    <div class="row">


<?php


foreach ($strategy_data as $strategy) {
    $strategyID = $strategy['strategyID'];
    $name = $strategy['strategyname'];
    $typeID = $strategy['strategytype'];
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
                echo "<h5 class='card-title'>$name</h5>";
                echo "<p class='card-text'>Strategy Type:</p>";
                echo "<p class='card-text'>$type</p>";
            echo "<div class='card-footer text-muted'> <a href=index.php?page=editstrategy&strategy=$strategyID>Edit strategy</a> </div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";

}
?>
</div>
</div>
