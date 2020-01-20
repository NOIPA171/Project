<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');
$pagePrm = 'prmA00';
require_once('./checkPrm.php');

require_once('../tpl/generatePwd.php');

try{
    $pdo->beginTransaction();

    $email = $arrGetInfo['aEmail'];
    $hash = md5( rand(0,1000) );
    $pwd = generatePwd(8);

    //先確認該email沒有註冊過
    $checksql = "SELECT `aEmail`
                FROM `platformAdmins`
                WHERE `aEmail` = '{$_POST['email']}'";
    $check = $pdo->query($checksql);

    if($check->rowCount()>0){
        echo "該用戶已經有帳號，請重新輸入";
        header("Refresh: 3 ; url = ./staff_add.php");
        exit();
    }
    
    //先加入vendor admins -> permissions
    $sql = "INSERT INTO `platformAdmins`(`aFName`,`aLName`,`aEmail`, `aPassword`, `aHash`, `aActive`, `aVerify`, `aNotes`)
    VALUES(?,?,?,?,?,'inactive',?,?)";


    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['Fname'],
        $_POST['Lname'],
        $_POST['email'],
        sha1($pwd),
        $hash,
        date("Y-m-d H:i:s"),
        $_POST['notes']
    ];

    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){
        $sql2 = "INSERT INTO `rel_platform_permissions`(`aId`, `aPermissionId`)
                VALUES(?,?)";
        $stmt2 = $pdo->prepare($sql2);
        //新工作人員
        $newStaff = $pdo->lastInsertId();
    
        //若身份為owner
        if($_POST['title'] === 'owner'){
            $allPrms = $pdo->query("SELECT `adminPrmId` FROM `platformPermissions`")->fetchAll(PDO::FETCH_ASSOC);
            //每一個permission都要輸入一次
            for($i=0 ; $i<count($allPrms) ; $i++){
                $arrParam2 = [
                    $newStaff,
                    $allPrms[$i]['adminPrmId']
                ];
                $stmt2->execute($arrParam2);
            }
        }else{
            //若身份為staff
            for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
                
                $arrPrms = $pdo->query("SELECT `adminPrmId` FROM `platformPermissions` WHERE `adminPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

                $arrParam2 = [
                    $newStaff,
                    $arrPrms['adminPrmId']
                ];

                $stmt2->execute($arrParam2);

            }

        }
        if($stmt2->rowCount()>0){
            sendMail($email, $_POST['Fname'], $arrGetInfo['aName'], $hash, $pwd);
            echo "success!";
            header("Refresh: 3 ; url = ./staff.php");
            $pdo->commit();
        }else{
            echo "fail";
            $pdo->rollback();
        }
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failure: ".$err->getMessage();
}



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function sendMail($email, $recepient, $vName, $hash, $pwd){

    // Load Composer's autoloader
    require '../vendor/autoload.php';

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
        $mail->addAddress($_POST['email'], $_POST['Fname'].' '.$_POST['Lname'], 0);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '您被邀請加入'.$vName.'的網站，請前往設定您的帳號';
        $mail->Body    = "
            $recepient 您好， <br>
            $vName 邀請您一起管理商店。<br>
            請點擊連結設定您的帳號密碼： <a href='http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}'>點擊這裡</a> <br>
            您的驗證碼：$pwd <br>
            $vName <br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = "$recepient 您好，
            $vName 邀請您一起管理商店，請點擊連結設定您的帳號密碼：http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}。
            您的驗證碼：$pwd 。
            此信為自動發出，請勿回覆";

        $mail->send();
        echo 'Message has been sent';
        header("Refresh: 3 ; url = ./staff_add.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}