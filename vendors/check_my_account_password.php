<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');

$pdo->beginTransaction();
$pwd = sha1($_POST['newpwd']);
$user = $arrGetInfo['vaId'];

//先確認舊密碼是否正確
$sql = "SELECT `vaId` FROM `vendorAdmins` WHERE `vaPassword` = ? AND `vaId` = ?";

$stmt = $pdo->prepare($sql);

$arrParam = [
    sha1($_POST['originalpwd']),
    $user
];

$stmt->execute($arrParam);

if($stmt->rowCount()>0){

    // 再確認新密碼不重複

    $checksql = "SELECT `vaId`, `vId` FROM`vendorAdmins` WHERE `vaPassword` = ? AND `vaEmail` = ?";
    $stmtc = $pdo->prepare($checksql);
    $checkparam = [
        $pwd,
        $arrGetInfo['vaEmail']
    ];
    $stmtc->execute($checkparam);
    if($stmtc->rowCount() > 0){
        $arrc = $stmtc->fetchAll(PDO::FETCH_ASSOC)[0];
        //如果是之前的就沒關係
        $s = "SELECT `vId` FROM `vendorAdmins` WHERE `vaId` = '{$arrc['vaId']}'";
        
        $st = $pdo->query($s)->fetchALL(PDO::FETCH_ASSOC);
        
        //有可能是同一個廠商的 -> 允許overwrite
        //非同一組資料則不允許執行
        if($arrc['vId'] != $arrGetInfo['vId']){
            echo "您有相同的帳號存在，請重新輸入密碼";
            exit();
        }  
    }

    $update = "UPDATE `vendorAdmins` SET `vaPassword` = '$pwd' WHERE `vaId` = '$user'";
    $stmtu = $pdo->query($update);
    
    if(!$stmtu){
        echo "<pre>";
        print_r($pdo->errorInfo());
        echo "</pre>";
        exit();
    }
    echo "success";
    $pdo->commit();
}else{
    echo "密碼不正確";
    exit();
}