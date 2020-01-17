<?php
session_start();
require_once('../../db.inc.php');

//若沒有輸入欄位，exit()
if($_POST['name']==='' || $_POST['email']==='' || $_POST['password']===''){
    echo "please enter info";
    exit();
}


//------先輸入admin帳號------
$sqlAdmin = "INSERT INTO `vendorAdmins`(`vaFName`,`vaEmail`,`vaPassword`,`vaActive`,`vaLoginTime`)
            VALUES (?,?,?,'active',current_timestamp())";
$arrParamAdmin = [
    $_POST['name'],
    $_POST['email'],
    sha1($_POST['password'])
];
$stmtAdmin = $pdo->prepare($sqlAdmin);
$stmtAdmin->execute($arrParamAdmin);

if($stmtAdmin->rowCount() > 0){
    //取得剛剛輸入的ID
    $currentAdmin = $pdo->lastInsertId();
    //------再輸入廠商資訊------
    $sqlVendor = "INSERT INTO `vendors`(`vName`,`vActive`)
                    VALUES(?,'active')";
    $stmtVendor = $pdo->prepare($sqlVendor);
    $arrParamVendor = [ $_POST['name'] ];
    $stmtVendor->execute($arrParamVendor);

    if($stmtVendor->rowCount()>0){
        //取得剛剛輸入的ID
        $currentVendor = $pdo->lastInsertId();
        //------再將廠商與admin連起來，輸入 REL 資料表------
        $sqlRel = "INSERT INTO `rel_vendor_admins`(`vId`, `vaId`) VALUES(?,?)";
        $stmtRel = $pdo->prepare($sqlRel);
        $arrParamRel = [
            $currentVendor,
            $currentAdmin
        ];
        $stmtRel->execute($arrParamRel);

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

                $_SESSION['userId'] = $currentAdmin;
                $_SESSION['userName'] = $_POST['name'];
                $_SESSION['vendor'] = $_POST['name'];
                $_SESSION['vendorActive'] = 'active';
                $_SESSION['adminActive'] = 'active';
                $_SESSION['vendorVerify'] = date("Y-m-d H:i:s");
                $_SESSION['adminVerify'] = date("Y-m-d H:i:s");                

                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
                // exit();

                echo "all complete! will refresh in 5 seconds";
                header("Refresh: 5 ; url = ../admin.php");
            }
        }
    }
}


