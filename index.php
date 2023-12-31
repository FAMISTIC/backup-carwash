<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['customer_name']) && isset($_SESSION['email'])) {
    // Retrieve the user information from the session variables
	$customer_id = $_SESSION['customer_id'];
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
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Heisenberg CarWash Website</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body class="vh-100">

<?php if(isset($customer_name) && isset($email)){ ?>
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
<!-- nav -->
<body>
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
	<div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
	<form method="" name="form1" class="was-validated">
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Customer Name:</label>
				<input type="text" name="customer_id" id="customer_id" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $customer_id; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Customer Name:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $customer_name; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Email:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $email; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Vehicle Model:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $model; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Vehicle Plate:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $plate; ?>" readonly/>
	</div>
	<div class="form-outline mb-4">
				<label class="form-label" for="customer_name">Vehicle Colour:</label>
				<input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg"
				  placeholder="Enter a Name" value="<?php echo $colour; ?>" readonly/>
	</div>

</div>
		</div>
	</div>

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
				<a class="nav-link" href="about.php">About</a>
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

<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"></li>
		<li data-target="#slides" data-slide-to="1"></li>
		
	</ul>
<div class="carousel-inner">
	<div class="carousel-item active">
		<img  width=100% height='600' src="img/gambar_carwash1.jpg" >
		<div class="carousel-caption">
			<h1 class="display-2"><b>Welcome To Heisenberg CarWash</b></h1>
			<h3>This is our carwash website.</h3><br>
			<a href="appointment.php"><button type="button" class="btn btn-primary btn-lg">Register And Create Appointment</button></a>
			<br><br><br>
		</div>
	</div>
	<div class="carousel-item">
		<img  width=100% height='600' src="img/gambar_carwash3.jpg" >
		<div class="carousel-caption">
			<h3 class="display-2" style="color: rgba(0, 110, 255, 0.74);"><b>The Most Best Service Of The Year</b></h3>
			<br><br><br>
		</div>
	</div>
	
</div>
</div>
</div>
<p><br></p>
<!--- Welcome Section -->
<div class="container-fluid padding">
<div class="row welcome text-center">
	<div class="col-12">
	<h1 class="display-4">Opening Hours</h1>
	</div>
	<hr>
	<div class="col-12">
		<h3 class="display-5">10a.m. - 10p.m.</h3>
	</div>
</div>
</div>
<br><br>
<!--- Three Column Section -->
<div class="container-fluid padding">
<div class="row text-center padding">
	<div class="col-xs-12 col-sm-6 col-md-4">
		<i class="fas fa-car"></i>
		<h3>Best Car Service</h3>	
		<p>Our service has been recognize by people.</p>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		<i class="fas fa-star"></i>
		<h3>First Class Award</h3>	
		<p>Winning No.1 Best Service Award.</p>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		<i class="fas fa-user"></i>
		<h3>Good Review</h3>	
		<p>Good feedback from the community people.</p>
	</div>
</div>
<hr class="my-4">
</div>
    <?php } ?>

<?php include 'includes/footer.php'; ?>
</body>
</html>