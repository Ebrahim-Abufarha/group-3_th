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

$productID = $_GET['updateid'];
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = (?)");
$stmt->execute([$productID]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
$productName = $product['product_name'];

$productDescription = $product['description'];
$productImg = $product['image_url'];
$discount = $product['discount'];
$stock = $product['stock_quantity'];
$productPrice = $product['price'];


if (isset($_POST['submit'])) {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['product_price'];
    $discount = $_POST['discount'];
    $stock = $_POST['stock'];


    // Keep the existing image if no new one is uploaded
    $filePath = $_POST['existing_img'];

    if (!empty($_FILES['img']['product_name'])) {
        $targetDir = "images/";
        $fileName = basename($_FILES["img"]["product_name"]);
        $fileTmpName = $_FILES["img"]["tmp_name"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($fileExt, $allowedExtensions)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.");
        }

        $newFileName = uniqid("img_", true) . "." . $fileExt;
        $filePath = $targetDir . $newFileName;

        if (!move_uploaded_file($fileTmpName, $filePath)) {
            die("Failed to upload image.");
        }
    }

    // Update the product
    $stmt = $conn->prepare("UPDATE products 
                            SET product_name = ?, description = ?, price = ?, discount = ? ,stock_quantity = ?, image_url = ? 
                            WHERE product_id = ?");
    $result = $stmt->execute([$productName, $description, $price, $discount ,$stock, $filePath, $productID]);

    if ($result) {
        echo '<script>alert("The product was updated successfully");
            window.location.href = "view-product.php";
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
    <title>Update Product</title>
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

        img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
            margin: 0 auto;

        }
    </style>
</head>

<body>

    <nav class="navbar  d-flex justify-content-between">
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
            <a href="view-product.php" class="active-link"><i class="fa-solid fa-bag-shopping me-2"></i> View
                Products</a>
            <a href="all-orders.php"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="content">
            <div class="container my-2 ">
                <h3>Update The Product</h3>
                <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                        <label class="form-label">Current Product Image</label>
                        <br>
                        <img src="<?php echo $productImg; ?>" alt="Product Image" class="rounded img-thumbnail"
                            width="200px">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $productName; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description"
                            value="<?php echo $productDescription; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input type="number" class="form-control" name="product_price"
                            value="<?php echo $productPrice; ?>" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" class="form-control" name="discount" value="<?php echo $discount; ?>" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" value="<?php echo $stock; ?>" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload New Image (Optional)</label>
                        <input type="file" class="form-control" accept=".jpg, .jpeg, .png, .webp" name="img">
                        <input type="hidden" name="existing_img" value="<?php echo $productImg; ?>">
                    </div>

                    <div class="text-center">
                        <button class="btn px-5 me-2"
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px"><a
                                href="view-product.php">Back</a></button>
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