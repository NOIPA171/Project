<?php

session_start();

if(!isset($_SESSION['userName'])){
    session_unset();
    session_destroy();
    header('Refresh: 3 ; url = platform_login.php');
    echo "Access Denied";
    exit();
}