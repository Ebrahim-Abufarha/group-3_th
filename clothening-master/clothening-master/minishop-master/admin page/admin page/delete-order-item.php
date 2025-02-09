<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $orderItemID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `order_items` WHERE order_item_id = ?");
    $result = $stmt-> execute([$orderItemID]);
    if ($result) {
        echo '<script>alert("The item was deleted successfully");
            window.location.href = "update-order.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>