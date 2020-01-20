<?php

if($arrGetInfo['aActive']!== 'active'){
    session_unset();
    session_destroy();
    echo "Your account is no longer active";
    header('Refresh: 3 ; url = ./login.php');
    exit();
}