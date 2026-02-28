<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT browser_name, market_share FROM browsers ORDER BY market_share DESC";
$result = mysqli_query($conn, $sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['browser_name'];
        $values[] = (float)$row['market_share'];
    }
}

$data = [
    'labels' => $labels,
    'values' => $values
];

mysqli_close($conn);

echo json_encode($data);
?>
