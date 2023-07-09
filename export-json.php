<?php
// Include your Oracle connection code here
include_once 'includes/db_connection.php';

// Fetch records from the database
$query = "SELECT * FROM customer ORDER BY customer_id ASC";
$stmt = oci_parse($connection, $query);
oci_execute($stmt);

// Fetch data into an array
$data = array();
while ($row = oci_fetch_assoc($stmt)) {
    $data[] = $row;
}

// Define the JSON file name for download
$fileName = "customer_data.json";

// Set the appropriate headers for JSON file download
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

// Output the JSON data
echo json_encode($data, JSON_PRETTY_PRINT);

// Close the Oracle connection
oci_close($connection);
?>
