<?php
// Start the session
session_start();

// Check if the required session variables are set
if (
    isset($_SESSION['customerId']) ) {
    // Retrieve the receipt information from the session variables
    $customerId = $_SESSION['customerId'];
    $customerName = $_SESSION['customerName'];
    $email = $_SESSION['email'];
    $model = $_SESSION['model'];
    $colour = $_SESSION['colour'];
    $plate = $_SESSION['plate'];
    $price = $_SESSION['price'];
    $package = $_SESSION['package'];
    $appointmentDate = $_SESSION['appointmentDate'];

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: index.php");
        exit();
    }
    if (isset($_POST['pay'])) {
        // Clear all session variables
        $payment = 

        // Redirect to the login page
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to the appointment form if the session variables are not set

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <h1>Receipt</h1>
    <h2>Customer Information</h2>

    <?php if (
    isset($customerId) ) {?>
    <p>Customer ID: <?php echo $customerId; ?></p>
    <p>Name: <?php echo $customerName; ?></p>
    <p>Email: <?php echo $email; ?></p>

    <h2>Vehicle Information</h2>
    <p>Model: <?php echo $model; ?></p>
    <p>Colour: <?php echo $colour; ?></p>
    <p>Plate: <?php echo $plate; ?></p>

    <h2>Service Information</h2>
    <p>Price: <?php echo $price; ?></p>
    <p>Package: <?php echo $package; ?></p>
    <p>Appointment Date: <?php echo $appointmentDate; ?></p>
<?php } else { ?>
        <p>You are not logged in.</p>
        <!-- Login button -->
        <a href="login.php">Login</a>
        <a href="appointment.php">Register And Create Appointment</a>
    <?php } ?>
    <h2>Payment Information</h2>
    <!-- Add payment-related details here, such as payment method, transaction ID, etc. -->
    <form action="" method="post">
        <label for="bank_account">Bank Account</label><br>
        <input type="number" />
        <br>
        <input type="submit" value="pay">
    </form>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
