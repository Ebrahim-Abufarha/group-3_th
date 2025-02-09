<?php
include 'config.php';
if(isset($_GET['deleteid'])){
    $commentID = $_GET['deleteid'];
    $stmt =$conn->prepare( "DELETE FROM `comments` WHERE id = ?");
    $result = $stmt-> execute([$commentID]);
    if ($result) {
        echo '<script>alert("The comment was deleted successfully");
            window.location.href = "comments-contacts.php";
            </script>';
        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}
?>