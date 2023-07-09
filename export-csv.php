<?php
// Include your Oracle connection code here
include_once 'includes/db_connection.php';

// Fetch records from the database
$query = "SELECT * FROM customer ORDER BY customer_id ASC";
$stmt = oci_parse($connection, $query);
oci_execute($stmt);

// Define the CSV file name for download
$fileName = "customer_data.csv";

// Set the appropriate headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

// Create a file pointer
$file = fopen('php://output', 'w');

// Write the column headers to the CSV file
$fields = array('CUSTOMER_ID', 'CUSTOMER_NAME', 'EMAIL', 'PASSWORD', 'PHONE');
fputcsv($file, $fields);

// Write the data rows to the CSV file
while ($row = oci_fetch_assoc($stmt)) {
    fputcsv($file, $row);
}

// Close the file pointer
fclose($file);

// Close the Oracle connection
oci_close($connection);
?>
