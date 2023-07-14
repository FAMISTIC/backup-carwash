<?php
// Include the database connection file
include 'includes/db_connection.php';

session_start();

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
        $query = "SELECT * FROM customer WHERE email = :email AND customer_name = :customer_name AND phone = :phone";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':email', $email);
        oci_bind_by_name($statement, ':customer_name', $customerName);
        oci_bind_by_name($statement, ':phone', $phone);
        oci_execute($statement);

        if (oci_fetch_assoc($statement)) {
            $error = 'Username/Email/Phone already exists in the customer table. Please choose a different email.';
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
            $vehicleId = null;
            $receiptId = null;

            if (oci_execute($insertCustomerStatement) && oci_execute($insertVehicleStatement)) {
                // Get the last inserted customer ID
                $customerQuery = "SELECT customer_id FROM customer WHERE customer_name = :customerName";
                $customerStatement = oci_parse($connection, $customerQuery);
                oci_bind_by_name($customerStatement, ':customerName', $customerName);
                oci_execute($customerStatement);
                $customerRow = oci_fetch_assoc($customerStatement);
                $customerId = $customerRow['CUSTOMER_ID'];

                // Get the last inserted vehicle ID
                $vehicleQuery = "SELECT vehicle_id FROM vehicle WHERE model = :model";
                $vehicleStatement = oci_parse($connection, $vehicleQuery);
                oci_bind_by_name($vehicleStatement, ':model', $model);
                oci_execute($vehicleStatement);
                $vehicleRow = oci_fetch_assoc($vehicleStatement);
                $vehicleId = $vehicleRow['VEHICLE_ID'];

                // Retrieve an employee ID
                $employeeQuery = "SELECT employee_id FROM (SELECT employee_id FROM employee ORDER BY DBMS_RANDOM.VALUE) WHERE ROWNUM = 1";
                $employeeStatement = oci_parse($connection, $employeeQuery);
                oci_execute($employeeStatement);
                $employeeRow = oci_fetch_assoc($employeeStatement);
                $employeeId = $employeeRow['EMPLOYEE_ID'];

                $insertReceiptQuery = "INSERT INTO receipt (receipt_id, receipt_bill, receipt_date) VALUES (receipt_seq.NEXTVAL, :price, CURRENT_DATE)";
                $insertReceiptStatement = oci_parse($connection, $insertReceiptQuery);
                oci_bind_by_name($insertReceiptStatement, ':price', $price);

                // Retrieve the generated receipt_id
                $receiptIdQuery = "SELECT receipt_seq.CURRVAL FROM dual";
                $receiptIdStatement = oci_parse($connection, $receiptIdQuery);

                if (oci_execute($insertReceiptStatement) && oci_execute($receiptIdStatement)) {
                    $receiptRow = oci_fetch_assoc($receiptIdStatement);
                    $receiptId = $receiptRow['CURRVAL'];

                    // Insert the service data into the service table
                    $insertServiceQuery = "INSERT INTO service (price, package, appointment_date, customer_id, vehicle_id, employee_id, receipt_id) VALUES (:price, :package, TO_DATE(:appointmentDate, 'YYYY-MM-DD'), :customerId, :vehicleId, :employeeId, :receiptId)";
                    $insertServiceStatement = oci_parse($connection, $insertServiceQuery);
                    oci_bind_by_name($insertServiceStatement, ':price', $price);
                    oci_bind_by_name($insertServiceStatement, ':package', $package);
                    oci_bind_by_name($insertServiceStatement, ':appointmentDate', $appointmentDate);
                    oci_bind_by_name($insertServiceStatement, ':customerId', $customerId);
                    oci_bind_by_name($insertServiceStatement, ':vehicleId', $vehicleId);
                    oci_bind_by_name($insertServiceStatement, ':employeeId', $employeeId);
                    oci_bind_by_name($insertServiceStatement, ':receiptId', $receiptId);

                    $InsertAddress = "INSERT INTO address(customer_id) VALUES(:customer_id)";
                    $InsertAddressStatement = oci_parse($connection, $InsertAddress);
                    oci_bind_by_name($InsertAddressStatement, ':customer_id', $customerId);

                    if (oci_execute($insertServiceStatement) && oci_execute($InsertAddressStatement)) {
                        $successMessage = 'Appointment form submitted successfully.';
                        
                        // Set the session variables for receipt.php
                        $_SESSION['customerId'] = $customerId;
                        $_SESSION['customerName'] = $customerName;
                        $_SESSION['email'] = $email;
                        $_SESSION['model'] = $model;
                        $_SESSION['colour'] = $colour;
                        $_SESSION['plate'] = $plate;
                        $_SESSION['price'] = $price;
                        $_SESSION['package'] = $package;
                        $_SESSION['appointmentDate'] = $appointmentDate;
                        $_SESSION['receiptId'] = $receiptId;
                        
                        // Redirect to receipt.php
                        header("Location: receipt.php");
                        exit();
                    } else {
                        $error = 'Error occurred during service data insertion. Please try again.';
                    }
                } else {
                    // Handle the case when no receipt row is returned
                    $error = 'Error occurred while retrieving receipt ID. Please try again.';
                }

                // Insert the service data into the service table
                
               
            } else {
                $error = 'Error occurred during customer and vehicle data insertion. Please try again.';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Appointment Page</title>
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
<style>
    body{background-color: wheat;}
</style>

<!-- Navigation -->

<body class="vh-100">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    <h1>Registration and Appointment Form</h1> 
  </div>
		  <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
			<form method="post" name="form1" class="was-validated">

              <?php if ($error) : ?>
                <p class="error"><?php echo $error; ?></p>
              <?php elseif ($successMessage) : ?>
                <p class="success"><?php echo $successMessage; ?></p>
              <?php endif; ?>

			  <br><br>
              <h2>Customer Information</h2><br>
			  <!-- Customer Name input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Customer Name:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" required/>
          <div class="invalid-feedback">
            Please enter Name
          </div>
			  </div>

              <!-- Email input -->
			  <div class="form-outline mb-3">
				<label class="form-label" for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control form-control-lg has-validation"
				  placeholder="Enter an Email" required/>	
          <div class="invalid-feedback">
            Please enter email
          </div>
			  </div>

              <!-- Password input -->
			  <div class="form-outline mb-3">
				<label class="form-label" for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control form-control-lg has-validation"
				  placeholder="Enter a Password" required/>	
          <div class="invalid-feedback">
            Please enter password
          </div>
			  </div>

			  <!-- Phone input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="phone">Phone Number:</label>
				<input type="tel" name="phone" id="phone" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" class="form-control form-control-lg has-validation"
				  placeholder="Enter a Phone Number"required/>
          <div class="invalid-feedback">
            Please enter phone number
          </div>
			  </div><br>

              <h2>Vehicle Information</h2><br>
			  <!-- Vehicle Model input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="model">Model:</label>
				<input type="text" name="model" id="model" class="form-control form-control-lg has-validation"
				  placeholder="Enter a Model" value="<?php echo $model; ?>" required/>
          <div class="invalid-feedback">
            Please enter email
          </div>
			  </div>
	
			  <!-- Vehicle Colour input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="colour">Colour:</label>
				<input type="color" name="colour" id="colour" class="form-control form-control-lg is-valid form-control-color has-validation"
				  placeholder="Enter a Colour" value="<?php echo $colour; ?>" required/>
          <div class="invalid-feedback">
            Please enter colour
          </div>
			  </div>

			  <!-- Vehicle plate input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="plate">Plate</label>
				<input type="text" name="plate" id="plate" class="form-control form-control-lg has-validation"
				  placeholder="Enter a Plate Number" value="<?php echo $plate; ?>" required/>
          <div id="plate" class="invalid-feedback">
            Please enter plate number.
         </div>
			  </div><br>
              <h2>Service Information</h2><br>
			  <!-- Plate Number input -->
			  <div class="form-outline mb-4">
				<label class="form-label" for="price">Price:</label>
				<input type="number" name="price" id="price" class="form-control form-control-lg has-validation"
				  placeholder="100" value="100" required readonly/>	
			  </div>

              <!-- Package Dropdown -->
        <div class="form-outline mb-4">
				<label for="package">Package:</label>
                <select name="package" id="package" onchange="updatePrice()" class="form-control form-control-lg has-validation">
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Supreme">Supreme</option>
                </select>	
            </div>
			  <!-- Appointment Date -->
        <div class="form-group form-outline mb-4">
			  <label for="datepicker1">Appointment Date:</label>
              <input type="date" placeholder="MM/DD/YYYY" name="appointment_date" id="datepicker1" class="form-control form-control-lg date has-validation" required>
              <div class="invalid-feedback">
                Please enter date
              </div>
        </div>
	
			  <div class="text-center text-lg-start mt-4 pt-2">
				<button type="submit" class="btn btn-primary btn-lg"
				  style="padding-left: 2.5rem; padding-right: 2.5rem;">Make Appointment</button>
			  </div><br><br>
	
			</form>
		  </div>
		  
		</div>
	  </div>
 <?php include 'includes/footer.php' ?>
  </body>
</html>