<?php
// Include the database connection file
include 'includes/db_connection.php';

// Retrieve data from the database
// You can modify this query to fetch the necessary data from your tables
$error ='';
$query = "SELECT * FROM service";
$statement = oci_parse($connection, $query);
oci_execute($statement);

// Check if the query was successful
if ($statement) {
    // Fetch data from the result set
    while ($row = oci_fetch_assoc($statement)) {
        // Access the data using the column names
        $serviceId = $row['SERVICE_ID'];
        $price = $row['PRICE'];
        $package = $row['PACKAGE'];
        $appointmentDate = $row['APPOINTMENT_DATE'];

        // Display the retrieved data
        echo "<p>Service ID: $serviceId</p>";
        echo "<p>Price: $price</p>";
        echo "<p>Package: $package</p>";
        echo "<p>Appointment Date: $appointmentDate</p>";
        echo "<hr>";
    }
} else {
    // Display an error message if the query fails
    $error = oci_error($statement);
    echo "Error: " . $error['message'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <h1>Dashboard</h1>

    <?php if ($error) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
