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
    $sql = "UPDATE `platformAdmins` SET `aActive` = ?, `aNotes` = ?, `aRoleId` = ? WHERE `aId` = ?";

    $title = $_POST['title'];

    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['active'],
        $_POST['notes'],
        $title,
        $_POST['aId']
    ];

    $stmt->execute($arrParam);
        
    //先刪除之前的permissions
    $sql2 = "DELETE FROM `rel_platform_permissions` WHERE `aId` = ?";
    $stmt2 = $pdo->prepare($sql2);
    $arrParam2 = [ $_POST['aId'] ];
    $stmt2->execute($arrParam2);

    if(!$stmt2){
        echo "<pre>";
        print_r($pdo->errorInfo());
        echo "</pre>";
    }

    $sql3 = "INSERT INTO `rel_platform_permissions`(`aId`, `aPermissionId`)
    VALUES(?,?)";
    $stmt3 = $pdo->prepare($sql3);

    //若身份為manager
    if($title == 2){
        $allPrms = $pdo->query("SELECT `adminPrmId` FROM `platformPermissions`")->fetchAll(PDO::FETCH_ASSOC);
        //每一個permission都要輸入一次
        for($i=0 ; $i<count($allPrms) ; $i++){
            $arrParam3 = [
                $_POST['aId'],
                $allPrms[$i]['adminPrmId']
            ];
            $stmt3->execute($arrParam3);
        }
    }else if($title == 3){
        //若身份為staff
        for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
            
            $arrPrms = $pdo->query("SELECT `adminPrmId` FROM `platformPermissions` WHERE `adminPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

            $arrParam3 = [
                $_POST['aId'],
                $arrPrms['adminPrmId']
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




