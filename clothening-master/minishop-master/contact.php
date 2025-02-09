<?php
session_start();

include_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $message = $_POST['message'];

    $db = new Database();
    $conn = $db->connect();

    $query = 'INSERT INTO contact (full_name, email, phone_number, message) VALUES (:full_name, :email, :phone_number, :message)';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo 'Message sent successfully.';
    } else {
        echo 'Error sending message.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contact Us</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

<link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="css/animate.css">

<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<link rel="stylesheet" href="css/magnific-popup.css">

<link rel="stylesheet" href="css/aos.css">

<link rel="stylesheet" href="css/ionicons.min.css">

<link rel="stylesheet" href="css/bootstrap-datepicker.css">
<link rel="stylesheet" href="css/jquery.timepicker.css">

<script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/flaticon.css">
<link rel="stylesheet" href="css/icomoon.css">
<link rel="stylesheet" href="css/style.css">  </head>
  <body class="goto-here">
		
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.php" style="font-size: xx-large;">Gilded Garments</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php" class="nav-link" style="font-size: large;">Home</a></li>
					<li class="nav-item dropdown <?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' || basename($_SERVER['PHP_SELF']) == 'product-single.php' || basename($_SERVER['PHP_SELF']) == 'cart.php' || basename($_SERVER['PHP_SELF']) == 'checkout.php' ? 'active' : ''; ?>">
						<a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: large;">Catalog</a>
						<div class="dropdown-menu" aria-labelledby="dropdown04">
							<a class="dropdown-item" href="shop.php">Shop</a>
							<a class="dropdown-item" href="cart.php">Cart</a>
							<a class="dropdown-item" href="checkout.php">Checkout</a>
						</div>
					</li>
					<li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php" class="nav-link" style="font-size: large;">Contact</a></li>
					<li class="nav-item cta cta-colored <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart" style="font-size: x-large;"></a></li>
					<?php if (isset($_SESSION['user_id'])): ?>
						<li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>"><a href="profile.php" class="nav-link" style="font-size: large;"><i class="fas fa-user"></i> Profile</a></li>
						<li class="nav-item"><a href="logout.php" class="nav-link" style="font-size: large;">Logout</a></li>
					<?php else: ?>
						<li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'regestration.php' ? 'active' : ''; ?>"><a href="regestration.php" class="nav-link" style="font-size: large;">Sign In</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
    <!-- END nav -->

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Contact</span></p>
            <h1 class="mb-0 bread">Contact Us</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section contact-section bg-light">
      <div class="container">
      	<div class="row d-flex mb-5 contact-info">
          <div class="w-100"></div>
          <div class="col-md-3 d-flex">
          	<div class="info bg-white p-4">
	            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
	          </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="info bg-white p-4">
	            <p><span>Phone:</span> <a href="tel://1234567920">+962775128291</a></p>
	          </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="info bg-white p-4">
	            <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
	          </div>
          </div>
          <div class="col-md-3 d-flex">
          	<div class="info bg-white p-4">
	            <p><span>Website</span> <a href="#">yoursite.com</a></p>
	          </div>
          </div>
        </div>
        <div class="container mt-5">
        <h2 class="text-center mb-4">Contact Us</h2>
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Contact Form -->
            <div class="p-4 border rounded bg-light" style="width: 48%;">
                <h4 class="text-center">Get in Touch</h4>
                <form action="contact.php" method="post">
                    <div class="form-group">
                        <label for="full_name" class="form-label">Full Name:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>

            <!-- Location Map -->
            <div class="p-4 border rounded bg-light" style="width: 48%;">
                <h4 class="text-center">Our Location</h4>
                <iframe width="100%" height="300px" frameborder="0" style="border:0; border-radius: 10px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54112.08908245311!2d35.769180654224456!3d32.04204072711298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca2aa6c9505af%3A0xc1d8fa75aade030f!2z2YXYudmH2K8g2KfZhNiq2K_YsdmK2Kgg2KfZhNmF2YfZhtmKINin2YTYs9mE2Lc!5e0!3m2!1sar!2sjo!4v1739008187386!5m2!1sar!2sjo" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></src=>
                </iframe>
            </div>
        </div>
    </div>
      </div>
    </section> 
   

    	
    <footer class="ftco-footer ftco-section" style="font-size: 14px; padding:15px 0;margin-top:200px; width:100%;">
    <div class="container">
      <div class="row">
        <div class="mouse">
          <a href="#" class="mouse-icon">
            <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
          </a>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-md" style="margin-bottom: 15px;">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2" style="font-size: x-large;">Gilded Garments</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
            <ul class="ftco-footer-social list-unstyled  mt-5">
              <li class="ftco-animate"><a href="#"><span><i class="fa-brands fa-x-twitter"></i></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md" style="margin-bottom: 15px;">
          <div class="ftco-footer-widget mb-4 ml-md-5">
            <h2 class="ftco-heading-2" style="font-size: 18px;">Menu</h2>
            <ul class="list-unstyled">
              <li><a href="shop.php" class="py-2 d-block" style="font-size: 14px;">Shop</a></li>


              <li><a href="contact.php" class="py-2 d-block" style="font-size: 14px;">Contact Us</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md" style="margin-bottom: 15px;">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2" style="font-size: 18px;">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text" style="font-size: 14px;">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text" style="font-size: 14px;">+96277512829</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span class="text" style="font-size: 14px;">info@yourdomain.com</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <p style="font-size: 12px;">&copy; <script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" style="font-size: 12px;">Colorlib</a></p>
        </div>
      </div>
    </div>
  </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>