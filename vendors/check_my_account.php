<?php

require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');


//UNFINISHED

$sql = "UPDATE `vendorAdmins`
        SET `vaFName`=?, `vaEmail`=?, `va`";

$arrParam = [
    $_POST['studentId'],
    $_POST['studentName'],
    $_POST['studentGender'],
    $_POST['studentBirthday'],
    $_POST['studentPhoneNumber'],
    $_POST['studentDescription']
];

//確定是否有上傳
if($_FILES['studentImg']['error'] === 0 ){
    
    $fileName = date("YmdHis").".".pathinfo($_FILES['studentImg']['name'], PATHINFO_EXTENSION); 

    //確定是否上傳成功，並存到指定位置
    if(move_uploaded_file($_FILES['studentImg']['tmp_name'], './img_files/'.$fileName)){

        //先刪除舊的檔案

        $imgSql = "SELECT `studentImg`
                    FROM `students`
                    WHERE `id` = ? ";

        $imgParam = [ (int)$_POST['editId'] ];

        $imgStm = $pdo->prepare($imgSql);
        $imgStm->execute($imgParam);

        if($imgStm->rowCount() > 0){

            $imgArr = $imgStm->fetchAll(PDO::FETCH_ASSOC);

            if($imgArr[0]['studentImg']!==NULL){
                @unlink('./img_files/'.$imgArr[0]['studentImg']);
            }
        }

        //因為有上傳圖片，所以將studentImg加入需要修改的資料中
        $sql.= ", `studentImg` = ?";
        $arrParam[] = $fileName;
    }
}

//完成SQL語句
$sql.= " WHERE `id` = ?";
$arrParam[] = (int)$_POST['editId'];

$stmt = $pdo->prepare($sql);

if(!$stmt){
    echo "<pre>";
    print_r($pdo->errorInfo());
    echo "</pre>";
    exit();
}

$stmt->execute($arrParam);

if( $stmt->rowCount() > 0){
    header("Refresh: 3 ; url = ./admin.php");
    echo "Edit Success";
}else{
    header("Refresh: 3 ; url = ./admin.php");
    echo "Edit Fail";
}