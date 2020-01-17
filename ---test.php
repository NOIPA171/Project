<?php
$email_address = "nightfallvs0923@gmail.com";
$subject = "Test send";
$message = " Hello there, thanks for trying out this thingy <br> we hope you enjoy your day.";
$headers = 'From: noreply@company.com\r\n';
$headers.= '=?UTF-8?B?'.base64_encode("您好，<br>感謝您註冊onePeace，請點選下列連結驗證帳號！<br>onePeace")."?=";
// if(mail($email_address , $subject, $message, $headers)){
//     echo "success!";
// }else{
//     echo "fail";
// }

if(mail('nightfallvs0923@gmail.com', 'test send', 'hi how are you', 'From: noreply@company.com')){
    echo "success";
}else{
    echo "fail";
}