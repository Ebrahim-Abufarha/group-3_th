<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $productID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `products` WHERE product_id = ?");
    $result = $stmt-> execute([$productID]);
    if ($result) {
        echo '<script>alert("The product was deleted successfully");
            window.location.href = "view-product.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>