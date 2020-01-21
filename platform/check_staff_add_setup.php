<?php
session_start();
require_once('../db.inc.php');


if(isset($_POST['password1']) && isset($_POST['password2'])){
    //先看兩欄密碼是否正確
    if($_POST['password1'] === $_POST['password2']){

        try{
            $pdo->beginTransaction();

            //看看是否對得上這個人
            $sql = "SELECT `aId`,`aEmail`
            FROM `platformAdmins`
            WHERE `aPassword`=?
            AND `aHash`=?
            AND `aEmail` = ?";
            $stmt = $pdo->prepare($sql);
            $arrParam = [
                sha1($_POST['verify']),
                $_POST['hash'],
                $_POST['email']
            ];
            $stmt->execute($arrParam);

            if($stmt->rowCount()>0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

                //確認是此人，配對password看看是否有同樣email + pwd的帳號存在

                $checksql = "SELECT `aId` FROM `platformAdmins` WHERE `aPassword` = ? AND `aEmail` = ?";
                $stmtc = $pdo->prepare($checksql);
                $checkparam = [
                    sha1($_POST['password1']),
                    $_POST['email']
                ];
                $stmtc->execute($checkparam);
                if($stmtc->rowCount() > 0){
                    echo "您有相同的帳號存在，請重新輸入密碼";
                    exit();
                }

                //確認是此人，則更新他的密碼，更新狀態，以及加入上線時間
                $sqlUpdate = "UPDATE `platformAdmins`
                            SET `aPassword` =? , `aActive` = 'active', `aLoginTime`=?, `aVerify` = 'verified'
                            WHERE `aEmail`=?
                            AND `aId` = ?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $arrParamUpdate = [
                    sha1($_POST['password1']),
                    date("Y-m-d H:i:s"),
                    $arr['aEmail'],
                    $arr['aId']
                ];
                $stmtUpdate->execute($arrParamUpdate);
                if($stmt->rowCount()>0){

                    //若有session（之前已登入某帳號），則幫前一個帳號加入登出時間，然後幫此用戶登入（加入session）
                    if(isset($_SESSION['email']) && isset($_SESSION['userId'])){
                        //看之前是登入哪一個帳號
                        if(!isset($_SESSION['vendor'])){
                            $s = "UPDATE `vendorAdmins` 
                                SET `vaLogoutTime` = ? 
                                WHERE `vaId` = ?
                                AND `vaEmail` = ?";
                            $st = $pdo->prepare($s);
                            $ap = [
                                date("Y-m-d H:i:s"),
                                $_SESSION['userId'],
                                $_SESSION['email']
                            ];
                            $st->execute($ap);
                        }else{
                            $s = "UPDATE `platformAdmins` 
                            SET `aLogoutTime` = ? 
                            WHERE `aId` = ?
                            AND `aEmail` = ?";
                            $st = $pdo->prepare($s);
                            $ap = [
                                date("Y-m-d H:i:s"),
                                $_SESSION['userId'],
                                $_SESSION['email']
                            ];
                            $st->execute($ap);
                        }
                    }

                    //submit changes
                    $pdo->commit();

                    //以防萬一總之歸零 
                    session_unset();
                    // 加入session登入
                    $_SESSION['email'] = $arr['aEmail'];
                    $_SESSION['userId'] = $arr['aId'];

                    //轉頁重新登入
                    echo "success";
                    exit();
                }
            }else{
                //非本人
                echo "請透過 Email 提供的連結和驗證碼來建立您的帳號";
            }
        }catch(Exception $err){
            $pdo->rollback();
            echo "failure: ".$err->getMessage();
        }

    }else{
        echo "密碼欄位不一致";
    }
}