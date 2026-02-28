<?php
// Function to fetch data using curl
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL Compitability
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return null;
    }
    curl_close($ch);
    return json_decode($output, true);
}

$baseUrl = "http://iamherelol.atwebpages.com/final";

// Fetch data
$salesData = fetchData("{$baseUrl}/api_sales.php");
$usersData = fetchData("{$baseUrl}/api_users.php");
$performanceData = fetchData("{$baseUrl}/api_performance.php");
$deviceData = fetchData("{$baseUrl}/api_devices.php");

// Fetch currencies
$usdDataRaw = fetchData('http://api.nbp.pl/api/exchangerates/rates/a/usd/last/20/?format=json');
$chfDataRaw = fetchData('http://api.nbp.pl/api/exchangerates/rates/a/chf/last/20/?format=json');

// Process currency data
$currencyDates = [];
$usdRates = [];
$chfRates = [];

if (isset($usdDataRaw['rates'])) {
    foreach ($usdDataRaw['rates'] as $rate) {
        $currencyDates[] = $rate['effectiveDate'];
        $usdRates[] = $rate['mid'];
    }
}
if (isset($chfDataRaw['rates'])) {
    foreach ($chfDataRaw['rates'] as $rate) {
        // Assume dates align
        $chfRates[] = $rate['mid'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chart-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        h1, h2 {
            color: #343a40;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <header class="text-center mb-5">
        <h1>Dashboard</h1>
        <p class="lead">Umarjon Mansurjonov 68921</p>
        <a href="test.php" class="btn btn-primary">Go to Test Page</a>
    </header>

    <div class="row">
        <!-- Charts -->
        <div class="col-12">
            <div class="chart-container">
                <h2>Last 20 USD & CHF Exchange Rates</h2>
                <div id="currencyChart"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="chart-container">
                <h2>Monthly Sales</h2>
                <div id="salesChart"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-container">
                <h2>Browser Market Share</h2>
                <div id="usersChart"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="chart-container">
                <h2>Server Load (%)</h2>
                <div id="performanceChart"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-container">
                <h2>Device Usage</h2>
                <div id="deviceChart"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sales Chart (Bar)
    const salesData = {
        x: <?php echo json_encode($salesData['labels'] ?? []); ?>,
        y: <?php echo json_encode($salesData['values'] ?? []); ?>,
        type: 'bar',
        marker: { color: 'rgba(54, 162, 235, 0.6)' }
    };
    const salesLayout = { title: 'Monthly Sales Performance' };
    Plotly.newPlot('salesChart', [salesData], salesLayout);

    // Users Chart (Pie)
    const usersData = [{
        labels: <?php echo json_encode($usersData['labels'] ?? []); ?>,
        values: <?php echo json_encode($usersData['values'] ?? []); ?>,
        type: 'pie',
        hole: .4
    }];
    const usersLayout = { title: 'User Browser Distribution' };
    Plotly.newPlot('usersChart', usersData, usersLayout);

    // Performance Chart (Bar)
    const performanceData = {
        x: <?php echo json_encode($performanceData['labels'] ?? []); ?>,
        y: <?php echo json_encode($performanceData['values'] ?? []); ?>,
        type: 'bar',
        marker: { color: 'rgba(255, 99, 132, 0.6)' }
    };
    const performanceLayout = { title: 'Real-time Server Load' };
    Plotly.newPlot('performanceChart', [performanceData], performanceLayout);

    // Device Chart (Pie)
    const deviceData = [{
        labels: <?php echo json_encode($deviceData['labels'] ?? []); ?>,
        values: <?php echo json_encode($deviceData['values'] ?? []); ?>,
        type: 'pie'
    }];
    const deviceLayout = { title: 'Access by Device Type' };
    Plotly.newPlot('deviceChart', deviceData, deviceLayout);

    // Currency Chart (Line)
    const usdTrace = {
      x: <?php echo json_encode($currencyDates); ?>,
      y: <?php echo json_encode($usdRates); ?>,
      mode: 'lines+markers',
      name: 'USD Rate',
      type: 'scatter',
      line: {shape: 'spline'}
    };

    const chfTrace = {
      x: <?php echo json_encode($currencyDates); ?>,
      y: <?php echo json_encode($chfRates); ?>,
      mode: 'lines+markers',
      name: 'CHF Rate',
      type: 'scatter',
      line: {shape: 'spline'}
    };

    const currencyLayout = {
      title: 'USD and CHF to PLN Exchange Rate',
      xaxis: { title: 'Date' },
      yaxis: { title: 'Rate (PLN)' }
    };

    Plotly.newPlot('currencyChart', [usdTrace, chfTrace], currencyLayout);

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
