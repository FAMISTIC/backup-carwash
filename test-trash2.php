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
<body>

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
				<a class="nav-link" href="#">Service</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">About</a>
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
<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $customer_name; ?>" >
    </div>
  </div>
  <div class="mb-3 row">
  <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $email; ?>">
    </div>
  </div>
  <div class="mb-3 row">
  <label for="staticEmail" class="col-sm-2 col-form-label">Model</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $model; ?>">
    </div>
  </div>
  <div class="mb-3 row">
  <label for="staticEmail" class="col-sm-2 col-form-label">Plate</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $plate; ?>">
    </div>
  </div>
  <div class="mb-3 row">
  <label for="staticEmail" class="col-sm-2 col-form-label">Colour</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $colour; ?>">
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
				<a class="nav-link" href="#">Service</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">About</a>
			</li>
			<li class="nav-item">
				<a href="login.php"><button type="button" class="btn btn-outline-secondary btn-lg">Login</button></a>		
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