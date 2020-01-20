<?php

require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');
$pagePrm = 'prmA00';
require_once('./checkPrm.php');

if(!isset($_GET['vId']) && !isset($_GET['action'])){
    echo "wrong access";
    exit();
}

if($_GET['action']=='ban'){
    $sql = "UPDATE `vendors` SET `vActive`=?  WHERE `vId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        'inactive',
        $_GET['vId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){
        echo "已將該用戶停權";
        header("Refresh: 3 ; url=./vendors.php");
        exit();
    }else{
        echo "該用戶已停用";
        header("Refresh: 3 ; url=./vendors.php");
        exit();
    }
}else if($_GET['action'] == 'activate'){
    $sql = "UPDATE `vendors` SET `vActive`=?  WHERE `vId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        'active',
        $_GET['vId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){
        echo "已將該用戶啟動";
        header("Refresh: 3 ; url=./vendors.php");
        exit();
    }else{
        echo "該用戶已啟動";
        header("Refresh: 3 ; url=./vendors.php");
        exit();
    }
}

