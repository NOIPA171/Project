<?php

require_once('../db.inc.php');
require_once('../tpl/generatePwd.php');
if(!isset($_POST['email'])){
    echo "請輸入信箱";
    header("Refresh: 3 ; url = ./forget_password.php");
    exit();
}

$email = $_POST['email'];

$sql = "INSERT INTO `vendorResetPass`(`vaEmail`, `vaToken`, `vaExpireDate`)
        VALUES(?,?,?)";
$stmt = $pdo->prepare($sql);

$arrParam = [
    $email,

]






//send mail

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $vName, $hash){

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
        $mail->setFrom($email);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '忘記密碼';
        $mail->Body    = "
            $vName 您好， <br>
            請點擊連結重新設置您的密碼： <a href='http://localhost:8080/Project/vendors/forget_password_reset.php?hash=$hash&email={$email}&action=reset' target='_blank'>http://localhost:8080/Project/vendors/forget_password_reset.php</a> <br>
            $vName <br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = "$vName 您好，您於 onepeace 申請了 $vName 廠商帳號，請點擊連結以驗證您的帳號：http://localhost:8080/Project/vendors/register_verify.php?hash=$hash&email={$_POST['email']}";

        $mail->send();
        echo 'Message has been sent';
        header("Refresh: 3 ; url = ./staff_add.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}