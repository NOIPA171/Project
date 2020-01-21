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
    $sql = "UPDATE `vendorAdmins` SET `vaActive` = ?, `vaNotes` = ? ,`vaRoleId` = ? WHERE `vaId` = ?";

    $title = $_POST['title'];

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

        
    //再輸入
    $sql3 = "INSERT INTO `rel_vendor_permissions`(`vaId`, `vaPermissionId`) VALUES(?,?)";
    $stmt3 = $pdo->prepare($sql3);
    
    for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
        
        $prmId = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions` WHERE `vendorPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

        $arrParam3 = [
            $_POST['vaId'],
            $prmId['vendorPrmId']
        ];
        $stmt3->execute($arrParam3);      
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




