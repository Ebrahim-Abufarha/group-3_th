<?php

session_start();
session_unset();
session_destroy();
header('location: http://localhost/clothening-master/minishop-master/regestration.php');

exit();
?>