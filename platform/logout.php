<?php

session_start();
require_once('../db.inc.php');

if(isset($_GET['logout']) && $_GET['logout'] === '1'){
    //加入登出時間
    $sql = "UPDATE `platformAdmins` SET `aLogoutTime` = ? WHERE `aId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        date("Y-m-d H:i:s"),
        $_SESSION['userId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){
        session_unset();
        session_destroy();
        header('Refresh: 0; url = ./login.php');
        exit();
    }

}