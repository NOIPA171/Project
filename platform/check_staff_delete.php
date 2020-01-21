<?php

require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');
$pagePrm = 'prmA00';
require_once('./checkPrm.php');


try{
    $pdo->beginTransaction();
    //先刪除vendor admins
    $id = $_POST['id'];
    
    $sql= "DELETE FROM `platformAdmins` WHERE `aId` = '$id'";
    $pdo->query($sql);

    //再刪除他的權限
    $sql2 = "DELETE FROM `rel_platform_permissions` WHERE `aId` = '$id'";
    $pdo->query($sql2);
    $pdo->commit();
    echo "success";
    
}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
    exit();
}
