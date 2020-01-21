<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');


$sql = "SELECT `aId` FROM `platformAdmins` WHERE `aPassword` = ? AND `aId` = ?";

$stmt = $pdo->prepare($sql);

$arrParam = [
    $_POST['pwd'],
    $arrGetInfo['aId']
];

$stmt->execute($arrParam);

if($stmt->rowCount()>0){
    echo "confirmed";
}else{
    echo "密碼不正確"
}