<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data)) {
            $file_path = 'cart.json';
            if (file_exists($file_path)) {
                if (is_writable($file_path)) {
                    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
                    echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
                }
            }
        }
    } 
}
include 'config.php';
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Shop</span></p>
            <h1 class="mb-0 bread">Shop</h1>
          </div>
        </div>
      </div>
    </div>

    <form action="shop.php" method="GET" class="search-form" style="padding: 5%; text-align: center;">
    <input type="text" name="search" placeholder="Search for products..." style="border-color: #dbcc8f; border-radius:30px;" required>
    <button class="btn btn-beige btn-rounded" 
        style="background-color:#e0d8b0; color: #fff; border-color: #dbcc8f; margin-right: 80px; font-size: 1rem; width:5%;"  
        onmouseout="this.style.backgroundColor='#e0d8b0'; this.style.color='#fff'" 
        onmouseover="this.style.backgroundColor='#fff'; this.style.color='#dbcc8f'">Search</button>
</form>
<!-- 
<input type="text" id="search" placeholder="Search...">
<button class="filter-button" data-filter="category1">Category 1</button>
<button class="filter-button" data-filter="category2">Category 2</button>
<button class="filter-button" data-filter="all">Show All</button> -->

<?php
include 'config.php';
$searchResults = [];

if (isset($_GET['search'])) {
    $search = $_GET['search'];  

    $sql = "SELECT products.*, categories.category_name 
            FROM products 
            JOIN categories ON products.category_id = categories.category_id 
            WHERE product_name LIKE :search OR description LIKE :search";

    $stmt = $conn->prepare($sql);

    $searchParam = "%" . $search . "%";  
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);

    $stmt->execute();

    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$NumItemPage = 9;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $NumItemPage;

$statment = $conn->prepare("SELECT * FROM products LIMIT :offset ,:NumItemPage");
$statment->bindParam(':offset', $offset, PDO::PARAM_INT);
$statment->bindParam(':NumItemPage', $NumItemPage, PDO::PARAM_INT);
$statment->execute();

?>

<div class="row">
    <?php if (!empty($searchResults)): ?>
        <?php foreach ($searchResults as $product): ?>
            <div class="col-sm-6 col-md-6 col-lg-2 ftco-animate d-flex">
                <div class="product d-flex flex-column">
                    <a href="product-single.php?id=<?php echo $product['product_id']; ?>" class="img-prod">
                        <img style="height: 300px;width:300px" class="img-fluid" src="<?php echo $product['image_url']; ?>" alt="Product Image">
                        
                        <?php
                        $original_price = $product['price'];
                        if (!empty($product['discount'])) {
                            $discount_percentage = $product['discount'];
                            if ($product['stock_quantity'] > 0) {
                                echo '<span class="status">' . $discount_percentage . '% Off</span>';
                            } else {
                                echo '<span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);">' . $discount_percentage . '% Off (Sold out)</span>';
                            }
                        } else {
                            if ($product['stock_quantity'] <= 0) {
                                echo '<span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);"> (Sold out)</span>';
                            }
                        }
                        ?>
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3">
                        <div class="d-flex">
                            <div class="cat"><span><?php echo $product['category_name']; ?></span></div>
                            <div class="rating">
                                <p class="text-right mb-0">
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                </p>
                            </div>
                        </div>
                        <h3><a href="#"><?php echo $product['product_name']; ?></a></h3>
                        <?php
                        if (!empty($product['discount'])) {
                            $discount_value = ($original_price * $discount_percentage) / 100;
                            $final_price = $original_price - $discount_value;
                            echo '<div class="pricing">
                                <p class="price"><span class="mr-2 price-dc">JD ' . $original_price . '</span><span class="price-sale">JD ' . $final_price . '</span></p>
                            </div>';
                        } else {
                            echo '<div class="pricing">
                                <p class="price"><span>JD ' . $original_price . '</span></p>
                            </div>';
                        }
                        ?>
                        <p class="bottom-area d-flex px-3">
                            <?php if ($product['stock_quantity'] <= 0): ?>
                                <a style="cursor: not-allowed; pointer-events: none;" class="add-to-cart text-center py-2 mr-1">
                                    <span>Add to cart <i class="ion-ios-add ml-1"></i></span>
                                </a>
                            <?php else: ?>
                                <a style="cursor: pointer;" class="add-to-cart text-center py-2 mr-1"
                                    data-id="<?php echo $product['product_id']; ?>"
                                    data-name="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                    data-price="<?php echo $original_price; ?>"
                                    data-image="<?php echo $product['image_url']; ?>"
                                    data-stock="<?php echo $product['stock_quantity']; ?>"
                                    data-description="<?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>"
                                    data-discount="<?php echo $product['discount']; ?>">
                                    <span>Add to cart <i class="ion-ios-add ml-1"></i></span>
                                </a>
                            <?php endif; ?>
                            <a href="#" class="buy-now text-center py-2" 
                                data-id="<?php echo $product['product_id']; ?>"
                                data-name="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-price="<?php echo $original_price; ?>"
                                data-image="<?php echo $product['image_url']; ?>"
                                data-stock="<?php echo $product['stock_quantity']; ?>"
                                data-description="<?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-discount="<?php echo $product['discount']; ?>">
                                Buy now <span><i class="ion-ios-cart ml-1"></i></span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
// Pagination logic
$totalProductsStatement = $conn->query("SELECT COUNT(*) FROM products");
$totalProducts = $totalProductsStatement->fetchColumn();
$totalPage = ceil($totalProducts / $NumItemPage);
?>

<div class="row mt-5">
    <div class="col text-center">
        <div class="block-27">
            <ul>
                <?php if ($currentPage > 1): ?>
                    <li><a href="?page=<?php echo $currentPage - 1; ?>">&lt;</a></li>
                <?php else: ?>
                    <li><span>&lt;</span></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                    <li class="<?php echo $i == $currentPage ? 'active' : ''; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPage): ?>
                    <li><a href="?page=<?php echo $currentPage + 1; ?>">&gt;</a></li>
                <?php else: ?>
                    <li><span>&gt;</span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>


    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-12 order-md-last">
    				<div class="row">
					<?php
                  

					$NumItemPage = 12;
					$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
					$offset = ($currentPage - 1) * $NumItemPage;
                                                  // Show products

                    $statment = $conn->prepare("SELECT * FROM products LIMIT :offset ,:NumItemPage ");
					$statment->bindParam(':offset', $offset, PDO::PARAM_INT);
					$statment->bindParam(':NumItemPage', $NumItemPage, PDO::PARAM_INT);
                    $statment->execute();

                    foreach($statment->fetchAll(PDO::FETCH_ASSOC) as $item) {
   
					echo ' <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
		    				<div class="product d-flex flex-column"> ' ;

							echo '<a href="product-single.php?id=' . $item['product_id'] . '" class="img-prod">
							<img style="width: 300px;height:300px" class="img-fluid" src="' . $item['image_url'] . '" alt="Product Image">';
					
		    				$original_price = $item['price'];
							if(!empty($item['discount'])){

								$discount_percentage = $item['discount'];
                    
                               if($item['stock_quantity']  > 0 ){
								echo ' <span class="status"> '. $discount_percentage.'% Off' .' </span>
		    						<div class="overlay"></div>
		    					</a>'; }else{
									echo ' <span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);"> '. $discount_percentage.'% Off (Sold out)' .' </span>
		    						<div class="overlay"></div>
		    					</a>';
								}
							}else{
								if($item['stock_quantity']  <= 0 ){
									echo ' <span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);">  (Sold out) </span> ';
								}
								echo '<div class="overlay"></div>
		    					</a>';
							}
							  echo '<div class="text py-3 pb-4 px-3">
		    						<div class="d-flex">
		    							<div class="cat"><span>Lifestyle</span>
				    					</div>
										<div class="rating">
			    							<p class="text-right mb-0">
			    								<a href="#"><span class="ion-ios-star-outline"></span></a>
			    								<a href="#"><span class="ion-ios-star-outline"></span></a>
			    								<a href="#"><span class="ion-ios-star-outline"></span></a>
			    								<a href="#"><span class="ion-ios-star-outline"></span></a>
			    								<a href="#"><span class="ion-ios-star-outline"></span></a>
			    							</p>
			    						</div>
			    					</div>';	
		    					
				    			echo '<h3><a href="#"> '. $item['product_name']  . '</a></h3>';			
								if(!empty($item['discount'])){
									$discount_value = ($original_price * $discount_percentage ) / 100;
									$final_price = $original_price - $discount_value;

									echo ' <div class="pricing">
			    						<p class="price"><span class="mr-2 price-dc">JD '. $original_price. '</span><span class="price-sale">JD'. $final_price .'</span></p>
			    					</div> ';	
								} else{

									echo ' <div class="pricing">
			    						<p class="price"><span>JD '. $original_price .'</span></p>
			    					</div> ';
								}                   // ADD Item To Cart
								
		    						echo '<p class="bottom-area d-flex px-3">';
									if ($item['stock_quantity'] <= 0) {
										echo '<a style="cursor: not-allowed; pointer-events: none;" class="add-to-cart text-center py-2 mr-1">
												<span>Add to cart <i class="ion-ios-add ml-1"></i></span>
											  </a>';
									} else {
										echo '<a style="cursor: pointer;" class="add-to-cart text-center py-2 mr-1" 
												data-id="' . $item['product_id'] . '" 
												data-name="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" 
												data-price="' . $original_price . '" 
												data-image="' . $item['image_url'] . '" 
												data-stock="' . $item['stock_quantity'] . '" 
												data-description="' . htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') . '" 
												data-discount="' . $item['discount'] . '">
												<span>Add to cart <i class="ion-ios-add ml-1"></i></span>
											  </a>';
									}
									
									echo '<a href="#" class="buy-now text-center py-2" 
											data-id="' . $item['product_id'] . '" 
											data-name="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" 
											data-price="' . $original_price . '" 
											data-image="' . $item['image_url'] . '" 
											data-stock="' . $item['stock_quantity'] . '" 
											data-description="' . htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') . '" 
											data-discount="' . $item['discount'] . '">
											Buy now <span><i class="ion-ios-cart ml-1"></i></span>
										  </a>
		    						</p>
		    					</div>
		    				</div>
		    			</div>';
					}


					$totalProductsStatement = $conn->query("SELECT COUNT(*) FROM products");
					$totalProducts = $totalProductsStatement->fetchColumn();
                    $totalPage = ceil($totalProducts/$NumItemPage);

					?>
		    			 <!-- Pagination buttons -->
						
		    		</div>
		    		<div class="row mt-5">
		          <div class="col text-center">
		            <div class="block-27">
		              <ul>
						<?php if($currentPage > 1): ?>
						<li><a href="?page=<?php echo $currentPage - 1; ?>">&lt;</a></li>
						<?php else: ?>
                        <li><span>&lt;</span></li>
                        <?php endif; ?>
						<?php  for ($i = 1 ; $i <= $totalPage ; $i++): ?>
		                <li class="<?php echo $i == $currentPage ? 'active' : ''; ?>"> <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php endfor; ?>

					   <?php if ($currentPage < $totalPage): ?>
                       <li><a href="?page=<?php echo $currentPage + 1; ?>">&gt;</a></li>
                       <?php else: ?>
                       <li><span>&gt;</span></li>
                       <?php endif; ?>

		              </ul>
		            </div>
		          </div>
		        </div>
		    	</div>

         
         
		    	<div class="col-md-4 col-lg-2">
            

                
                ...
<!-- <div class="col-md-4 col-lg-2">
    <div class="sidebar">
        <div class="sidebar-box-2">
            <h2 class="heading">Categories</h2>
            <div class="fancy-collapse-panel">
                <form action="shop.php" method="GET">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Men's Shoes
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul>
                                        <li><button type="submit" name="category" value="Sport">Sport</button></li>
                                        <li><button type="submit" name="category" value="Casual">Casual</button></li>
                                        <li><button type="submit" name="category" value="Running">Running</button></li>
                                        <li><button type="submit" name="category" value="Jordan">Jordan</button></li>
                                        <li><button type="submit" name="category" value="Soccer">Soccer</button></li>
                                        <li><button type="submit" name="category" value="Football">Football</button></li>
                                        <li><button type="submit" name="category" value="Lifestyle">Lifestyle</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Women's Shoes
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul>
                                        <li><button type="submit" name="category" value="Sport">Sport</button></li>
                                        <li><button type="submit" name="category" value="Casual">Casual</button></li>
                                        <li><button type="submit" name="category" value="Running">Running</button></li>
                                        <li><button type="submit" name="category" value="Jordan">Jordan</button></li>
                                        <li><button type="submit" name="category" value="Soccer">Soccer</button></li>
                                        <li><button type="submit" name="category" value="Football">Football</button></li>
                                        <li><button type="submit" name="category" value="Lifestyle">Lifestyle</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Accessories
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul>
                                        <li><button type="submit" name="category" value="Jeans">Jeans</button></li>
                                        <li><button type="submit" name="category" value="T-Shirt">T-Shirt</button></li>
                                        <li><button type="submit" name="category" value="Jacket">Jacket</button></li>
                                        <li><button type="submit" name="category" value="Shoes">Shoes</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">Clothing
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <ul>
                                        <li><button type="submit" name="category" value="Jeans">Jeans</button></li>
                                        <li><button type="submit" name="category" value="T-Shirt">T-Shirt</button></li>
                                        <li><button type="submit" name="category" value="Jacket">Jacket</button></li>
                                        <li><button type="submit" name="category" value="Shoes">Shoes</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->
<?php
$searchResults = [];
if (isset($_GET['category'])) {
    $category = $_GET['category'];  
    $sql = "SELECT products.*, categories.category_name 
            FROM products 
            JOIN categories ON products.category_id = categories.category_id 
            WHERE categories.category_name LIKE :category";

    $stmt = $conn->prepare($sql);
    $categoryParam = "%" . $category . "%";
    $stmt->bindParam(':category', $categoryParam, PDO::PARAM_STR);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($searchResults)) {
    foreach ($searchResults as $product) {
        echo '<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">';
        echo '<div class="product d-flex flex-column">';
        echo '<a href="#" class="img-prod">< img  class="img-fluid" src="images/' . $product['image_url'] . '" alt="Product Image">';
        echo '<div class="overlay"></div></a>';
        echo '<div class="text py-3 pb-4 px-3">';
        echo '<div class="d-flex">';
        echo '<div class="cat"><span>' . $product['category_name'] . '</span></div>';
        echo '<div class="rating"><p class="text-right mb-0">';
        echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
        echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
        echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
        echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
        echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
        echo '</p></div></div>';
        echo '<h3><a href="#">' . $product['product_name'] . '</a></h3>';
        echo '<div class="pricing"><p class="price"><span>$' . $product['price'] . '</span></p></div>';
        echo '<p class="bottom-area d-flex px-3">';
        echo '<a href="#" class="add-to-cart text-center py-2 mr-1"><span>Add to cart <i class="ion-ios-add ml-1"></i></span></a>';
        echo '<a href="#" class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>';
        echo '</p></div></div></div>';
    }
}
?>


              <?php
// تفعيل عرض الأخطاء أثناء التطوير
error_reporting(E_ALL);
ini_set('display_errors', 1);

// إعداد الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothing_ecommerce_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$searchResults = [];

if (isset($_GET['price_from']) || isset($_GET['price_to'])) {
   
    $price_from = isset($_GET['price_from']) && is_numeric($_GET['price_from']) ? (int)$_GET['price_from'] : 0;
    $price_to = isset($_GET['price_to']) && is_numeric($_GET['price_to']) ? (int)$_GET['price_to'] : PHP_INT_MAX;

    
    $sql = "SELECT products.*, categories.category_name 
            FROM products 
            JOIN categories ON products.category_id = categories.category_id 
            WHERE products.price BETWEEN :price_from AND :price_to";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':price_from', $price_from, PDO::PARAM_INT);
    $stmt->bindParam(':price_to', $price_to, PDO::PARAM_INT);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


 <!-- <form method="GET" class="colorlib-form-2">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="price_from">Price from:</label>
                    <div class="form-field">
                        <i class="icon icon-arrow-down3"></i>
                        <select name="price_from" id="price_from" class="form-control">
                            <option value="1">1</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="price_to">Price to:</label>
                    <div class="form-field">
                        <i class="icon icon-arrow-down3"></i>
                        <select name="price_to" id="price_to" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="120">120</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-beige btn-rounded" 
            style="background-color:#e0d8b0; color: #fff; border-color: #dbcc8f;  font-size: 15px;"  
            onmouseout="this.style.backgroundColor='#e0d8b0'; this.style.color='#fff'" 
            onmouseover="this.style.backgroundColor='#fff'; this.style.color='#dbcc8f'">Filter</button>
    </form> -->
               <!-- show results-->
<div class="row">
    <?php if (!empty($searchResults)): ?>
        <?php foreach ($searchResults as $product): ?>
            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                <div  class="product d-flex flex-column">
                    <a  href="#" class="img-prod">
                        <img style="width: 300px;height:300px"  class="img-fluid" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3">
                        <div class="d-flex">
                            <div class="cat">
                                <span><?php echo htmlspecialchars($product['category_name']); ?></span>
                            </div>
                            <div class="rating">
                                <p class="text-right mb-0">
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                </p>
                            </div>
                        </div>
                        <h3><a href="#"><?php echo htmlspecialchars($product['product_name']); ?></a></h3>
                        <div class="pricing">
                            <p class="price"><span>$<?php echo htmlspecialchars($product['price']); ?></span></p>
                        </div>
                        <p class="bottom-area d-flex px-3">
                            <a href="#" class="add-to-cart text-center py-2 mr-1"><span>Add to cart <i class="ion-ios-add ml-1"></i></span></a>
                            <a href="#" class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        
    <?php endif; ?>
</div>

						</div>
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
          <h2 class="ftco-heading-2" style="font-size: xx-large;">Clothening</h2>
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
          <div class="block-23 mb-3" >
            <ul>
              <li><span class="icon icon-map-marker" ></span><span class="text" style="font-size: 14px;">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
              <li><a href="#"><span class="icon icon-phone"></span><span class="text" style="font-size: 14px;">+96277512829</span></a></li>
              <li><a href="#"><span class="icon icon-envelope"></span><span class="text" style="font-size: 14px;">info@yourdomain.com</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <p style="font-size: 12px;">&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" style="font-size: 12px;">Colorlib</a></p>
      </div>
    </div>
  </div>
</footer>

    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

                       <!-- Script for Add to LocalStorage -->  
<script>
document.querySelectorAll('.buy-now').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
		
		var stockQuantity = this.getAttribute('data-stock');
		if(stockQuantity <= 0  ){

			return;
		}
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
   
		var productIndex = cart.findIndex(function(product){
			return product.id === productId;
		});

		if (productIndex !== -1){

			if(cart[productIndex].quantity >= stockQuantity){
				
				window.location = "cart.php";
				return;
			}
			cart[productIndex].quantity  += 1;
		}else{
			cart.push({
				...(discount > 0 ? { discount: discount } : {}),
				user_id:user ,
                id: productId,
                name: productName,
                price: productPrice,
				description: description,
                image: productImage,
                quantity: 1
            });
		}

		localStorage.setItem('cart', JSON.stringify(cart));
	var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var currentUserId = "1"; 
    var userCart = cart.filter(function(item) {
        return String(item.user_id) === currentUserId; 
    });

    fetch('shop.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
		
        body: JSON.stringify(userCart)
    })
    .then(response => response.json())
    .then(data => {
		alert("nkjnnk");
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
});
document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        var user = 1;
		
		var discount = 0;
var discountValue = this.getAttribute('data-discount');

if (discountValue && discountValue.trim() !== "" && discountValue > 0) {
    discount = discountValue;
}
		var productId = this.getAttribute('data-id');
		var description = this.getAttribute('data-description');
        var productName = this.getAttribute('data-name');
        var productPrice = parseFloat(this.getAttribute('data-price'));
        var productImage = this.getAttribute('data-image');

		                   // get data LocalStorage
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
   
		var productIndex = cart.findIndex(function(product){
			return product.id === productId;
		});
		 
		
		var productStock = this.getAttribute('data-stock');
		if (productIndex !== -1){
            if(cart[productIndex].quantity >= productStock){
				return;
			}
			cart[productIndex].quantity  += 1;
		}else{
			cart.push({
				...(discount > 0 ? { discount: discount } : {}),
				user_id:user ,
                id: productId,
                name: productName,
                price: productPrice,
				description: description,
                image: productImage,
                quantity: 1
            });
		}

		localStorage.setItem('cart', JSON.stringify(cart));
		var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var currentUserId = "1"; 
    var userCart = cart.filter(function(item) {
        return String(item.user_id) === currentUserId; 
    });

    fetch('shop.php', { 
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
 });
});



</script>

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
    function filterCards() {
        var searchValue = $('#search').val().toLowerCase();
        var categoryFilter = $('.filter-button.active').attr('data-filter');
        var priceRange = $('.price-button.active').attr('data-price').split('-');
        var minPrice = parseInt(priceRange[0]);
        var maxPrice = priceRange[1] === '+' ? Infinity : parseInt(priceRange[1]);

        $('.card').hide().filter(function() {
            var textMatch = $(this).text().toLowerCase().indexOf(searchValue) > -1;
            var categoryMatch = categoryFilter === 'all' || $(this).data('category') === categoryFilter;
            var price = parseFloat($(this).data('price'));
            var priceMatch = price >= minPrice && price <= maxPrice;
            return textMatch && categoryMatch && priceMatch;
        }).show();
    }

    $('#search').on('keyup', filterCards);

    $('.filter-button').on('click', function() {
        $('.filter-button').removeClass('active');
        $(this).addClass('active');
        filterCards();
    });

    $('.price-button').on('click', function() {
        $('.price-button').removeClass('active');
        $(this).addClass('active');
        filterCards();
    });

    // Initialize filters
    $('.filter-button[data-filter="all"]').addClass('active');
    $('.price-button[data-price="0-50"]').addClass('active');
});
</script>
    
  </body>
</html>

