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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <link rel="stylesheet" href="sidebar.css">

    <style>
        button.btn a {
            color: white !important;
        }
    </style>
</head>

<body>

    <nav class="navbar d-flex justify-content-between">
        <div>
            <h3>Gilded Garments</h3>
        </div>
        <div>
        <button class="btn"><i class="fa-solid fa-user me-2"></i> <a href="myprofile.php" class="text-dark">My Profile</a></button>
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
            <a href="view-product.php"><i class="fa-solid fa-bag-shopping me-2"></i> View Products</a>
            <a href="all-orders.php" class="active-link"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="content">
            <h1>Details</h1>

            <?php
            if (isset($_GET['viewid'])) {
                $orderID = $_GET['viewid']; // Get order ID from URL
            
                // Query
                $stmt = $conn->prepare("
                    SELECT 
                        users.user_id,
                        users.first_name AS user_firstname,
                        users.last_name AS user_lastname,
                        users.email AS user_email,
                        users.phone AS user_phone,
                        users.address AS user_address,

                        orders.order_id,
                        orders.total_price,
                        orders.created_at AS order_date,
                        orders.status AS order_status,

                        products.product_id,
                        products.product_name AS product_name,
                        order_items.quantity,
                        order_items.price AS item_price
                    FROM orders
                    JOIN users ON orders.user_id = users.user_id
                    JOIN order_items ON orders.order_id = order_items.order_id
                    JOIN products ON order_items.product_id = products.product_id
                    WHERE orders.order_id = ?
                    ORDER BY order_items.product_id
                ");

                $stmt->execute([$orderID]);
                $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($orderDetails) > 0) {
                    // Show User & Order Info
                    $firstItem = $orderDetails[0];
                    echo "<div class='border p-3 mb-3 text-dark fs-6 bg-white' style='border-radius: 10px;  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;'>
                        <h4>Customer Info</h4>
                        <p><strong>Name:</strong> {$firstItem['user_firstname']} {$firstItem['user_lastname']}</p>
                        <p><strong>Email:</strong> {$firstItem['user_email']}</p>
                        <p><strong>Phone:</strong> {$firstItem['user_phone']}</p>
                        <p><strong>Address:</strong> {$firstItem['user_address']}</p>
                        <hr class='border'>
                        <h4>Order Info</h4>
                        <p><strong>Order ID:</strong> {$firstItem['order_id']}</p>
                        <p><strong>Total Price:</strong> {$firstItem['total_price']} JD</p>
                        <p><strong>Order Date:</strong> {$firstItem['order_date']}</p>
                        <p><strong>Status:</strong> {$firstItem['order_status']}</p>
                    </div>";

                    // Show Order Items
                    echo "<table class='table table-striped mx-auto mt-2 fs-6 text-center' style='width:80%;'>
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>";
                    foreach ($orderDetails as $item) {
                        echo "<tr>
                            <td>{$item['product_id']}</td>
                            <td>{$item['product_name']}</td>
                            <td>{$item['quantity']}</td>
                            <td>{$item['item_price']} JD</td>
                        </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning'>Order details not found.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Invalid request. Order ID missing.</div>";
            }
            ?>
            <div class="text-center">
                <button onclick="goBack()" class="btn px-4"
                    style="background-color: #dbcc8f ; color:white ; font-size: 18px"><a> Back</a></button>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            if (document.referrer) {
                window.location.href = document.referrer;
            } else {
                window.history.back();
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>