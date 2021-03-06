<?php
require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('./getInfo.php');
require_once('./checkActive.php');
require_once('./checkVerify.php');
$pagePrm = 'prmV00';
require_once('./checkPrm.php');

$pdo->beginTransaction();

if(isset($_POST) && $_POST!==[]){
    foreach($_POST as $key=>$value){
        $input = $key;
    }
}else{
    exit();
}

$selectArr = [
    "`va`.`vaId`", 
    "`va`.`vaFName`",
    "`va`.`vaLName`",
    "`va`.`vaEmail`",
    "`va`.`vaActive`",
    "`va`.`vaNotes`",
    "`vendors`.`vId`",
    "`vendors`.`vName`",
    "`vendorPermissions`.`vendorPrmName`",
    "`vendorRoles`.`vaRoleName`"
];

$selectStr = implode(",", $selectArr);

$selectWhere = "";

foreach($selectArr as $key){
    $selectWhere .= $key." LIKE "."'".$input."%'"." OR";
}
$selectWhere = substr($selectWhere, 0, -2);

$sql = "SELECT $selectStr
FROM `vendorAdmins` AS `va`
INNER JOIN `vendors`
ON `vendors`.`vId` = `va`.`vId`
INNER JOIN `rel_vendor_permissions`
ON `rel_vendor_permissions`.`vaId` = `va`.`vaId`
INNER JOIN `vendorPermissions`
ON `rel_vendor_permissions`.`vaPermissionId` = `vendorPermissions`.`vendorPrmId`
INNER JOIN `vendorRoles`
ON `va`.`vaRoleId` = `vendorRoles`.`vaRoleId`
WHERE `vendors`.`vId` = '{$arrGetInfo['vId']}'
AND NOT (`vaRoleName`= 'Owner')
AND ($selectWhere)";

$stmt = $pdo->query($sql);
if($stmt->rowCount()>0){
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo->commit();

    $getResults = [];
    for($i = 0 ; $i < count($results) ; $i++){
        $getResults[] = $results[$i]['vaId'];
    }
    $getResults = array_values(array_unique($getResults));
    echo json_encode($getResults);
}else{
    exit();
}