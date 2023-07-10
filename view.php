<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
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
.export-forms {
        display: inline;
        margin-right: 10px;
    }
</style>
<script src="js/script.js">
</script>
</head>
<body>
    <h2>Customer List</h2>
    <button><a href="adhoc-query.php">Adhoc Query</a></button>
    <form action="" class="export-forms">
      <button type="submit" onclick="window.print()" >Print Report</button>
    </form>
    <form method="post" action="export-excel.php" class="export-forms">
        <button type="submit" name="export">Export to Excel</button>
    </form>
    <form method="post" action="export-xml.php" class="export-forms">
        <button type="submit" name="export">Export to XML</button>
    </form>
    <form method="post" action="export-text.php" class="export-forms">
        <button type="submit" name="export">Export to Text</button>
    </form>
    <form method="post" action="export-csv.php" class="export-forms">
        <button type="submit" name="export">Export to CSV</button>
    </form>
    <form method="post" action="export-json.php" class="export-forms">
        <button type="submit" name="export">Export to JSON</button>
    </form>
    <form method="post" action="export-word.php" class="export-forms">
        <button type="submit" name="export">Export to Word</button>
    </form>
    <?php
    // Include your Oracle connection code here
    include_once 'includes/db_connection.php';

    // Retrieve the customer data from the database
    $query = "SELECT * FROM customer";
    $stmt = oci_parse($connection, $query);
    oci_execute($stmt);
    
    echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">';
    echo '<input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Search for email.." title="Type in a email">';
    echo '<input type="text" id="myInput3" onkeyup="myFunction3()" placeholder="Search for phone.." title="Type in a phone">';

    // Display the customer data in a table
    echo '<table id="myTable">';
    echo '<tr class="header">';
    echo '<th>Customer ID</th>';
    echo '<th>Customer Name</th>';
    echo '<th>Phone</th>';
    echo '<th>Email</th>';
    echo '<th>Password</th>';
    echo '<th>Action</th>';
    echo '</tr>';

    while ($row = oci_fetch_assoc($stmt)) {
        echo '<tr>';
        echo '<td>' . $row['CUSTOMER_ID'] . '</td>';
        echo '<td>' . $row['CUSTOMER_NAME'] . '</td>';
        echo '<td>' . $row['PHONE'] . '</td>';
        echo '<td>' . $row['EMAIL'] . '</td>';
        echo '<td>' . $row['PASSWORD'] . '</td>';
        echo '<td>';
        echo '<a href="update-customer.php?customer_id=' . $row['CUSTOMER_ID'] . '">Edit</a>';
        echo ' | ';
        echo '<a href="delete-customer.php?customer_id=' . $row['CUSTOMER_ID'] . '">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

    // Close the Oracle connection
    oci_close($connection);
    ?>

</body>
</html>
