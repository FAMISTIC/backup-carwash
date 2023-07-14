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
	<title>Appointment Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
	<style>
    body{background-color: white;}
</style>
</head>

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
<?php } else {?>

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
<?php } ?>

<body class="vh-100">
	<div class="carousel-inner">
	<div class="carousel-item active">
		<img  width=100% height='600' src="img/gambar_carwash2.jpg" >
	</div></div><br>
	<div class="container-fluid padding">
		<div class="row welcome text-center">
			<div class="col-12">
			<h1 class="display-4">About Us</h1><br>
			</div>
			<hr>
			<div>
				<p>Heisenberg Car Wash is a business shop that offers car wash service in Subang, Selangor. It was founded by Jota, an Indonesian immigrant in 2010. The company ran for 12-hour a day. However, the shop was sold to the new owner, Ungku Arif due to family problems in 2012. In 2014, Ungku Arif  had begun making his company become a leading professional car cleaning service in Subang, Selangor. The car wash shop is a  single big warehouse size which can fit over 20 cars.</p>
				<p>The shop had been helping customers keep their vehicles valuable. Every vehicle can be cleaned which makes more customers often come to the car wash shop. The whole staff is polite and friendly. Their job is to ensure customers are 100% satisfied with their service because customer satisfaction always be prioritized. Special packages and discounts are offered to the regular  customers. Statistically, there are a big number of vehicles coming to the shop every month estimating 1,000 units due to good services.</p>
				<p>Heisenberg Car Wash is a convenient place where people want their car to be checked up. Hence, the company is prepared to help customers gaining greater services in Subang. They are committed to work to satisfy customer’s criteria in every cleaning service.  Heisenberg Car Wash gives affordable deals to customers so they can be more satisfied. The company takes pride in maintaining a customer-centric approach, always striving to go the extra mile to ensure customer happiness. The company values feedback and actively listens to customer suggestions and preferences, continuously improving their services based on valuable insights. With a reputation for excellent customer service and a dedication to meeting and exceeding expectations, Heisenberg Car Wash aims to become the go-to destination for car owners in Subang.</p>
			</div>
		</div>
		</div>
	</div>
	<hr class="my-4">
	</div>

<div>

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
</div>
<hr class="my-4">
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
	<?php include 'includes/footer.php'; ?>
  </body>
</html>