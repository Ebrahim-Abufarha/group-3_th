
<?php

session_start();
include 'config.php';
include 'Database.php';
$db = new Database();
$conn = $db->connect();

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check content type to differentiate between form submission and JSON API calls
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (stripos($contentType, 'application/json') !== false) {
        // Handle cart data (JSON POST request)
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data)) {
            $file_path = 'cart.json';
            if (file_exists($file_path)) {
                if (is_writable($file_path)) {
                    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
                    echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
                    exit;
                } else {
                    echo json_encode(["status" => "error", "message" => "Unable to write to file"]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "File does not exist"]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "No data received"]);
            exit;
        }
    } else {
        // Handle comment submission (form POST request)
        if (!isset($_SESSION['user_id'])) {
            header("Location: regestration.php");
            exit();
        }

        $user_id = $_POST['user_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['message'];

        $query1 = 'INSERT INTO comments (comment, rating, id_user, product_id) VALUES (:comment, :rating, :id_user, :product_id)';
        $stmt = $conn->prepare($query1);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':id_user', $user_id);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            header('Location: product-single.php?id=' . $product_id);
            exit();
        } else {
            echo 'Error saving feedback.';
            exit();
        }
    }}

// Fetch comments from the database
$query = 'SELECT comments.comment, comments.rating, comments.created_at, users.first_name FROM comments JOIN users ON comments.id_user = users.user_id WHERE comments.product_id = :product_id ORDER BY comments.created_at DESC';
$stmt = $conn->prepare($query);
$stmt->bindParam(':product_id', $product_id);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);

	if (!empty($data)) {
		$file_path = 'cart.json';
		if (file_exists($file_path)) {
			if (is_writable($file_path)) {
				file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));

				// تأكد من إرسال استجابة JSON فقط دون إعادة التوجيه
				echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
				exit; // تأكد من إنهاء السكربت بعد إرسال الاستجابة
			} else {
				echo json_encode(["status" => "error", "message" => "Unable to write to file"]);
				exit;
			}
		} else {
			echo json_encode(["status" => "error", "message" => "File does not exist"]);
			exit;
		}
	} else {
		echo json_encode(["status" => "error", "message" => "No data received"]);
		exit;
	}
}

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
	<script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
	<style>
		/* styleing the shap of the star*/
		.star-rating {
			display: flex;
			flex-direction: row-reverse;
			justify-content: center;
			gap: 5px;
		}

		.star-rating input {
			display: none;
		}

		.star-rating label {
			font-size: 30px;
			color: #ccc;
			cursor: pointer;
			transition: color 0.3s ease-in-out;
		}

		.star-rating input:checked~label,
		.star-rating label:hover,
		.star-rating label:hover~label {
			color: gold;
		}
	</style>
	<style>
		.out-of-stock {
			filter: grayscale(100%) brightness(70%);
			opacity: 0.6;
		}

		.out-of-stock-label {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: rgba(63, 63, 63, 0.5);
			color: white;
			padding: 8px 16px;
			font-size: 16px;
			font-weight: bold;
			border-radius: 5px;
		}
	</style>
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
	<!-- END nav -->

	<div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
		<div class="container">
			<div class="row no-gutters slider-text align-items-center justify-content-center">
				<div class="col-md-9 ftco-animate text-center">
					<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Shop</span></p>
					<h1 class="mb-0 bread">Shop</h1>
				</div>
			</div>
		</div>
	</div>

	<?php
	include 'config.php';

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$product_id = $_GET['id'];

		$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
		$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
		$stmt->execute();
		$product = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($product) {
			if ($product['discount'] > 0) {
				$product_price = $product['price'] - ($product['price'] * ($product['discount'] / 100));
			} else {
				$product_price = $product['price'];
			}
			$product_name = $product['product_name'];
			$product_image = $product['image_url'];
			$product_description = $product['description'];
			$product_stock = $product['stock_quantity'];
			$product_discount = $product['discount'];
		}
	} else {
		echo "* Error Id Not Found";
		exit();
	}

	?>

	<section class="ftco-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mb-5 ftco-animate">
					<a href="<?php echo $product_image  ?>" class="image-popup prod-img-bg"><img src="<?php echo $product_image;  ?>" class="img-fluid <?php echo ($product_stock == 0) ? 'out-of-stock' : ''; ?>" alt="Colorlib Template">
						<?php if ($product_stock == 0): ?>
							<div class="out-of-stock-label"> Currently Unavailable </div>
						<?php endif; ?>
					</a>
				</div>
				<div class="col-lg-6 product-details pl-md-5 ftco-animate">
					<h3><?php echo  $product_name; ?></h3>
					<div class="rating d-flex">
						<p class="text-left mr-4">
							<a href="#" class="mr-2">5.0</a>
							<a href="#"><span class="ion-ios-star-outline"></span></a>
							<a href="#"><span class="ion-ios-star-outline"></span></a>
							<a href="#"><span class="ion-ios-star-outline"></span></a>
							<a href="#"><span class="ion-ios-star-outline"></span></a>
							<a href="#"><span class="ion-ios-star-outline"></span></a>
						</p>
						<p class="text-left mr-4">
							<a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
						</p>
						<p class="text-left">
							<?php   //  retrieves the number of times a specific product has been sold. 
							$statement = $conn->prepare("SELECT COUNT(*) AS total_purchases FROM order_items WHERE product_id = :product_id");
							$statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
							$statement->execute();

							$result = $statement->fetch(PDO::FETCH_ASSOC);
							$totalPurchases = $result['total_purchases'] ?? 0;
							?>
							<a href="#" class="mr-2" style="color: #000;"><?php echo $totalPurchases; ?> <span style="color: #bbb;">Sold</span></a>
						</p>
					</div>
					<p class="price"><span>JD <?php echo $product_price;  ?></span></p>
					<p style=" overflow-wrap: break-word;"><?php echo $product_description; ?></p>

					<div class="row mt-4">
						<div class="col-md-6">
							<div class="form-group d-flex">
								<div class="select-wrap">
									<div class="icon"><span class="ion-ios-arrow-down"></span></div>
									<select name="" id="" class="form-control">
										<option value="">Small</option>
										<option value="">Medium</option>
										<option value="">Large</option>
										<option value="">Extra Large</option>
									</select>
								</div>
							</div>
						</div>
						<div class="w-100"></div>
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
									<i class="ion-ios-remove"></i>
								</button>
							</span>
							<input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="<?php echo $product_stock; ?>" disabled>
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field=""
									<?php echo ($product_stock <= 0) ? 'disabled' : ''; ?>>
									<i class="ion-ios-add"></i>
								</button>
							</span>
						</div>
						<div class="w-100"></div>
						<div class="col-md-12">
							<p style="color: #000;"><?php echo $product_stock; ?> piece available</p>
						</div>
					</div>
					<?php
					if ($product_stock <= 0) {
						echo '<p><a  style="cursor: not-allowed; pointer-events: none;" class="btn btn-black py-3 px-5 mr-2">Add to Cart</a><a style="cursor: not-allowed; pointer-events: none;" class="btn btn-primary py-3 px-5">Buy now</a></p>';
					} else {
						echo '<a style="color: white;" id="Add-to-Cart" 
						data-id="' . $product_id . '" 
						data-name="' . $product_name . '" 
						data-price="' . $product_price . '" 
						data-image="' . $product_image . '" 
						data-discount="' . $product_discount . '" 
						data-description="' . $product_description . '" 
						class="btn btn-black py-3 px-5 mr-2">Add to Cart</a>';

						echo '<a href="cart.php" id="Buy-now" 
						data-id="' . $product_id . '" 
						data-name="' . $product_name . '" 
						data-price="' . $product_price . '" 
						data-image="' . $product_image . '" 
						data-discount="' . $product_discount . '" 
						data-description="' . $product_description . '"
						class="btn btn-primary py-3 px-5">Buy now</a>';
					}

					?>
				</div>
			</div>




			<div class="row mt-5">
				<div class="col-md-12 nav-link-wrap">
					<div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Description</a>

						<a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Manufacturer</a>

						<a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reviews</a>

					</div>
				</div>
				<div class="col-md-12 tab-wrap">

					<div class="tab-content bg-light" id="v-pills-tabContent">

						<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
							<div class="p-4">
								<h3 class="mb-4">Nike Free RN 2019 iD</h3>
								<p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
							</div>
						</div>

						<div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
							<form action="product-single.php?id=<?php echo $product_id; ?>" method="post" class="p-4 border rounded bg-light">
								<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
								<div class="mb-3 text-center">
									<label class="form-label d-block">Rate Our Service:</label>
									<div class="star-rating">
										<input type="radio" id="star5" name="rating" value="5" required>
										<label for="star5"><i class="fa-solid fa-star"></i></label>
										<input type="radio" id="star4" name="rating" value="4">
										<label for="star4"><i class="fa-solid fa-star"></i></label>
										<input type="radio" id="star3" name="rating" value="3">
										<label for="star3"><i class="fa-solid fa-star"></i></label>
										<input type="radio" id="star2" name="rating" value="2">
										<label for="star2"><i class="fa-solid fa-star"></i></label>
										<input type="radio" id="star1" name="rating" value="1">
										<label for="star1"><i class="fa-solid fa-star"></i></label>
									</div>
								</div>
								<div class="mb-3">
									<label for="message" class="form-label">Feedback Message:</label>
									<textarea class="form-control" id="message" name="message" rows="4" required></textarea>
								</div>
								<button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
							</form>
						</div>
						<div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
						<div class="row p-4">
								<div class="col-md-7">
									<h3 class="mb-4"><?php echo count($comments); ?> Reviews</h3>
									<?php foreach ($comments as $comment): ?>
										<div class="review">
											<!-- <div class="user-img" style="background-image: url(images/person_1.jpg)"></div> -->
											<div class="desc">
												<h4>
													<span class="text-left"><?php echo htmlspecialchars($comment['first_name']); ?></span>
													<span class="text-right"><?php echo htmlspecialchars($comment['created_at']); ?></span>
												</h4>
												<p class="star">
													<span>
														<?php for ($i = 0; $i < $comment['rating']; $i++): ?>
															<i class="fa-solid fa-star"></i>
														<?php endfor; ?>
													</span>
												</p>
												<p><?php echo htmlspecialchars($comment['comment']); ?></p>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<footer class="ftco-footer ftco-section" style="font-size: 14px; padding: 20px 0;">
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
						<h2 class="ftco-heading-2" style="font-size: xx-large;">Gilded Garments</h2>
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
							<li><a href="#" class="py-2 d-block" style="font-size: 14px;">Shop</a></li>


							<li><a href="#" class="py-2 d-block" style="font-size: 14px;">Contact Us</a></li>
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
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
		</svg></div>


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
		$(document).ready(function() {

			var quantitiy = 0;
			$('.quantity-right-plus').click(function(e) {

				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var quantity = parseInt($('#quantity').val());

				// If is not undefined

				$('#quantity').val(quantity + 1);


				// Increment

			});

			$('.quantity-left-minus').click(function(e) {
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var quantity = parseInt($('#quantity').val());

				// If is not undefined

				// Increment
				if (quantity > 0) {
					$('#quantity').val(quantity - 1);
				}
			});

		});
	</script>

	<script>
		var currentProductId = "<?php echo $product_id; ?>";
		$(document).ready(function() {
			var cart = JSON.parse(localStorage.getItem('cart')) || [];
			var productIndex = cart.findIndex(product => product.id === currentProductId);

			if (productIndex !== -1) {
				$('#quantity').val(cart[productIndex].quantity);
			} else {
				$('#quantity').val(1);
			}
		});

		$(document).ready(function() {
			$('.quantity-right-plus').click(function(e) {
				e.preventDefault();

				var quantityInput = $('#quantity');
				var quantity = parseInt(quantityInput.val(), 10);
				var max = parseInt(quantityInput.attr('max'), 10) || Infinity;

				if (quantity < max) {
					quantityInput.val(quantity + 1);
				}
			});

			$('.quantity-left-minus').click(function(e) {
				e.preventDefault();

				var quantityInput = $('#quantity');
				var quantity = parseInt(quantityInput.val(), 10);
				var min = parseInt(quantityInput.attr('min'), 10) || 1;

				if (quantity > min) {
					quantityInput.val(quantity - 1);
				}
			});
		});

		// localStorage


		$('#Buy-now, #Add-to-Cart').click(function(e) {
			e.preventDefault();

			var quantity = $('#quantity').val();

			var user = 1;
			var discount = 0;
			var discountValue = this.getAttribute('data-discount');

			if (discountValue && discountValue.trim() !== "" && discountValue > 0) {
				discount = discountValue;
			}
			var description = this.getAttribute('data-description');
			var productId = this.getAttribute('data-id');
			var productName = this.getAttribute('data-name');
			var productPrice = parseFloat(this.getAttribute('data-price'));
			var productImage = this.getAttribute('data-image');


			// get data LocalStorage
			var cart = JSON.parse(localStorage.getItem('cart')) || [];

			var productIndex = cart.findIndex(function(product) {
				return product.id === productId;
			});

			if (productIndex !== -1) {

				cart[productIndex].quantity = parseInt(quantity, 10);
				//cart[productIndex].quantity  += 1;
			} else {
				cart.push({
					...(discount > 0 ? {
						discount: discount
					} : {}),
					user_id: user,
					id: productId,
					name: productName,
					price: productPrice,
					description: description,
					image: productImage,
					quantity: parseInt(quantity, 10)
				});
			}
			// save data to LocalStorage

			localStorage.setItem('cart', JSON.stringify(cart));
			var cart = JSON.parse(localStorage.getItem('cart')) || [];
			var currentUserId = "1";
			var userCart = cart.filter(function(item) {
				return String(item.user_id) === currentUserId;
			});


			fetch('product-single.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify(userCart)
				})
				.then(response => response.json())
				.then(data => {

					if (data.status === "success") {
						console.log("Data saved successfully:", data.message);
					} else {
						console.error("Error saving data:", data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
			window.location = "cart.php";
		});
	</script>

</body>

</html>