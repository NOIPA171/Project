<?php

session_start();

if(!isset($_SESSION['email']) || $_SESSION['active']!=='active'){
    session_unset();
    session_destroy();
    header('Refresh: 3 ; url = ./login.php');
    echo "Access Denied";
    exit();
}