<?php
session_start();

include_once 'Database.php';
include_once 'User.php';

$db = new Database();
$user = new User($db->connect());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        if ($user->role == 'customer') {
            header('Location: index.php');
            exit();
        } elseif ($user->role == 'admin') {
            header('Location: http://localhost\clothening-master\minishop-master\admin page\admin page\dashboard.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Invalid email or password';
        header('Location: login.php');
        exit();
    }
}
?>
