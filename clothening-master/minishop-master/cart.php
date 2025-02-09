<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data)) {
            $file_path = 'cart.json';
            if (file_exists($file_path)) {
                if (is_writable($file_path)) {
                    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
                    echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "File is not writable"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "File does not exist"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "No data provided"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid content type"]);
    }
} else {
     json_encode(["status" => "error", "message" => "Invalid request method"]);
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
.popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
  width: 300px;
}

button {
  padding: 10px;
  margin: 10px;
  border: none;
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #45a049;
}

button#confirmNo {
  background-color: #f44336;
}

button#confirmNo:hover {
  background-color: #e53935;
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

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Removal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRemove">Remove</button>
            </div>
        </div>
    </div>
</div>
    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <?php
                    require 'config.php';
                    $file = 'cart.json';
                    $fileContent = file_get_contents($file);
                    if (file_exists($file) && $fileContent !== '"[]"') {
                        $current_data = file_get_contents($file);
                        $products = json_decode($current_data, true);
                        ?>
                        <div class="cart-list">
                            <table class="table">
                              
                                <tbody>
                                <?php foreach ($products as $product): 
                                 
                                    $price = $product['price'];
                                    if (isset($product['discount']) && $product['discount'] > 0) {
                                        $price = $price - ($price * $product['discount'] / 100);
                                    }
                                    
                               
                                    $stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
                                    $stmt->execute([$product['id']]);
                                    $stock = $stmt->fetch(PDO::FETCH_ASSOC)['stock_quantity'] ?? 0;
                                ?>
                                    <tr class="text-center" data-product-id="<?= $product['id'] ?>">
                                    <td class="product-remove">
                                    <a href="#" onclick="showConfirmModal(<?= $product['id'] ?>)">
                                    <span class="ion-ios-close"></span>
                                    </a>
                                    </td>
                                        <td class="image-prod">
                                            <div class="img" style="background-image:url(<?= $product['image'] ?>)"></div>
                                        </td>
                                        <td class="product-name">
                                            <h3><?= $product['name'] ?></h3>
                                            <p><?= $product['description'] ?></p>
                                        </td>
                                        <td class="price">JD <span class="price-value"><?= number_format($price, 2) ?></span></td>
                                        <td class="quantity">
                                            <div class="input-group d-flex mb-3">
                                                <button type="button" 
                                                    class="quantity-left-minus btn btn-sm" 
                                                    onclick="updateQuantity('minus', <?= $product['id'] ?>, 1)"
                                                    <?= $product['quantity'] <= 1 ? 'disabled' : '' ?>>
                                                    <i class="ion-ios-remove"></i>
                                                </button>
                                                <input type="text" 
                                                    id="quantity-<?= $product['id'] ?>" 
                                                    class="quantity form-control" 
                                                    value="<?= $product['quantity'] ?>" 
                                                    disabled>
                                                <button type="button" 
                                                    class="quantity-right-plus btn btn-sm" 
                                                    onclick="updateQuantity('plus', <?= $product['id'] ?>, <?= $stock ?>)"
                                                    <?= $product['quantity'] >= $stock ? 'disabled' : '' ?>>
                                                    <i class="ion-ios-add"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="total">JD <span class="item-total"><?= number_format($price * $product['quantity'], 2) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
           
            <div class="row justify-content-start">
                <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Cart Totals</h3>
                        <p class="d-flex">
                            <span>Subtotal</span>
                            <span class="subtotal">JD 1.00</span>
                        </p>
                        <p class="d-flex">
                            <span>Delivery</span>
                            <span class="delivery">JD 0.00</span>
                        </p>
                        <p class="d-flex">
                            <span>Discount</span>
                            <span class="discount">JD 0.00</span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            <span class="total-amount">JD 0.00</span>
                        </p>
                    </div>
                    <p class="text-center"><a href="checkout.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-section" style="font-size: 14px; padding:15px 0;">
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
						<h2 class="ftco-heading-2" style="font-size: x-large;">Clothening</h2>
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
  
    function updateQuantity(action, productId, maxStock) {
        const quantityInput = document.getElementById(`quantity-${productId}`);
        let currentQty = parseInt(quantityInput.value);
        const row = quantityInput.closest('tr');
        
        
        if (action === 'plus' && currentQty < maxStock) {
            currentQty++;
        } else if (action === 'minus' && currentQty > 1) {
            currentQty--;
        }
        
     
        quantityInput.value = currentQty;
        updateItemTotal(row, currentQty);
        updateCartData(productId, currentQty);
        updateTotals();
        updateCartCount();
    }

   
    function updateItemTotal(row, quantity) {
        const price = parseFloat(row.querySelector('.price-value').textContent);
        row.querySelector('.item-total').textContent = (price * quantity).toFixed(2);
    }

    
    function updateCartData(productId, quantity) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const index = cart.findIndex(item => item.id == productId);
        
        if (index !== -1) {
            cart[index].quantity = quantity;
        } else {
            cart.push({ id: productId, quantity });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateServer(cart);
    }

    
    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-total').forEach(item => {
            subtotal += parseFloat(item.textContent);
        });
        
        const cartData = localStorage.getItem('cart');
        const delivery = cartData && cartData !== '[]' ? 10 : 0; 
        const discount = 0; 
        const total = subtotal + delivery - discount;
        
        document.querySelector('.subtotal').textContent = `JD ${subtotal.toFixed(2)}`;
        document.querySelector('.delivery').textContent = `JD ${delivery.toFixed(2)}`;
        document.querySelector('.discount').textContent = `JD ${discount.toFixed(2)}`;
        document.querySelector('.total-amount').textContent = `JD ${total.toFixed(2)}`;
    }

   
    async function updateCartCount() {
    // Get cart items from localStorage
    const localCart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalCount = localCart.reduce((acc, item) => acc + item.quantity, 0);

    try {
        // Fetch data from the JSON file
        const response = await fetch('data.json'); // Update the path if necessary
        const data = await response.json();

        // Filter items for user ID 1 and sum their quantities
        const userItems = data.filter(item => item.userId === 1);
        const userCount = userItems.reduce((acc, item) => acc + item.quantity, 0);
        
        // Add the user's count to the total
        totalCount += userCount;
    } catch (error) {
        console.error('Error fetching or processing data:', error);
    }

    // Update the DOM with the total count
    // document.querySelector('.cta-colored span').textContent = `[${totalCount}]`;
}
    
    async function updateServer(cartData) {
      if (cartData.length === 0) {
            return;
        }
        try {
            const response = await fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(cartData)
            });
            const result = await response.json();
            console.log('Server response:', result);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    
    document.addEventListener('DOMContentLoaded', () => {
        updateTotals();
        updateCartCount();
    });
    function removeProduct(productId) {
        if (confirm("Are you sure you want to remove this product?")) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(item => item.id !== productId.toString()); 
             localStorage.setItem('cart', JSON.stringify(cart));
             cartData = cart;
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (row) row.remove();
            updateTotals();
            updateCartCount();
            updateServer(cartData);
        }else{
            alert("Product not removed");
    }
  }
    
   
    function showConfirmModal(productId) {
   
    $('#confirmRemove').attr('data-product-id', productId);
    $('#confirmModal').modal('show');
}


$('#confirmRemove').click(function() {
    const productId = $(this).attr('data-product-id');
    removeProduct(productId); 
    $('#confirmModal').modal('hide'); 
});
    </script>
</body>
</html>