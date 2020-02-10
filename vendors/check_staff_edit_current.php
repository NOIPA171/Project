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
    $sql = "SELECT `vaRoleId`,`vaFName`,`vaLName`,`vaEmail`,`vaActive`,`vaVerify`,`vaNotes`
    FROM `vendoradmins`
    WHERE `vaId` = ?";

    $vaId = $

    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['active'],
        $_POST['notes'],
        $title,
        $_POST['vaId']
    ];

    $stmt->execute($arrParam);
    
        
    //先刪除之前的permissions
    $sql2 = "DELETE FROM `rel_vendor_permissions` WHERE `vaId` = ?";
    $stmt2 = $pdo->prepare($sql2);
    $arrParam2 = [ $_POST['vaId'] ];
    $stmt2->execute($arrParam2);

        
    $sql3 = "INSERT INTO `rel_vendor_permissions`(`vaId`, `vaPermissionId`)
    VALUES(?,?)";
    $stmt3 = $pdo->prepare($sql3);

    //若身份為manager
    if($title == 2){
        $allPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions`")->fetchAll(PDO::FETCH_ASSOC);
        //每一個permission都要輸入一次
        for($i=0 ; $i<count($allPrms) ; $i++){
            $arrParam3 = [
                $_POST['vaId'],
                $allPrms[$i]['vendorPrmId']
            ];
            $stmt3->execute($arrParam3);
        }
    }else if($title == 3){
        //若身份為staff
        for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){

            $arrPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions` WHERE `vendorPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

            $arrParam3 = [
                $_POST['vaId'],
                $arrPrms['vendorPrmId']
            ];

            $stmt3->execute($arrParam3);
        }
    }
    
    if($stmt3->rowCount()>0){
        $pdo->commit();
        
        echo "Success!";
        header("Refresh: 3 ; url = ./staff.php");
        exit();
    }
        

}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
    exit();
}




