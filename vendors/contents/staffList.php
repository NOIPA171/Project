<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table">

<table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
    <thead>
        <tr>
            <th>名稱</th>
            <th>Email</th>
            <th>身份</th>
            <th data-hide="phone,tablet">帳號狀態</th>
            <th data-hide="phone,tablet">擁有權限</th>
            <th data-hide="phone,tablet">備註</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // get admin count for vendor
        $sql = "SELECT `vendorAdmins`.`vaId`, `vaFName`, `vaLName`, `vaEmail`, `vaActive`, `vaVerify`, `vaNotes`,
        `vId`
                FROM `vendorAdmins`
                INNER JOIN `rel_vendor_admins`
                ON `vendorAdmins`.`vaId` = `rel_vendor_admins`.`vaId`
                WHERE `vId` = ?";

        $stmt = $pdo->prepare($sql);
        $arrParam = [ $arrGetInfo['vId'] ];
        $stmt->execute($arrParam);
        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //取得個別人的資訊
            $sqlPermissions = "SELECT `vendorPermissions`.`vendorPrmName`
                                FROM `rel_vendor_permissions`
                                INNER JOIN `vendorPermissions`
                                ON `rel_vendor_permissions`.`vaPermissionId` = `vendorPermissions`.`vendorPrmId`
                                WHERE `vaId` = ?";
            $stmtPermissions = $pdo->prepare($sqlPermissions);
            //每一個人執行一次尋找其permission
            for($i = 0 ; $i<count($arr); $i++){
                //先初始化permissions
                $prmList = [];
                $arrParamPermissions = [ $arr[$i]['vaId'] ];
                $stmtPermissions->execute($arrParamPermissions);
                
                if($stmtPermissions->rowCount()>0){
                    //撈出所有permission，並用兩層foreach去除多餘的上一層
                    $arrPermissions = $stmtPermissions->fetchAll(PDO::FETCH_ASSOC);
                    foreach($arrPermissions as $key => $value){
                        foreach($value as $k => $v){
                            $prmList[] = $v;
                        }
                    }
                    //把permission輸入到admin裡
                    $arr[$i]['permissions'] = $prmList;
                    if(in_array('admin', $prmList)){
                        $identity = "Owner";
                    }else{
                        $identity = "Staff";
                    }
                }
            }
            for($i = 0 ; $i<count($arr); $i++){
                ?>
                <tr class="gradeX">
                    <td><?php echo $arr[$i]['vaFName'].' '.$arr[$i]['vaLName'] ?></td>
                    <td><?php echo $arr[$i]['vaEmail'] ?></td>
                    <td><?php echo $identity ?></td>
                    <td class="center"><?php echo $arr[$i]['vaActive'] ?></td>
                    <td class="center"><?php echo implode(', ', $arr[$i]['permissions']) ?></td>
                    <td class="center"><?php echo $arr[$i]['vaNotes'] ?></td>
                </tr>
                <?php
            }
        }

    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                <ul class="pagination float-right"></ul>
            </td>
        </tr>
    </tfoot>
</table>
