<?php
// Load the database configuration file
include_once 'includes/db_connection.php';

// Fetch records from the database
$query = "SELECT * FROM customer ORDER BY CUSTOMER_ID ASC";
$statement = oci_parse($connection, $query);
oci_execute($statement);

// Define the file name
$filename = "carwashsystem_export_data.txt";

// Open the file for writing
$file = fopen($filename, 'w');

// Iterate through the database records
while ($row = oci_fetch_assoc($statement)) {
    // Format the data as a line in the text file
    $line = $row['CUSTOMER_ID'] . "\t" . $row['CUSTOMER_NAME'] . "\t" . $row['EMAIL'] . "\t" . $row['PASSWORD'] . "\t" . $row['PHONE'] . "\n";

    // Write the line to the file
    fwrite($file, $line);
}

// Close the file
fclose($file);

// Set the response headers for file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="carwashsystem_export_data.txt"');

// Output the file content
readfile($filename);

// Delete the temporary file
unlink($filename);

exit;
?>
