<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');

$sql = "UPDATE `vendorAdmins` SET `vaFName`= ?, `vaLName`=?, `vaEmail`=?, `vaNotes`=? WHERE `vaId`=?";
$stmt = $pdo->prepare($sql);

$arrParam = [
    $_POST['Fname'],
    $_POST['Lname'],
    $_POST['email'],
    $_POST['notes'],
    $arrGetInfo['vaId']
];

$stmt->execute($arrParam);

if(!$stmt){
    echo "<pre>";
    print_r($pdo->errorInfo());
    echo "</pre>";
    exit();
}

echo "success";