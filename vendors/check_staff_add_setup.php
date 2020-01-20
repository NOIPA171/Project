<?php
session_start();
require_once('../db.inc.php');


if(isset($_POST['password1']) && isset($_POST['password2'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        try{
            $pdo->beginTransaction();

            //看看是否對得上這個人
            $sql = "SELECT `vaId`,`vaEmail`, `vId`
            FROM `vendorAdmins`
            WHERE `vaPassword`=?
            AND `vaHash`=?
            AND `vaEmail` = ?";
            $stmt = $pdo->prepare($sql);
            $arrParam = [
                sha1($_POST['verify']),
                $_POST['hash'],
                $_POST['email']
            ];
            $stmt->execute($arrParam);

            if($stmt->rowCount()>0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                //確認是此人，則更新他的密碼，更新狀態，以及加入上線時間
                $sqlUpdate = "UPDATE `vendorAdmins`
                            SET `vaPassword` =? , `vaActive` = 'active', `vaLoginTime`=?, `vaVerify` = 'verified'
                            WHERE `vaEmail`=?
                            AND `vaId` = ?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $arrParamUpdate = [
                    sha1($_POST['password1']),
                    date("Y-m-d H:i:s"),
                    $arr['vaEmail'],
                    $arr['vaId']
                ];
                $stmtUpdate->execute($arrParamUpdate);
                if($stmt->rowCount()>0){

                    //若有session（之前已登入某帳號），則幫前一個帳號加入登出時間，然後幫此用戶登入（加入session）
                    if(isset($_SESSION['email']) && isset($_SESSION['userId']) && isset($_SESSION['vendor'])){
                        $s = "UPDATE `vendorAdmins` 
                            SET `vaLogoutTime` = ? 
                            WHERE `vaId` = ?
                            AND `vaEmail` = ?";
                        $st = $pdo->prepare($s);
                        $ap = [
                            date("Y-m-d H:i:s"),
                            $arr['vaId'],
                            $arr['vaEmail']
                        ];
                        $st->execute($ap);
                        if($st->rowCount()>0){
                            echo "已幫前一位用戶登出";
                        }
                    }

                    //submit changes
                    $pdo->commit();

                    //以防萬一總之歸零 
                    session_unset();
                    // 加入session登入
                    $_SESSION['email'] = $arr['vaEmail'];
                    $_SESSION['userId'] = $arr['vaId'];
                    $_SESSION['vendor'] = $arr['vId'];

                    //轉頁重新登入
                    header("Refresh: 3 ; url = ./admin.php");
                    echo "Validated! 3秒後轉頁";
                }
            }else{
                //非本人
                echo "請透過 Email 提供的連結來建立您的帳號";
            }
        }catch(Exception $err){
            $pdo->rollback();
            echo "failure: ".$err->getMessage();
        }

    }else{
        echo "密碼欄位不一致";
    }
}