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
    <title>Categories</title>
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
        .form-control {
            height: 42px !important;
            border-radius: 5px
        }

        button.btn.btn-primary a {
            color: white !important;
        }

        button.btn.btn-primary:hover a {
            color: #dbcc8f !important;
        }

        .container{
            width: 75% !important;
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
            <a href="category.php" class="active-link"> <i class="fa-solid fa-list-check me-2"></i>Categories</a>
            <a href="view-product.php"><i class="fa-solid fa-bag-shopping me-2"></i> View Products</a>
            <a href="all-orders.php"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="container">
            <div class="d-flex justify-content-between  w-75 mx-auto mt-3">
                <h2>All Categories</h2>
                <button class="btn btn-primary "><i class="fa-solid fa-plus"></i><a href="add-category.php"
                        style="text-decoration: none; font-size:medium"> Add New Category</a></button>
            </div>

            <table class="table table-striped mx-auto mt-4 fs-6" style="width:70%;">
                <thead>
                    <tr>
                        <th scope="col">Category ID</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare('SELECT * FROM categories ORDER BY category_id');
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (count($categories) > 0) {
                        foreach ($categories as $category) {
                            echo "<tr>
                        <td>$category[category_id]</td>
                        <td>$category[category_name]</td>
                        <td>
                            <a href='view-category.php?viewid=$category[category_id]'><i class='fa-solid fa-eye text-info'></i></a>
                            <a href='update-category.php?updateid=$category[category_id]' class='mx-2'><i class='fa-solid fa-pen text-warning'></i></a>
                            <a href='' onclick='confirmDelete($category[category_id]); return false;' ><i class='fa-solid fa-trash-can text-danger'></i></a>
                        </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No orders for today.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this category?")) {
                    window.location.href = "delete-category.php?deleteid=" + id;
                }
            }
        </script>
    </div>
    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>