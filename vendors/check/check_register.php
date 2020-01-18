<?php
session_start();
require_once('../../db.inc.php');

//若沒有輸入欄位，exit()
if($_POST['name']==='' || $_POST['email']==='' || $_POST['password']===''){
    echo "please enter info";
    exit();
}


try{
    $pdo->beginTransaction();

    $hash = md5( rand(0,1000) );
    $email = $_POST['email'];
    // $email = 'radu000rider@gmail.com';


    //------先輸入admin帳號------
    $sqlAdmin = "INSERT INTO `vendorAdmins`(`vaFName`,`vaEmail`,`vaPassword`,`vaActive`,`vaLoginTime`, `vaHash`)
                VALUES (?,?,?,'active',current_timestamp(), ?)";
    $arrParamAdmin = [
        $_POST['name'],
        $_POST['email'],
        sha1($_POST['password']),
        $hash
    ];
    $stmtAdmin = $pdo->prepare($sqlAdmin);
    $stmtAdmin->execute($arrParamAdmin);

    if($stmtAdmin->rowCount() > 0){
        //取得剛剛輸入的ID
        $currentAdmin = $pdo->lastInsertId();
        //------再輸入廠商資訊------
        $sqlVendor = "INSERT INTO `vendors`(`vName`,`vActive`, `vVerify`)
                        VALUES(?,'active', ?)";
        $stmtVendor = $pdo->prepare($sqlVendor);
        $arrParamVendor = [ $_POST['name'], date('Y-m-d H:i:s')];
        $stmtVendor->execute($arrParamVendor);

        if($stmtVendor->rowCount()>0){
            //取得剛剛輸入的ID
            $currentVendor = $pdo->lastInsertId();
            //------再將廠商輸入admin資料中------
            $sqlRel = "UPDATE `vendorAdmins` SET`vId` = $currentVendor";
            $stmtRel = $pdo->query($sqlRel);

            if($stmtRel->rowCount()>0){
                //------再將所有的 Permissions 賦予該 Admin (Owner)------
                $sqlPermission = "INSERT INTO `rel_vendor_permissions`(`vaId`, `vaPermissionId`)
                                    VALUES (?,?)";
                $stmtPermission = $pdo->prepare($sqlPermission);
                $allPermissions = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions`")->fetchAll(PDO::FETCH_ASSOC);
                
                //每一個permission都要輸入一次
                for($i=0 ; $i<count($allPermissions) ; $i++){
                    $arrParamAllPrm = [
                        $currentAdmin,
                        $allPermissions[$i]['vendorPrmId']
                    ];
                    $stmtPermission->execute($arrParamAllPrm);
                }

                if($stmtPermission->rowCount()>0){
                    //加入 session
                    $pdo->commit();

                    $_SESSION['userId'] = $currentAdmin;
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['vendor'] = $currentVendor;            

                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";
                    // exit();

                    sendMail($email, $_POST['name'], $hash);
                    echo "all complete! will refresh in 5 seconds";
                    header("Refresh: 5 ; url = ../admin.php");
                }
            }
        }
    }


}catch(Exception $err){
    $pdo->rollback();
    echo "failed: ".$err->getMessage();
}


//send mail

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $vName, $hash){

    // Load Composer's autoloader
    require '../../vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'radu000rider@gmail.com';                     // SMTP username
        $mail->Password   = 'ey3ty27e2/4';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
        $mail->CharSet="UTF-8"; //for Chinese
        $mail->SMTPDebug = 0; //stops sending debug info & allows header refresh
        
        //Recipients
        $mail->setFrom($email, $vName, 0);
        $mail->addAddress($_POST['email'], $_POST['name'], 0);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '您被邀請加入'.$vName.'的網站，請前往設定您的帳號';
        $mail->Body    = "
            $vName 您好， <br>
            您於 onepeace 申請了 $vName 廠商帳號 <br>
            請點擊連結設以驗證您的帳號： <a href='http://localhost:8080/Project/vendors/register_verify.php?hash=$hash&email={$_POST['email']}'>點擊這裡</a> <br>
            $vName <br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = "$vName 您好，您於 onepeace 申請了 $vName 廠商帳號，請點擊連結以驗證您的帳號：http://localhost:8080/Project/vendors/register_verify.php?hash=$hash&email={$_POST['email']}";

        $mail->send();
        echo 'Message has been sent';
        header("Refresh: 3 ; url = ../staff_add.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
