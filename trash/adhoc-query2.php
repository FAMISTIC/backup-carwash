<?php
// Include your database connection file
include_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tables = isset($_POST['tables']) ? $_POST['tables'] : [];
    $columns = isset($_POST['columns']) ? $_POST['columns'] : [];

    // Generate the column part of the SQL query
    $columnPart = implode(', ', $columns);

    // Generate the table part of the SQL query
    $tablePart = implode(', ', $tables);

    // Generate the JOIN clause if there are multiple tables
    $joinClause = '';
    if (count($tables) > 1) {
        $joinTables = [];
        for ($i = 0; $i < count($tables) - 1; $i++) {
            $joinTables[] = $tables[$i] . ' JOIN ' . $tables[$i + 1] . ' USING (column)';
        }
        $joinClause = implode(' ', $joinTables);
    }

    $query = "SELECT $columnPart FROM $tablePart $joinClause";
    $result = oci_parse($connection, $query);

    if (oci_execute($result)) {
        // Check if any rows were returned
        if (oci_fetch($result)) {
            // Output the table structure
            echo '<table id="myTable">';
            echo '<tr class="header">';
            foreach ($columns as $column) {
                echo '<th>' . $column . '</th>';
            }
            echo '</tr>';

            do {
                // Fetch the data from each column
                $row = oci_fetch_array($result, OCI_ASSOC);

                // Output the table rows
                echo '<tr>';
                foreach ($columns as $column) {
                    $columnValue = isset($row[strtoupper($column)]) ? $row[strtoupper($column)] : '';
                    echo '<td>' . $columnValue . '</td>';
                }
                echo '</tr>';
            } while (oci_fetch($result));

            // Close the table
            echo '</table>';
        } else {
            echo "No results found.";
        }
    } else {
        $error = oci_error($result);
        echo "Error: " . $error['message'];
    }

    // Close the database connection
    oci_close($connection);
} else {
   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adhoc Query</title>
    <style>
        * {
  box-sizing: border-box;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <form action="" method="post" onsubmit="return validateForm()">
        <label for="table">Table:</label>
        <div id="table-container">
        <input type="text" name="tables[]" value= "service" readonly>
        <input type="text" name="tables[]" placeholder="Table" required>
        </div>
        <button type="button" onclick="addTableInput()">+ Table</button>
        <button type="button" onclick="removeTableInput()">- Table</button>
        <div id="input-container">
            <label for="columns">Columns:</label>
            <input type="text" name="columns[]" placeholder="Column" required>
            <input type="text" name="columns[]" placeholder="Column">
            <input type="text" name="columns[]" placeholder="Column">
        </div>

        <button type="button" onclick="addColumn()">+ Column</button>
        <button type="button" onclick="removeColumn()">- Column</button>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
