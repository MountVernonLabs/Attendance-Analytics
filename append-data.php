<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('127.0.0.1', 'root', 'root', 'mv_dev');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM mv_attendance where day IS NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "date: " . $row["date"]."\n";
        $date = new DateTime($row["date"]);
        $week = $date->format("W");
        $dayofweek = $date->format("l");
        echo "Week of Year: ".$week."\n";
        echo "Day of Week: ".$dayofweek."\n";

        $update = "UPDATE mv_attendance SET day='".$dayofweek."', week=".$week." WHERE id=".$row["id"];

        if ($conn->query($update) === TRUE) {
            echo "Record updated successfully\n\n";
        } else {
            echo "Error updating record: " . $conn->error."\n\n";
        }

    }
} else {
    echo "0 results";
}
$conn->close();
?>
