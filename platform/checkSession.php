<?php

session_start();

if(!isset($_SESSION['email']) || !isset($_SESSION['userId'])){
    session_unset();
    session_destroy();
    header('Refresh: 3 ; url = ./login.php');
    echo "Access Denied";
    exit();
}