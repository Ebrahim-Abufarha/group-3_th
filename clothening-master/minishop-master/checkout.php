<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
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
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">


    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* .container4 {
    max-width: 800px;
    margin: 50px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
} */

h3 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="tel"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="tel"]:focus {
    border-color: #dbcc8f;
    outline: none;
    box-shadow: 0 0 5px #dbcc8f;
}

small {
    color: red;
    font-size: 12px;
}

.cart-detail {
    padding: 20px;
    border-radius: 8px;
    background: #f9f9f9;
    margin-top: 20px;
}

.cart-detail h3 {
    font-size: 20px;
    color: #444;
}

p.d-flex {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
}

p.total-price {
    font-weight: bold;
    color: #dbcc8f;
    font-size: 18px;
}

.radio label {
    display: block;
    margin: 5px 0;
}

input[type="submit"] {
    background: #dbcc8f;
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: all 0.3s ease;
}

input[type="submit"]:hover {
    background: #dbcc8f;
}

.checkbox-wrap {
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.checkbox-wrap a {
    color: #dbcc8f;
    text-decoration: none;
}

.checkbox-wrap a:hover {
    text-decoration: underline;
}



    </style>
  
    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
  </head>
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
                <a class="dropdown-item" href="product-single.php">Single Product</a>
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

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
      <div class="container4">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 ftco-animate">
            <form method="POST" onsubmit="return validateForm()">
                <label for="firstname">First Name:</label><br>
                <input type="text" id="firstname" name="firstname"><br><br>
                <small id="first"></small>
				<br>

                <label for="lastname">Last Name:</label><br>
                <input type="text" id="lastname" name="lastname"><br><br>
                <small id="last"></small>
				<br>
                <label for="emailaddress">Email Address:</label><br>
                <input type="text" id="emailaddress" name="emailaddress"><br><br>
                <small id="email"></small>
				<br>
                <label for="phone">Phone:</label><br>
                <input type="text" id="phone" name="phone"><br><br>
                <small id="phone"></small>
				<br>
                <label for="streetaddress">Street Address:</label><br>
                <input type="text" id="streetaddress" name="streetaddress"><br><br>
                <small id="address"></small>
				<br>
                <label for="towncity">Town / City:</label><br>
                <input type="text" id="towncity" name="towncity"><br><br>
                <small id="city"></small>
				<br>
                <label for="postcodezip">Postal Code:</label><br>
                <input type="text" id="postcodezip" name="postcodezip"><br><br>
                <small id="code"></small>
				<br>
            <div class="row mt-5 pt-3 d-flex">
              <div class="col-md-6 d-flex">
                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                  <h3 style="text-align: left;" class="billing-heading mb-4">Cart Total</h3>
                  <p class="d-flex">
                    <span>Subtotal</span>
                    <span>$50.00</span>
                  </p>
                  <p class="d-flex">
                    <span>Delivery</span>
                    <span>$5.00</span>
                  </p>
                  <p class="d-flex">
                    <span>Discount</span>
                    <span>- $5.00</span>
                  </p>
                  <hr>
                  <p class="d-flex total-price">
                    <span>Total</span>
                    <span>$50.00</span>
                  </p>
                </div>
              </div>

              <div class="col-md-6 d-flex">
                <div class="cart-detail bg-light p-3 p-md-4">
                  <h3 style="text-align: left;" class="billing-heading mb-4">Payment Method</h3>
                  <div class="form-group">
                    <div class="col-md-12">
                      <div class="payment-wrap">
                        <div class="d-flex">
                          <div class="radio">
                            <label><input type="radio" name="paymentmethod"> Direct Bank Transfer</label>
                          </div>
                        </div>
                        <div class="d-flex">
                          <div class="radio">
                            <label><input type="radio" name="paymentmethod"> Check Payment</label>
                          </div>
                        </div>
                        <div class="d-flex">
                          <div class="radio">
                            <label><input type="radio" name="paymentmethod"> PayPal</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mt-4">
                    <label style="background-color: #dbcc8f;" class="checkbox-wrap checkbox-primary">
                      <input type="checkbox" checked>
                      <span class="checkmark"></span>
                      I accept the <a href="#">terms and conditions</a>
                    </label>
                  </div>
				  <input name="check" type="submit" value="Submit">
				  </form>
          <?php 
    if (isset($_REQUEST['check'])) {
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo "<script>alert('Successfully logged in');</script>";
        } else {
            header('Location: registration.php');
            exit(); // To ensure the script stops after the redirection
        }
    }
?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Gilded Garments</h2>
              <p>Delivering the finest clothing for all your needs.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
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
    <script src="js/main.js"></script>
    <script>
        function validateForm() {
            const firstname = document.getElementById("firstname").value;
            const lastname = document.getElementById("lastname").value;
            const email = document.getElementById("emailaddress").value;
            const phone = document.getElementById("phone").value;
            const streetAddress = document.getElementById("streetaddress").value;
            const city = document.getElementById("towncity").value;
            const zip = document.getElementById("postcodezip").value;
            
            let valid = true;

            // Reset error messages
            document.getElementById("first").textContent = "";
            document.getElementById("last").textContent = "";
            document.getElementById("email").textContent = "";
            document.getElementById("phone").textContent = "";
            document.getElementById("address").textContent = "";
            document.getElementById("city").textContent = "";
            document.getElementById("code").textContent = "";

            if (firstname === "") {
                document.getElementById("first").textContent = "First name is required";
                valid = false;
            }
            if (lastname === "") {
                document.getElementById("last").textContent = "Last name is required";
                valid = false;
            }
            if (email === "") {
                document.getElementById("email").textContent = "Email address is required";
                valid = false;
            }
            if (phone === "") {
                document.getElementById("phone").textContent = "Phone number is required";
                valid = false;
            }
            if (streetAddress === "") {
                document.getElementById("address").textContent = "Street address is required";
                valid = false;
            }
            if (city === "") {
                document.getElementById("city").textContent = "City is required";
                valid = false;
            }
            if (zip === "") {
                document.getElementById("code").textContent = "Postal code is required";
                valid = false;
            }

            return valid;
        }
    </script>
  </body>
</html>
