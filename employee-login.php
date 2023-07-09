<?php
// Include your Oracle connection code here
include_once 'includes/db_connection.php';

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_name = $_POST['employee_name'];
    $employee_password = $_POST['employee_password'];

    // Validate the username and password
    // You can implement your own validation logic here

    // Query to check if the provided email and password are correct
    $query = "SELECT * FROM employee WHERE employee_name = :employee_name AND employee_password = :employee_password";
    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':employee_name', $employee_name);
    oci_bind_by_name($stmt, ':employee_password', $employee_password);
    oci_execute($stmt);

    // Check if the login is successful
    if ($row = oci_fetch_assoc($stmt)) {
        // Login successful
        // Store user information in session variables
        $_SESSION['employee_name'] = $row['employee_name'];
        
        // Redirect to the home page or a dashboard
        header("Location: view.php");
        exit();
    } else {
        // Login failed
        echo 'Invalid username or password.';
    }
}

// Close the Oracle connection
oci_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
</head>
<body>
    <h2>Employee Login</h2>
    <form action="employee-login.php" method="POST">
        <label for="username">USERNAME:</label>
        <input type="text" id="employee_name" name="employee_name" required><br>

        <label for="password">PASSWORD:</label>
        <input type="password" id="employee_password" name="employee_password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
