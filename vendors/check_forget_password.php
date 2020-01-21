<?php

require_once('../db.inc.php');
require_once('../tpl/generatePwd.php');
if(!isset($_POST['email'])){
    echo "請輸入信箱";
    // header("Refresh: 3 ; url = ./forget_password.php");
    exit();
}

$email = $_POST['email'];

//是否有該使用者
$s = "SELECT `vaId`, `vId` FROM `vendorAdmins` WHERE `vaEmail` = '$email'";
$st = $pdo->query($s);
if($st->rowCount()<=0){
    echo "沒有該使用者";
    exit();
}

//總之寄信就對了

$hash = md5( rand(0,1000) );
$token = generatePwd(8);
$sql = "INSERT INTO `vendorResetPass`(`vaEmail`, `vaToken`, `vaHash`, `vaExpireDate`)
        VALUES(?,?,?,?)";
$stmt = $pdo->prepare($sql);

$arrParam = [
    $email,
    $token,
    $hash,
    date("Y-m-d H:i:s")
];

$stmt->execute($arrParam);
if($stmt->rowCount()>0){
    sendMail($email, $hash, $token);
    echo "success";
    exit();
}





//send mail

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $hash, $token){

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
        $mail->Password   = 'lvknxoyjwwlyyjnb';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
        $mail->CharSet="UTF-8"; //for Chinese
        $mail->SMTPDebug = 0; //stops sending debug info & allows header refresh
        
        //Recipients
        $mail->setFrom($email, 'oncePeace', 0);
        $mail->addAddress($email);
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '忘記密碼';
        $mail->Body    = "
            您好， <br>
            請點擊連結重新設置您的密碼： <a href='http://localhost:8080/Project/vendors/forget_password_reset.php?hash=$hash&email={$email}&action=reset' target='_blank'>http://localhost:8080/Project/vendors/forget_password_reset.php</a> <br>
            請於十分鐘內驗證完畢<br>
            驗證碼：$token<br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = " 您好，您於 onepeace 申請了  廠商帳號，請點擊連結以驗證您的帳號：http://localhost:8080/Project/vendors/register_verify.php?hash=$hash&email={$email}";

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }
}