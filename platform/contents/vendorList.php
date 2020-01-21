

<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table">

<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter id="edit-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>廠商</th>
            <th>Email</th>
            <th>Logo</th>
            <th>狀態</th>
            <th data-sortable="false"></th>
            <th data-hide="all">廠商資訊</th>
            <th data-hide="all">人員</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // get admin count for vendor
        $sql = "SELECT `vId`, `vName`, `vEmail`, `vActive`, `vInfo`, `vImg`
                FROM `vendors`";

        $stmt = $pdo->query($sql);

        if($stmt->rowCount()>0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // echo "<pre>";
            // print_r($arr);
            // echo "</pre>";
            for($i = 0 ; $i<count($arr); $i++){
                ?>
                <tr>
                    <td><?php echo $arr[$i]['vId'] ?></td>
                    <td><?php echo $arr[$i]['vName'] ?></td>
                    <td><?php echo $arr[$i]['vEmail'] ?></td>
                    <td>
                        <?php
                            if($arr[$i]['vImg']!==null){
                                echo "<img src='../vendors/images/".$arr[$i]['vImg']."' class='vlistLogo'>";
                            }else{
                                echo "";
                            }
                        ?>
                    </td>
                    <td><?php echo $arr[$i]['vActive'] ?></td>
                    <td>
                        <div class="float-right mr-2 mr-md-0"  style="font-size: 1.2rem">
                            <?php
                                if($arr[$i]['vActive']=='active'){
                                    echo "<a data-func='ban' href='./check_vendors_ban.php?vId={$arr[$i]['vId']}&action=ban' class='text-muted'>";
                                    echo '<i class="fa fa-ban"></i>';
                                    echo "</a>";
                                }else{
                                    echo "<a data-func='activate' href='./check_vendors_ban.php?vId={$arr[$i]['vId']}&action=activate' class='text-muted'>";
                                    echo '<i class="fa fa-check-circle"></i>';
                                    echo "</a>";
                                }
                            ?>
                        </div>
                    </td>
                    <td><?php echo $arr[$i]['vInfo'] ?></td>
                    <td>
                        <table class="innerTable table table-stripped" data-page-size="8" style="background-color:transparent;">
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th>Email</th>
                                    <th>狀態</th>
                                    <th data-hide="all">備註</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //取得每個廠商的工  作人員
                                    $sqladmins = "SELECT `vaFName`, `vaLName`, `vaEmail`, `vaActive`, `vaNotes`, `vaRoleId`
                                                FROM `vendorAdmins`
                                                WHERE `vId` = ?";
                                    $stmtadmins = $pdo->prepare($sqladmins);

                                    $arradmins = [ $arr[$i]['vId'] ];
                                    $stmtadmins->execute($arradmins);

                                    if($stmtadmins->rowCount()>0){
                                    $arradmins = $stmtadmins->fetchAll(PDO::FETCH_ASSOC);
                                    
                                        for($j = 0 ; $j < count($arradmins) ; $j++){
                                            if($arradmins[$j]['vaRoleId'] == 1){
                                                continue;
                                            }else{
                                            ?>
                                            <tr>
                                                <td><?php echo $arradmins[$j]['vaLName'].' '.$arradmins[$j]['vaFName'] ?></td>
                                                <td><?php echo $arradmins[$j]['vaEmail'] ?></td>
                                                <td><?php echo $arradmins[$j]['vaActive'] ?></td>
                                                <td><?php echo $arradmins[$j]['vaNotes'] ?></td>
                                            </tr>
                                            <?php
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php
            }
        }

    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <ul class="pagination float-right"></ul>
            </td>
        </tr>
    </tfoot>
</table>