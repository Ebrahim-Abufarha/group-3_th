<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $categoryID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `categories` WHERE category_id = ?");
    $result = $stmt-> execute([$categoryID]);
    if ($result) {
        echo '<script>alert("The category was deleted successfully");
            window.location.href = "category.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>