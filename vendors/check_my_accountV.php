<?php

require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');

try{
    $pdo->beginTransaction();
    //先初始化之後要echo的陣列
    $echoArr=[];

    //先update使用者帳號
    $sql = "UPDATE `vendorAdmins`
    SET `vaFName`=?, `vaEmail`=? WHERE `vaId` = ?";

    $arrParam = [
    $_POST['vName'],
    $_POST['vEmail'],
    $arrGetInfo['vaId']
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);


    $sqlV = "UPDATE `vendors` SET `vName` = ?, `vEmail` = ?, `vInfo` = ?";
    $arrVParam = [
    $_POST['vName'],
    $_POST['vEmail'],
    $_POST['vInfo']
    ];

    //確定是否有上傳
    if($_FILES['vImg']['error'] === 0 ){

    $fileName = date("YmdHis").".".pathinfo($_FILES['vImg']['name'], PATHINFO_EXTENSION); 

    //確定是否上傳成功，並存到指定位置
    if(move_uploaded_file($_FILES['vImg']['tmp_name'], './images/'.$fileName)){

        //若有舊檔案則先刪除
        $imgSql = "SELECT `vImg`
                    FROM `vendors`
                    WHERE `vId` = ? ";

        $imgParam = [ $arrGetInfo['vId'] ];

        $imgStm = $pdo->prepare($imgSql);
        $imgStm->execute($imgParam);

        if($imgStm->rowCount() > 0){

            $imgArr = $imgStm->fetchAll(PDO::FETCH_ASSOC);

            if($imgArr[0]['vImg']!==NULL){
                @unlink('./images/'.$imgArr[0]['vImg']);
            }
        }

        //因為有上傳圖片，所以將vImg加入需要修改的資料中
        $sqlV.= ", `vImg` = ?";
        $arrVParam[] = $fileName;
        $echoArr[] = './images/'.$fileName;
        }
    }

    //完成SQL語句
    $sqlV.= " WHERE `vId` = ?";
    $arrVParam[] = $arrGetInfo['vId'];

    $stmtV = $pdo->prepare($sqlV);

    if(!$stmtV){    
    echo "<pre>";
    print_r($pdo->errorInfo());
    echo "</pre>";
    exit();
    }

    $stmtV->execute($arrVParam);

    // header("Refresh: 3 ; url = ./admin.php");
    $echoArr[] = "success";
    echo json_encode($echoArr);
    $pdo->commit();
}catch(Exception $err){
    echo "failed: ".$err->getMessage();
}

