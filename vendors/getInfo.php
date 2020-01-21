<?php

//get basic info
try{
    $pdo->beginTransaction();
    $sqlGetInfo = "SELECT `va`.`vaId`,`va`.`vaFName`,`va`.`vaLName`,`va`.`vaEmail`,`va`.`vaActive`,`va`.`vaVerify`, `va`.`vId`, `va`.`vaLoginTime`, `va`.`vaLogoutTime`,
`vendors`.`vId`, `vendors`.`vActive`, `vendors`.`vVerify`, `vendors`.`vName`,`vendorRoles`.`vaRoleId`, `vendorRoles`.`vaRoleName`
                FROM `vendorAdmins` AS `va`
                INNER JOIN `vendors`
                ON `va`.`vId` = `vendors`.`vId`
                INNER JOIN `vendorRoles`
                ON `va`.`vaRoleId` = `vendorRoles`.`vaRoleId`
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
            $pdo->commit();
        }
    }else{
        echo "你的帳號不存在";
        session_unset();
        session_destroy();
        header("Refresh: 3 ; url = ./index.php");
        exit();
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failure: ".$err->getMessage();
}
