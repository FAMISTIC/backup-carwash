<?php
// Include the database connection file
include 'includes/db_connection.php';

// Initialize variables for the appointment form
$customerName = '';
$email = '';
$password = '';
$phone = '';
$model = '';
$colour = '';
$plate = '';
$price = '';
$package = '';
$appointmentDate = '';
$successMessage = '';
$error = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $customerName = $_POST['customer_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $model = $_POST['model'];
    $colour = $_POST['colour'];
    $plate = $_POST['plate'];
    $price = $_POST['price'];
    $package = $_POST['package'];
    $appointmentDate = $_POST['appointment_date'];

    // Validate the form data (you can add more validation if required)
    if (empty($customerName) || empty($email) || empty($password) || empty($phone) || empty($model) || empty($colour) || empty($plate) || empty($price) || empty($package) || empty($appointmentDate)) {
        $error = 'Please fill in all fields.';
    } else {
        // Check if the email already exists in the customer table
        $query = "SELECT * FROM customer WHERE email = :email";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':email', $email);
        oci_execute($statement);

        if (oci_fetch_assoc($statement)) {
            $error = 'Email already exists in the customer table. Please choose a different email.';
        } else {
            // Insert the customer data into the customer table
            $insertCustomerQuery = "INSERT INTO customer (customer_name, email, password, phone) VALUES (:customerName, :email, :password, :phone)";
            $insertCustomerStatement = oci_parse($connection, $insertCustomerQuery);
            oci_bind_by_name($insertCustomerStatement, ':customerName', $customerName);
            oci_bind_by_name($insertCustomerStatement, ':email', $email);
            oci_bind_by_name($insertCustomerStatement, ':password', $password);
            oci_bind_by_name($insertCustomerStatement, ':phone', $phone);

            // Insert the vehicle data into the vehicle table
            $insertVehicleQuery = "INSERT INTO vehicle (model, colour, plate) VALUES (:model, :colour, :plate)";
            $insertVehicleStatement = oci_parse($connection, $insertVehicleQuery);
            oci_bind_by_name($insertVehicleStatement, ':model', $model);
            oci_bind_by_name($insertVehicleStatement, ':colour', $colour);
            oci_bind_by_name($insertVehicleStatement, ':plate', $plate);

            // Retrieve the customer ID for the appointment
            $customerId = null;

            if (oci_execute($insertCustomerStatement) && oci_execute($insertVehicleStatement)) {
                // Get the last inserted customer ID
                $customerQuery = "SELECT customer_id FROM customer WHERE customer_name = :customerName";
                $customerStatement = oci_parse($connection, $customerQuery);
                oci_bind_by_name($customerStatement, ':customerName', $customerName);
                oci_execute($customerStatement);
                $customerRow = oci_fetch_assoc($customerStatement);
                $customerId = $customerRow['CUSTOMER_ID'];

                // Insert the service data into the service table
                $insertServiceQuery = "INSERT INTO service (price, package, appointment_date, customer_id, vehicle_id, employee_id, receipt_id) VALUES (:price, :package, TO_DATE(:appointmentDate, 'YYYY-MM-DD'), :customerId, :vehicleId, :employee_id,:receiptId)";
                $insertServiceStatement = oci_parse($connection, $insertServiceQuery);
                oci_bind_by_name($insertServiceStatement, ':price', $price);
                oci_bind_by_name($insertServiceStatement, ':package', $package);
                oci_bind_by_name($insertServiceStatement, ':appointmentDate', $appointmentDate);
                oci_bind_by_name($insertServiceStatement, ':customerId', $customerId);
                oci_bind_by_name($insertServiceStatement, ':customerId', $customerId);
                oci_bind_by_name($insertServiceStatement, ':customerId', $customerId);


                if (oci_execute($insertServiceStatement)) {
                    $successMessage = 'Appointment form submitted successfully.';
                } else {
                    $error = 'Error occurred during service data insertion. Please try again.';
                }
            } else {
                $error = 'Error occurred during customer and vehicle data insertion. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Form</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <h1>Appointment Form</h1>

    <?php if ($error) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif ($successMessage) : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <h2>Customer Information</h2>
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" id="customer_name" value="<?php echo $customerName; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo $password; ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required>

        <h2>Vehicle Information</h2>
        <label for="model">Model:</label>
        <input type="text" name="model" id="model" value="<?php echo $model; ?>" required>

        <label for="colour">Colour:</label>
        <input type="text" name="colour" id="colour" value="<?php echo $colour; ?>" required>

        <label for="plate">Plate:</label>
        <input type="text" name="plate" id="plate" value="<?php echo $plate; ?>" required>

        <h2>Service Information</h2>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" value="<?php echo $price; ?>" required>

        <label for="package">Package:</label>
        <input type="text" name="package" id="package" value="<?php echo $package; ?>" required>

        <label for="appointment_date">Appointment Date:</label>
        <input type="date" name="appointment_date" id="appointment_date" value="<?php echo $appointmentDate; ?>" required>

        <input type="submit" value="Submit">
    </form>

    <?php include 'includes/footer.php'; ?>
</body
