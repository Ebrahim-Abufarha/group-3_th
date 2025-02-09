<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $orderID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `orders` WHERE order_id = ?");
    $result = $stmt-> execute([$orderID]);
    if ($result) {
        echo '<script>alert("The order was deleted successfully");
            window.location.href = "dashboard.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>