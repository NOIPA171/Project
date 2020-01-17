<?php

session_start();

if(!isset($_SESSION['userName']) || $_SESSION['vendorActive'] !== 'active' || $_SESSION['adminActive'] !== 'active'){
    session_unset();
    session_destroy();
    echo "access denied";
    exit();
};
