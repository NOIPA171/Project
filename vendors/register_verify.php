<?php

if(isset($_GET['hash']) && isset($_GET['email'])){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
}else{
    echo "invalid access";
    exit();
}

$sql = "SELECT `vaId`
        FROM `vendorAdmins`
        WHERE `vaHash` = ?
        AND `vaEmail` =?";
$arrParam = [
    $_GET['hash'],
    $_GET['email']
];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);
if($stmt->rowCount()>0){
    
}