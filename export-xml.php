<?php
// Load the database configuration file
include_once 'includes/db_connection.php';

// Fetch records from the database
$query = "SELECT * FROM customer ORDER BY CUSTOMER_ID ASC";
$statement = oci_parse($connection, $query);
oci_execute($statement);

// Create a new XML element
$xml = new SimpleXMLElement('<customers></customers>');

// Iterate through the database records
while ($row = oci_fetch_assoc($statement)) {
    // Create a new customer element
    $customer = $xml->addChild('customer');

    // Add data as child elements
    $customer->addChild('customer_id', $row['CUSTOMER_ID']);
    $customer->addChild('customer_name', $row['CUSTOMER_NAME']);
    $customer->addChild('email', $row['EMAIL']);
    $customer->addChild('password', $row['PASSWORD']);
    $customer->addChild('phone', $row['PHONE']);
}

// Set the response headers for XML download
header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="carwashsystem_export_data.xml"');

// Output the XML content
echo $xml->asXML();

exit;
?>
