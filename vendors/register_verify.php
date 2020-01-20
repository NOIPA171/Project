<?php
//是否有hash 跟 email
if(isset($_GET['hash']) && isset($_GET['email'])){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
}else{
    echo "invalid access";
    exit();
}

require_once('../db.inc.php');

//先看看該帳號是否已驗證過
$sqlCheck = "SELECT `vaVerify` FROM `vendorAdmins` 
WHERE `vaEmail` = '{$_GET['email']}' AND  `vaHash` = '{$_GET['hash']}'";
$arrCheck = $pdo->query($sqlCheck)->fetchAll(PDO::FETCH_ASSOC);

if(count($arrCheck)>0){
    if($arrCheck[0]['vaVerify']==='active'){
        echo "您已經驗證過了";
        header("Refresh: 3 ; url=./login.php");
        exit();
    }
}

try{
    $pdo->beginTransaction();
    $sql = "SELECT `vaId`, `vId`
    FROM `vendorAdmins`
    WHERE `vaHash` = ?
    AND `vaEmail` =?";
    $arrParam = [
    $_GET['hash'],
    $_GET['email']
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    //配對成功
    if($stmt->rowCount()>0){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Admin 跟 Vendors 都改成verified
        $sql2 = "UPDATE `vendorAdmins` 
        SET `vaVerify` = 'verified' 
        WHERE `vaId` = '{$arr[0]['vaId']}' 
        AND `vaEmail`= '{$_GET['email']}'";

        $arr2 = $pdo->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        $sql3 = "UPDATE `vendors`
        SET `vVerify` = 'verified'
        WHERE `vEmail` = '{$_GET['email']}'
        AND `vId` = '{$arr[0]['vId']}'";
        $arr3 = $pdo->query($sql3)->fetchAll(PDO::FETCH_ASSOC);
        
        $pdo->commit();
        echo "success!";
        header("Refresh: 3 ; url = ./login.php");
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failure: ".$err->getMessage();
    exit();
}
