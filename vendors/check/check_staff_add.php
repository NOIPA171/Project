<?php
require_once('./checkSession.php');
require_once('../../db.inc.php');
require_once('./getInfo.php');
require_once('../../tpl/generatePwd.php');
// echo "<pre>";
// print_r($_SESSION);
// print_r($arrGetInfo);
// print_r($_POST);
// echo "</pre>";
// exit();


try{
    $pdo->beginTransaction();

    // $mail = $_SESSION['email'];
    $email = 'radu000rider@gmail.com';
    $hash = md5( rand(0,1000) );
    $pwd = generatePwd(8);

    //先加入vendor admins -> vendor -> permissions
    $sql = "INSERT INTO `vendorAdmins`(`vaFName`,`vaLName`,`vaEmail`, `vaPassword`, `vaHash`, `vaActive`)
    VALUES(?,?,?,?,?,'inactive')";


    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['Fname'],
        $_POST['Lname'],
        $_POST['email'],
        sha1($pwd),
        $hash,
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){

        //vendor
        $newStaff = $pdo->lastInsertId();
        $sql2 = "INSERT INTO `rel_vendor_admins`(`vId`,`vaId`)
                VALUES(?,?)";
        $stmt2 = $pdo->prepare($sql2);
        $arrParam2 = [ $arrGetInfo['vId'], $newStaff ];

        $stmt2->execute($arrParam2);

        if($stmt2->rowCount()>0){
            $sql3 = "INSERT INTO `rel_vendor_permissions`(`vaId`, `vaPermissionId`)
            VALUES(?,?)";
            $stmt3 = $pdo->prepare($sql3);

            
            //若身份為owner
            if($_POST['title'] === 'owner'){
                $allPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions`")->fetchAll(PDO::FETCH_ASSOC);
                //每一個permission都要輸入一次
                for($i=0 ; $i<count($allPrms) ; $i++){
                    $arrParam3 = [
                        $newStaff,
                        $allPrms[$i]['vendorPrmId']
                    ];
                    $stmt3->execute($arrParam3);
                }
            }else{
                //若身份為staff
                for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
                    
                    $arrPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions` WHERE `vendorPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

                    $arrParam3 = [
                        $newStaff,
                        $arrPrms['vendorPrmId']
                    ];

                    $stmt3->execute($arrParam3);

                }

            }
            if($stmt3->rowCount()>0){
                sendMail($email, $arrGetInfo['vaFName'], $arrGetInfo['vName'], $hash, $pwd);
                echo "success!";
                $pdo->commit();
            }else{
                echo "fail";
            }
        }
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failure: ".$err->getMessage();
}



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function sendMail($email, $vaName, $vName, $hash, $pwd){

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
        $mail->addAddress($_POST['email'], $_POST['Fname'].' '.$_POST['Lname'], 0);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '您被邀請加入'.$vName.'的網站，請前往設定您的帳號';
        $mail->Body    = "
            {$_POST['Fname']}您好， <br>
            $vName 邀請您一起管理他們的商店。<br>
            請點擊連結設定您的帳號密碼： <a href='http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}'>點擊這裡</a> <br>
            您的驗證碼：$pwd <br>
            $vName <br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = "$vaName 您好，$vName 邀請您一起管理他們的商店，請點擊連結設定您的帳號密碼：http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}";

        $mail->send();
        echo 'Message has been sent';
        header("Refresh: 3 ; url = ../staff_add.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}