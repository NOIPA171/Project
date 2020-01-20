<?php

if($arrGetInfo['vaActive']!== 'active' || $arrGetInfo['vActive']!== 'active'){
    session_unset();
    session_destroy();
    echo "Your account is no longer active";
    header('Refresh: 3 ; url = ./index.php');
    exit();
}