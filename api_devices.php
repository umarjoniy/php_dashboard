<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT device_type, usage_percentage FROM devices ORDER BY usage_percentage DESC";
$result = mysqli_query($conn, $sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['device_type'];
        $values[] = (int)$row['usage_percentage'];
    }
}

$data = [
    'labels' => $labels,
    'values' => $values
];

mysqli_close($conn);

echo json_encode($data);
?>
