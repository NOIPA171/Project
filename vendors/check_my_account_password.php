<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');


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

    $checksql = "SELECT `vaId` FROM`vendorAdmins` WHERE `vaPassword` = ? AND `vaEmail` = ?";
    $stmtc = $pdo->prepare($checksql);
    $checkparam = [
        $pwd,
        $arrGetInfo['vaEmail']
    ];
    $stmtc->execute($checkparam);
    if($stmtc->rowCount() > 0){
        echo "您有相同的帳號存在，請重新輸入密碼";
        exit();
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

}else{
    echo "密碼不正確";
    exit();
}