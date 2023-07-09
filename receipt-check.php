<?php
// Include the database connection file
include 'includes/db_connection.php';

// Retrieve data from the database
// You can modify this query to fetch the necessary data from your tables
$error ='';
$query = "SELECT * FROM receipt";
$statement = oci_parse($connection, $query);
oci_execute($statement);

// Check if the query was successful
if ($statement) {
    // Fetch data from the result set
    while ($row = oci_fetch_assoc($statement)) {
        // Access the data using the column names
        $receiptId = $row['RECEIPT_ID'];
        $receiptBill = $row['RECEIPT_BILL'];
        $receiptDate = $row['RECEIPT_DATE'];

        // Display the retrieved data
        echo "<p>Receipt ID: $receiptId</p>";
        echo "<p>Receipt Bill: $receiptBill</p>";
        echo "<p>Receipt Date: $receiptDate</p>";
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
    <title>Receipts</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <h1>Receipts</h1>

    <?php if ($error) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
