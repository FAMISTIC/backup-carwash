<?php
// Include the database connection file
include 'includes/db_connection.php';

// Initialize variables for the registration form
$customerName = '';
$email = '';
$password = '';
$confirmPassword = '';
$error = '';
$successMessage = '';

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $customerName = $_POST['customer_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the form data (you can add more validation if required)
    if (empty($customerName) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Check if the email already exists in the database
        $query = "SELECT * FROM customer WHERE email = :email";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':email', $email);
        oci_execute($statement);

        if (oci_fetch_assoc($statement)) {
            $error = 'Email already exists. Please choose a different email.';
        } else {
            // Insert the new customer into the database
            $insertQuery = "INSERT INTO customer (CUSTOMER_NAME, EMAIL, PASSWORD, PHONE) VALUES (:customerName, :email, :password, :phone)";
            $insertStatement = oci_parse($connection, $insertQuery);
            oci_bind_by_name($insertStatement, ':customerName', $customerName);
            oci_bind_by_name($insertStatement, ':email', $email);
            oci_bind_by_name($insertStatement, ':password', $password);
            oci_bind_by_name($insertStatement, ':phone', $phone);

            if (oci_execute($insertStatement)) {
                $successMessage = 'Registration successful. You can now login.';
                // Clear the form fields after successful registration
                $customerName = '';
                $email = '';
                $password = '';
                $phone = '';
                $confirmPassword = '';
            } else {
                $error = 'Error occurred during registration. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <h1>Register</h1>

    <?php if ($error) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif ($successMessage) : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" id="customer_name" value="<?php echo $customerName; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>

        <label for="phone">Phone:</label>
        <input type="number" name="phone" id="phone" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <input type="submit" value="Register">
    </form>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
