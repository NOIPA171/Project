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
    $id = $_POST['id'];

    $sql= "DELETE FROM `vendorAdmins` WHERE `vaId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [ $id ];
    $stmt->execute($arrParam);

    //再刪除他的權限
    $sql2 = "DELETE FROM `rel_vendor_permissions` WHERE `vaId` = ?";
    $stmt2 = $pdo->prepare($sql2);
    $arrParam2 = [ $id ];
    $stmt2->execute($arrParam2);
    
    $pdo->commit();
    echo "success";
    
}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
    exit();
}
