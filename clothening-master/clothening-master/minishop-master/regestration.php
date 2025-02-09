<?php
session_start();
if (isset($_SESSION['error_message'])) {
    echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']);
}
if (isset($_SESSION['user_id'])) {
  header('location: index.php');
}

  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="regestration.css">
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
  <link rel="stylesheet" href="css/style.css">
  <style>
  


  </style>
</head>

<body>
  <!-- start nav -->
  <div class="container">
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
                    <li class="nav-item cta cta-colored <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart" style="font-size: x-large;"></span><span style="font-size: 19px;">[0]</span></a></li>
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
  </div>
<!-- end nav -->



  <div class="myContainer" id="container">
    <div class="form-container sign-up-container">
      <form action="register.php" method="POST">
        <h1>Create Account</h1>

        <span>Use your email for registration</span>
        <input name="first_name" onblur="nam(event)" id="Firstname" type="text" placeholder="Firstname" required />
        <small style="text-align: left;" class="form-text small" id="txFirst"></small>
        <input name="last_name" onblur="nam(event)" id="LastName" type="text" placeholder="LastName" required />
        <small class="form-text small" id="txLast"></small>

        <input name="address"  id="address" type="text" placeholder="address" required />
        <small class="form-text small" id="address"></small>

        <input name="email" onblur="validate(event)" id="email" type="email" placeholder="Email" required />
        <small class="form-text small" id="txemail">eg: username@domain.com</small>

        <input name="phone" onblur="validatenumb(event)" id="number" type="tel" placeholder="Mobile Number" required />
        <small id="numberText" class="form-text small">eg: 077********</small>

        <input name="password" onblur="pas(event)" id="password" type="password" placeholder="Password" required />
        <small id="masspass" class="form-text small">The Password should be between 6-18 characters.</small>

        <input onblur="equalpass(event)" id="correctPassword" type="password" placeholder="Confirm Password" required />
        <small id="masspass2" class="form-text small">The Password should be between 6-18 characters.</small>

        <button  type="submit" onclick="haveacc()" id="btnCreat">Sign Up</button>
        <a id="haveAcount" href="">Do have an acount ?</a>

      </form>
    </div>
    <!-- ............................... -->
    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <h1>Sign in</h1>

        <span>Use your account</span>
        <input name="email" id="email1" onblur="validate1(event)" type="email" placeholder="Email" required />
        <div id="txemail1" class="form-text small">eg: username@domain.com</div>

        <input name="password" id="pass1" type="password" placeholder="Password" required />
        <div id="masspass1" class="form-text small"></div>

        <button type="submit" onclick="loginn1(event)">Sign In</button>
        <a id="noAcount" href="">Don't have an acount ?</a>
      </form>
    </div>
    <div class="overlay-container">

      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

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

  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


  <script src="all.js"></script>
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