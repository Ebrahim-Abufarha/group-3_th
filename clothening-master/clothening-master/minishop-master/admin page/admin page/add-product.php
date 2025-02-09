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


if (isset($_POST['submit'])) {
    $productName = $_POST['product-name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $categoryName = $_POST['category'];

    // Handling file upload
    $targetDir = "images/"; // Folder where images will be stored
    $fileName = basename($_FILES["img"]["name"]); // Get file name
    $fileTmpName = $_FILES["img"]["tmp_name"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Get file extension
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowedExtensions)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.");
    }

    // Generate a unique filename
    $newFileName = uniqid("img_", true) . "." . $fileExt;
    $filePath = $targetDir . $newFileName; // Full path to store in the database

    if (move_uploaded_file($fileTmpName, $filePath)) {

        $stmt = $conn->prepare("SELECT category_id FROM categories WHERE TRIM(LOWER(category_name)) = TRIM(LOWER(?))");
        $stmt->execute([$categoryName]);
        $categoryID = $stmt->fetchColumn();
                // $stmt->execute([$categoryName]);
        // $categoryID = $stmt->fetchColumn();
        
        if (!$categoryID) {  // إذا لم يتم العثور على الفئة، عرض خطأ
            die("Error: The selected category does not exist in the database.");
        }
        

        $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, stock_quantity, category_id, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$productName, $description, $price, $stock, $categoryID, $filePath]);

        if ($result) {
            echo '<script>alert("The product was added successfully");
                window.location.href = "dashboard.php";
                </script>';
            exit;
        } else {
            print_r($stmt->errorInfo());
        }
    } else {
        die("Failed to upload image.");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            <a href="add-product.php" class="active-link"> <i class="fa-solid fa-plus me-2"></i> Add Products</a>
            <a href="category.php"> <i class="fa-solid fa-list-check me-2"></i>Categories</a>
            <a href="view-product.php"><i class="fa-solid fa-bag-shopping me-2"></i> View Products</a>
            <a href="all-orders.php"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="content">
            <div class="container my-2 ">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" placeholder="Enter the name of the product"
                            name="product-name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <input type="text" class="form-control" placeholder="Description" name="description">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" placeholder="Enter the price" name="price" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" placeholder="Stock" name="stock" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select  mb-3" name="category">
                            <option selected>Select Category</option>
                            <?php
                            $stmt = $conn->prepare('SELECT category_name FROM categories');
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($categories) > 0) {
                                foreach ($categories as $category) {
                                    echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                                }
                            }
                            ?>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" accept=".jpg, .jpeg, .png, .webp" name="img">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn px-5"
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px;"
                            name="submit">Add</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>