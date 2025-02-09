<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $userID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `users` WHERE user_id = ?");
    $result = $stmt-> execute([$userID]);
    if ($result) {
        echo '<script>alert("The user was deleted successfully");
            window.location.href = "users-account.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>