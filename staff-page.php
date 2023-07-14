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
    <script src="js/script.js"></script>
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
            </div>
        </div>
      </nav>
        <?php } else { ?>
        <p>You are not logged in.</p>
        <!-- Login button -->
        <a href="employee-login.php">Login</a>
    <?php } ?>

    <div class="container mt-5 d-flex justify-content-center">
    <div class="row">
        <div class="col-md-6">
            <h2>Rating Chart</h2>
            <canvas id="ratingChart" style="max-width: 800px;"></canvas>
        </div>
        <div class="col-md-6">
            <h2>Pie Chart</h2>
            <canvas id="pieChart" style="max-width: 800px;"></canvas>
        </div>
    </div>
    
</div>

<script>
    <?php
    // Database connection
    include 'includes/db_connection.php';

    // Query to retrieve the counts for each package type
    $query = "SELECT 
                (SELECT COUNT(package) FROM service WHERE package LIKE 'Basic') AS basicCount,
                (SELECT COUNT(package) FROM service WHERE package LIKE 'Premium') AS premiumCount,
                (SELECT COUNT(package) FROM service WHERE package LIKE 'Deluxe') AS deluxeCount,
                (SELECT COUNT(package) FROM service WHERE package LIKE 'Supreme') AS supremeCount
              FROM dual";

    // Execute the query
    $result = oci_parse($connection, $query);
    oci_execute($result);

    // Fetch the row
    $row = oci_fetch_assoc($result);
    $basicCount = $row['BASICCOUNT'];
    $premiumCount = $row['PREMIUMCOUNT'];
    $deluxeCount = $row['DELUXECOUNT'];
    $supremeCount = $row['SUPREMECOUNT'];

    // Prepare the counts as an array
    $packageCounts = [$basicCount, $premiumCount, $deluxeCount, $supremeCount];

    // Convert the array to a JavaScript-readable format
    $jsPackageCounts = json_encode($packageCounts);
    ?>

    // Pie Chart
    const piePackageTypes = ['Basic', 'Premium', 'Deluxe', 'Supreme'];
    const pieXValues = piePackageTypes;
    const pieYValues = <?php echo $jsPackageCounts; ?>;

    const pieChart = new Chart("pieChart", {
        type: "pie",
        data: {
            labels: pieXValues,
            datasets: [{
                data: pieYValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 10
                }
            }
        }
    });
</script>

<script>
    <?php
    // Database connection
    include 'includes/db_connection.php';

    // Query to retrieve the counts for each rating
    $query = "SELECT 
                (SELECT COUNT(rating) FROM comments WHERE rating = 1) AS rating1Count,
                (SELECT COUNT(rating) FROM comments WHERE rating = 2) AS rating2Count,
                (SELECT COUNT(rating) FROM comments WHERE rating = 3) AS rating3Count,
                (SELECT COUNT(rating) FROM comments WHERE rating = 4) AS rating4Count,
                (SELECT COUNT(rating) FROM comments WHERE rating = 5) AS rating5Count
              FROM dual";

    // Execute the query
    $result = oci_parse($connection, $query);
    oci_execute($result);

    // Fetch the row
    $row = oci_fetch_assoc($result);
    $rating1Count = $row['RATING1COUNT'];
    $rating2Count = $row['RATING2COUNT'];
    $rating3Count = $row['RATING3COUNT'];
    $rating4Count = $row['RATING4COUNT'];
    $rating5Count = $row['RATING5COUNT'];

    // Prepare the counts as an array
    $ratingCounts = [$rating1Count, $rating2Count, $rating3Count, $rating4Count, $rating5Count];

    // Convert the array to a JavaScript-readable format
    $jsRatingCounts = json_encode($ratingCounts);
    ?>

    // Rating Chart
    const ratingLabels = ['1', '2', '3', '4', '5'];
    const ratingData = <?php echo $jsRatingCounts; ?>;

    const ratingChart = new Chart("ratingChart", {
        type: "line",
        data: {
            labels: ratingLabels,
            datasets: [{
                label: 'Rating Count',
                data: ratingData,
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)"
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</body>
</html>
