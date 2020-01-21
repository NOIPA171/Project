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
        $sql = "SELECT `aEmail`, `aExpireDate`
        FROM `platformResetPass`
        WHERE `aEmail` = '$email'
        AND `aHash` = '$hash'
        AND `aToken` = '$token'";

        $stmt = $pdo->query($sql);

        //確認
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //確認驗證是否已經expired
            $expire = new DateTime($arr[0]['aExpireDate']);
            $isExpired = $expire->diff(new DateTime());

            if($isExpired->i>=10){
                
                $delsql = "DELETE FROM `platformResetPass` WHERE `aToken` = ?";
                $stmtdel = $pdo->prepare($delsql);
                $delParam = [ $token ];
                $stmtdel->execute($delParam);

                if($stmtdel->rowCount()>0){
                    $pdo->commit();
                    echo "驗證碼已過期，請重新申請。";
                    // header("Refresh: 3 ; url = ./login.php");
                    exit();
                }
            }

            //刪除這個id所有重新設定密碼的資料
            $del = "DELETE FROM `platformResetPass` WHERE `aEmail`= ?";
            $stmtd = $pdo->prepare($del);
            $delParam = [ $email ];
            $stmtd->execute($delParam);
            if($stmtd->rowCount()>0){

                //再更改這個人的密碼
                $update = "UPDATE `platformAdmins` SET `aPassword` = ? WHERE `aEmail` = ?";
                $stmtu = $pdo->prepare($update);
                $updateParam = [
                    $pwd,
                    $email
                ];

                $stmtu->execute($updateParam);
                $pdo->commit();
                //需要重新登入
                echo "success";
                exit();
            }
        }else{
            echo "發生錯誤，請使用 email 提供的連結和驗證碼";
        }
    }else{
        echo "密碼欄位不一致，請重新輸入";
        exit();
    }
}else{
    echo "請輸入密碼";
    exit();
}
