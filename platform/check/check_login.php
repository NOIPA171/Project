<?php
session_start();
require_once('../../db.inc.php');

if(isset($_POST['email']) && isset($_POST['password'])){
    //先檢查是否有這個帳號
    $sqlEmail = "SELECT `aEmail`
                FROM `platformAdmins`
                WHERE `aEmail` = ?";
    $arrParamEmail = [ $_POST['email'] ];
    $stmtEmail = $pdo->prepare($sqlEmail);
    $stmtEmail->execute($arrParamEmail);
    //若有該帳號，在檢查email與password是否對得上
    if($stmtEmail->rowCount()>0){
        $sql = "SELECT `a`.`aId`, `a`.`aEmail`, `a`.`aActive`
                FROM `platformAdmins` AS `a`
                WHERE `a`.`aEmail` = ?
                AND `a`.`aPassword` = ?";

        $stmt = $pdo->prepare($sql);
        $arrParam = [
            $_POST['email'],
            sha1($_POST['password'])
        ];
        $stmt->execute($arrParam);

        //成功登入，則建立session
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_unset();

            //若帳號非active，則禁止進入
            if($arr[0]['aActive']!=='active'){
                echo "帳號未啟用，請設置您的帳號，或者聯絡您網站的管理員";
                header("Refresh: 3 ; url = ../login.php");
                exit();
            }

            //成功登入，紀錄登入時間
            $sqlTime = "UPDATE `platformAdmins`
                        SET `aLoginTime` = ?
                        WHERE `aId` = ?";
            
            $stmtTime = $pdo->prepare($sqlTime);
            $arrParamTime = [ 
                date("Y-m-d H:i:s"),
                $arr[0]['aId'] 
            ];
            $stmtTime->execute($arrParamTime);
            
            //將資訊放入session
            $_SESSION['userId'] = $arr[0]['aId'];
            $_SESSION['email'] = $arr[0]['aEmail'];

            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            echo "will refresh in 5 seconds";
            // exit();


            header('Refresh: 5 ;url = ../admin.php');
        }else{
            //登入失敗
            header('Refresh: 5 ; url = ../platform_login.php');
            echo "wrong account/ password";
            session_unset();
            session_destroy();
        }
    }else{
        //沒有該帳號
        echo "沒有該使用者，請重新登入";
    }
   
}else{
    echo "請輸入帳號密碼";
}