<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {

    header("Location: http://localhost/clothening-master/minishop-master/regestration.php");
    exit();


}



if (isset($_SESSION['user_id'])) {

if ($_SESSION['user_role']  == 'customer') {
    header("Location: http://localhost/clothening-master/minishop-master/regestration.php");
    exit();
}}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="sidebar.css">
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
        .block-27 ul {
            display: flex;
            list-style: none;
            padding: 0;
            justify-content: center;
            /* Centers the pagination */
            align-items: center;
            gap: 5px;
            /* Adds spacing between elements */
        }

        .block-27 ul li {
            display: inline-block;
            border-radius: 5px;
        }

        .block-27 ul li a {
            text-decoration: none;
            color: #333;
        }

        .block-27 ul li.active {
            color: white;
        }

        .block-27 ul li:hover {
            color: white;
        }

        section {
            padding-top: 20px !important;
            margin: auto !important;
        }

        .img-prod img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }
    </style>
</head>

<body class="goto-here">

    <nav class="navbar d-flex justify-content-between">
        <div>
            <h3>Gilded Garments</h3>
        </div>
        <div>
            <button class="btn"><i class="fa-solid fa-user me-2"></i> <a href="myprofile.php" class="text-dark">My
                    Profile</a></button>
                    <a href="logout.php" class="btn"> <i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
                    </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
        <h4>
            <?php  echo  $_SESSION['first_name'] ?>
            </h4>
            <h4>Admin Dashboard</h4>
            <a href="dashboard.php"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
            <a href="add-product.php"> <i class="fa-solid fa-plus me-2"></i> Add Products</a>
            <a href="category.php"> <i class="fa-solid fa-list-check me-2"></i>Categories</a>
            <a href="view-product.php" class="active-link"><i class="fa-solid fa-bag-shopping me-2"></i> View
                Products</a>
            <a href="all-orders.php"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
        </div>



        <section class="content ftco-section bg-light">
            <div class="container">
                <div class="row justify-content-around">
                    <div class="col-md-8 col-lg-10 order-md-last">
                        <div class="row">
                            <?php

                            $NumItemPage = 10;
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($currentPage - 1) * $NumItemPage;
                            // Show products
                            
                            $statment = $conn->prepare("SELECT * FROM products LIMIT :offset ,:NumItemPage ");
                            $statment->bindParam(':offset', $offset, PDO::PARAM_INT);
                            $statment->bindParam(':NumItemPage', $NumItemPage, PDO::PARAM_INT);
                            $statment->execute();

                            foreach ($statment->fetchAll(PDO::FETCH_ASSOC) as $item) {

                                echo ' <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
		    				<div class="product d-flex flex-column"> ';

                                echo '<a href="show-product.php?id=' . $item['product_id'] . '" class="img-prod">
							<img class="img-fluid" src="' . $item['image_url'] . '" alt="Product Image">';

                                $original_price = $item['price'];
                                if (!empty($item['discount'])) {

                                    $discount_percentage = $item['discount'];

                                    if ($item['stock_quantity'] > 0) {
                                        echo ' <span class="status"> ' . $discount_percentage . '% Off' . ' </span>
		    						<div class="overlay"></div>
		    					</a>';
                                    } else {
                                        echo ' <span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);"> ' . $discount_percentage . '% Off (Sold out)' . ' </span>
		    						<div class="overlay"></div>
		    					</a>';
                                    }
                                } else {
                                    if ($item['stock_quantity'] <= 0) {
                                        echo ' <span class="status" style="background-color:rgb(149, 149, 149); color:rgb(255, 255, 255);">  (Sold out) </span> ';
                                    }
                                    echo '<div class="overlay"></div>
		    					</a>';
                                }
                                echo '<div class="text py-3 pb-4 px-3">';

                                echo '<h3><a href="#"> ' . $item['product_name'] . '</a></h3>';
                                if (!empty($item['discount'])) {
                                    $discount_value = ($original_price * $discount_percentage) / 100;
                                    $final_price = $original_price - $discount_value;

                                    echo ' <div class="pricing">
			    						<p class="price"><span class="mr-2 price-dc">JD ' . $original_price . '</span><span class="price-sale">JD' . $final_price . '</span></p>
			    					</div> ';
                                } else {

                                    echo ' <div class="pricing">
			    						<p class="price"><span>JD ' . $original_price . '</span></p>
			    					</div> ';
                                }                   // ADD Item To Cart
                            
                                echo '<p class="bottom-area d-flex px-3">';
                                if ($item['stock_quantity'] <= 0) {
                                    echo '<a  href="update-product.php?updateid= ' . $item['product_id'] . '" style="cursor: pointer;" class="add-to-cart text-center py-2 mr-1">
												<span>Update<i class="fa-solid fa-pen text-warning ms-2"></i></span>';
                                } else {
                                    echo '<a   href="update-product.php?updateid= ' . $item['product_id'] . '" style="cursor: pointer;" class="add-to-cart text-center py-2 mr-1" 
												data-id="' . $item['product_id'] . '" 
												data-name="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" 
												data-price="' . $original_price . '" 
												data-image="' . $item['image_url'] . '" 
												data-description="' . htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') . '" 
												data-discount="' . $item['discount'] . '">
												<span>Update<i class="fa-solid fa-pen text-warning ms-2"></i></span>
											</a>';
                                }

                                echo '<a href="" onclick="confirmDelete(' . $item['product_id'] . '); return false;"" class="text-center py-2" 
											data-id="' . $item['product_id'] . '" 
											data-name="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" 
											data-price="' . $original_price . '" 
											data-image="' . $item['image_url'] . '" 
											data-stock="' . $item['stock_quantity'] . '" 
											data-description="' . htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') . '" 
											data-discount="' . $item['discount'] . '">
											<span>Delete <i class="fa-solid fa-trash-can text-danger ms-2"></i> </span>
										</a>
		    					</p>
		    					</div>
		    				</div>
		    			</div>';
                            }


                            $totalProductsStatement = $conn->query("SELECT COUNT(*) FROM products");
                            $totalProducts = $totalProductsStatement->fetchColumn();
                            $totalPage = ceil($totalProducts / $NumItemPage);

                            ?>
                            <!-- Pagination buttons -->

                        </div>
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
                                            <li class="<?php echo $i == $currentPage ? 'active' : ''; ?>"> <a
                                                    href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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

                </div>
            </div>
        </section>

    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "delete-product.php?deleteid=" + id;
            }
        }
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

</body>

</html>