<?php
// Include the database connection file
include_once 'includes/db_connection.php';

// Fetch data from the database
$query = "SELECT * FROM customer ORDER BY customer_id ASC";
$result = oci_parse($connection, $query);
oci_execute($result);

// Create a table to display the data
$table = '<table>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
            </tr>';

while ($row = oci_fetch_assoc($result)) {
    $table .= '<tr>
                    <td>' . $row['CUSTOMER_ID'] . '</td>
                    <td>' . $row['CUSTOMER_NAME'] . '</td>
                    <td>' . $row['EMAIL'] . '</td>
                    <td>' . $row['PASSWORD'] . '</td>
                    <td>' . $row['PHONE'] . '</td>
                </tr>';
}

$table .= '</table>';

// Set the appropriate headers for Word document download
header("Content-Type: application/msword");
header("Content-Disposition: attachment; filename=\"customer-data.doc\"");

// Generate the Word document content
$content = "<html>
                <body>
                    <h2>Customer Data</h2>
                    $table
                </body>
            </html>";

// Convert the content to RTF format
$rtfContent = "{\\rtf1\\ansi\n";
$rtfContent .= "{\\fonttbl\\f0\\fswiss Helvetica;}\n";
$rtfContent .= "\\f0\\fs24\n";
$rtfContent .= $content;
$rtfContent .= "}";

// Output the RTF-formatted content
echo $rtfContent;

// Close the database connection
oci_close($connection);
exit;
?>
