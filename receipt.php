<?php

include_once 'includes/db_connection.php';
// Start the session
session_start();

// Check if the required session variables are set
if (isset($_SESSION['customerId'])) {
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
    $receiptId = $_SESSION['receiptId'];

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: customer-home.php");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $receiptBankAcc = $_POST['receiptBankAcc'];

        // Update the receipt table with the bank account information
        $payment = "UPDATE receipt r
                    SET r.receipt_bankacc = :receiptBankAcc
                    WHERE r.receipt_id = :receiptId";
        $PayStatement = oci_parse($connection, $payment);
        oci_bind_by_name($PayStatement, ':receiptBankAcc', $receiptBankAcc);
        oci_bind_by_name($PayStatement, ':receiptId', $receiptId);
        oci_execute($PayStatement);

        $_SESSION['customer_id'] = $customerId;
        $_SESSION['customer_name'] = $customerName;
        $_SESSION['email'] = $email;
        $_SESSION['model'] = $model;
        $_SESSION['colour'] = $colour;
        $_SESSION['plate'] = $plate;
        $_SESSION['price'] = $price;
        $_SESSION['package'] = $package;
        $_SESSION['appointmentDate'] = $appointmentDate;
        $_SESSION['receiptId'] = $receiptId;

        // Redirect to the login page
        header("Location: index.php");
        exit();

    }
} else {
    // Redirect to the appointment form if the session variables are not set
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Receipt Page</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<style>
body {
    color: #404E67;
    background-color: #6cf8e5;
    font-family: 'Open Sans', sans-serif;
    
}
.table-wrapper {
    width: 700px;
    margin: 30px auto;
    background: #fff;
    padding: 20px;	
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
    padding-bottom: 10px;
    margin: 0 0 10px;
}
.table-title h2 {
    margin: 6px 0 0;
    font-size: 22px;
}
.table-title .add-new {
    float: right;
    height: 30px;
    font-weight: bold;
    font-size: 12px;
    text-shadow: none;
    min-width: 100px;
    border-radius: 50px;
    line-height: 13px;
}
.table-title .add-new i {
    margin-right: 4px;
}
table.table {
    table-layout: fixed;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}
table.table th:last-child {
    width: 100px;
}
table.table td a {
    cursor: pointer;
    display: inline-block;
    margin: 0 5px;
    min-width: 24px;
}    
table.table td a.add {
    color: #27C46B;
}
table.table td a.edit {
    color: #FFC107;
}
table.table td a.delete {
    color: #E34724;
}
table.table td i {
    font-size: 19px;
}
table.table td a.add i {
    font-size: 24px;
    margin-right: -1px;
    position: relative;
    top: 3px;
}    
table.table .form-control {
    height: 32px;
    line-height: 32px;
    box-shadow: none;
    border-radius: 2px;
}
table.table .form-control.error {
    border-color: #f50000;
}
table.table td .add {
    display: none;
}
</style>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();
});
</script>
</head>
<body>


<?php if (isset($customerId)) { ?>
<!-- Navigation -->

<div class="d-flex flex-row align-items-center justify-content-center">
    <h1><br>Receipt Page</h1>
  </div><br>
<div class="container-lg" style="width: auto;" >
    <div class="table-responsive" >
        <div class="table-wrapper" style="background-color: #fcfcfc">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Customer Information</h2></div>
                </div>
            </div>
            <table class="table table-bordered" style="width: auto;">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Email</th>
            
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $customerId; ?></td>
                        <td><?php echo $customerName; ?></td>
                        <td><?php echo $email; ?></td>
                    </tr>
                          
                </tbody>
            </table>
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Vehicle Information</h2></div>
                </div>
            </div>
            <table class="table table-bordered" style="width: auto;">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Colour</th>
                        <th>Plate Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $model; ?></td>
                        <td><?php echo $colour; ?></td>
                        <td><?php echo $plate; ?></td>
                    </tr>     
                </tbody>
            </table>
        <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Service Information</h2></div>
                </div>
            </div>
            <table class="table table-bordered" style="width: auto;">
                <thead>
                    <tr>
                        <th>Price</th>
                        <th>Package</th>
                        <th>Appointment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $package; ?></td>
                        <td><?php echo $appointmentDate; ?></td>
                    </tr>     
                </tbody>
            </table>
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Payment Information</h2></div>
                </div>
            </div>
            <table class="table table-bordered" style="width: 40%;">
                <thead>
                    <tr>
                        <th>Receipt ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $receiptId;?></td>
                    </tr>     
                </tbody>
            </table>
        <!-- Add payment-related details here, such as payment method, transaction ID, etc. -->
        <form action="" method="post">
            <label for="bank_account">Bank Account Number:</label><br>
            <input type="number" name="receiptBankAcc" id="receiptBankAcc" class="form-control form-control-lg" style="width: 40%;">
            <br>
            <button type="submit" value="pay" class="btn btn-dark btn-lg">Pay</button>
        </form>
        </div> 
    </div>
</div><br><br><br><br>

<?php } else {?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="img/logo-carwash.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item-active">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">About</a>
			</li>
			<li class="nav-item">
                    <div class="btn-container-user" style="margin-right: 70px;">
                        	<a href="login.php"><button class="btn nav-box" type="button">Login</button></a>
                    </div>
			</li>
		</ul>
	</div>
</div> 
</nav>
<?php } ?>
<!--- Footer -->
<?php include 'includes/footer.php';?>
</body>
</html>