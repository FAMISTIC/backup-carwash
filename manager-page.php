<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>   
</head>
<body>

<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['employee_name'])) {
    // Retrieve the user information from the session variables
    $employee_name = $_SESSION['employee_name'];
    $employee_role = $_SESSION['employee_role'];

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: employee-login.php");
        exit();
    }
} else {
    // Admin is not logged in, redirect to the login page
    header("Location: index.php");

}
?>
    <?php if (isset($employee_name)) { ?>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link">NAME: <?php echo $employee_name; ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link">ROLE: <?php echo $employee_role; ?></a>
                </li>    
            </ul>
            </div>
        </div>
        </nav>
        <!-- Add more HTML content or functionality specific to the logged-in user -->

        <!-- Logout form -->
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    <?php } else { ?>
        <p>You are not logged in.</p>
        <!-- Login button -->
        <a href="login.php">Login</a>
        <a href="appointment.php">Register And Create Appointment</a>
    <?php } ?>
<?php 
include 'view.php';
?>
</body>
</html>
