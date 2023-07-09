<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['customer_name']) && isset($_SESSION['email'])) {
    // Retrieve the user information from the session variables
    $customer_name = $_SESSION['customer_name'];
    $email = $_SESSION['email'];
    $model = $_SESSION['model'];
    $colour = $_SESSION['colour'];
    $plate = $_SESSION['plate'];

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: index.php");
        exit();
    }
} else {
    // User is not logged in, redirect to the login page

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <!-- Add your CSS styling here -->
    <style>
        /* CSS styles for the page */
    </style>
</head>
<body>
    <?php if (isset($customer_name) && isset($email)) { ?>
        <h2>Welcome, <?php echo $customer_name; ?>!</h2>
        <p>Email: <?php echo $email; ?></p>
        <p>Model: <?php echo $model; ?></p>
        <p>Plate: <?php echo $plate; ?></p>
        <p>Colour: <?php echo $colour; ?></p>
        <p>This is the home page for the logged-in user.</p>
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
</body>
</html>
