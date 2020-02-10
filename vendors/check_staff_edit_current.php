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

    $sql2 = "SELECT `vendorPrmName`
    FROM `vendorpermissions` 
    INNER JOIN `rel_vendor_permissions`
    ON `vendorpermissions`.`vendorPrmId` = `rel_vendor_permissions`.`vaPermissionId`
    WHERE `rel_vendor_permissions`.`vaId` = ?";

    $stmt = $pdo->prepare($sql);
    $stmt2 = $pdo->prepare($sql2);
    $arrParam = [
        $_POST['vaId']
    ];

    $stmt->execute($arrParam);
    $stmt2->execute($arrParam);



    if($stmt->rowCount() > 0 && $stmt2->rowCount() > 0){

        $pdo->commit();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $arr2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach($arr2 as $key=>$value){
            foreach($value as $k=>$v){
                $arr["permissions"][] = $v;
            }
        } ;
        echo json_encode($arr);
        exit();
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
    exit();
}




