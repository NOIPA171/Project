<?php
session_start();
require_once('../db.inc.php');

if(isset($_POST['email']) && isset($_POST['password'])){
    //先檢查是否有這個帳號
    $sqlEmail = "SELECT `vaEmail`
                FROM `vendorAdmins`
                WHERE `vaEmail` = ?";
    $arrParamEmail = [ $_POST['email'] ];
    $stmtEmail = $pdo->prepare($sqlEmail);
    $stmtEmail->execute($arrParamEmail);
    //若有該帳號，在檢查email與password是否對得上
    if($stmtEmail->rowCount()>0){
        $sql = "SELECT `vaId`, `vaEmail`, `vId`, `vaActive`
                FROM `vendorAdmins`
                WHERE `vaEmail` = ?
                AND `vaPassword` = ?";

        $stmt = $pdo->prepare($sql);
        $arrParam = [
            $_POST['email'],
            sha1($_POST['password'])
        ];
        $stmt->execute($arrParam);

        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //若帳號非active，則禁止進入
            if($arr[0]['vaActive']!=='active'){
                echo "帳號未啟用，請設置您的帳號，或者聯絡您網站的管理員";
                header("Refresh: 3 ; url = ./login.php");
                exit();
            }

             //成功登入，則建立session

            session_unset();

            //成功登入，紀錄登入時間
            $sqlTime = "UPDATE `vendorAdmins`
                        SET `vaLoginTime` = ?
                        WHERE `vaId` = ?";
            $stmtTime = $pdo->prepare($sqlTime);
            $arrParamTime = [ 
                date("Y-m-d H:i:s"),
                $arr[0]['vaId']
            ];
            $stmtTime->execute($arrParamTime);
            
            //將資訊放入session
            $_SESSION['userId'] = $arr[0]['vaId'];
            $_SESSION['email'] = $arr[0]['vaEmail'];
            $_SESSION['vendor'] = $arr[0]['vId'];

            echo "success";
            // exit();

            // header('Refresh: 5 ;url = ./admin.php');
        }else{
            //登入失敗
            header('Refresh: 5 ; url = ./login.php');
            echo "帳號/密碼錯誤";
            session_unset();
            session_destroy();
        }
    }else{
        //沒有該帳號
        echo "沒有該使用者";
    }
   
}else{
    echo "請輸入帳號密碼";
}