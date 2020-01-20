<?php

require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');
$pagePrm = 'prmV00';
require_once('./checkPrm.php');


try{
    $pdo->beginTransaction();
    //先刪除vendor admins
    $sql= "DELETE FROM `vendorAdmins` WHERE `vaId` = '{$_GET['deleteId']}'";
    $pdo->query($sql);

    //再刪除他的權限
    $sql2 = "DELETE FROM `rel_vendor_permissions` WHERE `vaId` = '{$_GET['deleteId']}'";
    $pdo->query($sql2);
    $pdo->commit();
    header("Refresh: 0 ; url = ./staff.php");
}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
    exit();
}
