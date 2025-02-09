<?php
session_start();

include_once 'Database.php';
include_once 'User.php';

$db = new Database();
$user = new User($db->conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    $user->role = 'customer'; 

    if ($user->register()) {
        header('Location: regestration.php');
    } else {
        $_SESSION['error_message'] = 'Email already in use.';
        header('Location: regestration.php');
    }
}
?>