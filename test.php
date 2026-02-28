<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Tests</h1>

    <?php
    function fetchData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    $baseUrl = "http://iamherelol.atwebpages.com/final/";

    $salesData = fetchData("{$baseUrl}/api_sales.php");
    $usersData = fetchData("{$baseUrl}/api_users.php");
    $performanceData = fetchData("{$baseUrl}/api_performance.php");
    $deviceData = fetchData("{$baseUrl}/api_devices.php");
    
    function displayDataAsTable($title, $data) {
        echo "<h2>{$title}</h2>";
        if (!empty($data) && isset($data['labels']) && isset($data['values'])) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead class="table-dark"><tr><th>Label</th><th>Value</th></tr></thead>';
            echo '<tbody>';
            for ($i = 0; $i < count($data['labels']); $i++) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($data['labels'][$i]) . '</td>';
                echo '<td>' . htmlspecialchars($data['values'][$i]) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="text-warning">No data available or data is in wrong format.</p>';
        }
    }
    ?>

    <?php displayDataAsTable('Sales Data', $salesData); ?>
    <?php displayDataAsTable('Users Data', $usersData); ?>
    <?php displayDataAsTable('Performance Data', $performanceData); ?>
    <?php displayDataAsTable('Device Data', $deviceData); ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
