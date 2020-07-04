<?php
$database = "20200704_simulation_data";
include '../config/coding_challenges_database.php';

$sql = "select * from simulation_data";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row['data'];
}
