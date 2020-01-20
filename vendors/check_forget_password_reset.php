<?php
session_start();
require_once('../db.inc.php');

if(isset($_POST['password1']) && isset($_POST['password2'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        $email = $_POST['email'];
        $hash = $_POST['hash'];
        $token = $_POST['token'];
        $pwd = $_POST['password1'];

        //確認驗證跟hash有在reset password的表單裡
        $sql = "SELECT `vaId`, `vaEmail` 
        FROM `vendorResetPass`
        WHERE `vaEmail` = '$email'
        AND `vaHash` = '$hash'
        AND `vaToken` = '$token'";

        $stmt = $pdo->query($sql);

        //確認
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //刪除這個id所有重新設定密碼的資料
            $delete = $pdo->query("DELETE FROM `vendorResetPass` WHERE `vaId`= '$arr[0]['vaId']'");
            if($delete->rowCount()>0){
                //再更改這個人的密碼
                $update = "UPDATE `vendorAdmins` SET `vaPassword` = ? WHERE `vaId` = ?";
                $stmtu = $pdo->prepare($update);
                $updateParam = [
                    $pwd,
                    $arr[0]['vaId']
                ];
                $stmtu->execute($updateParam);
                if($stmtu->rowCount()>0){
                    echo "成功更改密碼，請重新登入";
                    exit();
                }
            }
        }else{
            echo "發生錯誤，請從信件重新點擊連結";
            header("Refresh: 3 ; url = ./login.php");
        }
    }
}