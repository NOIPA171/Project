<?php
session_start();
require_once('../../db.inc.php');

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
        $sql = "SELECT `a`.`vaId`, `a`.`vaEmail`, `a`.`vaPassword`, `a`.`vaActive`, `a`.`vaVerify`, `a`.`vId`, `a`.`vaLoginTime`,     
        `vendors`.`vActive`, `vendors`.`vId`
                FROM `vendorAdmins` AS `a`
                INNER JOIN `vendors`
                ON `vendorAdmins`.`vId` = `vendors`.`vId`
                WHERE `a`.`vaEmail` = ?
                AND `a`.`vaPassword` = ?";

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

            //成功登入，紀錄登入時間
            $sqlTime = "UPDATE `vendorAdmins`
                        SET `vaLoginTime` = current_timestamp()
                        WHERE `vaId` = ?";
            
            $stmtTime = $pdo->prepare($sqlTime);
            $arrParamTime = [ $arr[0]['vaId'] ];
            $stmtTime->execute($arrParamTime);
            
            //將資訊放入session
            $_SESSION['userId'] = $arr[0]['vaId'];
            $_SESSION['email'] = $arr[0]['vaEmail'];
            $_SESSION['vendor'] = $arr[0]['vId'];

            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            echo "will refresh in 5 seconds";
            // exit();

            header('Refresh: 5 ;url = ../admin.php');
        }else{
            //登入失敗
            // header('Refresh: 5 ; url = ../login.php');
            echo "帳號/密碼錯誤，請重新登入";
            session_destroy();
        }
    }else{
        //沒有該帳號
        echo "該信箱尚未註冊，請重新登入";
    }
   
}else{
    echo "請輸入帳號密碼";
}