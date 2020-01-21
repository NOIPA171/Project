<?php
session_start();
require_once('../db.inc.php');

if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['vendor'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        $email = $_POST['email'];
        $hash = $_POST['hash'];
        $token = $_POST['token'];
        $pwd = sha1($_POST['password1']);
        $vendorId = $_POST['vendor'];

        $pdo->beginTransaction();

        //確認驗證跟hash有在reset password的表單裡
        $sql = "SELECT `vaEmail`, `vaExpireDate`
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
                
                $delsql = "DELETE FROM `vendorResetPass` WHERE `vaToken` = ?";
                $stmtdel = $pdo->prepare($delsql);
                $delParam = [ $token ];
                $stmtdel->execute($delParam);

                if($stmtdel->rowCount()>0){
                    $pdo->commit();
                    echo "驗證碼已過期，請重新申請。";
                    exit();
                }
            }

            //確認是此人，配對password看看是否有同樣email + pwd的帳號存在

            $checksql = "SELECT `vId` FROM `vendorAdmins` WHERE `vaPassword` = ? AND `vaEmail` = ?";
            $stmtc = $pdo->prepare($checksql);
            $checkparam = [
                $pwd,
                $email
            ];
            $stmtc->execute($checkparam);
            if($stmtc->rowCount() > 0){
                $ven = $stmtc->fetchAll(PDO::FETCH_ASSOC);

                //有可能是同一個廠商的 -> 允許overwrite
                //非同一組資料則不允許執行
                for($i = 0 ; $i<count($ven) ; $i++){
                    if($ven[$i]['vId'] != $vendorId){
                        echo "您有相同的帳號存在，請重新輸入密碼";
                        exit();
                    }      
                }  
            }
            
            //刪除這個id所有重新設定密碼的資料
            $del = "DELETE FROM `vendorResetPass` WHERE `vaEmail`= ?";
            $stmtd = $pdo->prepare($del);
            $delParam = [ $email ];
            $stmtd->execute($delParam);
            if($stmtd->rowCount()>0){

                //再更改這個人的密碼
                $update = "UPDATE `vendorAdmins` SET `vaPassword` = ? WHERE `vaEmail` = ? AND `vId` = ?";
                $stmtu = $pdo->prepare($update);
                $updateParam = [
                    $pwd,
                    $email,
                    $vendorId
                ];
                
                $stmtu->execute($updateParam);
                if($stmtu->rowCount()>0){
                    $pdo->commit();
                    //需要重新登入
                    echo "success";
                    exit();
                }
            }
        }else{
            echo "請使用 email 提供的連結和驗證碼";
        }
    }else{
        echo "密碼欄位不一致，請重新輸入";
        exit();
    }
}else{
    echo "請輸入所有欄位";
    exit();
}