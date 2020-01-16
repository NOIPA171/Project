<?php

require_once('./checkSession.php');
require_once('./db.inc.php');


if(isset($_GET['logout']) && $_GET['logout'] === '1'){
    session_unset();
    session_destroy();
    header('Refresh: 0; url = ../platform_login.php');
    exit();
}