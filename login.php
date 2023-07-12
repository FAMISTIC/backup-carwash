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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
	<link href="style.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <h1>Login</h1> 
    </div>
    
    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="" method="POST">
            <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email:</label>
                        <input type="text" id="email" name="email" required><br>

            </div>
            <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email:</label>
                        <input type="text" id="email" name="email" required><br>

            </div>

            <input type="submit" value="Login">
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>

</body>
</html>
