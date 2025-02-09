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
    <title>Orders</title>
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
            <a href="view-product.php"><i class="fa-solid fa-bag-shopping me-2"></i> View Products</a>
            <a href="all-orders.php"  class="active-link"><i class="fa-solid fa-clipboard-check me-2"></i>All Orders</a>
            <a href="users-account.php"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a href="comments-contacts.php"><i class="fa-solid fa-message me-2"></i>Comments & Contacts</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me2"></i> Logout</a>
        </div>

        <div class="content">
            <h2>Orders</h2>
            <table class="table table-striped mx-auto mt-2 fs-6" style="width:80%;">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare('SELECT * FROM orders ORDER BY created_at DESC');
                        $stmt->execute();
                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (count($orders) > 0) {
                            foreach ($orders as $order) {
                                echo "<tr>
                        <td>$order[order_id]</td>
                        <td>$order[user_id]</td>
                        <td>$order[total_price]</td>
                        <td>$order[created_at]</td>
                        <td id ='status'>$order[status]</td>
                        <td>
                            <a href='view-order.php?viewid=$order[order_id]'><i class='fa-solid fa-eye text-info'></i></a>
                            <a href='update-order.php?updateid=$order[order_id]' class='mx-2'><i class='fa-solid fa-pen text-warning'></i></a>
                            <a href='' onclick='confirmDelete($order[order_id]);  return false;' ><i class='fa-solid fa-trash-can text-danger'></i></a>
                        </td>
                    </tr>";
                            }
                        } 
                        ?>
                    </tbody>

                </table>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this order?")) {
                window.location.href = "delete-order.php?deleteid=" + id;
            }
        }
    document.addEventListener("DOMContentLoaded", function () {
        let statusCells = document.querySelectorAll("td#status"); 

        statusCells.forEach(statusCell => {
            let statusText = statusCell.textContent.trim().toLowerCase();
            if (statusText === "pending") {
                statusCell.style.backgroundColor = "rgb(247 161 72)";
            } else if (statusText === "cancelled") {
                statusCell.style.backgroundColor = "#ff5c5c";
            } else if (statusText === "delivered") {
                statusCell.style.backgroundColor = "#6dff6d";
            } else if (statusText === "shipped") {
                statusCell.style.backgroundColor = "#ffff6d";
            }
        });
    });
</script>






    <script src="https://kit.fontawesome.com/5ab58071a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>