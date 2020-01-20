<?php

if($arrGetInfo['aVerify']!=='verified'){
    $vaVerifyTime = new DateTime($arrGetInfo['aVerify']);
    $vaVerifyLeft = $vaVerifyTime->diff(new DateTime());
    
    if($vaVerifyLeft->days > 10){
        echo "請驗證您的信箱以繼續操作";
        exit();
    }
}