<?php


if($arrGetInfo['vVerify']!=='verified'){
    $vVerifyTime = new DateTime($arrGetInfo['vVerify']);
    $vVerifyLeft = $vVerifyTime->diff(new DateTime());
    
    if( $vVerifyLeft->i >= 10){
        echo "請驗證公司信箱以繼續操作";
        exit();
    }
}

if($arrGetInfo['vaVerify']!=='verified'){

    // echo "請驗證您的信箱";

    $vaVerifyTime = new DateTime($arrGetInfo['vaVerify']);
    $vaVerifyLeft = $vaVerifyTime->diff(new DateTime());
    
    if($vaVerifyLeft->i >= 10){
        echo "請驗證您的信箱以繼續操作";
        exit();
    }
}
