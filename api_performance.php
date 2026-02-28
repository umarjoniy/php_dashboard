<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT server_name, cpu_load FROM server_performance";
$result = mysqli_query($conn, $sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['server_name'];
        $values[] = (int)$row['cpu_load'];
    }
}

$data = [
    'labels' => $labels,
    'values' => $values
];

mysqli_close($conn);

echo json_encode($data);
?>
