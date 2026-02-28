<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT month, sales_amount FROM sales ORDER BY month";
$result = mysqli_query($conn, $sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['month'];
        $values[] = (int)$row['sales_amount'];
    }
}

$data = [
    'labels' => $labels,
    'values' => $values
];

mysqli_close($conn);

echo json_encode($data);
?>
