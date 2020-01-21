<?php
//get basic info
try{
    $pdo->beginTransaction();
    $sqlGetInfo = "SELECT `aId`, `aFName`,`aLName`,`aEmail`,`aActive`,`aVerify`, `aLoginTime`, `aLogoutTime`
                    FROM `platformAdmins` 
                    WHERE `aId` = ?
                    AND `aEmail`=?";

    $stmtGetInfo = $pdo->prepare($sqlGetInfo);
    $arrParamGetInfo = [ $_SESSION['userId'], $_SESSION['email'] ];
    $stmtGetInfo->execute($arrParamGetInfo);
    if($stmtGetInfo->rowCount()>0){
        $arrGetInfo = $stmtGetInfo->fetchAll(PDO::FETCH_ASSOC)[0];

        //尋找其permission
        $sqlGetPermissions = "SELECT `aPermissionId`
                        FROM `rel_platform_permissions`
                        WHERE `aId` = ?";
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
    echo "failure: ".$err->getMessage();
}
