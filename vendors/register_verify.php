<?php
//是否有hash 跟 email
if(isset($_GET['hash']) && isset($_GET['email'])){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
}else{
    echo "invalid access";
    exit();
}


try{
    $pdo->beginTransaction();
    $sql = "SELECT `vaId`, `vId`
    FROM `vendorAdmins`
    WHERE `vaHash` = ?
    AND `vaEmail` =?";
    $arrParam = [
    $_GET['hash'],
    $_GET['email']
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    //配對成功
    if($stmt->rowCount()>0){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Admin 跟 Vendors 都改成verified
        $sql2 = "UPDATE `vendorAdmins` 
        SET `vaVerify` = 'verified' 
        WHERE `vaId` = {$arr[0]['vaId']} 
        AND `vaEmail`={$_GET['email']}";
        $arr2 = $pdo->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        $sql3 = "UPDATE `vendors`
        SET `vVerify` = 'verified'
        WHERE `vEmail` = {$_GET['email']}
        AND `vId` = {$arr[0]['vId']}";
        $arr3 = $pdo->query($sql3)->fetchAll(PDO::FETCH_ASSOC);
        
        $pdo->commit();
    }
}catch(Exception $err){
    $pdo->rollback();
    echo "failure: ".$err->getMessage();
}
//取得該用戶id
