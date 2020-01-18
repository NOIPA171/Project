<?php

//get basic info
$sqlGetInfo = "SELECT `va`.`vaFName`,`va`.`vaLName`,`va`.`vaEmail`,`va`.`vaActive`,`va`.`vaVerify`,
`vendors`.`vId`, `vendors`.`vActive`, `vendors`.`vVerify`, `vendors`.`vName`
                FROM `vendorAdmins` AS `va`
                INNER JOIN `rel_vendor_admins`
                ON `va`.`vaId` = `rel_vendor_admins`.`vaId`
                INNER JOIN `vendors`
                ON `rel_vendor_admins`.`vId` = `vendors`.`vId`
                WHERE `va`.`vaId` = ?
                AND `va`.`vaEmail`=?";

$stmtGetInfo = $pdo->prepare($sqlGetInfo);
$arrParamGetInfo = [ $_SESSION['userId'], $_SESSION['email'] ];
$stmtGetInfo->execute($arrParamGetInfo);
if($stmtGetInfo->rowCount()>0){
    $arrGetInfo = $stmtGetInfo->fetchAll(PDO::FETCH_ASSOC)[0];

    //尋找其permission
    $sqlGetPermissions = "SELECT `vaPermissionId`
                    FROM `rel_vendor_permissions`
                    WHERE `vaId` = ?";
    $stmtGetPermissions = $pdo->prepare($sqlGetPermissions);
    $arrParamGetPermissions = [ $_SESSION['userId'] ];
    $getPrmList = [];


    $stmtGetPermissions->execute($arrParamGetPermissions);

    if($stmtGetPermissions->rowCount()>0){
        //撈出所有permission，並用兩層foreach去除多餘的上一層
        $arrGetPermissions = $stmtGetPermissions->fetchAll(PDO::FETCH_ASSOC);
        foreach($arrGetPermissions as $key => $value){
            foreach($value as $k => $v){
                $getPrmList[] = $v;
            }
        }
        //把permission輸入到info裡
        $arrGetInfo['permissions'] = $getPrmList;
    }
}

// echo "<pre>";
// print_r($arrGetInfo);
// echo "</pre>";
