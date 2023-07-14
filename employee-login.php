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

    // Query to check if the provided employee name and password are correct
    $query = "SELECT * FROM employee WHERE employee_name = :employee_name AND employee_password = :employee_password";
    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':employee_name', $employee_name);
    oci_bind_by_name($stmt, ':employee_password', $employee_password);
    oci_execute($stmt);

    // Check if the login is successful
    if ($row = oci_fetch_assoc($stmt)) {
        // Login successful
        // Store user information in session variables
        $_SESSION['employee_name'] = $row['EMPLOYEE_NAME'];
        $_SESSION['employee_role'] = $row['EMPLOYEE_ROLE']; // Assuming EMPLOYEE_ROLE column exists in the employee table

        // Redirect based on the role
        if ($_SESSION['employee_role'] == 'staff') {
            header("Location: staff-page.php");
            exit();
        } elseif ($_SESSION['employee_role'] == 'manager') {
            header("Location: manager-page.php");
            exit();
        } else {
            // Unknown role
            echo 'Unknown role.';
        }
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
<title>LEmployee Login</title>
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
    <script src="js/script.js"></script></head>
<body>
<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <h1>Employee Login</h1> 
    </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                <form action="employee-login.php" method="POST">
                <div class="form-outline mb-4">

                    <label for="username" class="form-label">USERNAME:</label>
                    <input type="text" id="employee_name" name="employee_name" class="form-control form-control-lg" required><br>
                </div>
                <div class="form-outline mb-4">
                    <label for="password" class="form-label">PASSWORD:</label>
                    <input type="password" id="employee_password"  name="employee_password" class="form-control form-control-lg" required><br>
                </div>
                <div class="text-center text-lg-start mt-4 pt-2">
				<button type="submit" class="btn btn-primary btn-lg"
				  style="padding-left: 2.5rem; padding-right: 2.5rem;">LOGIN</button>
			     </div>
                    <br>
                    <br>
                    <br>
                </form>
        </div>
    </div>
</div>

</body>
</html>
