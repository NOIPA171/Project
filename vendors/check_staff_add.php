<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');

require_once('../tpl/generatePwd.php');

try{
    $pdo->beginTransaction();

    $email = $_SESSION['email'];
    $hash = md5( rand(0,1000) );
    $pwd = generatePwd(8);

    //先確認該廠商沒有註冊過這個信箱
    $checksql = "SELECT `vaEmail`
                FROM `vendorAdmins`
                INNER JOIN `vendors`
                ON `vendorAdmins`.`vId` = `vendors`.`vId`
                WHERE `vendorAdmins`.`vId` = '{$arrGetInfo['vId']}'";
    $check = $pdo->query($checksql)->fetchAll(PDO::FETCH_ASSOC);
    $flag = true;
    for($i = 0 ; $i < count($check) ; $i++){
        if($check[$i]['vaEmail'] == $_POST['email']){
            $flag = false;
        }
    }
    if(!$flag){
        echo "該用戶已在您的團隊裡，請重新輸入";
        exit();
    }
    
    //先加入vendor admins -> permissions
    $sql = "INSERT INTO `vendorAdmins`(`vaFName`,`vaLName`,`vaEmail`, `vaPassword`, `vaHash`, `vaActive`, `vaVerify`, `vId`, `vaNotes`)
    VALUES(?,?,?,?,?,'inactive',?,?,?)";

    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['Fname'],
        $_POST['Lname'],
        $_POST['email'],
        sha1($pwd),
        $hash,
        date("Y-m-d H:i:s"),
        $arrGetInfo['vId'],
        $_POST['notes']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount()>0){
        $sql2 = "INSERT INTO `rel_vendor_permissions`(`vaId`, `vaPermissionId`)
                VALUES(?,?)";
        $stmt2 = $pdo->prepare($sql2);
        //新工作人員
        $newStaff = $pdo->lastInsertId();
           
        //若身份為owner
        if($_POST['title'] === 'owner'){
            $allPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions`")->fetchAll(PDO::FETCH_ASSOC);
            //每一個permission都要輸入一次
            for($i=0 ; $i<count($allPrms) ; $i++){
                $arrParam2 = [
                    $newStaff,
                    $allPrms[$i]['vendorPrmId']
                ];
                $stmt2->execute($arrParam2);
            }
        }else{
            //若身份為staff
            for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
                
                $arrPrms = $pdo->query("SELECT `vendorPrmId` FROM `vendorPermissions` WHERE `vendorPrmName` = '{$_POST['staffPrm'][$i]}'")->fetchAll(PDO::FETCH_ASSOC)[0];

                $arrParam2 = [
                    $newStaff,
                    $arrPrms['vendorPrmId']
                ];
                $stmt2->execute($arrParam2);
            }
        }
        if($stmt2->rowCount()>0){
            sendMail($email, $_POST['Fname'], $arrGetInfo['vName'], $hash, $pwd);
            $pdo->commit();
            echo "success";
            exit();
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
        $mail->Password   = 'lvknxoyjwwlyyjnb';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
        $mail->CharSet="UTF-8"; //for Chinese
        $mail->SMTPDebug = 0; //stops sending debug info & allows header refresh
        
        //Recipients
        $mail->setFrom($email, $vName, 0);
        $mail->addAddress($_POST['email'], $_POST['Fname'].' '.$_POST['Lname'], 0);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '邀請您加入'.$vName.'的網站';
        $mail->Body    = "
            $recepient 您好， <br>
            $vName 邀請您一起管理商店。<br>
            請點擊連結設定您的帳號密碼： <a href='http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}'>http://localhost:8080/Project/vendors/staff_add_setup.php</a> <br>
            您的驗證碼：$pwd <br>
            $vName <br>
            此信為自動發出，請勿回覆";
        $mail->AltBody = "$recepient 您好，
            $vName 邀請您一起管理商店，請點擊連結設定您的帳號密碼：http://localhost:8080/Project/vendors/staff_add_setup.php?hash=$hash&email={$_POST['email']}。
            您的驗證碼：$pwd 。
            此信為自動發出，請勿回覆";

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }
}