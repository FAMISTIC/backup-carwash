<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['employee_name'])) {
    // Retrieve the user information from the session variables
    $employee_name = $_SESSION['employee_name'];
    $employee_role = $_SESSION['employee_role'];

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: employee-login.php");
        exit();
    }
} else {
    // Admin is not logged in, redirect to the login page
    header("Location: employee-login.php");

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <style>
* {
  box-sizing: border-box;
}

#myInput, #myInput2, #myInput3{
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}


</style>
<script src="js/script.js">
</script>
</head>
<body>

<?php if (isset($employee_name)) { ?>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">STAFF PAGE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link">NAME: <?php echo $employee_name; ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link">ROLE: <?php echo $employee_role; ?></a>
              </li>
              <li class="nav-item">
                <form method="post"><button class="nav-link" type="submit" name="logout">Logout</button></form>
              </li>
              <li class="nav-item"><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." class="nav-link" title="Type in a name"></li>
             <li><input type="text" id="myInput2" onkeyup="myFunction2()" class="nav-link" placeholder="Search for email.." title="Type in a email"></li>
             <li><input type="text" id="myInput3" onkeyup="myFunction3()" class="nav-link" placeholder="Search for phone.." title="Type in a phone"></li>
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown link
                </a>
                <ul class="dropdown-menu">
                <li><form><button type="submit" onclick="window.print()" class="dropdown-item">Print Report</button></form></li>
            <li><form method="post" action="export-excel.php"><button type="submit" name="export"  class="dropdown-item">Export to Excel</button></form></li>
            <li><form method="post" action="export-xml.php"><button class="dropdown-item">Export to XML</button></form></li>
            <li><form method="post" action="export-text.php"><button type="submit" name="export" class="dropdown-item">Export to Text</button></form></li>
            <li><form method="post" action="export-csv.php"><button type="submit" name="export" class="dropdown-item">Export to CSV</button></form></li>
            <li><form method="post" action="export-json.php"><button type="submit" name="export" class="dropdown-item">Export to JSON</button></form></li>
            <li><form method="post" action="export-word.php"><button type="submit" name="export" class="dropdown-item">Export to Word</button></form></li>
            </ul>
                </ul>
            </li>
            </ul>
          </div>
        </div>
      </nav>

        <!-- Add more HTML content or functionality specific to the logged-in user -->
        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
<script>
<?php

include 'includes/db_connection.php';
// Assuming you have retrieved the package types from your table into an array called $packageTypes

// Query to retrieve the counts for each package type
$query = "SELECT 
            (SELECT COUNT(package) FROM service WHERE package LIKE 'Basic') AS basicCount,
            (SELECT COUNT(package) FROM service WHERE package LIKE 'Premium') AS premiumCount,
            (SELECT COUNT(package) FROM service WHERE package LIKE 'Deluxe') AS deluxeCount,
            (SELECT COUNT(package) FROM service WHERE package LIKE 'Supreme') AS supremeCount";

// Execute the query
$result = oci_parse($connection, $query);
oci_execute($result);
$row = oci_fetch_assoc($result);
$basicCount = $row['basicCount'];
$premiumCount = $row['premiumCount'];
$deluxeCount = $row['deluxeCount'];
$supremeCount = $row['supremeCount'];

// Close the database connection
oci_close($connection);

// Prepare the counts as an array
$packageCounts = [$basicCount, $premiumCount, $deluxeCount, $supremeCount];

// Convert the array to a JavaScript-readable format
$jsPackageCounts = json_encode($packageCounts);
?>

const packageTypes = ['Basic', 'Premium', 'Deluxe', 'Supreme'];
const xValues = packageTypes;
const yValues = <?php echo $jsPackageCounts; ?>;

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: { display: false },
    scales: {
      yAxes: [{ ticks: { min: 0, max: Math.max(...yValues) + 1 } }]
    }
  }
});
</script>
        <?php } else { ?>
        <p>You are not logged in.</p>
        <!-- Login button -->
        <a href="employee-login.php">Login</a>
    <?php } ?>

</body>
</html>
