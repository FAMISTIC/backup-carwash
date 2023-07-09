<?php
// Include your Oracle connection code here
include_once 'includes/db_connection.php';

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the username and password
    // You can implement your own validation logic here

    // Query to check if the provided email and password are correct
    $query = "SELECT * 
              FROM customer c
              JOIN service s
              ON c.customer_id = s.customer_id
              JOIN vehicle v
              ON v.vehicle_id = s.vehicle_id
              WHERE email LIKE :email AND password LIKE :password";
    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':password', $password);
    oci_execute($stmt);

    // Check if the login is successful
    if ($row = oci_fetch_assoc($stmt)) {
        // Login successful
        // Store user information in session variables
        $_SESSION['customer_name'] = $row['CUSTOMER_NAME'];
        $_SESSION['email'] = $row['EMAIL'];
        $_SESSION['model'] = $row['MODEL'];
        $_SESSION['plate'] = $row['PLATE'];
        $_SESSION['colour'] = $row['COLOUR'];        
        // Redirect to the home page or a dashboard
        header("Location: index.php");
        exit();
    } else {
        // Login failed
        echo 'Invalid email or password.';
    }
}

// Close the Oracle connection
oci_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>
<?php include 'includes/header.php'; ?>

    <h2>Login</h2>
    <form action="" method="POST">
        <label for="username">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
    <?php include 'includes/footer.php'; ?>

</body>
</html>
