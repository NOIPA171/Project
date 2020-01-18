<?php
session_start();
require_once('../../db.inc.php');


if(isset($_POST['password1']) && isset($_POST['password2'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        try{
            $pdo->beginTransaction();

            //看看是否對得上這個人
            $sql = "SELECT `vaId`,`vaEmail`
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
                //確認是此人，則更新他的密碼
                $sqlUpdate = "UPDATE `vendorAdmins`
                            SET `vaPassword` =? , `vaActive` = 'active'
                            WHERE `vaEmail`=?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $arrParamUpdate = [
                    sha1($_POST['password1']),
                    $arr['vaEmail']
                ];
                $stmtUpdate->execute($arrParamUpdate);
                if($stmt->rowCount()>0){
                    $pdo->commit();

                    //建立session
                    //先destroy
                    session_unset();
                    session_destroy();

                    $arrV = $pdo->query("SELECT `vId` FROM `rel_vendor_admins` WHERE `vaId` = {$arr['vaId']}")->fetchAll(PDO::FETCH_ASSOC)[0];

                    $_SESSION['userId'] = $arr['vaId'];
                    $_SESSION['email'] = $arr['vaEmail'];
                    $_SESSION['vendor'] = $arrV['vId'];

                    //再轉頁
                    header("Refresh: 3 ; url = ../admin.php");
                    echo "Validated!";
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