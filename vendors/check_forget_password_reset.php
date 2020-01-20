<?php
session_start();
require_once('../db.inc.php');

if(isset($_POST['password1']) && isset($_POST['password2'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        $email = $_POST['email'];
        $hash = $_POST['hash'];
        $token = $_POST['token'];
        $pwd = sha1($_POST['password1']);

        $pdo->beginTransaction();

        //確認驗證跟hash有在reset password的表單裡
        $sql = "SELECT `vaId`, `vaEmail`, `vaExpireDate`
        FROM `vendorResetPass`
        WHERE `vaEmail` = '$email'
        AND `vaHash` = '$hash'
        AND `vaToken` = '$token'";

        $stmt = $pdo->query($sql);

        //確認
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //確認驗證是否已經expired
            $expire = new DateTime($arr[0]['vaExpireDate']);
            $isExpired = $expire->diff(new DateTime());

            if($isExpired->i>=10){
                
                $delsql = "DELETE FROM `vendorResetPass` WHERE `vaId`= ? AND `vaToken` = ?";
                $stmtdel = $pdo->prepare($delsql);
                $delParam = [
                    $arr[0]['vaId'],
                    $token
                ];
                $stmtdel->execute($delParam);
                if($stmtdel->rowCount()>0){
                    $pdo->commit();
                    echo "驗證碼已過期，請重新申請。";
                    header("Refresh: 3 ; url = ./login.php");
                    exit();
                }
            }

            //刪除這個id所有重新設定密碼的資料
            $del = "DELETE FROM `vendorResetPass` WHERE `vaId`= ?";
            $stmtd = $pdo->prepare($del);
            $delParam = [ $arr[0]['vaId'] ];
            $stmtd->execute($delParam);
            if($stmtd->rowCount()>0){
                echo "yes";
                //再更改這個人的密碼
                $update = "UPDATE `vendorAdmins` SET `vaPassword` = ? WHERE `vaId` = ?";
                $stmtu = $pdo->prepare($update);
                $updateParam = [
                    $pwd,
                    $arr[0]['vaId']
                ];
                $stmtu->execute($updateParam);
                if($stmtu->rowCount()>0){
                    $pdo->commit();
                    echo "成功更改密碼，請重新登入";
                    header("Refresh: 3 ; url = ./login.php");
                    exit();
                }
            }
        }else{
            echo "發生錯誤，請從信件重新點擊連結";
            header("Refresh: 3 ; url = ./login.php");
        }
    }
}