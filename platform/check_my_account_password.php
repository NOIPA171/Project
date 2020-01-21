<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');


$pwd = sha1($_POST['newpwd']);
$user = $arrGetInfo['aId'];

$sql = "SELECT `aId` FROM `platformAdmins` WHERE `aPassword` = ? AND `aId` = ?";

$stmt = $pdo->prepare($sql);

$arrParam = [
    sha1($_POST['originalpwd']),
    $arrGetInfo['aId']
];

$stmt->execute($arrParam);

if($stmt->rowCount()>0){
    $update = "UPDATE `platformAdmins` SET `aPassword` = '$pwd' WHERE `aId` = '$user'";
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