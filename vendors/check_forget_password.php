<?php

require_once('../db.inc.php');
require_once('../tpl/generatePwd.php');
if(!isset($_POST['email'])){
    echo "請輸入信箱";
    header("Refresh: 3 ; url = ./forget_password.php");
    exit();
}

$email = $_POST['email'];

//是否有該使用者
$s = "SELECT `vaId` FROM `vendorAdmins` WHERE `vaEmail` = '$email'";
$st = $pdo->query($s);
if($st->rowCount()<=0){
    echo "沒有該使用者";
    header("Refresh: 3 ; url = ./forget_password.php");
    exit();
}else if ($st->rowCount()>1){
    //若有多重帳號
    echo "請輸入您的使用者ID";
    header("Refresh: 3 ; url = ./forget_password_2.php?email={$_POST['email']}");
    exit();
}

//只有這一個email

//先取得他的使用者id
$id = $pdo->query("SELECT `vaId` FROM `vendorAdmins` WHERE `vaEmail` = '$email'")->fetchAll(PDO::FETCH_ASSOC)[0]['vaId'];

$hash = md5( rand(0,1000) );
$token = generatePwd(8);
$sql = "INSERT INTO `vendorResetPass`(`vaId`, `vaEmail`, `vaToken`, `vaHash`, `vaExpireDate`)
        VALUES(?,?,?,?,?)";
$stmt = $pdo->prepare($sql);

$arrParam = [
    $id,
    $email,
    $token,
    $hash,
    date("Y-m-d H:i:s")
];

$stmt->execute($arrParam);
if($stmt->rowCount()>0){
    echo "success!";
    sendMail($email, $hash, $token);
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
        $mail->Password   = 'ey3ty27e2/4';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
        $mail->CharSet="UTF-8"; //for Chinese
        $mail->SMTPDebug = 0; //stops sending debug info & allows header refresh
        
        //Recipients
        $mail->setFrom($email);
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
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}