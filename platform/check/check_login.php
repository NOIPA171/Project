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
        $sql = "SELECT `a`.`aId`, `a`.`aEmail`, `a`.`aActive`,     
                        `rel_platform_permissions`.`aPermissionId`
                FROM `platformAdmins` AS `a`
                INNER JOIN `rel_platform_permissions`
                ON `a`.`aId` = `rel_platform_permissions`.`aId`
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

            // echo "<pre>";
            // print_r($arr);
            // echo "</pre>";
            // exit();

            session_unset();
            // session_destroy();


            //成功登入，紀錄登入時間
            $sqlTime = "UPDATE `platformAdmins`
                        SET `aLoginTime` = current_timestamp()
                        WHERE `aId` = ?";
            
            $stmtTime = $pdo->prepare($sqlTime);
            $arrParamTime = [ $arr[0]['aId'] ];
            $stmtTime->execute($arrParamTime);
            
            //將資訊放入session
            $_SESSION['userId'] = $arr[0]['aId'];
            $_SESSION['email'] = $arr[0]['aEmail'];
            $_SESSION['active'] = $arr[0]['aActive'];

            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            echo "will refresh in 5 seconds";
            // exit();


            header('Refresh: 5 ;url = ../admin.php');
        }else{
            //登入失敗
            // header('Refresh: 5 ; url = ../platform_login.php');
            echo "wrong account/ password";
            // session_unset();
        }
    }else{
        //沒有該帳號
        echo "no such user email, please check again";
    }
   
}