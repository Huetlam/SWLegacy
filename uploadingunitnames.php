<?php
include 'dbconnect.php';

$filename = $_FILES["csvfile"]["tmp_name"];
// Make sure the file exists and is bigger than 0mb
if ($_FILES["csvfile"]["size"]>0) {

    $file = fopen($filename, "r");

    $csv_stmt = $dbconnect->prepare("INSERT INTO unitnames (unitname) VALUES (?)");
    $csv_stmt->bind_param("s", $unitname);

    while (($column = fgetcsv($file, 1000, ",")) !== FALSE) {
        if (isset($column[0])) {
            $unitname = $column[0];
            $csv_stmt->execute();

        }
    }



}




?>