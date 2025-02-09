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

$orderItemID = $_GET['updateid'];
$stmt = $conn->prepare("
                    SELECT 
                        orders.order_id,
                        orders.total_price,
                        orders.created_at AS order_date,
                        orders.status AS order_status,

                        products.price,
                        products.product_id,
                        products.product_name AS product_name,
                        order_items.order_item_id,
                        order_items.quantity,
                        order_items.price AS item_price
                    FROM orders
                    JOIN order_items ON orders.order_id = order_items.order_id
                    JOIN products ON order_items.product_id = products.product_id
                    WHERE order_item_id = ?
                    ORDER BY order_items.product_id
                ");
$stmt->execute([$orderItemID]);
$orderItems = $stmt->fetch(PDO::FETCH_ASSOC);
if ($orderItems) {
    $productID = $orderItems['product_id'];
    $productName = $orderItems['product_name'];
    $orderProductQuantity = $orderItems['quantity'];
    $productPrice = $orderItems['item_price'];
} else {
    die("Error: No order item found.");
}

if (isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $stmt = $conn->prepare("UPDATE  order_items SET quantity = (?), price = $quantity * $orderItems[price]   WHERE order_item_id = (?)");
    $result = $stmt->execute([$quantity, $orderItemID]);

    if ($result) {
        echo '<script>alert("The item was updated successfully");
                window.location.href = "update-order.php?updateid=' . $orderItems['order_id'] . '&refresh=' . time() .'";
                </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update order item</title>
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
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .form-control {
            height: 42px !important;
            border-radius: 5px
        }

        button.btn a {
            color: white !important;
        }
    </style>
</head>

<body>

    <nav class="navbar  d-flex justify-content-between">
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
            <a href="view-product.php"><i class="fa-solid fa-bag-shopping me-2"></i> View Products</a>
            <a href="all-orders.php" class="active-link"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="content">
            <div class="container my-2 ">
                <h3>Update Item quantity</h3>
                <form method="post" enctype="multipart/form-data">
                    <h4></h4>
                    <p class='fs-5'><strong>Product ID:</strong> <?php echo $productID ?></p>
                    <p class='fs-5'><strong>Product Name:</strong> <?php echo $productName ?></p>
                    <p class='fs-5'><strong>Total Price:</strong> <?php echo $productPrice ?> JD</p>

                    <div class="d-flex align-items-center">
                        <p class="fs-5 mb-0 me-2"><strong>Quantity</strong></p>
                        <input type="number" class="form-control w-25" name="quantity"
                            value="<?php echo $orderProductQuantity; ?>" min="0">
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn px-5 me-2 "
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px"><a
                                href="update-order.php?updateid=<?php echo $orderItems['order_id'] ?>">Back</a></button>
                        <button type="submit" class="btn px-5"
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px"
                            name="submit">Update</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>