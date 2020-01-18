<?php
require_once('./checkSession.php');
require_once('../../db.inc.php');
require_once('./getInfo.php');

echo "<pre>";
print_r($_SESSION);
print_r($arrGetInfo);
print_r($_POST);
echo "</pre>";
// exit();


//先加入vendor admins -> vendor -> permissions
$sql = "INSERT INTO `vendorAdmins`(`vaFName`,`vaLName`,`vaEmail`, `vaPassword`)
        VALUES(?,?,?,?)";

$stmt = $pdo->prepare($sql);
$arrParam = [
    $_POST['Fname'],
    $_POST['Lname'],
    $_POST['email'].
    
];

$stmt->execute($arrParam);
if($stmt->rowCount()>0){
    echo "yes";

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
            for($i = 0 ; $i < count($_POST['staffPrm']) ; $i++){
                $arrParam3 = [
                    $newStaff,
                    $_POST['staffPrm'][$i]
                ];
                $stmt3->execute($arrParam3);
            }
        }
        if($stmt3->rowCount()>0){
            echo "success!";
            // include_once('./staff_add_sendMail');
        }else{
            echo "fail";
        }
    }

}