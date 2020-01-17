<?php

//check vendor verify days
$timeV = new DateTime($_SESSION['vendorVerify']);
$timeDiffV = $timeV->diff(new DateTime());
$daysTotalV = $timeDiffV->days;

//vendor admin verify days
$timeA = new DateTime($_SESSION['adminVerify']);
$timeDiffA = $timeA->diff(new DateTime());
$daysTotalA = $timeDiffA->days;

//帳號未初始verify
if($daysTotalV > 10 || $daysTotalV > 10){
    echo "Please verify your email";
    // TO DO: 讓使用者不能更動內容 OR 讓頁面不能點選-->css加入pointer-events:none?
}else{
    echo "you are within verification date";
}

