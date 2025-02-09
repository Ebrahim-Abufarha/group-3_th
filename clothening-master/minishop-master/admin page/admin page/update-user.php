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

$userID = $_GET['updateid'];
$stmt = $conn->prepare("SELECT  * FROM users WHERE user_id = (?)");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$email = $user['email'];
$phone = $user['phone'];
$address = $user['address'];


if (isset($_POST['submit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?;");
    $result = $stmt->execute([$firstName, $lastName, $email, $phone, $address, $userID]);

    if ($result) {
        echo '<script>alert("The user  was updated successfully");
                window.location.href = "users-account.php";
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
    <title>Update Category</title>
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

        <div class="content">
            <div class="container my-2 ">
                <h3>Update User</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">First Name:</label>
                        <input class="form-control" type="text" name="first_name" value="<?php echo $firstName; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name:</label>
                        <input class="form-control" type="text" name="last_name" value="<?php echo $lastName; ?>"
                            required>
                    </div>
                    <div class="mb-3"> 
                        <label class="form-label">Email:</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <input class="form-control" type="tel" name="phone" value="<?php echo $phone; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
                    </div>
                    <div class="text-center">
                        <button class="btn px-5 me-2"
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px"><a
                                href="users-account.php">Back</a></button>
                        <button type="submit" class="btn px-5"
                            style="background-color: #dbcc8f ; color:white ; font-size: 18px" name="submit">Update
                            User</button>
                    </div>
            </div>

        </div>
    </div>


    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>