<?php

include_once 'includes/db_connection.php';

session_start();

$address = '';
$resident_status = '';

// Check if the user is logged in
if (isset($_SESSION['customer_name']) && isset($_SESSION['email'])) {
    // Retrieve the user information from the session variables
	$customer_id = $_SESSION['customer_id'];
    $customer_name = $_SESSION['customer_name'];
    $email = $_SESSION['email'];
    $model = $_SESSION['model'];
    $colour = $_SESSION['colour'];
    $plate = $_SESSION['plate'];
	if(isset($_SESSION['address']) && isset($_SESSION['resident_status'])){
		$address = $_SESSION['address'];
		$resident_status = $_SESSION['resident_status'];
	}else{

	}

    if (isset($_POST['logout'])) {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: index.php");
        exit();
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$address = $_POST['address'];
		$resident_status = $_POST['resident_status'];

        $AddressQuery = "INSERT INTO address(customer_id, address, resident_status) VALUES (:customer_id, :address, :resident_status)";
        $AddressStatement = oci_parse($connection, $AddressQuery);
        oci_bind_by_name($AddressStatement, ':customer_id', $customer_id);
        oci_bind_by_name($AddressStatement, ':address', $address);
		oci_bind_by_name($AddressStatement, ':resident_status', $resident_status);

        if(oci_execute($AddressStatement)){
			echo "<script>alert('Address submitted successfully');</script>";

		}else{
			echo "<script>alert('Address submitted failed');</script>";


		}

    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: index.php");

}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Heisenberg CarWash Website</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="css/rating.css" rel="stylesheet">
	
</head>
<body>
<?php if(isset($customer_name) && isset($email)){ ?>
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
				<a class="nav-link" href="comment.php">Comment</a>
			</li>
            <li class="nav-item">
				<a class="nav-link" href="address.php">Address</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="about.php">About</a>
			</li>
			<li class="nav-item">
                    <div class="btn-container-user" style="margin-right: 70px;">
                        <div class="dropdown">
                        <button class="btn dropdown-toggle nav-box" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> <?php echo $customer_name; ?></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <form method="post">
                                    <a><button type="submit" name="logout" class="btn btn-outline-secondary btn-lg">Logout</button></a>		
                                </form>
                            </li>
                        </ul>
                        </div>
                    </div>
			</li>
		</ul>
	</div>
</div> 
</nav>
  <h1>Address</h1>
  <div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
	<div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
	<form method="post" name="form1" class="was-validated">

	<div class="form-outline mb-4">
				<input type="hidden" name="customer_id" id="customer_id" class="form-control form-control-lg"
				  placeholder="Enter a id" value="<?php echo $customer_id; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Customer Name:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $customer_name; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="address">Address:</label>
				<input type="text" name="address" id="" class="form-control form-control-lg"
				  placeholder="<?php echo $address; ?>" />
	</div>
    <div class="form-outline mb-4">
				<label class="form-label" for="rating">Resident Status:</label>
                <input type="text" name="resident_status" id="resident_status" class="form-control form-control-lg"
				  placeholder="<?php echo $resident_status; ?>" />
	</div>
    <div class="form-outline mb-4">
				<input type="submit" name="AddressButton" id="AddressButton" class="form-control form-control-lg"/>
	</div>
    </form>


</div>



<?php } else {?>
<h1>In order to comment, you need to login first</h1>
<?php } ?>
<?php include 'includes/footer.php'; ?>
</body>
</html>