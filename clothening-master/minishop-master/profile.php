<?php
session_start();
require 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: regestration.php');
    exit();
}

function getUserData($userId) {
    try {
        $database = new Database();
        $db = $database->connect();
        $query = 'SELECT first_name, last_name, email, address FROM users WHERE user_id = :userId';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function updateUserData($userId, $firstName, $lastName, $email, $address) {
    try {
        $database = new Database();
        $db = $database->connect();
        $query = 'UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email, address = :address WHERE user_id = :userId';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function getOrders($userId) {
    try {
        $database = new Database();
        $db = $database->connect();
        $query = 'SELECT o.order_id, o.total_price, o.status, o.created_at, 
                         oi.product_id, oi.quantity, oi.price, 
                         p.product_name 
                  FROM orders o 
                  JOIN order_items oi ON o.order_id = oi.order_id 
                  JOIN products p ON oi.product_id = p.product_id 
                  WHERE o.user_id = :userId';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    if (updateUserData($_SESSION['user_id'], $firstName, $lastName, $email, $address)) {
        echo 'Profile updated successfully.';
    } else {
        echo 'Error updating profile.';
    }
}

$userData = getUserData($_SESSION['user_id']);
if (!$userData) {
    echo 'Error fetching user data.';
    exit();
}

$orders = getOrders($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="path/to/your/custom.css">


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
        .order-details {
            display: none;
        }
        .nav-item.active .nav-link {
            color: #fff !important;
            color: #dbcc8f !important;
        }
    </style>
</head>
<body class="goto-here">
    <!-- Navbar -->
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

    <div style="margin-top: 120px;" class="container">
        <h1>My Profile</h1>
        <form method="POST" action="profile.php">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($userData['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($userData['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($userData['address']); ?>" required>
            </div>
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>

        <h2 class="mt-5">My Orders</h2>
        <?php if ($orders): ?>
            <?php
            $currentOrderId = null;
            $orderCounter = 1; 
            foreach ($orders as $order):
                if ($currentOrderId !== $order['order_id']):
                    if ($currentOrderId !== null):
                        echo '</tbody></table>';
                    endif;
                    $currentOrderId = $order['order_id'];
            ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $orderCounter++; ?></td> <!-- عرض رقم الطلب -->
                                <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                                <td><button class="btn btn-primary" onclick="toggleOrderDetails(<?php echo $order['order_id']; ?>)">View Details</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered order-details" id="order-details-<?php echo $order['order_id']; ?>">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php endif; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['price']); ?></td>
                            </tr>
            <?php endforeach; ?>
                        </tbody>
                    </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
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
    <!-- Bootstrap JS and dependencies -->
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
    <script>
        function toggleOrderDetails(orderId) {
            var detailsTable = document.getElementById('order-details-' + orderId);
            if (detailsTable.style.display === 'none' || detailsTable.style.display === '') {
                detailsTable.style.display = 'table';
            } else {
                detailsTable.style.display = 'none';
            }
        }
    </script>
</body>
</html>