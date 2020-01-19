<?php

//是否有驗證過，沒有則加上提醒
if($arrGetInfo['vaVerify']!=='active' || $arrGetInfo['vVerify']!=='active'){
    echo "請驗證您的信箱";
}

//
$vaVerifyTime = new DateTime($arrGetInfo['vaVerify']);
$vaVerifyLeft = $vaVerifyTime->diff(new DateTime());

$vVerifyTime = new DateTime($arrGetInfo['vVerify']);
$vVerifyLeft = $vVerifyTime->diff(new DateTime());

if($vaVerifyLeft->days > 10){
    echo "請驗證您的信箱以繼續操作";
    exit();
}else if( $vVerifyLeft->days > 10){
    echo "請驗證公司信箱以繼續操作";
    exit();
}

